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
      <h1 class="mt-4">
        Editar Ingreso de Produccion
      </h1>
      <?php
      $codIngreso = $_GET["codIngreso"];
      $datosIngreso = IngresosController::ctrGetIngreso($codIngreso);
      $listaProductos = json_decode($datosIngreso["DatosProductosIngresoJson"], true);
      ?>
    </div>

    <div class="container-fluid">
      <form role="form" method="post" class="row g-3 m-2 formEditarIngreso">
        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Datos de Produccion</h3>
            <!-- Select Provider-->
            <div class="form-group col-md-8">
              <label for="editResponsable" class="form-label" style="font-weight: bold">Responsable:</label>
              <select class="form-control input-lg" id="editResponsable" name="editResponsable" required>
                <?php
                $listOperadores = PersonalController::ctrGetPersonalByType("2");
                echo '<option value="' . $datosIngreso["IdPer"] . '">' . $datosIngreso["NombrePer"] . ' ' . $datosIngreso["ApellidoPer"] . '</option>';
                foreach ($listOperadores as $value) {
                  echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="col-md-3">
              <label for="editFechaProduccion" class="form-label" style="font-weight: bold">Fecha Ingreso: </label>
              <input type="date" class="form-control" id="editFechaProduccion" name="editFechaProduccion" value="<?php echo $datosIngreso["FechaProduccionIng"] ?>" required>
            </div>

            <div class="form-group col-md-8">
              <label for="editDescripcionIngreso" class="form-label" style="font-weight: bold">Descripción de Ingreso:</label>
              <input type="text" class="form-control" id="editDescripcionIngreso" name="editDescripcionIngreso" value="<?php echo $datosIngreso["DescripcionIng"] ?>"" placeholder=" Descripcion Ingreso">
            </div>

            <div class="col-md-3">
              <label for="editFechaVencimiento" class="form-label" style="font-weight: bold">Fecha Vencimiento: </label>
              <input type="date" class="form-control" id="editFechaVencimiento" name="editFechaVencimiento" value="<?php echo $datosIngreso["FechaVencimientoIng"] ?>"" required><br><br>
            </div>

            <div class=" col-md-3">
              <div id="stateIngWrapper">
                <label for="stateIng" class="form-label" style="font-weight: bold">Estado:</label>
                <select class="form-control" id="stateIng" name="stateIng" readonly>
                  <option value="7" selected>Ingresado</option>
                </select>
              </div>
            </div>
          </div>
        </span>

        <!-- List of materials -->
        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Productos</h3>
            <div class="d-inline-flex m-2">
              <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalAddProdIng">Agregar Productos</button>
            </div>

            <div class="row" style="font-weight: bold">
              <div class="col-lg-5">Descripción</div>
              <div class="col-lg-3">Unidad</div>
              <div class="col-lg-3">Cantidad</div>
            </div>

            <div class="form-group row newProductAddIng">
              <?php
              foreach ($listaProductos as $value) {
                $datosProducto = ProductsController::ctrGetDataProducto($value["codProduct"]);
                echo '
                  <div class="row" style="padding:5px 15px">
                    <!-- Description -->
                    <div class="col-lg-5" style="padding-right:0px">
                      <div class="input-group">
                        <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs deleteNuevoiIngreso" codProduct="' . $datosProducto["IdProd"] . '"><i class="fa fa-times"></i></button></span>
                        <input type="text" class="form-control newProduct" codProduct="' . $datosProducto["IdProd"] . '" value="' . $datosProducto["NombreProducto"] . '" readonly>
                      </div>
                    </div>

                    <!-- Unity -->
                    <div class="col-lg-3 unityMaterial">
                      <input type="text" class="form-control newUnity" name="newUnity" value="' . $datosProducto["Unidad"] . '" readonly>
                    </div>

                    <!-- Count -->
                    <div class="col-lg-3 countMaterial">
                      <input type="number" min="1.00" step="1.00" class="form-control newCount" name="newCount" value="' . $value["countProduct"] . '" >
                    </div>
                  </div>
                ';
              }
              ?>
              <input type="hidden" id="listProducts" name="listProducts">

            </div>
            <div class="container row g-3 p-3 justify-content-between">
              <input type="hidden" class="codIngreso" name="codIngreso" id="codIngreso" value="<?php echo $codIngreso ?>">
              <button type="button" class="col-3 d-inline-flex-center p-2 btn btn-danger closeIngresoNuevo">Cerrar</button>
              <button type="submit" class="col-4 d-inline-flex-center p-2 btn btn-success">Editar Ingreso</button>
            </div>
        </span>
      </form>
    </div>
  </main>
</div>
</div>

<?php
  $editarIngreso = new IngresosController();
  $editarIngreso->ctrEditIngreso();
?>

<!-- Modal Add Material -->
<div class="modal fade" id="modalAddProdIng" tabindex="-1" role="dialog" aria-labelledby="modalAddProdIng" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Listado de Productos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="datatablesSimple" class="table table-striped dt-responsive tableNuevoIng" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Descripción del Material</th>
              <th>Unidad</th>
              <th>Acciones</th>
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
                  <td>' . $value["Unidad"] . '</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-primary btnAddProduct takeButton" codProduct="' . $value["IdProd"] . '">Agregar</button> 
                    </div>
                  </td>
                </tr>';
            }
            ?>
          </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary pull-left" data-bs-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>