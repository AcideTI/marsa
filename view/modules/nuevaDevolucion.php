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
        Ingreso por Devolución
      </h1>
    </div>

    <div class="container-fluid">
      <form role="form" method="post" class="row g-3 m-2 formIngresoDevolucion">
        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Datos de la Nota de Pedido</h3>
            <?php
            $codNotaPedido = $_GET["codUpdateNota"];
            $datosNota = NotaPedidoController::ctrGetNotaPeById($codNotaPedido);
            $listaProductos = json_decode($datosNota["DatosProductosNotaPedidoJson"], true);
            ?>

            <div class="form-group col-md-4">
              <label for="notRuc" class="form-label" style="font-weight: bold">Ruc Cliente </label>
              <select class="form-control input-lg" id="notRuc" name="notRuc" disabled>
                <?php
                echo '<option value="' . $datosNota["IdCliente"] . '">' . $datosNota["RucCli"] . '</option>';
                $listClientes = NotaPedidoController::ctrGetNotaPeCli();
                foreach ($listClientes as $value) {
                  echo '<option value="' . $value["IdCli"] . '">' . $value["RucCli"] . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="notCli" class="form-label" style="font-weight: bold">Nombre Cliente</label>
              <select class="form-control input-lg" id="notCli" name="notCli" disabled>
                <?php
                echo '<option value="' . $datosNota["IdCliente"] . '">' . $datosNota["NombreCli"] . '</option>';
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
                echo '<option value="' . $datosNota["IdCliente"] . '">' . $datosNota["DireccionCli"] . '</option>';
                $listClientes = NotaPedidoController::ctrGetNotaPeCli();
                foreach ($listClientes as $value) {
                  echo '<option value="' . $value["IdCli"] . '">' . $value["DireccionCli"] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <div class="container row g-3">
            <div class="col-md-5">
              <label for="notRes" class="form-label" style="font-weight: bold">Responsable</label>
              <select class="form-control input-lg" id="notRes" name="notRes" disabled>
                <?php
                echo '<option value="' . $datosNota["IdRes"] . '">' . $datosNota["nombreResponsable"] . '</option>';
                $listResponsables = PersonalController::ctrGetPersonalByType("1");
                foreach ($listResponsables as $value) {
                  echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                }
                ?>
              </select>
            </div>

            <!-- fecha de nota pedido -->
            <div class="form-group col-md-2">
              <label for="notFechPe" class="form-label" style="font-weight: bold">Fecha Nota Pedido: </label>
              <input type="date" class="form-control" id="notFechPe" name="notFechPe" value="<?php echo $datosNota["FechaNotaPedido"] ?>" disabled>
            </div>

            <div class="col-md-5">
              <label for="notVend" class="form-label" style="font-weight: bold">Vendedor</label>
              <select class="form-control" id="notVend" name="notVend" disabled>
                <?php
                echo '<option value="' . $datosNota["IdPer"] . '">' . $datosNota["nombreVendedor"] . '</option>';
                $listVendedores = PersonalController::ctrGetPersonalByType("3");
                foreach ($listVendedores as $value) {
                  echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <div class="container row g-3">
            <div class="col-md-2">
              <h3>Total</h3>
              <div style="font-size:26px; display: flex; align-items: center;"><span style="margin-right: 3px;">S/</span> <input type="text" class="form-control" id="notTotal" name="notTotal" value="<?php echo $datosNota["Total"] ?>" readonly></div>
            </div>
          </div>
        </span>

        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Datos del Ingreso</h3>
            <!-- Select Provider-->
            <div class="form-group col-md-9">
              <label for="responsableDev" class="form-label" style="font-weight: bold">Responsable:</label>
              <select class="form-control input-lg" id="responsableDev" name="responsableDev" required>
                <option value="">Seleccione el Operador</option>
                <?php
                $listOperadores = PersonalController::ctrGetPersonalByType("2");
                foreach ($listOperadores as $value) {
                  echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="col-md-3">
              <label for="fechaDevolucion" class="form-label" style="font-weight: bold">Fecha Devolucion: </label>
              <input type="date" class="form-control" id="fechaDevolucion" name="fechaDevolucion" required>
            </div>

            <div class="form-group col-md-12">
              <label for="motivoDevolucion" class="form-label" style="font-weight: bold">Motivo de la Devolucion:</label>
              <input type="text" class="form-control" id="motivoDevolucion" name="motivoDevolucion" required>
            </div>
          </div>
        </span>

        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Productos</h3>
            <div class="form-group col-md-12">
              <p style="font-weight: bold; font-style: oblique; font-size: 18px; color: #E1654C">* Ingrese la cantidad en cada producto que va a devolver al stock almacén</p>
            </div>

            <div class="row" style="font-weight: bold">
              <div class="col-lg-8">Producto</div>
              <div class="col-lg-2">Precio Producto</div>
              <div class="col-lg-2">Cantidad</div>
            </div>

            <div class="form-group row">
              <?php
              foreach ($listaProductos as $value) {
                $producto = AlmacenController::ctrGerProductDataById($value["codProduct"]);
                echo '
                  <div class="row" style="padding:5px 15px">
                    <div class="col-lg-8" style="padding-right:0px">
                      <div class="input-group">
                        <input type="text" class="form-control productDevolucion" codProduct="' . $value["codProduct"] . '" value="' . $producto["NombreProducto"] . '" disabled>
                      </div>
                    </div>
                    
                    <div class="col-lg-2 PriceProNotaP">
                      <input type="text" class="form-control" name="" value="' . $value["priceProduct"] . '" disabled>
                    </div>

                    <div class="col-lg-2 countMaterial">
                      <input type="number" min="1.00" step="1.00" class="form-control countDevolucion" name="countDevolucion" stock="' . $value["countProduct"] . '" value="' . $value["countProduct"] . '" >
                    </div>
                  </div>
                ';
              }
              ?>
              <input type="hidden" id="listProductosDevolver" name="listProductosDevolver">
              <input type="hidden" id="listProductosMerma" name="listProductosMerma">
            </div>
          </div>
        </span>

        <!-- botones par enviar el formulario productos  -->
        <div class="container row g-3 p-3 justify-content-between">
          <input type="hidden" name="codSalida" class="codSalida" id="codSalida" value="<?php echo $codNotaPedido ?>">
          <button type="button" class="col-3 d-inline-flex-center p-2 btn btn-danger closeDevolucion">Cerrar</button>
          <button type="submit" class="col-4 d-inline-flex-center p-2 btn btn-success" name="submitNotaPedido">Ingresar Devolución</button>
        </div>
        <!-- Campo de entrada oculto para la cadena JSON -->
        <input type="hidden" id="formDataJson" name="formDataJson">
      </form>
    </div>
  </main>
</div>
</div>

<?php
$crearIngresoDevolucion = new IngresosController();
$crearIngresoDevolucion->ctrCrearIngresoDevolucionNota();
?>