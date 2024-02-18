<?php
date_default_timezone_set('America/Bogota');

class PersonalController
{
  //  ver a todo el personal
  public static function ctrGetAllPersonal()
  {
    $table = "tb_personal";
    $listPersonal = PersonalModel::mdlGetAllPersonal($table);
    return $listPersonal;
  }

  // ver los tipos de personal
  public static function ctrGetAllTypesPersonal()
  {
    $table = "tb_tipopersonal";
    $listTypesPersonal = PersonalModel::mdlGetAllTypesPersonal($table);
    return $listTypesPersonal;
  }

  // Crear Personal
  public static function ctrCreatePersonal()
  {
    if (isset($_POST["firstNamePer"]) && isset($_POST["lastNamePer"]) && isset($_POST["personalTypePer"])) {
      $table = "tb_personal";
      $dataCreate = array(
        "IdTipoPer" => $_POST["personalTypePer"], // Usar el tipo de personal enviado por el modal
        "dni" => $_POST["dniNumberPer"],
        "NombrePer" => $_POST["firstNamePer"],
        "ApellidoPer" => $_POST["lastNamePer"],
        "TelefonoPer" => $_POST["phoneNumberPer"],
        "DireccionPer" => $_POST["addressPer"],
        "Estado" => 3, // Estado siempre será "Activo" al crear por que el id 3 en la tabla tb_estado es "Activo" y 4 es "Inactivo"
        "DateCreate" => date("Y-m-d\TH:i:sP"),
        "DateUpdate" => date("Y-m-d\TH:i:sP")
      );
      $createPersonal = PersonalModel::mdlCreatePersonal($table, $dataCreate);
      if ($createPersonal == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Personal creado Correctamente', 'index.php?ruta=personal');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al crear el Personal', 'index.php?ruta=personal');
        echo $message;
      }
    }
  }

  // Editar Personal
  public static function ctrUpdatePersonal()
  {
    if (isset($_POST["editFirstNamePer"]) && isset($_POST["editLastNamePer"])) {
      $table = 'tb_personal';
      $dataUpdate = array(
        "IdTipoPer" => $_POST["editPersonalTypePer"],
        "dni" => $_POST["editDniNumberPer"],
        "NombrePer" => $_POST["editFirstNamePer"],
        "ApellidoPer" => $_POST["editLastNamePer"],
        "TelefonoPer" => $_POST["editPhoneNumberPer"],
        "DireccionPer" => $_POST["editAddressPer"],
        "Estado" => $_POST["editEstadoPer"],
        "DateUpdate" => date("Y-m-d\TH:i:sP"),
        "IdPer" => $_POST["codPersonal"]
      );
      $updateData = PersonalModel::mdlUpdatePersonal($table, $dataUpdate);
      if ($updateData == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Personal editado Correctamente', 'index.php?ruta=personal');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Editar el Personal', 'index.php?ruta=personal');
        echo $message;
      }
    }
  }

  // Obtener datos del personal para mostrar en el modal editar funcion a traves de ajax
  public static function ctrGetPersonalDataEdit($codPersonal)
  {
    $table = "tb_personal";
    $dataPersonal = PersonalModel::mdlGetPersonalDataEdit($table, $codPersonal);
    return $dataPersonal;
  }

  // Delete personal
  public static function ctrDeletePersonal()
  {
    if (isset($_GET["codPersonal"])) {

      $codPersonal = $_GET["codPersonal"];
      //  Verificar si el producto está dentro de la tabla almacén, si es así no se puede eliminar -> Solo almacén 
      $historialPer = IngresosController::ctrGetHistorialPer($codPersonal);
      $historialPerVend = NotaPedidoController::ctrGetHistorialPerVend($codPersonal);
      $historialPerRes = NotaPedidoController::ctrGetHistorialPerRes($codPersonal);

      $countPer = $historialPer["IdPer"];
      $countPerVend = $historialPerVend["IdRes"];
      $countPerRes = $historialPerRes["IdPer"];

      if ($countPer > 0 || $countPerVend > 0 || $countPerRes > 0) {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Al eliminar al Personal ya tiene movimientos en el sistema', 'personal');
      } else {
        $table = "tb_personal";
        $response = PersonalModel::mdlDeletePersonal($table, $codPersonal);
        if ($response == "ok") {
          $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Personal eliminado correctamente', 'personal');
          
        } else {
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al eliminar el personal', 'personal');
          
        }
      }
     echo $message;
    }
  }

  //  Obtener personales por el tipo de personal
  public static function ctrGetPersonalByType($typePersonal)
  {
    $table = "tb_personal";
    $listPersonal = PersonalModel::mdlGetPersonalByType($table, $typePersonal);
    return $listPersonal;
  }
}
