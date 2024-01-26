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
      $("#editProductQuantity").val(response["Cantidad"]);
      $("#editProductPrice").val(response["Precio"]);
      $("#codProduct").val(response["IdProd"]);
    }
  });
});

// Alerta para eliminar producto
$(".table").on("click", ".btnDeleteProduct", function () {
  var codProduct = $(this).attr("codProduct");

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
