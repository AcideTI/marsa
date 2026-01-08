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
      <h1 class="mt-4">Catálogo de Categorias</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Todas las Categorias</li>
      </ol>
      <div class="d-flex m-2">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddCategoria">
          Agregar Categoria
        </button>
      </div>
      <div class="card mb-4">
        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Todas las Categorias
        </div>
        <div class="card-body">
          <table id="datatablesSimple" class="data-table-Categorias table">
            <thead>
              <tr>
                <th>#</th>
                <th>Descripción</th>
                <th>Última Actualización</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $listCategorias = ProductsController::ctrGetAllCategoriesView();
              foreach ($listCategorias as $key => $value) {
                echo
                '<tr>
                  <td>' . ($key + 1) . '</td>
                  <td>' . $value["NombreCategoria"] . '</td>
                  <td>' . $value["DateUpdate"] . '</td>
                  <td>
                    <button class="btn btn-warning btnEditCategoria" codCategoria="' . $value["IdCate"] . '" data-toggle="modal" data-target="#modalEditCategoria"><i class="fa-solid fa-pencil"></i></button>
                    <button class="btn btn-danger btnDeleteCategoria" codCategoria="' . $value["IdCate"] . '" userTypeCat="' . $_SESSION['IdTipoUsu'] . '"><i class="fa-solid fa-trash"></i></button>
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

<!-- Modal Add Categoria -->
<div class="modal fade" id="modalAddCategoria" tabindex="-1" role="dialog" aria-labelledby="modalAddCategoria" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear Nueva Categoría</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form" method="post">
          <!-- Nombre Categoria -->
          <div class="form-group">
            <label for="descripcionCategoria" class="col-form-label">Nombre de la Categoráa:</label>
            <input type="text" class="form-control" id="descripcionCategoria" name="descripcionCategoria" required>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Crear Categoria</button>
          </div>
          <?php
            $createCategoria = new ProductsController();
            $createCategoria->ctrCreateCategoria();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Producto -->
<div class="modal fade" id="modalEditCategoria" tabindex="-1" role="dialog" aria-labelledby="modalEditCategoria" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Categoría</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form" method="post">
          <!-- Descripcion Categoria -->
          <div class="form-group">
            <label for="editDescripcionCategoria" class="col-form-label">Nombre de la Categoría:</label>
            <input type="text" class="form-control" id="editDescripcionCategoria" name="editDescripcionCategoria" required>
          </div>

          <div class="modal-footer">
            <input type="hidden" id="codCategoriaEdit" name="codCategoriaEdit" class="codCategoriaEdit">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Editar Producto</button>
          </div>
          <?php
            $editCategoria = new ProductsController();
            $editCategoria->ctrEditCategoria();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
  $deleteCategoria = new ProductsController();
  $deleteCategoria->ctrDeleteCategoria();
?>