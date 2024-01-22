//  Show user data
$(".table").on("click", ".btnEditUser", function () {
  var codUser = $(this).attr("codUser");
  var data = new FormData();

  data.append("codUser", codUser);
  $.ajax({
    url: "ajax/users.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      $("#editFirstName").val(response["Nombre"]);
      $("#editLastName").val(response["Apellido"]);
      $("#editUserName").val(response["NombreUsu"]);
      $("#editUserType").val(response["IdTipoUsu"]);
      $("#codUser").val(codUser);
    }
  });
});

//  Alert to delete user
$(".table").on("click", ".btnDeleteUser", function () {
  var codUser = $(this).attr("codUser");

  swal.fire({
    title: '¿Está seguro de borrar el usuario?',
    text: "¡No podrá revertir el cambio!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar usuario!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "index.php?ruta=users&codUser="+codUser;
    }
  });
});
