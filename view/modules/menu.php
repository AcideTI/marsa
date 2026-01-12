<!-- Menu for all users -->
<div class="sb-sidenav-menu-heading">Inicio</div>
<a class="nav-link" href="home">
  <div class="sb-nav-link-icon"><i class="fa-solid fa-desktop"></i></div>
  Inicio
</a>

<!-- Inventory -->
<div class="sb-sidenav-menu-heading">Inventario</div>
<a class="nav-link" href="#">
  <div class="sb-nav-link-icon"><i class="fa-solid fa-box-open"></i></div>
  Inventario
  <span class="submenu-count">2</span>
</a>
<div class="show" id="listInventory">
  <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="almacen"><i class="fa-solid fa-box"></i><span style="margin-left: 10px;">Almacén</span></a>
    <a class="nav-link" href="mermas"><i class="fa-solid fa-trash-can"></i><span style="margin-left: 10px;">Mermas</span></a>
  </nav>
</div>

<!-- Compras -->
<div class="sb-sidenav-menu-heading">Producción diaria</div>
<a class="nav-link" href="#">
  <div class="sb-nav-link-icon"><i class="fa-solid fa-laptop-medical"></i></div>
  Producción
  <span class="submenu-count">2</span>
</a>
<div class="show" id="listRegistros">
  <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="nuevoIngreso"><i class="fa-solid fa-plus"></i><span style="margin-left: 10px;">Crear Nuevo Ingreso</span></a>
    <a class="nav-link" href="ingresos"><i class="fa-solid fa-file-lines"></i><span style="margin-left: 10px;">Todos los Ingresos</span></a>
  </nav>
</div>

<!-- Notapedido -->
<div class="sb-sidenav-menu-heading">Salidas</div>
<a class="nav-link" href="#">
  <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-flatbed-suitcase"></i></div>
  Salidas
  <span class="submenu-count">3</span>
</a>
<div class="show" id="listNotaPedido">
  <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="notaPedido"><i class="fa-solid fa-cart-plus"></i><span style="margin-left: 5px;">Nueva Nota</span></a>
    <a class="nav-link" href="nuevoLote"><i class="fa-solid fa-file-circle-plus"></i><span style="margin-left: 5px;">Nueva Factura</span></a>
    <a class="nav-link" href="verSalidas"><i class="fa-solid fa-layer-group"></i><span style="margin-left: 5px;">Ver Salidas</span></a>
  </nav>
</div>

<!-- Catalogo -->
<div class="sb-sidenav-menu-heading">Catálogos</div>
<a class="nav-link" href="#">
  <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-list"></i></div>
  Catálogos
  <span class="submenu-count"><?php echo ($_SESSION["IdTipoUsu"] == 1) ? '5' : '4'; ?></span>
</a>
<div class="show" id="listaCatalogo">
  <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="personal"><i class="fa-solid fa-user-plus"></i><span style="margin-left: 5px;">Personal</span></a>
    <a class="nav-link" href="products"><i class="fa-solid fa-dolly"></i><span style="margin-left: 5px;">Productos</span></a>
    <a class="nav-link" href="categorias"><i class="fa-solid fa-align-left"></i><span style="margin-left: 5px;">Categorias</span></a>
    <a class="nav-link" href="clients"><i class="fa-solid fa-clipboard-user"></i><span style="margin-left: 5px;">Clientes</span></a>
    <?php if ($_SESSION["IdTipoUsu"] == 1): ?>
      <a class="nav-link text-primary" href="users"><i class="fa-solid fa-id-card-clip"></i><span style="margin-left: 5px;">Usuarios</span></a>
    <?php endif; ?>
  </nav>
</div>