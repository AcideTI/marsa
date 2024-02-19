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
    $table = "tb_almacen";
    $data = LotesModel::mdlGetProductDataAjx($table, $codProductAdd);
    return $data;
  }

  /*  funcion para crear un nuevo lote */
  public static function ctrCreateIngresoLoteAjx($newIngLote)
  {
    if (isset($newIngLote)) {
      $table = "tb_lote";

      // Decodificar el JSON
      $data = json_decode($newIngLote, true);
      $listProducts = json_decode($data["listProducts"], true);
      //  El codigo de lote, está compuesto por el día_mes_operador_producto
      $fecha = strtotime($data["dateCreatLot"]);
      $dia = date("d", $fecha);
      $mes = date("m", $fecha);
      $operador = $data["nameResLot"];
      $producto = $listProducts[0]["codProduct"];

      $codigoLote = $dia . '_' . $mes . '_' . $operador . '_' . $producto;

      $dataCreate = array(
        "IdCliente" => $data["notCli"],
        "IdPer" => $data["nameResLot"],
        "CodigoLote" => $codigoLote,
        "DatosLoteIngresoJson" => $data["listProducts"],
        "FechaProduccionLote" => $data["dateCreatLot"],
        "FechaVencimientoLote" => $data["dateVenciLot"],
        "DescripcionLote" => $data["DesLot"],
        "Estado" => "1",
        "DateCreate" => date("Y-m-d\TH:i:sP"),
        "DateUpdate" => date("Y-m-d\TH:i:sP")
      );
      $response = LotesModel::mdlCreateIngresoLoteAjx($table, $dataCreate);

      // Si la respuesta es exitosa, restar los productos del almacén
      if ($response == "ok") {
        foreach ($listProducts as $product) {
          //  Obtener el codigo del producto del almacén y la cantidad que se tiene actualmente
          $stock = AlmacenController::ctrComprobarStockRes($product["codProduct"]);
          $newStock = $stock["CantidadTotal"] - $product["countProduct"];

          // Prepara los datos para la actualización en la base de datos
          $dataUpdate = array(
            "CantidadTotal" => $newStock,
            "DateUpdate" => date("Y-m-d"),
            "HoraUpdate" => date("H:i:s"),
            "IdAlma" => $stock["IdAlma"]
          );

          // Actualiza el stock del producto en la base de datos
          $response = AlmacenController::ctrUpdateStockAlmacenRes($dataUpdate);
        }
      } else {
        $response = "error";
      }
      return $response;
    }
  }

  /* funcion para Editar  lote por el boton  */
  public static function ctrEditIngresoLoteAjx($editLote)
  {
    if (isset($editLote)) {
      $table = "tb_lote";

      // Decodificar el JSON
      $data = json_decode($editLote, true);

      // Recuperar el stock actual
      $stockActual = LotesModel::mdlGetStockActual($table, $data["idLoteEdit"]);
      $stockActual = json_decode($stockActual["DatosLoteIngresoJson"], true);

      // Decodificar listProducts
      if (isset($data["listProducts"])) {
        $data["listProducts"] = json_decode($data["listProducts"], true);

        // Recorrer cada producto en $data["listProducts"]
        foreach ($data["listProducts"] as $product) {
          // Buscar el producto en $stockActual
          foreach ($stockActual as $productActual) {
            if ($productActual["codProduct"] == $product["codProduct"]) {
              // Calcular la diferencia de stock
              $diferenciaStock = $productActual["countProduct"] - $product["countProduct"];

              // Si la diferencia de stock es positiva, devolver la diferencia al almacén
              if ($diferenciaStock > 0) {
                // Aquí puedes añadir el código para devolver la diferencia de stock al almacén
                $stock = AlmacenController::ctrComprobarStockRes($product["codProduct"]);
                $newStock = $stock["CantidadTotal"] + $diferenciaStock;
                $dataUpdate = array(
                  "CantidadTotal" => $newStock,
                  "DateUpdate" => date("Y-m-d"),
                  "HoraUpdate" => date("H:i:s"),
                  "IdAlma" => $stock["IdAlma"]
                );
                AlmacenController::ctrUpdateStockAlmacenRes($dataUpdate);
              }
              // Si la diferencia de stock es negativa, restar la diferencia del almacén
              else if ($diferenciaStock < 0) {
                // Aquí puedes añadir el código para restar la diferencia de stock del almacén
                $stock = AlmacenController::ctrComprobarStockRes($product["codProduct"]);
                $newStock = $stock["CantidadTotal"] + $diferenciaStock; // La diferencia es negativa, por lo que se restará
                if ($newStock < 0) {
                  $message = FunctionsController::ctrShowAlert('error', 'Error', 'La cantidad del producto en la nota de pedido es mayor que el stock existente', 'index.php?ruta=notaPedido');
                  echo $message;
                  return;
                }
                $dataUpdate = array(
                  "CantidadTotal" => $newStock,
                  "DateUpdate" => date("Y-m-d"),
                  "HoraUpdate" => date("H:i:s"),
                  "IdAlma" => $stock["IdAlma"]
                );
                AlmacenController::ctrUpdateStockAlmacenRes($dataUpdate);
              }
            }
          }
        }
      } else {
        echo "No se encontró listProducts en los datos proporcionados.";
      }

      $dataEditUpdate = array(
        /* IdLote registro especificao a actualizar  */
        "IdLote" => $data["idLoteEdit"],
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

      $response = LotesModel::mdlEditIngresoLoteAjx($table, $dataEditUpdate);

      return $response;
    }
  }
  /* fin */

  /* funcion para recuperar datos para Editar  lote por el boton  */
  public static function ctrGetEditLoteData($codLoteEdit)
  {
    $table = "tb_lote";
    $response = LotesModel::mdlGetEditLoteData($table, $codLoteEdit);
    return $response;
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
