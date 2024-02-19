<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php require "modules/header.php" ?>
</head>

  <?php
    if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok")
    {
      echo '<body class="sb-nav-fixed">';
      
      include "modules/navbar.php";

      echo '
      <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
          <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
              <div class="nav">';
      include "modules/menu.php";

      if(isset($_GET["ruta"]))
      {
        if(
          $_GET["ruta"] == "home" ||  
          $_GET["ruta"] == "users" ||
          $_GET["ruta"] == "products" ||
          $_GET["ruta"] == "personal" ||
          $_GET["ruta"] == "clients" ||
          $_GET["ruta"] == "ingresos" ||
          $_GET["ruta"] == "nuevoIngreso" ||
          $_GET["ruta"] == "almacen" ||
          $_GET["ruta"] == "notaPedido" ||
          $_GET["ruta"] == "editNotaPedido" ||
          $_GET["ruta"] == "lotes" ||
          $_GET["ruta"] == "editLote" ||
          $_GET["ruta"] == "nuevoLote" ||
          $_GET["ruta"] == "categorias" ||
          $_GET["ruta"] == "editarIngreso" ||
          $_GET["ruta"] == "verSalidas" ||

          $_GET["ruta"] == "signout" 
             )
        {
          include "modules/".$_GET["ruta"].".php";
        }
        else
        {
          include "web/404.html";
        }
      }
      else
      {
        include "modules/home.php";
      }
      echo '<footer>';
      include "modules/footer.php";
      echo '</footer>';
      echo '</div>';
      echo '</div>';
    }
    else
    {
      include "modules/login.php";
    }
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="js/users.js"></script>
<script src="js/products.js"></script>
<script src="js/personal.js"></script>
<script src="js/clients.js"></script>
<script src="js/ingresos.js"></script>
<script src="js/almacen.js"></script>
<script src="js/notaPedido.js"></script>
<script src="js/lotes.js"></script>

</body>
</html>