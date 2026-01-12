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
    <?php
    $codIngreso = $_GET["codIngreso"];
    $datosIngreso = IngresosController::ctrGetIngreso($codIngreso);
    $listaProductos = json_decode($datosIngreso["DatosProductosIngresoJson"], true);
    ?>

    <div class="container-fluid px-4">
      <!-- Header mejorado -->
      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
          <h1 class="mb-0"><i class="fa-solid fa-pen-to-square text-warning me-2"></i>Editar Ingreso
            #<?php echo $codIngreso ?></h1>
          <p class="text-muted mb-0">Modifique los datos del ingreso de producción</p>
        </div>
        <a href="ingresos" class="btn btn-outline-secondary">
          <i class="fa-solid fa-arrow-left me-1"></i> Volver a Ingresos
        </a>
      </div>
    </div>

    <div class="container-fluid px-4">
      <form role="form" method="post" class="formEditarIngreso">

        <!-- Card Datos del Ingreso -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-warning py-3">
            <h5 class="mb-0"><i class="fa-solid fa-clipboard-list me-2"></i>Datos del Ingreso</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="editResponsable" class="form-label fw-bold">
                  <i class="fa-solid fa-user-gear text-warning me-1"></i>Operador Responsable
                </label>
                <select class="form-select form-select-lg" id="editResponsable" name="editResponsable" required>
                  <?php
                  $listOperadores = PersonalController::ctrGetPersonalByType("2");
                  echo '<option value="' . $datosIngreso["IdPer"] . '">' . $datosIngreso["NombrePer"] . ' ' . $datosIngreso["ApellidoPer"] . '</option>';
                  foreach ($listOperadores as $value) {
                    if ($value["IdPer"] != $datosIngreso["IdPer"]) {
                      echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-3">
                <label for="editFechaProduccion" class="form-label fw-bold">
                  <i class="fa-solid fa-calendar-day text-warning me-1"></i>Fecha Ingreso
                </label>
                <input type="date" class="form-control form-control-lg" id="editFechaProduccion"
                  name="editFechaProduccion" value="<?php echo $datosIngreso["FechaProduccionIng"] ?>" required>
              </div>

              <div class="col-md-3">
                <label for="editFechaVencimiento" class="form-label fw-bold">
                  <i class="fa-solid fa-calendar-xmark text-warning me-1"></i>Fecha Vencimiento
                </label>
                <input type="date" class="form-control form-control-lg" id="editFechaVencimiento"
                  name="editFechaVencimiento" value="<?php echo $datosIngreso["FechaVencimientoIng"] ?>">
              </div>

              <div class="col-md-12">
                <label for="editDescripcionIngreso" class="form-label fw-bold">
                  <i class="fa-solid fa-file-lines text-warning me-1"></i>Descripción del Ingreso
                </label>
                <input type="text" class="form-control" id="editDescripcionIngreso" name="editDescripcionIngreso"
                  value="<?php echo $datosIngreso["DescripcionIng"] ?>"
                  placeholder="Ej: Producción del día, Compra de insumos, etc.">
              </div>
            </div>
          </div>
        </div>

        <!-- Card Productos -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-info text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fa-solid fa-boxes-stacked me-2"></i>Productos del Ingreso</h5>
            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modalAddProdIng">
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

            <!-- Contenedor de productos existentes -->
            <div class="form-group newProductAddIng">
              <?php
              foreach ($listaProductos as $value) {
                $datosProducto = ProductsController::ctrGetDataProducto($value["codProduct"]);
                echo '
                  <div class="row align-items-center mb-2" style="padding:5px 15px">
                    <!-- Description -->
                    <div class="col-lg-5">
                      <div class="input-group">
                        <button type="button" class="btn btn-danger btn-sm deleteNuevoiIngreso" codProduct="' . $datosProducto["IdProd"] . '">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                        <input type="text" class="form-control newProduct" codProduct="' . $datosProducto["IdProd"] . '" value="' . $datosProducto["NombreProducto"] . '" readonly>
                      </div>
                    </div>

                    <!-- Unity -->
                    <div class="col-lg-3 text-center unityMaterial">
                      <input type="text" class="form-control text-center newUnity" name="newUnity" value="' . $datosProducto["Unidad"] . '" readonly>
                    </div>

                    <!-- Count -->
                    <div class="col-lg-3 text-center countMaterial">
                      <input type="number" min="1" step="1" class="form-control text-center newCount" name="newCount" value="' . $value["countProduct"] . '">
                    </div>
                  </div>
                ';
              }
              ?>
              <input type="hidden" id="listProducts" name="listProducts">
              <input type="hidden" class="codIngreso" name="codIngreso" id="codIngreso"
                value="<?php echo $codIngreso ?>">
            </div>
          </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between mb-4">
          <a href="ingresos" class="btn btn-outline-danger btn-lg px-4 closeIngresoNuevo">
            <i class="fa-solid fa-xmark me-2"></i>Cancelar
          </a>
          <button type="submit" class="btn btn-success btn-lg px-5">
            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Cambios
          </button>
        </div>

      </form>
    </div>
  </main>
</div>
</div>

<?php
$editarIngreso = new IngresosController();
$editarIngreso->ctrEditIngreso();
?>

<!-- Modal Agregar Productos -->
<div class="modal fade" id="modalAddProdIng" tabindex="-1" role="dialog" aria-labelledby="modalAddProdIng"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title"><i class="fa-solid fa-list me-2"></i>Listado de Productos</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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