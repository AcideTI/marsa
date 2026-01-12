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
          <h1 class="mb-0"><i class="fa-solid fa-industry text-info me-2"></i>Nuevo Ingreso de Producción</h1>
          <p class="text-muted mb-0">Registre los productos fabricados o ingresados al inventario</p>
        </div>
        <a href="ingresos" class="btn btn-outline-secondary">
          <i class="fa-solid fa-arrow-left me-1"></i> Volver a Ingresos
        </a>
      </div>
    </div>

    <div class="container-fluid px-4">
      <form role="form" method="post" class="formNuevoIngreso">

        <!-- Card Datos del Ingreso -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-info text-white py-3">
            <h5 class="mb-0"><i class="fa-solid fa-clipboard-list me-2"></i>Datos del Ingreso</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="nameRes" class="form-label fw-bold">
                  <i class="fa-solid fa-user-gear text-info me-1"></i>Operador Responsable
                </label>
                <select class="form-select form-select-lg" id="nameRes" name="nameRes" required>
                  <option value="">Seleccione el Operador</option>
                  <?php
                  $listOperadores = PersonalController::ctrGetPersonalByType("2");
                  foreach ($listOperadores as $value) {
                    echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-3">
                <label for="dateProduction" class="form-label fw-bold">
                  <i class="fa-solid fa-calendar-day text-info me-1"></i>Fecha Ingreso
                </label>
                <input type="date" class="form-control form-control-lg" id="dateProduction" name="dateProduction" required>
              </div>

              <div class="col-md-3">
                <label for="dateVenci" class="form-label fw-bold">
                  <i class="fa-solid fa-calendar-xmark text-info me-1"></i>Fecha Vencimiento
                </label>
                <input type="date" class="form-control form-control-lg" id="dateVenci" name="dateVenci">
              </div>

              <div class="col-md-12">
                <label for="DescripcionIng" class="form-label fw-bold">
                  <i class="fa-solid fa-file-lines text-info me-1"></i>Descripción del Ingreso
                </label>
                <input type="text" class="form-control" id="DescripcionIng" name="DescripcionIng" placeholder="Ej: Producción del día, Compra de insumos, etc.">
              </div>
            </div>
          </div>
        </div>

        <!-- Card Productos -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-warning py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fa-solid fa-boxes-stacked me-2"></i>Productos del Ingreso</h5>
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalAddProdIng">
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
            <div class="form-group newProductAddIng">
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
          <button type="button" class="btn btn-outline-danger btn-lg px-4 closeIngresoNuevo">
            <i class="fa-solid fa-xmark me-2"></i>Cancelar
          </button>
          <button type="submit" class="btn btn-success btn-lg px-5">
            <i class="fa-solid fa-check me-2"></i>Registrar Ingreso
          </button>
        </div>

      </form>
    </div>
  </main>
</div>

</div>

<!-- Modal Agregar Productos -->
<div class="modal fade" id="modalAddProdIng" tabindex="-1" role="dialog" aria-labelledby="modalAddProdIng" aria-hidden="true">
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
        <table id="dataTableProducts" class="table table-striped table-hover display dataTableProducts" width="100%">
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
                    <button type="button" class="btn btn-primary btn-sm btnAddProduct takeButton" codProduct="' . $value["IdProd"] . '">
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