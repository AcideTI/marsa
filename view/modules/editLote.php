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
    $codLote = $_GET["codLoteEdit"];
    $datosLote = LotesController::ctrGetEditLoteData($codLote);
    $listClientes = NotaPedidoController::ctrGetNotaPeCli();
    $listaProductos = json_decode($datosLote["DatosLoteIngresoJson"], true);
    ?>

    <div class="container-fluid px-4">
      <!-- Header mejorado -->
      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
          <h1 class="mb-0">
            <i class="fa-solid fa-pen-to-square text-warning me-2"></i>Editar Salida #<?php echo $codLote ?>
            <?php if ($datosLote["TipoSalida"] == "Factura"): ?>
              <span class="badge bg-success ms-2">Factura</span>
            <?php else: ?>
              <span class="badge bg-info ms-2">Lote</span>
            <?php endif; ?>
          </h1>
          <p class="text-muted mb-0">Modifique los datos de la salida</p>
        </div>
        <a href="verSalidas" class="btn btn-outline-secondary">
          <i class="fa-solid fa-arrow-left me-1"></i> Volver a Salidas
        </a>
      </div>
    </div>

    <div class="container-fluid px-4">
      <form role="form" method="post" class="formEditLote">
        <input type="hidden" id="idLoteEdit" name="idLoteEdit">

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
                  <?php
                  echo '<option value="' . $datosLote["IdCliente"] . '">' . $datosLote["RucCli"] . '</option>';
                  foreach ($listClientes as $value) {
                    if ($value["IdCli"] != $datosLote["IdCliente"]) {
                      echo '<option value="' . $value["IdCli"] . '">' . $value["RucCli"] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-4">
                <label for="notCli" class="form-label fw-bold">
                  <i class="fa-solid fa-building text-success me-1"></i>Nombre / Razón Social
                </label>
                <select class="form-select form-select-lg" id="notCli" name="notCli" required>
                  <?php
                  echo '<option value="' . $datosLote["IdCliente"] . '">' . $datosLote["NombreCli"] . '</option>';
                  foreach ($listClientes as $value) {
                    if ($value["IdCli"] != $datosLote["IdCliente"]) {
                      echo '<option value="' . $value["IdCli"] . '">' . $value["NombreCli"] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-4">
                <label for="notDirec" class="form-label fw-bold">
                  <i class="fa-solid fa-location-dot text-success me-1"></i>Dirección
                </label>
                <select class="form-select form-select-lg" id="notDirec" name="notDirec" disabled>
                  <?php
                  echo '<option value="' . $datosLote["IdCliente"] . '">' . $datosLote["DireccionCli"] . '</option>';
                  foreach ($listClientes as $value) {
                    if ($value["IdCli"] != $datosLote["IdCliente"]) {
                      echo '<option value="' . $value["IdCli"] . '">' . $value["DireccionCli"] . '</option>';
                    }
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
              <div class="col-md-5">
                <label for="editarResponsable" class="form-label fw-bold">
                  <i class="fa-solid fa-user-check text-primary me-1"></i>Responsable
                </label>
                <select class="form-select" id="editarResponsable" name="editarResponsable" required>
                  <?php
                  echo '<option value="' . $datosLote["IdPer"] . '">' . $datosLote["FullNamePersonal"] . '</option>';
                  $listResponsables = PersonalController::ctrGetPersonalByType("1");
                  foreach ($listResponsables as $value) {
                    if ($value["IdPer"] != $datosLote["IdPer"]) {
                      echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-3">
                <label for="editarFechaLote" class="form-label fw-bold">
                  <i class="fa-solid fa-calendar-day text-primary me-1"></i>Fecha Salida
                </label>
                <input type="date" class="form-control" id="editarFechaLote" name="editarFechaLote"
                  value="<?php echo $datosLote["FechaProduccionLote"] ?>" required>
              </div>

              <div class="col-md-2">
                <label class="form-label fw-bold">
                  <i class="fa-solid fa-tags text-primary me-1"></i>Tipo de Salida
                </label>
                <?php if ($datosLote["TipoSalida"] == "Factura"): ?>
                  <input type="text" class="form-control text-center fw-bold" value="Factura"
                    style="background-color: #d4edda; color: #155724;" disabled>
                <?php else: ?>
                  <input type="text" class="form-control text-center fw-bold" value="Lote"
                    style="background-color: #d1ecf1; color: #0c5460;" disabled>
                <?php endif; ?>
              </div>

              <div class="col-md-2">
                <label for="editarEstadoLote" class="form-label fw-bold">
                  <i class="fa-solid fa-circle-info text-primary me-1"></i>Estado
                </label>
                <?php
                $inputLote = FunctionsController::ctrGetStateEditLote($datosLote["Estado"]);
                echo $inputLote;
                ?>
              </div>

              <?php if ($datosLote["TipoSalida"] == "Factura"): ?>
                <div class="col-md-4">
                  <label for="editarNumeroFactura" class="form-label fw-bold">
                    <i class="fa-solid fa-hashtag text-primary me-1"></i>Número de Factura
                  </label>
                  <input type="text" class="form-control" id="editarNumeroFactura" name="editarNumeroFactura"
                    value="<?php echo $datosLote["NroFactura"] ?>">
                </div>
                <div class="col-md-4">
                  <label for="totalFactura" class="form-label fw-bold">
                    <i class="fa-solid fa-coins text-primary me-1"></i>Total
                  </label>
                  <div class="input-group">
                    <span class="input-group-text bg-primary text-white">S/</span>
                    <input type="text" class="form-control" id="totalFactura" name="totalFactura"
                      value="<?php echo $datosLote["TotalFactura"] ?>">
                  </div>
                </div>
              <?php else: ?>
                <div class="col-md-4">
                  <label for="editarNumeroFactura" class="form-label fw-bold">
                    <i class="fa-solid fa-hashtag text-primary me-1"></i>Número de Factura
                  </label>
                  <input type="text" class="form-control" id="editarNumeroFactura" name="editarNumeroFactura"
                    value="<?php echo $datosLote["NroFactura"] ?>">
                </div>
                <div class="col-md-4">
                  <label for="editarNumeroLote" class="form-label fw-bold">
                    <i class="fa-solid fa-barcode text-primary me-1"></i>Código de Lote
                  </label>
                  <input type="text" class="form-control" id="editarNumeroLote" name="editarNumeroLote"
                    value="<?php echo $datosLote["CodigoLote"] ?>">
                </div>
                <div class="col-md-4">
                  <label for="totalFactura" class="form-label fw-bold">
                    <i class="fa-solid fa-coins text-primary me-1"></i>Total
                  </label>
                  <div class="input-group">
                    <span class="input-group-text bg-primary text-white">S/</span>
                    <input type="text" class="form-control" id="totalFactura" name="totalFactura"
                      value="<?php echo $datosLote["TotalFactura"] ?>">
                  </div>
                </div>
              <?php endif; ?>
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

            <!-- Lista de productos -->
            <div class="form-group newProductAddLote">
              <?php
              foreach ($listaProductos as $value) {
                $producto = LotesController::ctrGetProductDataAjx($value["codProduct"]);
                echo '
                  <div class="row align-items-center mb-2" style="padding:5px 15px">
                    <div class="col-lg-5">
                      <div class="input-group">
                        <button type="button" class="btn btn-danger btn-sm deleteEditLote" codProduct="' . $producto["IdProd"] . '">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                        <input type="text" class="form-control newProduct" id="newProduct" name="newProduct" codProduct="' . $producto["IdProd"] . '" value="' . $producto["NombreProducto"] . '" readonly>
                      </div>
                    </div>
                    <div class="col-lg-3 text-center UnityProduct">
                      <input type="text" class="form-control text-center" name="newUnity" value="' . $producto["Unidad"] . '" readonly>
                    </div>
                    <div class="col-lg-3 text-center countMaterial">
                      <input type="number" class="form-control text-center newCount" min="1" step="1" name="newCount" value="' . $value["countProduct"] . '">
                    </div>
                  </div>
                ';
              }
              ?>
              <input type="hidden" id="listProducts" name="listProducts">
              <input type="hidden" name="codLoteEditar" id="codLoteEditar" class="codLoteEditar"
                value="<?php echo $codLote ?>">
            </div>
          </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between mb-4">
          <a href="verSalidas" class="btn btn-outline-danger btn-lg px-4 closelotes">
            <i class="fa-solid fa-xmark me-2"></i>Cancelar
          </a>
          <button type="submit" class="btn btn-success btn-lg px-5 btnEditLoteBack">
            <i class="fa-solid fa-floppy-disk me-2"></i>Actualizar Salida
          </button>
        </div>

      </form>
    </div>
  </main>
</div>
</div>

<!-- Modal Agregar Productos -->
<div class="modal fade" id="modalAddProdLote" tabindex="-1" role="dialog" aria-labelledby="modalAddProdLote"
  aria-hidden="true">
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
        <table id="dataTableProductosLote" class="table table-striped table-hover display dataTableProductosLote"
          width="100%">
          <thead class="table-dark">
            <tr>
              <th style="width:50px">#</th>
              <th>Descripción</th>
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