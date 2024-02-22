//  Buscar el producto en específico por el codigo del producto
$(".stockGlobal").on("click", ".btnBuscarStockGlobal", function () {
  var valor = $("#valorbusqueda").val();
  if (valor !== "") {
    window.location = "index.php?ruta=buscarProducto&valor=" + valor;
  }
});

//  Buscar el producto en específico por el codigo del producto de Home
$(".stockGlobal").on("click", ".btnBuscarStockGlobalHome", function () {
  var valor = $("#valorbusqueda").val();
  if (valor !== "") {
    window.location = "index.php?ruta=home&valor=" + valor;
  }
});

//  Descargar reporte exel de Almacen
$("#reporteExeAlmacen").on("click", function () {
  window.location = "view/modules/Excel-Inventario.php?&reporteExeAlmacen";
});

$(".table").on("click", ".btnVisualizarSalida", function () {
  var codSalida = $(this).attr("codSalida");
  var tipoSalida = $(this).attr("tipoSalida");

  if (tipoSalida === "Nota de Pedido") {
    window.location = "index.php?ruta=visualizarNotaPedido&codSalida=" + codSalida;
  }
  if (tipoSalida === "Lote") {
    window.location = "index.php?ruta=visualizarLote&codSalida=" + codSalida;
  }
});
