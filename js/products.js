// Mostrar datos del producto
$(".table").on("click", ".btnEditProduct", function () {
  var codProduct = $(this).attr("codProduct");
  var data = new FormData();

  data.append("codProduct", codProduct);
  $.ajax({
    url: "ajax/products.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      $("#editProductName").val(response["NombreProducto"]);
      $("#editProductDetail").val(response["DetalleProducto"]);
      $("#editProductCategory").val(response["IdCate"]);
      $("#editProductUnit").val(response["Unidad"]);
            $("#editProductPrice").val(response["Precio"]);
      $("#codProduct").val(response["IdProd"]);
    }
  });
});

// Alerta para eliminar producto
$(".table").on("click", ".btnDeleteProduct", function () {
  var codProduct = $(this).attr("codProduct");
  var userTypeProd = $(this).attr("userTypeProd");

  if (userTypeProd != 1) {
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
    title: '¿Está seguro de borrar el producto?',
    text: "¡No podrá revertir el cambio!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar producto!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "index.php?ruta=products&codProduct="+codProduct;
    }
  });
});

//  Report donwload materials excel Enters
$("#btnDownloadMaterialsExcel").on("click", function(){
  window.location = "view/modules/descargar-reporte.php?&ReportMaterials";
});

//  Get categoria data
$(".table").on("click", ".btnEditCategoria", function () {
  var codCategoria = $(this).attr("codCategoria");
  var data = new FormData();

  data.append("codCategoria", codCategoria);
  $.ajax({
    url: "ajax/products.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      $("#editDescripcionCategoria").val(response["NombreCategoria"]);
      $("#codCategoriaEdit").val(response["IdCate"]);
    }
  });
});

// Alerta para eliminar categoria
$(".table").on("click", ".btnDeleteCategoria", function () {
  var codCategoria = $(this).attr("codCategoria");
  var userTypeCat = $(this).attr("userTypeCat");

  if (userTypeCat != 1) {
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
    title: '¿Está seguro de borrar la categoria?',
    text: "¡No podrá revertir el cambio!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar categoria!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "index.php?ruta=categorias&codCategoria="+codCategoria;
    }
  });
});