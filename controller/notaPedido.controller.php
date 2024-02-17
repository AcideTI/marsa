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
          "IdRes" => $data["notRes"],
          "FechaNotaPedido" => $data["notFechPe"],
          "IdPer" => $data["notVend"],
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
        return;
      } else {
        //  Obtenemos la lista de productos de la nota de pedido
        $productos = NotaPedidoModel::mdlGetListaProductos($table, $codNotaPe);
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
      $productosAntiguos = NotaPedidoModel::mdlGetListaProductos($table, $_POST["codNotaPedido"]);
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
}
