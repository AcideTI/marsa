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
    $codNotaPedido = $_GET["codNotaPe"];
    $datosNota = NotaPedidoController::ctrGetNotaPeById($codNotaPedido);
    $listaProductos = json_decode($datosNota["DatosProductosNotaPedidoJson"], true);
    $listClientes = NotaPedidoController::ctrGetNotaPeCli();
    ?>

    <div class="container-fluid px-4">
      <!-- Header mejorado -->
      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
          <h1 class="mb-0"><i class="fa-solid fa-pen-to-square text-warning me-2"></i>Editar Nota de Pedido
            #<?php echo $codNotaPedido ?></h1>
          <p class="text-muted mb-0">Modifique los datos de la nota de pedido</p>
        </div>
        <a href="verSalidas" class="btn btn-outline-secondary">
          <i class="fa-solid fa-arrow-left me-1"></i> Volver a Salidas
        </a>
      </div>
    </div>

    <div class="container-fluid px-4">
      <form role="form" method="post" class="formNotaPedido">

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
                  echo '<option value="' . $datosNota["IdCliente"] . '">' . $datosNota["RucCli"] . '</option>';
                  foreach ($listClientes as $value) {
                    if ($value["IdCli"] != $datosNota["IdCliente"]) {
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
                  echo '<option value="' . $datosNota["IdCliente"] . '">' . $datosNota["NombreCli"] . '</option>';
                  foreach ($listClientes as $value) {
                    if ($value["IdCli"] != $datosNota["IdCliente"]) {
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
                  echo '<option value="' . $datosNota["IdCliente"] . '">' . $datosNota["DireccionCli"] . '</option>';
                  foreach ($listClientes as $value) {
                    if ($value["IdCli"] != $datosNota["IdCliente"]) {
                      echo '<option value="' . $value["IdCli"] . '">' . $value["DireccionCli"] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- Card Datos del Pedido -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0"><i class="fa-solid fa-file-invoice me-2"></i>Datos del Pedido</h5>
          </div>
          <div class="card-body">
            <div class="row g-3 align-items-end">
              <div class="col-md-4">
                <label for="notRes" class="form-label fw-bold">
                  <i class="fa-solid fa-user-check text-primary me-1"></i>Responsable
                </label>
                <select class="form-select" id="notRes" name="notRes" required>
                  <?php
                  echo '<option value="' . $datosNota["IdRes"] . '">' . $datosNota["NombreResponsable"] . ' ' . $datosNota["ApellidoResponsable"] . '</option>';
                  $listResponsables = PersonalController::ctrGetPersonalByType("1");
                  foreach ($listResponsables as $value) {
                    if ($value["IdPer"] != $datosNota["IdRes"]) {
                      echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-2">
                <label for="notFechPe" class="form-label fw-bold">
                  <i class="fa-solid fa-calendar-day text-primary me-1"></i>Fecha Pedido
                </label>
                <input type="date" class="form-control" id="notFechPe" name="notFechPe"
                  value="<?php echo $datosNota["FechaNotaPedido"] ?>" required>
              </div>

              <div class="col-md-4">
                <label for="notVend" class="form-label fw-bold">
                  <i class="fa-solid fa-user-tag text-primary me-1"></i>Vendedor
                </label>
                <select class="form-select" id="notVend" name="notVend" required>
                  <?php
                  echo '<option value="' . $datosNota["IdPer"] . '">' . $datosNota["NombreVendedor"] . ' ' . $datosNota["ApellidoVendedor"] . '</option>';
                  $listVendedores = PersonalController::ctrGetPersonalByType("3");
                  foreach ($listVendedores as $value) {
                    if ($value["IdPer"] != $datosNota["IdPer"]) {
                      echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-2">
                <label for="notTotal" class="form-label fw-bold">
                  <i class="fa-solid fa-coins text-primary me-1"></i>Total
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-primary text-white fw-bold">S/</span>
                  <input type="text" class="form-control text-end fw-bold fs-5" id="notTotal" name="notTotal"
                    value="<?php echo $datosNota["Total"] ?>" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Card Productos -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-warning py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fa-solid fa-boxes-stacked me-2"></i>Productos del Pedido</h5>
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalAddProdIng">
              <i class="fa-solid fa-plus me-1"></i> Agregar Productos
            </button>
          </div>
          <div class="card-body">
            <!-- Encabezado de productos -->
            <div class="row fw-bold bg-light py-2 rounded mb-2" style="padding: 5px 15px;">
              <div class="col-lg-5">Producto</div>
              <div class="col-lg-2 text-center">Precio</div>
              <div class="col-lg-2 text-center">Cantidad</div>
              <div class="col-lg-2 text-center">Total</div>
            </div>

            <!-- Lista de productos -->
            <div class="form-group newProductAddNotaP">
              <?php
              foreach ($listaProductos as $value) {
                $producto = AlmacenController::ctrGerProductDataById($value["codProduct"]);
                echo '
                  <div class="row align-items-center mb-2" style="padding:5px 15px">
                    <div class="col-lg-5">
                      <div class="input-group">
                        <button type="button" class="btn btn-danger btn-sm deleteProductNota" codProduct="' . $value["codProduct"] . '">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                        <input type="text" class="form-control newProduct" codProduct="' . $value["codProduct"] . '" value="' . $producto["NombreProducto"] . '" readonly>
                      </div>
                    </div>
                    
                    <div class="col-lg-2 text-center PriceProNotaP">
                      <div class="input-group">
                        <span class="input-group-text">S/</span>
                        <input type="text" class="form-control text-end newPrice" name="newPrice" value="' . $value["priceProduct"] . '">
                      </div>
                    </div>

                    <div class="col-lg-2 text-center countMaterial">
                      <input type="number" min="1" step="1" class="form-control text-center newCount" name="newCount" value="' . $value["countProduct"] . '">
                    </div>
                    
                    <div class="col-lg-2 text-center sumMaterial">
                      <div class="input-group">
                        <span class="input-group-text bg-success text-white">S/</span>
                        <input type="text" class="form-control text-end fw-bold newSum" name="newSum" value="' . $value["newSum"] . '" readonly>
                      </div>
                    </div>
                  </div>
                ';
              }
              ?>
              <input type="hidden" id="listProductAddNotaP" name="listProductAddNotaP">
              <input type="hidden" name="codNotaPedido" class="codNotaPedido" id="codNotaPedido"
                value="<?php echo $codNotaPedido ?>">
            </div>
          </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between mb-4">
          <a href="verSalidas" class="btn btn-outline-danger btn-lg px-4 closeNotaPedido">
            <i class="fa-solid fa-xmark me-2"></i>Cancelar
          </a>
          <button type="submit" class="btn btn-success btn-lg px-5" name="submitNotaPedido">
            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Cambios
          </button>
        </div>

        <input type="hidden" id="formDataJson" name="formDataJson">
      </form>
    </div>
  </main>
</div>
</div>

<!-- Modal Agregar Productos -->
<div class="modal fade" id="modalAddProdIng" tabindex="-1" role="dialog" aria-labelledby="modalAddProdIng"
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
        <table id="dataTableProductosNota" class="table table-striped table-hover display dataTableProductosNota"
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

<?php
$notaPedidoController = new NotaPedidoController();
$notaPedidoController->ctrEditarNotaPedido();
?>