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
      <div class="d-flex m-2 buttonsSalidas">

        <button type="button" class="btn btn-secondary btnAllNotasSalida" id="btnAllNotasSalida" filtro="notasSalida"><i
            class="fa-solid fa-clipboard-check"></i>
          Registros Notas Pedido
        </button>
        <span style="margin: 0 10px;"></span>
        <button type="button" class="btn btn-info btnAllLotes" id="btnAllLotes" filtro="lotes"><i
            class="fa-solid fa-clipboard-check"></i>
          Registros Facturas
        </button>
        <span style="margin: 0 10px;"></span>

        <button type="button" class="btn btn-success" id="reporteGeneralNotas"><i
            class="fa-solid fa-file-arrow-down"></i>
          Reporte General Notas
        </button>
        <span style="margin: 0 10px;"></span>
        <button type="button" class="btn btn-warning reporteExeNotaPe" id="reporteExeNotaPe"><i
            class="fa-solid fa-file-arrow-down "></i>
          Reporte Notas
        </button>
        <span style="margin: 0 10px;"></span>
        <button type="button" class="btn btn-secondary" id="reporteExeNotaPeFech"><i
            class="fa-solid fa-calendar-days"></i>
          Reporte Notas Por Fechas
        </button>

        <button type="button" class="btn btn-success" id="reporteGeneralFacturas"><i
            class="fa-solid fa-file-arrow-down"></i>
          Reporte General Facturas
        </button>
        <span style="margin: 0 10px;"></span>
        <button type="button" class="btn btn-warning reporteExeLotes" id="reporteExeLotes"><i
            class="fa-solid fa-file-arrow-down "></i>
          Reporte Facturas
        </button>
        <span style="margin: 0 10px;"></span>
        <button type="button" class="btn btn-secondary" id="reporteExeLotesFech"><i
            class="fa-solid fa-calendar-days"></i>
          Reporte Facturas Por Fechas
        </button>

        <span style="margin: 0 10px;"></span>
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