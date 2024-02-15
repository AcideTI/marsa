<?php

require_once "../controller/lotes.controller.php";
require_once "../model/lotes.model.php";
require_once "../controller/almacen.controller.php";
require_once "../model/almacen.model.php";

//productos para gregar ala lista de formulario de lotes
class AjaxMaterials
{
    public $codProductAdd;
    public function ajaxAddMaterialInside()
    {
        $codProductAdd = $this->codProductAdd;
        $respuesta = LotesController::ctrGetProductDataAjx($codProductAdd);
        echo json_encode($respuesta);
    }
}

//  Add material to a list
if (isset($_POST["codProductAdd"])) {
    $addMaterialInside = new AjaxMaterials();
    $addMaterialInside->codProductAdd = $_POST["codProductAdd"];
    $addMaterialInside->ajaxAddMaterialInside();
}
/* fin */

/* crear lote por json */

class NewIngresoLoteAjax
{
    public $newIngLote;

    public function NewCreateIngresoLoteAjax()
    {

        $newIngLote = $this->newIngLote;
        $response = LotesController::ctrCreateIngresoLoteAjx($newIngLote);
        echo json_encode($response);
    }
}

// Crear Ingreso
if (isset($_POST["newIngLote"])) {
    $jsonOriginData = new NewIngresoLoteAjax();
    $jsonOriginData->newIngLote = $_POST["newIngLote"];
    $jsonOriginData->NewCreateIngresoLoteAjax();
}
/* fin */

/* funcion Editar para mostrar detalles de nota de pedido por el boton  */
class EditLoteAjax
{
  public $codLoteEdit;
  public function ajaxGetProductEditData()
  {
    $codLoteEdit = $this->codLoteEdit;
    $response = LotesController::ctrGetEditLoteData($codLoteEdit);
    echo json_encode($response);
  }
}

//  Show  detalles de la nota de pedido
if(isset($_POST["codLoteEdit"])){
	$getProductData = new EditLoteAjax();
	$getProductData -> codLoteEdit = $_POST["codLoteEdit"];
	$getProductData -> ajaxGetProductEditData();
}

/* fin */

/* crear lote por json */

class NewEditarLoteAjax
{
    public $editLote;

    public function EditIngresoLoteAjax()
    {

        $editLote = $this->editLote;
        $response = LotesController::ctrEditIngresoLoteAjx($editLote);
        echo json_encode($response);
    }
}

// Crear Ingreso
if (isset($_POST["editLote"])) {
    $jsonOriginData = new NewEditarLoteAjax();
    $jsonOriginData->editLote = $_POST["editLote"];
    $jsonOriginData->EditIngresoLoteAjax();
}
/* fin */
