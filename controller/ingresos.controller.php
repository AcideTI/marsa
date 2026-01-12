<?php
date_default_timezone_set('America/Bogota');
class IngresosController
{
  /* mostrar todos ingresos en la tabla */
  public static function ctrGetAllIngresos()
  {
    $table = "tb_ingreso";
    $listAllDataExeIng = IngresosModel::mdlGetAllIngresos($table);
    return $listAllDataExeIng;
  }

  /* Obtener ingresos paginados para DataTables server-side */
  public static function ctrGetIngresosPaginated($start, $length, $search, $orderColumn, $orderDir)
  {
    $table = "tb_ingreso";
    return IngresosModel::mdlGetIngresosPaginated($table, $start, $length, $search, $orderColumn, $orderDir);
  }

  // obtener datos de los productos para agregarlos a la lista
  public static function ctrGetListProducts()
  {
    $table = "tb_producto";
    $productData = IngresosModel::mdlGetProductData($table);
    return $productData;
  }

  //  Devolver productos para agregarlos a la lista de ingreso ajx
  public static function ctrGetProductDataAjx($codProductAdd)
  {
    $table = "tb_producto";
    $data = IngresosModel::mdlGetProductDataAjx($table, $codProductAdd);
    return $data;
  }

  /* funcion de controlador que toma el json de newIngJs e ingresa el registo a el ingreso */
  public static function ctrCreateIngresoNuevoAjx($newIngJs)
  {
    if (isset($newIngJs)) {
      $table = "tb_ingreso";

      // Decodificar el JSON
      $data = json_decode($newIngJs, true);

      $dataCreate = array(
        "IdPer" => $data["nameRes"],
        "DescripcionIng" => $data["DescripcionIng"],
        "DatosProductosIngresoJson" => $data["listProducts"],
        "FechaProduccionIng" => $data["dateProduction"],
        "FechaVencimientoIng" => $data["dateVenci"],
        "Estado" => "7",
        "TipoIngreso" => "1",
        "DateCreate" => date("Y-m-d\TH:i:sP"),
        "DateUpdate" => date("Y-m-d\TH:i:sP")
      );
      $response = IngresosModel::mdlCreateIngresoNuevoAjx($table, $dataCreate);

      // Actualizar stock
      $listaProductos = json_decode($data["listProducts"], true);
      foreach ($listaProductos as $value) {

        // Comprobar stock
        $dataStock = AlmacenController::ctrComprobarStock($value["codProduct"]);
        //update stock
        if ($dataStock["IdAlma"] != "") {
          $newStock = $dataStock["CantidadTotal"] + $value["countProduct"];
          $dataUpdateStock = array(
            "CantidadTotal" => $newStock,
            "DateUpdate" => date("Y-m-d"),
            "HoraUpdate" => date("H:i:s"),
            "IdAlma" => $dataStock["IdAlma"]
          );
          $updateStock = AlmacenController::ctrUpdateStockAlmacen($dataUpdateStock);
          //crear stock
        } else {
          $dataCreateStock = array(
            "IdProd" => $value["codProduct"],
            "CantidadTotal" => $value["countProduct"],
            "DateCreate" => date("Y-m-d"),
            "HoraCreate" => date("H:i:s"),
            "DateUpdate" => date("Y-m-d"),
            "HoraUpdate" => date("H:i:s")
          );
          $updateStock = AlmacenController::ctrCreateStockAlmacen($dataCreateStock);
        }
      }
      return $response;
    }
  }

  // Eliminar nota pedido
  public static function ctrdeleteIngreso()
  {
    if (isset($_GET["codIngresoDelet"])) {
      $table = "tb_ingreso";
      $codIngreso = $_GET["codIngresoDelet"];
      //  Obtener la data del ingreso
      $listaProductos = IngresosModel::mdlGetIngresoList($table, $codIngreso);
      $listaProductos = json_decode($listaProductos["DatosProductosIngresoJson"], true);

      //  Actualizar stock con cada dato que se está eliminando
      foreach ($listaProductos as $value) {
        $stockActual = AlmacenController::ctrComprobarStock($value["codProduct"]);
        $nuevoStock = $stockActual["CantidadTotal"] - $value["countProduct"];

        $dataStock = array(
          "CantidadTotal" => $nuevoStock,
          "DateUpdate" => date("Y-m-d"),
          "HoraUpdate" => date("H:i:s"),
          "IdAlma" => $stockActual["IdAlma"]
        );
        $updateStock = AlmacenController::ctrUpdateStockAlmacen($dataStock);
      }

      if ($updateStock == "ok") {
        $response = IngresosModel::mdlDeleteIngreso($table, $codIngreso);
        if ($response == "ok") {
          $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Ingreso Eliminado Correctamente', 'index.php?ruta=ingresos');
          echo $message;
        } else {
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Eliminar el Ingreso ', 'index.php?ruta=ingresos');
          echo $message;
        }
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Eliminar el Ingreso ', 'index.php?ruta=ingresos');
        echo $message;
      }
    }
  }

  //  Obtener datos del ingreso para editar
  public static function ctrGetIngreso($codIngreso)
  {
    $table = "tb_ingreso";
    $data = IngresosModel::mdlGetIngreso($table, $codIngreso);
    return $data;
  }

  //  Editar un ingreso
  public static function ctrEditIngreso()
  {
    if (isset($_POST["editResponsable"]) && isset($_POST["editFechaProduccion"]) && isset($_POST["editFechaVencimiento"]) && isset($_POST["editDescripcionIngreso"])) {
      $table = "tb_ingreso";
      $codIngreso = $_POST["codIngreso"];
      //  Primero editamos la cabecera del ingreso
      $data = array(
        "IdPer" => $_POST["editResponsable"],
        "DescripcionIng" => $_POST["editDescripcionIngreso"],
        "FechaProduccionIng" => $_POST["editFechaProduccion"],
        "FechaVencimientoIng" => $_POST["editFechaVencimiento"],
        "DateUpdate" => date("Y-m-d\TH:i:sP"),
        "IdIng" => $codIngreso
      );
      $response = IngresosModel::mdlEditIngreso($table, $data);

      if ($response == "ok") {
        //  Actualizamos el stock del almacén, siempre que se haya modificado la lista de productos
        $nuevaListaProductos = json_decode($_POST["listProducts"], true);
        if ($nuevaListaProductos != "" || $nuevaListaProductos != null) {
          //  Obtener la lista antigua del ingreso
          $antiguaListaProductos = IngresosModel::mdlGetIngresoList($table, $codIngreso);
          $antiguaListaProductos = json_decode($antiguaListaProductos["DatosProductosIngresoJson"], true);
          //  Actualizar stock con cada dato de la lista antigua
          foreach ($antiguaListaProductos as $value) {
            $stockActual = AlmacenController::ctrComprobarStock($value["codProduct"]);
            $nuevoStock = $stockActual["CantidadTotal"] - $value["countProduct"];
            $dataStock = array(
              "CantidadTotal" => $nuevoStock,
              "DateUpdate" => date("Y-m-d"),
              "HoraUpdate" => date("H:i:s"),
              "IdAlma" => $stockActual["IdAlma"]
            );
            $updateStock = AlmacenController::ctrUpdateStockAlmacen($dataStock);
          }

          //  Actualizar stock con la lista nueva, si existe el stock de un producto solo se hace update, caso contrario se lo crea en el almacen
          foreach ($nuevaListaProductos as $value) {
            $stockActual = AlmacenController::ctrComprobarStock($value["codProduct"]);
            if ($stockActual["IdAlma"] == "") {
              $dataCreateStock = array(
                "IdProd" => $value["codProduct"],
                "CantidadTotal" => $value["countProduct"],
                "DateCreate" => date("Y-m-d"),
                "HoraCreate" => date("H:i:s"),
                "DateUpdate" => date("Y-m-d"),
                "HoraUpdate" => date("H:i:s")
              );
              $updateStock = AlmacenController::ctrCreateStockAlmacen($dataCreateStock);
            } else {
              $nuevoStock = $stockActual["CantidadTotal"] + $value["countProduct"];
              $dataStock = array(
                "CantidadTotal" => $nuevoStock,
                "DateUpdate" => date("Y-m-d"),
                "HoraUpdate" => date("H:i:s"),
                "IdAlma" => $stockActual["IdAlma"]
              );
              $updateStock = AlmacenController::ctrUpdateStockAlmacen($dataStock);
            }
            $nuevoStock = $stockActual["CantidadTotal"] + $value["countProduct"];
            $dataStock = array(
              "CantidadTotal" => $nuevoStock,
              "DateUpdate" => date("Y-m-d"),
              "HoraUpdate" => date("H:i:s"),
              "IdAlma" => $stockActual["IdAlma"]
            );

            //  Luego de actualizar el stock, actualizamos la lista de productos del ingreso
            $dataUpdate = array(
              "DatosProductosIngresoJson" => $_POST["listProducts"],
              "IdIng" => $codIngreso
            );
            $response = IngresosModel::mdlEditIngresoList($table, $dataUpdate);
          }
          if ($updateStock == "ok") {
            $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Ingreso Editado Correctamente', 'index.php?ruta=ingresos');
            echo $message;
          } else {
            $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Editar el Ingreso ', 'index.php?ruta=ingresos');
            echo $message;
          }
        } else {
          $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Ingreso Editado Correctamente', 'index.php?ruta=ingresos');
          echo $message;
        }
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Editar el Ingreso ', 'index.php?ruta=ingresos');
        echo $message;
      }
    }
  }

  // Verificar un personal se esta usando en alguna tabla
  public static function ctrGetHistorialPer($codPersonal)
  {
    $table = "tb_ingreso";
    $respuesta = IngresosModel::mdlGetHistorialPersonal($table, $codPersonal);
    return $respuesta;
  }

  /* Descargar todos los ingresos para el reporte exel de ingresos */
  /* 
   * Función para obtener todos los ingresos para el reporte de Excel.
   * Itera sobre cada registro devuelto por el modelo y procesa el campo JSON.
   * Devuelve una lista de registros con los datos del producto formateados.
   */
  public static function ctrGetAllDowlReportsExeIng()
  {
    $table = "tb_ingreso";
    $listAllDataExeIng = IngresosModel::mdlGetAllDowlReportsExeIng($table);

    $newlistAllDataExeIng = [];

    // Iterar sobre cada registro
    foreach ($listAllDataExeIng as $key => $Data) {
      $recordlistAllDataExeIng = self::procesarJson($Data);
      $newlistAllDataExeIng = array_merge($newlistAllDataExeIng, $recordlistAllDataExeIng);
    }

    return $newlistAllDataExeIng;
  }
  /* 
   * Función para procesar el campo JSON de un registro.
   * Decodifica el JSON y formatea los datos del producto.
   * Devuelve una lista de nuevos registros con los datos del producto formateados.
   */
  private static function procesarJson($Data)
  {
    $recordlistAllDataExeIng = [];

    // Decodificar el JSON en el campo DatosProductosIngresoJson
    $products = json_decode($Data['DatosProductosIngresoJson'], true);

    // Formatear los datos del producto
    foreach ($products as $index => $product) {
      $newData = $Data; // Copiar el registro original
      $newData['Producto'] = $product['NombreProducto'];
      $newData['Cantidad'] = $product['countProduct'];
      unset($newData['DatosProductosIngresoJson']); // Eliminar el campo DatosProductosIngresoJson

      $recordlistAllDataExeIng[] = $newData; // Agregar el nuevo registro a la lista
    }
    return $recordlistAllDataExeIng;
  }
  /* fin */

  /* Obtener ingresos filtrados por AÑO para reporte Excel */
  public static function ctrGetReportIngByAnio($anio)
  {
    $table = "tb_ingreso";
    $listData = IngresosModel::mdlGetReportIngByAnio($table, $anio);

    $newList = [];
    foreach ($listData as $Data) {
      $processed = self::procesarJson($Data);
      $newList = array_merge($newList, $processed);
    }

    return $newList;
  }

  /* Obtener ingresos filtrados por MES y AÑO para reporte Excel */
  public static function ctrGetReportIngByMes($anio, $mes)
  {
    $table = "tb_ingreso";
    $listData = IngresosModel::mdlGetReportIngByMes($table, $anio, $mes);

    $newList = [];
    foreach ($listData as $Data) {
      $processed = self::procesarJson($Data);
      $newList = array_merge($newList, $processed);
    }

    return $newList;
  }

  /* Devolver todos los ingresos para el reporte exel por fechas */
  public static function ctrGetAllDowlReportsExeIngFech($fechaInicio, $fechaFin)
  {
    $table = "tb_ingreso";
    $listAllDataExeIngFech = IngresosModel::mdlGetAllDowlReportsExeIngFech($table, $fechaInicio, $fechaFin);
    $newlistAllDataExeIng = [];
    // Iterar sobre cada registro
    foreach ($listAllDataExeIngFech as $key => $Data) {
      $recordlistAllDataExeIng = self::procesarJsonFech($Data);
      $newlistAllDataExeIng = array_merge($newlistAllDataExeIng, $recordlistAllDataExeIng);
    }
    return $newlistAllDataExeIng;
  }

  private static function procesarJsonFech($Data)
  {
    $recordlistAllDataExeIng = [];
    $products = json_decode($Data['DatosProductosIngresoJson'], true);
    foreach ($products as $index => $product) {
      $newData = $Data; // Copiar el registro original
      $newData['Producto'] = $product['NombreProducto'];
      $newData['Cantidad'] = $product['countProduct'];
      unset($newData['DatosProductosIngresoJson']);
      $recordlistAllDataExeIng[] = $newData;
    }
    return $recordlistAllDataExeIng;
  }
  /* fin */

  //  Crear un ingreso por devolucion de una nota de pedido o de un lote, dependiendo del $tipoSalida
  public static function ctrCrearIngresoDevolucion()
  {
    if (isset($_POST["responsableDev"]) || isset($_POST["fechaDevolucion"]) || isset($_POST["motivoDevolucion"])) {
      $table = "tb_ingreso";
      $codSalida = $_POST["codSalida"];
      $tipoSalida = $_POST["tipoSalida"];

      //  Si ambas lista que devuelven están vacias o nulas, significa que se devolvio toda la lista de productos al almacén
      if (empty($_POST["listProductosDevolver"]) && empty($_POST["listProductosMerma"])) {
        $listaProductos = NotaPedidoController::ctrGetListaProductos($codSalida);
        $listaProductos = json_decode($listaProductos["DatosProductosNotaPedidoJson"], true);
        foreach ($listaProductos as $value) {
          $stock = AlmacenController::ctrComprobarStock($value["codProduct"]);
          $nuevoStock = $stock["CantidadTotal"] + $value["countProduct"];
          $dataStock = array(
            "CantidadTotal" => $nuevoStock,
            "DateUpdate" => date("Y-m-d"),
            "HoraUpdate" => date("H:i:s"),
            "IdAlma" => $stock["IdAlma"]
          );
          $updateStock = AlmacenController::ctrUpdateStockAlmacen($dataStock);
        }
        if ($updateStock == "ok") {
          //  Cuando se actualice el stock en el almacén se creará el ingreso por devolución en la tabla de ingresos
          $dataTipoSalida = array(
            "codSalida" => $codSalida,
            "tipoSalida" => $tipoSalida
          );
          $dataTipoSalida = json_encode($dataTipoSalida);

          $dataCreate = array(
            "IdPer" => $_POST["responsableDev"],
            "DatosRefSalida" => $dataTipoSalida,
            "DescripcionIng" => $_POST["motivoDevolucion"],
            "DatosProductosIngresoJson" => json_encode($listaProductos),
            "FechaProduccionIng" => $_POST["fechaDevolucion"],
            "Estado" => "6",
            "TipoIngreso" => "2",
            "DateCreate" => date("Y-m-d\TH:i:sP"),
            "DateUpdate" => date("Y-m-d\TH:i:sP")
          );
          $ingreso = IngresosModel::mdlCrearIngresoDevolucionNota($table, $dataCreate);
          //  Si se crea el ingreso por devolución se actualiza el estado del tipo de salida que se está haciendo
          if ($ingreso == "ok") {
            if ($tipoSalida == "Nota de Pedido") {
              $dataUpdate = array(
                "IdNotaP" => $codSalida,
                "EstadoNota" => "4",
                "FechaDevolucion" => $_POST["fechaDevolucion"],
                "DateUpdate" => date("Y-m-d\TH:i:sP")
              );
              $updateSalida = NotaPedidoController::ctrUpdateNotaPedidoDevolucion($dataUpdate);
            } else {
              $dataUpdate = array(
                "IdLote" => $codSalida,
                "Estado" => "4",
                "FechaDevolucion" => $_POST["fechaDevolucion"],
                "DateUpdate" => date("Y-m-d\TH:i:sP")
              );
              $updateSalida = LotesController::ctrUpdateLoteDevolucion($dataUpdate);
            }
            if ($updateSalida == "ok") {
              $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Ingreso por Devolución Creado Correctamente', 'ingresos');
              echo $message;
            } else {
              $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Crear el Ingreso por Devolución', 'ingresos');
              echo $message;
            }
          } else {
            $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Crear el Ingreso por Devolución', 'ingresos');
            echo $message;
          }
        }
      } else {
        $productosDevolucion = json_decode($_POST["listProductosDevolver"], true);
        $productosMerma = json_decode($_POST["listProductosMerma"], true);

        //  Primero creamos el ingreso por devolución para luego obtener el id de este registro creado y guardarlo en la tabla de stock de merma
        $dataTipoSalida = array(
          "codSalida" => $codSalida,
          "tipoSalida" => $tipoSalida
        );
        $dataTipoSalida = json_encode($dataTipoSalida);
        $dataCreate = array(
          "IdPer" => $_POST["responsableDev"],
          "DatosRefSalida" => $dataTipoSalida,
          "DescripcionIng" => $_POST["motivoDevolucion"],
          "DatosProductosIngresoJson" => $_POST["listProductosDevolver"],
          "FechaProduccionIng" => $_POST["fechaDevolucion"],
          "Estado" => "6",
          "TipoIngreso" => "2",
          "DateCreate" => date("Y-m-d\TH:i:sP"),
          "DateUpdate" => date("Y-m-d\TH:i:sP")
        );
        $ingreso = IngresosModel::mdlCrearIngresoDevolucionNota($table, $dataCreate);

        if ($ingreso == "ok") {
          //  Actualizar stock con la lista de productos que se devuelven al stock
          foreach ($productosDevolucion as $value) {
            $stock = AlmacenController::ctrComprobarStock($value["codProduct"]);
            $nuevoStock = $stock["CantidadTotal"] + $value["countProduct"];
            $dataStock = array(
              "CantidadTotal" => $nuevoStock,
              "DateUpdate" => date("Y-m-d"),
              "HoraUpdate" => date("H:i:s"),
              "IdAlma" => $stock["IdAlma"]
            );
            $updateStock = AlmacenController::ctrUpdateStockAlmacen($dataStock);
          }

          //  Obtener el id del ingreso por devolución
          $codIngreso = IngresosModel::mdlGetLastIngreso($table);
          //  Actualizar stock que se va a merma
          foreach ($productosMerma as $value) {
            $dataStock = array(
              "IdProducto" => $value["codProduct"],
              "IdSalida" => $codSalida,
              "IdIngresoDev" => $codIngreso["IdIng"],
              "Cantidad" => $value["countProduct"],
              "TipoSalida" => "Nota de Pedido",
              "DateCreate" => date("Y-m-d\TH:i:sP"),
              "DateUpdate" => date("Y-m-d\TH:i:sP")
            );
            $updateStock = AlmacenController::ctrUpdateStockAlmacenMerma($dataStock);
          }

          if ($updateStock == "ok") {
            //  Si se crea el ingreso por devolución se actualiza el estado de la salida que se está haciendo
            if ($tipoSalida == "Nota de Pedido") {
              $dataUpdate = array(
                "IdNotaP" => $codSalida,
                "EstadoNota" => "3",
                "FechaDevolucion" => $_POST["fechaDevolucion"],
                "DateUpdate" => date("Y-m-d\TH:i:sP")
              );
              $updateSalida = NotaPedidoController::ctrUpdateNotaPedidoDevolucion($dataUpdate);
            } else {
              $dataUpdate = array(
                "IdLote" => $codSalida,
                "Estado" => "3",
                "FechaDevolucion" => $_POST["fechaDevolucion"],
                "DateUpdate" => date("Y-m-d\TH:i:sP")
              );
              $updateSalida = LotesController::ctrUpdateLoteDevolucion($dataUpdate);
            }
            if ($updateSalida == "ok") {
              $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Ingreso por Devolución Creado Correctamente', 'ingresos');
              echo $message;
            } else {
              $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Crear el Ingreso por Devolución', 'ingresos');
              echo $message;
            }
          } else {
            $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Crear el Ingreso por Devolución', 'ingresos');
            echo $message;
          }
        } else {
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Crear el Ingreso por Devolución', 'ingresos');
          echo $message;
        }
      }
    }
  }
}
