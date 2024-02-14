<?php

class AlmacenController
{

  //  Mostrar productos y cantidades del almacen
  public static function ctrGetAllProductsIngDet()
  {
    $tabla = "tb_almacen";
    $respuesta = AlmacenModel::mdlObtenerProductsIngDetl($tabla);
    return $respuesta;
  }



  //  Mostrar producto por codigo del producto 
  public static function ctrMostrarStockPorCampo($valorBuscado)
  {
    $tabla = "tb_product";
    $respuesta = ModelStock::mdlObtenerStockGeneral($tabla, $valorBuscado);
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
}
