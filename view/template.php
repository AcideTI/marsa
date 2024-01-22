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
          <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
              <div class="nav">';
      include "modules/menu.php";

      if(isset($_GET["ruta"]))
      {
        if(
          $_GET["ruta"] == "home" ||  
          $_GET["ruta"] == "users" ||
/*           $_GET["ruta"] == "materials" ||
          $_GET["ruta"] == "providers" ||
          $_GET["ruta"] == "movements" ||
          $_GET["ruta"] == "newMovementIC" ||
          $_GET["ruta"] == "newMovementIV" ||
          $_GET["ruta"] == "editMovementIC" ||
          $_GET["ruta"] == "stockMaterials" ||
          $_GET["ruta"] == "stockProducts" ||
          $_GET["ruta"] == "editMovementIV" ||
          $_GET["ruta"] == "newMovementOutsite" ||
          $_GET["ruta"] == "editMovementOutsite" ||
          $_GET["ruta"] == "makers" ||
          $_GET["ruta"] == "allOrders" ||
          $_GET["ruta"] == "models" ||
          $_GET["ruta"] == "newOrder" ||
          $_GET["ruta"] == "editOrder" ||
          $_GET["ruta"] == "editOrderApproved" || */
          $_GET["ruta"] == "signout" 
     /*      $_GET["ruta"] == "buscarProducto" ||
          $_GET["ruta"] == "client"  */
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
<!--   <link rel="stylesheet" href="../css/styles-home.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="js/users.js"></script>
<!--   <script src="js/providers.js"></script>
  <script src="js/materials.js"></script>
  <script src="js/movements.js"></script>
  <script src="js/makers.js"></script>
  <script src="js/orders.js"></script>
  <script src="js/models.js"></script>
  <script src="js/products.js"></script>
  <script src="js/stock.js"></script>
  <script src="js/client.js"></script>
 -->
 
</body>
</html>