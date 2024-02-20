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
        <li class="breadcrumb-item active">Todas las Notas de Pedido</li>
      </ol>
      <div class="d-flex m-2 buttonsSalidas">
        <button type="button" class="btn btn-primary btnAllNotasSalida" id="btnAllNotasSalida" filtro="notasSalida">
          Ver Notas de Pedido
        </button>
        <button type="button" class="btn btn-warning btnAllLotes" id="btnAllLotes" filtro="lotes">
          Ver Lotes
        </button>
        <button type="button" class="btn btn-success ReporteSalidas" id="ReporteSalidas" _blank>
          Descargar Reporte Excel
        </button>
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
                <th>Estado</th>
                <th>Fecha de Nota</th>
                <th>Productos</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $ListNotaPedido = NotaPedidoController::ctrGetAllSalidasNotaPe();
              foreach ($ListNotaPedido as $key => $value) {
                $estado = FunctionsController::ctrGetStateSalidas($value["EstadoNota"]);
                $buttons = FunctionsController::ctrGetButtonsSalidas($value["EstadoNota"], $value["IdNotaP"]);
                echo
                '<tr>                
                      <td>' . $value["IdNotaP"] . '</td>
                      <td>' . $value["NombrePerIdPer"] . '</td>
                      <td>' . $value["NombreCliNota"] . '</td>
                      <td>' . $estado . '</td>
                      <td>' . $value["FechaNotaPedido"] . '</td>
                      <td>
                        <button class="btn btn-primary btnMostarProductos" data-products="' . htmlspecialchars($value["DatosProductosNotaPedidoJson"]) . '">Productos</button>
                      </td>
                      <td>
                        ' . $buttons . '
                      </td>
                    </tr>';
              }
              ?>
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

//  Eliminar lote
$deleteLote = new LotesController();
$deleteLote->ctrDeleteLote();
?>


<!-- Modal detalles del lote -->
<div class="modal fade" id="modalViewDetallNotPe" tabindex="-1" role="dialog" aria-labelledby="modalViewDetallNotPe" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-weight: bold">Detalles Nota Pedido</h5>
      </div>
      <div class="modal-body">
        <!-- Responsable -->
        <div class="form-group">
          <label for="nombreResponsable" class="col-form-label" style="font-weight: bold">Responsable:</label>
          <input type="text" class="form-control" id="nombreResponsable" name="nombreResponsable" style="border:none" readonly>
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
          <label for="codigoLote" class="col-form-label" style="font-weight: bold">Codigo Lote:</label>
          <input type="text" class="form-control" id="codigoLote" name="codigoLote" style="border:none" readonly>
        </div>

        <!-- Fecha de Lote -->
        <div class="form-group">
          <label for="fechaLote" class="col-form-label" style="font-weight: bold">Fecha Lote:</label>
          <input type="date" class="form-control" id="fechaLote" name="fechaLote" style="border:none" readonly>
        </div>

        <!-- Fecha de Vencimiento -->
        <div class="form-group">
          <label for="fechaVencimiento" class="col-form-label" style="font-weight: bold">Fecha Vencimiento:</label>
          <input type="date" class="form-control" id="fechaVencimiento" name="fechaVencimiento" style="border:none" readonly>
        </div>

        <!-- Descripción -->
        <div class="form-group">
          <label for="descripcionLote" class="col-form-label" style="font-weight: bold">Descripción: </label>
          <input type="text" class="form-control" id="descripcionLote" name="descripcionLote" style="border:none" readonly>
        </div>

        <!-- Producto -->
        <div class="form-group">
          <label for="productoLote" class="col-form-label" style="font-weight: bold">Producto Lote:</label>
          <input type="text" class="form-control" id="productoLote" name="productoLote" style="border:none" readonly>
        </div>

        <!-- Cantidad -->
        <div class="form-group">
          <label for="cantidadProducto" class="col-form-label" style="font-weight: bold">Cantidad: </label>
          <input type="text" class="form-control" id="cantidadProducto" name="cantidadProducto" style="border:none" readonly>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>