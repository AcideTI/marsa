<?php

class FunctionsController
{
  //  Message alert
  public static function ctrShowAlert($type, $title, $message, $rute)
  {
    $alert =
      '<script>
        Swal.fire({
          icon: "' . $type . '",
          title: "' . $title . '",
          text: "' . $message . '",
        }).then(function(result){
          if(result.value){
            window.location = "' . $rute . '";
          }
        });
      </script>';
    return $alert;
  }

  //  Buttons of movements in inside
  public static function ctrGetButtonsMovements($idMovement, $stateMovement, $idTypeMovement, $idProvider)
  {
    $editMovementIC = "";
    $state = "";

    if ($idTypeMovement == '1' && $stateMovement == '1') {
      $editMovementIC = 'btnEditInsideIC';
      $state = '';
    }
    if ($idTypeMovement == '1' && $stateMovement == '2') {
      $editMovementIC = 'btnEditInsideIC';
      $state = 'disabled';
    }
    if ($idTypeMovement == '2' && $stateMovement == '1') {
      $editMovementIC = 'btnEditInsideIV';
      $state = '';
    }
    if ($idTypeMovement == '2' && $stateMovement == '2') {
      $editMovementIC = 'btnEditInsideIV';
      $state = 'disabled';
    }
    $buttons = '
      <button class="btn btn-warning ' . $editMovementIC . ' " codMovement="' . $idMovement . '" ' . $state . '><i class="fa-solid fa-pencil"></i></button>
      <button class="btn btn-info btnUpdateStock" codMovement="' . $idMovement . '" ' . $state . '><i class="fa-solid fa-circle-check"></i></button>
      <button class="btn btn-danger btnDeleteInside" codMovement="' . $idMovement . '" codProvider="' . $idProvider . '" ' . $state . '><i class="fa-solid fa-trash"></i></button>
    ';
    return $buttons;
  }

  //  Buttons of orders
  public static function ctrGetButtonsOrders($idOrder, $stateOrder)
  {
    $stateEdit = "";
    $stateUpdate = "";
    $stateDelete = "";
    $stateNull = "";
    $btnEdit = "";

    if ($stateOrder == '1') {
      $stateEdit = "";
      $stateUpdate = "";
      $stateDelete = "";
      $stateNull = "";
      $btnEdit = "btnEditOrder";
    }
    if ($stateOrder == '2') {
      $stateEdit = "";
      $stateUpdate = "";
      $stateDelete = "disabled";
      $stateNull = "";
      $btnEdit = "btnEditOrderApproved";
    }
    if ($stateOrder == '3' || $stateOrder == '4') {
      $stateEdit = "disabled";
      $stateUpdate = "disabled";
      $stateDelete = "disabled";
      $stateNull = "disabled";
    }
    $buttons = '
      <button class="btn btn-success btnPrintOrder" codOrder="' . $idOrder . '" ><i class="fa-solid fa-print"></i></button>
      <button class="btn btn-warning ' . $btnEdit . '" codOrder="' . $idOrder . '" ' . $stateEdit . '><i class="fa-solid fa-pencil"></i></button>
      <button class="btn btn-secondary btnUpdateOrder" codOrder="' . $idOrder . '" ' . $stateUpdate . '><i class="fa-solid fa-circle-check"></i></button>
      <button class="btn btn-danger btnDeleteOrder" codOrder="' . $idOrder . '" ' . $stateDelete . '><i class="fa-solid fa-trash"></i></button>
      <button class="btn btn-light btnNullOrder" codOrder="' . $idOrder . '" ' . $stateNull . '><i class="fa-solid fa-ban"></i></button>
    ';
    return $buttons;
  }

  //  For states of inside movements
  public static function ctrGetStateInsides($stateValue)
  {
    if ($stateValue == 1) {
      $state = '<span class="badge rounded-pill bg-warning">Registrado</span>';
    }
    if ($stateValue == 2) {
      $state = '<span class="badge rounded-pill bg-success">Autorizado</span>';
    }
    return $state;
  }

  //  States of orders
  public static function ctrGetStateOrders($stateValue)
  {
    if ($stateValue == 1) {
      $state = '<span class="badge rounded-pill bg-info">Registrado</span>';
    }
    if ($stateValue == 2) {
      $state = '<span class="badge rounded-pill bg-warning">Aprobado</span>';
    }
    if ($stateValue == 3) {
      $state = '<span class="badge rounded-pill bg-success">Finalizado</span>';
    }
    if ($stateValue == 4) {
      $state = '<span class="badge rounded-pill bg-danger">Anulado</span>';
    }
    return $state;
  }

  //  Get makers select
  public static function ctrGetMakersSelect($IdMaker, $FirstName, $LastName)
  {
    $listMakers = MakersController::ctrGetMakersOrder();
    $options = "";
    foreach($listMakers as $value) {
      $options .= '<option value="' . $value["IdMaker"] . '">' . $value["FirstNameMaker"] . ' '.$value["LastNameMaker"].'</option>';
    }
    
    if($IdMaker != null || $IdMaker != "") {
      $select = '
      <select class="form-control input-lg makerProduct" id="makerProduct" name="makerProduct">
        <option value="'.$IdMaker.'">'.$FirstName.' '.$LastName.'</option>
        '.$options.'
      </select>
      ';
    } else {
      $select = '
      <select class="form-control input-lg makerProduct" id="makerProduct" name="makerProduct">
        <option value="">Seleccionar Confeccionista</option>
        '.$options.'
      </select>
      ';
    }
    return $select;
  }

  //  Get state products
  public static function ctrGetProductsStates($StateProduct)
  {
    if ($StateProduct == 1) {
      $state = '<span class="badge rounded-pill bg-info">Registrado</span>';
    }
    if ($StateProduct == 2) {
      $state = '<span class="badge rounded-pill bg-warning">En confección</span>';
    }
    if ($StateProduct == 3) {
      $state = '<span class="badge rounded-pill bg-success">Finalizado</span>';
    }
    if ($StateProduct == 4) {
      $state = '<span class="badge rounded-pill bg-danger">Anulado</span></span>';
    }
    return $state;
  }
}
