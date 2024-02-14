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
        Crear un Nuevo Lote
      </h1>
    </div>

    <div class="container-fluid">
      <form role="form" method="post" class="row g-3 m-2 formEditLote">
        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Datos de Lote</h3>

            <!-- Select Provider-->
            <div class="form-group col-md-6">
              <label for="nameResLot" class="form-label" style="font-weight: bold">Responsable:</label>
              <select class="form-control input-lg" id="nameResLot" name="nameResLot" required>
                <option value="">Seleccione el Responsable</option>
                <?php
                $listResponsables = PersonalController::ctrGetPersonalByType("1");
                foreach ($listResponsables as $value) {
                  echo '<option value="' . $value["IdPer"] . '" ' . $selected . '>' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-md-3">
              <label for="dateCreatLot" class="form-label" style="font-weight: bold">Fecha Lote: </label>
              <input type="date" class="form-control" id="dateCreatLot" name="dateCreatLot" required><br>
            </div>
            <div class="col-md-3">
              <label for="dateVenciLot" class="form-label" style="font-weight: bold">Fecha Vencimiento: </label>
              <input type="date" class="form-control" id="dateVenciLot" name="dateVenciLot"><br><br>
            </div>

            <!-- Description -->
            <div class="form-group col-md-6 inl">
              <label for="codLot" class="form-label" style="font-weight: bold"> Numero de Lote:</label>
              <input type="text" class="form-control" id="codLot" name="codLot" placeholder="L-000000#00000FV0000">
              <!-- <br><button type="button" class="btn btn-outline-success" id="genLot" name="genLot">Generar</button> -->
            </div>

            <div class="form-group col-md-6">
              <label for="DesLot" class="form-label" style="font-weight: bold">Descripcion Lote:</label>
              <input type="text" class="form-control" id="DesLot" name="DesLot" placeholder="Ingrese Descripcion de Lote">
            </div>

            <!-- estados -->
            <div class="form-group col-md-3 d-flex align-items-center">
              <label for="stateLot" class="form-label" style="font-weight: bold">Estado:</label>
              <select class="form-control ml-3" id="stateLot" name="stateLot">
                <option value="7">Ingresado</option>
                <!-- <option value="8">Retirado</option> -->
                <!-- <option value="6">Devolucion</option> -->
              </select>
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
            <button type="button" class="col-3 d-inline-flex-center p-2 btn btn-danger closelotes" href="index.php?ruta=lotes">Cerrar</button>
            <button type="submit" class="col-4 d-inline-flex-center p-2 btn btn-success " name="submitEditLote">Registrar Lote</button>
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