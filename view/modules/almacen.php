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
      <!-- Header mejorado -->
      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
          <h1 class="mb-0"><i class="fa-solid fa-warehouse text-warning me-2"></i>Inventario Almacén</h1>
          <p class="text-muted mb-0">Control de stock de todos los productos</p>
        </div>
      </div>

      <!-- Botones de acción -->
      <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-success reporteExeAlmacen" id="reporteExeAlmacen">
          <i class="fa-solid fa-file-excel me-1"></i> Descargar Inventario
        </button>
        <a href="nuevoIngreso" class="btn btn-info">
          <i class="fa-solid fa-plus me-1"></i> Nuevo Ingreso
        </a>
      </div>

      <!-- Tabla de inventario -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning py-3">
          <h5 class="mb-0"><i class="fas fa-table me-2"></i>Todos los productos</h5>
        </div>
        <div class="card-body">
          <table id="datatablesSimple" class="data-table-ListProductsAlma table table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Nombre del Producto</th>
                <th>Categoría</th>
                <th>Unidad</th>
                <th>Stock</th>
                <th>Última Actualización</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $listProducts = AlmacenController::ctrGetAllProductsIngDet();
              foreach ($listProducts as $key => $value) {
                // Determinar color del badge de stock
                $stockValue = (int) $value["CantidadTotal"];
                if ($stockValue > 0) {
                  $stockBadge = '<span class="badge bg-success fs-6">' . $stockValue . '</span>';
                } elseif ($stockValue < 0) {
                  $stockBadge = '<span class="badge bg-danger fs-6">' . $stockValue . '</span>';
                } else {
                  $stockBadge = '<span class="badge bg-secondary fs-6">0</span>';
                }

                // Botón de regularizar solo visible si stock es negativo
                $btnRegularizar = '';
                if ($stockValue < 0) {
                  $btnRegularizar = '
                      <form method="post" id="formRegularizar' . $value["IdAlma"] . '" style="display:inline;">
                        <input type="hidden" name="regularizarIdAlma" value="' . $value["IdAlma"] . '">
                        <button type="button" class="btn btn-warning btn-sm btnRegularizarStock" data-form="formRegularizar' . $value["IdAlma"] . '" data-producto="' . $value["NombreProducto"] . '" title="Poner stock en 0">
                          <i class="fa-solid fa-scale-balanced"></i> Regularizar
                        </button>
                      </form>';
                }


                // Botón de nuevo ingreso siempre visible
                $btnIngreso = '<a href="nuevoIngreso" class="btn btn-info btn-sm" title="Crear ingreso para este producto">
                    <i class="fa-solid fa-box-open"></i> Ingreso
                  </a>';

                echo
                  '<tr>
                    <td>' . ($key + 1) . '</td>
                    <td>' . $value["NombreProducto"] . '</td>
                    <td><span class="badge bg-secondary">' . $value["NombreCategoria"] . '</span></td>
                    <td>' . $value["Unidad"] . '</td>
                    <td>' . $stockBadge . '</td>
                    <td>' . $value["DateUpdate"] . ' <small class="text-muted">' . $value["HoraUpdate"] . '</small></td>
                    <td>
                      <div class="btn-group" role="group">
                        ' . $btnRegularizar . '
                        ' . $btnIngreso . '
                      </div>
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
// Procesar regularización de stock
$regularizar = new AlmacenController();
$regularizar->ctrRegularizarStockAlmacen();
?>

<script>
  $(document).ready(function () {
    // Usar delegación de eventos para que funcione con DataTables
    $(document).on('click', '.btnRegularizarStock', function (e) {
      e.preventDefault();
      var formId = $(this).attr('data-form');
      var producto = $(this).attr('data-producto');

      Swal.fire({
        icon: 'warning',
        title: '¿Regularizar Stock?',
        html: 'El stock del producto <strong>"' + producto + '"</strong> será puesto en <strong>0</strong>.<br><br>Esta acción no se puede deshacer.',
        showCancelButton: true,
        confirmButtonColor: '#ffc107',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fa-solid fa-scale-balanced"></i> Sí, Regularizar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#' + formId).submit();
        }
      });
    });
  });
</script>