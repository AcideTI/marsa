<?php

require_once "conexion.php";

class AlmacenModel
{

  //  Mostrar productos y cantidades del almacen
  public static function mdlObtenerProductsIngDetl($table)
  {
    $statement = Conexion::conn()->prepare("SELECT 
      tb_almacen.IdAlma,
      tb_producto.NombreProducto,
      tb_categoriaprod.NombreCategoria,
      tb_producto.Unidad,
      tb_almacen.CantidadTotal
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
  
  

public static function mdlCreateAlmacen($tableAlmacen, $dataCreateAlmacen) {
  $statement = Conexion::conn()->prepare("INSERT INTO $tableAlmacen (IdIngDet, IdProd, CantidadTotal, FechaProduccion, FechaVencimiento, FechaReingreso, Estado, DateCreate, DateUpdate) VALUES (:IdIngDet, :IdProd, :CantidadTotal, :FechaProduccion, :FechaVencimiento, :FechaReingreso, :Estado, :DateCreate, :DateUpdate)");

  $statement->bindParam(":IdIngDet", $dataCreateAlmacen["IdIngDet"], PDO::PARAM_INT);
  $statement->bindParam(":IdProd", $dataCreateAlmacen["IdProd"], PDO::PARAM_STR);
  $statement->bindParam(":CantidadTotal", $dataCreateAlmacen["CantidadTotal"], PDO::PARAM_INT);
  $statement->bindParam(":FechaProduccion", $dataCreateAlmacen["FechaProduccion"], PDO::PARAM_STR);
  $statement->bindParam(":FechaVencimiento", $dataCreateAlmacen["FechaVencimiento"], PDO::PARAM_STR);
  $statement->bindParam(":FechaReingreso", $dataCreateAlmacen["FechaReingreso"], PDO::PARAM_STR);
  $statement->bindParam(":Estado", $dataCreateAlmacen["Estado"], PDO::PARAM_INT);
  $statement->bindParam(":DateCreate", $dataCreateAlmacen["DateCreate"], PDO::PARAM_STR);
  $statement->bindParam(":DateUpdate", $dataCreateAlmacen["DateUpdate"], PDO::PARAM_STR);

  if ($statement->execute()) {
    return "ok";
  } else {
    return "error";
  }
}
  ///////////////////////////////////////////////


  //  Obtener el producto por el codigo del producto
  public static function mdlObtenerStockGeneral($tabla, $valor)
  {
    $stmt = Conexion::conn()->prepare("SELECT
      tb_product.IdProduct, 
      tb_product.IdModel, 
      tb_product.IdOrder,
      tb_product.CodProduct, 
      CASE 
        WHEN tb_product.StateProduct = 1 THEN 'Registrado'
        WHEN tb_product.StateProduct = 2 THEN 'En confección'
        WHEN tb_product.StateProduct = 3 THEN 'Finalizado'
        WHEN tb_product.StateProduct = 4 THEN 'Anulado'
        ELSE 'Estado desconocido'
        END AS StateProduct,
      tb_orderdetail.IdMaker, 
      COALESCE(tb_maker.FirstNameMaker, 'Sin Asignar') AS FirstNameMaker,
      tb_maker.LastNameMaker, 
      tb_order.DateOrder, 
      tb_model.DescriptionModel
    FROM
      tb_product
      INNER JOIN
      tb_orderdetail
      ON 
          tb_product.IdProduct = tb_orderdetail.IdProduct
      INNER JOIN
      tb_model
      ON 
          tb_product.IdModel = tb_model.IdModel
      LEFT JOIN
      tb_maker
      ON 
          tb_orderdetail.IdMaker = tb_maker.IdMaker
      INNER JOIN
      tb_order
      ON 
          tb_orderdetail.IdOrder = tb_order.IdOrder
        WHERE 
      tb_product.CodProduct = '$valor' ");

    $stmt->execute();
    return $stmt->fetch();
  }



  //  Comprobar stock
  public static function mdlComprobarStock($tabla, $codProduct) {
    $stmt = Conexion::conn()->prepare("SELECT tb_almacen.IdAlma, tb_almacen.CantidadTotal FROM $tabla WHERE tb_almacen.IdProd = '$codProduct'");
    $stmt->execute();
    return $stmt->fetch();
  }

  // Crear stock almacen
  public static function mdlCrearStockAlmacen($tabla, $dataCreate) {
      $stmt = Conexion::conn()->prepare("INSERT INTO $tabla (IdProd, CantidadTotal, DateUpdate, DateCreate, HoraUpdate, HoraCreate) VALUES (:IdProd, :CantidadTotal, :DateUpdate, :DateCreate, :HoraUpdate, :HoraCreate)");

      $stmt->bindParam(":IdProd", $dataCreate["IdProd"], PDO::PARAM_STR);
      $stmt->bindParam(":CantidadTotal", $dataCreate["CantidadTotal"], PDO::PARAM_STR);
      $stmt->bindParam(":DateUpdate", $dataCreate["DateUpdate"], PDO::PARAM_STR);
      $stmt->bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);
      $stmt->bindParam(":HoraUpdate", $dataCreate["HoraUpdate"], PDO::PARAM_STR);
      $stmt->bindParam(":HoraCreate", $dataCreate["HoraCreate"], PDO::PARAM_STR);

      if ($stmt->execute()) {
        return "ok";
      } else {
        return "error";
      }
  }

  // Actualizar stock para sumar
  public static function mdlActualizarStockAlmacen($table, $dataUpdate) {
    $stmt = Conexion::conn()->prepare("UPDATE $table SET CantidadTotal = :CantidadTotal, DateUpdate = :DateUpdate, HoraUpdate = :HoraUpdate WHERE IdAlma = :IdAlma");

    $stmt->bindParam(":CantidadTotal", $dataUpdate["CantidadTotal"], PDO::PARAM_INT);
    $stmt->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $stmt->bindParam(":HoraUpdate", $dataUpdate["HoraUpdate"], PDO::PARAM_STR);
    $stmt->bindParam(":IdAlma", $dataUpdate["IdAlma"], PDO::PARAM_INT);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

    //  Comprobar stock para restar
    public static function mdlComprobarStockRes($tabla, $product) {
      $stmt = Conexion::conn()->prepare("SELECT tb_almacen.IdAlma, tb_almacen.CantidadTotal FROM $tabla WHERE tb_almacen.IdProd = '$product'");
      $stmt->execute();
      return $stmt->fetch();
    }
  
   // Actualizar stock para restar 
   public static function mdlUpdateStockAlmacenRes($table, $dataUpdate) {
    $stmt = Conexion::conn()->prepare("UPDATE $table SET CantidadTotal = :CantidadTotal, DateUpdate = :DateUpdate, HoraUpdate = :HoraUpdate WHERE IdAlma = :IdAlma");

    $stmt->bindParam(":CantidadTotal", $dataUpdate["CantidadTotal"], PDO::PARAM_INT);
    $stmt->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $stmt->bindParam(":HoraUpdate", $dataUpdate["HoraUpdate"], PDO::PARAM_STR);
    $stmt->bindParam(":IdAlma", $dataUpdate["IdAlma"], PDO::PARAM_INT);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

//  Verificar que un producto no tiene registro dentro del almacén
  public static function mdlGetHistorialProduct($table, $codProduct) {
    $stmt = Conexion::conn()->prepare("SELECT COUNT(IdProd) as cantidad FROM $table WHERE IdProd = :IdProd");
    $stmt->bindParam(":IdProd", $codProduct, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
  }
 
}