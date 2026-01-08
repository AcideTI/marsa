<?php

//  Controllers
require_once "../../controller/reportesExcel.controller.php";
require_once "../../controller/template.controller.php";
require_once "../../controller/functions.controller.php";

//  Controllers Modules
require_once "../../controller/products.controller.php";
require_once "../../controller/ingresos.controller.php";
require_once "../../controller/almacen.controller.php";
require_once "../../controller/notaPedido.controller.php";
require_once "../../controller/lotes.controller.php";

//  Models
require_once "../../model/products.model.php";
require_once "../../model/ingresos.model.php";
require_once "../../model/almacen.model.php";
require_once "../../model/notaPedido.model.php";
require_once "../../model/lotes.model.php";

//liberira para descargar reportes
require_once "../../vendor/autoload.php";

/*-------------------------
  Dowload Reports EXCEL
-------------------------*/


/*  Descargar todos las Notas para el reporte exel de Notas pedido */

if (isset($_GET["reporteExeNotaPe"])) {
  $reporteExeNotaPe =  new ControllerReportesExcel();
  $reporteExeNotaPe->ctrDowlReportsExeNotPe();
}

/* fin */

/* Reporte excel Notas por fechas  */

if (isset($_GET["reporteExeNotaPeFech"])) {
  $fechaInicioNot = $_GET["fechaInicioNot"];
  $fechaFinNot = $_GET["fechaFinNot"];
  $reporteExeNotaPeFech =  new ControllerReportesExcel();
  $reporteExeNotaPeFech->ctrDowlReportsExeNotPeFech($fechaInicioNot, $fechaFinNot);
}

if (isset($_GET["reporteGeneralNotas"])) {
  $reporteGeneralExcel =  new ControllerReportesExcel();
  $reporteGeneralExcel->ctrDownloadExcelNotasGeneral();
}
