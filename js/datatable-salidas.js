var table = $("#dataTableSalidas").DataTable({
  columns: [
    { data: "IdNotaP" },
    { data: "NombrePerIdPer" },
    { data: "NombreCliNota" },
    { data: "StateNota" },
    { data: "FechaNotaPedido" },
    { data: "Productos" },
    { data: "Buttons" },
  ],
});

//  Actualizar la tabla de visualización con los productos Registrados
$(".buttonsSalidas").on("click", ".btnAllNotasSalida", function () {
  var filtro = $(this).attr("filtro");
  var data = new FormData();
  
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

