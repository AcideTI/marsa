// Definición inicial de las columnas
var columnDefs = [
  { data: "IdNotaP" },
  { data: "NombrePerIdPer" },
  { data: "NombreCliNota" },
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
    { data: "StateNota" },
    { data: "FechaNotaPedido" },
    { data: "Productos" },
    { data: "Buttons" },
  ];
  table = $("#dataTableSalidas").DataTable({
    columns: columnDefs,
  });

  data.append("codFiltroNotas", filtro);
  +$.ajax({
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
  $(".tituloSalidas").text("Lotes");
  
  $("#dataTableSalidas thead").html(`
  <tr>
    <th>ID</th>
    <th>Responsable</th>
    <th>Nombre del Cliente</th>
    <th>Código de Lote</th>
    <th>Fecha de Lote</th>
    <th>Estado</th>
    <th>Acciones</th>
  </tr>
`);

  table.destroy();
  columnDefs = [
    { data: "IdLote" },
    { data: "FullNamePersonal" },
    { data: "NombreCli" },
    { data: "CodigoLote" },
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
