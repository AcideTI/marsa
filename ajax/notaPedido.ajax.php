<?php

require_once "../controller/notaPedido.controller.php";
require_once "../model/notaPedido.model.php";

class notaPedidoAjax
{
  /* // Agrega los productos al modal de la vista  */
  public $codProductAdd;
  public function ajaxAddProdModalSa()
  {
    $codProductAdd = $this->codProductAdd;
    $respuesta = NotaPedidoController::ctrGetProductDataAjx($codProductAdd);
    echo json_encode($respuesta);
  }

}

// Agrega los productos al modal de la vista 
if(isset($_POST["codProductAdd"])){
  $addProdModalSa = new notaPedidoAjax();
  $addProdModalSa -> codProductAdd = $_POST["codProductAdd"];
  $addProdModalSa -> ajaxAddProdModalSa();
}

/* fin */

/* mostrar detalles complentarios de nota de pedido por el boton */
class DetallesNotaPedAjax
{
  public $codDetNotPeData;
  public function ajaxGetProductData()
  {
    $codDetNotPeData = $this->codDetNotPeData;
    $response = NotaPedidoController::ctrGetDetallNotPeData($codDetNotPeData);
    echo json_encode($response);
  }
}

//  Show  detalles de la nota de pedido
if(isset($_POST["codDetNotPeData"])){
	$getProductData = new DetallesNotaPedAjax();
	$getProductData -> codDetNotPeData = $_POST["codDetNotPeData"];
	$getProductData -> ajaxGetProductData();
}
/* fin */

/* funcion Editar para mostrar detalles de nota de pedido por el boton  */
class EditNotaPedAjax
{
  public $codEditNotPeData;
  public function ajaxGetProductEditData()
  {
    $codEditNotPeData = $this->codEditNotPeData;
    $response = NotaPedidoController::ctrGetEditNotPeData($codEditNotPeData);
    echo json_encode($response);
  }
}

//  Show  detalles de la nota de pedido
if(isset($_POST["codEditNotPeData"])){
	$getProductData = new EditNotaPedAjax();
	$getProductData -> codEditNotPeData = $_POST["codEditNotPeData"];
	$getProductData -> ajaxGetProductEditData();
}

/* fin */