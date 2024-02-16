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
          "IdLote" => $data["notPeLot"],
          "IdPer" => $data["notRes"],
          "IdRes" => $data["notVend"],
          "NotaPorFA" => $data["notTiPe"],
          "IdCliente" => $data["notRuc"],
          "TipoDeNotaPe" => $data["notTipoPe"],
          "TipoNotaPeFactura" => $data["datosFactura"],
          "DatosProductosNotaPedidoJson" => json_encode($data["listProducts"]),
          "Total" => $data["notTotal"],
          "Estado" => $data["notDescrip"],
          "FechaNotaPedido" => $data["notFechPe"],
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
      $response = NotaPedidoModel::mdlDeleteNotaPedido($table, $codNotaPe);
      if ($response == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Nota Pedido Eliminado Correctamente', 'verNotasPedido');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Eliminar la Nota Pedido', 'verNotasPedido');
        echo $message;
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
  public static function ctrGetNotaPeById($codNota)
  {
    $table = "tb_notapedido";
    $response = NotaPedidoModel::mdlGetNotaPeById($table, $codNota);
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


}
