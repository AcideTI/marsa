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
          Inventario Almacen
        </h1>
        <span style="margin: 0 10px;"></span>
        <div class="d-flex m-2">
          <button type="button" class="btn btn-success reporteExeAlmacen" id="reporteExeAlmacen"><i class="fa-solid fa-file-arrow-down "></i>
            Descargar Inventario
          </button>
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Todos los productos
          </div>
          <div class="card-body">
            <table id="datatablesSimple" class="data-table-ListProductsAlma table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombre del Producto</th>
                  <th>Categoría</th>
                  <th>Unidad</th>
                  <th>Stock</th>
                  <th>Fecha Actualización</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $listProducts = AlmacenController::ctrGetAllProductsIngDet();
                foreach ($listProducts as $key => $value) {
                  echo
                  '<tr>
                          <td>' . ($key + 1) . '</td>
                          <td>' . $value["NombreProducto"] . '</td>
                          <td>' . $value["NombreCategoria"] . '</td>
                          <td>' . $value["Unidad"] . '</td>
                          <td>' . $value["CantidadTotal"] . '</td>
                          <td>' . $value["DateUpdate"] . ' - ' . $value["HoraUpdate"] . '</td>
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