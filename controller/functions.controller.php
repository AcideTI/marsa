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
      $state = '<span class="badge rounded-pill bg-primary" style="font-size: 16px; padding: 2px; width: 100px; height: 25px; text-align: center;">Retirado</span>';
    }
    if ($stateValue == 2) {
      $state = '<span class="badge rounded-pill bg-warning" style="font-size: 16px; padding: 2px; width: 100px; height: 25px; text-align: center;">Entregado</span>';
    }
    if ($stateValue == 3) {
      $state = '<span class="badge rounded-pill bg-success" style="font-size: 16px; padding: 2px; width: 100px; height: 25px; text-align: center;">Cancelado</span>';
    }
    if ($stateValue == 4) {
      $state = '<span class="badge rounded-pill bg-danger" style="font-size: 16px; padding: 2px; width: 100px; height: 25px; text-align: center;">Devolución</span>';
    }
    if ($stateValue == 5) {
      $state = '<span class="badge rounded-pill bg-secondary" style="font-size: 16px; padding: 2px; width: 100px; height: 25px; text-align: center;">Anulado</span>';
    }
    return $state;
  }

  //  Botones para las notas de pedido -> 1=Retirado, 2=Completado, 3=Devolucion
  public static function ctrGetButtonsSalidas($stateValue, $codNotaPedido)
  {
    if ($stateValue == 1) {
      $buttons = '
        <button class="btn btn-outline-dark btnPrintNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-file-pdf"></i></button>
        <button class="btn btn-warning btnEditNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-pencil"></i></button>
        <button class="btn btn-success btnUpdateNotaRegistrado" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa fa-check-circle"></i></button>
        <button class="btn btn-danger btnDeleteNotaPe" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-trash"></i></button>
        <button class="btn btn-secondary btnNullNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-ban"></i></button>
      ';
    }
    if ($stateValue == 2) {
      $buttons = '
        <button class="btn btn-outline-dark btnPrintNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-file-pdf"></i></button>
        <button class="btn btn-warning btnEditNotaPedido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-pencil"></i></button>
        <button class="btn btn-success btnUpdateNotaCancelado" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa fa-check-circle"></i></button>
        <button class="btn btn-danger btnDeleteNotaPe" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-trash"></i></button>
        <button class="btn btn-secondary btnNullNotaPedido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-ban"></i></button>
      ';
    }
    if ($stateValue == 3) {
      $buttons = '
        <button class="btn btn-outline-dark btnPrintNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-file-pdf"></i></button>
        <button class="btn btn-warning btnEditNotaPedido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-pencil"></i></button>
        <button class="btn btn-danger btnUpdateNotaVendido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa fa-check-circle"></i></button>
        <button class="btn btn-danger btnDeleteNotaPe" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-trash"></i></button>
        <button class="btn btn-secondary btnNullNotaPedido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-ban"></i></button>
      ';
    }
    if ($stateValue == 4) {
      $buttons = '
        <button class="btn btn-outline-dark btnPrintNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-file-pdf"></i></button>
        <button class="btn btn-warning btnEditNotaPedido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-pencil"></i></button>
        <button class="btn btn-danger " codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa fa-check-circle"></i></button>
        <button class="btn btn-danger btnDeleteNotaPe" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-trash"></i></button>
        <button class="btn btn-secondary btnNullNotaPedido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-ban"></i></button>
      ';
    }
    if ($stateValue == 5) {
      $buttons = '
        <button class="btn btn-outline-dark btnPrintNotaPedido" codNotaPe="' . $codNotaPedido . '"><i class="fa-solid fa-file-pdf"></i></button>
        <button class="btn btn-warning btnEditNotaPedido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-pencil"></i></button>
        <button class="btn btn-danger " codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa fa-check-circle"></i></button>
        <button class="btn btn-danger btnDeleteNotaPe" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-trash"></i></button>
        <button class="btn btn-secondary btnNullNotaPedido" codNotaPe="' . $codNotaPedido . '" disabled><i class="fa-solid fa-ban"></i></button>
      ';
    }

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
      $state = '<span class="badge rounded-pill bg-primary" style="font-size: 16px; padding: 2px; width: 100px; height: 25px; text-align: center;">Retirado</span>';
    }
    if ($stateValue == 2) {
      $state = '<span class="badge rounded-pill bg-warning" style="font-size: 16px; padding: 2px; width: 100px; height: 25px; text-align: center;">Entregado</span>';
    }
    if ($stateValue == 3) {
      $state = '<span class="badge rounded-pill bg-success" style="font-size: 16px; padding: 2px; width: 100px; height: 25px; text-align: center;">Cancelado</span>';
    }
    if ($stateValue == 4) {
      $state = '<span class="badge rounded-pill bg-danger" style="font-size: 16px; padding: 2px; width: 100px; height: 25px; text-align: center;">Devolución</span>';
    }
    if ($stateValue == 5) {
      $state = '<span class="badge rounded-pill bg-secondary" style="font-size: 16px; padding: 2px; width: 100px; height: 25px; text-align: center;">Anulado</span>';
    }
    return $state;
  }

  //  Botones para la lista de lotes
  public static function ctrGetButtonsLotes($stateValue, $codLote)
  {
    if ($stateValue == 1) {
      $buttons = '
      <button class="btn btn-info btnViewAllLote" data-bs-toggle="modal" data-bs-target="#modalViewDetallNotPe" codLote="' . $codLote . '"><i class="fa-solid fa-magnifying-glass"></i></button>
      <button class="btn btn-warning btnLoteEdit" codLoteEdit="' . $codLote . '"><i class="fa-solid fa-pencil"></i></button>
      <button class="btn btn-success btnUpdateLoteRetirado" codLoteUpdate="' . $codLote . '"><i class="fa-solid fa fa-check-circle"></i></button>
      <button class="btn btn-danger btnLoteDelet" codLoteDelet="' . $codLote . '"><i class="fa-solid fa-trash"></i></button>
      <button class="btn btn-secondary btnNullLote" codLote="' . $codLote . '" ><i class="fa-solid fa-ban"></i></button>
      ';
    }
    if ($stateValue == 2) {
      $buttons = '
      <button class="btn btn-info btnViewAllLote" data-bs-toggle="modal" data-bs-target="#modalViewDetallNotPe" codLote="' . $codLote . '"><i class="fa-solid fa-magnifying-glass"></i></button>
      <button class="btn btn-warning btnLoteEdit" codLoteEdit="' . $codLote . '" disabled><i class="fa-solid fa-pencil"></i></button>
      <button class="btn btn-success btnUpdateLoteEntregado" codLoteUpdateEntregado="' . $codLote . '"><i class="fa-solid fa fa-check-circle"></i></button>
      <button class="btn btn-danger btnLoteDelet" codLoteDelet="' . $codLote . '" disabled><i class="fa-solid fa-trash"></i></button>
      <button class="btn btn-secondary btnNullLote" codLote="' . $codLote . '" disabled><i class="fa-solid fa-ban"></i></button>
      ';
    }
    if ($stateValue == 3) {
      $buttons = '
      <button class="btn btn-info btnViewAllLote" data-bs-toggle="modal" data-bs-target="#modalViewDetallNotPe" codLote="' . $codLote . '"><i class="fa-solid fa-magnifying-glass"></i></button>
      <button class="btn btn-warning btnLoteEdit" codLoteEdit="' . $codLote . '" disabled><i class="fa-solid fa-pencil"></i></button>
      <button class="btn btn-danger btnUpdateLoteVendido" codLoteUpdateVendido="' . $codLote . '" ><i class="fa-solid fa fa-check-circle"></i></button>
      <button class="btn btn-danger btnLoteDelet" codLoteDelet="' . $codLote . '" disabled><i class="fa-solid fa-trash"></i></button>
      <button class="btn btn-secondary btnNullLote" codLote="' . $codLote . '" disabled><i class="fa-solid fa-ban"></i></button>
      ';
    }
    if ($stateValue == 4) {
      $buttons = '
      <button class="btn btn-info btnViewAllLote" data-bs-toggle="modal" data-bs-target="#modalViewDetallNotPe" codLote="' . $codLote . '"><i class="fa-solid fa-magnifying-glass"></i></button>
      <button class="btn btn-warning btnLoteEdit" codLoteEdit="' . $codLote . '" disabled><i class="fa-solid fa-pencil"></i></button>
      <button class="btn btn-danger" codLoteUpdate="' . $codLote . '" disabled><i class="fa-solid fa fa-check-circle"></i></button>
      <button class="btn btn-danger btnLoteDelet" codLoteDelet="' . $codLote . '" disabled><i class="fa-solid fa-trash"></i></button>
      <button class="btn btn-secondary btnNullLote" codLote="' . $codLote . '" disabled><i class="fa-solid fa-ban"></i></button>
      ';
    }
    if ($stateValue == 5) {
      $buttons = '
      <button class="btn btn-info btnViewAllLote" data-bs-toggle="modal" data-bs-target="#modalViewDetallNotPe" codLote="' . $codLote . '"><i class="fa-solid fa-magnifying-glass"></i></button>
      <button class="btn btn-warning btnLoteEdit" codLoteEdit="' . $codLote . '" disabled><i class="fa-solid fa-pencil"></i></button>
      <button class="btn btn-danger" codLoteUpdate="' . $codLote . '" disabled><i class="fa-solid fa fa-check-circle"></i></button>
      <button class="btn btn-danger btnLoteDelet" codLoteDelet="' . $codLote . '" disabled><i class="fa-solid fa-trash"></i></button>
      <button class="btn btn-secondary btnNullLote" codLote="' . $codLote . '" disabled><i class="fa-solid fa-ban"></i></button>
      ';
    }
    return $buttons;
  }

  //  Obtener el valor del estado para la vista editar
  public static function ctrGetStateEditLote($codState)
  {
    if ($codState == 1) {
      $estado = "Retirado";
      $color = "#82B2F1";
    }
    if ($codState == 2) {
      $estado = "Entregado";
      $color = "#FFFCAE";
    }
    if ($codState == 3) {
      $estado = "Cancelado";
      $color = "#82F5A5";
    }
    if ($codState == 4) {
      $estado = "Devolución";
      $color = "#F1907D";
    }
    if ($codState == 5) {
      $estado = "Anulado";
      $color = "#C7C7C7";
    }
    $input = '<input type="text" class="form-control" id="editarEstadoLote" name="editarEstadoLote" value="' . $estado . '"  style="background-color: ' . $color . '" disabled>';
    return $input;
  }

  //  Obtener tipo de ignreso de un ingreso
  public static function ctrGetTipoIngreso($tipoIngreso)
  {
    if ($tipoIngreso == 1) {
      $tipo = "<span class='badge rounded-pill bg-success' style='font-size: 16px; padding: 2px; width: 100px; height: 25px; text-align: center;'>Producción</span>";
    }
    if ($tipoIngreso == 2) {
      $tipo = "<span class='badge rounded-pill bg-danger' style='font-size: 16px; padding: 2px; width: 100px; height: 25px; text-align: center;'>Devolución</span>";
    }
    return $tipo;
  }

  //  Botones para los ingresos 6->Devolución 7->Ingresado
  public static function ctrGetButtonsIngresos($stateValue, $codIngreso)
  {
    if ($stateValue == 7) {
      $buttons = '
        <button class="btn btn-info btnVisualizarIngreso" codIngreso="' . $codIngreso . '"><i class="fa-solid fa-magnifying-glass"></i></button>
        <button class="btn btn-warning btnEditarIngreso" codIngreso="' . $codIngreso . '" ><i class="fa-solid fa-pencil"></i></button>
        <button class="btn btn-danger btnIngresoDelet" codIngresoDelet="' . $codIngreso . '"><i class="fa-solid fa-trash"></i></button>
      ';
    }
    if ($stateValue == 6) {
      $buttons = '
        <button class="btn btn-info btnVisualizarIngreso" codIngreso="' . $codIngreso . '"><i class="fa-solid fa-magnifying-glass"></i></button>
        <button class="btn btn-warning btnEditarIngreso" codIngreso="' . $codIngreso . '" disabled><i class="fa-solid fa-pencil"></i></button>
        <button class="btn btn-danger btnIngresoDelet" codIngresoDelet="' . $codIngreso . '" disabled><i class="fa-solid fa-trash"></i></button>
      ';
    }
    return $buttons;
  }

  //  Botones para las mermas
  public static function ctrGetButtonsMermas($codIngresoDev, $codSalida, $tipoSalida)
  {
    $buttons = '
      <button class="btn btn-success btnVisualizarIngreso" codIngreso="' . $codIngresoDev . '"><i class="fa-solid fa-file-lines"></i></button>
      <button class="btn btn-warning btnVisualizarSalida" codSalida="' . $codSalida . '" tipoSalida="' . $tipoSalida . '"><i class="fa-solid fa-layer-group"></i></button>
    ';
    return $buttons;
  }
}
