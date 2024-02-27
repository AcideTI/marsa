//  Cerrar movimiento Ingreso
$(".closeDevolucion").on("click", function () {
  window.location = "index.php?ruta=verSalidas";
});

//  Cerrar movimiento Ingreso
$(".closeNotaPedido").on("click", function () {
  window.location = "index.php?ruta=verSalidas";
});

//  Cerrar movimiento Ingreso
$(".closeVisualizarNota").on("click", function () {
  window.location = "index.php?ruta=verSalidas";
});

$(".btnVisualizarNota").on("click", function () {
  var codNotaPe = $(this).attr("codNota");
  window.location = "index.php?ruta=visualizarNotaPedido&codSalida=" + codNotaPe;
});

/* fin */

//  Crear una nueva nota de pedido
// $("#btnNewNotaDePedido").on("click", function () {
//   window.location = "index.php?ruta=notaPedido";
// });

//  Descargar todas las notas para el reporte exel de notas pedido
$("#reporteExeNotaPe").on("click", function () {
  window.location = "view/modules/Excel-Nota-Pedido.php?&reporteExeNotaPe";
});

//  Descargar reporte exel de notas por fechas
$(function () {
  var boton = $("#reporteExeNotaPeFech");
  boton.daterangepicker(
    {
      opens: "left",
      autoApply: false,
      locale: {
        format: "YYYY-MM-DD",
      },
    },
    function (start, end) {
      boton.val(start.format("YYYY-MM-DD") + " - " + end.format("YYYY-MM-DD"));
    }
  );
  //agraga la fecha actual si no se selecciona ninguna fecha al clickear en el boton aplly
  //tambien si solo se selciona una solo fecha
  boton.on("apply.daterangepicker", function (ev, picker) {
    var rangoFechas = $(this).val().split(" - ");
    var fechaInicioNot = rangoFechas[0];
    var fechaFinNot = rangoFechas[1];
    var fechaActualNot = new Date().toISOString().split("T")[0]; // obtiene la fecha actual en formato YYYY-MM-DD
    if (!fechaInicioNot && !fechaFinNot) {
      fechaInicioNot = fechaActualNot;
      fechaFinNot = fechaActualNot;
    } else if (!fechaFinNot) {
      fechaFinNot = fechaInicioNot;
    } else if (!fechaInicioNot) {
      fechaInicioNot = fechaFinNot;
    }
    window.location =
      "view/modules/Excel-Nota-Pedido.php?reporteExeNotaPeFech&fechaInicioNot=" +
      fechaInicioNot +
      "&fechaFinNot=" +
      fechaFinNot;
  });
});
/* fin */

//  Pdf de la nota de pedido

$(".dataTableSalidas").on("click", ".btnPrintNotaPedido", function () {
  var codNotaPe = $(this).attr("codNotaPe");

  if (codNotaPe != null || codNotaPe != "") {
    window.open(
      "library/FPDF/pdfNotaPedido.php?&codNotaPe=" + codNotaPe,
      "_blank"
    );
  } else {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "¡No se puede imprimir este pedido!",
    });
  }
});

/* fin */

//  cambiar cantidad de producto agregado
$(".formNotaPedido").on("change", "input.newCount", function () {
  /*var nuevoStock = Number($(this).attr("stock")) - $(this).val();
  if (nuevoStock < 0) {
    $(this).val(1);
    swal.fire({
      title: "La cantidad supera el Stock",
      text: "¡Sólo hay " + $(this).attr("stock") + " unidades!",
      type: "error",
      confirmButtonText: "¡Cerrar!",
    });
  }*/
  listProductAddNota();
});

//  borar producto agregado de la lista de ingreso
$(".formNotaPedido").on("click", "button.deleteNuevoiIngreso", function () {
  $(this).parent().parent().parent().parent().remove();
  listProductAddNota();
});

/*  agragar producto al listado de ingreso */
$(".tableNuevoIng").on("click", ".btnAddProduct", function () {
  var codProductAdd = $(this).attr("codProduct");

  var datos = new FormData();
  datos.append("codProductAdd", codProductAdd);
  $.ajax({
    url: "ajax/notaPedido.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      var IdProduct = respuesta["IdProd"];
      var DescriptionProduct = respuesta["NombreProducto"];
      var PriceProNotaP = respuesta["Precio"];
      var stock = respuesta["CantidadTotal"];

      $(".newProductAddNotaP").append(
        '<div class="row" style="padding:5px 15px">' +
          "<!-- Description -->" +
          '<div class="col-lg-5" style="padding-right:0px">' +
          '<div class="input-group">' +
          '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs deleteNuevoiIngreso" codProduct="' +
          IdProduct +
          '"><i class="fa fa-times"></i></button></span>' +
          "<!-- Idproducto -->" +
          '<input type="text" class="form-control newProduct" codProduct="' +
          IdProduct +
          '" value="' +
          DescriptionProduct +
          '" readonly>' +
          "</div>" +
          "</div>" +
          "<!-- precio producto -->" +
          '<div class="col-lg-2 PriceProNotaP">' +
          '<input type="text" class="form-control newPrice" name="newPrice" value="' +
          PriceProNotaP +
          '" >' +
          "</div>" +
          "<!-- cantidad producto -->" +
          '<div class="col-lg-2 countMaterial">' +
          '<input type="number" min="1.00" step="1.00" class="form-control newCount" name="newCount" stock="' +
          stock +
          '" value="1.00" >' +
          "</div>" +
          "<!-- suma de cantidad y precio -->" +
          '<div class="col-lg-2 sumMaterial">' +
          '<div style="font-size:24px; display: flex; align-items: center;"><span style="margin-right: 2px;">S/</span><input type="text" class="form-control newSum" name="newSum" value="' +
          PriceProNotaP +
          '" readonly>' +
          "</div>" +
          "</div>"
      );
      listProductAddNota();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      //console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});
/* fin */

/* // Recopila los datos de los productos agregados a la lista */
function listProductAddNota() {
  var listProducts = [];
  var product = $(".newProduct");
  var price = $(".newPrice");
  var count = $(".newCount");
  var Sum = $(".newSum");
  for (var i = 0; i < product.length; i++) {
    listProducts.push({
      codProduct: $(product[i]).attr("codProduct"),
      priceProduct: $(price[i]).val(),
      countProduct: $(count[i]).val(),
      newSum: $(Sum[i]).val(),
    });
  }
  //console.log(listProducts); // Imprime la lista de productos
  return listProducts;
}
/* fin */

/* recopila todos los datos del formulario y  un array json con datos de productos y los convierte en json para usarlo en el controlador con el name del campo oculto "formDataJson" */

$(document).ready(function () {
  $(".formNotaPedido").on("submit", function (e) {
    var formDataArray = $(this).serializeArray();
    var formDataObject = {};

    $.each(formDataArray, function (i, field) {
      if (
        field.name !== "listProductAddNota" &&
        field.name !== "newCount" &&
        field.name !== "newPrice"
      ) {
        formDataObject[field.name] = field.value;
      }
    });

    var listProducts = listProductAddNota();
    if (listProducts) {
      formDataObject["listProducts"] = listProducts;
    }

    //console.log(formDataObject); // Imprime los datos del formulario

    // Asigna la cadena JSON al campo de entrada oculto
    $("#formDataJson").val(JSON.stringify(formDataObject));
  });
});

/* fin */

/* funcion para mostrar el mdoal con los productos de la nota de pedido que devuelve el modelo y el controaldor en json del campo DatosProductosNotaPedidoJson */

// Cuando se hace clic en un botón de "Ver productos"
$(".dataTableSalidas").on("click", ".btnMostarProductos", function () {
  // Obtiene los productos del atributo data-products del botón
  var products = JSON.parse($(this).attr("data-products"));
  var codNota = $(this).attr("codNotaPe");

  // Vacía la tabla en el modal
  $("#tablaProductosNotaPedido tbody").empty();

  // Llena la tabla en el modal con los productos
  for (var i = 0; i < products.length; i++) {
    $("#tablaProductosNotaPedido tbody").append(
      "<tr>" +
        "<td>" +
        (i + 1) +
        "</td>" +
        "<td>" +
        products[i].NombreProducto +
        "</td>" +
        /* '<td>' + products[i].codProduct + '</td>' + */
        /* '<td>' + products[i].priceProduct + '</td>' + */
        "<td>" +
        products[i].countProduct +
        "</td>" +
        /* '<td>' + products[i].newSum + '</td>' + */
        "</tr>"
    );
  }
  // Muestra el modal 
  $("#btnVisualizarNota").attr("codNota", codNota);
  $("#modalProductosNotaPedido").modal("show");
});

/* Llama a calculateTotals() cuando se cierra el modal de agregar producto */
$("#modalAddProdIng").on("hidden.bs.modal", calculateTotals);

// Función para calcular los totales
function calculateTotals() {
  var total = 0;

  $(".newProductAddNotaP .row").each(function () {
    /* aqui actualiza el subtotal */ var price = Number(
      $(this).find(".newPrice").val()
    );
    var quantity = Number($(this).find(".newCount").val());
    total += price * quantity;
  });

  $("#notTotal").val(total.toFixed(2)).css("font-size", "24px");
}

// Llama a calculateTotals() cuando cambias la cantidad o el precio
$(document).on("input", ".newCount, .newPrice", calculateTotals);

$(document).on("click", ".deleteNuevoiIngreso", function () {
  setTimeout(calculateTotals, 1);
});

$("#modalAddProdIng").on("hidden.bs.modal", calculateTotals);
$(document).ready(calculateTotals);

// Actualiza la suma y la lista de productos cuando se cambia el precio o la cantidad
$(document).on("input", ".newPrice, .newCount", function () {
  var price = $(this).closest(".row").find(".newPrice").val();
  var count = $(this).closest(".row").find(".newCount").val();
  var sum = price * count;
  $(this).closest(".row").find(".newSum").val(sum.toFixed(2));
  // Actualiza la lista de productos
  listProductAddNota();
});
/* fin */

// Alerta para eliminar Nota de Pedido
$(".dataTableSalidas").on("click", ".btnDeleteNotaPe", function () {
  var codNotaPe = $(this).attr("codNotaPe");

  swal
    .fire({
      title: "¿Está seguro de borrar la Nota de Pedido?",
      text: "¡No podrá revertir el cambio!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar Nota de Pedido!",
    })
    .then((result) => {
      if (result.isConfirmed) {
        window.location = "index.php?ruta=verSalidas&codNotaPe=" + codNotaPe;
      }
    });
});
/* fin */
$(".dataTableSalidas").on("click", ".btnUpdateNotaRegistrado", function () {
  var codNotaPe = $(this).attr("codNotaPe");
  swal
    .fire({
      title: '¿Está seguro de enviar esta nota al estado de "Entregado"?',
      text: "Ingrese alguna observación:",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, actualizar estado!",
      input: "text",
    })
    .then((result) => {
      if (result.isConfirmed) {
        var observacion = result.value;
        window.location =
          "index.php?ruta=verSalidas&codUpdateNota=" +
          codNotaPe +
          "&observacion=" +
          observacion;
      }
    });
});

$(".dataTableSalidas").on("click", ".btnUpdateNotaCancelado", function () {
  var codNotaPe = $(this).attr("codNotaPe");
  swal
    .fire({
      title: '¿Está seguro de enviar esta nota al estado de "Cancelado"?',
      text: "Ingrese alguna observación:",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, actualizar estado!",
      input: "text",
    })
    .then((result) => {
      if (result.isConfirmed) {
        var observacion = result.value;
        window.location =
          "index.php?ruta=verSalidas&codUpdateNota=" +
          codNotaPe +
          "&observacion=" +
          observacion;
      }
    });
});

//  Actualizar el estado de una n
$(".dataTableSalidas").on("click", ".btnUpdateNotaVendido", function () {
  var codNotaPe = $(this).attr("codNotaPe");
  swal
    .fire({
      title:
        '¿Está seguro que desea devolver estos productos al almacén? Cambiará al estado de "Devolución"',
      text: "¡No podrá deshacer los cambios!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, actualizar estado!",
    })
    .then((result) => {
      if (result.isConfirmed) {
        window.location =
          "index.php?ruta=nuevaDevolucion&codUpdateNota=" + codNotaPe;
      }
    });
});

/* funcion con promesa js para Editar los datos  de una nota de pedido pro el id */

$(".dataTableSalidas").on("click", ".btnEditNotaPedido", function () {
  var codNotaPe = $(this).attr("codNotaPe");

  // Redirigir al usuario a la página de edición
  window.location = "index.php?ruta=editNotaPedido&codNotaPe=" + codNotaPe;
});

$(".dataTableSalidas").on("click", ".btnNullNotaPedido", function () {
  var codNotaPe = $(this).attr("codNotaPe");
  swal
    .fire({
      title: "¿Está seguro que desea Anular esta nota de pedido?",
      text: "¡No podrá deshacer los cambios!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, anular nota!",
    })
    .then((result) => {
      if (result.isConfirmed) {
        window.location = "index.php?ruta=verSalidas&codNotaNull=" + codNotaPe;
      }
    });
});

function getUrlParameter(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
  var results = regex.exec(location.search);
  return results === null
    ? ""
    : decodeURIComponent(results[1].replace(/\+/g, " "));
}

/* fin */

/*Función para mostrar/ocultar el campo adicional según la selección en el select */
$(document).ready(function () {
  $("#notTipoPe").change(function () {
    if ($(this).val() === "Lote") {
      $("#campoLoteAdd").show();
    } else {
      $("#campoLoteAdd").hide();
    }
  });
});
/* fin */

/* //colorea el estado y cambio de estado automatico */
$(document).ready(function () {
  var estadoOriginal = "8";
  $("#notDescrip").change(function () {
    var color = $(this).find(":selected").data("color");
    $(this).css("background-color", color);
    estadoOriginal = $(this).val();
  });

  $("#notTiPe").change(function () {
    var tipoPedido = $(this).val();
    if (tipoPedido === "Factura") {
      $("#campoFactura").show();
      $("#notDescrip").val("5").change();
    } else {
      $("#campoFactura").hide();
      if (tipoPedido === "NotaPedido") {
        $("#notDescrip").val("8").change();
      }
    }
  });

  $("#notDescrip").click(function () {
    $(this).val(estadoOriginal).trigger("change");
  });
});
/* fin */

/* Al cargar la página, verifica el estado actual y establece la fecha si es 'Devolucion' */
$(document).ready(function () {
  checkAndSetDate();
  $("#notDescrip").change(function () {
    checkAndSetDate();
  });
});

// Función para verificar el estado actual y establecer/eliminar la fecha
function checkAndSetDate() {
  var selectedState = $("#notDescrip").val();
  var currentDate = new Date().toISOString().split("T")[0];
  if (selectedState === "6") {
    $("#notFechDev").val(currentDate);
    $("#comentDev").show();
  } else {
    $("#notFechDev").val("");
    $("#comentDev").hide();
  }
}

//campo de devolucion
$(document).ready(function () {
  checkAndSetDate();
  $("#notDescrip").change(function () {
    checkAndSetDate();
  });
});

// Función para verificar el estado y tipo actual y establecer/eliminar la fecha y mostrar/ocultar el campo de comentario
function checkAndSetDate() {
  var selectedState = $("#notDescrip").val();
  var currentDate = new Date().toISOString().split("T")[0];
  if (selectedState === "6") {
    $("#notFechDev").val(currentDate);
    $("#comentDev").show();
  } else {
    $("#notFechDev").val("");
    $("#comentDev").hide();
  }
}

$(document).ready(function () {
  $("#notRuc").select2();
  $("#notCli").select2();
  $("#notDirec").select2();

  $("#notRuc").on("select2:select", function (e) {
    var data = e.params.data;
    $("#notCli").val(data.id).trigger("change");
    $("#notDirec").val(data.id).trigger("change");
  });

  $("#notCli").on("select2:select", function (e) {
    var data = e.params.data;
    $("#notRuc").val(data.id).trigger("change");
    $("#notDirec").val(data.id).trigger("change");
  });
});

// Verifica si la URL de la página es la correcta

// Si la URL es la correcta, ejecuta el código

// fecha actual para campos que se requieran
function setTodayDate(fieldId) {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, "0");
  var mm = String(today.getMonth() + 1).padStart(2, "0");
  var yyyy = today.getFullYear();
  var formattedDate = yyyy + "-" + mm + "-" + dd;

  document.getElementById(fieldId).value = formattedDate;
}

// Llama a la función para establecer la fecha actual en los campos deseados por el id
setTodayDate("notFechPe");
/* fin */

//  Cambiar la cantida de los productos que se devolverán
$(".formIngresoDevolucion").on("change", "input.countDevolucion", function () {
  var nuevoStock = Number($(this).attr("stock")) - $(this).val();
  if (nuevoStock < 0) {
    $(this).val(1);
    swal.fire({
      title: "La cantidad supera el Stock",
      text: "¡Sólo hay " + $(this).attr("stock") + " unidades!",
      type: "error",
      confirmButtonText: "¡Cerrar!",
    });
  }
  listProductosDevolucion();
});

//  Listar todos los datos que se pondrán en los input de lista de productos devolver y lista de productos merma
function listProductosDevolucion() {
  var listProductsDevolucion = [];
  var listProductsMerma = [];
  var codProducto = $(".productDevolucion");
  var countDevolucion = $(".countDevolucion");

  for (var i = 0; i < codProducto.length; i++) {
    var cantidadTotal = $(countDevolucion[i]).attr("stock");
    var cantidadDevolucion = $(countDevolucion[i]).val();
    var cantidadMerma = cantidadTotal - cantidadDevolucion;
    if (cantidadMerma > 0) {
      listProductsMerma.push({
        codProduct: $(codProducto[i]).attr("codProduct"),
        countProduct: cantidadMerma,
      });
    }
    listProductsDevolucion.push({
      codProduct: $(codProducto[i]).attr("codProduct"),
      countProduct: cantidadDevolucion,
    });
  }
  $("#listProductosDevolver").val(JSON.stringify(listProductsDevolucion));
  $("#listProductosMerma").val(JSON.stringify(listProductsMerma));
}
