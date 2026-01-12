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

  // Obtener clientes con paginación server-side para DataTables
  public static function mdlGetClientsPaginated($draw, $start, $length, $searchValue, $orderColumn, $orderDir)
  {
    $conn = Conexion::conn();

    // Columnas para ordenamiento
    $columns = ['IdCli', 'RucCli', 'RazonSocial', 'NombreCli', 'CorreoCli', 'DireccionCli', 'TelefonoCli', 'Estado'];
    $orderColumnName = isset($columns[$orderColumn]) ? $columns[$orderColumn] : 'IdCli';
    $orderDir = ($orderDir === 'asc') ? 'ASC' : 'DESC';

    // Consulta base
    $baseQuery = "FROM tb_cliente 
                  INNER JOIN tb_estado ON tb_cliente.Estado = tb_estado.IdEstado 
                  WHERE tb_estado.TipoEstado IN ('Activo', 'Inactivo')";

    // Agregar búsqueda si hay término
    $searchQuery = "";
    if (!empty($searchValue)) {
      $searchQuery = " AND (
        tb_cliente.RucCli LIKE :search OR 
        tb_cliente.RazonSocial LIKE :search OR 
        tb_cliente.NombreCli LIKE :search OR 
        tb_cliente.CorreoCli LIKE :search OR 
        tb_cliente.DireccionCli LIKE :search OR 
        tb_cliente.TelefonoCli LIKE :search
      )";
    }

    // Total sin filtrar
    $totalQuery = $conn->prepare("SELECT COUNT(*) as total FROM tb_cliente 
                                   INNER JOIN tb_estado ON tb_cliente.Estado = tb_estado.IdEstado 
                                   WHERE tb_estado.TipoEstado IN ('Activo', 'Inactivo')");
    $totalQuery->execute();
    $totalRecords = $totalQuery->fetch(PDO::FETCH_ASSOC)['total'];

    // Total filtrado
    $filteredQuery = $conn->prepare("SELECT COUNT(*) as total $baseQuery $searchQuery");
    if (!empty($searchValue)) {
      $searchParam = "%$searchValue%";
      $filteredQuery->bindParam(':search', $searchParam, PDO::PARAM_STR);
    }
    $filteredQuery->execute();
    $filteredRecords = $filteredQuery->fetch(PDO::FETCH_ASSOC)['total'];

    // Datos paginados
    $dataQuery = $conn->prepare("SELECT 
      tb_cliente.IdCli, 
      tb_cliente.RucCli, 
      tb_cliente.NombreCli, 
      tb_cliente.CorreoCli, 
      tb_cliente.DireccionCli, 
      tb_cliente.TelefonoCli,
      tb_cliente.RazonSocial, 
      tb_estado.TipoEstado AS Estado
      $baseQuery $searchQuery 
      ORDER BY $orderColumnName $orderDir 
      LIMIT :start, :length");

    if (!empty($searchValue)) {
      $searchParam = "%$searchValue%";
      $dataQuery->bindParam(':search', $searchParam, PDO::PARAM_STR);
    }
    $dataQuery->bindParam(':start', $start, PDO::PARAM_INT);
    $dataQuery->bindParam(':length', $length, PDO::PARAM_INT);
    $dataQuery->execute();
    $data = $dataQuery->fetchAll(PDO::FETCH_ASSOC);

    return [
      'draw' => intval($draw),
      'recordsTotal' => intval($totalRecords),
      'recordsFiltered' => intval($filteredRecords),
      'data' => $data
    ];
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