// Variable global para la tabla de clientes
var tableClients;

// Inicializar DataTable de clientes con server-side processing
$(document).ready(function () {
  // Verificar si la tabla existe en la página
  if ($('#tableClients').length > 0) {
    initClientsTable();
  }
});

function initClientsTable() {
  tableClients = $('#tableClients').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: 'ajax/clients.ajax.php',
      type: 'POST',
      data: function (d) {
        d.getClientsPaginated = true;
      }
    },
    columns: [
      {
        data: null,
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        },
        orderable: false
      },
      { data: 'RucCli' },
      { data: 'RazonSocial' },
      { data: 'NombreCli' },
      { data: 'CorreoCli' },
      { data: 'DireccionCli' },
      { data: 'TelefonoCli' },
      {
        data: 'Estado',
        render: function (data) {
          if (data === 'Activo') {
            return '<span class="badge bg-success">Activo</span>';
          } else {
            return '<span class="badge bg-danger">Inactivo</span>';
          }
        }
      },
      {
        data: 'IdCli',
        render: function (data) {
          // El userType se obtiene de una variable global definida en PHP
          var userType = window.currentUserType || 1;
          return '<button class="btn btn-warning btn-sm btnEditClients" codClient="' + data + '" data-toggle="modal" data-target="#modalEditClients"><i class="fa-solid fa-pencil"></i></button> ' +
            '<button class="btn btn-danger btn-sm btnDeleteClient" codClient="' + data + '" userType="' + userType + '"><i class="fa-solid fa-trash"></i></button>';
        },
        orderable: false
      }
    ],
    order: [[0, 'desc']],
    pageLength: 10,
    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
    language: {
      processing: "Procesando...",
      lengthMenu: "Mostrar _MENU_ registros",
      zeroRecords: "No se encontraron resultados",
      emptyTable: "Ningún dato disponible en esta tabla",
      info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      infoFiltered: "(filtrado de un total de _MAX_ registros)",
      search: "Buscar:",
      loadingRecords: "Cargando...",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior"
      }
    }
  });
}

// Mostrar datos del cliente para editar
$("#tableClients").on("click", ".btnEditClients", function () {
  var codClient = $(this).attr("codClient");
  var data = new FormData();
  data.append("codClient", codClient);
  $.ajax({
    url: "ajax/clients.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      $("#EditRu").val(response["RucCli"]);
      $("#EditRazonSocial").val(response["RazonSocial"]);
      $("#EditNameCli").val(response["NombreCli"]);
      $("#EditEmailCli").val(response["CorreoCli"]);
      $("#EditAddressCli").val(response["DireccionCli"]);
      $("#EditPhoneCli").val(response["TelefonoCli"]);
      $("#EditStateCli").val(response["Estado"]);
      $("#codClient").val(response["IdCli"]);
    }
  });
});


// Alerta para eliminar
$("#tableClients").on("click", ".btnDeleteClient", function () {
  var codClient = $(this).attr("codClient");
  var userType = $(this).attr("userType");
  // Alerta para usuarios que no son administradores
  if (userType != 1) {
    $(this).prop("disabled", true);
    $(this).css("opacity", 0.5);
    Swal.fire({
      icon: 'error',
      title: 'Acción solo para el Administrador.',
      text: 'No permitido',
      showConfirmButton: false,
      timer: 2000
    });
    return;
  }
  // Alerta para eliminar cliente
  swal.fire({
    title: '¿Está seguro de borrar el cliente?',
    text: "¡No podrá revertir el cambio!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar cliente!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "index.php?ruta=clients&codClient=" + codClient;
    }
  });
});
