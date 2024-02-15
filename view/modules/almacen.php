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
      <h1 class="mt-4">
        Inventario Produccion
      </h1>
      <div class="d-flex m-2">
        <button type="button" class="btn btn-success btnDownloadProductsExcel" id="btnDownloadProductsExcel">Descargar Excel</button>
      </div>

      <div class="card mb-4">
        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Todos los insumos
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="data-table-ListProductsAlma table">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Categoría</th>
                      <th>Nombre del Producto</th>
                      <th>Unidad de medida</th>
                      <th>Cantidad Total de Producto</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                      $listProducts = AlmacenController::ctrGetAllProductsIngDet();
                      foreach ($listProducts as $key => $value) {
                        echo
                          '<tr>
                          <td>' . ($key + 1) . '</td>
                          <td>' . $value["NombreCategoria"] . '</td> <!-- Cambio aquí -->
                          <td>' . $value["NombreProducto"] . '</td>
                          <td>' . $value["Unidad"] . '</td>
                          <td>' . $value["CantidadTotal"] . '</td>
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

<!-- Modal -->
<div class="modal fade" id="modalViewProduct" tabindex="-1" role="dialog" aria-labelledby="modalViewProduct" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-weight: bold">Descripción Producto</h5>
      </div>
      <div class="modal-body">
        <!-- Código del Producto -->
        <div class="form-group">
          <label for="codeProduct" class="col-form-label" style="font-weight: bold">Código Producto:</label>
          <input type="text" class="form-control" id="codeProduct" name="codeProduct" style="border:none" readonly>
        </div>

        <!-- Descripción Producto -->
        <div class="form-group">
          <label for="descriptionProduct" class="col-form-label" style="font-weight: bold">Descripción:</label>
          <input type="text" class="form-control" id="descriptionProduct" name="descriptionProduct" style="border:none" readonly>
        </div>

        <!-- Confeccionista -->
        <div class="form-group">
          <label for="makerProduct" class="col-form-label" style="font-weight: bold">Confeccionista:</label>
          <input type="text" class="form-control" id="makerProduct" name="makerProduct" style="border:none" readonly>
        </div>

        <!-- Precio -->
        <div class="form-group">
          <label for="priceProduct" class="col-form-label" style="font-weight: bold">Precio (S/.):</label>
          <input type="text" class="form-control" id="priceProduct" name="priceProduct" style="border:none" readonly>
        </div>

        <!-- Estado del Producto -->
        <div class="form-group">
          <label for="stateProduct" class="col-form-label" style="font-weight: bold">Estado:</label>
          <input type="text" class="form-control" id="stateProduct" name="stateProduct" style="border:none" readonly>
        </div>

        <!-- Cliente -->
        <div class="form-group">
          <label for="clientProduct" class="col-form-label" style="font-weight: bold">Cliente:</label>
          <input type="text" class="form-control" id="clientProduct" name="clientProduct" style="border:none" readonly>
        </div>

        <!-- Fecha Pedido -->
        <div class="form-group">
          <label for="dateOrder" class="col-form-label" style="font-weight: bold">Fecha Pedido:</label>
          <input type="date" class="form-control" id="dateOrder" name="dateOrder" style="border:none" readonly>
        </div>
        <!-- Fecha de Entrega -->
        <div class="form-group">
          <label for="dateSend" class="col-form-label" style="font-weight: bold">Fecha de Entrega:</label>
          <input type="date" class="form-control" id="dateSend" name="dateSend" style="border:none" readonly>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>