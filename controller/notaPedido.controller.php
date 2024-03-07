<?php
date_default_timezone_set('America/Bogota');
class NotaPedidoController
{
  // Obtener todos los registros de  Nota de pedido
  public static function ctrGetAllSalidasNotaPe()
  {
    $table = "tb_notapedido";
    $ListNotaPedido = NotaPedidoModel::mdlGetAllSalidasNotaPe($table);
    return $ListNotaPedido;
  }

  // Crear NotaPedido con datos JSON
  public static function ctrCreateNotaPedido()
  {
    if (isset($_POST["formDataJson"])) {
      // Decodifica la cadena JSON en un array asociativo
      $data = json_decode($_POST["formDataJson"], true);

      //  Verificamos si todos los datos se han llenado correctamente, es decir si tiene una lista de productos que no sea vacía
      if ($data["listProducts"] == "" || $data["listProducts"] == null) {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al crear la nota de pedido, no tiene productos añadidos', 'notaPedido');
        echo $message;
      } else {
        // Prepara los datos para la inserción en la base de datos
        $table = "tb_notapedido";
        $dataCreate = array(
          "IdCliente" => $data["notRuc"],
          "IdRes" => $data["notVend"],
          "FechaNotaPedido" => $data["notFechPe"],
          "IdPer" => $data["notRes"],
          "EstadoNota" => "1",
          "DatosProductosNotaPedidoJson" => json_encode($data["listProducts"]),
          "Total" => $data["notTotal"],
          "DateCreate" => date("Y-m-d\TH:i:sP"),
          "DateUpdate" => date("Y-m-d\TH:i:sP")
        );

        // Llama al modelo para insertar los datos
        $createNotaPedido = NotaPedidoModel::mdlCreateNotaPedido($table, $dataCreate);

        // Comprueba si la inserción fue exitosa
        if ($createNotaPedido == "ok") {

          // Para cada producto en listProducts, realiza las siguientes operaciones:
          $listProducts = is_string($data["listProducts"]) ? json_decode($data["listProducts"], true) : $data["listProducts"];

          // Para cada producto en listProducts, realiza las siguientes operaciones:
          foreach ($listProducts as $product) {
            // Comprueba el stock del producto
            $stock = AlmacenController::ctrComprobarStockRes($product["codProduct"]);

            // Si el producto existe en el almacén, resta la cantidad del producto del stock existente
            if (!empty($stock["IdAlma"])) {
              $newStock = $stock["CantidadTotal"] - $product["countProduct"];

              // Prepara los datos para la actualización en la base de datos
              $dataUpdate = array(
                "CantidadTotal" => $newStock,
                "DateUpdate" => date("Y-m-d"),
                "HoraUpdate" => date("H:i:s"),
                "IdAlma" => $stock["IdAlma"]
              );

              // Actualiza el stock del producto en la base de datos
              AlmacenController::ctrUpdateStockAlmacenRes($dataUpdate);
            } else {
              //  Se puede crear negativos, en el caso que se cree notas de pedido con productos que no tienen ingreso, se creará el registro como si fuese un ingreso pero negativo.
              $dataCreateStock = array(
                "IdProd" => $product["codProduct"],
                "CantidadTotal" => intval($product["countProduct"])*(-1),
                "DateCreate" => date("Y-m-d"),
                "HoraCreate" => date("H:i:s"),
                "DateUpdate" => date("Y-m-d"),
                "HoraUpdate" => date("H:i:s")
              );
              $updateStock = AlmacenController::ctrCreateStockAlmacen($dataCreateStock);
            }
          }

          $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Nota de pedido creada correctamente', 'index.php?ruta=notaPedido');
          echo $message;
        } else {
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al crear la nota de pedido', 'index.php?ruta=notaPedido');
          echo $message;
        }
      }
    }
  }



  //obtener el  Cliente en nota pedido
  public static function ctrGetNotaPeCli()
  {
    $table = "tb_cliente";
    $listClientes = NotaPedidoModel::mdlGetNotaPeCli($table);
    return $listClientes;
  }

  // obtener datos de los productos para agregarlos a la lista
  public static function ctrGetListProducts()
  {
    $table = "tb_almacen";
    $productData = NotaPedidoModel::mdlGetProductData($table);
    return $productData;
  }


  //  Devolver productos para agregarlos a nota pedido  ajx
  public static function ctrGetProductDataAjx($codProductAdd)
  {
    $table = "tb_almacen";
    $data = NotaPedidoModel::mdlGetProductDataAjx($table, $codProductAdd);
    return $data;
  }

  /* mostrar detalles complentarios de nota de pedido por el boton */
  public static function ctrGetDetallNotPeData($codDetNotPeData)
  {
    $table = "tb_notapedido";
    $response = NotaPedidoModel::mdlGetDetallNotPeData($table, $codDetNotPeData);
    return $response;
  }

  /* fin */

  // Eliminar nota pedido
  public static function ctrDeleteNotaPedido()
  {
    if (isset($_GET["codNotaPe"])) {
      $table = "tb_notapedido";
      $codNotaPe = $_GET["codNotaPe"];
      //  Verificamos que es una nota de pedido que está en estado 1, ya que solo pueden elimarse esas
      $estadoNota = self::ctrGetEstadoNotaPedido($codNotaPe);
      if ($estadoNota["EstadoNota"] != 1) {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Eliminar la Nota Pedido, solo se pueden eliminar las notas de pedido en estado "Retirado"', 'verSalidas');
        echo $message;
      } else {
        //  Obtenemos la lista de productos de la nota de pedido
        $productos = self::ctrGetListaProductos($codNotaPe);
        $productos = json_decode($productos["DatosProductosNotaPedidoJson"], true);
        //  Actualizamos el stock de los productos
        foreach ($productos as $product) {
          $stock = AlmacenController::ctrComprobarStockRes($product["codProduct"]);
          $nuevoStock = $stock["CantidadTotal"] + $product["countProduct"];
          $dataUpdate = array(
            "CantidadTotal" => $nuevoStock,
            "DateUpdate" => date("Y-m-d"),
            "HoraUpdate" => date("H:i:s"),
            "IdAlma" => $stock["IdAlma"]
          );
          AlmacenController::ctrUpdateStockAlmacenRes($dataUpdate);
        }
        $response = NotaPedidoModel::mdlDeleteNotaPedido($table, $codNotaPe);
        if ($response == "ok") {
          $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Nota Pedido Eliminado Correctamente', 'verSalidas');
          echo $message;
        } else {
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Eliminar la Nota Pedido', 'verSalidas');
          echo $message;
        }
      }
    }
  }
  /* fin */

  //  Actualizar el estado de la nota
  public static function ctrUpdateNotaPedido()
  {
    //  En el caso se tenga estos datos, es un update de estado 1 a 2 || 2 a 3 
    if (isset($_GET["codUpdateNota"]) && isset($_GET["observacion"])) {
      $table = "tb_notapedido";
      $codNota = $_GET["codUpdateNota"];
      $observacion = $_GET["observacion"];
      $estadoNota = self::ctrGetEstadoNotaPedido($codNota);
      $estadoNota = intval($estadoNota["EstadoNota"]) + 1;
      $dataUpdate = array(
        "EstadoNota" => $estadoNota,
        "DateUpdate" => date("Y-m-d\TH:i:sP"),
        "Observacion" => $observacion,
        "IdNotaP" => $codNota
      );
      $actualizarNota = NotaPedidoModel::mdlUpdateNotaPedidoRetirado($table, $dataUpdate);
      if ($actualizarNota == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Nota Pedido Actualizada Correctamente', 'verSalidas');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Actualizar la Nota Pedido', 'verSalidas');
        echo $message;
      }
    }
  }

  //  Anular una nota de pedido
  public static function ctrNullNotaPedido()
  {
    if (isset($_GET["codNotaNull"])) {
      $table = "tb_notapedido";
      $codNotaPe = $_GET["codNotaNull"];
      //  Obtenemos la lista de productos de la nota de pedido
      $productos = self::ctrGetListaProductos($codNotaPe);
      $productos = json_decode($productos["DatosProductosNotaPedidoJson"], true);
      //  Actualizamos el stock de los productos
      foreach ($productos as $product) {
        $stock = AlmacenController::ctrComprobarStockRes($product["codProduct"]);
        $nuevoStock = $stock["CantidadTotal"] + $product["countProduct"];
        $dataUpdate = array(
          "CantidadTotal" => $nuevoStock,
          "DateUpdate" => date("Y-m-d"),
          "HoraUpdate" => date("H:i:s"),
          "IdAlma" => $stock["IdAlma"]
        );
        $updateStock = AlmacenController::ctrUpdateStockAlmacenRes($dataUpdate);
      }
      if ($updateStock == "ok") {
        $dataUpdate = array(
          "EstadoNota" => "5",
          "DateUpdate" => date("Y-m-d\TH:i:sP"),
          "IdNotaP" => $codNotaPe
        );
        $response = NotaPedidoModel::mdlUpdateNotaPedidoRetirado($table, $dataUpdate);
        if ($response == "ok") {
          $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Nota Pedido Anulada Correctamente', 'verSalidas');
          echo $message;
        } else {
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Anulada la Nota Pedido', 'verSalidas');
          echo $message;
        }
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Anulada la Nota Pedido', 'verSalidas');
        echo $message;
      }
    }
  }

  /* funcion para Editar nota de pedido por el boton  */
  public static function ctrGetEditNotPeData($codEditNotPeData)
  {
    $table = "tb_notapedido";
    $response = NotaPedidoModel::mdlGetEditNotPeData($table, $codEditNotPeData);
    return $response;
  }

  /* fin */

  //  Obtener datos de la nota de pedido para editar
  public static function ctrGetNotaPeById($codNotaPedido)
  {
    $table = "tb_notapedido";
    $response = NotaPedidoModel::mdlGetNotaPeById($table, $codNotaPedido);
    return $response;
  }

  //  Editar una noat de pedido
  public static function ctrEditarNotaPedido()
  {
    if (isset($_POST["formDataJson"])) {
      $table = "tb_notapedido";
      $data = json_decode($_POST["formDataJson"], true);

      //  Obtengo la lista antigua de productos y la comparo con la nueva
      $productosAntiguos = self::ctrGetListaProductos($_POST["codNotaPedido"]);
      $productosAntiguos = json_decode($productosAntiguos["DatosProductosNotaPedidoJson"], true);

      $listaAntigua = array_map('serialize', $productosAntiguos);
      $listaNueva = array_map('serialize', $data["listProducts"]);
      sort($listaAntigua);
      sort($listaNueva);

      if ($listaAntigua == $listaNueva) {
        //  Si ambos arrays son iguales solo actualizo los datos generales de la nota de pedido
        $dataUpdate = array(
          "IdPer" => $data["notVend"],
          "IdRes" => $data["notRes"],
          "IdCliente" => $data["notRuc"],
          "FechaNotaPedido" => $data["notFechPe"],
          "DateUpdate" => date("Y-m-d\TH:i:sP"),
          "IdNotaP" => $_POST["codNotaPedido"]
        );
        $response = NotaPedidoModel::mdlEditarNotaPedido($table, $dataUpdate);

        if ($response == "ok") {
          $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Nota de pedido actualizada correctamente', 'verSalidas');
          echo $message;
        } else {
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al actualizar la nota de pedido', 'verSalidas');
          echo $message;
        }
      } else {
        //  En el caso que los arrays sean diferentes, se debe actualizar el stock con los productos antiguos y nuevos
        $actualizarStock = AlmacenController::ctrUpdateStockNota($productosAntiguos, $data["listProducts"]);

        if ($actualizarStock == "ok") {
          $dataUpdate = array(
            "IdPer" => $data["notVend"],
            "IdRes" => $data["notRes"],
            "IdCliente" => $data["notRuc"],
            "DatosProductosNotaPedidoJson" => json_encode($data["listProducts"]),
            "Total" => $data["notTotal"],
            "FechaNotaPedido" => $data["notFechPe"],
            "DateUpdate" => date("Y-m-d\TH:i:sP"),
            "IdNotaP" => $_POST["codNotaPedido"]
          );
          $response = NotaPedidoModel::mdlEditarNotaPedidoCompleta($table, $dataUpdate);
          if ($response == "ok") {
            $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Nota de pedido actualizada correctamente', 'verSalidas');
            echo $message;
          } else {
            $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al actualizar la nota de pedido', 'verSalidas');
            echo $message;
          }
        } else {
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al actualizar la nota de pedido', 'verSalidas');
          echo $message;
        }
      }
    }
  }

  //  Obtener el estado de la nota de pedido
  public static function ctrGetEstadoNotaPedido($codNotaPedido)
  {
    $table = "tb_notapedido";
    $response = NotaPedidoModel::mdlGetEstadoNotaPedido($table, $codNotaPedido);
    return $response;
  }

  // Verificar un Cliente se esta usando en la tabla nota pedido
  public static function ctrGetHistorialCliente($codClient)
  {
    $table = "tb_notapedido";
    $respuesta = NotaPedidoModel::mdlGetHistorialCliente($table, $codClient);
    return $respuesta;
  }

  // Verificar un verdedor se esta usando en alguna tabla
  public static function ctrGetHistorialPerVend($codPersonal)
  {
    $table = "tb_notapedido";
    $respuesta = NotaPedidoModel::mdlGetHistorialPerVend($table, $codPersonal);
    return $respuesta;
  }

  // Verificar un Responsable se esta usando en alguna tabla
  public static function ctrGetHistorialPerRes($codPersonal)
  {
    $table = "tb_notapedido";
    $respuesta = NotaPedidoModel::mdlGetHistorialPerRes($table, $codPersonal);
    return $respuesta;
  }

  /* Reporte excel de todas las Notas */
  public static function ctrGetAllDowlReportsExeNotPe()
  {
    $table = "tb_notapedido";
    $listAllDataExeNotPe = NotaPedidoModel::mdlGetAllDowlReportsExeNotPe($table);

    $newlistAllDataExeNotPe = [];

    // Iterar sobre cada registro
    foreach ($listAllDataExeNotPe as $key => $Data) {
      $recordlistAllDataExeNotPe = self::procesarJson($Data);
      $newlistAllDataExeNotPe = array_merge($newlistAllDataExeNotPe, $recordlistAllDataExeNotPe);
    }

    return $newlistAllDataExeNotPe;
  }

  //  Obtener la data para imprimir en el excel general de las notas
  public static function ctrDownloadExcelNotas()
  {
    $table = "tb_notapedido";
    $listNotasGeneral = NotaPedidoModel::mdlDownloadExcelNotas($table);
    return $listNotasGeneral;
  }

  /* Función para procesar el campo JSON de un registro.*/

  private static function procesarJson($Data)
  {
    $recordlistAllDataExeNotPe = [];

    // Decodificar el JSON en el campo DatosProductosIngresoJson
    $products = json_decode($Data['DatosProductosNotaPedidoJson'], true);

    // Formatear los datos del producto
    foreach ($products as $index => $product) {
      $newData = $Data;
      $newData['Producto'] = $product['NombreProducto'];
      $newData['Cantidad'] = $product['countProduct'];
      $newData['TotalP'] = $product['newSum'];
      unset($newData['DatosProductosNotaPedidoJson']);

      $recordlistAllDataExeNotPe[] = $newData;
    }
    return $recordlistAllDataExeNotPe;
  }

  /* fin */

  /* Reporte excel Notas por fechas  */
  public static function ctrGetAllDowlReportsExeNotPeFech($fechaInicioNot, $fechaFinNot)
  {
    $table = "tb_notapedido";
    $listAllDataExeNotPeFech = NotaPedidoModel::mdlGetAllDowlReportsExeNotPeFech($table, $fechaInicioNot, $fechaFinNot);
    $newlistAllDataExeNotPeFech = [];
    // Iterar sobre cada registro
    foreach ($listAllDataExeNotPeFech as $key => $Data) {
      $recordlistAllDataExeNotPeFech = self::procesarJsonFech($Data);
      $newlistAllDataExeNotPeFech = array_merge($newlistAllDataExeNotPeFech, $recordlistAllDataExeNotPeFech);
    }
    return $newlistAllDataExeNotPeFech;
  }

  /* Función para procesar el campo JSON de un registro.*/
  private static function procesarJsonFech($Data)
  {
    $recordlistAllDataExeNotPeFech = [];
    $products = json_decode($Data['DatosProductosNotaPedidoJson'], true);
    foreach ($products as $index => $product) {
      $newData = $Data; // Copiar el registro original
      $newData['Producto'] = $product['NombreProducto'];
      $newData['Cantidad'] = $product['countProduct'];
      $newData['TotalP'] = $product['newSum'];
      unset($newData['DatosProductosNotaPedidoJson']);
      $recordlistAllDataExeNotPeFech[] = $newData;
    }
    return $recordlistAllDataExeNotPeFech;
  }
  /* fin */

  /* Imprimir Pdf para Notas de Pedido */

  public static function ctrGetAllPrintPDFNotPe($codNotaPe)
  {
    $table = "tb_notapedido";
    $listAllDataPDFnotPe = NotaPedidoModel::mdlGetAllPrintPDFNotPe($table, $codNotaPe);

    // Como necesitamos devolver un solo registro y no un array, tomamos el primer elemento
    $singleRecord = $listAllDataPDFnotPe[0];

    return $singleRecord;
  }

  public static function procesarJsonPDF($Data)
  {
    $recordlistAllDataPDFnotPe = [];

    // Decodificar el JSON en el campo DatosProductosNotaPedidoJson
    $products = json_decode($Data['DatosProductosNotaPedidoJson'], true);

    // Formatear los datos del producto
    foreach ($products as $index => $product) {
      $newData = [];
      $newData['Producto'] = $product['NombreProducto'];
      $newData['PrecioUnitario'] = $product['priceProduct'];
      $newData['Cantidad'] = $product['countProduct'];
      $newData['Total'] = $product['newSum'];
      $newData['UnidadM'] = $product['Unidad'];

      $recordlistAllDataPDFnotPe[] = $newData;
    }
    return $recordlistAllDataPDFnotPe;
  }

  /* fin */
  //  Obtener la lista de productos de una nota de pedido
  public static function ctrGetListaProductos($codNota)
  {
    $table = "tb_notapedido";
    $listaProductos = NotaPedidoModel::mdlGetListaProductos($table, $codNota);
    return $listaProductos;
  }

  //  Actualizar la nota de pedido en una devolución
  public static function ctrUpdateNotaPedidoDevolucion($dataUpdate)
  {
    $table = "tb_notapedido";
    $response = NotaPedidoModel::mdlUpdateNotaPedidoDevolucion($table, $dataUpdate);
    return $response;
  }
}
