<?php
require_once "conexion.php";

class LotesModel
{

  /* mostrar todos los lotes en la tabla */
  public static function mdlGetAllLotes($table)
  {
    $statement = Conexion::conn()->prepare("SELECT
    tb_lote.IdLote, 
		CONCAT(COALESCE(tb_personal.NombrePer, ''), COALESCE(tb_personal.ApellidoPer, '')) AS FullNamePersonal,
    tb_lote.IdPer, 
    tb_cliente.NombreCli, 
    tb_lote.TipoSalida, 
    tb_lote.FechaProduccionLote,
    tb_lote.NroFactura,
    tb_lote.Estado
  FROM
    $table
    INNER JOIN
    tb_cliente
    ON 
      tb_lote.IdCliente = tb_cliente.IdCli
    INNER JOIN
    tb_personal
    ON 
      tb_lote.IdPer = tb_personal.IdPer
    ");

    $statement->execute();
    return $statement->fetchAll();
  }

  // Mostrar los productos a agregar
  public static function mdlGetProductData($table)
  {
    $statement = Conexion::conn()->prepare("SELECT 
    tb_almacen.IdProd,
    tb_producto.NombreProducto,
    tb_producto.Unidad,
    tb_almacen.CantidadTotal
  FROM 
    $table
  INNER JOIN 
    tb_producto ON tb_almacen.IdProd = tb_producto.IdProd
	WHERE
			tb_almacen.CantidadTotal > 0
  ORDER BY 
    GREATEST(CONCAT(tb_almacen.DateCreate, ' ', tb_almacen.HoraCreate), CONCAT(tb_almacen.DateUpdate, ' ', tb_almacen.HoraUpdate)) DESC");
    $statement->execute();
    return $statement->fetchAll();
  }

  //   Ajax que devuelve  los productos a agregar en la lista
  public static function mdlGetProductDataAjx($table, $codProductAdd)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_producto.IdProd, tb_producto.NombreProducto, tb_producto.Unidad FROM	$table WHERE tb_producto.IdProd = $codProductAdd");
    $statement->execute();
    return $statement->fetch();
  }
  /* fin */

  /* funcion de controlador que toma el json de newIngJs */
  public static function mdlCreateIngresoLoteAjx($table, $dataCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $table (IdCliente, IdPer, CodigoLote, NroFactura,TotalFactura, TipoSalida, DatosLoteIngresoJson, FechaProduccionLote, FechaVencimientoLote, Estado, DateCreate, DateUpdate) VALUES(:IdCliente, :IdPer, :CodigoLote, :NroFactura,:TotalFactura, :TipoSalida, :DatosLoteIngresoJson, :FechaProduccionLote, :FechaVencimientoLote, :Estado, :DateCreate, :DateUpdate)");

    $statement->bindParam(":IdCliente", $dataCreate["IdCliente"], PDO::PARAM_INT);
    $statement->bindParam(":IdPer", $dataCreate["IdPer"], PDO::PARAM_INT);
    $statement->bindParam(":CodigoLote", $dataCreate["CodigoLote"], PDO::PARAM_STR);
    $statement->bindParam(":NroFactura", $dataCreate["NroFactura"], PDO::PARAM_STR);
    $statement->bindParam(":TotalFactura", $dataCreate["TotalFactura"], PDO::PARAM_STR);
    $statement->bindParam(":TipoSalida", $dataCreate["TipoSalida"], PDO::PARAM_STR);
    $statement->bindParam(":DatosLoteIngresoJson", $dataCreate["DatosLoteIngresoJson"], PDO::PARAM_STR);
    $statement->bindParam(":FechaProduccionLote", $dataCreate["FechaProduccionLote"], PDO::PARAM_STR);
    $statement->bindParam(":FechaVencimientoLote", $dataCreate["FechaVencimientoLote"], PDO::PARAM_STR);
    $statement->bindParam(":Estado", $dataCreate["Estado"], PDO::PARAM_INT);
    $statement->bindParam(":DateCreate", $dataCreate["DateCreate"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataCreate["DateUpdate"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /* fin */

  /* verifica el stoc actual en el campo  */
  public static function mdlGetListaProductos($table, $idLote)
  {
    $stmt = Conexion::conn()->prepare("SELECT DatosLoteIngresoJson FROM $table WHERE IdLote = :IdLote");
    $stmt->bindParam(":IdLote", $idLote, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
  }
  /* fin */

  /* funcion de ediutar  el lote */
  public static function mdlEditSalidaFactura($table, $dataEditUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET IdPer = :IdPer, IdCliente = :IdCliente, NroFactura = :NroFactura, TotalFactura = :TotalFactura, FechaProduccionLote = :FechaProduccionLote, DateUpdate = :DateUpdate WHERE IdLote = :IdLote");

    $statement->bindParam(":IdLote", $dataEditUpdate["IdLote"], PDO::PARAM_INT);
    $statement->bindParam(":IdPer", $dataEditUpdate["IdPer"], PDO::PARAM_INT);
    $statement->bindParam(":IdCliente", $dataEditUpdate["IdCliente"], PDO::PARAM_STR);
    $statement->bindParam(":NroFactura", $dataEditUpdate["NroFactura"], PDO::PARAM_STR);
    $statement->bindParam(":TotalFactura", $dataEditUpdate["TotalFactura"], PDO::PARAM_STR);
    $statement->bindParam(":FechaProduccionLote", $dataEditUpdate["FechaProduccionLote"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataEditUpdate["DateUpdate"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Editar la salida de una factura
  public static function mdlEditSalidaLote($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET IdPer = :IdPer, IdCliente = :IdCliente, NroFactura = :NroFactura, TotalFactura = :TotalFactura, CodigoLote = :CodigoLote, FechaProduccionLote = :FechaProduccionLote, DateUpdate = :DateUpdate WHERE IdLote = :IdLote");

    $statement->bindParam(":IdLote", $dataUpdate["IdLote"], PDO::PARAM_INT);
    $statement->bindParam(":IdPer", $dataUpdate["IdPer"], PDO::PARAM_INT);
    $statement->bindParam(":IdCliente", $dataUpdate["IdCliente"], PDO::PARAM_STR);
    $statement->bindParam(":NroFactura", $dataUpdate["NroFactura"], PDO::PARAM_STR);
    $statement->bindParam(":TotalFactura", $dataUpdate["TotalFactura"], PDO::PARAM_STR);
    $statement->bindParam(":CodigoLote", $dataUpdate["CodigoLote"], PDO::PARAM_STR);
    $statement->bindParam(":FechaProduccionLote", $dataUpdate["FechaProduccionLote"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  // Actualizar el lote en su totalidad
  public static function mdlEditSalidaFacturaCompleto($table, $dataEditUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET IdPer = :IdPer, IdCliente = :IdCliente, NroFactura = :NroFactura, TotalFactura = :TotalFactura, FechaProduccionLote = :FechaProduccionLote, DatosLoteIngresoJson=:DatosLoteIngresoJson, DateUpdate = :DateUpdate WHERE IdLote = :IdLote");

    $statement->bindParam(":IdLote", $dataEditUpdate["IdLote"], PDO::PARAM_INT);
    $statement->bindParam(":IdPer", $dataEditUpdate["IdPer"], PDO::PARAM_INT);
    $statement->bindParam(":IdCliente", $dataEditUpdate["IdCliente"], PDO::PARAM_STR);
    $statement->bindParam(":NroFactura", $dataEditUpdate["NroFactura"], PDO::PARAM_STR);
    $statement->bindParam(":TotalFactura", $dataEditUpdate["TotalFactura"], PDO::PARAM_STR);
    $statement->bindParam(":FechaProduccionLote", $dataEditUpdate["FechaProduccionLote"], PDO::PARAM_STR);
    $statement->bindParam(":DatosLoteIngresoJson", $dataEditUpdate["DatosLoteIngresoJson"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataEditUpdate["DateUpdate"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }


  // Actualizar el lote en su totalidad
  public static function mdlEditSalidaLoteCompleto($table, $dataEditUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET IdPer = :IdPer, IdCliente = :IdCliente, NroFactura = :NroFactura, TotalFactura = :TotalFactura, CodigoLote=:CodigoLote, FechaProduccionLote = :FechaProduccionLote, DatosLoteIngresoJson=:DatosLoteIngresoJson, DateUpdate = :DateUpdate WHERE IdLote = :IdLote");

    $statement->bindParam(":IdLote", $dataEditUpdate["IdLote"], PDO::PARAM_INT);
    $statement->bindParam(":IdPer", $dataEditUpdate["IdPer"], PDO::PARAM_INT);
    $statement->bindParam(":IdCliente", $dataEditUpdate["IdCliente"], PDO::PARAM_STR);
    $statement->bindParam(":NroFactura", $dataEditUpdate["NroFactura"], PDO::PARAM_STR);
    $statement->bindParam(":TotalFactura", $dataEditUpdate["TotalFactura"], PDO::PARAM_STR);
    $statement->bindParam(":CodigoLote", $dataEditUpdate["CodigoLote"], PDO::PARAM_STR);
    $statement->bindParam(":FechaProduccionLote", $dataEditUpdate["FechaProduccionLote"], PDO::PARAM_STR);
    $statement->bindParam(":DatosLoteIngresoJson", $dataEditUpdate["DatosLoteIngresoJson"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataEditUpdate["DateUpdate"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /* fin */

  //  Obtener la información del lote para la vista de editar
  public static function mdlGetEditLoteData($table, $codLoteEdit)
  {
    $statement = Conexion::conn()->prepare("SELECT
    CONCAT(COALESCE(tb_personal.NombrePer, ''), COALESCE(tb_personal.ApellidoPer, '')) AS FullNamePersonal, 
    tb_lote.IdPer, 
    tb_cliente.NombreCli, 
    tb_cliente.RucCli, 
    tb_cliente.DireccionCli, 
    tb_lote.IdCliente, 
    tb_lote.FechaProduccionLote, 
    tb_lote.FechaVencimientoLote, 
    tb_lote.CodigoLote, 
    tb_lote.DatosLoteIngresoJson, 
    tb_lote.Estado,
    tb_lote.NroFactura,
    tb_lote.TotalFactura,
    tb_lote.Observacion,
    tb_lote.TipoSalida
  FROM
    $table
    INNER JOIN
    tb_personal
    ON 
      tb_lote.IdPer = tb_personal.IdPer
    INNER JOIN
    tb_cliente
    ON 
      tb_lote.IdCliente = tb_cliente.IdCli
    WHERE tb_lote.IdLote = :codLoteEdit");
    $statement->bindParam(":codLoteEdit", $codLoteEdit, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /* fin */
  // Eliminar lote
  public static function mdlDeleteLote($table, $codLoteDelet)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $table WHERE IdLote = :IdLote");
    $statement->bindParam(":IdLote", $codLoteDelet, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  /* fin */

  /*  Descargar todos los Lotes para el reporte exel de Lotes */
  public static function mdlGetAllDowlReportsExeLote($table)
  {
    $statement = Conexion::conn()->prepare("
        SELECT
          tb_lote.IdLote, 
          tb_personal.NombrePer, 
          tb_personal.ApellidoPer, 
          tb_lote.IdPer, 
          tb_cliente.NombreCli,
          tb_cliente.RucCli,
          tb_cliente.DireccionCli, 
          tb_lote.CodigoLote, 
          tb_lote.DescripcionLote, 
          tb_lote.DatosLoteIngresoJson, 
          tb_lote.FechaProduccionLote,
          tb_lote.TipoSalida,
          tb_lote.NroFactura,
          tb_lote.TotalFactura,
          CASE tb_lote.Estado
            WHEN 1 THEN 'Retirado'
            WHEN 2 THEN 'Entregado'
            WHEN 3 THEN 'Cancelado'
            WHEN 4 THEN 'Devolución'
            WHEN 5 THEN 'Anulado'
            ELSE 'Estado desconocido'
          END AS Estado
        FROM
          tb_lote
          INNER JOIN
          tb_cliente
          ON 
            tb_lote.IdCliente = tb_cliente.IdCli
          INNER JOIN
          tb_personal
          ON 
            tb_lote.IdPer = tb_personal.IdPer ");
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as &$result) {
      // Procesar el campo JSON
      if (isset($result['DatosLoteIngresoJson'])) {
        $productsJson = json_decode($result['DatosLoteIngresoJson'], true);

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

        $result['DatosLoteIngresoJson'] = json_encode($productsJson);
      }
    }

    return $results;
  }

  /* Reporte excel Lotes por fechas  */
  public static function mdlGetAllDowlReportsExeLoteFech($table, $fechaInicioLt, $fechaFinLt)
  {
    $statement = Conexion::conn()->prepare("
          SELECT
            tb_lote.IdLote, 
            tb_personal.NombrePer, 
            tb_personal.ApellidoPer, 
            tb_lote.IdPer, 
            tb_cliente.NombreCli,
            tb_cliente.RucCli,
            tb_cliente.DireccionCli, 
            tb_lote.CodigoLote, 
            tb_lote.DescripcionLote, 
            tb_lote.DatosLoteIngresoJson, 
            tb_lote.FechaProduccionLote,
            tb_lote.TipoSalida,
            tb_lote.NroFactura,
            tb_lote.TotalFactura,
            CASE tb_lote.Estado
            WHEN 1 THEN 'Retirado'
            WHEN 2 THEN 'Entregado'
            WHEN 3 THEN 'Cancelado'
            WHEN 4 THEN 'Devolución'
            WHEN 5 THEN 'Anulado'
              ELSE 'Estado desconocido'
            END AS Estado
          FROM
            tb_lote
            INNER JOIN
            tb_cliente
            ON tb_lote.IdCliente = tb_cliente.IdCli
            INNER JOIN
            tb_personal
            ON tb_lote.IdPer = tb_personal.IdPer
            WHERE FechaProduccionLote BETWEEN :fechaInicioLt AND :fechaFinLt ");

    $statement->bindParam(":fechaInicioLt", $fechaInicioLt, PDO::PARAM_STR);
    $statement->bindParam(":fechaFinLt", $fechaFinLt, PDO::PARAM_STR);

    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as &$result) {
      // Procesar el campo JSON
      if (isset($result['DatosLoteIngresoJson'])) {
        $productsJson = json_decode($result['DatosLoteIngresoJson'], true);

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

        $result['DatosLoteIngresoJson'] = json_encode($productsJson);
      }
    }

    return $results;
  }
  //  Obtener la data de un lote
  public static function mdlGetDataLote($table, $codLote)
  {
    $statement = Conexion::conn()->prepare("SELECT
    CONCAT(tb_personal.NombrePer,tb_personal.ApellidoPer) AS FullNamePersonal, 
    tb_cliente.NombreCli, 
    tb_lote.NroFactura, 
    tb_lote.TipoSalida,
    tb_lote.TotalFactura,
    tb_lote.Observacion, 
    tb_lote.FechaProduccionLote,  
    tb_lote.DatosLoteIngresoJson, 
    tb_cliente.RucCli
  FROM
    $table
    INNER JOIN
    tb_cliente
    ON 
      tb_lote.IdCliente = tb_cliente.IdCli
    INNER JOIN
    tb_personal
    ON 
      tb_lote.IdPer = tb_personal.IdPer
  WHERE
    tb_lote.IdLote = $codLote");
    $statement->execute();
    return $statement->fetch();
  }

  //  Obtener el estado del lote
  public static function mdlGetEstadoLote($table, $codLote)
  {
    $statement = Conexion::conn()->prepare("SELECT Estado FROM $table WHERE IdLote = :IdLote");
    $statement->bindParam(":IdLote", $codLote, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch();
  }

  //  Actualizar el estado del lote
  public static function mdlUpdateLoteEstado($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET Estado=:Estado, DateUpdate=:DateUpdate, Observacion=:Observacion WHERE IdLote=:IdLote");
    $statement->bindParam(":Estado", $dataUpdate["Estado"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":Observacion", $dataUpdate["Observacion"], PDO::PARAM_STR);
    $statement->bindParam(":IdLote", $dataUpdate["IdLote"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  public static function mdlUpdateLoteDevolucion($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET Estado=:Estado, DateUpdate=:DateUpdate, FechaDevolucion=:FechaDevolucion WHERE IdLote=:IdLote");
    $statement->bindParam(":Estado", $dataUpdate["Estado"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":FechaDevolucion", $dataUpdate["FechaDevolucion"], PDO::PARAM_STR);
    $statement->bindParam(":IdLote", $dataUpdate["IdLote"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  public static function mdlNullLote($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET Estado=:Estado, DateUpdate=:DateUpdate WHERE IdLote=:IdLote");
    $statement->bindParam(":Estado", $dataUpdate["Estado"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":IdLote", $dataUpdate["IdLote"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener el tipo de salida
  public static function mdlGetTipoSalida($table, $codLote)
  {
    $statement = Conexion::conn()->prepare("SELECT TipoSalida FROM $table WHERE IdLote = :IdLote");
    $statement->bindParam(":IdLote", $codLote, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch();
  }
}
