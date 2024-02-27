//  Crear un nuevo lote
$("#btnNewLote").on("click", function () {
  window.location = "index.php?ruta=nuevoLote";
});

//  Cerrar movimiento lote
$(".closelotes").on("click", function () {
  window.location = "verSalidas";
});

//  Cerrar visualizar lote
$(".closeVisualizarLote").on("click", function () {
  window.location = "verSalidas";
});

//  Descargar todos los lotes para el reporte exel de lotes
$("#reporteExeLotes").on("click", function () {
  window.location = "view/modules/Excel-Lotes.php?&reporteExeLotes";
});

$(".btnVisualizarSalida").on("click", function () {
  var codLote = $(this).attr("codLote");
  window.location = "index.php?ruta=visualizarLote&codSalida=" + codLote;
});

//  Descargar reporte exel de lotes por fechas
$(function () {
  var boton = $("#reporteExeLotesFech");
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
    var fechaInicioLt = rangoFechas[0];
    var fechaFinLt = rangoFechas[1];
    var fechaActualLt = new Date().toISOString().split("T")[0]; // obtiene la fecha actual en formato YYYY-MM-DD
    if (!fechaInicioLt && !fechaFinLt) {
      fechaInicioLt = fechaActualLt;
      fechaFinLt = fechaActualLt;
    } else if (!fechaFinLt) {
      fechaFinLt = fechaInicioLt;
    } else if (!fechaInicioLt) {
      fechaInicioLt = fechaFinLt;
    }
    window.location =
      "view/modules/Excel-Lotes.php?reporteExeLotesFech&fechaInicioLt=" +
      fechaInicioLt +
      "&fechaFinLt=" +
      fechaFinLt;
  });
});
/* fin */

//  cambia el conteo de  lote
$(".formNuevoLote").on("change", "input.newCount", function () {
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
  listProductAddLotes();
});

//  cambia el conteo de  lote
$(".formEditLote").on("change", "input.newCount", function () {
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
  listProductAddLotes();
});

//  borar producto agregado de la lista de lote
$(".formNuevoLote").on("click", "button.deleteNuevoLote", function () {
  $(this).parent().parent().parent().parent().remove();
  var IdProd = $(this).attr("codProduct");
  $("button.takeButtonLote[codProduct='" + IdProd + "']").removeClass(
    "btn-default"
  );
  $("button.takeButtonLote[codProduct='" + IdProd + "']").addClass(
    "btn-primary btnAddProductLote"
  );
  listProductAddLotes();
});

//  borar producto agregado de la lista de lote
$(".formEditLote").on("click", "button.deleteEditLote", function () {
  $(this).parent().parent().parent().parent().remove();
  var IdProd = $(this).attr("codProduct");
  $("button.takeButtonLote[codProduct='" + IdProd + "']").removeClass(
    "btn-default"
  );
  $("button.takeButtonLote[codProduct='" + IdProd + "']").addClass(
    "btn-primary btnAddProductLote"
  );
  listProductAddLotes();
});

// agragar producto al listado de lote
$(".tableNuevoLote").on("click", ".btnAddProductLote", function () {
  var codProductAdd = $(this).attr("codProduct");

  /*if (document.querySelector(".newProductAddLote").children.length > 1) {
    swal.fire({
      title: "Solo puedes tener un producto",
      text: "¡Ya tienes un producto dentro del lote!",
      type: "error",
      confirmButtonText: "¡Cerrar!",
    });
  } else {*/
  $(this).removeClass("btn-primary btnAddProductLote");
  $(this).addClass("btn-default");

  var datos = new FormData();
  datos.append("codProductAdd", codProductAdd);
  $.ajax({
    url: "ajax/lotes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      var IdProduct = respuesta["IdProd"];
      var DescriptionProduct = respuesta["NombreProducto"];
      var UnityProduct = respuesta["Unidad"];
      var Stock = respuesta["CantidadTotal"];

      $(".newProductAddLote").append(
        '<div class="row" style="padding:5px 15px">' +
          "<!-- Description -->" +
          '<div class="col-lg-5" style="padding-right:0px">' +
          '<div class="input-group">' +
          '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs deleteNuevoLote" codProduct="' +
          IdProduct +
          '"><i class="fa fa-times"></i></button></span>' +
          '<input type="text" class="form-control newProduct" codProduct="' +
          IdProduct +
          '" value="' +
          DescriptionProduct +
          '" readonly>' +
          "</div>" +
          "</div>" +
          "<!-- Unity -->" +
          '<div class="col-lg-3 UnityProduct">' +
          '<input type="text" class="form-control newUnity" name="newUnity" value="' +
          UnityProduct +
          '" readonly>' +
          "</div>" +
          "<!-- Count -->" +
          '<div class="col-lg-3 countMaterial">' +
          '<input type="number" min="1.00" step="1.00" class="form-control newCount" name="newCount" stock="' +
          Stock +
          '" value="1.00" >' +
          "</div>" +
          "</div>"
      );
      listProductAddLotes();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      //console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
  //}
});
/* fin */

/* Lista todos los productos agragados y los muestra en consola */
function listProductAddLotes() {
  var listProducts = [];
  var product = $(".newProduct");
  var count = $(".newCount");
  for (var i = 0; i < product.length; i++) {
    listProducts.push({
      codProduct: $(product[i]).attr("codProduct"),
      countProduct: $(count[i]).val(),
    });
  }
  console.log(listProducts); // Depuración
  $("#listProducts").val(JSON.stringify(listProducts));
}

/* fin */

//formulario ingreso en json a ajax para guardar en la base de datos

$(document).ready(function () {
  $(".formNuevoLote")
    .off("submit")
    .on("submit", function (e) {
      e.preventDefault();

      // Recoge todos los campos del formulario
      var dataArray = $(this).serializeArray();

      // Convierte el array de objetos en un solo objeto JavaScript
      var dataObject = {};
      $.each(dataArray, function (i, item) {
        dataObject[item.name] = item.value;
      });

      /* // Asegúrate de que listProducts esté en el objeto, incluso si está vacío
      if (!dataObject.hasOwnProperty("listProducts")) {
        dataObject["listProducts"] = "";
      } */
      // Llama a listProductAddLotes() y añade el resultado a dataObject
      var listProducts = listProductAddLotes();
      dataObject["listProducts"] = JSON.stringify(listProducts);

      // Convierte el objeto en una cadena JSON
      var dataJson = JSON.stringify(dataObject);

      // Muestra la cadena JSON en la consola
      console.log(dataJson);

      // Ahora puedes enviar dataJson a través de AJAX
      $.ajax({
        url: "ajax/lotes.ajax.php",
        method: "POST",
        data: { newIngLote: dataJson }, // Cambiado de 'data' a 'newIngLote'
        dataType: "json",
        success: function (response) {
          if (response === "ok") {
            Swal.fire({
              icon: "success",
              title: "Lote creado con éxito",
              showConfirmButton: false,
              timer: 1000,
            });
            $(".formNuevoLote")[0].reset();
            setTimeout(function () {
              location.reload();
            }, 1000);
          } else {
            Swal.fire({
              icon: "error",
              title: "Hubo un error al crear el Lote",
              showConfirmButton: true,
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
          Swal.fire({
            icon: "success",
            title: "Ingreso creado con éxito",
            showConfirmButton: false,
            timer: 1000,
          });
          $(".formNuevoLote")[0].reset();
          setTimeout(function () {
            location.reload();
          }, 1000);
        },
      });
    });
});
/* fin */

/* funcion con promesa js para Editar los datos  de una nota de pedido por el id */

$(".dataTableSalidas").on("click", ".btnLoteEdit", function () {
  var codLoteEdit = $(this).attr("codLoteEdit");
  window.location = "index.php?ruta=editLote&codLoteEdit=" + codLoteEdit;
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

/* funcion para enviar el formulario de actualizacion al ajx  */
//formulario ingreso en json a ajax para guardar en la base de datos
function listProductAddLotes() {
  var listProducts = [];
  var product = $(".newProduct");
  var count = $(".newCount");
  for (var i = 0; i < product.length; i++) {
    listProducts.push({
      codProduct: $(product[i]).attr("codProduct"),
      countProduct: $(count[i]).val(),
    });
  }
  //console.log("listProductAddLotes output:", listProducts); // Depuración
  return listProducts;
}

$(document).ready(function () {
  $(".formEditLote")
    .off("submit")
    .on("submit", function (e) {
      e.preventDefault();

      // Recoge todos los campos del formulario
      var dataArray = $(this).serializeArray();

      // Convierte el array de objetos en un solo objeto JavaScript
      var dataObject = {};
      $.each(dataArray, function (i, item) {
        dataObject[item.name] = item.value;
      });

      // Llama a listProductAddLotes() y añade el resultado a dataObject
      var listProducts = listProductAddLotes();
      dataObject["listProducts"] = JSON.stringify(listProducts);

      // Convierte el objeto en una cadena JSON
      var dataJson = JSON.stringify(dataObject);

      $.ajax({
        url: "ajax/lotes.ajax.php",
        method: "POST",
        data: { editLote: dataJson },
        dataType: "json",
        success: function (response) {
          if (response === "ok") {
            Swal.fire({
              icon: "success",
              title: "Lote modificado con éxito",
              showConfirmButton: false,
              timer: 1000,
            });
            setTimeout(function () {
              window.location.href = "index.php?ruta=verSalidas";
            }, 1000);
          } else {
            Swal.fire({
              icon: "error",
              title: "Hubo un error al crear el Lote",
              showConfirmButton: true,
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
        },
      });
    });
});
/* fin */

/* funcion para mostrar el mdoal con los productos de ingresos que devuelve el modelo y el controaldor en json del campo DatosProductosIngresoJson */

$(document).ready(function () {
  // Cuando se hace clic en un botón de "Ver productos"
  $(".btnMostarProductosLote").click(function () {
    // Obtiene los productos del atributo data-products del botón
    var products = JSON.parse($(this).attr("data-products"));

    // Vacía la tabla en el modal
    $("#tablaProductosLote tbody").empty();

    // Llena la tabla en el modal con los productos
    for (var i = 0; i < products.length; i++) {
      $("#tablaProductosLote tbody").append(
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
    $("#modalProductosLote").modal("show");
  });
});

/* fin */

// Alerta para eliminar lote
$(".dataTableSalidas").on("click", ".btnLoteDelet", function () {
  var codLoteDelet = $(this).attr("codLoteDelet");

  swal
    .fire({
      title: "¿Está seguro de borrar el Lote?",
      text: "¡No podrá revertir el cambio!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar Lote!",
    })
    .then((result) => {
      if (result.isConfirmed) {
        window.location =
          "index.php?ruta=verSalidas&codLoteDelet=" + codLoteDelet;
      }
    });
});
/* fin */

// Función para establecer la fecha actual en un campo
function setTodayDate(fieldId) {
  var today = new Date();
  var formattedDate = today.toISOString().slice(0, 10);
  document.getElementById(fieldId).value = formattedDate;
}

// Establecer la fecha de ingreso como la fecha actual al cargar la página
document.addEventListener("DOMContentLoaded", function () {
  setTodayDate("dateCreatLot");
});

// Función para aplicar el destello de color personalizado y mantener el estado pintado
function flashAndPaintColor(color) {
  var element = document.getElementById("stateLot");
  element.style.backgroundColor = color;
  selectedColor = color; // Almacena el color del estado seleccionado
  setTimeout(function () {
    element.style.backgroundColor = selectedColor; // Mantiene el estado pintado después del destello
  }, 1000); // 1000 milisegundos = 1 segundo
}

/* Generar codigo de lote */
function generarCodigoLote() {
  // Obtener las fechas de lote y vencimiento
  var fechaLote = document.getElementById("dateCreatLot").value;
  var fechaVencimiento = document.getElementById("dateVenciLot").value;

  // Verificar si hay una fecha de vencimiento ingresada
  if (fechaVencimiento === "") {
    // Mostrar un mensaje de alerta temporal si la fecha de vencimiento está vacía
    Swal.fire({
      icon: "warning",
      title: "Ingrese fecha de vencimiento.",
      showConfirmButton: false,
      timer: 1000,
    });
  } else {
    // Generar el código de lote
    var year = fechaLote.slice(2, 4); // Obtener los dos últimos dígitos del año
    var month = fechaLote.slice(5, 7); // Obtener el mes
    var day = fechaLote.slice(8, 10); // Obtener el día

    var codigoLote =
      "L-" +
      year +
      month +
      day +
      "#00000FV" +
      fechaVencimiento.slice(2, 4) +
      fechaVencimiento.slice(5, 7);

    // Insertar el código de lote en el campo correspondiente
    var codLotInput = document.getElementById("codLot");
    codLotInput.value = codigoLote;
    codLotInput.style.fontWeight = "bold";

    // Mostrar un mensaje de éxito temporal
    Swal.fire({
      icon: "info",
      title: "Código generado correctamente.",
      showConfirmButton: false,
      timer: 1000,
    });
  }
}

$(".dataTableSalidas").on("click", ".btnViewAllLote", function () {
  var codLote = $(this).attr("codLote");
  var data = new FormData();

  data.append("codLoteMostrarData", codLote);
  $.ajax({
    url: "ajax/lotes.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      $("#nombreResponsable").val(response["FullNamePersonal"]);
      $("#rucCliente").val(response["RucCli"]);
      $("#nombreCliente").val(response["NombreCli"]);
      $("#mostrarTipoSalida").val(response["TipoSalida"]);
      $("#fechaLote").val(response["FechaProduccionLote"]);
      $("#fechaVencimiento").val(response["FechaVencimientoLote"]);
      $("#descripcionLote").val(response["Observacion"]);
      $("#totalFactura").val(response["TotalFactura"]);

      $("#btnVisualizarSalida").attr("codLote", codLote);
    },
  });
});

$(".dataTableSalidas").on("click", ".btnUpdateLoteRetirado", function () {
  var codLoteUpdate = $(this).attr("codLoteUpdate");
  swal
    .fire({
      title: '¿Está seguro de enviar el lota al estado de "Entregado"?',
      text: "Ingrese una observación:",
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
          "index.php?ruta=verSalidas&codUpateLote=" +
          codLoteUpdate +
          "&observacion=" +
          observacion;
      }
    });
});

$(".dataTableSalidas").on("click", ".btnUpdateLoteEntregado", function () {
  var codLoteUpdate = $(this).attr("codLoteUpdateEntregado");
  swal
    .fire({
      title: '¿Está seguro de enviar el lota al estado de "Cancelado"?',
      text: "Ingrese una observación:",
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
          "index.php?ruta=verSalidas&codUpateLote=" +
          codLoteUpdate +
          "&observacion=" +
          observacion;
      }
    });
});

$(".dataTableSalidas").on("click", ".btnNullLote", function () {
  var codLoteUpdate = $(this).attr("codLote");
  swal
    .fire({
      title: '¿Está seguro que desea anular la Salida"?',
      text: "¡No se podrán deshacer los cambios!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar Lote!",
    })
    .then((result) => {
      if (result.isConfirmed) {
        window.location =
          "index.php?ruta=verSalidas&codNullLote=" + codLoteUpdate;
      }
    });
});

//  Actualizar el estado de una n
$(".dataTableSalidas").on("click", ".btnUpdateLoteVendido", function () {
  var codLoteUpdate = $(this).attr("codLoteUpdateVendido");
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
          "index.php?ruta=nuevaDevolucion&codLoteUpdate=" + codLoteUpdate;
      }
    });
});

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

$(document).ready(function () {
  $("#tipoSalida").css("background-color", "#90EE90");
  $("#numeroLote").parent().hide();

  $("#tipoSalida").change(function () {
    var selectedOption = $(this).val();

    if (selectedOption === "Factura") {
      $(this).css("background-color", "#90EE90");
      $("#numeroLote").parent().hide();
    } else if (selectedOption === "Lote") {
      $(this).css("background-color", "#ADD8E6");
      $("#numeroLote").parent().show();
    }
  });
});
