<?php
require_once "conexion.php";


class PersonalModel
{
  //  mostrar a todo el personal
  public static function mdlGetAllPersonal($table)
  {
    $statement = Conexion::conn()->prepare("SELECT 
    tb_personal.IdPer, 
    tb_personal.NombrePer, 
    tb_personal.ApellidoPer, 
    tb_personal.dni, 
    tb_personal.TelefonoPer, 
    tb_personal.DireccionPer, 
    tb_tipopersonal.DescripcionTipoPer AS IdTipoPer,
    tb_estado.TipoEstado AS Estado 
    FROM 
    $table
    INNER JOIN 
    tb_tipopersonal ON tb_personal.IdTipoPer = tb_tipopersonal.IdTipoPer 
    INNER JOIN 
    tb_estado ON tb_personal.Estado = tb_estado.IdEstado 
    WHERE 
    tb_estado.TipoEstado IN ('Activo', 'Inactivo') 
    ORDER BY 
    IdPer DESC");
    $statement->execute();
    return $statement->fetchAll();
  }

  // ver los tipos de personal
  public static function mdlGetAllTypesPersonal($table)
  {
    $statement = Conexion::conn()->prepare("SELECT IdTipoPer, DescripcionTipoPer FROM $table ORDER BY IdTipoPer DESC");
    $statement->execute();
    return $statement->fetchAll();
  }

  // Crear Personal
  public static function mdlCreatePersonal($table, $dataCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (IdTipoPer, dni, NombrePer, ApellidoPer, TelefonoPer, DireccionPer, Estado, DateCreate, DateUpdate) VALUES(:IdTipoPer, :dni, :NombrePer, :ApellidoPer, :TelefonoPer, :DireccionPer, :Estado, :DateCreate, :DateUpdate)");
    $statement->bindParam(":IdTipoPer", $dataCreate["IdTipoPer"], PDO::PARAM_INT);
    $statement->bindParam(":dni", $dataCreate["dni"], PDO::PARAM_INT);
    $statement->bindParam(":NombrePer", $dataCreate["NombrePer"], PDO::PARAM_STR);
    $statement->bindParam(":ApellidoPer", $dataCreate["ApellidoPer"], PDO::PARAM_STR);
    $statement->bindParam(":TelefonoPer", $dataCreate["TelefonoPer"], PDO::PARAM_STR);
    $statement->bindParam(":DireccionPer", $dataCreate["DireccionPer"], PDO::PARAM_STR);
    $statement->bindParam(":Estado", $dataCreate["Estado"], PDO::PARAM_INT);
    $statement->bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataCreate["DateUpdate"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  // Editar datos del personal
  public static function mdlUpdatePersonal($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET IdTipoPer=:IdTipoPer, dni=:dni, NombrePer=:NombrePer, ApellidoPer=:ApellidoPer, TelefonoPer=:TelefonoPer, DireccionPer=:DireccionPer, Estado=:Estado, DateUpdate=:DateUpdate WHERE IdPer=:IdPer");
    $statement->bindParam(":IdTipoPer", $dataUpdate["IdTipoPer"], PDO::PARAM_INT);
    $statement->bindParam(":dni", $dataUpdate["dni"], PDO::PARAM_INT);
    $statement->bindParam(":NombrePer", $dataUpdate["NombrePer"], PDO::PARAM_STR);
    $statement->bindParam(":ApellidoPer", $dataUpdate["ApellidoPer"], PDO::PARAM_STR);
    $statement->bindParam(":TelefonoPer", $dataUpdate["TelefonoPer"], PDO::PARAM_STR);
    $statement->bindParam(":DireccionPer", $dataUpdate["DireccionPer"], PDO::PARAM_STR);
    $statement->bindParam(":Estado", $dataUpdate["Estado"], PDO::PARAM_INT);
    $statement->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":IdPer", $dataUpdate["IdPer"], PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  // Obtener datos del personal
  public static function mdlGetPersonalDataEdit($table, $codPersonal)
  {
    $statement = Conexion::conn()->prepare("SELECT * FROM $table WHERE IdPer = :IdPer");
    $statement->bindParam(":IdPer", $codPersonal, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch();
  }

  // Delete personal
  public static function mdlDeletePersonal($table, $codPersonal)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $table WHERE IdPer = :IdPer");
    $statement->bindParam(":IdPer", $codPersonal, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Get personal por tipo de personal
  public static function mdlGetPersonalByType($table, $codTipoPersonal)
  {
    $statement = Conexion::conn()->prepare("SELECT IdPer, NombrePer, ApellidoPer FROM $table WHERE IdTipoPer = :IdTipoPer");
    $statement->bindParam(":IdTipoPer", $codTipoPersonal, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
  }
}
