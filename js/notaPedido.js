//  Cerrar movimiento Ingreso
$(".closeNotaPedido").on("click", function () {
  window.location = "index.php?ruta=verNotasPedido";
});

//  Crear una nueva nota de pedido
$("#btnNewNotaDePedido").on("click", function () {
  window.location = "index.php?ruta=notaPedido";
});

//  cambiar cantidad de producto agregado
$(".formNotaPedido").on("change", "input.newCount", function () {
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
          '"readonly>' +
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

$(document).ready(function () {
  // Cuando se hace clic en un botón de "Ver productos"
  $(".btnMostarProductos").click(function () {
    // Obtiene los productos del atributo data-products del botón
    var products = JSON.parse($(this).attr("data-products"));

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
    $("#modalProductosNotaPedido").modal("show");
  });
});

/* fin */

/* funcion para llamar los datos complementarios de la nota de pedido y mostrarlos en un modal */

$(".table").on("click", ".btnViewDetallNotPe", function () {
  var codDetNotPe = $(this).attr("codDetNotPe");
  var data = new FormData();

  data.append("codDetNotPeData", codDetNotPe);
  $.ajax({
    url: "ajax/notaPedido.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      $("#detVendedor").val(response["NombrePerIdPer"]);
      $("#detCliRuc").val(response["RucCli"]);
      $("#detTotal").val(response["Total"]);
      $("#detFactur").val(response["TipoNotaPeFactura"]);
      $("#detLote").val(response["CodigoLote"]);
      $("#detComDev").val(response["ComentarioNotaDev"]);
      $("#detFechDev").val(response["FechaNotaDevolucion"]);
    },
  });
});

/* fin */

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
$(".table").on("click", ".btnDeleteNotaPe", function () {
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
        window.location =
          "index.php?ruta=verNotasPedido&codNotaPe=" + codNotaPe;
      }
    });
});
/* fin */

/* funcion con promesa js para Editar los datos  de una nota de pedido pro el id */

$(".table").on("click", ".btnEditNotaPedido", function () {
  var codNotaPe = $(this).attr("codNotaPe");

  // Redirigir al usuario a la página de edición
  window.location = "index.php?ruta=editNotaPedido&codNotaPe=" + codNotaPe;
});

$(document).ready(function () {
  // Comprobar si estamos en la página de edición
  if (window.location.href.indexOf("editNotaPedido") > -1) {
    var codNotaPe = getUrlParameter("codNotaPe");
    var data = new FormData();

    data.append("codEditNotPeData", codNotaPe);
    $.ajax({
      url: "ajax/notaPedido.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#notRuc").val(response["IdCliente"]);
        $("#notCli").val(response["IdCliente"]);
        $("#notDirec").val(response["IdCliente"]);
        $("#notRes").val(response["IdRes"]);
        //campo notTipoPe select que debe de apararese si el tipo de nota es lote
        $("#notTipoPe").val(response["TipoDeNotaPe"]).change();
        $("#notPeLot").val(response["IdLote"]);
        //campo notTiPe select que debe de apararese si el tipo de nota es factura
        $("#notTiPe").val(response["NotaPorFA"]).change();
        $("#datosFactura").val(response["TipoNotaPeFactura"]);
        $("#notFechPe").val(response["FechaNotaPedido"]);
        $("#notVend").val(response["IdPer"]);
        $("#notDescrip").val(response["Estado"]).change();
        //campo comentDev que aparese despues que el estado es devolucion
        $("#comentDev").val(response["ComentarioNotaDev"]);
        //campo notFechDev que aparese despues que el estado es devolucion
        $("#notFechDev").val(response["FechaNotaDevolucion"]);
        $("#notSubT").val(response["SubTotal"]);
        $("#notIGV").val(response["IGV"]);
        $("#notTotal").val(response["Total"]);
        $("#submitEditNotaPedido").val(response["IdNotaP"]);
        $("#listProductAddNota").val(response["DatosProductosNotaPedidoJson"]);

        /* funcion para mostrar  los productos de la nota de pedido que devuelve el ajax en json campo DatosProductosNotaPedidoJson */

        // Obtiene los productos del campo listProductAddNota
        var products = JSON.parse($("#listProductAddNota").val());

        // Vacía el div donde se mostrarán los productos
        $(".newProductAddNotaP").empty();

        // Llena el div con los productos
        for (var i = 0; i < products.length; i++) {
          (function (i) {
            // Crea una función de cierre para capturar el valor actual de i
            // Crea un nuevo FormData
            var datos = new FormData();
            // Agrega el codProduct al FormData
            datos.append("codProductAdd", products[i].codProduct);

            // Hace una solicitud AJAX para obtener los detalles del producto
            $.ajax({
              url: "ajax/notaPedido.ajax.php",
              method: "POST",
              data: datos,
              cache: false,
              contentType: false,
              processData: false,
              dataType: "json",
              success: function (respuesta) {
                // Obtiene el nombre del producto de la respuesta
                var DescriptionProduct = respuesta["NombreProducto"];

                // Agrega el producto al div
                $(".newProductAddNotaP").append(
                  '<div class="row" style="padding:5px 15px">' +
                    '<div class="col-lg-5" style="padding-right:0px">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs deleteNuevoiIngreso" codProduct="' +
                    products[i].codProduct +
                    '"><i class="fa fa-times"></i></button></span>' +
                    '<input type="text" class="form-control newProduct" codProduct="' +
                    products[i].codProduct +
                    '" value="' +
                    products[i].DescriptionProduct +
                    '" readonly>' +
                    "</div>" +
                    "</div>" +
                    '<div class="col-lg-2 PriceProNotaP">' +
                    '<input type="text" class="form-control newPrice" name="newPrice" value="' +
                    products[i].priceProduct +
                    '">' +
                    "</div>" +
                    '<div class="col-lg-2 countMaterial">' +
                    '<input type="number" min="1.00" step="1.00" class="form-control newCount" name="newCount" value="' +
                    products[i].countProduct +
                    '">' +
                    "</div>" +
                    '<div class="col-lg-2 sumMaterial">' +
                    '<div style="font-size:24px; display: flex; align-items: center;"><span style="margin-right: 2px;">S/</span><input type="text" class="form-control newSum" name="newSum" value="' +
                    products[i].newSum +
                    '"readonly>' +
                    "</div>" +
                    "</div>"
                );
              },
            });
          })(i); // Invoca la función de cierre con el valor actual de i
        } /* fin */
      }, //fin success function editNotaPedido
    });
  }
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

// Verifica si la URL de la página es la correcta

// Si la URL es la correcta, ejecuta el código

document.getElementById("notRuc").addEventListener("change", function () {
  document.getElementById("notCli").value = this.value;
  document.getElementById("notDirec").value = this.value;
});

document.getElementById("notCli").addEventListener("change", function () {
  document.getElementById("notRuc").value = this.value;
  document.getElementById("notDirec").value = this.value;
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
