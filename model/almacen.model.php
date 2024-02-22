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
  public static function mdlGetHistorialProduct($table, $codProduct)
  {
    $stmt = Conexion::conn()->prepare("SELECT COUNT(IdProd) as cantidad FROM $table WHERE IdProd = :IdProd");
    $stmt->bindParam(":IdProd", $codProduct, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
  }

  //  Report donwload excel Almacen
  public static function mdlGetAllDowlReprtAlmacen($table)
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
  /* fin */

  //  Obtener el producto por el codigo del producto para editar una nota de pedido
  public static function mdlGerProductDataById($table, $codProduct)
  {
    $stmt = Conexion::conn()->prepare("SELECT
    tb_almacen.CantidadTotal, 
    tb_producto.NombreProducto
  FROM
    $table
    INNER JOIN
    tb_producto
    ON 
      tb_almacen.IdProd = tb_producto.IdProd
  WHERE
    tb_almacen.IdProd = $codProduct");
      $stmt->execute();
      return $stmt->fetch();
  }

  //  Actualizar el almacén de la merma
  public static function mdlUpdateStockAlmacenMerma($table, $dataCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (IdProducto, IdSalida, Cantidad, TipoSalida, DateCreate, DateUpdate) VALUES (:IdProducto, :IdSalida, :Cantidad, :TipoSalida, :DateCreate, :DateUpdate)");

    $statement->bindParam(":IdProducto", $dataCreate["IdProducto"], PDO::PARAM_STR);
    $statement->bindParam(":IdSalida", $dataCreate["IdSalida"], PDO::PARAM_STR);
    $statement->bindParam(":Cantidad", $dataCreate["Cantidad"], PDO::PARAM_STR);
    $statement->bindParam(":TipoSalida", $dataCreate["TipoSalida"], PDO::PARAM_STR);
    $statement->bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataCreate["DateUpdate"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
 
  //  Mostrar todas las mermas
  public static function mdlGetAllMerma($table)
  {
    $statement = Conexion::conn()->prepare("SELECT
    tb_producto.NombreProducto, 
    tb_producto.Unidad, 
    tb_almacen_merma.Cantidad, 
    tb_almacen_merma.TipoSalida,  
    tb_ingreso.FechaProduccionIng, 
    tb_almacen_merma.IdIngresoDev, 
    tb_almacen_merma.IdSalida
  FROM
    $table
    INNER JOIN
    tb_producto
    ON 
      tb_almacen_merma.IdProducto = tb_producto.IdProd
    INNER JOIN
    tb_categoriaprod
    ON 
      tb_producto.IdCate = tb_categoriaprod.IdCate
    INNER JOIN
    tb_ingreso
    ON 
      tb_almacen_merma.IdIngresoDev = tb_ingreso.IdIng
  ORDER BY
    tb_almacen_merma.IdAlmacenMerma DESC");
    $statement->execute();
    return $statement->fetchAll();
  }
}