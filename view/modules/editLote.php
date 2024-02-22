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
      <?php
      $codLote = $_GET["codLoteEdit"];
      $datosLote = LotesController::ctrGetEditLoteData($codLote);
      ?>
      <h1 class="mt-4">
        Editar Lote
      </h1>

    </div>

    <div class="container-fluid">
      <form role="form" method="post" class="row g-3 m-2 formEditLote">
        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Datos del Lote </h3>
            <input type="hidden" id="idLoteEdit" name="idLoteEdit">

            <div class="form-group col-md-4">
              <label for="notRuc" class="form-label" style="font-weight: bold">Ruc Cliente </label>
              <select class="form-control input-lg" id="notRuc" name="notRuc">
                <?php
                echo '<option value="' . $datosLote["IdCliente"] . '">' . $datosLote["RucCli"] . '</option>';
                $listClientes = NotaPedidoController::ctrGetNotaPeCli();
                foreach ($listClientes as $value) {
                  echo '<option value="' . $value["IdCli"] . '">' . $value["RucCli"] . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="notCli" class="form-label" style="font-weight: bold">Nombre Cliente</label>
              <select class="form-control input-lg" id="notCli" name="notCli" required>
                <?php
                echo '<option value="' . $datosLote["IdCliente"] . '">' . $datosLote["NombreCli"] . '</option>';
                $listClientes = NotaPedidoController::ctrGetNotaPeCli();
                foreach ($listClientes as $value) {
                  echo '<option value="' . $value["IdCli"] . '">' . $value["NombreCli"] . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="notDirec" class="form-label" style="font-weight: bold">Direccion Cliente </label>
              <select class="form-control input-lg" id="notDirec" name="notDirec" disabled>
                <?php
                echo '<option value="' . $datosLote["IdCliente"] . '">' . $datosLote["DireccionCli"] . '</option>';
                $listClientes = NotaPedidoController::ctrGetNotaPeCli();
                foreach ($listClientes as $value) {
                  echo '<option value="' . $value["IdCli"] . '">' . $value["DireccionCli"] . '</option>';
                }
                ?>
              </select>
            </div>
            <!-- Select Responsable-->
            <div class="form-group col-md-6">
              <label for="editarResponsable" class="form-label" style="font-weight: bold">Responsable:</label>
              <select class="form-control input-lg" id="editarResponsable" name="editarResponsable" required>
                <?php
                echo '<option value="' . $datosLote["IdPer"] . '" >' . $datosLote["FullNamePersonal"] . '</option>';
                $listResponsables = PersonalController::ctrGetPersonalByType("1");
                foreach ($listResponsables as $value) {
                  echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="col-md-3">
              <label for="editarFechaLote" class="form-label" style="font-weight: bold">Fecha Lote: </label>
              <input type="date" class="form-control" id="editarFechaLote" name="editarFechaLote" value="<?php echo $datosLote["FechaProduccionLote"] ?>" required><br>
            </div>

            <div class="col-md-3">
              <label for="editarFechaVencimiento" class="form-label" style="font-weight: bold">Fecha Vencimiento: </label>
              <input type="date" class="form-control" id="editarFechaVencimiento" name="editarFechaVencimiento" value="<?php echo $datosLote["FechaVencimientoLote"] ?>" required>
            </div>

            <!-- Codigo de Lote -->
            <div class="form-group col-md-6 inl">
              <label for="editarCodigoLote" class="form-label" style="font-weight: bold"> Código de Lote:</label>
              <input type="text" class="form-control" id="editarCodigoLote" name="editarCodigoLote" value="<?php echo $datosLote["CodigoLote"] ?>" disabled>
            </div>

            <div class="form-group col-md-6">
              <label for="editarDescripcionLote" class="form-label" style="font-weight: bold">Descripcion Lote:</label>
              <input type="text" class="form-control" id="editarDescripcionLote" name="editarDescripcionLote" value="<?php echo $datosLote["DescripcionLote"] ?>">
            </div>

            <!-- Estado Único -->
            <div class="form-group col-md-2">
              <label for="editarEstadoLote" class="form-label" style="font-weight: bold">Estado:</label>
              <?php
              $inputLote = FunctionsController::ctrGetStateEditLote($datosLote["Estado"]);
              echo $inputLote;
              ?>
            </div>
          </div>
        </span>

        <!-- List of materials -->
        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Productos</h3>
            <div class="d-inline-flex m-2">
              <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalAddProdLote">Agregar Productos</button>
            </div>

            <div class="row" style="font-weight: bold">
              <div class="col-lg-5">Descripción</div>
              <div class="col-lg-3">Unidad</div>
              <div class="col-lg-3">Cantidad</div>
            </div>

            <div class="form-group row newProductAddLote">
              <?php
              $listaProductos = json_decode($datosLote["DatosLoteIngresoJson"], true);
              foreach ($listaProductos as $value) {
                $producto = LotesController::ctrGetProductDataAjx($value["codProduct"]);
                $stock = $producto["CantidadTotal"] + $value["countProduct"];
                echo '
                  <div class="row" style="padding:5px 15px">
                    <div class="col-lg-5" style="padding-right:0px">
                      <div class="input-group">
                        <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs deleteEditLote" codProduct="' . $producto["IdProd"] . '"><i class="fa fa-times"></i></button></span>
                        <input type="text" class="form-control newProduct" id="newProduct" name="newProduct" codProduct="' . $producto["IdProd"] . '" value="' . $producto["NombreProducto"] . '" readonly>
                      </div>
                    </div>
                    <div class="col-lg-3 UnityProduct">
                      <input type="text" class="form-control" name="newUnity" value="' . $producto["Unidad"] . '" readonly>
                    </div>
                    <div class="col-lg-3 countMaterial">
                      <input type="number" class="form-control newCount" min="1.00" step="1.00" name="newCount" value="' . $value["countProduct"] . '" stock="' . $stock . '">
                    </div>
                  </div>
                  ';
              }
              ?>
              <input type="hidden" id="listProducts" name="listProducts">
            </div>
          </div>
          <div class="container row g-3 p-3 justify-content-between">
            <input type="hidden" name="codLoteEditar" id="codLoteEditar" class="codLoteEditar" value="<?php echo $codLote ?>">
            <button type="button" class="col-3 d-inline-flex-center p-2 btn btn-danger closelotes" href="index.php?ruta=lotes">Cerrar</button>
            <button type="submit" class="col-4 d-inline-flex-center p-2 btn btn-success btnEditLoteBack ">Actualizar Lote</button>
          </div>
        </span>
      </form>
    </div>
  </main>
</div>

</div>

<!-- Modal Add Material -->
<div class="modal fade" id="modalAddProdLote" tabindex="-1" role="dialog" aria-labelledby="modalAddProdLote" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Listado de Productos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <table id="datatablesSimple" class="table table-striped dt-responsive tableNuevoLote" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Descripción del Producto</th>
              <th>Almacen</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $listProducts = LotesController::ctrGetListProducts();
            foreach ($listProducts as $key => $value) {
              echo '
                <tr>
                  <td>' . ($key + 1) . '</td>
                  <td>' . $value["NombreProducto"] . '</td>
                  <td>' . $value["CantidadTotal"] . '</td>
                  <td>
                    <div class="btn-group"> 
                      <button class="btn btn-primary btnAddProductLote takeButtonLote" codProduct="' . $value["IdProd"] . '">Agregar</button> 
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