</div>
</div>

<div class="sb-sidenav-footer">
  <div class="small">Sesión iniciada como:</div>
  <?php echo $_SESSION["Nombre"] ?>
</div>
</nav>
</div>

<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">

      <!-- Salidas -->
      <h1 class="mt-4 tituloSalidas">Notas de Pedido</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Todos los Registros</li>
      </ol>
      <!-- ============================================ -->
      <!-- SELECTOR DE TIPO DE REGISTROS (Tabs Style) -->
      <!-- ============================================ -->
      <div class="card mb-3">
        <div class="card-body p-2">
          <div class="row">
            <!-- Sección: NOTAS DE PEDIDO -->
            <div class="col-md-6">
              <div class="card border-primary h-100" id="cardNotas" style="border-width: 2px;">
                <div class="card-header bg-primary text-white py-2">
                  <i class="fa-solid fa-clipboard-list me-2"></i>
                  <strong>Notas de Pedido</strong>
                </div>
                <div class="card-body py-2">
                  <p class="card-text small text-muted mb-2">
                    <i class="fa-solid fa-info-circle me-1"></i>
                    Pedidos de clientes antes de generar factura
                  </p>
                  <div class="d-flex flex-wrap gap-2 buttonsSalidas">
                    <button type="button" class="btn btn-primary btn-sm btnAllNotasSalida" id="btnAllNotasSalida" filtro="notasSalida">
                      <i class="fa-solid fa-eye me-1"></i>
                      Ver Notas de Pedido
                    </button>
                    <button type="button" class="btn btn-success btn-sm" id="reporteGeneralNotas" title="Descargar todas las notas en Excel">
                      <i class="fa-solid fa-file-excel me-1"></i>
                      Excel General
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm" id="reporteExeNotaPe" title="Descargar notas con detalle de productos">
                      <i class="fa-solid fa-file-arrow-down me-1"></i>
                      Excel Detallado
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="reporteExeNotaPeFech" title="Descargar notas por rango de fechas">
                      <i class="fa-solid fa-calendar-days me-1"></i>
                      Por Fechas
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sección: FACTURAS/LOTES -->
            <div class="col-md-6">
              <div class="card border-info h-100" id="cardFacturas" style="border-width: 2px; opacity: 0.7;">
                <div class="card-header bg-info text-white py-2">
                  <i class="fa-solid fa-file-invoice-dollar me-2"></i>
                  <strong>Facturas / Lotes</strong>
                </div>
                <div class="card-body py-2">
                  <p class="card-text small text-muted mb-2">
                    <i class="fa-solid fa-info-circle me-1"></i>
                    Salidas facturadas y lotes de productos
                  </p>
                  <div class="d-flex flex-wrap gap-2 buttonsSalidas">
                    <button type="button" class="btn btn-info btn-sm btnAllLotes" id="btnAllLotes" filtro="lotes">
                      <i class="fa-solid fa-eye me-1"></i>
                      Ver Facturas
                    </button>
                    <button type="button" class="btn btn-success btn-sm" id="reporteGeneralFacturas" title="Descargar todas las facturas en Excel">
                      <i class="fa-solid fa-file-excel me-1"></i>
                      Excel General
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm" id="reporteExeLotes" title="Descargar facturas con detalle de productos">
                      <i class="fa-solid fa-file-arrow-down me-1"></i>
                      Excel Detallado
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="reporteExeLotesFech" title="Descargar facturas por rango de fechas">
                      <i class="fa-solid fa-calendar-days me-1"></i>
                      Por Fechas
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Indicador de datos actuales -->
      <div class="alert alert-light border mb-3 py-2" role="alert">
        <i class="fa-solid fa-database me-2"></i>
        <strong>Mostrando:</strong> <span class="tituloSalidas badge bg-primary">Notas de Pedido</span>
        <small class="text-muted ms-2">Haga clic en "Ver Notas de Pedido" o "Ver Facturas" para cambiar la vista</small>
      </div>


      <div class="card mb-4">
        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Todas las Salidas

        </div>
        <div class="card-body">
          <table id="dataTableSalidas" class="display dataTableSalidas" style="width: 100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Responsable</th>
                <th>Nombre Cliente</th>
                <th>Vendedor</th>
                <th>Estado</th>
                <th>Fecha de Nota</th>
                <th>Productos</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <!-- Los datos se cargan dinámicamente via AJAX con server-side processing -->
              <!-- Esto mejora significativamente el rendimiento al cargar solo los registros necesarios -->
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </main>
</div>
</div>

<?php
//  Eliminar nota de pedido
$deleteNotaPe = new NotaPedidoController();
$deleteNotaPe->ctrDeleteNotaPedido();
$updateNotaPe = new NotaPedidoController();
$updateNotaPe->ctrUpdateNotaPedido();
$nullNotaPe = new NotaPedidoController();
$nullNotaPe->ctrNullNotaPedido();

//  Eliminar lote
$deleteLote = new LotesController();
$deleteLote->ctrDeleteLote();
$updateLote = new LotesController();
$updateLote->ctrUpdateLoteEstado();
$nullLote = new LotesController();
$nullLote->ctrNullLote();


?>

<!-- Modal para ver productos a través del botón "btnShowProducts" de la lista -->

<div class="modal fade" id="modalProductosNotaPedido" tabindex="-1" role="dialog"
  aria-labelledby="modalProductosNotaPedido" aria-hidden="true" style="display: none;">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detale Nota Pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tablaProductosNotaPedido" class="table table-striped dt-responsive" width="100%">
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
        <button type="button" class="btn btn-primary pull-right btnVisualizarNota" id="btnVisualizarNota">Ver
          más</button>
        <button type="button" class="btn btn-secondary pull-left" data-bs-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal detalles del lote -->
<div class="modal fade" id="modalViewDetallNotPe" tabindex="-1" role="dialog" aria-labelledby="modalViewDetallNotPe"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-weight: bold">Detalle de la Salida</h5>
      </div>
      <div class="modal-body">
        <!-- Responsable -->
        <div class="form-group">
          <label for="nombreResponsable" class="col-form-label" style="font-weight: bold">Responsable:</label>
          <input type="text" class="form-control" id="nombreResponsable" name="nombreResponsable" style="border:none"
            readonly>
        </div>

        <!-- Ruc Cliente -->
        <div class="form-group">
          <label for="rucCliente" class="col-form-label" style="font-weight: bold">Ruc Cliente:</label>
          <input type="text" class="form-control" id="rucCliente" name="rucCliente" style="border:none" readonly>
        </div>

        <!-- Nombre Cliente -->
        <div class="form-group">
          <label for="nombreCliente" class="col-form-label" style="font-weight: bold">Nombre Cliente:</label>
          <input type="text" class="form-control" id="nombreCliente" name="nombreCliente" style="border:none" readonly>
        </div>

        <!-- Codigo Lote -->
        <div class="form-group">
          <label for="mostrarTipoSalida" class="col-form-label" style="font-weight: bold">Tipo de Salida:</label>
          <input type="text" class="form-control" id="mostrarTipoSalida" name="mostrarTipoSalida" style="border:none"
            readonly>
        </div>

        <!-- Total -->
        <div class="form-group">
          <label for="totalFactura" class="col-form-label" style="font-weight: bold">Total:</label>
          <input type="text" class="form-control" id="totalFactura" name="totalFactura" style="border:none" readonly>
        </div>

        <!-- Fecha de Lote -->
        <div class="form-group">
          <label for="fechaLote" class="col-form-label" style="font-weight: bold">Fecha Salida:</label>
          <input type="date" class="form-control" id="fechaLote" name="fechaLote" style="border:none" readonly>
        </div>

        <!-- Descripción -->
        <div class="form-group">
          <label for="descripcionLote" class="col-form-label" style="font-weight: bold">Observacion: </label>
          <input type="text" class="form-control" id="descripcionLote" name="descripcionLote" style="border:none"
            readonly>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-primary pull-right btnVisualizarSalida" id="btnVisualizarSalida">Ver
            más</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>