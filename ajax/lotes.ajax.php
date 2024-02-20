<?php

require_once "../controller/lotes.controller.php";
require_once "../model/lotes.model.php";
require_once "../controller/almacen.controller.php";
require_once "../model/almacen.model.php";
require_once "../controller/products.controller.php";
require_once "../model/products.model.php";
require_once "../controller/functions.controller.php";
//productos para gregar ala lista de formulario de lotes
class AjaxLotes
{
  public $codProductAdd;
  public function ajaxAddMaterialInside()
  {
    $codProductAdd = $this->codProductAdd;
    $respuesta = LotesController::ctrGetProductDataAjx($codProductAdd);
    echo json_encode($respuesta);
  }

  //  Mostrar los datos de los lotes verSalidas
  public $codFiltroLotes;
  public function ajaxMostrarTablaLotes()
  {
    $codFiltroLotes = $this->codFiltroLotes;
    $respuesta = LotesController::ctrGetAllLotes();
    foreach ($respuesta as &$lote) {
      $lote['Buttons'] = FunctionsController::ctrGetButtonsLotes($lote["Estado"], $lote["IdLote"]);
      $lote['StateLote'] = FunctionsController::ctrGetStatesLotes($lote["Estado"]);
    }
    echo json_encode($respuesta);
  }

  //  Mostrar los datos de los lotes verSalidas
  public $codLoteMostrarData;
  public function ajaxMostrarDataLote()
  {
    $codLoteMostrarData = $this->codLoteMostrarData;
    $respuesta = LotesController::ctrGetDataLote($codLoteMostrarData);
    echo json_encode($respuesta);
  }  

  //  Editar Lote
  public $editLote;
  public function EditIngresoLoteAjax()
  {
    $editLote = $this->editLote;
    $response = LotesController::ctrEditIngresoLoteAjx($editLote);
    echo json_encode($response);
  }
}

//  Add material to a list
if (isset($_POST["codProductAdd"])) {
  $addMaterialInside = new AjaxLotes();
  $addMaterialInside->codProductAdd = $_POST["codProductAdd"];
  $addMaterialInside->ajaxAddMaterialInside();
}

//  Mostrar los datos de los lotes verSalidas
if (isset($_POST["codFiltroLotes"])) {
  $mostrarLotes = new AjaxLotes();
  $mostrarLotes->codFiltroLotes = $_POST["codFiltroLotes"];
  $mostrarLotes->ajaxMostrarTablaLotes();
}

//  Mostrar los datos de los lotes verSalidas
if (isset($_POST["codLoteMostrarData"])) {
  $mostrarDataLote = new AjaxLotes();
  $mostrarDataLote->codLoteMostrarData = $_POST["codLoteMostrarData"];
  $mostrarDataLote->ajaxMostrarDataLote();
}

if (isset($_POST["editLote"])) {
  $jsonOriginData = new AjaxLotes();
  $jsonOriginData->editLote = $_POST["editLote"];
  $jsonOriginData->EditIngresoLoteAjax();
}

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

/* crear lote por json */