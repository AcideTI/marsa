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


/* Reporte excel Almacen */

if(isset($_GET["reporteExeAlmacen"]))
{
  $reporteExeAlmacen =  new ControllerReportesExcel();
  $reporteExeAlmacen -> ctrDowlReportsExeAlmacen();
}

/* fin */
