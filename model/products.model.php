<?php

require_once "conexion.php";

class ProductsModel
{
  // Mostrar todos los productos
  public static function mdlGetAllProducts($table)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_producto.IdProd, tb_producto.NombreProducto, tb_producto.DetalleProducto, tb_producto.IdCate, tb_producto.Unidad, tb_producto.Cantidad, tb_producto.Precio, tb_producto.DateCreate, tb_producto.DateUpdate, tb_categoriaprod.NombreCategoria FROM $table INNER JOIN tb_categoriaprod ON tb_producto.IdCate = tb_categoriaprod.IdCate ORDER BY IdProd DESC");
    $statement->execute();
    return $statement->fetchAll();
  }

  //  Show all materials
  public static function mdlGetListMaterials($table)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_material.IdMaterial, tb_material.DescriptionMaterial, tb_material.UnityMaterial FROM $table ORDER BY IdMaterial DESC");
    $statement->execute();
    return $statement->fetchAll();
  }

  // Mostrar todas las categorías de productos
  public static function mdlGetAllCategories($table)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_categoriaprod.IdCate, tb_categoriaprod.NombreCategoria FROM $table ORDER BY IdCate DESC");
    $statement->execute();
    return $statement->fetchAll();
  }

  // Crear nuevo producto
  public static function mdlCreateProduct($table, $dataCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (IdCate, NombreProducto, DetalleProducto, Unidad, Cantidad, Precio, DateCreate, DateUpdate) VALUES(:IdCate, :NombreProducto, :DetalleProducto, :Unidad, :Cantidad, :Precio, :DateCreate, :DateUpdate)");
    $statement->bindParam(":IdCate", $dataCreate["IdCate"], PDO::PARAM_INT);
    $statement->bindParam(":NombreProducto", $dataCreate["NombreProducto"], PDO::PARAM_STR);
    $statement->bindParam(":DetalleProducto", $dataCreate["DetalleProducto"], PDO::PARAM_STR);
    $statement->bindParam(":Unidad", $dataCreate["Unidad"], PDO::PARAM_STR);
    $statement->bindParam(":Cantidad", $dataCreate["Cantidad"], PDO::PARAM_INT);
    $statement->bindParam(":Precio", $dataCreate["Precio"], PDO::PARAM_STR);
    $statement->bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataCreate["DateUpdate"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  // Obtener datos del producto para editar
  public static function mdlGetProductDataEdit($table, $codProduct)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_producto.IdProd, tb_producto.IdCate, tb_producto.NombreProducto, tb_producto.DetalleProducto, tb_producto.Unidad, tb_producto.Cantidad, tb_producto.Precio, tb_categoriaprod.NombreCategoria FROM $table INNER JOIN tb_categoriaprod ON tb_producto.IdCate = tb_categoriaprod.IdCate WHERE tb_producto.IdProd = :IdProd");
    $statement->bindParam(":IdProd", $codProduct, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch();
  }


  // Editar un producto específico
  public static function mdlEditProduct($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET IdCate=:IdCate, NombreProducto=:NombreProducto, DetalleProducto=:DetalleProducto, Unidad=:Unidad, Cantidad=:Cantidad, Precio=:Precio, DateUpdate=:DateUpdate WHERE IdProd=:IdProd");
    $statement->bindParam(":IdCate", $dataUpdate["IdCate"], PDO::PARAM_INT);
    $statement->bindParam(":NombreProducto", $dataUpdate["NombreProducto"], PDO::PARAM_STR);
    $statement->bindParam(":DetalleProducto", $dataUpdate["DetalleProducto"], PDO::PARAM_STR);
    $statement->bindParam(":Unidad", $dataUpdate["Unidad"], PDO::PARAM_STR);
    $statement->bindParam(":Cantidad", $dataUpdate["Cantidad"], PDO::PARAM_INT);
    $statement->bindParam(":Precio", $dataUpdate["Precio"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":IdProd", $dataUpdate["IdProd"], PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Borrar un producto específico
  public static function mdlDeleteProduct($table, $codProduct)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $table WHERE IdProd = $codProduct");
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }


  //  Get Material data
  public static function mdlGetMaterialData($table, $codMaterial)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_material.IdMaterial, tb_material.DescriptionMaterial, tb_material.UnityMaterial FROM $table WHERE IdMaterial = $codMaterial");
    $statement -> execute();
    return $statement -> fetch();
  }
}
