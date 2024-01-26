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
}

//  Show product data edit
if(isset($_POST["codProduct"])){
    $edit = new ProductAjax();
    $edit -> codProduct = $_POST["codProduct"];
    $edit -> ajaxEditProduct();
}