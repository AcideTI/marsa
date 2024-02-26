<?php

require_once "conexion.php";

class UsersModel
{
  // Actualizar último inicio de sesión
  public static function mdlUpdateLastLogin($table, $lastlogin, $userId)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET LastConnection=:LastConnection WHERE IdUsu = :IdUsu");
    $statement -> bindParam(":LastConnection", $lastlogin, PDO::PARAM_STR);
    $statement -> bindParam(":IdUsu", $userId, PDO::PARAM_INT);
    if ($statement->execute()){
      return "ok";
    }
    else
    {
      return "error";
    }
  }

 public static function mdlGetUserDataVerify($table, $username)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_usuario.IdUsu, tb_usuario.password FROM $table WHERE NombreUsu = :NombreUsu");
    $statement -> bindParam(":NombreUsu", $username , PDO::PARAM_STR);
    $statement -> execute();
    return $statement -> fetch();
  }

  // Tomar los datos del usuario para guardar en la sesión
  public static function mdlGetSessionData($table, $user)
  {
    $statement = Conexion::conn()->prepare("SELECT IdUsu, IdTipoUsu, NombreUsu, Nombre FROM $table WHERE NombreUsu = :NombreUsu");
    $statement -> bindParam(":NombreUsu", $user , PDO::PARAM_STR);
    $statement -> execute();
    return $statement -> fetch();
  }

  // Obtener todos los usuarios
  public static function mdlGetAllUsers($table)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_usuario.IdUsu, tb_usuario.NombreUsu, tb_usuario.Nombre, tb_usuario.Apellido, tb_usuario.LastConnection, tb_tipousuario.DescripcionTipo FROM $table INNER JOIN tb_tipousuario ON tb_usuario.IdTipoUsu = tb_tipousuario.IdTipoUsu ORDER BY IdUsu ASC");
    $statement -> execute();
    return $statement -> fetchAll();
  }
  
  // Mostrar datos para editar usuario
  public static function mdlGetUserDataEdit($table, $codUser)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_usuario.IdUsu, tb_usuario.IdTipoUsu, tb_usuario.NombreUsu, tb_usuario.Nombre, tb_usuario.Apellido FROM $table WHERE tb_usuario.IdUsu = $codUser");
    $statement -> execute();
    return $statement -> fetch();
  }

  // Obtener todos los tipos de usuarios
  public static function mdlGetUsersType($table)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_tipousuario.IdTipoUsu, tb_tipousuario.DescripcionTipo FROM $table");
    $statement -> execute();
    return $statement -> fetchAll();
  }
  
  // Crear nuevo usuario
  public static function mdlCreateUser($table, $dataCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (IdTipoUsu, NombreUsu, Nombre, Apellido, password, DateCreate, DateUpdate) VALUES(:IdTipoUsu, :NombreUsu, :Nombre, :Apellido, :password, :DateCreate, :DateUpdate)");
    $statement -> bindParam(":IdTipoUsu", $dataCreate["IdTipoUsu"], PDO::PARAM_STR);
    $statement -> bindParam(":NombreUsu", $dataCreate["NombreUsu"], PDO::PARAM_STR);
    $statement -> bindParam(":Nombre", $dataCreate["Nombre"], PDO::PARAM_STR);
    $statement -> bindParam(":Apellido", $dataCreate["Apellido"], PDO::PARAM_STR);
    $statement -> bindParam(":password", $dataCreate["password"], PDO::PARAM_STR);
    $statement -> bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);
    $statement -> bindParam(":DateUpdate", $dataCreate["DateUpdate"], PDO::PARAM_STR);

    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }
  
  // Actualizar datos completos del usuario y contraseña
  public static function mdlUpdateUserComplete($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET IdTipoUsu=:IdTipoUsu, NombreUsu=:NombreUsu, Nombre=:Nombre, Apellido=:Apellido, password=:password, LastConnection=:LastConnection WHERE IdUsu=:IdUsu");
    $statement -> bindParam(":IdTipoUsu", $dataUpdate["IdTipoUsu"], PDO::PARAM_STR);
    $statement -> bindParam(":NombreUsu", $dataUpdate["NombreUsu"], PDO::PARAM_STR);
    $statement -> bindParam(":Nombre", $dataUpdate["Nombre"], PDO::PARAM_STR);
    $statement -> bindParam(":Apellido", $dataUpdate["Apellido"], PDO::PARAM_STR);
    $statement -> bindParam(":password", $dataUpdate["password"], PDO::PARAM_STR);
    $statement -> bindParam(":LastConnection", $dataUpdate["LastConnection"], PDO::PARAM_STR);
    $statement -> bindParam(":IdUsu", $dataUpdate["IdUsu"], PDO::PARAM_STR);
    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  // Actualizar datos del usuario sin cambiar la contraseña
  public static function mdlUpdateUserData($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET IdTipoUsu=:IdTipoUsu, NombreUsu=:NombreUsu, Nombre=:Nombre, Apellido=:Apellido, LastConnection=:LastConnection WHERE IdUsu=:IdUsu");
    $statement -> bindParam(":IdTipoUsu", $dataUpdate["IdTipoUsu"], PDO::PARAM_STR);
    $statement -> bindParam(":NombreUsu", $dataUpdate["NombreUsu"], PDO::PARAM_STR);
    $statement -> bindParam(":Nombre", $dataUpdate["Nombre"], PDO::PARAM_STR);
    $statement -> bindParam(":Apellido", $dataUpdate["Apellido"], PDO::PARAM_STR);
    $statement -> bindParam(":LastConnection", $dataUpdate["LastConnection"], PDO::PARAM_STR);
    $statement -> bindParam(":IdUsu", $dataUpdate["IdUsu"], PDO::PARAM_STR);
    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  // Eliminar usuario
  public static function mdlDeleteUser($table, $codUser)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $table WHERE IdUsu = :IdUsu");
    $statement -> bindParam(":IdUsu", $codUser, PDO::PARAM_INT);
    if ($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

}