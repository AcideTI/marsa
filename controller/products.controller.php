<?php
date_default_timezone_set('America/Bogota');

class ProductsController
{
  // Mostrar todos los productos
  public static function ctrGetAllProducts()
  {
    $table = "tb_producto";
    $listProducts = ProductsModel::mdlGetAllProducts($table);
    return $listProducts;
  }
  //  Get list of materials to IC
  public static function ctrGetListMaterials()
  {
    $table = "tb_material";
    $listMaterials = MaterialsModel::mdlGetListMaterials($table);
    return $listMaterials;
  }

  // Mostrar todas las categorías de productos
  public static function ctrGetAllCategories()
  {
    $table = "tb_categoriaprod";
    $listCategories = ProductsModel::mdlGetAllCategories($table);
    return $listCategories;
  }

  // Crear nuevo producto
  public static function ctrCreateProduct()
  {
    if (isset($_POST["productName"]) && isset($_POST["productCategory"])) {
      $table = "tb_producto";
      $dataCreate = array(
        "IdCate" => $_POST["productCategory"],
        "NombreProducto" => $_POST["productName"],
        "DetalleProducto" => $_POST["productDetail"],
        "Unidad" => $_POST["productUnit"],
        "Cantidad" => $_POST["productQuantity"],
        "Precio" => $_POST["productPrice"],
        "DateCreate" => date("Y-m-d\TH:i:sP"),
        "DateUpdate" => date("Y-m-d\TH:i:sP")
      );
      $response = ProductsModel::mdlCreateProduct($table, $dataCreate);
      if ($response == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Producto Creado Correctamente', 'products');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Crear el Producto', 'products');
        echo $message;
      }
    }
  }


  // Obtener datos para editar
  public static function ctrGetProductDataEdit($codProduct)
  {
    $table = 'tb_producto';
    $productData = ProductsModel::mdlGetProductDataEdit($table, $codProduct);
    return $productData;
  }

  // Editar un producto específico
  public static function ctrEditProduct()
  {
    if (isset($_POST['editProductName']) && isset($_POST['editProductCategory'])) {
      $table = 'tb_producto';
      $dataUpdate = array(
        'IdProd' => $_POST['codProduct'],
        'IdCate' => $_POST['editProductCategory'],
        'NombreProducto' => $_POST['editProductName'],
        'DetalleProducto' => $_POST['editProductDetail'],
        'Unidad' => $_POST['editProductUnit'],
        'Cantidad' => $_POST['editProductQuantity'],
        'Precio' => $_POST['editProductPrice'],
        'DateUpdate' => date("Y-m-d\TH:i:sP"),
      );

      $response = ProductsModel::mdlEditProduct($table, $dataUpdate);
      if ($response == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Producto Editado Correctamente', 'products');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Editar el Producto', 'products');
        echo $message;
      }
    }
  }

  // Eliminar un producto
  public static function ctrDeleteProduct()
  {
    if (isset($_GET['codProduct'])) {
      $table = "tb_producto";
      $codProduct = $_GET["codProduct"];
      $response = ProductsModel::mdlDeleteProduct($table, $codProduct);
      if ($response == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Producto eliminado correctamente', 'products');
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al tratar de eliminar un producto', 'products');
      }
      echo $message;
    }
  }

  //  Get material data
  public static function ctrGetMaterialData($codMaterial)
  {
    $table = "tb_material";
    $data = MaterialsModel::mdlGetMaterialData($table, $codMaterial);
    return $data;
  }
}
