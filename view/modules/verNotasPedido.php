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
  <h1 class="mt-4">Notas de Pedido</h1>
        <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item active">Todas las Notas de Pedido</li>
        </ol>
        <div class="d-flex m-2">
          <button type="button" class="btn btn-warning btnNewNotaDePedido" id="btnNewNotaDePedido">
            Crear Nota de Pedido
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
          <table id="datatablesSimple" class="data-table-ListNotaPedido table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Responsable</th>
                  <th>Nombre Cliente</th>
                  <th>Salida</th>
                  <th>FechaNotaPedido</th>
                  <th>Productos</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
              <?php
                  $ListNotaPedido = NotaPedidoController::ctrGetAllSalidasNotaPe();
                  foreach ($ListNotaPedido as $key => $value) {
                    $estado = "";
                    if ($value["TipoEstado"] == "Retirado") {
                      $estado = "<span class='badge bg-primary' style='font-size: 14px; padding: 3px; width: 70px; text-align: center;'>Retirado</span>";
                    } elseif ($value["TipoEstado"] == "Devolucion") {
                      $estado = "<span class='badge bg-danger' style='font-size: 14px; padding: 3px; width: 80px; text-align: center;'>Devolucion</span>";
                    } elseif ($value["TipoEstado"] == "Completado") {
                      $estado = "<span class='badge bg-success' style='font-size: 14px; padding: 3px; text-align: center;'>Completado</span>";
                    }
                    echo
                  '<tr>                
                      <td>' . $value["IdNotaP"] . '</td>
                      <td>' . $value["NombrePerNotaPorFA"] . '</td>
                      <td>' . $value["NombreCliNota"] . '</td>
                      <td>' . $value["TipoDeNotaPe"] . '</td>
                      <td>' . $value["FechaNotaPedido"] . '</td>
                      <td><button class="btn btn-primary btnMostarProductos" data-products="' . htmlspecialchars($value["DatosProductosNotaPedidoJson"]) . '">Productos</button></td>
                      <td>' . $estado . '</td>
                      <td>
                      <button class="btn btn-info btnViewDetallNotPe" data-bs-toggle="modal" data-bs-target="#modalViewDetallNotPe" codDetNotPe="' . $value["IdNotaP"] . '" ><i class="fa-solid fa-search"></i></button>
                      <button class="btn btn-warning btnEditIC" codIngreso="' . $value["IdNotaP"] . '"><i class="fa-solid fa-pencil"></i></button>
                      <button class="btn btn-danger btnDeleteIC" codIngreso="' . $value["IdNotaP"] . '"><i class="fa-solid fa-trash"></i></button>
                      
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


<!-- Modal para ver productos a través del botón "btnShowProducts" de la lista -->
<div class="modal fade" id="modalProductosNotaPedido" tabindex="-1" role="dialog" aria-labelledby="modalProductosNotaPedido"
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
        <button type="button" class="btn btn-secondary pull-left" data-bs-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal detalles de nota pedido-->
<div class="modal fade" id="modalViewDetallNotPe" tabindex="-1" role="dialog" aria-labelledby="modalViewDetallNotPe" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-weight: bold">Detalles Nota Pedido</h5>
      </div>
      <div class="modal-body">
              <!-- Vendedor -->
              <div class="form-group">
          <label for="detVendedor" class="col-form-label" style="font-weight: bold">Vendedor:</label>
          <input type="text" class="form-control" id="detVendedor" name="detVendedor" style="border:none" readonly>
        </div>

        <!-- Ruc Cliente -->
        <div class="form-group">
          <label for="detCliRuc" class="col-form-label" style="font-weight: bold">Ruc Cliente:</label>
          <input type="text" class="form-control" id="detCliRuc" name="detCliRuc" style="border:none" readonly>
        </div>



        <!-- Total -->
        <div class="form-group">
          <label for="detTotal" class="col-form-label" style="font-weight: bold">Total:</label>
          <input type="text" class="form-control" id="detTotal" name="detTotal" style="border:none" readonly>
        </div>

        <!-- Factura -->

       <div class="form-group">
          <label for="detFactur" class="col-form-label" style="font-weight: bold">Factura</label>
          <input type="text" class="form-control" id="detFactur" name="detFactur" style="border:none" readonly>
        </div>


 <!-- lote -->
        <div class="form-group">
          <label for="detLote" class="col-form-label" style="font-weight: bold">Lote</label>
          <input type="text" class="form-control" id="detLote" name="detLote" style="border:none" readonly>
        </div>
        
 <!-- comentario devolucion -->
        <div class="form-group">
          <label for="detComDev" class="col-form-label" style="font-weight: bold">Comentario devolucion</label>
          <input type="text" class="form-control" id="detComDev" name="detComDev" style="border:none" readonly>
        </div>

        <!-- Fecha Devolucion -->
        <div class="form-group">
          <label for="detFechDev" class="col-form-label" style="font-weight: bold">Fecha Devolucion:</label>
          <input type="date" class="form-control" id="detFechDev" name="detFechDev" style="border:none" readonly>
        </div>



       
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>