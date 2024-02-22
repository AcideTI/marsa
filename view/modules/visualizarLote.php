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
      $codLote = $_GET["codSalida"];
      $datosLote = LotesController::ctrGetEditLoteData($codLote);
      ?>
      <h1 class="mt-4">
        Visualizar Lote
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
              <select class="form-control input-lg" id="notRuc" name="notRuc" disabled>
                <?php
                echo '<option value="' . $datosLote["IdCliente"] . '">' . $datosLote["RucCli"] . '</option>';
                ?>
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="notCli" class="form-label" style="font-weight: bold">Nombre Cliente</label>
              <select class="form-control input-lg" id="notCli" name="notCli" disabled>
                <?php
                echo '<option value="' . $datosLote["IdCliente"] . '">' . $datosLote["NombreCli"] . '</option>';
                ?>
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="notDirec" class="form-label" style="font-weight: bold">Direccion Cliente </label>
              <select class="form-control input-lg" id="notDirec" name="notDirec" disabled>
                <?php
                echo '<option value="' . $datosLote["IdCliente"] . '">' . $datosLote["DireccionCli"] . '</option>';
                ?>
              </select>
            </div>
            <!-- Select Responsable-->
            <div class="form-group col-md-6">
              <label for="editarResponsable" class="form-label" style="font-weight: bold">Responsable:</label>
              <select class="form-control input-lg" id="editarResponsable" name="editarResponsable" disabled>
                <?php
                echo '<option value="' . $datosLote["IdPer"] . '" >' . $datosLote["FullNamePersonal"] . '</option>';
                ?>
              </select>
            </div>

            <div class="col-md-3">
              <label for="editarFechaLote" class="form-label" style="font-weight: bold">Fecha Lote: </label>
              <input type="date" class="form-control" id="editarFechaLote" name="editarFechaLote" value="<?php echo $datosLote["FechaProduccionLote"] ?>" disabled><br>
            </div>

            <div class="col-md-3">
              <label for="editarFechaVencimiento" class="form-label" style="font-weight: bold">Fecha Vencimiento: </label>
              <input type="date" class="form-control" id="editarFechaVencimiento" name="editarFechaVencimiento" value="<?php echo $datosLote["FechaVencimientoLote"] ?>" disabled>
            </div>

            <!-- Codigo de Lote -->
            <div class="form-group col-md-6 inl">
              <label for="editarCodigoLote" class="form-label" style="font-weight: bold"> Código de Lote:</label>
              <input type="text" class="form-control" id="editarCodigoLote" name="editarCodigoLote" value="<?php echo $datosLote["CodigoLote"] ?>" disabled>
            </div>

            <div class="form-group col-md-6">
              <label for="editarDescripcionLote" class="form-label" style="font-weight: bold">Descripcion Lote:</label>
              <input type="text" class="form-control" id="editarDescripcionLote" name="editarDescripcionLote" value="<?php echo $datosLote["DescripcionLote"] ?>" disabled>
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
                echo '
                  <div class="row" style="padding:5px 15px">
                    <div class="col-lg-5" style="padding-right:0px">
                      <div class="input-group">
                        <input type="text" class="form-control newProduct" id="newProduct" name="newProduct" codProduct="' . $producto["IdProd"] . '" value="' . $producto["NombreProducto"] . '" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3 UnityProduct">
                      <input type="text" class="form-control" name="newUnity" value="' . $producto["Unidad"] . '" disabled>
                    </div>
                    <div class="col-lg-3 countMaterial">
                      <input type="number" class="form-control newCount" min="1.00" step="1.00" name="newCount" value="' . $value["countProduct"] . '" disabled>
                    </div>
                  </div>
                  ';
              }
              ?>
            </div>
          </div>
          <div class="container row g-3 p-3 justify-content-between">
            <button type="button" class="col-3 d-inline-flex-center p-2 btn btn-danger closeVisualizarLote" href="verSalidas">Cerrar</button>
          </div>
        </span>
      </form>
    </div>
  </main>
</div>
</div>
