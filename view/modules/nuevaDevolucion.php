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
        <?php
        if (isset($_GET["codUpdateNota"])) {
          $codSalida = $_GET["codUpdateNota"];
          $datosNota = NotaPedidoController::ctrGetNotaPeById($codSalida);
          $listaProductos = json_decode($datosNota["DatosProductosNotaPedidoJson"], true);
          $tipoSalida = "Nota de Pedido";
        ?>
          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3>Datos de la Nota de Pedido</h3>
              <div class="form-group col-md-4">
                <label for="devolucionRucCLiente" class="form-label" style="font-weight: bold">Ruc Cliente </label>
                <select class="form-control input-lg" id="devolucionRucCLiente" name="devolucionRucCLiente" disabled>
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
                <label for="devolucionNombreCliente" class="form-label" style="font-weight: bold">Nombre Cliente</label>
                <select class="form-control input-lg" id="devolucionNombreCliente" name="devolucionNombreCliente" disabled>
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
                <label for="devolucionDireccionCLiente" class="form-label" style="font-weight: bold">Direccion Cliente </label>
                <select class="form-control input-lg" id="devolucionDireccionCLiente" name="devolucionDireccionCLiente" disabled>
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
        <?php
        }
        if (isset($_GET["codLoteUpdate"])) {
          $codSalida = $_GET["codLoteUpdate"];
          $datosLote = LotesController::ctrGetEditLoteData($codSalida);
          $listaProductos = json_decode($datosLote["DatosLoteIngresoJson"], true);
          $tipoSalida = "Lote";
        ?>
          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3>Datos del Lote </h3>
              <input type="hidden" id="idLoteEdit" name="idLoteEdit">

              <div class="form-group col-md-4">
                <label for="devolucionRuc" class="form-label" style="font-weight: bold">Ruc Cliente </label>
                <select class="form-control input-lg" id="devolucionRuc" name="devolucionRuc" disabled>
                  <?php
                  echo '<option value="' . $datosLote["IdCliente"] . '">' . $datosLote["RucCli"] . '</option>';
                  ?>
                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="devolucionNombre" class="form-label" style="font-weight: bold">Nombre Cliente</label>
                <select class="form-control input-lg" id="devolucionNombre" name="devolucionNombre" disabled>
                  <?php
                  echo '<option value="' . $datosLote["IdCliente"] . '">' . $datosLote["NombreCli"] . '</option>';
                  ?>
                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="devolucionDIreccion" class="form-label" style="font-weight: bold">Direccion Cliente </label>
                <select class="form-control input-lg" id="devolucionDIreccion" name="devolucionDIreccion" disabled>
                  <?php
                  echo '<option value="' . $datosLote["IdCliente"] . '">' . $datosLote["DireccionCli"] . '</option>';
                  ?>
                </select>
              </div>
              <!-- Select Responsable-->
              <div class="form-group col-md-6">
                <label for="devolucionResponsable" class="form-label" style="font-weight: bold">Responsable:</label>
                <select class="form-control input-lg" id="devolucionResponsable" name="devolucionResponsable" disabled>
                  <?php
                  echo '<option value="' . $datosLote["IdPer"] . '" >' . $datosLote["FullNamePersonal"] . '</option>';
                  ?>
                </select>
              </div>

              <div class="col-md-3">
                <label for="devolucionFecha" class="form-label" style="font-weight: bold">Fecha Lote: </label>
                <input type="date" class="form-control" id="devolucionFecha" name="devolucionFecha" value="<?php echo $datosLote["FechaProduccionLote"] ?>" disabled>
              </div>

              <div class="col-md-3">
                <label for="devolucionVencimiento" class="form-label" style="font-weight: bold">Fecha Vencimiento: </label>
                <input type="date" class="form-control" id="devolucionVencimiento" name="devolucionVencimiento" value="<?php echo $datosLote["FechaVencimientoLote"] ?>" disabled>
              </div>

              <!-- Codigo de Lote -->
              <div class="form-group col-md-6 inl">
                <label for="devolucionCodigo" class="form-label" style="font-weight: bold"> Código de Lote:</label>
                <input type="text" class="form-control" id="devolucionCodigo" name="devolucionCodigo" value="<?php echo $datosLote["CodigoLote"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="devolucionDescripcion" class="form-label" style="font-weight: bold">Descripcion Lote:</label>
                <input type="text" class="form-control" id="devolucionDescripcion" name="devolucionDescripcion" value="<?php echo $datosLote["DescripcionLote"] ?>" disabled>
              </div>
            </div>
          </span>
        <?php
        }
        ?>

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

            <div class="form-group row">
              <?php
              if (isset($_GET["codUpdateNota"])) {
              ?>
                <div class="row" style="font-weight: bold">
                  <div class="col-lg-8">Producto</div>
                  <div class="col-lg-2">Precio Producto</div>
                  <div class="col-lg-2">Cantidad</div>
                </div>
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
              }
              ?>
              <?php
              if (isset($_GET["codLoteUpdate"])) {
              ?>
                <div class="row" style="font-weight: bold">
                  <div class="col-lg-5">Descripción</div>
                  <div class="col-lg-3">Unidad</div>
                  <div class="col-lg-3">Cantidad</div>
                </div>
              <?php
                foreach ($listaProductos as $value) {
                  $producto = LotesController::ctrGetProductDataAjx($value["codProduct"]);
                  echo '
                    <div class="row" style="padding:5px 15px">
                      <div class="col-lg-5" style="padding-right:0px">
                        <div class="input-group">
                          <input type="text" class="form-control productDevolucion" id="productDevolucion" name="productDevolucion" codProduct="' . $producto["IdProd"] . '" value="' . $producto["NombreProducto"] . '" disabled>
                        </div>
                      </div>
                      <div class="col-lg-3 UnityProduct">
                        <input type="text" class="form-control" name="newUnity" value="' . $producto["Unidad"] . '" disabled>
                      </div>
                      <div class="col-lg-3 countMaterial">
                        <input type="number" min="1.00" step="1.00" class="form-control countDevolucion" name="countDevolucion" stock="' . $value["countProduct"] . '" value="' . $value["countProduct"] . '">
                      </div>
                    </div>
                    ';
                }
              }
              ?>
              <input type="hidden" id="listProductosDevolver" name="listProductosDevolver">
              <input type="hidden" id="listProductosMerma" name="listProductosMerma">
            </div>
          </div>
        </span>

        <!-- botones par enviar el formulario productos  -->
        <div class="container row g-3 p-3 justify-content-between">
          <input type="hidden" name="codSalida" class="codSalida" id="codSalida" value="<?php echo $codSalida ?>">
          <input type="hidden" name="tipoSalida" class="tipoSalida" id="tipoSalida" value="<?php echo $tipoSalida ?>">
          <button type="button" class="col-3 d-inline-flex-center p-2 btn btn-danger closeDevolucion">Cerrar</button>
          <button type="submit" class="col-4 d-inline-flex-center p-2 btn btn-success">Ingresar Devolución</button>
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
$crearIngresoDevolucion->ctrCrearIngresoDevolucion();
?>