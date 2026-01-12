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

  // Obtener clientes paginados para DataTables
  public function ajaxGetClientsPaginated()
  {
    $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
    $orderColumn = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
    $orderDir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'desc';

    $response = ClientsController::ctrGetClientsPaginated($draw, $start, $length, $searchValue, $orderColumn, $orderDir);
    echo json_encode($response);
  }
}

//  Show client edit
if (isset($_POST["codClient"])) {
  $edit = new ClientsAjax();
  $edit->codClient = $_POST["codClient"];
  $edit->ajaxEditClient();
}

// Obtener clientes paginados
if (isset($_POST["getClientsPaginated"])) {
  $paginated = new ClientsAjax();
  $paginated->ajaxGetClientsPaginated();
}