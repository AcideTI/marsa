<?php 


//  Controllers
require_once "controller/template.controller.php";
require_once "controller/functions.controller.php";
require_once "controller/users.controller.php";
/* require_once "controller/providers.controller.php";
require_once "controller/materials.controller.php";
require_once "controller/movements.controller.php";
require_once "controller/buy.controller.php";
require_once "controller/stockMaterial.controller.php";
require_once "controller/makers.controller.php";
require_once "controller/orders.controller.php";
require_once "controller/models.controller.php";
require_once "controller/client.controller.php";
require_once "controller/products.controller.php";
require_once "controller/reportesExcel.controller.php";
require_once "controller/vendor.controller.php";
require_once "controller/stock.controller.php"; */

//  Models
require_once "model/users.model.php";
/* require_once "model/providers.model.php";
require_once "model/materials.model.php";
require_once "model/movements.model.php";
require_once "model/buy.model.php";
require_once "model/stockMaterial.model.php";
require_once "model/makers.model.php";
require_once "model/orders.model.php";
require_once "model/models.model.php";
require_once "model/client.model.php";
require_once "model/products.model.php";
require_once "model/stock.model.php";
 */

$template = new TemplateController();
$template -> ctrTemplate();