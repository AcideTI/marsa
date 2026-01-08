<?php
class Conexion
{
  static public function conn()
  {
    /* base de datos Docker - usar nombre del servicio 'db' */
    $link = new PDO("mysql:host=db;dbname=pruebasbetaacide_marsa", "root", "test");
    /* base de datos cpanel */
    /* $link = new PDO("mysql:host=localhost;dbname=pruebasbetaacide_marsa", "pruebasbetaacide_admin_marsa", "&4ptnm!9dqdHM5m4"); */
    $link->exec("set names utf8");
    return $link;
  }
}