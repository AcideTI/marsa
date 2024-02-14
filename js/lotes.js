//  Crear un nuevo lote
$("#btnNewLote").on("click", function () {
  window.location = "index.php?ruta=nuevoLote";
});

//  Cerrar movimiento lote
$(".closelotes").on("click", function () {
  window.location = "index.php?ruta=lotes";
});

//  cambia el conteo de  lote
$(".formNuevoLote").on("change", "input.newCount", function () {
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
  listProductAdd();
});

//  borar producto agregado de la lista de lote
$(".formNuevoLote").on("click", "button.deleteNuevoLote", function () {
  $(this).parent().parent().parent().parent().remove();
  var IdProd = $(this).attr("codProduct");
  $("button.takeButton[codProduct='" + IdProd + "']").removeClass("btn-default");
  $("button.takeButton[codProduct='" + IdProd + "']").addClass("btn-primary btnAddProduct");
  listProductAdd();
});

// agragar producto al listado de lote

$(".tableNuevoLote").on("click", ".btnAddProduct", function () {
  var codProductAdd = $(this).attr("codProduct");

  $(this).removeClass("btn-primary btnAddProduct");
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
          '<input type="number" min="1.00" step="1.00" class="form-control newCount" name="newCount" stock="'+Stock+'" value="1.00" >' +
          "</div>" +
          "</div>"
      );
      listProductAdd();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      //console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});
/* fin */

/* Lista todos los productos agragados y los muestra en consola */
function listProductAdd() {
  var listProducts = [];
  var product = $(".newProduct");
  var count = $(".newCount");
  for (var i = 0; i < product.length; i++) {
    listProducts.push({
      codProduct: $(product[i]).attr("codProduct"),
      countProduct: $(count[i]).val(),
    });
  }
  //console.log(listProducts); // Depuración
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

      // Asegúrate de que listProducts esté en el objeto, incluso si está vacío
      if (!dataObject.hasOwnProperty("listProducts")) {
        dataObject["listProducts"] = "";
      }

      // Convierte el objeto en una cadena JSON
      var dataJson = JSON.stringify(dataObject);

      // Muestra la cadena JSON en la consola
      //console.log(dataJson);

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
          $(".formNuevoIngreso")[0].reset();
          setTimeout(function () {
            location.reload();
          }, 1000);
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
$(".table").on("click", ".btnLoteDelet", function () {
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
        window.location = "index.php?ruta=lotes&codLoteDelet=" + codLoteDelet;
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

// Evento click para el botón de Ingreso Normal
document.getElementById("genLot").addEventListener("click", function (e) {
  e.preventDefault();
  document.getElementById("stateLot").value = "7"; // Establece el estado por defecto como Ingresado
  flashAndPaintColor("#adff2f"); // Aplica el destello de color y mantiene el estado pintado
});

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

// Asignar la función generarCodigoLote al evento click del botón Generar
document.getElementById("genLot").addEventListener("click", generarCodigoLote);

// Función para detener la animación después de 3 segundos
setTimeout(function () {
  var codLotInput = document.getElementById("codLot");
  codLotInput.style.animation = "none";
}, 3000);

/* fin */
