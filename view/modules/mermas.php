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
        Mermas
      </h1>
      <span style="margin: 0 10px;"></span>
      <div class="d-flex m-2">
        <button type="button" class="btn btn-success reporteMermas" id="reporteMermas"><i class="fa-solid fa-file-arrow-down"></i>
        Descargar Mermas
        </button>
      </div>

      <div class="card mb-4">
        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Todas las mermas
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="data-table-ListProductosMerma table">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Nombre del Producto</th>
                      <th>Unidad</th>
                      <th>Cantidad</th>
                      <th>Tipo de Salida</th>
                      <th>Fecha de Devolución</th>
                      <th>Acciones</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                      $listMerma = AlmacenController::ctrGetAllMerma();
                      foreach ($listMerma as $key => $value) {
                        $botones = FunctionsController::ctrGetButtonsMermas($value["IdIngresoDev"], $value["IdSalida"], $value["TipoSalida"]);
                        echo
                          '<tr>
                          <td>' . ($key + 1) . '</td>
                          <td>' . $value["NombreProducto"] . '</td>
                          <td>' . $value["Unidad"] . '</td>
                          <td>' . $value["Cantidad"] . '</td>
                          <td>' . $value["TipoSalida"] . '</td>
                          <td>' . $value["FechaProduccionIng"] . '</td>
                          <td>' . $botones . '</td>
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
