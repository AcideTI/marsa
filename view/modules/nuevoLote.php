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
        Crear Nueva Salida Factura / Lote
      </h1>
    </div>

    <div class="container-fluid">
      <form role="form" method="post" class="row g-3 m-2 formNuevoLote">
        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Datos de la Salida</h3>

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
              <label for="notDirec" class="form-label" style="font-weight: bold">Direccion Cliente </label>
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

            <!-- Select Provider-->
            <div class="form-group col-md-8">
              <label for="nameResLot" class="form-label" style="font-weight: bold">Responsable:</label>
              <select class="form-control input-lg" id="nameResLot" name="nameResLot" required>
                <option value="">Seleccione el Responsable</option>
                <?php
                $listResponsables = PersonalController::ctrGetPersonalByType("1");
                foreach ($listResponsables as $value) {
                  echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="col-md-4">
              <label for="dateCreatLot" class="form-label" style="font-weight: bold">Fecha Salida: </label>
              <input type="date" class="form-control" id="dateCreatLot" name="dateCreatLot" required>
            </div>

            <!-- <div class="col-md-3">
              <label for="dateVenciLot" class="form-label" style="font-weight: bold">Fecha Vencimiento: </label>
              <input type="date" class="form-control" id="dateVenciLot" name="dateVenciLot">
            </div> -->

            <div class="col-md-2">
              <label for="nameResLot" class="form-label" style="font-weight: bold">Tipo de Salida:</label>
              <select class="form-control input-lg" name="tipoSalida" id="tipoSalida">
                <option value="Factura">Factura</option>
                <option value="Lote">Lote</option>
              </select>
            </div>

            <div class="col-md-3">
              <label for="numeroFactura" class="form-label" style="font-weight: bold">Número de Factura:</label>
              <input type="text" class="form-control" id="numeroFactura" name="numeroFactura" placeholder="Ingrese el número de Factura">
            </div>
            <div class="col-md-3">
              <label for="numeroLote" class="form-label" style="font-weight: bold">Código de Lote:</label>
              <input type="text" class="form-control" id="numeroLote" name="numeroLote" placeholder="Ingrese el código de Lote">
            </div>
            <div class="col-md-3">
              <label for="totalFactura" class="form-label" style="font-weight: bold">Total:</label>
              <input type="text" class="form-control" id="totalFactura" name="totalFactura" placeholder="Ingrese el Total">
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
            <!-- aqui se agregan los productos del modal de prodcutos  -->
            <div class="form-group row newProductAddLote">
              <input type="hidden" id="listProducts" name="listProducts">
              <!-- aqui se agregan los productos del modal de prodcutos  -->
            </div>
          </div>
          <div class="container row g-3 p-3 justify-content-between">
            <button type="button" class="col-3 d-inline-flex-center p-2 btn btn-danger closelotes" href="verSalidas">Cerrar</button>
            <button type="submit" class="col-4 d-inline-flex-center p-2 btn btn-success ">Registrar Salida</button>
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
        <div class="form-group">
          <select name="categoriaModal" id="categoriaModal" class="form-control input-lg categoriaModal">
            <option value="">Seleccione la Categoría</option>
            <?php
            $listCategories = ProductsController::ctrGetAllCategories();
            foreach ($listCategories as $value) {
              echo '<option value="' . $value["NombreCategoria"] . '">' . $value["NombreCategoria"] . '</option>';
            }
            ?>
          </select>
        </div>
        <table id="dataTableProductosLote" class="display dataTableProductosLote" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Producto</th>
              <th>Categoría</th>
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
                  <td>' . $value["NombreCategoria"] . '</td>
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