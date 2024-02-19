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

  //  Estado para las notas de pedido
  public static function ctrGetStateSalidas($stateValue)
  {
    if ($stateValue == 1) {
      $state = '<span class="badge rounded-pill bg-primary">Retirado</span>';
    }
    if ($stateValue == 2) {
      $state = '<span class="badge rounded-pill bg-success">Vendido</span>';
    }
    if ($stateValue == 3) {
      $state = '<span class="badge rounded-pill bg-danger">Devolucion</span>';
    }
    if ($stateValue == 4) {
      $state = '<span class="badge rounded-pill bg-secondary">Anulado</span>';
    }
    return $state;
  }

  //  Botones para las notas de pedido -> 1=Retirado, 2=Completado, 3=Devolucion
  public static function ctrGetButtonsSalidas($stateValue, $codNotaPedido)
  {
    if ($stateValue == 1) {
      $buttons = '
        <button class="btn btn-info btnPrintNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-print"></i></button>
        <button class="btn btn-warning btnEditNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-pencil"></i></button>
        <button class="btn btn-success btnUpdateNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa fa-check-circle"></i></button>
        <button class="btn btn-danger btnDeleteNotaPe" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-trash"></i></button>
      ';
    }
    if ($stateValue == 2) {
      $buttons = '
        <button class="btn btn-info btnPrintNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-print"></i></button>
        <button class="btn btn-warning btnEditNotaPedido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-pencil"></i></button>
        <button class="btn btn-success btnUpdateNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa fa-check-circle"></i></button>
        <button class="btn btn-danger btnDeleteNotaPe" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-trash"></i></button>
      ';
    }
    if ($stateValue == 3) {
      $buttons = '
        <button class="btn btn-info btnPrintNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-print"></i></button>
        <button class="btn btn-warning btnEditNotaPedido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-pencil"></i></button>
        <button class="btn btn-success btnUpdateNotaPedido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa fa-check-circle"></i></button>
        <button class="btn btn-danger btnDeleteNotaPe" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-trash"></i></button>
      ';
    }
    if ($stateValue == 4) {
      $buttons = '
        <button class="btn btn-info btnPrintNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-print"></i></button>
        <button class="btn btn-warning btnEditNotaPedido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-pencil"></i></button>
        <button class="btn btn-success btnUpdateNotaPedido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa fa-check-circle"></i></button>
        <button class="btn btn-danger btnDeleteNotaPe" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-trash"></i></button>
      ';
    }
    // <button class="btn btn-info btnViewDetallNotPe" data-bs-toggle="modal" data-bs-target="#modalViewDetallNotPe" codDetNotPe="' . $codNotaPedido . '"><i class="fa-solid fa-magnifying-glass"></i></button>
    return $buttons;
  }

  //  Botones para mostrar todos los productos
  public static function ctrGetButtonsProductos($listaProductos)
  {
    $button = '<button class="btn btn-primary btnMostarProductos" data-products="' . htmlspecialchars($listaProductos) . '">Productos</button>';
    return $button;
  }

  //  Estados para los lotes
  public static function ctrGetStatesLotes($stateValue)
  {
    if ($stateValue == 1) {
      $state = '<span class="badge rounded-pill bg-primary">Retirado</span>';
    }
    if ($stateValue == 2) {
      $state = '<span class="badge rounded-pill bg-success">Ingresado</span>';
    }
    if ($stateValue == 3) {
      $state = '<span class="badge rounded-pill bg-danger">Vendido</span>';
    }
    if ($stateValue == 4) {
      $state = '<span class="badge rounded-pill bg-secondary">Anulado</span>';
    }
    return $state;
  }

  //  Botones para la lista de lotes
  public static function ctrGetButtonsLotes($stateValue, $codLote)
  {
    if ($stateValue == 1) {
      $buttons = '
      <button class="btn btn-info btnViewDetallNotPe" data-bs-toggle="modal" data-bs-target="#modalViewDetallNotPe" codLote="' . $codLote . '" ><i class="fa-solid fa-magnifying-glass"></i></button>
      <button class="btn btn-warning btnLoteEdit" codLoteEdit="' . $codLote . '"><i class="fa-solid fa-pencil"></i></button>
      <button class="btn btn-danger btnLoteDelet" codLoteDelet="' . $codLote . '"><i class="fa-solid fa-trash"></i></button>
      ';
    }
    if ($stateValue == 2) {
      $buttons = '
      <button class="btn btn-info btnViewDetallNotPe" data-bs-toggle="modal" data-bs-target="#modalViewDetallNotPe" codLote="' . $codLote . '" ><i class="fa-solid fa-magnifying-glass"></i></button>
      <button class="btn btn-warning btnLoteEdit" codLoteEdit="' . $codLote . '"><i class="fa-solid fa-pencil"></i></button>
      <button class="btn btn-danger btnLoteDelet" codLoteDelet="' . $codLote . '"><i class="fa-solid fa-trash"></i></button>
      ';
    }
    if ($stateValue == 3) {
      $buttons = '
      <button class="btn btn-info btnViewDetallNotPe" data-bs-toggle="modal" data-bs-target="#modalViewDetallNotPe" codLote="' . $codLote . '" ><i class="fa-solid fa-magnifying-glass"></i></button>
      <button class="btn btn-warning btnLoteEdit" codLoteEdit="' . $codLote . '"><i class="fa-solid fa-pencil"></i></button>
      <button class="btn btn-danger btnLoteDelet" codLoteDelet="' . $codLote . '"><i class="fa-solid fa-trash"></i></button>
      ';
    }
    if ($stateValue == 4) {
      $buttons = '
      <button class="btn btn-info btnViewDetallNotPe" data-bs-toggle="modal" data-bs-target="#modalViewDetallNotPe" codLote="' . $codLote . '" ><i class="fa-solid fa-magnifying-glass"></i></button>
      <button class="btn btn-warning btnLoteEdit" codLoteEdit="' . $codLote . '"><i class="fa-solid fa-pencil"></i></button>
      <button class="btn btn-danger btnLoteDelet" codLoteDelet="' . $codLote . '"><i class="fa-solid fa-trash"></i></button>
      ';
    }
    return $buttons;
  }

}
