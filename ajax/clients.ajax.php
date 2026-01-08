<?php

require_once "../controller/clients.controller.php";
require_once "../model/clients.model.php";


class ClientsAjax
{
  //  Show client data
  public $codClient;
  public function ajaxEditClient()
  {
    $codClient = $this->codClient;
    $response = ClientsController::ctrGetClientDataEdit($codClient);
    echo json_encode($response);
  }

}

//  Show clint edit
if(isset($_POST["codClient"])){
	$edit = new ClientsAjax();
	$edit -> codClient = $_POST["codClient"];
	$edit -> ajaxEditClient();
}