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
        Nuevo Ingreso de Produccion
      </h1>
    </div>

    <div class="container-fluid">
      <form role="form" method="post" class="row g-3 m-2 formNuevoIngreso">
        <span class="border border-3 p-3">
          <div class="container row g-3">
            <h3>Datos de Produccion</h3>
            <!-- Select Provider-->
            <div class="form-group col-md-8">
              <label for="nameRes" class="form-label" style="font-weight: bold">Responsable:</label>
              <select class="form-control input-lg" id="nameRes" name="nameRes" required>
                <option value="">Seleccione el Operador</option>
                <?php
                $listOperadores = PersonalController::ctrGetPersonalByType("2");
                foreach ($listOperadores as $value) {
                    echo '<option value="' . $value["IdPer"] . '">' . $value["NombrePer"] . ' ' . $value["ApellidoPer"] . '</option>';
                }
                ?>
              </select><br <!-- Description -->
              <div class="form-group col-md-8">
              <label for="DescripcionIng" class="form-label" style="font-weight: bold">Descripción de Ingreso:</label>
                <input type="text" class="form-control" id="DescripcionIng" name="DescripcionIng" value="" placeholder="Descripcion Ingreso">
                  <!-- Campo adicional para el lote como select -->

              </div>
            
              <div class="form-group col-md-12 d-flex align-items-start">
                <div id="stateIngWrapper">
                  <label for="stateIng" class="form-label" style="font-weight: bold">Estado:</label>
                  <select class="form-control" id="stateIng" name="stateIng">
                    <option value="7">Ingresado</option>
                    <option value="6">Devolucion</option>
                    <option value="2">Vencido</option>
                    <option value="9">Merma</option>
                  </select>
                </div>

                  <!-- Botón de Ingreso Normal -->
                  <div class="col-md-2" style="margin-left: 360px;">
                    <label for="IngNormal" class="form-label" style="font-weight: bold">Ingreso</label><br>
                    <button type="button" class="btn btn-outline-success" id="IngNormal" name="IngNormal">Normal</button>

                  </div>
              </div>

              </div>

              <!-- Date -->
              <div class="col-md-2">
              <label for="dateProduction" class="form-label" style="font-weight: bold">Fecha Ingreso: </label>
              <input type="date" class="form-control" id="dateProduction" name="dateProduction" required>

              <label for="dateVenci" class="form-label" style="font-weight: bold">Fecha Vencimiento: </label>
              <input type="date" class="form-control" id="dateVenci" name="dateVenci" required><br><br>
                  
              <!-- boton de ingresar devolucion -->
              <label for="IngVenci" class="form-label" style="font-weight: bold">Ingresar</label><br>
              <button type="submit" class="btn btn-outline-danger" id="IngVenci" name="IngVenci">Devolucion</button> 
            </div>

             <!-- Date -->
             <div class="col-md-2">
              <label for="dateDev" class="form-label" style="font-weight: bold">Fecha Devolucion: </label>
              <input type="date" class="form-control" id="dateDev" name="dateDev" readonly>

              <label for="dateMerma" class="form-label" style="font-weight: bold">Fecha Merma: </label>
              <input type="date" class="form-control" id="dateMerma" name="dateMerma" readonly><br><br>
                  
              <!-- boton de ingresar Merma -->
              <label for="IngMerma" class="form-label" style="font-weight: bold"> Ingresar </label><br>
              <button type="submit" class="btn btn-outline-dark" id="IngMerma" name="IngMerma">Merma</button> 
           
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
              <!-- aqui se agregan los productos del modal de prodcutos  -->    
            <div class="form-group row newProductAddIng">
              <input type="hidden" id="listProducts" name="listProducts">
              <!-- aqui se agregan los productos del modal de prodcutos  -->
            </div>
          </div>

        </span>
        <div class="container row g-3 p-3 justify-content-between">
          <button type="button" class="col-1 d-inline-flex-center p-2 btn btn-danger closeIngresoNuevo">Cerrar</button>
          <button type="submit" class="col-2 d-inline-flex-center p-2 btn btn-success ">Registrar Ingreso</button>
        </div>
      </form>
    </div>
  </main>
</div>

</div>

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