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
        Nota de Pedido
      </h1>
    </div>

    <div class="container-fluid">
      <form role="form" method="post" class="row g-3 m-2 formNotaPedido">
        <span class="border border-3 p-3">


          <div class="container row g-3">
            <h3>Datos de pedido</h3>

            <div class="form-group col-md-4">
              <label for="notRuc" class="form-label" style="font-weight: bold">Ruc Cliente </label>
              <select class="form-control input-lg" id="notRuc" name="notRuc">
                <option disabled selected>Seleccione Ruc de Cliente</option>
                <?php
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
                <option value="">Seleccione cliente</option>
                <?php
                $listClientes = NotaPedidoController::ctrGetNotaPeCli();
                foreach ($listClientes as $value) {
                  echo '<option value="' . $value["IdCli"] . '">' . $value["NombreCli"] . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="notDirec" class="form-label" style="font-weight: bold">Direccion Client </label>
              <select class="form-control input-lg" id="notDirec" name="notDirec" disabled>
                <option value="">Seleccione cliente</option>
                <?php
                $listClientes = NotaPedidoController::ctrGetNotaPeCli();
                foreach ($listClientes as $value) {
                  echo '<option value="' . $value["IdCli"] . '">' . $value["DireccionCli"] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <div class="container row g-3">
            <div class="col-md-3">
              <label for="notRes" class="form-label" style="font-weight: bold">Responsable</label>
              <select class="form-control input-lg" id="notRes" name="notRes" required>
                <option value="">Seleccione el Responsable</option>
                <?php
                $listResponsables = PersonalController::ctrGetPersonalByType("1");
                foreach ($listResponsables as $value) {
                  echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="col-md-3">
              <label for="notTipoPe" class="form-label" style="font-weight: bold">Crear Desde:</label>
              <select class="form-control input-lg" id="notTipoPe" name="notTipoPe" required>
                <option value="Almacen">Almacen</option>
                <option value="Lote">Lote</option>
              </select>
            </div>

            <!-- Campo adicional para el lote como select -->
            <div class="col-md-3" id="campoLoteAdd" style="display: none;">
              <label for="notPeLot" class="form-label" style="font-weight: bold">Seleccione Lote:</label>
              <select class="form-control" id="notPeLot" name="notPeLot" required>
                <option value="O">Selecione el Lote</option>
                <option value="1">Lote 1</option>
                <option value="2">Lote 2</option>
                <option value="3">Lote 3</option>
              </select>
            </div>

            <div class="col-md-3">
              <label for="notTiPe" class="form-label" style="font-weight: bold">Tipo Pedido:</label>
              <select class="form-control input-lg" id="notTiPe" name="notTiPe" required>
                <option value="NotaPedido">Nota Pedido</option>
                <option value="Factura">Factura</option>
              </select>
            </div>

            <!-- Campo adicional para la Factura -->
            <div class="col-md-3" id="campoFactura" style="display: none;">
              <label for="datosFactura" class="form-label" style="font-weight: bold">Nr° Factura:</label>
              <input type="text" class="form-control" id="datosFactura" name="datosFactura" placeholder="Datos de la factura">
            </div>

            <!-- fecha de nota pedido -->
            <div class="form-group col-md-3">
              <label for="notFechPe" class="form-label" style="font-weight: bold">Fecha Nota Pedido: </label>
              <input type="date" class="form-control" id="notFechPe" name="notFechPe" required>
            </div>
          </div>

          <div class="container row g-3">

            <div class="col-md-4">
              <label for="notVend" class="form-label" style="font-weight: bold">Vendedor</label>
              <select class="form-control" id="notVend" name="notVend" required>
                <option value="">Seleccione al Vendedor</option>
                <?php
                $listVendedores = PersonalController::ctrGetPersonalByType("3");
                foreach ($listVendedores as $value) {
                  echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                }
                ?>
              </select>
            </div>

            <!-- estado -->
            <div class="col-md-3">
              <label for="notDescrip" class="form-label" style="font-weight: bold">Estado Nota de Pedido:</label>
              <select class="form-control input-lg" id="notDescrip" name="notDescrip" >
                <option value="8" data-color="#b3e0ff">Retirado</option>
                <option value="5" data-color="#98fb98">Completado</option>
                <option value="6" data-color="#ffb6c1">Devolucion</option>
              </select>
            </div>
          </div>

          <div class="container row g-3">
            <div class="col-md-2">
              <h3>Total</h3>
              <div style="font-size:26px; display: flex; align-items: center;"><span style="margin-right: 3px;">S/</span> <input type="text" class="form-control" id="notTotal" name="notTotal" readonly></div>
            </div>
          </div>
        </span>

        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Productos</h3>
            <div class="d-inline-flex m-2">
              <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalAddProdIng">Agregar Productos</button>
            </div>

            <div class="row" style="font-weight: bold">
              <div class="col-lg-5">Producto</div>
              <div class="col-lg-2">Precio Producto</div>
              <div class="col-lg-2">Cantidad</div>
              <div class="col-lg-2">total</div>
            </div>

            <div class="form-group row newProductAddNotaP">
              <input type="hidden" id="listProductAddNotaP" name="listProductAddNotaP">
              <!-- aqui se agregan los productos del modal de prodcutos  -->
            </div>
          </div>
        </span>

        <!-- botones par enviar el formulario productos  -->
        <div class="col-md-4>
        <div class=" container row g-4 p-4 justify-content-between">
          <button type="button" class="col-1 d-inline-flex-center p-2 btn btn-danger closeNotaPedido">Cerrar</button>
          <button type="submit" class="col-2 d-inline-flex-center p-2 btn btn-success" name="submitNotaPedido">Registrar Nota Pedido</button>
        </div>
    </div>
    <!-- Campo de entrada oculto para la cadena JSON -->
    <input type="hidden" id="formDataJson" name="formDataJson">
    </form>
</div>
</main>
</div>

</div>

<!-- Modal para agregar  productos -->
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
              <th>Descripción del Producto</th>
              <th>Almacen</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $listProducts = NotaPedidoController::ctrGetListProducts();
            foreach ($listProducts as $key => $value) {
              echo '
                <tr>
                  <td>' . ($key + 1) . '</td>
                  <td>' . $value["NombreProducto"] . '</td>
                  <td>' . $value["CantidadTotal"] . '</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-primary btnAddProduct takeButton" codProduct="' . $value["IdProd"] . '">Agregar</button> 
                    </div>
                  </td>
                </tr>';
            } ?>
          </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary pull-left" data-bs-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>

<?php
$notaPedidoController = new NotaPedidoController();
$notaPedidoController->ctrCreateNotaPedido();
?>