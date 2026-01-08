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
      <h1 class="mt-4">Catálogo de Personal</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Todo el Personal</li>
      </ol>
      <div class="d-flex m-2">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddPersonal">
          Agregar Personal
        </button>
      </div>
      <div class="card mb-4">
        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Todo el Personal
        </div>
        <div class="card-body">
          <table id="datatablesSimple" class="data-table-Personal table">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Tipo</th> <!-- Agregado el tipo de personal -->
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $listPersonal = PersonalController::ctrGetAllPersonal();
              foreach ($listPersonal as $key => $value) {
                $estado = $value["Estado"] == "Activo" ? "<span class='badge bg-success'>Activo</span>" : "<span class='badge bg-danger'>Inactivo</span>";
                echo
                '<tr>
                  <td>' . ($key + 1) . '</td>
                  <td>' . $value["NombrePer"] . '</td>
                  <td>' . $value["ApellidoPer"] . '</td>
                  <td>' . $value["dni"] . '</td>
                  <td>' . $value["TelefonoPer"] . '</td>
                  <td>' . $value["DireccionPer"] . '</td>
                  <td>' . $value["IdTipoPer"] . '</td>
                  <td>' . $estado . '</td>
                  <td>
                    <button class="btn btn-warning btnEditPersonal" codPersonal="' . $value["IdPer"] . '" data-toggle="modal" data-target="#modalEditPersonal"><i class="fa-solid fa-pencil"></i></button>
                    <button class="btn btn-danger btnDeletePersonal" codPersonal="' . $value["IdPer"] . '" userTypePer="' . $_SESSION['IdTipoUsu'] . '"><i class="fa-solid fa-trash"></i></button>
                  </td>
                </tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</div>

</div>

<!-- Modal Agregar Personal -->
<div class="modal fade" id="modalAddPersonal" tabindex="-1" role="dialog" aria-labelledby="modalAddPersonal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Personal</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Cuerpo del modal -->
      <div class="modal-body">
        <form role="form" method="post">

            <!-- Tipo de Personal -->
            <div class="form-group">
              <label for="personalTypePer" class="col-form-label">Tipo de Personal:</label>
              <select class="form-control" name="personalTypePer" id="personalTypePer">
                <?php
              $typePersonalList = PersonalController::ctrGetAllTypesPersonal();
              foreach ($typePersonalList as $key => $value) {
                echo '<option value="' . $value["IdTipoPer"] . '">' . $value["DescripcionTipoPer"] . '</option>';
              }
              ?>
            </select>
          </div>

          <!-- Nombre del Personal -->
          <div class="form-group">
            <label for="firstNamePer" class="col-form-label">Nombres:</label>
            <input type="text" class="form-control" id="firstNamePer" name="firstNamePer" required>
          </div>

          <!-- Apellido del Personal -->
          <div class="form-group">
            <label for="lastNamePer" class="col-form-label">Apellidos:</label>
            <input type="text" class="form-control" id="lastNamePer" name="lastNamePer" >
          </div>

          <!-- DNI del Personal -->
          <div class="form-group">
            <label for="dniNumberPer" class="col-form-label">DNI:</label>
            <input type="text" class="form-control" id="dniNumberPer" name="dniNumberPer">
          </div>

          <!-- Número de Contacto del Personal -->
          <div class="form-group">
            <label for="phoneNumberPer" class="col-form-label">Telefono</label>
            <input type="text" class="form-control" id="phoneNumberPer" name="phoneNumberPer" >
          </div>

          <!-- Dirección del Personal -->
          <div class="form-group">
            <label for="addressPer" class="col-form-label">Dirección:</label>
            <input type="text" class="form-control" id="addressPer" name="addressPer" >
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Crear Personal</button>
          </div>
          <?php
          $createPersonal = new PersonalController();
          $createPersonal->ctrCreatePersonal();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Personal -->
<div class="modal fade" id="modalEditPersonal" tabindex="-1" role="dialog" aria-labelledby="modalEditPersonal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Personal</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <!-- Cuerpo del modal -->
      <div class="modal-body">
        <form role="form" method="post">

            <!-- Tipo de Personal -->
            <div class="form-group">
              <label for="editPersonalTypePer" class="col-form-label">Tipo de Personal:</label>
              <select class="form-control" name="editPersonalTypePer" id="editPersonalTypePer">
                <?php
              $typePersonalList = PersonalController::ctrGetAllTypesPersonal();
              foreach ($typePersonalList as $key => $value) {
                echo '<option value="' . $value["IdTipoPer"] . '">' . $value["DescripcionTipoPer"] . '</option>';
              }
              ?>
            </select>
          </div>
        
          <!-- Nombre del Personal -->
          <div class="form-group">
            <label for="editFirstNamePer" class="col-form-label">Nombres:</label>
            <input type="text" class="form-control" id="editFirstNamePer" name="editFirstNamePer" required>
          </div>

          <!-- Apellido del Personal -->
          <div class="form-group">
            <label for="editLastNamePer" class="col-form-label">Apellidos:</label>
            <input type="text" class="form-control" id="editLastNamePer" name="editLastNamePer" >
          </div>

          <!-- DNI del Personal -->
          <div class="form-group">
            <label for="editDniNumberPer" class="col-form-label">DNI:</label>
            <input type="text" class="form-control" id="editDniNumberPer" name="editDniNumberPer">
          </div>

          <!-- Número de Contacto del Personal -->
          <div class="form-group">
            <label for="editPhoneNumberPer" class="col-form-label">Telefono</label>
            <input type="text" class="form-control" id="editPhoneNumberPer" name="editPhoneNumberPer" >
          </div>

          <!-- Dirección del Personal -->
          <div class="form-group">
            <label for="editAddressPer" class="col-form-label">Dirección:</label>
            <input type="text" class="form-control" id="editAddressPer" name="editAddressPer" >
          </div>

          <!-- Estado del Personal -->
          <div class="form-group">
            <label for="editEstadoPer" class="col-form-label">Estado:</label>
             <select class="form-control" id="editEstadoPer" name="editEstadoPer" required>
                <option value="3">Activo</option>
                <option value="4">Inactivo</option>
              </select>
          </div>

          <div class="modal-footer">
            <input type="hidden" id="codPersonal" name="codPersonal" class="codPersonal">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Editar Personal</button>
          </div>
          <?php
          $editPersonal = new PersonalController();
          $editPersonal->ctrUpdatePersonal();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
$deletePersonal = new PersonalController();
$deletePersonal->ctrDeletePersonal();
?>