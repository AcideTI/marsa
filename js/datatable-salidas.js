// ============================================
// DATATABLE SALIDAS - SERVER-SIDE PROCESSING
// ============================================

// Variable global para el DataTable
var table = null;

// Configuración de idioma en español
var languageConfig = {
  processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> Cargando datos...',
  lengthMenu: "Mostrar _MENU_ registros",
  zeroRecords: "No se encontraron resultados",
  info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
  infoEmpty: "Mostrando 0 a 0 de 0 registros",
  infoFiltered: "(filtrado de _MAX_ registros totales)",
  search: "Buscar:",
  paginate: {
    first: "Primero",
    last: "Último",
    next: "Siguiente",
    previous: "Anterior"
  }
};

// ============================================
// INICIALIZACIÓN CON SERVER-SIDE PROCESSING
// ============================================
$(document).ready(function () {
  // Inicializar tabla con Notas de Pedido por defecto (server-side)
  initNotasPedidoTable();

  // Activar card de Notas por defecto
  activarCardNotas();
});

// ============================================
// FUNCIONES PARA CAMBIAR ESTADO VISUAL DE CARDS
// ============================================
function activarCardNotas() {
  // Activar card de Notas
  $("#cardNotas").css("opacity", "1").addClass("shadow");
  $("#cardFacturas").css("opacity", "0.6").removeClass("shadow");

  // Actualizar badge indicador
  $(".tituloSalidas").text("Notas de Pedido").removeClass("bg-info").addClass("bg-primary");
}

function activarCardFacturas() {
  // Activar card de Facturas
  $("#cardFacturas").css("opacity", "1").addClass("shadow");
  $("#cardNotas").css("opacity", "0.6").removeClass("shadow");

  // Actualizar badge indicador
  $(".tituloSalidas").text("Facturas / Lotes").removeClass("bg-primary").addClass("bg-info");
}

// ============================================
// FUNCIÓN: Inicializar tabla de Notas de Pedido
// ============================================
function initNotasPedidoTable() {
  // Destruir tabla existente si existe
  if (table !== null) {
    table.destroy();
    $("#dataTableSalidas").empty();
  }

  // Actualizar encabezado
  $("#dataTableSalidas").html(`
    <thead>
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
    </thead>
    <tbody></tbody>
  `);

  // Inicializar DataTable con SERVER-SIDE PROCESSING
  table = $("#dataTableSalidas").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "ajax/notaPedido.ajax.php",
      type: "POST",
      data: function (d) {
        d.serverSideNotas = true;
      },
      error: function (xhr, error, thrown) {
        console.error("Error en la solicitud AJAX:", error, thrown);
      }
    },
    columns: [
      {
        data: "IdNotaP",
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      { data: "NombrePerIdPer" },
      { data: "NombreCliNota" },
      { data: "NombrePerIdRes" },
      { data: "StateNota" },
      { data: "FechaNotaPedido" },
      { data: "Productos" },
      { data: "Buttons" }
    ],
    order: [[0, 'desc']],
    pageLength: 25,
    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
    language: languageConfig,
    // Permitir HTML en las columnas
    columnDefs: [
      { targets: [4, 6, 7], orderable: false } // Estado, Productos y Acciones no ordenables
    ]
  });
}

// ============================================
// FUNCIÓN: Inicializar tabla de Lotes/Facturas
// ============================================
function initLotesTable() {
  // Destruir tabla existente si existe
  if (table !== null) {
    table.destroy();
    $("#dataTableSalidas").empty();
  }

  // Actualizar encabezado para Lotes
  $("#dataTableSalidas").html(`
    <thead>
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
    </thead>
    <tbody></tbody>
  `);

  // Inicializar DataTable - Por ahora sin server-side para lotes
  // TODO: Implementar server-side para lotes en siguiente fase
  table = $("#dataTableSalidas").DataTable({
    processing: true,
    language: languageConfig,
    pageLength: 25,
    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
    order: [[0, 'desc']]
  });

  // Cargar datos via AJAX tradicional (se optimizará en siguiente fase)
  var data = new FormData();
  data.append("codFiltroLotes", "lotes");

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
      // Mapear datos para las columnas correctas
      var mappedData = response.map(function (item, index) {
        return [
          index + 1,
          item.FullNamePersonal || '',
          item.NombreCli || '',
          item.TipoSalida || '',
          item.NroFactura || '',
          item.FechaProduccionLote || '',
          item.StateLote || '',
          item.Buttons || ''
        ];
      });
      table.rows.add(mappedData);
      table.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
    }
  });
}

// ============================================
// EVENTOS DE BOTONES DE FILTRO
// ============================================

// Botón "Ver Notas de Pedido"
$(".buttonsSalidas").on("click", ".btnAllNotasSalida", function () {
  // Cambiar estado visual de las cards
  activarCardNotas();

  // Inicializar tabla con server-side
  initNotasPedidoTable();
});

// Botón "Ver Facturas"
$(".buttonsSalidas").on("click", ".btnAllLotes", function () {
  // Cambiar estado visual de las cards
  activarCardFacturas();

  // Inicializar tabla de lotes
  initLotesTable();
});
