<?php

require_once "conexion.php";

class ProductsModel
{
  // Mostrar todos los productos
  public static function mdlGetAllProducts($table)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_producto.IdProd, tb_producto.NombreProducto, tb_producto.DetalleProducto, tb_producto.IdCate, tb_producto.Unidad, tb_producto.Precio, tb_producto.DateUpdate, tb_categoriaprod.NombreCategoria FROM $table INNER JOIN tb_categoriaprod ON tb_producto.IdCate = tb_categoriaprod.IdCate ORDER BY IdProd DESC");
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

  // Mostrar todas las categorías de productos
  public static function mdlGetAllCategoriesView($table)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_categoriaprod.IdCate, tb_categoriaprod.NombreCategoria, tb_categoriaprod.DateUpdate FROM $table");
    $statement->execute();
    return $statement->fetchAll();
  }

  // Crear nuevo producto
  public static function mdlCreateProduct($table, $dataCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (IdCate, NombreProducto, DetalleProducto, Unidad, Precio, DateCreate, DateUpdate) VALUES(:IdCate, :NombreProducto, :DetalleProducto, :Unidad, :Precio, :DateCreate, :DateUpdate)");
    $statement->bindParam(":IdCate", $dataCreate["IdCate"], PDO::PARAM_INT);
    $statement->bindParam(":NombreProducto", $dataCreate["NombreProducto"], PDO::PARAM_STR);
    $statement->bindParam(":DetalleProducto", $dataCreate["DetalleProducto"], PDO::PARAM_STR);
    $statement->bindParam(":Unidad", $dataCreate["Unidad"], PDO::PARAM_STR);
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
    $statement = Conexion::conn()->prepare("SELECT tb_producto.IdProd, tb_producto.IdCate, tb_producto.NombreProducto, tb_producto.DetalleProducto, tb_producto.Unidad, tb_producto.Precio, tb_categoriaprod.NombreCategoria FROM $table INNER JOIN tb_categoriaprod ON tb_producto.IdCate = tb_categoriaprod.IdCate WHERE tb_producto.IdProd = :IdProd");
    $statement->bindParam(":IdProd", $codProduct, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch();
  }


  // Editar un producto específico
  public static function mdlEditProduct($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET IdCate=:IdCate, NombreProducto=:NombreProducto, DetalleProducto=:DetalleProducto, Unidad=:Unidad, Precio=:Precio, DateUpdate=:DateUpdate WHERE IdProd=:IdProd");
    $statement->bindParam(":IdCate", $dataUpdate["IdCate"], PDO::PARAM_INT);
    $statement->bindParam(":NombreProducto", $dataUpdate["NombreProducto"], PDO::PARAM_STR);
    $statement->bindParam(":DetalleProducto", $dataUpdate["DetalleProducto"], PDO::PARAM_STR);
    $statement->bindParam(":Unidad", $dataUpdate["Unidad"], PDO::PARAM_STR);
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

  //Crear una nueva categoria
  public static function mdlCreateCategoria($table, $dataCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (NombreCategoria, DateCreate, DateUpdate) VALUES(:NombreCategoria, :DateCreate, :DateUpdate)");
    $statement->bindParam(":NombreCategoria", $dataCreate["NombreCategoria"], PDO::PARAM_STR);
    $statement->bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataCreate["DateUpdate"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Editar categoria
  public static function mdlEditCategoria($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET NombreCategoria=:NombreCategoria, DateUpdate=:DateUpdate WHERE IdCate=:IdCate");
    $statement->bindParam(":NombreCategoria", $dataUpdate["NombreCategoria"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":IdCate", $dataUpdate["IdCate"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener la cantidad de veces que se uso el id de la categoria
  public static function mdlGetHistorialCategoria($table, $codCategoria)
  {
    $statement = Conexion::conn()->prepare("SELECT COUNT(IdCate) as cantidad FROM $table WHERE IdCate = :IdCate");
    $statement->bindParam(":IdCate", $codCategoria, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch();
  }

  //  Obtener data de una categoria
  public static function mdlGetCategoriaDataEdit($table, $codCategoria)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_categoriaprod.IdCate, tb_categoriaprod.NombreCategoria FROM $table WHERE IdCate = :IdCate");
    $statement->bindParam(":IdCate", $codCategoria, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch();
  }

  //  Eliminar categoria
  public static function mdlDeleteCategoria($table, $codCategoria)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $table WHERE IdCate = $codCategoria");
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}
