<!-- Menu for all users -->
<div class="sb-sidenav-menu-heading">Inicio</div>
<a class="nav-link" href="home">
  <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
  Inicio
</a>
<!-- Inventory -->
<div class="sb-sidenav-menu-heading">Inventario</div>
  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#listInventory" aria-expanded="false" aria-controls="collapseLayouts">
  <div class="sb-nav-link-icon"><i class="fa-solid fa-box-open"></i></div>
  Inventario
  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
  </a>
<div class="collapse" id="listInventory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
  <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="almacen"><i class="fa-solid fa-box"></i><span style="margin-left: 10px;">Almacen</span></a>
   
    
  </nav>
</div>
<!-- Compras -->
<div class="sb-sidenav-menu-heading">Produccion</div>
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#listRegistros" aria-expanded="false" aria-controls="collapseLayouts">
  <div class="sb-nav-link-icon"><i class="fa-solid fa-laptop-medical"></i></div>
  Produccion
  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="listRegistros" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
  <nav class="sb-sidenav-menu-nested nav">
  <a class="nav-link" href="index.php?ruta=nuevoIngreso"><i class="fa-solid fa-plus"></i><span style="margin-left: 10px;">Crear Nuevo Ingreso</span></a>
    <a class="nav-link" href="index.php?ruta=ingresos&type=ingresos"><i class="fa-solid fa-file-lines"></i><span style="margin-left: 10px;">Todos los Ingresos</span></a>
    <!-- <a class="nav-link" href="index.php?ruta=ingresos&type=salidas">Salidas</a> -->
  </nav>
</div>

<!-- Notapedido -->
<div class="sb-sidenav-menu-heading">Nota De Pedido</div>
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#listNotaPedido" aria-expanded="false" aria-controls="collapseLayouts">
  <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-flatbed-suitcase"></i></div>
  Nota Pedido
  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="listNotaPedido" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
  <nav class="sb-sidenav-menu-nested nav">
  <a class="nav-link" href="notaPedido"><i class="fa-solid fa-cart-plus"></i><span style="margin-left: 5px;">Nota de Pedido</span></a>
    <a class="nav-link" href="verNotasPedido"><i class="fa-solid fa-layer-group"></i><span style="margin-left: 5px;">Ver Notas de Pedido</span></a>
    
  </nav>
</div>
<!-- Movements -->
<div class="sb-sidenav-menu-heading">Lotes</div>
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#listMovements" aria-expanded="false" aria-controls="collapseLayouts">
  <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-check"></i></div>
  Lotes
  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="listMovements" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
  <nav class="sb-sidenav-menu-nested nav">
  <a class="nav-link" href="nuevoLote"><i class="fa-solid fa-file-circle-plus"></i><span style="margin-left: 5px;">Crear Lote</span></a>
    <a class="nav-link" href="lotes"><i class="fa-solid fa-clipboard-list"></i><span style="margin-left: 5px;">Todos los Lotes</span></a>
    
    
  </nav>
</div>

<!-- Catalogo -->
<div class="sb-sidenav-menu-heading">Catálogos</div>
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#listaCatalogo" aria-expanded="false" aria-controls="collapseLayouts">
  <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-list"></i></div>
  Catálogos
  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="listaCatalogo" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
  <nav class="sb-sidenav-menu-nested nav">
  <a class="nav-link" href="personal"><i class="fa-solid fa-user-plus"></i><span style="margin-left: 5px;">Personal</span></a>
    <a class="nav-link" href="products"><i class="fa-solid fa-dolly"></i><span style="margin-left: 5px;">Productos</span></a>
    <a class="nav-link" href="categorias"><i class="fa-solid fa-id-card-clip"></i><span style="margin-left: 5px;">Categorias</span></a>
    <a class="nav-link" href="clients"><i class="fa-solid fa-clipboard-user"></i><span style="margin-left: 5px;">Clientes</span></a>
    <a class="nav-link" href="users"><i class="fa-solid fa-id-card-clip"></i><span style="margin-left: 5px;">Usuarios</span></a>
  </nav>
</div>