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
      
      $codProduct = $_GET["codProduct"];
//  Verificar si el producto está dentro de la tabla almacén, si es así no se puede eliminar -> Solo almacén 
      $historial = AlmacenController::mdlGetHistorialProduct($codProduct);

      if($historial["cantidad"] > 0) {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al tratar de eliminar un producto que ya tiene movimientos en el sistema', 'products');
      } else {
        $table = "tb_producto";
      $response = ProductsModel::mdlDeleteProduct($table, $codProduct);
      if ($response == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Producto eliminado correctamente', 'products');
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al tratar de eliminar un producto', 'products');
      }
}

      echo $message;
    }
  }

  //  Listar Categorias de los productos
  public static function ctrGetAllCategoriesView()
  {
    $table = "tb_categoriaprod";
    $listCategories = ProductsModel::mdlGetAllCategoriesView($table);
    return $listCategories;
  }

  //  Crear nueva cateoria
  public static function ctrCreateCategoria()
  {
    if (isset($_POST["descripcionCategoria"])) {
      $table = "tb_categoriaprod";
      $dataCreate = array(
        "NombreCategoria" => $_POST["descripcionCategoria"],
        "DateCreate" => date("Y-m-d\TH:i:sP"),
        "DateUpdate" => date("Y-m-d\TH:i:sP")
      );
      $response = ProductsModel::mdlCreateCategoria($table, $dataCreate);
      if ($response == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Categoria Creada Correctamente', 'categorias');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Crear la Categoria', 'categorias');
        echo $message;
      }
    }
  }

  //  Editar una categoria
  public static function ctrEditCategoria()
  {
    if (isset($_POST["editDescripcionCategoria"]) && isset($_POST["codCategoriaEdit"])) {
      $table = "tb_categoriaprod";
    $dataUpdate = array(
        "IdCate" => $_POST["codCategoriaEdit"],
        "NombreCategoria" => $_POST["editDescripcionCategoria"],
        "DateUpdate" => date("Y-m-d\TH:i:sP")
      );
      $response = ProductsModel::mdlEditCategoria($table, $dataUpdate);
      if ($response == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Categoria Editada Correctamente', 'categorias');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Editar la Categoria', 'categorias');
        echo $message;
      }
    }
  }

  //  Obtener data de una categoria
  public static function ctrGetCategoriaDataEdit($codCategoria)
  {
    $table = "tb_categoriaprod";
    $data = ProductsModel::mdlGetCategoriaDataEdit($table, $codCategoria);
    return $data;
  }

  //  Delete Categoria
  public static function ctrDeleteCategoria()
  {
    if (isset($_GET["codCategoria"])) {
      $table = "tb_producto";
      $codCategoria = $_GET["codCategoria"];
      $historial = ProductsModel::mdlGetHistorialCategoria($table, $codCategoria);

      //  Si la categoria ya se asigno a un producto no se puede eliminar
      if ($historial["cantidad"] > 0) {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al tratar de eliminar una categoria que ya se asigno a un producto', 'categorias');
      } else {
        $table = "tb_categoriaprod";
        $response = ProductsModel::mdlDeleteCategoria($table, $codCategoria);
        if ($response == "ok") {
          $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Categoria eliminada correctamente', 'categorias');
        } else {
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al tratar de eliminar una categoria', 'categorias');
        }
      }
      echo $message;
    }
  }
}
