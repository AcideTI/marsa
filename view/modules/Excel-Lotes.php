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


/*  Descargar todos los Lotes para el reporte excel de Lotes - CON FILTRO DE AÑO */

if (isset($_GET["reporteExeLotes"])) {
  $anio = isset($_GET["anio"]) ? $_GET["anio"] : null;
  $reporteExeLotes = new ControllerReportesExcel();
  $reporteExeLotes->ctrDowlReportsExeLote($anio);
}

/* fin */

/* Reporte excel Lotes por fechas  */

if (isset($_GET["reporteExeLotesFech"])) {
  $fechaInicioLt = $_GET["fechaInicioLt"];
  $fechaFinLt = $_GET["fechaFinLt"];
  $reporteExeLotesFech = new ControllerReportesExcel();
  $reporteExeLotesFech->ctrDowlReportsExeLoteFech($fechaInicioLt, $fechaFinLt);
}

/* Reporte General Facturas - CON FILTRO DE AÑO */
if (isset($_GET["reporteGeneralFacturas"])) {
  $anio = isset($_GET["anio"]) ? $_GET["anio"] : null;
  $reporteGeneralFacturas = new ControllerReportesExcel();
  $reporteGeneralFacturas->ctrDownloadGeneralFacturas($anio);
}


/* fin */
