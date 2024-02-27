//  Crear un nuevo ingreso
$("#btnNewIng").on("click", function () {
  window.location = "index.php?ruta=nuevoIngreso";
});

//  Edit order approved
$(".table").on("click", ".btnEditarIngreso", function () {
  var codIngreso = $(this).attr("codIngreso");
  window.location = "index.php?ruta=editarIngreso&codIngreso=" + codIngreso;
});

//  Edit order approved
$(".table").on("click", ".btnVisualizarIngreso", function () {
  var codIngreso = $(this).attr("codIngreso");
  window.location = "index.php?ruta=visualizarIngreso&codIngreso=" + codIngreso;
});

//  Cerrar movimiento Ingreso
$(".closeIngresoNuevo").on("click", function () {
  window.location = "index.php?ruta=ingresos";
});

//  Cerrar movimiento Ingreso
$(".closeVisualizarIngreso").on("click", function () {
  window.location = "index.php?ruta=ingresos";
});

//  cambia el conteo de  productos 
$(".formNuevoIngreso").on("change", "input.newCount", function () {
  listProductAdd();
});

$(".formEditarIngreso").on("change", "input.newCount", function () {
  listProductAdd();
});

//  borar producto agregado de la lista de ingreso
$(".formNuevoIngreso").on("click", "button.deleteNuevoiIngreso", function () {
 /*  $(this).parent().parent().parent().parent().remove();
  var IdProd = $(this).attr("codProduct");
  $("button.takeButton[codProduct='" + IdProd + "']").removeClass("btn-default");
  $("button.takeButton[codProduct='" + IdProd + "']").addClass("btn-primary btnAddProduct"); */
  listProductAdd();
});

//  borar producto agregado de la lista de ingreso
$(".formEditarIngreso").on("click", "button.deleteNuevoiIngreso", function () {
  $(this).parent().parent().parent().parent().remove();
  var IdProd = $(this).attr("codProduct");
  $("button.takeButton[codProduct='" + IdProd + "']").removeClass("btn-default");
  $("button.takeButton[codProduct='" + IdProd + "']").addClass("btn-primary btnAddProduct");
  listProductAdd();
});

//  Descargar todos los ingresos para el reporte exel de ingresos
$("#reporteExeIngresos").on("click", function(){
  window.location = "view/modules/Excel-Ingresos.php?&reporteExeIngresos";
});

//  Descargar reporte exel de ingresos por fechas 
$(function() {
  var boton = $('#reporteIngPorFechas');
  boton.daterangepicker({
    opens: 'left',
    autoApply: false,
    locale: {
      format: 'YYYY-MM-DD'
    }
  }, function(start, end) {
    boton.val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
  });
  //agraga la fecha actual si no se selecciona ninguna fecha al clickear en el boton aplly
  //tambien si solo se selciona una solo fecha
  boton.on('apply.daterangepicker', function(ev, picker) {
    var rangoFechas = $(this).val().split(' - ');
    var fechaInicio = rangoFechas[0];
    var fechaFin = rangoFechas[1];
    var fechaActual = new Date().toISOString().split('T')[0]; // obtiene la fecha actual en formato YYYY-MM-DD
    if (!fechaInicio && !fechaFin) {
      fechaInicio = fechaActual;
      fechaFin = fechaActual;
    } else if (!fechaFin) {
      fechaFin = fechaInicio;
    } else if (!fechaInicio) {
      fechaInicio = fechaFin;
    }
    window.location = "view/modules/Excel-Ingresos.php?reporteIngPorFechas&fechaInicio=" + fechaInicio + "&fechaFin=" + fechaFin;
  });
});

// agragar producto al listado de ingreso
$(".tableNuevoIng").on("click", ".btnAddProduct", function () {
  var codProductAdd = $(this).attr("codProduct");

 /*  $(this).removeClass("btn-primary btnAddProduct");
  $(this).addClass("btn-default");
 */
  var datos = new FormData();
  datos.append("codProductAdd", codProductAdd);
  $.ajax({
    url: "ajax/ingresos.ajax.php",
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

      $(".newProductAddIng").append(
        '<div class="row" style="padding:5px 15px">' +
        '<!-- Description -->' +
        '<div class="col-lg-5" style="padding-right:0px">' +
        '<div class="input-group">' +

        '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs deleteNuevoiIngreso" codProduct="' + IdProduct + '"><i class="fa fa-times"></i></button></span>' +

        '<input type="text" class="form-control newProduct" codProduct="' + IdProduct + '" value="' + DescriptionProduct + '" readonly>' +
        '</div>' +
        '</div>' +

        '<!-- Unity -->' +
        '<div class="col-lg-3 UnityProduct">' +
        '<input type="text" class="form-control newUnity" name="newUnity" value="' + UnityProduct + '" readonly>' +
        '</div>' +
        
        '<!-- Count -->' +
        '<div class="col-lg-3 countMaterial">' +
        '<input type="number" min="1.00" step="1.00" class="form-control newCount" name="newCount" value="1.00" >' +
        '</div>' +
        '</div>'
      );
      listProductAdd();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      //console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    }
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
      "codProduct": $(product[i]).attr("codProduct"),
      "countProduct": $(count[i]).val(),
    });
  }
  //console.log(listProducts); // Depuración
  $("#listProducts").val(JSON.stringify(listProducts));
}

/* fin */

//formulario ingreso en json a ajax para guardar en la base de datos

$(document).ready(function() {
  $('.formNuevoIngreso').off('submit').on('submit', function(e) {
    e.preventDefault();

    // Recoge todos los campos del formulario
    var dataArray = $(this).serializeArray();

    // Convierte el array de objetos en un solo objeto JavaScript
    var dataObject = {};
    $.each(dataArray, function(i, item) {
      dataObject[item.name] = item.value;
    });

    /* // Asegúrate de que listProducts esté en el objeto, incluso si está vacío
    if (!dataObject.hasOwnProperty('listProducts')) {
      dataObject['listProducts'] = '';
    } */
     // Llama a listProductAdd() y añade el resultado a dataObject
    //  var listProducts = listProductAdd();
    //  dataObject["listProducts"] = JSON.stringify(listProducts);

    // Convierte el objeto en una cadena JSON
    var dataJson = JSON.stringify(dataObject);

    // Muestra la cadena JSON en la consola
    //console.log(dataJson);

    // Ahora puedes enviar dataJson a través de AJAX
    $.ajax({
      url: "ajax/ingresos.ajax.php",
      method: "POST",
      data: {newIngJs: dataJson}, // Cambiado de 'data' a 'newIngJs'
      dataType: "json",
      success: function(response) {
        if (response === 'ok') {
          Swal.fire({
            icon: 'success',
            title: 'Ingreso creado con éxito',
            showConfirmButton: false,
            timer: 1000
          });
          $('.formNuevoIngreso')[0].reset();
          setTimeout(function() {
            location.reload();
          }, 1000);
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Hubo un error al crear el ingreso',
            showConfirmButton: true
          });
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        //console.log(textStatus, errorThrown);
        Swal.fire({
          icon: 'success',
          title: 'Ingreso creado con éxito',
          showConfirmButton: false,
          timer: 1000
        });
        $('.formNuevoIngreso')[0].reset();
        setTimeout(function() {
          location.reload();
        }, 1000);
      }
      
    });

  });
});

/* funcion para mostrar el mdoal con los productos de ingresos que devuelve el modelo y el controaldor en json del campo DatosProductosIngresoJson */

$(document).ready(function() {
  // Cuando se hace clic en un botón de "Ver productos"
  $('.btnMostarProductosIng').click(function() {
    // Obtiene los productos del atributo data-products del botón
    var products = JSON.parse($(this).attr('data-products'));

    // Vacía la tabla en el modal
    $('#tablaProductosIngreso tbody').empty();

    // Llena la tabla en el modal con los productos
    for (var i = 0; i < products.length; i++) {
      $('#tablaProductosIngreso tbody').append(
        '<tr>' +
          '<td>' + (i + 1) + '</td>' +
          '<td>' + products[i].NombreProducto + '</td>' +
          /* '<td>' + products[i].codProduct + '</td>' + */
          /* '<td>' + products[i].priceProduct + '</td>' + */
          '<td>' + products[i].countProduct + '</td>' +
          /* '<td>' + products[i].newSum + '</td>' + */
          
        '</tr>'
      );
    }

    // Muestra el modal
    $('#modalProductosIngreso').modal('show');
  });
});

/* fin */

// Alerta para eliminar lote
$(".table").on("click", ".btnIngresoDelet", function () {
  var codIngresoDelet = $(this).attr("codIngresoDelet");

  swal.fire({
    title: '¿Está seguro de borrar el Ingreso?',
    text: "¡No podrá revertir el cambio!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar Ingreso!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "index.php?ruta=ingresos&codIngresoDelet="+codIngresoDelet;
    }
  });
});
/* fin */

// fecha actual para campos que se requieran
// Variable para almacenar el color del estado seleccionado
var selectedColor = '';

// Función para aplicar el destello de color personalizado y mantener el estado pintado al div envolvente
function flashAndPaintColorSelect(color) {
  var element = document.getElementById('stateIng');
  element.style.backgroundColor = color;
  selectedColor = color; // Almacena el color del estado seleccionado
  setTimeout(function () {
      element.style.backgroundColor = selectedColor; // Mantiene el estado pintado después del destello
  }, 1000); // 1000 milisegundos = 1 segundo
}

// Función para establecer la fecha actual en un campo
function setTodayDate(fieldId) {
    var today = new Date();
    var formattedDate = today.toISOString().slice(0, 10);
    document.getElementById(fieldId).value = formattedDate;
}

// Establecer la fecha de ingreso como la fecha actual al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    setTodayDate('dateProduction');
});

// Verifica si la fecha de vencimiento coincide con la fecha actual o es anterior
function checkExpiration() {
    var dateVenci = new Date(document.getElementById('dateVenci').value);
    var today = new Date();
    if (dateVenci.toISOString().slice(0, 10) <= today.toISOString().slice(0, 10)) {
        document.getElementById('stateIng').value = '2'; // Cambia el estado a Vencido
        flashAndPaintColorSelect('#ffff00'); // Aplica el destello de color y mantiene el estado pintado
    } else {
        document.getElementById('stateIng').value = '7'; // Cambia el estado a Ingresado
        flashAndPaintColorSelect('#adff2f'); // Aplica el destello de color y mantiene el estado pintado
    }
}

// Verifica la fecha de vencimiento cuando hay un cambio en el campo de fecha de vencimiento
document.getElementById('dateVenci').addEventListener('change', function() {
    checkExpiration();
});

// Evento click para el botón de Devolución
document.getElementById('IngVenci').addEventListener('click', function (e) {
    e.preventDefault();
    document.getElementById('stateIng').value = '6'; // Cambia el estado a Devolución
    setTodayDate('dateDev'); // Establece la fecha de devolución a la fecha actual
    document.getElementById('dateMerma').value = ''; // Limpia la fecha de merma
    flashAndPaintColorSelect('#ffcccc'); // Aplica el destello de color y mantiene el estado pintado
});

// Evento click para el botón de Merma
document.getElementById('IngMerma').addEventListener('click', function (e) {
    e.preventDefault();
    document.getElementById('stateIng').value = '9'; // Cambia el estado a Merma
    setTodayDate('dateMerma'); // Establece la fecha de merma a la fecha actual
    document.getElementById('dateDev').value = ''; // Limpia la fecha de devolución
    flashAndPaintColorSelect('#ffa500'); // Aplica el destello de color y mantiene el estado pintado
});

// Evento click para el botón de Ingreso Normal
document.getElementById('IngNormal').addEventListener('click', function (e) {
    e.preventDefault();
    document.getElementById('stateIng').value = '7'; // Establece el estado por defecto como Ingresado
    document.getElementById('dateDev').value = ''; // Limpia la fecha de devolución
    document.getElementById('dateMerma').value = ''; // Limpia la fecha de merma
    setTodayDate('dateProduction'); // Establece la fecha de ingreso como la fecha actual
    flashAndPaintColorSelect('#adff2f'); // Aplica el destello de color y mantiene el estado pintado
});

  /* fin */

