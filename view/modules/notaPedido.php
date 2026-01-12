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
          <h1 class="mb-0"><i class="fa-solid fa-cart-plus text-success me-2"></i>Nueva Nota de Pedido</h1>
          <p class="text-muted mb-0">Complete los datos del cliente y agregue los productos</p>
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
                  <option value="">Seleccione el Responsable</option>
                  <?php
                  $listResponsables = PersonalController::ctrGetPersonalByType("1");
                  foreach ($listResponsables as $value) {
                    echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-4">
                <label for="notVend" class="form-label fw-bold">
                  <i class="fa-solid fa-user-tag text-primary me-1"></i>Vendedor
                </label>
                <select class="form-select" id="notVend" name="notVend" required>
                  <option value="">Seleccione al Vendedor</option>
                  <?php
                  $listVendedores = PersonalController::ctrGetPersonalByType("3");
                  foreach ($listVendedores as $value) {
                    echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-2">
                <label for="notFechPe" class="form-label fw-bold">
                  <i class="fa-solid fa-calendar-days text-primary me-1"></i>Fecha
                </label>
                <input type="date" class="form-control" id="notFechPe" name="notFechPe" required>
              </div>

              <div class="col-md-2">
                <label class="form-label fw-bold">
                  <i class="fa-solid fa-calculator text-primary me-1"></i>Total
                </label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text bg-success text-white fw-bold">S/</span>
                  <input type="text" class="form-control fw-bold text-end fs-4" id="notTotal" name="notTotal" readonly
                    value="0.00" style="background-color: #f8f9fa;">
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
            <!-- Encabezado - misma estructura col-lg que genera el JS -->
            <div class="row fw-bold bg-light py-2 rounded mb-2" style="padding: 5px 15px;">
              <div class="col-lg-5">Producto</div>
              <div class="col-lg-2 text-center">Precio Unit.</div>
              <div class="col-lg-2 text-center">Cantidad</div>
              <div class="col-lg-2 text-center">Subtotal</div>
            </div>

            <!-- Contenedor donde JS agrega los productos -->
            <div class="form-group newProductAddNotaP">
              <input type="hidden" id="listProductAddNotaP" name="listProductAddNotaP">
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
        <div class="d-flex justify-content-between mb-5">
          <button type="button" class="btn btn-outline-danger btn-lg closeNotaPedido">
            <i class="fa-solid fa-xmark me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-success btn-lg px-5" name="submitNotaPedido">
            <i class="fa-solid fa-check me-1"></i> Registrar Nota de Pedido
          </button>
        </div>

        <input type="hidden" id="formDataJson" name="formDataJson">
      </form>
    </div>
  </main>
</div>

</div>

<!-- Modal para agregar productos - MEJORADO -->
<div class="modal fade" id="modalAddProdIng" tabindex="-1" aria-labelledby="modalAddProdIngLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="modalAddProdIngLabel">
          <i class="fa-solid fa-boxes-stacked me-2"></i>Seleccionar Productos
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <!-- Filtro por categoría -->
        <div class="mb-3">
          <label for="categoriaModal" class="form-label fw-bold">
            <i class="fa-solid fa-filter me-1"></i>Filtrar por Categoría
          </label>
          <select name="categoriaModal" id="categoriaModal" class="form-select categoriaModal">
            <option value="">Todas las categorías</option>
            <?php
            $listCategories = ProductsController::ctrGetAllCategories();
            foreach ($listCategories as $value) {
              echo '<option value="' . $value["NombreCategoria"] . '">' . $value["NombreCategoria"] . '</option>';
            }
            ?>
          </select>
        </div>

        <!-- Tabla de productos -->
        <div class="table-responsive">
          <table id="dataTableProductosNota" class="table table-striped table-hover dataTableProductosNota"
            width="100%">
            <thead class="table-dark">
              <tr>
                <th style="width:50px">#</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th style="width:120px" class="text-center">Acción</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $listProducts = IngresosController::ctrGetListProducts();
              foreach ($listProducts as $key => $value) {
                echo '
                  <tr>
                    <td>' . ($key + 1) . '</td>
                    <td><i class="fa-solid fa-box text-muted me-2"></i>' . $value["NombreProducto"] . '</td>
                    <td><span class="badge bg-secondary">' . $value["NombreCategoria"] . '</span></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-success btn-sm btnAddProduct takeButton" codProduct="' . $value["IdProd"] . '">
                        <i class="fa-solid fa-plus me-1"></i>Agregar
                      </button>
                    </td>
                  </tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
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
$notaPedidoController->ctrCreateNotaPedido();
?>

<style>
  /* Estilos adicionales para la página de Nota de Pedido */
  .card {
    border: none;
    border-radius: 10px;
  }

  .card-header {
    border-radius: 10px 10px 0 0 !important;
  }

  .form-select-lg {
    font-size: 1rem;
  }

  .table tbody tr:hover {
    background-color: #f1f8e9 !important;
  }

  #noProductsMessage {
    display: block;
  }

  .newProductAddNotaP tr {
    animation: fadeIn 0.3s ease-in;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Mejorar inputs de cantidad en productos agregados */
  .newProductAddNotaP input[type="number"] {
    text-align: center;
    font-weight: bold;
  }

  /* Modal mejorado */
  #modalAddProdIng .modal-body {
    max-height: 60vh;
    overflow-y: auto;
  }

  #modalAddProdIng .table td {
    vertical-align: middle;
  }
</style>

<script>
  // Ocultar mensaje de "no productos" cuando se agregan productos
  document.addEventListener('DOMContentLoaded', function () {
    const observer = new MutationObserver(function () {
      const tbody = document.querySelector('.newProductAddNotaP');
      const message = document.getElementById('noProductsMessage');
      if (tbody && message) {
        // Contar solo elementos TR, no inputs ocultos
        const rows = tbody.querySelectorAll('tr');
        message.style.display = rows.length > 0 ? 'none' : 'block';
      }
    });

    const tbody = document.querySelector('.newProductAddNotaP');
    if (tbody) {
      observer.observe(tbody, { childList: true, subtree: true });
    }
  });
</script>