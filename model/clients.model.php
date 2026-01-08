<?php
require_once "conexion.php";


class ClientsModel
{

  //  Get clients
  public static function mdlGetClients($table)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_client.IdClient, tb_client.NameClient FROM $table ORDER BY IdClient DESC");
    $statement->execute();
    return $statement->fetchAll();
  }

  // Obtener todos los clientes
  public static function mdlGetAllClients($table)
  {
    $statement = Conexion::conn()->prepare("SELECT 
    tb_cliente.IdCli, 
    tb_cliente.RucCli, 
    tb_cliente.NombreCli, 
    tb_cliente.CorreoCli, 
    tb_cliente.DireccionCli, 
    tb_cliente.TelefonoCli,
    tb_cliente.RazonSocial, 
    tb_estado.TipoEstado AS Estado, 
    tb_cliente.DateCreate 
    -- tb_cliente.DateUpdate 
    FROM 
    $table
    INNER JOIN 
    tb_estado ON tb_cliente.Estado = tb_estado.IdEstado 
    WHERE 
    tb_estado.TipoEstado IN ('Activo', 'Inactivo') 
    ORDER BY 
    IdCli DESC");
    $statement->execute();
    return $statement->fetchAll();
  }
  
  // Create clients
  public static function mdlCreateClient($table, $dataCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (RucCli, RazonSocial,NombreCli, CorreoCli, DireccionCli, TelefonoCli, Estado, DateCreate, DateUpdate)
     VALUES(:RucCli,:RazonSocial,:NombreCli, :CorreoCli, :DireccionCli, :TelefonoCli, :Estado, :DateCreate, :DateUpdate)");
    $statement->bindParam(":RucCli", $dataCreate["RucCli"], PDO::PARAM_STR);
    $statement->bindParam(":RazonSocial", $dataCreate["RazonSocial"], PDO::PARAM_STR);
    $statement->bindParam(":NombreCli", $dataCreate["NombreCli"], PDO::PARAM_STR);
    $statement->bindParam(":CorreoCli", $dataCreate["CorreoCli"], PDO::PARAM_STR);
    $statement->bindParam(":DireccionCli", $dataCreate["DireccionCli"], PDO::PARAM_STR);
    $statement->bindParam(":TelefonoCli", $dataCreate["TelefonoCli"], PDO::PARAM_STR);
    $statement->bindParam(":Estado", $dataCreate["Estado"], PDO::PARAM_INT);
    $statement->bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataCreate["DateUpdate"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // Editar datos del cliente
  public static function mdlUpdateClient($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET RucCli=:RucCli, 
    NombreCli=:NombreCli, CorreoCli=:CorreoCli, DireccionCli=:DireccionCli, 
    TelefonoCli=:TelefonoCli, Estado=:Estado, DateUpdate=:DateUpdate
    WHERE IdCli=:IdCli");
    $statement->bindParam(":RucCli", $dataUpdate["RucCli"], PDO::PARAM_STR);
    $statement->bindParam(":NombreCli", $dataUpdate["NombreCli"], PDO::PARAM_STR);
    $statement->bindParam(":CorreoCli", $dataUpdate["CorreoCli"], PDO::PARAM_STR);
    $statement->bindParam(":DireccionCli", $dataUpdate["DireccionCli"], PDO::PARAM_STR);
    $statement->bindParam(":TelefonoCli", $dataUpdate["TelefonoCli"], PDO::PARAM_STR);
    $statement->bindParam(":Estado", $dataUpdate["Estado"], PDO::PARAM_INT);
    $statement->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":IdCli", $dataUpdate["IdCli"], PDO::PARAM_INT);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  // Obtener datos del cliente
  public static function mdlGetClientDataEdit($table, $codClient)
  {
    $statement = Conexion::conn()->prepare("SELECT
    tb_cliente.IdCli, 
    tb_cliente.RazonSocial, 
    tb_cliente.RucCli, 
    tb_cliente.NombreCli, 
    tb_cliente.CorreoCli, 
    tb_cliente.DireccionCli, 
    tb_cliente.TelefonoCli, 
    tb_cliente.Estado 
    FROM $table WHERE tb_cliente.IdCli = $codClient");
    $statement->execute();
    return $statement->fetch();
  }


  // Eliminar cliente
  public static function mdlDeleteClient($table, $codClient)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $table WHERE IdCli = :IdCli");
    $statement->bindParam(":IdCli", $codClient, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}