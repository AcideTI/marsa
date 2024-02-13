<?php
require_once "../controller/products.controller.php";
require_once "../model/products.model.php";

class ProductAjax
{
  //  Show product data edit
  public $codProduct;
  public function ajaxEditProduct()
  {
    $codProduct = $this->codProduct;
    $response = ProductsController::ctrGetProductDataEdit($codProduct);
    echo json_encode($response);
  }

  //  Show categoria data edit
  public $codCategoria;
  public function ajaxEditCategoria()
  {
    $codCategoria = $this->codCategoria;
    $response = ProductsController::ctrGetCategoriaDataEdit($codCategoria);
    echo json_encode($response);
  }
}

//  Show product data edit
if(isset($_POST["codProduct"])){
    $edit = new ProductAjax();
    $edit -> codProduct = $_POST["codProduct"];
    $edit -> ajaxEditProduct();
}

//  Show categoria data edit
if(isset($_POST["codCategoria"])){
    $edit = new ProductAjax();
    $edit -> codCategoria = $_POST["codCategoria"];
    $edit -> ajaxEditCategoria();
}