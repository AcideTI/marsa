
// Mostrar datos del cliente
$(".table").on("click", ".btnEditClients", function () {
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
$(".table").on("click", ".btnDeleteClient", function () {
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
      window.location = "index.php?ruta=clients&codClient="+codClient;
    }
  });
});
