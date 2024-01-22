<!-- Menu for all users -->
<div class="sb-sidenav-menu-heading">Inicio</div>
<a class="nav-link" href="home">
  <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
  Inicio
</a>

<!-- Compras -->
<div class="sb-sidenav-menu-heading">Almacen</div>
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#listCompras" aria-expanded="false" aria-controls="collapseLayouts">
  <div class="sb-nav-link-icon"><i class="fa fa-exchange"></i></div>
  Produccion
  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="listCompras" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
  <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="index.php?ruta=movements&type=insides">Ingresos</a>
    <a class="nav-link" href="index.php?ruta=movements&type=outsides">Salidas</a>
  </nav>
</div>
<!-- Inventory -->
<div class="sb-sidenav-menu-heading">Inventario</div>
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#listInventory" aria-expanded="false" aria-controls="collapseLayouts">
  <div class="sb-nav-link-icon"><i class="fa fa-archive"></i></div>
  Inventario
  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="listInventory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
  <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="stockMaterials">Lotes</a>
    <a class="nav-link" href="stockProducts">Productos</a>
  </nav>
</div>

<!-- Movements -->
<div class="sb-sidenav-menu-heading">Lotes</div>
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#listMovements" aria-expanded="false" aria-controls="collapseLayouts">
  <div class="sb-nav-link-icon"><i class="fa fa-list"></i></div>
  Lotes
  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="listMovements" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
  <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="allOrders">Lotes</a>
    <a class="nav-link" href="materials">Productos</a>
  </nav>
</div>


<!-- Catalogo -->
<div class="sb-sidenav-menu-heading">Catálogos</div>
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#listaCatalogo" aria-expanded="false" aria-controls="collapseLayouts">
  <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
  Catálogos
  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="listaCatalogo" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
  <nav class="sb-sidenav-menu-nested nav">

    
    <a class="nav-link" href="providers">Operadores</a>
    
    <a class="nav-link" href="client">Clientes</a>
    <a class="nav-link" href="users">Usuarios</a>
  </nav>
</div>