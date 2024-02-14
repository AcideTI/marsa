<?php

class LotesController
{
 
/* mostrar todos los lotes en la tabla */
public static function ctrGetAllLotes()
{
  $table = "tb_lote";
  $ListNotaPedido = LotesModel::mdlGetAllLotes($table);
  return $ListNotaPedido;
}

    // obtener datos de los productos para agregarlos a la lista
  public static function ctrGetListProducts()
  {
    $table = "tb_almacen";
    $productData = LotesModel::mdlGetProductData($table);
    return $productData;
  }

//  Devolver productos para agregarlos a la lista de ingreso ajx
  public static function ctrGetProductDataAjx($codProductAdd)
  {
    $table = "tb_producto";
    $data = LotesModel::mdlGetProductDataAjx($table, $codProductAdd);
    return $data;
  }

  
  public static function ctrCreateIngresoLoteAjx($newIngLote)
  {
    if(isset($newIngLote))
    {
      $table = "tb_lote";

      // Decodificar el JSON
      $data = json_decode($newIngLote, true);

      $dataCreate = array(
        "IdPer" => $data["nameResLot"],
        "CodigoLote" => $data["codLot"],
        "DescripcionLote" => $data["DesLot"],
        "DatosLoteIngresoJson" => $data["listProducts"],
        "FechaProduccionLote" => $data["dateCreatLot"],
        "FechaVencimientoLote" => $data["dateVenciLot"],  
        "Estado" => $data["stateLot"],
        "DateCreate" => date("Y-m-d\TH:i:sP"),
        "DateUpdate" => date("Y-m-d\TH:i:sP")
      );

      $response = LotesModel::mdlCreateIngresoLoteAjx($table, $dataCreate);


      // Si la respuesta es exitosa, restar los productos del almacén
      if ($response == "ok") {

       /*  $listProducts = is_string($value["listProducts"]) ? json_decode($value["listProducts"], true) : $value["listProducts"]; */
       $listProducts = json_decode($data["listProducts"], true);

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
      }
      return $response;
    }
  }
  /* fin */

   // Eliminar lote
   public static function ctrDeleteLote()
   {
     if (isset($_GET["codLoteDelet"])) {
       $table = "tb_lote";
       $codLoteDelet = $_GET["codLoteDelet"];
       $response = LotesModel::mdlDeleteLote($table, $codLoteDelet);
       if ($response == "ok") {
         $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Lote Eliminado Correctamente', 'lotes');
         echo $message;
       } else {
         $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Eliminar el Lote ', 'lotes');
         echo $message;
       }
     }
   }
   /* fin */
}
