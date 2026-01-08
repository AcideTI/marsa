<?php
date_default_timezone_set('America/Bogota');

class UsersController
{
  // Obtener todos los usuarios
  public static function ctrGetAllUsers()
  {
    $table = "tb_usuario";
    $usersList = UsersModel::mdlGetAllUsers($table);
    return $usersList;
  }

  // Obtener todos los tipos de usuarios
  public static function ctrGetUsersType()
  {
    $table = "tb_tipousuario";
    $typesList = UsersModel::mdlGetUsersType($table);
    return $typesList;
  }

  // Verificar usuario para iniciar sesión
  static public function ctrVerifyUser($username, $password)
  {
  $table = "tb_usuario";
  $userData = UsersModel::mdlGetUserDataVerify($table, $username);
  if ($userData != false) {
    $verify = password_verify($password, $userData["password"]);
  } else {
    return $verify = false;
  }
  return $verify;
  }

  // Obtener datos del usuario para editar
  static public function ctrGetUserDataEdit($codUser)
  {
    $table = "tb_usuario";
    $userData = UsersModel::mdlGetUserDataEdit($table, $codUser);
    return $userData;
  }

  // Verificar datos para iniciar sesión
  static public function ctrLogIn()
  {
  if (isset($_POST["inputUser"]) && $_POST["inputUser"] != "" && $_POST["inputUser"] != null && $_POST["inputPassword"] != "" && $_POST["inputPassword"] != null) {
    $verify = self::ctrVerifyUser($_POST["inputUser"], $_POST["inputPassword"]);

    if ($verify != false) {
      $table = "tb_usuario";

      $userData = UsersModel::mdlGetSessionData($table, $_POST["inputUser"]);
      $_SESSION["login"] = "ok";
      $_SESSION["IdUsu"] = $userData["IdUsu"];
      $_SESSION["NombreUsu"] = $userData["NombreUsu"];
      $_SESSION["Nombre"] = $userData["Nombre"];
      $_SESSION["IdTipoUsu"] = $userData["IdTipoUsu"];

      // Guardar último inicio de sesión
      $lastLogin = date("Y-m-d\TH:i:sP");

      $updateConnection = UsersModel::mdlUpdateLastLogin($table, $lastLogin, $userData["IdUsu"]);
      if ($updateConnection == "ok") {
        echo '<script>
          window.location = "home";
        </script>';
      }
    } else {
      echo '<br><div class="alert alert-danger" role="alert">Error en los datos ingresados, vuelve a intentarlo</div>';
    }
  }
  }

  // Crear nuevo usuario
  static public function ctrCreateUser()
  {
    if (isset($_POST["userFirstName"]) && isset($_POST["userLastName"]) && isset($_POST["userName"]) && isset($_POST["userPassword"])) {
      $table = "tb_usuario";
      $passwordCrypt = password_hash($_POST["userPassword"], PASSWORD_ARGON2ID, [
        'memory_cost' => 1 << 12,
        'time_cost' => 2,
        'threads' => 2
      ]);

      $dataCreate = array(
        "IdTipoUsu" => $_POST["userType"],
        "NombreUsu" => $_POST["userName"],
        "Nombre" => $_POST["userFirstName"],
        "Apellido" => $_POST["userLastName"],
        "password" => $passwordCrypt,
        "DateCreate" => date("Y-m-d\TH:i:sP"),
        "DateUpdate" => date("Y-m-d\TH:i:sP"),
      );

      $response = UsersModel::mdlCreateUser($table, $dataCreate);
      if ($response == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Usuario Creado Correctamente', 'users');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al crear el usuario', 'users');
        echo $message;
      }
    }
  }

  // Editar datos del usuario
  static public function ctrEditUser()
  {
    if (isset($_POST["editFirstName"]) && isset($_POST["editLastName"]) && isset($_POST["editUserName"])) {
      $table = "tb_usuario";
      if ($_POST["editPassword"] != null) {
        $passwordCrypt = password_hash($_POST["editPassword"], PASSWORD_ARGON2ID, [
          'memory_cost' => 1 << 12,
          'time_cost' => 2,
          'threads' => 2
        ]);
        $dataUpdate = array(
          "IdTipoUsu" => $_POST["editUserType"],
          "NombreUsu" => $_POST["editUserName"],
          "Nombre" => $_POST["editFirstName"],
          "Apellido" => $_POST["editLastName"],
          "password" => $passwordCrypt,
          "LastConnection" => date("Y-m-d\TH:i:sP"),
          "IdUsu" => $_POST["codUser"]
        );

        $response = UsersModel::mdlUpdateUserComplete($table, $dataUpdate);
      } else {
        $dataUpdate = array(
          "IdTipoUsu" => $_POST["editUserType"],
          "NombreUsu" => $_POST["editUserName"],
          "Nombre" => $_POST["editFirstName"],
          "Apellido" => $_POST["editLastName"],
          "LastConnection" => date("Y-m-d\TH:i:sP"),
          "IdUsu" => $_POST["codUser"]
        );

        $response = UsersModel::mdlUpdateUserData($table, $dataUpdate);
      }

      if ($response == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Usuario Editado Correctamente', 'users');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Editar el Usuario', 'users');
        echo $message;
      }
    }
  }

  // Eliminar usuario
  public static function ctrDeleteUser()
  {
    if (isset($_GET["codUser"])) {
      $table = "tb_usuario";
      $codUser = $_GET["codUser"];
      $response = UsersModel::mdlDeleteUser($table, $codUser);
      if ($response == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Usuario Eliminado Correctamente', 'users');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Eliminar el Usuario', 'users');
        echo $message;
      }
    }
  }
}
