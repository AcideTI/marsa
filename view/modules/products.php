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
      <h1 class="mt-4">Catálogo de Productos</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Todos los Productos</li>
      </ol>
      <div class="d-flex m-2">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddProduct">
          Agregar Producto
        </button>
      </div>
      <div class="card mb-4">
        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Todos los Productos
        </div>
        <div class="card-body">
          <table id="datatablesSimple" class="data-table-Products table">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Detalle</th>
                <th>Categoría</th>
                <th>Unidad</th>
                                <th>Precio</th>
                                <th>Fecha Actualizado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $listProducts = ProductsController::ctrGetAllProducts();
              foreach ($listProducts as $key => $value) {
                echo
                '<tr>
                  <td>' . ($key + 1) . '</td>
                  <td>' . $value["NombreProducto"] . '</td>
                  <td>' . $value["DetalleProducto"] . '</td>
                  <td>' . $value["NombreCategoria"] . '</td>
                  <td>' . $value["Unidad"] . '</td>
                                    <td>' . $value["Precio"] . '</td>
                                    <td>' . $value["DateUpdate"] . '</td>
                  <td>
                    <button class="btn btn-warning btnEditProduct" codProduct="' . $value["IdProd"] . '" data-toggle="modal" data-target="#modalEditProduct"><i class="fa-solid fa-pencil"></i></button>
                    <button class="btn btn-danger btnDeleteProduct" codProduct="' . $value["IdProd"] . '" userTypeProd="' . $_SESSION['IdTipoUsu'] . '"><i class="fa-solid fa-trash"></i></button>
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

<!-- Modal Add Product -->
<div class="modal fade" id="modalAddProduct" tabindex="-1" role="dialog" aria-labelledby="modalAddProduct" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Producto</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form" method="post">
          <!-- Nombre Producto -->
          <div class="form-group">
            <label for="productName" class="col-form-label">Nombre del Producto:</label>
            <input type="text" class="form-control" id="productName" name="productName" required>
          </div>

          <!-- Detalle Producto -->
          <div class="form-group">
            <label for="productDetail" class="col-form-label">Detalle del Producto:</label>
            <input type="text" class="form-control" id="productDetail" name="productDetail">
          </div>

          <!-- Categoría -->
          <div class="form-group">
            <label for="productCategory" class="col-form-label">Categoría:</label>
            <select class="form-control" name="productCategory" id="productCategory">
              <?php
              $categoryList = ProductsController::ctrGetAllCategories();
              foreach ($categoryList as $key => $value) {
                echo '<option value="' . $value["IdCate"] . '">' . $value["NombreCategoria"] . '</option>';
              }
              ?>
            </select>
          </div>

          <!-- Unidad -->
          <div class="form-group">
            <label for="productUnit" class="col-form-label">Unidad:</label>
            <input type="text" class="form-control" id="productUnit" name="productUnit" required>
          </div>

          <!-- Precio -->
          <div class="form-group">
            <label for="productPrice" class="col-form-label">Precio:</label>
            <input type="number" step="0.01" class="form-control" id="productPrice" name="productPrice" required>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Crear Producto</button>
          </div>
          <?php
            $createProduct = new ProductsController();
            $createProduct->ctrCreateProduct();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Producto -->
<div class="modal fade" id="modalEditProduct" tabindex="-1" role="dialog" aria-labelledby="modalEditProduct" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form" method="post">
          <!-- Nombre Producto -->
          <div class="form-group">
            <label for="editProductName" class="col-form-label">Nombre del Producto:</label>
            <input type="text" class="form-control" id="editProductName" name="editProductName" required>
          </div>

          <!-- Detalle Producto -->
          <div class="form-group">
            <label for="editProductDetail" class="col-form-label">Detalle del Producto:</label>
            <input type="text" class="form-control" id="editProductDetail" name="editProductDetail">
          </div>

          <!-- Categoría -->
          <div class="form-group">
            <label for="editProductCategory" class="col-form-label">Categoría:</label>
            <select class="form-control" name="editProductCategory" id="editProductCategory">
              <?php
              $categoryList = ProductsController::ctrGetAllCategories();
              foreach ($categoryList as $key => $value) {
                echo '<option value="' . $value["IdCate"] . '">' . $value["NombreCategoria"] . '</option>';
              }
              ?>
            </select>
          </div>

          <!-- Unidad -->
          <div class="form-group">
            <label for="editProductUnit" class="col-form-label">Unidad:</label>
            <input type="text" class="form-control" id="editProductUnit" name="editProductUnit" required>
          </div>

          <!-- Precio -->
          <div class="form-group">
            <label for="editProductPrice" class="col-form-label">Precio:</label>
            <input type="number" step="0.01" class="form-control" id="editProductPrice" name="editProductPrice" required>
          </div>

          <div class="modal-footer">
            <input type="hidden" id="codProduct" name="codProduct" class="codProduct">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Editar Producto</button>
          </div>
          <?php
            $editProduct = new ProductsController();
            $editProduct->ctrEditProduct();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
  $deleteProduct = new ProductsController();
  $deleteProduct->ctrDeleteProduct();
?>