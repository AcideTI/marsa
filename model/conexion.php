<?php
class Conexion
{
  static public function conn()
  {
    $link = new PDO("mysql:host=localhost;dbname=marsa_db_2","root","");
    $link->exec("set names utf8");
    return $link;
  }
}