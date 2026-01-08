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

  // Mostrar los productos a agregar
  public static function mdlGetProductData($table)
  {
    $statement = Conexion::conn()->prepare("SELECT 
    tb_producto.IdProd, 
    tb_producto.NombreProducto, 
    tb_producto.Unidad,
    tb_categoriaprod.IdCate,
    tb_categoriaprod.NombreCategoria
  FROM 
  $table 
  INNER JOIN 
    tb_categoriaprod ON tb_producto.IdCate = tb_categoriaprod.IdCate
  ORDER BY 
    tb_producto.IdProd DESC");
    $statement->execute();
    return $statement->fetchAll();
  }

  //   Ajax que devuelve  los productos a agregar en la lista
  public static function mdlGetProductDataAjx($table, $codProductAdd)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_producto.IdProd, tb_producto.NombreProducto, tb_producto.Precio, tb_producto.Unidad FROM $table WHERE IdProd = $codProductAdd");
    $statement->execute();
    return $statement->fetch();
  }

  /* funcion de controlador que toma el json de newIngJs */
  public static function mdlCreateIngresoNuevoAjx($table, $dataCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (IdPer, DescripcionIng, DatosProductosIngresoJson, FechaProduccionIng, FechaVencimientoIng, Estado, TipoIngreso, DateCreate, DateUpdate) VALUES(:IdPer, :DescripcionIng, :DatosProductosIngresoJson, :FechaProduccionIng, :FechaVencimientoIng, :Estado, :TipoIngreso, :DateCreate, :DateUpdate)");

    $statement->bindParam(":IdPer", $dataCreate["IdPer"], PDO::PARAM_STR);
    $statement->bindParam(":DescripcionIng", $dataCreate["DescripcionIng"], PDO::PARAM_STR);
    $statement->bindParam(":DatosProductosIngresoJson", $dataCreate["DatosProductosIngresoJson"], PDO::PARAM_STR);
    $statement->bindParam(":FechaProduccionIng", $dataCreate["FechaProduccionIng"], PDO::PARAM_STR);
    $statement->bindParam(":FechaVencimientoIng", $dataCreate["FechaVencimientoIng"], PDO::PARAM_STR);
    $statement->bindParam(":Estado", $dataCreate["Estado"], PDO::PARAM_STR);
    $statement->bindParam(":TipoIngreso", $dataCreate["TipoIngreso"], PDO::PARAM_STR);
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
    tb_ingreso.FechaVencimientoIng,
    tb_ingreso.TipoIngreso
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
  public static function mdlEditIngreso($table, $data)
  {
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
  public static function mdlEditIngresoList($table, $data)
  {
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
  public static function mdlGetHistorialPersonal($table, $codPersonal)
  {
    $stmt = Conexion::conn()->prepare("SELECT COUNT(IdPer) as IdPer FROM $table WHERE IdPer = :IdPer");
    $stmt->bindParam(":IdPer", $codPersonal, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
  }

  /* Devolver todos los ingreso para el reporte exel */
  public static function mdlGetAllDowlReportsExeIng($table)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_ingreso.IdIng, tb_ingreso.DatosProductosIngresoJson, tb_ingreso.DescripcionIng, tb_ingreso.FechaProduccionIng, CONCAT(tb_personal.NombrePer,tb_personal.ApellidoPer) AS FullNamePersonal, tb_estado.TipoEstado FROM tb_ingreso INNER JOIN tb_personal ON tb_ingreso.IdPer = tb_personal.IdPer INNER JOIN tb_estado ON tb_ingreso.Estado = tb_estado.IdEstado");

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


  /* Devolver todos los ingreso para el reporte exel pro fechas*/
  public static function mdlGetAllDowlReportsExeIngFech($table, $fechaInicio, $fechaFin)
  {
    $statement = Conexion::conn()->prepare("
      SELECT ing.*, 
        per.NombrePer AS NombrePerIdPer, 
        e.TipoEstado
      FROM $table AS ing
      INNER JOIN tb_personal AS per ON ing.IdPer = per.IdPer
      INNER JOIN tb_estado AS e ON ing.Estado = e.IdEstado
      WHERE ing.FechaProduccionIng BETWEEN :fechaInicio AND :fechaFin
      ORDER BY 
      IdIng DESC");

    $statement->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
    $statement->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);

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

  //  Crear un ingreso por devolución de una nota de pedido
  public static function mdlCrearIngresoDevolucionNota($table, $dataCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (IdPer, DatosRefSalida, DescripcionIng, DatosProductosIngresoJson, FechaProduccionIng, Estado, TipoIngreso, DateCreate, DateUpdate) VALUES(:IdPer, :DatosRefSalida, :DescripcionIng, :DatosProductosIngresoJson, :FechaProduccionIng, :Estado, :TipoIngreso, :DateCreate, :DateUpdate)");

    $statement->bindParam(":IdPer", $dataCreate["IdPer"], PDO::PARAM_STR);
    $statement->bindParam(":DatosRefSalida", $dataCreate["DatosRefSalida"], PDO::PARAM_STR);
    $statement->bindParam(":DescripcionIng", $dataCreate["DescripcionIng"], PDO::PARAM_STR);
    $statement->bindParam(":DatosProductosIngresoJson", $dataCreate["DatosProductosIngresoJson"], PDO::PARAM_STR);
    $statement->bindParam(":FechaProduccionIng", $dataCreate["FechaProduccionIng"], PDO::PARAM_STR);
    $statement->bindParam(":Estado", $dataCreate["Estado"], PDO::PARAM_STR);
    $statement->bindParam(":TipoIngreso", $dataCreate["TipoIngreso"], PDO::PARAM_STR);
    $statement->bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataCreate["DateUpdate"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener el ultimo ingreso creado
  public static function mdlGetLastIngreso($table)
  {
    $statement = Conexion::conn()->prepare("SELECT MAX(tb_ingreso.IdIng) AS IdIng FROM $table ");
    $statement->execute();
    return $statement->fetch();
  }
}
