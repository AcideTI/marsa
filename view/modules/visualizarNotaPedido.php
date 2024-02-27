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
        Visualizar Nota de Pedido
      </h1>
    </div>
    <div class="container-fluid">
      <form role="form" method="post" class="row g-3 m-2 formNotaPedido">
        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Datos Nota de Pedido</h3>
            <?php
            $codNotaPedido = $_GET["codSalida"];
            $datosNota = NotaPedidoController::ctrGetNotaPeById($codNotaPedido);
            $listaProductos = json_decode($datosNota["DatosProductosNotaPedidoJson"], true);
            if ($datosNota["EstadoNota"] == "1") {
              $color = "#82B2F1";
              $tipoIngreso = "Retirado";
            }
            if ($datosNota["EstadoNota"] == "2") {
              $color = "#FFFCAE";
              $tipoIngreso = "Entregado";
            }
            if ($datosNota["EstadoNota"] == "3") {
              $color = "#82F5A5";
              $tipoIngreso = "Cancelado";
            }
            if ($datosNota["EstadoNota"] == "4") {
              $color = "#F1907D";
              $tipoIngreso = "Devolución";
            }
            if ($datosNota["EstadoNota"] == "5") {
              $color = "#C7C7C7";
              $tipoIngreso = "Anulado";
            }
            ?>

            <div class="form-group col-md-4">
              <label for="visualizarRuc" class="form-label" style="font-weight: bold">Ruc Cliente </label>
              <select class="form-control input-lg" id="visualizarRuc" name="visualizarRuc" disabled>
                <?php
                echo '<option value="' . $datosNota["IdCliente"] . '">' . $datosNota["RucCli"] . '</option>';
                ?>
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="visualizarCliente" class="form-label" style="font-weight: bold">Nombre Cliente</label>
              <select class="form-control input-lg" id="visualizarCliente" name="visualizarCliente" disabled>
                <?php
                echo '<option value="' . $datosNota["IdCliente"] . '">' . $datosNota["NombreCli"] . '</option>';
                ?>
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="visualizarDireccion" class="form-label" style="font-weight: bold">Direccion Cliente </label>
              <select class="form-control input-lg" id="visualizarDireccion" name="visualizarDireccion" disabled>
                <?php
                echo '<option value="' . $datosNota["IdCliente"] . '">' . $datosNota["DireccionCli"] . '</option>';
                $listClientes = NotaPedidoController::ctrGetNotaPeCli();
                ?>
              </select>
            </div>
          </div>

          <div class="container row g-3">
            <div class="col-md-5">
              <label for="visualizarResponsable" class="form-label" style="font-weight: bold">Responsable</label>
              <select class="form-control input-lg" id="visualizarResponsable" name="visualizarResponsable" disabled>
                <?php
                echo '<option value="' . $datosNota["IdRes"] . '">' . $datosNota["nombreResponsable"] . '</option>';
                ?>
              </select>
            </div>

            <!-- fecha de nota pedido -->
            <div class="form-group col-md-2">
              <label for="visualizarFecha" class="form-label" style="font-weight: bold">Fecha Nota Pedido: </label>
              <input type="date" class="form-control" id="visualizarFecha" name="visualizarFecha" value="<?php echo $datosNota["FechaNotaPedido"] ?>" disabled>
            </div>

            <div class="col-md-5">
              <label for="visualizarVendedor" class="form-label" style="font-weight: bold">Vendedor</label>
              <select class="form-control" id="visualizarVendedor" name="visualizarVendedor" disabled>
                <?php
                echo '<option value="' . $datosNota["IdPer"] . '">' . $datosNota["nombreVendedor"] . '</option>';
                ?>
              </select>
            </div>
          </div>

          <div class="container row g-3">
            <div class="form-group col-md-12">
              <label for="visualizarObservacion" class="form-label" style="font-weight: bold">Observación </label>
              <input type="text" class="form-control" id="visualizarObservacion" name="visualizarObservacion" value="<?php echo $datosNota["Observacion"] ?>" disabled>
            </div>
          </div>

          <div class="container row g-3">
            <div class="col-md-2">
              <h3>Total</h3>
              <div style="font-size:26px; display: flex; align-items: center;"><span style="margin-right: 3px;">S/</span> <input type="text" class="form-control" id="notTotal" name="notTotal" value="<?php echo $datosNota["Total"] ?>" disabled></div>
            </div>
          </div>

          <div class="col-md-1">
            <label for="visualizarTipo" class="form-label" style="font-weight: bold">Estado: </label>
            <input type="text" class="form-control" id="visualizarTipo" name="visualizarTipo" value="<?php echo $tipoIngreso ?>" style="background-color: <?php echo $color ?>;" disabled>
          </div>
        </span>

        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Productos</h3>

            <div class="row" style="font-weight: bold">
              <div class="col-lg-5">Producto</div>
              <div class="col-lg-2">Precio Producto</div>
              <div class="col-lg-2">Cantidad</div>
              <div class="col-lg-2">Total</div>
            </div>

            <div class="form-group row newProductAddNotaP">
              <?php
              foreach ($listaProductos as $value) {
                $producto = AlmacenController::ctrGerProductDataById($value["codProduct"]);
                echo '
                  <div class="row" style="padding:5px 15px">
                    <div class="col-lg-5" style="padding-right:0px">
                      <div class="input-group">
                        <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs deleteNuevoiIngreso" codProduct="' . $value["codProduct"] . '"><i class="fa fa-times"></i></button></span>
                        <input type="text" class="form-control newProduct" codProduct="' . $value["codProduct"] . '" value="' . $producto["NombreProducto"] . '" disabled>
                      </div>
                    </div>
                    
                    <div class="col-lg-2 PriceProNotaP">
                      <input type="text" class="form-control newPrice" name="newPrice" value="' . $value["priceProduct"] . '" disabled>
                    </div>

                    <div class="col-lg-2 countMaterial">
                      <input type="number" min="1.00" step="1.00" class="form-control newCount" name="newCount" value="' . $value["countProduct"] . '" disabled>
                    </div>
                    
                    <div class="col-lg-2 sumMaterial">
                      <div style="font-size:24px; display: flex; align-items: center;"><span style="margin-right: 2px;">S/</span><input type="text" class="form-control newSum" name="newSum" value="' . $value["newSum"] . '" disabled></div>
                    </div>
                  </div>
                ';
              }
              ?>
            </div>
          </div>
        </span>
        <div class="container row g-3 p-3 justify-content-between">
          <button type="button" class="col-3 d-inline-flex-center p-2 btn btn-danger closeVisualizarNota">Cerrar</button>
        </div>
      </form>
    </div>
  </main>
</div>
</div>