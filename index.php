<?php 


//  Controllers
require_once "controller/template.controller.php";
require_once "controller/functions.controller.php";
//  Controllers Modules
require_once "controller/users.controller.php";
require_once "controller/Products.controller.php";
require_once "controller/personal.controller.php";
require_once "controller/clients.controller.php";
require_once "controller/ingresos.controller.php";
require_once "controller/almacen.controller.php";
require_once "controller/notaPedido.controller.php";
require_once "controller/lotes.controller.php";

/* require_once "controller/providers.controller.php";
require_once "controller/buy.controller.php";
require_once "controller/stockMaterial.controller.php";
require_once "controller/orders.controller.php";
require_once "controller/models.controller.php";
require_once "controller/client.controller.php";
require_once "controller/products.controller.php";
require_once "controller/reportesExcel.controller.php";
require_once "controller/vendor.controller.php"; */

//  Models
require_once "model/users.model.php";
require_once "model/Products.model.php";
require_once "model/personal.model.php";
require_once "model/clients.model.php";
require_once "model/ingresos.model.php";
require_once "model/almacen.model.php";
require_once "model/notaPedido.model.php";
require_once "model/lotes.model.php";

/* require_once "model/providers.model.php";
require_once "model/buy.model.php";
require_once "model/stockMaterial.model.php";
require_once "model/makers.model.php";
require_once "model/orders.model.php";
require_once "model/models.model.php";
require_once "model/client.model.php";
require_once "model/products.model.php";
*/

$template = new TemplateController();
$template -> ctrTemplate();