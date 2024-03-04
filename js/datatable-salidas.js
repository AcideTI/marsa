// Definición inicial de las columnas
var columnDefs = [
  { data: "IdNotaP" },
  { data: "NombrePerIdPer" },
  { data: "NombreCliNota" },
  { data: "NombrePerIdRes" },
  { data: "StateNota" },
  { data: "FechaNotaPedido" },
  { data: "Productos" },
  { data: "Buttons" },
];

var table = $("#dataTableSalidas").DataTable({
  columns: columnDefs,
});

//  Actualizar la tabla de visualización con los productos Registrados
$(".buttonsSalidas").on("click", ".btnAllNotasSalida", function () {
  var filtro = $(this).attr("filtro");
  var data = new FormData();
  $(".tituloSalidas").text("Notas de Pedido");

  $("#dataTableSalidas thead").html(`
      <tr>
        <th>ID</th>
        <th>Responsable</th>
        <th>Nombre Cliente</th>
        <th>Vendedor</th>
        <th>Estado</th>
        <th>Fecha de Nota</th>
        <th>Productos</th>
        <th>Acciones</th>
      </tr>
    `);

  table.destroy();

  columnDefs = [
    { data: "IdNotaP" },
    { data: "NombrePerIdPer" },
    { data: "NombreCliNota" },
    { data: "NombrePerIdRes" },
    { data: "StateNota" },
    { data: "FechaNotaPedido" },
    { data: "Productos" },
    { data: "Buttons" },
  ];
  table = $("#dataTableSalidas").DataTable({
    columns: columnDefs,
  });

  data.append("codFiltroNotas", filtro);
  $.ajax({
    url: "ajax/notaPedido.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      table.clear();
      table.rows.add(response);
      table.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});

//  Actualizar la tabla de visualización con los productos Registrados
$(".buttonsSalidas").on("click", ".btnAllLotes", function () {
  var filtro = $(this).attr("filtro");
  var data = new FormData();
  $(".tituloSalidas").text("Facturas");

  $("#dataTableSalidas thead").html(`
  <tr>
    <th>ID</th>
    <th>Responsable</th>
    <th>Nombre del Cliente</th>
    <th>Tipo Salida</th>
    <th>Nr Factura</th>
    <th>Fecha de Salida</th>
    <th>Estado</th>
    <th>Acciones</th>
  </tr>
`);

  table.destroy();
  columnDefs = [
    { data: "IdLote" },
    { data: "FullNamePersonal" },
    { data: "NombreCli" },
    { data: "TipoSalida" },
    { data: "NroFactura" },
    { data: "FechaProduccionLote" },
    { data: "StateLote" },
    { data: "Buttons" },
  ];
  table = $("#dataTableSalidas").DataTable({
    columns: columnDefs,
  });

  data.append("codFiltroLotes", filtro);
  $.ajax({
    url: "ajax/lotes.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      table.clear();
      table.rows.add(response);
      table.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});

/* ocultar botones de descarga de reportes para verlosm cuando se haga clic en el botón correspondiente */
$(document).ready(function () {
  // Ocultar todos los botones de reporte al inicio
  $("#reporteExeNotaPe").hide();
  $("#reporteExeNotaPeFech").hide();
  $("#reporteExeLotes").hide();
  $("#reporteExeLotesFech").hide();

  // Mostrar los botones de reporte correspondientes cuando se hace clic en btnAllNotasSalida
  $(".buttonsSalidas").on("click", ".btnAllNotasSalida", function () {
    $("#reporteExeNotaPe").show();
    $("#reporteExeNotaPeFech").show();
    $("#reporteExeLotes").hide();
    $("#reporteExeLotesFech").hide();
  });

  // Mostrar los botones de reporte correspondientes cuando se hace clic en btnAllLotes
  $(".buttonsSalidas").on("click", ".btnAllLotes", function () {
    $("#reporteExeNotaPe").hide();
    $("#reporteExeNotaPeFech").hide();
    $("#reporteExeLotes").show();
    $("#reporteExeLotesFech").show();
  });
});
/* fin */
