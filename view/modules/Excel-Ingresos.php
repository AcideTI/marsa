<?php

//  Controllers
require_once "../../controller/reportesExcel.controller.php";
require_once "../../controller/template.controller.php";
require_once "../../controller/functions.controller.php";

//  Controllers Modules
require_once "../../controller/Products.controller.php";
require_once "../../controller/ingresos.controller.php";
require_once "../../controller/almacen.controller.php";
require_once "../../controller/notaPedido.controller.php";
require_once "../../controller/lotes.controller.php";

//  Models
require_once "../../model/Products.model.php";
require_once "../../model/ingresos.model.php";
require_once "../../model/almacen.model.php";
require_once "../../model/notaPedido.model.php";
require_once "../../model/lotes.model.php";

//liberira para descargar reportes
require_once "../../vendor/autoload.php";

/*-------------------------
  Dowload Reports EXCEL
-------------------------*/


/*  Descargar todos los ingresos para el reporte exel de ingresos */

if(isset($_GET["reporteExeIngresos"]))
{
  $reporteExeIngresos =  new ControllerReportesExcel();
  $reporteExeIngresos -> ctrDowlReportsExeIng();
}

/* fin */

/* Reporte excel Ingresos por fechas  */

if(isset($_GET["reporteIngPorFechas"])) {
  $fechaInicio = $_GET["fechaInicio"];
  $fechaFin = $_GET["fechaFin"];
  $reporteIngPorFechas =  new ControllerReportesExcel();
  $reporteIngPorFechas -> ctrDowlReportsExeIngFech($fechaInicio, $fechaFin);
}

/* fin */
