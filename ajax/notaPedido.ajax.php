<?php

require_once "../controller/notaPedido.controller.php";
require_once "../model/notaPedido.model.php";
require_once "../controller/ingresos.controller.php";
require_once "../model/ingresos.model.php";
require_once "../controller/functions.controller.php";
class notaPedidoAjax
{
  /* // Agrega los productos al modal de la vista  */
  public $codProductAdd;
  public function ajaxAddProdModalSa()
  {
    $codProductAdd = $this->codProductAdd;
    //$respuesta = NotaPedidoController::ctrGetProductDataAjx($codProductAdd);
    $respuesta = IngresosController::ctrGetProductDataAjx($codProductAdd);
    echo json_encode($respuesta);
  }

  //  Mostrar los datos de las notas de pedido en a vista verSalidas
  public $codFiltroNotas;
  public function ajaxMostrarTablaNotasPedido()
  {
    $codFiltroNotas = $this->codFiltroNotas;
    $respuesta = NotaPedidoController::ctrGetAllSalidasNotaPe();
    foreach ($respuesta as &$notaPedido) {
      $notaPedido['Buttons'] = FunctionsController::ctrGetButtonsSalidas($notaPedido["EstadoNota"], $notaPedido["IdNotaP"]);
      $notaPedido['StateNota'] = FunctionsController::ctrGetStateSalidas($notaPedido["EstadoNota"]);
      $notaPedido['Productos'] = FunctionsController::ctrGetButtonsProductos($notaPedido["DatosProductosNotaPedidoJson"]);
    }
    echo json_encode($respuesta);
  }

  //  Mostrar los datos de los lotes verSalidas
  public $codFiltroLotes;
  public function ajaxMostrarTablaLotes()
  {
    $codFiltroLotes = $this->codFiltroLotes;
    $respuesta = NotaPedidoController::ctrGetAllSalidasNotaPe();
    foreach ($respuesta as &$notaPedido) {
      $notaPedido['Buttons'] = FunctionsController::ctrGetButtonsSalidas($notaPedido["EstadoNota"], $notaPedido["IdNotaP"]);
      $notaPedido['StateNota'] = FunctionsController::ctrGetStateSalidas($notaPedido["EstadoNota"]);
      $notaPedido['Productos'] = FunctionsController::ctrGetButtonsProductos($notaPedido["DatosProductosNotaPedidoJson"]);
    }
    echo json_encode($respuesta);
  }
}

// Agrega los productos al modal de la vista 
if (isset($_POST["codProductAdd"])) {
  $addProdModalSa = new notaPedidoAjax();
  $addProdModalSa->codProductAdd = $_POST["codProductAdd"];
  $addProdModalSa->ajaxAddProdModalSa();
}

// Mostrar los datos de la note de pedido en la vista verSalidas
if (isset($_POST["codFiltroNotas"])) {
  $mostrarNotasPedido = new notaPedidoAjax();
  $mostrarNotasPedido->codFiltroNotas = $_POST["codFiltroNotas"];
  $mostrarNotasPedido->ajaxMostrarTablaNotasPedido();
}

//  Mostrar los datos de los lotes verSalidas
if (isset($_POST["codFiltroLotes"])) {
  $mostrarLotes = new notaPedidoAjax();
  $mostrarLotes->codFiltroLotes = $_POST["codFiltroLotes"];
  $mostrarLotes->ajaxMostrarTablaLotes();
}
/* fin */

/* funcion Editar para mostrar detalles de nota de pedido por el boton  */
class EditNotaPedAjax
{
  public $codEditNotPeData;
  public function ajaxGetProductEditData()
  {
    $codEditNotPeData = $this->codEditNotPeData;
    $response = NotaPedidoController::ctrGetEditNotPeData($codEditNotPeData);
    echo json_encode($response);
  }
}

//  Show  detalles de la nota de pedido
if (isset($_POST["codEditNotPeData"])) {
  $getProductData = new EditNotaPedAjax();
  $getProductData->codEditNotPeData = $_POST["codEditNotPeData"];
  $getProductData->ajaxGetProductEditData();
}

/* fin */