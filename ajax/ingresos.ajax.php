<?php

require_once "../controller/ingresos.controller.php";
require_once "../model/ingresos.model.php";
require_once "../controller/almacen.controller.php";
require_once "../model/almacen.model.php";


class AjaxMaterials
{
  public $codProductAdd;
  public function ajaxAddMaterialInside()
  {
    $codProductAdd = $this->codProductAdd;
    $respuesta = IngresosController::ctrGetProductDataAjx($codProductAdd);
    echo json_encode($respuesta);
  }

  
}

//  Add material to a list
if(isset($_POST["codProductAdd"])){
  $addMaterialInside = new AjaxMaterials();
  $addMaterialInside -> codProductAdd = $_POST["codProductAdd"];
  $addMaterialInside -> ajaxAddMaterialInside();
}
/* fin */



/* crear ingreso por json */

class NewIngresoAjax
{
  public $newIngJs;

  public function ajaxCreateIngresoNuevo()
  {
    
    $newIngJs = $this->newIngJs;
    $response = IngresosController::ctrCreateIngresoNuevoAjx($newIngJs);
    echo json_encode($response);
  }
}

// Crear Ingreso
if(isset($_POST["newIngJs"])){
  $jsonOriginData = new NewIngresoAjax();
  $jsonOriginData -> newIngJs = $_POST["newIngJs"];
  $jsonOriginData -> ajaxCreateIngresoNuevo();
}
/* fin */
