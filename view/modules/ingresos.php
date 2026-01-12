</div>
</div>
<!-- index movements -->
<div class="sb-sidenav-footer">
  <div class="small">Sesión iniciada como:</div>
  <?php echo $_SESSION["Nombre"] ?>
</div>

</nav>
</div>

<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">
      <!-- Header mejorado -->
      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
          <h1 class="mb-0"><i class="fa-solid fa-industry text-info me-2"></i>Ingresos de Producción</h1>
          <p class="text-muted mb-0">Historial de todos los ingresos registrados</p>
        </div>
      </div>

      <!-- Botones de acciones -->
      <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-info btnNewIng" id="btnNewIng">
          <i class="fa-solid fa-plus me-1"></i> Nuevo Ingreso
        </button>
        
        <!-- Dropdown Reporte por Año -->
        <div class="dropdown">
          <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="fa-solid fa-calendar me-1"></i> Reporte por Año
          </button>
          <div class="dropdown-menu p-3" style="min-width: 200px;">
            <form id="formReporteAnio">
              <div class="mb-2">
                <label class="form-label fw-bold">Seleccione el año:</label>
                <select class="form-select" id="selectAnioReporte" name="anio">
                  <?php
                  $anioActual = date('Y');
                  for ($i = $anioActual; $i >= $anioActual - 5; $i--) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                  }
                  ?>
                </select>
              </div>
              <button type="button" class="btn btn-success w-100" id="btnDescargarReporteAnio">
                <i class="fa-solid fa-download me-1"></i> Descargar
              </button>
            </form>
          </div>
        </div>

        <!-- Dropdown Reporte por Mes -->
        <div class="dropdown">
          <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="fa-solid fa-calendar-day me-1"></i> Reporte por Mes
          </button>
          <div class="dropdown-menu p-3" style="min-width: 220px;">
            <form id="formReporteMes">
              <div class="mb-2">
                <label class="form-label fw-bold">Año:</label>
                <select class="form-select" id="selectAnioMes" name="anio">
                  <?php
                  for ($i = $anioActual; $i >= $anioActual - 5; $i--) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="mb-2">
                <label class="form-label fw-bold">Mes:</label>
                <select class="form-select" id="selectMesReporte" name="mes">
                  <option value="1">Enero</option>
                  <option value="2">Febrero</option>
                  <option value="3">Marzo</option>
                  <option value="4">Abril</option>
                  <option value="5">Mayo</option>
                  <option value="6">Junio</option>
                  <option value="7">Julio</option>
                  <option value="8">Agosto</option>
                  <option value="9">Septiembre</option>
                  <option value="10">Octubre</option>
                  <option value="11">Noviembre</option>
                  <option value="12">Diciembre</option>
                </select>
              </div>
              <button type="button" class="btn btn-primary w-100" id="btnDescargarReporteMes">
                <i class="fa-solid fa-download me-1"></i> Descargar
              </button>
            </form>
          </div>
        </div>

        <button type="button" class="btn btn-secondary" id="reporteIngPorFechas">
          <i class="fa-solid fa-calendar-days me-1"></i> Reporte por Fechas
        </button>
      </div>

      <!-- Tabla de ingresos -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white py-3">
          <h5 class="mb-0"><i class="fas fa-table me-2"></i>Todos los Ingresos</h5>
        </div>
        <div class="card-body">
          <table id="tablaIngresos" class="table table-striped table-hover" style="width:100%">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Responsable</th>
                <th>Tipo Ingreso</th>
                <th>Detalle</th>
                <th>Productos</th>
                <th>Fecha Ingreso</th>
                <th>Fecha Vencimiento</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <!-- DataTables cargará los datos dinámicamente -->
            </tbody>
          </table>
        </div>
      </div>

      <?php
      $deleteIngreso = new IngresosController();
      $deleteIngreso->ctrDeleteIngreso();
      ?>
    </div>
  </main>
</div>
</div>

<!-- Modal para ver productos -->
<div class="modal fade" id="modalProductosIngreso" tabindex="-1" role="dialog" aria-labelledby="modalProductosIngreso" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title"><i class="fa-solid fa-boxes-stacked me-2"></i>Productos del Ingreso</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="tablaProductosIngreso" class="table table-striped" width="100%">
          <thead class="table-dark">
            <tr>
              <th style="width:50px">#</th>
              <th>Nombre Producto</th>
              <th style="width:120px">Cantidad</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa-solid fa-xmark me-1"></i>Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Script para DataTables Server-Side y Reportes -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Inicializar DataTables con server-side processing
  $('#tablaIngresos').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: 'ajax/ingresos.ajax.php?action=getIngresosPaginated',
      type: 'GET'
    },
    columns: [
      { data: 0 }, // IdIng
      { data: 1 }, // Responsable
      { data: 2 }, // Tipo Ingreso
      { data: 3 }, // Detalle
      { data: 4, orderable: false }, // Botón Productos
      { data: 5 }, // Fecha Ingreso
      { data: 6 }, // Fecha Vencimiento
      { data: 7, orderable: false } // Acciones
    ],
    order: [[0, 'desc']],
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
    },
    responsive: true,
    pageLength: 10,
    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]]
  });

  // Manejar clic en botón de productos (delegación de eventos)
  $(document).on('click', '.btnMostarProductosIng', function() {
    var productsData = $(this).attr('data-products');
    var products = JSON.parse(productsData);
    
    var tbody = $('#tablaProductosIngreso tbody');
    tbody.empty();
    
    products.forEach(function(product, index) {
      tbody.append(
        '<tr>' +
          '<td>' + (index + 1) + '</td>' +
          '<td>' + (product.NombreProducto || 'Producto ID: ' + product.codProduct) + '</td>' +
          '<td class="text-center"><span class="badge bg-primary">' + product.countProduct + '</span></td>' +
        '</tr>'
      );
    });
    
    $('#modalProductosIngreso').modal('show');
  });

  // Descargar reporte por AÑO
  $('#btnDescargarReporteAnio').on('click', function() {
    var anio = $('#selectAnioReporte').val();
    window.location.href = 'view/modules/Excel-Ingresos.php?reporteIngByAnio=true&anio=' + anio;
  });

  // Descargar reporte por MES
  $('#btnDescargarReporteMes').on('click', function() {
    var anio = $('#selectAnioMes').val();
    var mes = $('#selectMesReporte').val();
    window.location.href = 'view/modules/Excel-Ingresos.php?reporteIngByMes=true&anio=' + anio + '&mes=' + mes;
  });

  // Seleccionar el mes actual por defecto
  var mesActual = new Date().getMonth() + 1;
  $('#selectMesReporte').val(mesActual);
});
</script>