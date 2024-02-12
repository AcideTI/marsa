<?php
require_once "conexion.php";

class LotesModel
{

  /* mostrar todos los lotes en la tabla */
  public static function mdlGetAllLotes($table)
  {
    $statement = Conexion::conn()->prepare("
      SELECT lot.*, 
        per.NombrePer AS NombrePerIdPer, 
        e.TipoEstado
      FROM $table AS lot
      INNER JOIN tb_personal AS per ON lot.IdPer = per.IdPer
      INNER JOIN tb_estado AS e ON lot.Estado = e.IdEstado
      ORDER BY IdLote DESC
    ");

    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as &$result) {
      // Procesar el campo JSON
      if (isset($result['DatosLoteIngresoJson'])) {
        $productsJson = json_decode($result['DatosLoteIngresoJson'], true);

        foreach ($productsJson as &$product) {
          $statement = Conexion::conn()->prepare("
            SELECT NombreProducto
            FROM tb_producto
            WHERE IdProd = :codProduct
          ");

          $statement->bindParam(":codProduct", $product['codProduct'], PDO::PARAM_INT);

          $statement->execute();

          $productResult = $statement->fetch(PDO::FETCH_ASSOC);

          $product['NombreProducto'] = $productResult['NombreProducto'];
        }

        $result['DatosLoteIngresoJson'] = json_encode($productsJson);
      }
    }

    return $results;
  }

      // Mostrar los productos a agregar
  public static function mdlGetProductData($table)
  {
    $statement = Conexion::conn()->prepare("SELECT 
    tb_almacen.IdAlma,
    tb_almacen.IdProd,
    tb_producto.NombreProducto,
    tb_categoriaprod.NombreCategoria,
    tb_producto.Unidad,
    tb_almacen.CantidadTotal,
    tb_producto.Precio
  FROM 
    $table
  INNER JOIN 
    tb_producto ON tb_almacen.IdProd = tb_producto.IdProd
  INNER JOIN 
    tb_categoriaprod ON tb_producto.IdCate = tb_categoriaprod.IdCate
  ORDER BY 
    GREATEST(CONCAT(tb_almacen.DateCreate, ' ', tb_almacen.HoraCreate), CONCAT(tb_almacen.DateUpdate, ' ', tb_almacen.HoraUpdate)) DESC");
    $statement->execute();
    return $statement->fetchAll();
  }

    //   Ajax que devuelve  los productos a agregar en la lista
    public static function mdlGetProductDataAjx($table, $codProductAdd)
    {
        $statement = Conexion::conn()->prepare("SELECT tb_producto.IdProd, tb_producto.NombreProducto, tb_producto.Unidad FROM $table WHERE IdProd = $codProductAdd");
        $statement->execute();
        return $statement->fetch();
    }
    /* fin */

     /* funcion de controlador que toma el json de newIngJs */
public static function mdlCreateIngresoLoteAjx($table, $dataCreate)
{
    $statement = Conexion::conn()->prepare("INSERT INTO $table (IdPer, CodigoLote, DescripcionLote, DatosLoteIngresoJson, FechaProduccionLote, FechaVencimientoLote, Estado, DateCreate, DateUpdate) VALUES(:IdPer, :CodigoLote, :DescripcionLote, :DatosLoteIngresoJson, :FechaProduccionLote, :FechaVencimientoLote, :Estado, :DateCreate, :DateUpdate)");

    $statement->bindParam(":IdPer", $dataCreate["IdPer"], PDO::PARAM_INT);
    $statement->bindParam(":CodigoLote", $dataCreate["CodigoLote"], PDO::PARAM_STR);
    $statement->bindParam(":DescripcionLote", $dataCreate["DescripcionLote"], PDO::PARAM_STR);
    $statement->bindParam(":DatosLoteIngresoJson", $dataCreate["DatosLoteIngresoJson"], PDO::PARAM_STR);
    $statement->bindParam(":FechaProduccionLote", $dataCreate["FechaProduccionLote"], PDO::PARAM_STR);
    $statement->bindParam(":FechaVencimientoLote", $dataCreate["FechaVencimientoLote"], PDO::PARAM_STR);
    $statement->bindParam(":Estado", $dataCreate["Estado"], PDO::PARAM_INT);
    $statement->bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataCreate["DateUpdate"], PDO::PARAM_STR);

    if ($statement->execute()) {
        return "ok";
    } else {
        return "error";
    }
}

  /* fin */
}