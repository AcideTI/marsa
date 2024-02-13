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
public static function ctrGetAjaxDatosJson()
{
  // Comprueba si se ha enviado el campo jsonDatos
  if (isset($_POST["formDataJson"])) {
    // Decodifica la cadena JSON en un array asociativo
    $data = json_decode($_POST["formDataJson"], true);

    // Imprime los datos decodificados en la consola
    error_log(print_r($data, true));
        // Comprueba si listProducts es un array válido
      if (!is_array($data["listProducts"])) {
      // Si no es un array válido, devuelve un mensaje de error
      return "error: listProducts no es un array válido";
      }
    // Prepara los datos para la inserción en la base de datos
    $table = "tb_notapedido";
    $dataCreate = array(
      "IdLote" => $data["notPeLot"],
      "IdPer" => $data["notVend"],
      "IdRes" => $data["notRes"],
      "NotaPorFA" => $data["notTiPe"],
      "RucCli" => $data["notRuc"],
      "NombreCliNota" => $data["notCli"],
      "DireccionCliNota" => $data["notDirec"],
      "TipoDeNotaPe" => $data["notTipoPe"],
      "TipoNotaPeFactura" => $data["datosFactura"],
      "DatosProductosNotaPedidoJson" => json_encode($data["listProducts"]),
      "SubTotal" => $data["notSubT"],
      "IGV" => $data["notIGV"],
      "Total" => $data["notTotal"],
      "ComentarioNotaDev" => $data["comentDev"],
      "Estado" => $data["notDescrip"],
      "FechaNotaPedido" => $data["notFechPe"],
      "FechaNotaDevolucion" => $data["notFechDev"],
      "DateCreate" => date("Y-m-d\TH:i:sP"),
      "DateUpdate" => date("Y-m-d\TH:i:sP")
    );

   // Llama al modelo para insertar los datos
   $createNotaPedido = NotaPedidoModel::mdlGetAjaxDatosJson($table, $dataCreate);

   // Comprueba si la inserción fue exitosa
   if ($createNotaPedido == "ok") {

    // Para cada producto en listProducts, realiza las siguientes operaciones:
    $listProducts = is_string($data["listProducts"]) ? json_decode($data["listProducts"], true) : $data["listProducts"];

    // Para cada producto en listProducts, realiza las siguientes operaciones:
    foreach ($listProducts as $product) {
      // Comprueba el stock del producto
      $stock = AlmacenController::ctrComprobarStockRes($product["codProduct"]);
      // ...
    
      // Si el producto existe en el almacén, resta la cantidad del producto del stock existente
      if (!empty($stock["IdAlma"])) {
        $newStock = $stock["CantidadTotal"] - $product["countProduct"];

        // Comprueba si el nuevo stock es negativo
        if ($newStock < 0) {
          // Si el nuevo stock es negativo, devuelve un mensaje de error y termina la ejecución
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'La cantidad del producto en la nota de pedido es mayor que el stock existente', 'index.php?ruta=notaPedido');
          echo $message;
          return;
        }

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
        $table = "tb_producto";
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
}
