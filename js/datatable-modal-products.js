//  Actualizar tabla de productos
$("#categoriaModal").on("change", function () {
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
