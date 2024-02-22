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
        Visualizar Ingreso
      </h1>
      <?php
      $codIngreso = $_GET["codIngreso"];
      $datosIngreso = IngresosController::ctrGetIngreso($codIngreso);
      $listaProductos = json_decode($datosIngreso["DatosProductosIngresoJson"], true);
      if($datosIngreso["TipoIngreso"] == "1") {
        $color = "#82F5A5";
        $tipoIngreso = "Produccion";
      } else {
        $color = "#F1907D";
        $tipoIngreso = "Devolución";
      }
      ?>
    </div>

    <div class="container-fluid">
      <form role="form" method="post" class="row g-3 m-2 formEditarIngreso">
        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Datos de Produccion</h3>
            <!-- Select Provider-->
            <div class="form-group col-md-8">
              <label for="visualizarResponsable" class="form-label" style="font-weight: bold">Responsable:</label>
              <select class="form-control input-lg" id="visualizarResponsable" name="visualizarResponsable" disabled>
                <?php
                echo '<option value="' . $datosIngreso["IdPer"] . '">' . $datosIngreso["NombrePer"] . ' ' . $datosIngreso["ApellidoPer"] . '</option>';
                ?>
              </select>
            </div>

            <div class="col-md-3">
              <label for="editFechaProduccion" class="form-label" style="font-weight: bold">Fecha Ingreso: </label>
              <input type="date" class="form-control" id="editFechaProduccion" name="editFechaProduccion" value="<?php echo $datosIngreso["FechaProduccionIng"] ?>" disabled>
            </div>

            <div class="form-group col-md-8">
              <label for="visualizarDescripcion" class="form-label" style="font-weight: bold">Descripción de Ingreso:</label>
              <input type="text" class="form-control" id="visualizarDescripcion" name="visualizarDescripcion" value="<?php echo $datosIngreso["DescripcionIng"] ?>"" disabled>
            </div>

            <div class="col-md-3">
              <label for="visualizarFechaVencimiento" class="form-label" style="font-weight: bold">Fecha Vencimiento: </label>
              <input type="date" class="form-control" id="visualizarFechaVencimiento" name="visualizarFechaVencimiento" value="<?php echo $datosIngreso["FechaVencimientoIng"] ?>"" disabled><br><br>
            </div>

            <div class="col-md-3">
              <label for="visualizarTipo" class="form-label" style="font-weight: bold">Tipo Ingreso: </label>
              <input type="text" class="form-control" id="visualizarTipo" name="visualizarTipo"  value="<?php echo $tipoIngreso ?>" style="background-color: <?php echo $color ?>;" disabled>
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

            <div class="form-group row newProductAddIng">
              <?php
              foreach ($listaProductos as $value) {
                $datosProducto = ProductsController::ctrGetDataProducto($value["codProduct"]);
                echo '
                  <div class="row" style="padding:5px 15px">
                    <!-- Description -->
                    <div class="col-lg-5" style="padding-right:0px">
                      <div class="input-group">
                        <input type="text" class="form-control newProduct" codProduct="' . $datosProducto["IdProd"] . '" value="' . $datosProducto["NombreProducto"] . '" disabled>
                      </div>
                    </div>

                    <!-- Unity -->
                    <div class="col-lg-3 unityMaterial">
                      <input type="text" class="form-control newUnity" name="newUnity" value="' . $datosProducto["Unidad"] . '" disabled>
                    </div>

                    <!-- Count -->
                    <div class="col-lg-3 countMaterial">
                      <input type="number" min="1.00" step="1.00" class="form-control newCount" name="newCount" value="' . $value["countProduct"] . '" disabled>
                    </div>
                  </div>
                ';
              }
              ?>
            </div>
            <div class="container row g-3 p-3 justify-content-between">
              <button type="button" class="col-3 d-inline-flex-center p-2 btn btn-danger closeVisualizarIngreso">Cerrar</button>
            </div>
        </span>
      </form>
    </div>
  </main>
</div>
</div>