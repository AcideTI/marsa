<?php

require_once "../controller/ingresos.controller.php";
require_once "../model/ingresos.model.php";
require_once "../controller/almacen.controller.php";
require_once "../model/almacen.model.php";
require_once "../controller/functions.controller.php";


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
if (isset($_POST["codProductAdd"])) {
  $addMaterialInside = new AjaxMaterials();
  $addMaterialInside->codProductAdd = $_POST["codProductAdd"];
  $addMaterialInside->ajaxAddMaterialInside();
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
if (isset($_POST["newIngJs"])) {
  $jsonOriginData = new NewIngresoAjax();
  $jsonOriginData->newIngJs = $_POST["newIngJs"];
  $jsonOriginData->ajaxCreateIngresoNuevo();
}
/* fin */

/* Obtener ingresos paginados para DataTables */
if (isset($_GET["action"]) && $_GET["action"] == "getIngresosPaginated") {
  $draw = isset($_GET["draw"]) ? intval($_GET["draw"]) : 1;
  $start = isset($_GET["start"]) ? intval($_GET["start"]) : 0;
  $length = isset($_GET["length"]) ? intval($_GET["length"]) : 10;
  $search = isset($_GET["search"]["value"]) ? $_GET["search"]["value"] : "";
  $orderColumn = isset($_GET["order"][0]["column"]) ? intval($_GET["order"][0]["column"]) : 0;
  $orderDir = isset($_GET["order"][0]["dir"]) ? $_GET["order"][0]["dir"] : "DESC";

  $result = IngresosController::ctrGetIngresosPaginated($start, $length, $search, $orderColumn, $orderDir);

  $data = [];
  foreach ($result["data"] as $row) {
    $tipoIngreso = FunctionsController::ctrGetTipoIngreso($row["TipoIngreso"]);
    $botones = FunctionsController::ctrGetButtonsIngresos($row["Estado"], $row["IdIng"]);

    $data[] = [
      $row["IdIng"],
      $row["NombrePerIdPer"],
      $tipoIngreso,
      $row["DescripcionIng"],
      '<button class="btn btn-primary btn-sm btnMostarProductosIng" data-products="' . htmlspecialchars($row["DatosProductosIngresoJson"]) . '"><i class="fa-solid fa-eye"></i> Productos</button>',
      $row["FechaProduccionIng"],
      $row["FechaVencimientoIng"],
      $botones
    ];
  }

  echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $result["recordsTotal"],
    "recordsFiltered" => $result["recordsFiltered"],
    "data" => $data
  ]);
  exit;
}

