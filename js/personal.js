// Mostrar datos del personal
$(".table").on("click", ".btnEditPersonal", function () {
  var codPersonal = $(this).attr("codPersonal");
  var data = new FormData();
  data.append("codPersonal", codPersonal);
  $.ajax({
    url: "ajax/personal.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      $("#editPersonalTypePer").val(response["IdTipoPer"]);
      $("#editFirstNamePer").val(response["NombrePer"]);
      $("#editLastNamePer").val(response["ApellidoPer"]);
      $("#editDniNumberPer").val(response["dni"]);
      $("#editPhoneNumberPer").val(response["TelefonoPer"]);
      $("#editAddressPer").val(response["DireccionPer"]);
      $("#editEstadoPer").val(response["Estado"]);
      $("#codPersonal").val(response["IdPer"]);
    }
  });
});

// Alerta para eliminar personal
$(".table").on("click", ".btnDeletePersonal", function () {
  var codPersonal = $(this).attr("codPersonal");
  var userTypePer = $(this).attr("userTypePer");
  if (userTypePer != 1) {
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
  swal.fire({
    title: '¿Está seguro de borrar el personal?',
    text: "¡No podrá revertir el cambio!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar personal!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "index.php?ruta=personal&codPersonal="+codPersonal;
    }
  });
});