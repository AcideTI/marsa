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
      <!-- Título de la página -->
      <h1 class="mt-4">Ingresos</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Todos los Ingresos</li>
      </ol>

      <!-- Botones de acciones -->
      <div class="d-flex m-2">
        <button type="button" class="btn btn-info btnNewIng" id="btnNewIng"><i class="fa-regular fa-clipboard "></i>
          Ingresar Producción Diaria
        </button>
        <span style="margin: 0 10px;"></span>
        <button type="button" class="btn btn-warning reporteExeIngresos" id="reporteExeIngresos"><i class="fa-solid fa-file-arrow-down "></i>
          Descargar todo el Reporte
        </button>
        <span style="margin: 0 10px;"></span>
        <button type="button" class="btn btn-secondary" id="reporteIngPorFechas"><i class="fa-solid fa-calendar-days"></i>
          Descargar Reporte por fechas
        </button>
      </div>
      <!--  <span style="margin: 0 10px;"></span> -->
      <!-- Tabla de ingresos -->
      <div class="card mb-4">
        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Todos los Ingresos
        </div>
        <div class="card-body">
          <table id="datatablesSimple" class="data-table-InsidesMaterials table">
            <thead>
              <tr>
                <th>#</th>
                <th>Responsable</th>
                <th>Tipo Ingreso</th>
                <th>Detalle Ingreso</th>
                <th>Productos</th>
                <th>Fecha Ingreso</th>
                <th>Fecha Vencimiento</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $ListNotaPedido = IngresosController::ctrGetAllIngresos();
              foreach ($ListNotaPedido as $key => $value) {
                $tipoIngreso = FunctionsController::ctrGetTipoIngreso($value["TipoIngreso"]);
                $botones = FunctionsController::ctrGetButtonsIngresos($value["Estado"], $value["IdIng"]);
                echo
                '<tr>                
                  <td>' . $value["IdIng"] . '</td>
                  <td>' . $value["NombrePerIdPer"] . '</td>
                  <td>' . $tipoIngreso . '</td>
                  <td>' . $value["DescripcionIng"] . '</td>
                  <td><button class="btn btn-primary btnMostarProductosIng" data-products="' . htmlspecialchars($value["DatosProductosIngresoJson"]) . '">Productos</button></td>
                  <td>' . $value["FechaProduccionIng"] . '</td>
                  <td>' . $value["FechaVencimientoIng"] . '</td>
                  <td>' . $botones . '</td>
                </tr>';
              } ?>
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

<!-- Modal para ver productos a través del botón "btnMostarProductosIng" de la lista -->
<div class="modal fade" id="modalProductosIngreso" tabindex="-1" role="dialog" aria-labelledby="modalProductosIngreso" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Listado de Productos Nota Pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tablaProductosIngreso" class="table table-striped dt-responsive" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Nombre Producto</th>
              <!--  <th>Precio</th> -->
              <th>Cantidad</th>
              <!-- <th>Total</th> -->
              <!--  <th>Nombre</th> -->
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary pull-left" data-bs-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>