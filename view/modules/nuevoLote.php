</div>
</div>

<div class="sb-sidenav-footer">
  <div class="small">Sesión iniciada como:</div>
  <?php echo $_SESSION["Nombre"] ?>
</div>
</nav>
</div>

<div id="layoutSidenav_content">
  <main class="bg">
    <div class="container-fluid px-4">
      <!-- Header mejorado -->
      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
          <h1 class="mb-0"><i class="fa-solid fa-file-invoice text-primary me-2"></i>Nueva Salida Factura / Lote</h1>
          <p class="text-muted mb-0">Complete los datos del cliente y agregue los productos</p>
        </div>
        <a href="verSalidas" class="btn btn-outline-secondary">
          <i class="fa-solid fa-arrow-left me-1"></i> Volver a Salidas
        </a>
      </div>
    </div>

    <div class="container-fluid px-4">
      <form role="form" method="post" class="formNuevoLote">

        <!-- Card Datos del Cliente -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-success text-white py-3">
            <h5 class="mb-0"><i class="fa-solid fa-user-tie me-2"></i>Datos del Cliente</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <label for="notRuc" class="form-label fw-bold">
                  <i class="fa-solid fa-id-card text-success me-1"></i>RUC Cliente
                </label>
                <select class="form-select form-select-lg" id="notRuc" name="notRuc">
                  <option disabled selected>Seleccione RUC</option>
                  <?php
                  $listClientes = NotaPedidoController::ctrGetNotaPeCli();
                  foreach ($listClientes as $value) {
                    echo '<option value="' . $value["IdCli"] . '">' . $value["RucCli"] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-4">
                <label for="notCli" class="form-label fw-bold">
                  <i class="fa-solid fa-building text-success me-1"></i>Nombre / Razón Social
                </label>
                <select class="form-select form-select-lg" id="notCli" name="notCli" required>
                  <option value="">Seleccione cliente</option>
                  <?php
                  foreach ($listClientes as $value) {
                    echo '<option value="' . $value["IdCli"] . '">' . $value["NombreCli"] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-4">
                <label for="notDirec" class="form-label fw-bold">
                  <i class="fa-solid fa-location-dot text-success me-1"></i>Dirección
                </label>
                <select class="form-select form-select-lg" id="notDirec" name="notDirec" disabled>
                  <option value="">Seleccione cliente</option>
                  <?php
                  foreach ($listClientes as $value) {
                    echo '<option value="' . $value["IdCli"] . '">' . $value["DireccionCli"] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- Card Datos de la Salida -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0"><i class="fa-solid fa-truck-fast me-2"></i>Datos de la Salida</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="nameResLot" class="form-label fw-bold">
                  <i class="fa-solid fa-user-check text-primary me-1"></i>Responsable
                </label>
                <select class="form-select" id="nameResLot" name="nameResLot" required>
                  <option value="">Seleccione el Responsable</option>
                  <?php
                  $listResponsables = PersonalController::ctrGetPersonalByType("1");
                  foreach ($listResponsables as $value) {
                    echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-3">
                <label for="dateCreatLot" class="form-label fw-bold">
                  <i class="fa-solid fa-calendar-day text-primary me-1"></i>Fecha Salida
                </label>
                <input type="date" class="form-control" id="dateCreatLot" name="dateCreatLot" required>
              </div>

              <div class="col-md-3">
                <label for="tipoSalida" class="form-label fw-bold">
                  <i class="fa-solid fa-tags text-primary me-1"></i>Tipo de Salida
                </label>
                <select class="form-select" name="tipoSalida" id="tipoSalida">
                  <option value="Factura">Factura</option>
                  <option value="Lote">Lote</option>
                </select>
              </div>

              <div class="col-md-4">
                <label for="numeroFactura" class="form-label fw-bold">
                  <i class="fa-solid fa-hashtag text-primary me-1"></i>Número de Factura
                </label>
                <input type="text" class="form-control" id="numeroFactura" name="numeroFactura" placeholder="Ingrese el número de Factura">
              </div>

              <div class="col-md-4">
                <label for="numeroLote" class="form-label fw-bold">
                  <i class="fa-solid fa-barcode text-primary me-1"></i>Código de Lote
                </label>
                <input type="text" class="form-control" id="numeroLote" name="numeroLote" placeholder="Ingrese el código de Lote">
              </div>

              <div class="col-md-4">
                <label for="totalFactura" class="form-label fw-bold">
                  <i class="fa-solid fa-coins text-primary me-1"></i>Total
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-primary text-white">S/</span>
                  <input type="text" class="form-control" id="totalFactura" name="totalFactura" placeholder="0.00">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Card Productos -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-warning py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fa-solid fa-boxes-stacked me-2"></i>Productos de la Salida</h5>
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalAddProdLote">
              <i class="fa-solid fa-plus me-1"></i> Agregar Productos
            </button>
          </div>
          <div class="card-body">
            <!-- Encabezado de productos -->
            <div class="row fw-bold bg-light py-2 rounded mb-2" style="padding: 5px 15px;">
              <div class="col-lg-5">Descripción</div>
              <div class="col-lg-3 text-center">Unidad</div>
              <div class="col-lg-3 text-center">Cantidad</div>
            </div>
            
            <!-- Contenedor donde JS agrega los productos -->
            <div class="form-group newProductAddLote">
              <input type="hidden" id="listProducts" name="listProducts">
            </div>
            
            <!-- Mensaje cuando no hay productos -->
            <div class="text-center py-4 text-muted" id="noProductsMessage">
              <i class="fa-solid fa-box-open fa-3x mb-3"></i>
              <p class="mb-0">No hay productos agregados.</p>
              <p class="small">Haga clic en "Agregar Productos" para comenzar.</p>
            </div>
          </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between mb-4">
          <a href="verSalidas" class="btn btn-outline-danger btn-lg px-4 closelotes">
            <i class="fa-solid fa-xmark me-2"></i>Cancelar
          </a>
          <button type="submit" class="btn btn-success btn-lg px-5">
            <i class="fa-solid fa-check me-2"></i>Registrar Salida
          </button>
        </div>

      </form>
    </div>
  </main>
</div>

</div>

<!-- Modal Agregar Productos -->
<div class="modal fade" id="modalAddProdLote" tabindex="-1" role="dialog" aria-labelledby="modalAddProdLote" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title"><i class="fa-solid fa-list me-2"></i>Listado de Productos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-3">
          <label class="form-label fw-bold"><i class="fa-solid fa-filter me-1"></i>Filtrar por Categoría:</label>
          <select name="categoriaModal" id="categoriaModal" class="form-select categoriaModal">
            <option value="">Todas las Categorías</option>
            <?php
            $listCategories = ProductsController::ctrGetAllCategories();
            foreach ($listCategories as $value) {
              echo '<option value="' . $value["NombreCategoria"] . '">' . $value["NombreCategoria"] . '</option>';
            }
            ?>
          </select>
        </div>
        <table id="dataTableProductosLote" class="table table-striped table-hover display dataTableProductosLote" width="100%">
          <thead class="table-dark">
            <tr>
              <th style="width:50px">#</th>
              <th>Producto</th>
              <th>Categoría</th>
              <th style="width:120px">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $listProducts = IngresosController::ctrGetListProducts();
            foreach ($listProducts as $key => $value) {
              echo '
                <tr>
                  <td>' . ($key + 1) . '</td>
                  <td>' . $value["NombreProducto"] . '</td>
                  <td><span class="badge bg-secondary">' . $value["NombreCategoria"] . '</span></td>
                  <td>
                    <button type="button" class="btn btn-primary btn-sm btnAddProductLote takeButtonLote" codProduct="' . $value["IdProd"] . '">
                      <i class="fa-solid fa-plus me-1"></i>Agregar
                    </button>
                  </td>
                </tr>';
            }
            ?>
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