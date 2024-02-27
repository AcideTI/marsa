<?php
date_default_timezone_set('America/Bogota');

class ClientsController
{

  //  Get clients to create an order
  public static function ctrGetClients()
  {
    $table = "tb_client";
    $listClients = ClientsModel::mdlGetClients($table);
    return $listClients;
  }

  // Mostrar todos los clientes
  public static function ctrGetAllClients()
  {
    $table = "tb_cliente";
    $listClients = ClientsModel::mdlGetAllClients($table);
    return $listClients; 
  }

  // crear cliente nuevo
  public static function ctrCreateClient()
  {
    if (isset($_POST["NameCli"]) && isset($_POST["Ru"])) {
      $table = "tb_cliente";
      $dataCreate = array(
        "RucCli" => $_POST["Ru"],
        "RazonSocial" => $_POST["razonSocial"],
        "NombreCli" => $_POST["NameCli"],
        "CorreoCli" => $_POST["EmailCli"],
        "DireccionCli" => $_POST["AddressCli"],
        "TelefonoCli" => $_POST["PhoneCli"],
        "Estado" => 3,
        "DateCreate" => date("Y-m-d H:i:s"),
        "DateUpdate" => date("Y-m-d H:i:s")
      );
      $createClient = ClientsModel::mdlCreateClient($table, $dataCreate);
      if ($createClient == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Cliente creado Correctamente', 'index.php?ruta=clients');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al crear el Cliente', 'index.php?ruta=clients');
        echo $message;
      }
    }
  }
  // Editar Cliente
  public static function ctrUpdateClients()
  {
    if (isset($_POST["EditNameCli"]) && isset($_POST["EditRu"])) {
      $table = 'tb_cliente';
      $dataUpdate = array(
        "RucCli" => $_POST["EditRu"],
        "NombreCli" => $_POST["EditNameCli"],
        "CorreoCli" => $_POST["EditEmailCli"],
        "DireccionCli" => $_POST["EditAddressCli"],
        "TelefonoCli" => $_POST["EditPhoneCli"],
        "Estado" => $_POST["EditStateCli"],
        "DateUpdate" => date("Y-m-d\TH:i:sP"),
        "IdCli" => $_POST["codClient"]
      );
      $updateData = ClientsModel::mdlUpdateClient($table, $dataUpdate);
      if ($updateData == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Cliente editado correctamente', 'index.php?ruta=clients');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al editar el cliente', 'index.php?ruta=clients');
        echo $message;
      }
    }
  }

  // Obtener datos del cliente para editar
  public static function ctrGetClientDataEdit($codClient)
  {
    $table = "tb_cliente";
    $dataClient = ClientsModel::mdlGetClientDataEdit($table, $codClient);
    return $dataClient;
  }

  // Eliminar cliente
  public static function ctrDeleteClient()
  {
    if (isset($_GET["codClient"])) {

      $codClient = $_GET["codClient"];
      //  Verificar si el producto está dentro de la tabla almacén, si es así no se puede eliminar -> Solo almacén 
      $historialCli = NotaPedidoController::ctrGetHistorialCliente($codClient);

      if ($historialCli["IdCliente"] > 0) {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Al eliminar Cliente ya tiene movimientos en el sistema', 'products');
      } else {
        $table = "tb_cliente";
        $response = ClientsModel::mdlDeleteClient($table, $codClient);
        if ($response == "ok") {
          $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Cliente eliminado correctamente', 'clients');

        } else {
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al eliminar el cliente', 'clients');

        }

      }
      echo $message;
    }
  }
}
