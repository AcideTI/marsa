<?php
require_once "../controller/personal.controller.php";
require_once "../model/personal.model.php";

class PersonalAjax
{
  // Mostrar datos del personal
  public $codPersonal;
  public function ajaxEditPersonal()
  {
    $codPersonal = $this->codPersonal;
    $response = PersonalController::ctrGetPersonalDataEdit($codPersonal);
    echo json_encode($response);
  }
}

// Mostrar datos del personal
if(isset($_POST["codPersonal"])){
  $edit = new PersonalAjax();
  $edit -> codPersonal = $_POST["codPersonal"];
  $edit -> ajaxEditPersonal();
}