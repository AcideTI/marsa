<?php
require_once "conexion.php";

class IngresosModel
{
  /* mostrar todos los registro en la tabla  */
  public static function mdlGetAllIngresos($table)
  {
    $statement = Conexion::conn()->prepare("
      SELECT ing.*, 
        per.NombrePer AS NombrePerIdPer, 
        e.TipoEstado
      FROM $table AS ing
      INNER JOIN tb_personal AS per ON ing.IdPer = per.IdPer
      INNER JOIN tb_estado AS e ON ing.Estado = e.IdEstado
      ORDER BY 
      IdIng DESC");

    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as &$result) {
      // Procesar el campo JSON
      if (isset($result['DatosProductosIngresoJson'])) {
        $productsJson = json_decode($result['DatosProductosIngresoJson'], true);

        foreach ($productsJson as &$product) {
          $statement = Conexion::conn()->prepare("
            SELECT NombreProducto
            FROM tb_producto
            WHERE IdProd = :codProduct
          ");

          $statement->bindParam(":codProduct", $product['codProduct'], PDO::PARAM_INT);

          $statement->execute();

          $productResult = $statement->fetch(PDO::FETCH_ASSOC);

          $product['NombreProducto'] = $productResult['NombreProducto'];
        }

        $result['DatosProductosIngresoJson'] = json_encode($productsJson);
      }
    }

    return $results;
  }
  /* fin */

  // Obtener al responsable por login o sesión de usuario
  public static function mdlGetPersonRes($table, $sessionUserId)
  {
    $statement = Conexion::conn()->prepare("SELECT 
    tb_personal.IdPer,
    tb_personal.IdTipoPer,
    tb_personal.dni,
    tb_personal.NombrePer,
    tb_personal.ApellidoPer,
    tb_personal.TelefonoPer,
    tb_personal.DireccionPer,
    CASE tb_personal.Estado
      WHEN 3 THEN 'Activo'
      WHEN 4 THEN 'Inactivo'
      ELSE 'Otro'
   END AS Estado,
   tb_personal.DateCreate,
   tb_personal.DateUpdate
    FROM 
    $table
    INNER JOIN 
   tb_tipopersonal ON tb_personal.IdTipoPer = tb_tipopersonal.IdTipoPer 
   LEFT JOIN 
    tb_usuario ON tb_tipopersonal.IdUsu = tb_usuario.IdUsu
    WHERE 
   tb_tipopersonal.DescripcionTipoPer = 'Responsable' AND tb_tipopersonal.IdUsu = :sessionUserId AND tb_personal.Estado = 3
    ORDER BY 
    IdPer DESC");
    $statement->bindParam(":sessionUserId", $sessionUserId, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
  }

  // Mostrar los productos a agregar
  public static function mdlGetProductData($table)
  {
    $statement = Conexion::conn()->prepare("SELECT IdProd, NombreProducto, Unidad FROM $table ORDER BY IdProd DESC");
    $statement->execute();
    return $statement->fetchAll();
  }

  //   Ajax que devuelve  los productos a agregar en la lista
  public static function mdlGetProductDataAjx($table, $codProductAdd)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_producto.IdProd, tb_producto.NombreProducto, tb_producto.Unidad FROM $table WHERE IdProd = $codProductAdd");
    $statement->execute();
    return $statement->fetch();
  }
  
  /* funcion de controlador que toma el json de newIngJs */
  public static function mdlCreateIngresoNuevoAjx($table, $dataCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (IdPer, DescripcionIng, DatosProductosIngresoJson, FechaProduccionIng, FechaVencimientoIng, FechaReingresoIng, FechaMermaIng, Estado, DateCreate, DateUpdate) VALUES(:IdPer, :DescripcionIng, :DatosProductosIngresoJson, :FechaProduccionIng, :FechaVencimientoIng, :FechaReingresoIng, :FechaMermaIng, :Estado, :DateCreate, :DateUpdate)");

    $statement->bindParam(":IdPer", $dataCreate["IdPer"], PDO::PARAM_STR);
    $statement->bindParam(":DescripcionIng", $dataCreate["DescripcionIng"], PDO::PARAM_STR);
    $statement->bindParam(":DatosProductosIngresoJson", $dataCreate["DatosProductosIngresoJson"], PDO::PARAM_STR);
    $statement->bindParam(":FechaProduccionIng", $dataCreate["FechaProduccionIng"], PDO::PARAM_STR);
    $statement->bindParam(":FechaVencimientoIng", $dataCreate["FechaVencimientoIng"], PDO::PARAM_STR);
    $statement->bindParam(":FechaReingresoIng", $dataCreate["FechaReingresoIng"], PDO::PARAM_STR);
    $statement->bindParam(":FechaMermaIng", $dataCreate["FechaMermaIng"], PDO::PARAM_STR);
    $statement->bindParam(":Estado", $dataCreate["Estado"], PDO::PARAM_STR);
    $statement->bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataCreate["DateUpdate"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  /* fin */

  // Eliminar nota de pedido
  public static function mdlDeleteIngreso($table, $codIngresoDelet)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $table WHERE IdIng = :IdIng");
    $statement->bindParam(":IdIng", $codIngresoDelet, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener el detalle del ingreso
  public static function mdlGetIngresoList($table, $codIngreso)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_ingreso.DatosProductosIngresoJson FROM $table WHERE tb_ingreso.IdIng = :IdIng");
    $statement->bindParam(":IdIng", $codIngreso, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch();
  }

  //  Obtener datos del ingresos para mostrar en la edición
  public static function mdlGetIngreso($table, $codIngreso)
  {
    $statement = Conexion::conn()->prepare("SELECT
    tb_ingreso.IdPer, 
    tb_personal.NombrePer, 
    tb_personal.ApellidoPer, 
    tb_ingreso.DescripcionIng,
    tb_ingreso.DatosProductosIngresoJson, 
    tb_ingreso.FechaProduccionIng, 
    tb_ingreso.FechaVencimientoIng
  FROM
    $table
    INNER JOIN
    tb_personal
    ON 
      tb_ingreso.IdPer = tb_personal.IdPer
      WHERE tb_ingreso.IdIng = $codIngreso");
    $statement->execute();
    return $statement->fetch();
  }

  //  Editar un ingreso
  public static function mdlEditIngreso($table, $data) {
    $statement = Conexion::conn()->prepare("UPDATE $table SET IdPer=:IdPer, DescripcionIng=:DescripcionIng, FechaProduccionIng=:FechaProduccionIng, FechaVencimientoIng=:FechaVencimientoIng, DateUpdate=:DateUpdate WHERE IdIng=:IdIng");
    $statement->bindParam(":IdPer", $data["IdPer"], PDO::PARAM_STR);
    $statement->bindParam(":DescripcionIng", $data["DescripcionIng"], PDO::PARAM_STR);
    $statement->bindParam(":FechaProduccionIng", $data["FechaProduccionIng"], PDO::PARAM_STR);
    $statement->bindParam(":FechaVencimientoIng", $data["FechaVencimientoIng"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $data["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":IdIng", $data["IdIng"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Editar la lista de un ingreso
  public static function mdlEditIngresoList($table, $data) {
    $statement = Conexion::conn()->prepare("UPDATE $table SET DatosProductosIngresoJson=:DatosProductosIngresoJson WHERE IdIng=:IdIng");
    $statement->bindParam(":DatosProductosIngresoJson", $data["DatosProductosIngresoJson"], PDO::PARAM_STR);
    $statement->bindParam(":IdIng", $data["IdIng"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

    // Verificar un persoanl se esta usando en alguna tabla
  public static function mdlGetHistorialPersonal($table, $codPersonal) {
    $stmt = Conexion::conn()->prepare("SELECT COUNT(IdPer) as IdPer FROM $table WHERE IdPer = :IdPer");
    $stmt->bindParam(":IdPer", $codPersonal, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
  }

}
