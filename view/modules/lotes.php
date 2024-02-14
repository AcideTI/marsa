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
  <h1 class="mt-4">Lotes</h1>
        <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item active">Todos los Lotes</li>
        </ol>
        <div class="d-flex m-2"><span style="margin-left: 5px;"></span>
          <button type="button" class="btn btn-warning btnNewLote" id="btnNewLote">
            Crear Lote
          </button><span style="margin-left: 20px;"></span>
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
            <table id="datatablesSimple" class="data-table-OutsidesMaterials table">
              <thead>
              <tr>
                  <th>#</th>
                  <th>Responsable</th>
                  <th>Detalle Lote</th>
                  <th>Codigo Lote</th>
                  <th>Fecha Lote</th>
                  <th>Productos Lote</th>
                  <th>Fecha Vencimiento</th>
                  <th>Estado</th>
                  <th>Acciones</th>             
                </tr>
              </thead>
              <tbody>
              <?php
                  $ListNotaPedido = LotesController::ctrGetAllLotes();
                  foreach ($ListNotaPedido as $key => $value) {
                    $estado = "";
                    if ($value["TipoEstado"] == "Retirado") {
                      $estado = "<span class='badge bg-primary' style='font-size: 14px; padding: 3px; width: 70px; text-align: center;'>Retirado</span>";
                    } elseif ($value["TipoEstado"] == "Ingresado") {
                      $estado = "<span class='badge bg-warning' style='font-size: 14px; padding: 3px; width: 80px; text-align: center;'>Ingresado</span>";
                    } elseif ($value["TipoEstado"] == "Completado") {
                      $estado = "<span class='badge bg-success' style='font-size: 14px; padding: 3px; text-align: center;'>Completado</span>";
                    }
                    echo
                  '<tr>                
                      <td>' . $value["IdLote"] . '</td>
                      <td>' . $value["NombrePerIdPer"] . '</td>
                      <td>' . $value["DescripcionLote"] . '</td>
                      <td>' . $value["CodigoLote"] . '</td>
                      <td>' . $value["FechaProduccionLote"] . '</td>
                      <td><button class="btn btn-primary btnMostarProductosLote" data-products="' . htmlspecialchars($value["DatosLoteIngresoJson"]) . '">Productos</button></td>
                      <td>' . $value["FechaVencimientoLote"] . '</td>
                      <td>' . $estado . '</td>
                      <td>
                      <button class="btn btn-info btnViewDetallNotPe" data-bs-toggle="modal" data-bs-target="#modalViewDetallNotPe" codDetNotPe="' . $value["IdLote"] . '" ><i class="fa-solid fa-magnifying-glass"></i></button>
                      <button class="btn btn-warning btnLoteEdit" codLoteEdit="' . $value["IdLote"] . '"><i class="fa-solid fa-pencil"></i></button>
                      <button class="btn btn-danger btnLoteDelet" codLoteDelet="' . $value["IdLote"] . '"><i class="fa-solid fa-trash"></i></button>
                      
                    </tr>';
                }?>
                
              </tbody>
            </table>
          </div>
        </div>
    
    </div>
  </main>
</div>
</div>

<?php
$deleteLote = new LotesController();
$deleteLote->ctrDeleteLote();
?>

<!-- Modal para ver productos a través del botón "btnMostarProductosLote" de la lista -->
<div class="modal fade" id="modalProductosLote" tabindex="-1" role="dialog" aria-labelledby="modalProductosLote"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Listado de Productos Nota Pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tablaProductosLote" class="table table-striped dt-responsive" width="100%">
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