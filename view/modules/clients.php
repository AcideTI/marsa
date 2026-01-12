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
      <h1 class="mt-4"> Nuevos Clientes</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Todos los Clientes</li>
      </ol>
      <div class="d-flex m-2">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddClients">
          Agregar Clientes
        </button>
      </div>
      <div class="card mb-4">
        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Todos los Clientes
        </div>
        <div class="card-body">
          <table id="tableClients" class="table table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>#</th>
                <th>RUC</th>
                <th>Razon Social</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <!-- Los datos se cargan vía AJAX con server-side processing -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</div>

</div>

<!-- Modal Add Clients -->
<div class="modal fade" id="modalAddClients" tabindex="-1" role="dialog" aria-labelledby="modalAddClients"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalCreatCli">Nuevo Cliente</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form" method="post">
          <!-- RUC Client -->
          <div class="form-group">
            <label for="Ru" class="col-form-label">RUC:</label>
            <input type="text" class="form-control" id="Ru" name="Ru">
          </div>
          <!-- Razon social -->
          <div class="form-group">
            <label for="razonSocial" class="col-form-label">Razon social:</label>
            <input type="text" class="form-control" id="razonSocial" name="razonSocial">
          </div>
          <!-- Name Client -->
          <div class="form-group">
            <label for="NameCli" class="col-form-label">Nombre Cliente:</label>
            <input type="text" class="form-control" id="NameCli" name="NameCli" required>
          </div>
          <!-- Email Client -->
          <div class="form-group">
            <label for="EmailCli" class="col-form-label">Correo Electrónico:</label>
            <input type="email" class="form-control" id="EmailCli" name="EmailCli">
          </div>
          <!-- Address Client -->
          <div class="form-group">
            <label for="AddressCli" class="col-form-label">Dirección:</label>
            <input type="text" class="form-control" id="AddressCli" name="AddressCli">
          </div>
          <!-- Phone Client -->
          <div class="form-group">
            <label for="PhoneCli" class="col-form-label">Número de Teléfono:</label>
            <input type="number" class="form-control" id="PhoneCli" name="PhoneCli">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Crear Cliente</button>
          </div>
          <?php
          $createClient = new ClientsController();
          $createClient->ctrCreateClient();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Clients -->
<div class="modal fade" id="modalEditClients" tabindex="-1" role="dialog" aria-labelledby="modalEditClients"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalEditCli">Editar Cliente</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form" method="post">
          <!-- RUC Client -->
          <div class="form-group">
            <label for="EditRu" class="col-form-label">RUC:</label>
            <input type="text" class="form-control" id="EditRu" name="EditRu">
          </div>
          <!-- Razon social -->
          <div class="form-group">
            <label for="EditRazonSocial" class="col-form-label">Razon social:</label>
            <input type="text" class="form-control" id="EditRazonSocial" name="EditRazonSocial">
          </div>
          <!-- Name Client -->
          <div class="form-group">
            <label for="EditNameCli" class="col-form-label">Nombre Cliente:</label>
            <input type="text" class="form-control" id="EditNameCli" name="EditNameCli" required>
          </div>
          <!-- Email Client -->
          <div class="form-group">
            <label for="EditEmailCli" class="col-form-label">Correo Electrónico:</label>
            <input type="email" class="form-control" id="EditEmailCli" name="EditEmailCli">
          </div>
          <!-- Address Client -->
          <div class="form-group">
            <label for="EditAddressCli" class="col-form-label">Dirección:</label>
            <input type="text" class="form-control" id="EditAddressCli" name="EditAddressCli">
          </div>
          <!-- Phone Client -->
          <div class="form-group">
            <label for="EditPhoneCli" class="col-form-label">Número de Teléfono:</label>
            <input type="number" class="form-control" id="EditPhoneCli" name="EditPhoneCli">
          </div>
          <!-- State Client -->
          <div class="form-group">
            <label for="EditStateCli" class="col-form-label">Estado:</label>
            <select class="form-control" id="EditStateCli" name="EditStateCli" required>
              <option value="3">Activo</option>
              <option value="4">Inactivo</option>
            </select>
          </div>
          <div class="modal-footer">
            <input type="hidden" id="codClient" name="codClient" class="codClient">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Editar Cliente</button>
          </div>
          <?php
          $updateClient = new ClientsController();
          $updateClient->ctrUpdateClients();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>


<?php
$deleteClient = new ClientsController();
$deleteClient->ctrDeleteClient();
?>

<script>
  // Variable global para el tipo de usuario (usada en clients.js para permisos)
  window.currentUserType = <?php echo isset($_SESSION['IdTipoUsu']) ? $_SESSION['IdTipoUsu'] : 0; ?>;
</script>