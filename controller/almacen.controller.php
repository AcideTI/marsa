<?php
date_default_timezone_set('America/Bogota');
class AlmacenController
{

  //  Mostrar productos y cantidades del almacen
  public static function ctrGetAllProductsIngDet()
  {
    $tabla = "tb_almacen";
    $respuesta = AlmacenModel::mdlObtenerProductsIngDetl($tabla);
    return $respuesta;
  }

  //  Crear stock del almacen por ingreso de produccion
  public static function ctrCreateStockAlmacen($dataStock)
  {
    $tabla = "tb_almacen";
    $respuesta = AlmacenModel::mdlCrearStockAlmacen($tabla, $dataStock);
    return $respuesta;
  }

  //  Actualizar stock del almacen
  public static function ctrUpdateStockAlmacen($dataStock)
  {
    $tabla = "tb_almacen";
    $respuesta = AlmacenModel::mdlActualizarStockAlmacen($tabla, $dataStock);
    return $respuesta;
  }

  //  Revisar stock del producto
  public static function ctrComprobarStock($codProduct)
  {
    $tabla = "tb_almacen";
    $respuesta = AlmacenModel::mdlComprobarStock($tabla, $codProduct);
    return $respuesta;
  }

   //  Revisar stock del producto para restarlo
   public static function ctrComprobarStockRes($product)
  {
    $tabla = "tb_almacen";
    $respuesta = AlmacenModel::mdlComprobarStockRes($tabla, $product);
    return $respuesta;
  }

  //  Actualizar stock del almacen para restar 
  public static function ctrUpdateStockAlmacenRes($dataStock)
  {
    $tabla = "tb_almacen";
    $respuesta = AlmacenModel::mdlUpdateStockAlmacenRes($tabla, $dataStock);
    return $respuesta;
  }

  //  Verificar que un producto no tiene registro dentro del almacén
  public static function mdlGetHistorialProduct($codProduct)
  {
    $table = "tb_almacen";
    $respuesta = AlmacenModel::mdlGetHistorialProduct($table, $codProduct);
    return $respuesta;
  }

  //  Report donwload exel Almacen
  public static function ctrGetAllDowlReportsAlmacen()
  {
    $table = "tb_almacen";
    $listAllDataExeAlmacen = AlmacenModel::mdlGetAllDowlReprtAlmacen($table);
    // Filtrar los registros donde la cantidad es mayor a cero
    $listAllDataExeAlmacen = array_filter($listAllDataExeAlmacen, function($record) {
      return $record['CantidadTotal'] != 0;
    });

    return $listAllDataExeAlmacen;
  }
  /* FIN */
  //  Obtener la data de un producto para enviar a la vista de editar una nota de pedido
  public static function ctrGerProductDataById($codProduct)
  {
    $table = "tb_producto";
    $respuesta = AlmacenModel::mdlGerProductDataById($table, $codProduct);
    return $respuesta;
  }

  //  Actualizar stock del almacen por una modificacion en la nota de pedido
  public static function ctrUpdateStockNota($listaAntigua, $listaNueva)
  {
    // Primero actualizamos el stock de los productos que ya estaban en la lista
    foreach($listaAntigua as $value) {
      $stockActual = self::ctrComprobarStock($value["codProduct"]);
      $nuevStock = $value["countProduct"] + $stockActual["CantidadTotal"];
      $dataUpdate = array(
        "CantidadTotal" => $nuevStock,
        "DateUpdate" => date("Y-m-d"),
        "HoraUpdate" => date("H:i:s"),
        "IdAlma" => $stockActual["IdAlma"]
      );
      $response = self::ctrUpdateStockAlmacen($dataUpdate);
    }
    if($response == "ok") {
      // Luego restamos el stock de la nueva lista de productos
      foreach($listaNueva as $value) {
        $stockActual = self::ctrComprobarStock($value["codProduct"]);
        $nuevStock = $stockActual["CantidadTotal"] - $value["countProduct"];
        $dataUpdate = array(
          "CantidadTotal" => $nuevStock,
          "DateUpdate" => date("Y-m-d"),
          "HoraUpdate" => date("H:i:s"),
          "IdAlma" => $stockActual["IdAlma"]
        );
        $response = self::ctrUpdateStockAlmacen($dataUpdate);
      }
      return $response;
    } else {
      return $response;
    }
  }

  //  Actualizar stock del almacén de merma por una devolución
  public static function ctrUpdateStockAlmacenMerma($dataCreate)
  {
    $table = "tb_almacen_merma";
    $response = AlmacenModel::mdlUpdateStockAlmacenMerma($table, $dataCreate);
    return $response;
  }

  //  Mostrar productos y cantidades del almacen de merma
  public static function ctrGetAllMerma()
  {
    $table = "tb_almacen_merma";
    $response = AlmacenModel::mdlGetAllMerma($table);
    return $response;
  }
}
