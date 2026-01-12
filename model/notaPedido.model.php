<?php
require_once "conexion.php";

class NotaPedidoModel
{
  // Obtener todos los REGISTROS de Nota de pedido
  public static function mdlGetAllSalidasNotaPe($table)
  {
    $statement = Conexion::conn()->prepare("SELECT np.DatosProductosNotaPedidoJson, np.IdPer, np.IdRes, np.IdNotaP, np.FechaNotaPedido, np.Total, np.EstadoNota,
    per.NombrePer AS NombrePerIdPer, 
    per2.NombrePer AS NombrePerIdRes, 
      cli.NombreCli AS NombreCliNota, 
    cli.RucCli, 
    cli.DireccionCli AS DireccionCliNota
  FROM $table AS np
  INNER JOIN tb_personal AS per ON np.IdPer = per.IdPer
  INNER JOIN tb_personal AS per2 ON np.IdRes = per2.IdPer
  INNER JOIN tb_cliente AS cli ON np.IdCliente = cli.IdCli
  ORDER BY 
  IdNotaP DESC");

    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as &$result) {
      // Procesar el campo JSON
      if (isset($result['DatosProductosNotaPedidoJson'])) {
        $productsJson = json_decode($result['DatosProductosNotaPedidoJson'], true);

        foreach ($productsJson as &$product) {
          $statement = Conexion::conn()->prepare("
          SELECT NombreProducto
          FROM tb_producto
          WHERE IdProd = :codProduct
        ");

          $statement->bindParam(":codProduct", $product['codProduct'], PDO::PARAM_INT);

          $statement->execute();

          $productResult = $statement->fetch(PDO::FETCH_ASSOC);

          // Verificar que $productResult no es false antes de intentar acceder a su índice 'NombreProducto'
          if ($productResult !== false) {
            $product['NombreProducto'] = $productResult['NombreProducto'];
          } else {
            $product['NombreProducto'] = "";
          }
        }

        $result['DatosProductosNotaPedidoJson'] = json_encode($productsJson);
      }
    }

    return $results;
  }

  // NUEVO: Método optimizado con paginación server-side para DataTables
  public static function mdlGetNotasPaginadas($start, $length, $search, $orderColumn, $orderDir)
  {
    $conn = Conexion::conn();

    // Mapeo de columnas para ordenamiento seguro
    $columns = ['np.IdNotaP', 'per.NombrePer', 'cli.NombreCli', 'per2.NombrePer', 'np.EstadoNota', 'np.FechaNotaPedido'];
    $orderBy = isset($columns[$orderColumn]) ? $columns[$orderColumn] : 'np.IdNotaP';
    $orderDir = strtoupper($orderDir) === 'ASC' ? 'ASC' : 'DESC';

    // Query base con JOINs
    $baseQuery = "FROM tb_notapedido AS np
        INNER JOIN tb_personal AS per ON np.IdPer = per.IdPer
        INNER JOIN tb_personal AS per2 ON np.IdRes = per2.IdPer
        INNER JOIN tb_cliente AS cli ON np.IdCliente = cli.IdCli";

    // Condición de búsqueda
    $searchCondition = "";
    $searchParam = "";
    if (!empty($search)) {
      $searchParam = "%$search%";
      $searchCondition = " WHERE (
          per.NombrePer LIKE :search1 OR 
          cli.NombreCli LIKE :search2 OR 
          per2.NombrePer LIKE :search3 OR
          np.FechaNotaPedido LIKE :search4 OR
          np.IdNotaP LIKE :search5
      )";
    }

    // 1. Contar total de registros (sin filtro)
    $stmtTotal = $conn->prepare("SELECT COUNT(*) as total FROM tb_notapedido");
    $stmtTotal->execute();
    $totalRecords = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

    // 2. Contar registros filtrados
    $sqlFiltered = "SELECT COUNT(*) as total $baseQuery $searchCondition";
    $stmtFiltered = $conn->prepare($sqlFiltered);
    if (!empty($search)) {
      $stmtFiltered->bindParam(':search1', $searchParam, PDO::PARAM_STR);
      $stmtFiltered->bindParam(':search2', $searchParam, PDO::PARAM_STR);
      $stmtFiltered->bindParam(':search3', $searchParam, PDO::PARAM_STR);
      $stmtFiltered->bindParam(':search4', $searchParam, PDO::PARAM_STR);
      $stmtFiltered->bindParam(':search5', $searchParam, PDO::PARAM_STR);
    }
    $stmtFiltered->execute();
    $filteredRecords = $stmtFiltered->fetch(PDO::FETCH_ASSOC)['total'];

    // 3. Query principal con LIMIT para paginación
    $sql = "SELECT np.IdNotaP, np.EstadoNota, np.FechaNotaPedido, np.Total,
                   np.DatosProductosNotaPedidoJson,
                   per.NombrePer AS NombrePerIdPer,
                   per2.NombrePer AS NombrePerIdRes,
                   cli.NombreCli AS NombreCliNota,
                   cli.RucCli,
                   cli.DireccionCli AS DireccionCliNota
            $baseQuery
            $searchCondition
            ORDER BY $orderBy $orderDir
            LIMIT :start, :length";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
    $stmt->bindValue(':length', (int) $length, PDO::PARAM_INT);
    if (!empty($search)) {
      $stmt->bindParam(':search1', $searchParam, PDO::PARAM_STR);
      $stmt->bindParam(':search2', $searchParam, PDO::PARAM_STR);
      $stmt->bindParam(':search3', $searchParam, PDO::PARAM_STR);
      $stmt->bindParam(':search4', $searchParam, PDO::PARAM_STR);
      $stmt->bindParam(':search5', $searchParam, PDO::PARAM_STR);
    }
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4. Procesar JSON de productos - OPTIMIZADO con batch query
    $productIds = [];
    foreach ($data as $row) {
      if (!empty($row['DatosProductosNotaPedidoJson'])) {
        $products = json_decode($row['DatosProductosNotaPedidoJson'], true);
        if (is_array($products)) {
          foreach ($products as $product) {
            if (isset($product['codProduct'])) {
              $productIds[] = (int) $product['codProduct'];
            }
          }
        }
      }
    }

    // Obtener nombres de productos en una sola consulta
    $productNames = [];
    if (!empty($productIds)) {
      $uniqueIds = array_values(array_unique($productIds));
      $placeholders = implode(',', array_fill(0, count($uniqueIds), '?'));
      $stmtProducts = $conn->prepare("SELECT IdProd, NombreProducto FROM tb_producto WHERE IdProd IN ($placeholders)");
      $stmtProducts->execute($uniqueIds);
      $productResults = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);
      foreach ($productResults as $prod) {
        $productNames[$prod['IdProd']] = $prod['NombreProducto'];
      }
    }

    // Agregar nombres a los productos en el JSON
    foreach ($data as &$row) {
      if (!empty($row['DatosProductosNotaPedidoJson'])) {
        $products = json_decode($row['DatosProductosNotaPedidoJson'], true);
        if (is_array($products)) {
          foreach ($products as &$product) {
            $codProduct = isset($product['codProduct']) ? (int) $product['codProduct'] : 0;
            $product['NombreProducto'] = isset($productNames[$codProduct]) ? $productNames[$codProduct] : '';
          }
          $row['DatosProductosNotaPedidoJson'] = json_encode($products);
        }
      }
    }

    return [
      'data' => $data,
      'recordsTotal' => (int) $totalRecords,
      'recordsFiltered' => (int) $filteredRecords
    ];
  }

  // Crear Nota de pedido
  public static function mdlCreateNotaPedido($table, $data)
  {
    // Prepara la consulta SQL
    $stmt = Conexion::conn()->prepare("INSERT INTO $table (IdPer, IdRes, IdCliente, EstadoNota, DatosProductosNotaPedidoJson, Total, FechaNotaPedido, DateCreate, DateUpdate) VALUES (:IdPer, :IdRes, :IdCliente, :EstadoNota, :DatosProductosNotaPedidoJson, :Total, :FechaNotaPedido, :DateCreate, :DateUpdate)");

    // Vincula los parámetros
    $stmt->bindParam(":IdPer", $data["IdPer"], PDO::PARAM_STR);
    $stmt->bindParam(":IdRes", $data["IdRes"], PDO::PARAM_STR);
    $stmt->bindParam(":IdCliente", $data["IdCliente"], PDO::PARAM_STR);
    $stmt->bindParam(":EstadoNota", $data["EstadoNota"], PDO::PARAM_STR);
    $stmt->bindParam(":DatosProductosNotaPedidoJson", $data["DatosProductosNotaPedidoJson"], PDO::PARAM_STR);
    $stmt->bindParam(":Total", $data["Total"], PDO::PARAM_STR);
    $stmt->bindParam(":FechaNotaPedido", $data["FechaNotaPedido"], PDO::PARAM_STR);
    $stmt->bindParam(":DateCreate", $data["DateCreate"], PDO::PARAM_STR);
    $stmt->bindParam(":DateUpdate", $data["DateUpdate"], PDO::PARAM_STR);

    // Ejecuta la consulta
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }


  // Obtener al Cliente para la nota pedido
  public static function mdlGetNotaPeCli($table)
  {
    $statement = Conexion::conn()->prepare("SELECT 
        IdCli,
        RucCli,
        NombreCli,
        CorreoCli,
        DireccionCli,
        TelefonoCli,
        CASE Estado
            WHEN 3 THEN 'Activo'
            WHEN 4 THEN 'Inactivo'
            ELSE 'Otro'
        END AS Estado,
        DateCreate,
        DateUpdate
        FROM 
        $table
        WHERE 
        Estado = 3
        ORDER BY 
        IdCli DESC");
    $statement->execute();
    return $statement->fetchAll();
  }

  // Obtener al vendedor
  public static function mdlGetPersonVen($table)
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
        WHERE 
     tb_personal.IdTipoPer = 3 AND tb_personal.Estado = 3
        ORDER BY 
        IdPer DESC");
    $statement->execute();
    return $statement->fetchAll();
  }

  // Mostrar los productos a agregar nota de pedido
  public static function mdlGetProductData($table)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_almacen.IdProd, tb_producto.NombreProducto, tb_producto.Unidad, tb_almacen.CantidadTotal FROM $table INNER JOIN tb_producto ON tb_almacen.IdProd = tb_producto.IdProd WHERE	tb_almacen.CantidadTotal > 0");
    $statement->execute();
    return $statement->fetchAll();
  }


  //   Ajax que devuelve  los productos a nota pedido
  public static function mdlGetProductDataAjx($table, $codProductAdd)
  {
    $statement = Conexion::conn()->prepare("SELECT
        tb_almacen.IdProd, 
        tb_almacen.CantidadTotal, 
        tb_producto.NombreProducto, 
        tb_producto.Precio
      FROM
        $table
        INNER JOIN
        tb_producto
        ON 
          tb_almacen.IdProd = tb_producto.IdProd
          WHERE
          tb_producto.IdProd = $codProductAdd");
    $statement->execute();
    return $statement->fetch();
  }


  /* mostrar detalles complentarios de nota de pedido por el boton */
  public static function mdlGetDetallNotPeData($table, $codDetNotPeData)
  {
    $statement = Conexion::conn()->prepare("SELECT np.*, 
           l.CodigoLote, 
           per.NombrePer AS NombrePerIdPer, 
           per2.NombrePer AS NombrePerIdRes, 
    np.NotaPorFA, 
           cli.NombreCli AS NombreCliNota, 
           cli.RucCli, 
           cli.DireccionCli AS DireccionCliNota, 
           e.TipoEstado
      FROM $table AS np
      LEFT JOIN tb_lote AS l ON np.IdLote = l.IdLote
      INNER JOIN tb_personal AS per ON np.IdPer = per.IdPer
      INNER JOIN tb_personal AS per2 ON np.IdRes = per2.IdPer
      INNER JOIN tb_cliente AS cli ON np.IdCliente = cli.IdCli
      INNER JOIN tb_estado AS e ON np.Estado = e.IdEstado
      WHERE np.IdNotaP = :codDetNotPeData");

    $statement->bindParam(":codDetNotPeData", $codDetNotPeData, PDO::PARAM_INT);

    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // Procesar el campo JSON
    $productsJson = json_decode($result['DatosProductosNotaPedidoJson'], true);

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

    $result['DatosProductosNotaPedidoJson'] = json_encode($productsJson);

    return $result;
  }

  /* fin */


  /* funcion Editar para mostrar detalles de nota de pedido por el boton  */
  public static function mdlGetEditNotPeData($table, $codEditNotPeData)
  {
    $statement = Conexion::conn()->prepare("SELECT * FROM $table WHERE IdNotaP = :codEditNotPeData");
    $statement->bindParam(":codEditNotPeData", $codEditNotPeData, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /* fin */

  // Eliminar nota de pedido
  public static function mdlDeleteNotaPedido($table, $codNotaPe)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $table WHERE IdNotaP = :IdNotaP");
    $statement->bindParam(":IdNotaP", $codNotaPe, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  /* fin */

  // Obtener datos de la nota de pedido para editar -> CORREGIR
  public static function mdlGetNotaPeById($table, $codNotaPedido)
  {
    $statement = Conexion::conn()->prepare("SELECT
    tb_notapedido.IdPer, 
    tb_notapedido.IdRes, 
    tb_notapedido.IdCliente, 
    tb_notapedido.EstadoNota, 
    tb_notapedido.Total,
    tb_notapedido.Observacion, 
    tb_notapedido.FechaNotaPedido, 
    tb_notapedido.DatosProductosNotaPedidoJson, 
    tb_cliente.NombreCli, 
    tb_cliente.RucCli, 
    tb_cliente.DireccionCli, 
    vendedor.NombrePer AS NombreVendedor, 
		vendedor.ApellidoPer AS ApellidoVendedor,
    responsable.NombrePer AS NombreResponsable, 
		responsable.ApellidoPer AS ApellidoResponsable
    FROM
        $table
        INNER JOIN
        tb_cliente
        ON 
            tb_notapedido.IdCliente = tb_cliente.IdCli
        INNER JOIN
        tb_personal AS vendedor
        ON 
            tb_notapedido.IdPer = vendedor.IdPer
        INNER JOIN
        tb_personal AS responsable
        ON 
            tb_notapedido.IdRes = responsable.IdPer
    WHERE tb_notapedido.IdNotaP = $codNotaPedido");
    $statement->execute();
    return $statement->fetch();
  }

  //  Obtener lista de la nota de pedido antigua
  public static function mdlGetListaProductos($table, $codNotaPedido)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_notapedido.DatosProductosNotaPedidoJson FROM $table WHERE tb_notapedido.IdNotaP = $codNotaPedido");
    $statement->execute();
    return $statement->fetch();
  }

  //  Editar datos generales de la nota de pedido
  public static function mdlEditarNotaPedido($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET IdPer=:IdPer, IdRes=:IdRes, IdCliente=:IdCliente, FechaNotaPedido=:FechaNotaPedido, DateUpdate=:DateUpdate WHERE IdNotaP=:IdNotaP");
    $statement->bindParam(":IdPer", $dataUpdate["IdPer"], PDO::PARAM_STR);
    $statement->bindParam(":IdRes", $dataUpdate["IdRes"], PDO::PARAM_STR);
    $statement->bindParam(":IdCliente", $dataUpdate["IdCliente"], PDO::PARAM_STR);
    $statement->bindParam(":FechaNotaPedido", $dataUpdate["FechaNotaPedido"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":IdNotaP", $dataUpdate["IdNotaP"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Editar la nota de pedido completa
  public static function mdlEditarNotaPedidoCompleta($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET IdPer=:IdPer, IdRes=:IdRes, IdCliente=:IdCliente, DatosProductosNotaPedidoJson=:DatosProductosNotaPedidoJson, Total=:Total, FechaNotaPedido=:FechaNotaPedido, DateUpdate=:DateUpdate WHERE IdNotaP=:IdNotaP");
    $statement->bindParam(":IdPer", $dataUpdate["IdPer"], PDO::PARAM_STR);
    $statement->bindParam(":IdRes", $dataUpdate["IdRes"], PDO::PARAM_STR);
    $statement->bindParam(":IdCliente", $dataUpdate["IdCliente"], PDO::PARAM_STR);
    $statement->bindParam(":DatosProductosNotaPedidoJson", $dataUpdate["DatosProductosNotaPedidoJson"], PDO::PARAM_STR);
    $statement->bindParam(":Total", $dataUpdate["Total"], PDO::PARAM_STR);
    $statement->bindParam(":FechaNotaPedido", $dataUpdate["FechaNotaPedido"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":IdNotaP", $dataUpdate["IdNotaP"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener el estado de la nota de pedido
  public static function mdlGetEstadoNotaPedido($table, $codNotaPedido)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_notapedido.EstadoNota FROM $table WHERE tb_notapedido.IdNotaP = $codNotaPedido");
    $statement->execute();
    return $statement->fetch();
  }

  // Verificar un Cliente si se esta usando en nota pedido
  public static function mdlGetHistorialCliente($table, $codClient)
  {
    $stmt = Conexion::conn()->prepare("SELECT COUNT(IdCliente) as IdCliente FROM $table WHERE IdCliente = :IdCliente");
    $stmt->bindParam(":IdCliente", $codClient, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
  }

  // Verificar un vendedor si se esta usando en nota pedido
  public static function mdlGetHistorialPerVend($table, $codPersonal)
  {
    $stmt = Conexion::conn()->prepare("SELECT COUNT(IdRes) as IdRes FROM $table WHERE IdRes = :IdRes");
    $stmt->bindParam(":IdRes", $codPersonal, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
  }

  // Verificar un responsable si se esta usando en nota pedido
  public static function mdlGetHistorialPerRes($table, $codPersonal)
  {
    $stmt = Conexion::conn()->prepare("SELECT COUNT(IdPer) as IdPer FROM $table WHERE IdPer = :IdPer");
    $stmt->bindParam(":IdPer", $codPersonal, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
  }

  /* Devolver todas las Notas pedido para el reporte excel - OPTIMIZADO CON FILTRO DE AÑO */
  public static function mdlGetAllDowlReportsExeNotPe($table, $anio = null)
  {
    // PASO 1: Obtener todas las notas de pedido (con filtro de año opcional)
    $whereClause = "";
    if ($anio !== null && $anio !== 'todos') {
      $whereClause = "WHERE YEAR(np.FechaNotaPedido) = :anio";
    }

    $statement = Conexion::conn()->prepare("SELECT 
        np.DatosProductosNotaPedidoJson, 
        np.IdPer, 
        np.IdRes, 
        np.IdNotaP, 
        np.FechaNotaPedido, 
        np.Total,
        CASE np.EstadoNota
            WHEN 1 THEN 'Retirado'
            WHEN 2 THEN 'Entregado'
            WHEN 3 THEN 'Cancelado'
            WHEN 4 THEN 'Devolución'
            WHEN 5 THEN 'Anulado'
            ELSE 'Estado desconocido'
        END AS EstadoNota,
        per.NombrePer AS NombrePerIdPer, 
        per2.NombrePer AS NombrePerIdRes, 
        cli.NombreCli AS NombreCliNota, 
        cli.RucCli, 
        cli.DireccionCli AS DireccionCliNota
    FROM $table AS np
    INNER JOIN tb_personal AS per ON np.IdPer = per.IdPer
    INNER JOIN tb_personal AS per2 ON np.IdRes = per2.IdPer
    INNER JOIN tb_cliente AS cli ON np.IdCliente = cli.IdCli
    $whereClause
    ORDER BY IdNotaP DESC");

    if ($anio !== null && $anio !== 'todos') {
      $statement->bindParam(":anio", $anio, PDO::PARAM_INT);
    }

    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    // PASO 2: Obtener TODOS los IDs de productos únicos de todos los JSONs
    $productIds = [];
    foreach ($results as $result) {
      if (isset($result['DatosProductosNotaPedidoJson'])) {
        $productsJson = json_decode($result['DatosProductosNotaPedidoJson'], true);
        if (is_array($productsJson)) {
          foreach ($productsJson as $product) {
            if (isset($product['codProduct'])) {
              $productIds[] = (int) $product['codProduct'];
            }
          }
        }
      }
    }

    // PASO 3: Obtener nombres de TODOS los productos en UNA SOLA consulta
    $productNames = [];
    if (!empty($productIds)) {
      $uniqueIds = array_values(array_unique($productIds)); // Reindexar para PDO
      $placeholders = implode(',', array_fill(0, count($uniqueIds), '?'));

      $stmtProducts = Conexion::conn()->prepare("
        SELECT IdProd, NombreProducto
        FROM tb_producto
        WHERE IdProd IN ($placeholders)
      ");

      $stmtProducts->execute($uniqueIds);
      $productResults = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);

      // Crear array asociativo [IdProd => NombreProducto]
      foreach ($productResults as $prod) {
        $productNames[$prod['IdProd']] = $prod['NombreProducto'];
      }
    }

    // PASO 4: Agregar nombres a los productos en el JSON
    foreach ($results as &$result) {
      if (isset($result['DatosProductosNotaPedidoJson'])) {
        $productsJson = json_decode($result['DatosProductosNotaPedidoJson'], true);

        if (is_array($productsJson)) {
          foreach ($productsJson as &$product) {
            $codProduct = isset($product['codProduct']) ? (int) $product['codProduct'] : 0;

            // Asignar nombre desde el array precargado
            if (isset($productNames[$codProduct])) {
              $product['NombreProducto'] = $productNames[$codProduct];
            } else {
              $product['NombreProducto'] = "Producto no encontrado";
            }
          }

          $result['DatosProductosNotaPedidoJson'] = json_encode($productsJson);
        }
      }
    }

    return $results;
  }

  //  Get list of notas de pedido en general - CON FILTRO DE AÑO
  public static function mdlDownloadExcelNotas($table, $anio = null)
  {
    $whereClause = "";
    if ($anio !== null && $anio !== 'todos') {
      $whereClause = "WHERE YEAR(np.FechaNotaPedido) = :anio";
    }

    $statement = Conexion::conn()->prepare("SELECT np.DatosProductosNotaPedidoJson, np.IdPer, np.IdRes, np.IdNotaP, np.FechaNotaPedido, np.Total,
        CASE np.EstadoNota
            WHEN 1 THEN 'Retirado'
            WHEN 2 THEN 'Entregado'
            WHEN 3 THEN 'Cancelado'
            WHEN 4 THEN 'Devolución'
            WHEN 5 THEN 'Anulado'
            ELSE 'Estado desconocido'
        END AS EstadoNota,
        per.NombrePer AS NombrePerIdPer, 
        per2.NombrePer AS NombrePerIdRes, 
        cli.NombreCli AS NombreCliNota, 
        cli.RucCli, 
        cli.DireccionCli AS DireccionCliNota
    FROM $table AS np
    INNER JOIN tb_personal AS per ON np.IdPer = per.IdPer
    INNER JOIN tb_personal AS per2 ON np.IdRes = per2.IdPer
    INNER JOIN tb_cliente AS cli ON np.IdCliente = cli.IdCli
    $whereClause
    ORDER BY 
    IdNotaP DESC");

    if ($anio !== null && $anio !== 'todos') {
      $statement->bindParam(":anio", $anio, PDO::PARAM_INT);
    }

    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  /* fin */

  /* Reporte excel Notas por fechas - OPTIMIZADO */
  public static function mdlGetAllDowlReportsExeNotPeFech($table, $fechaInicioNot, $fechaFinNot)
  {
    // PASO 1: Obtener notas por fecha
    $statement = Conexion::conn()->prepare("SELECT 
        np.DatosProductosNotaPedidoJson, 
        np.IdPer, 
        np.IdRes, 
        np.IdNotaP, 
        np.FechaNotaPedido, 
        np.Total,
        CASE np.EstadoNota
            WHEN 1 THEN 'Retirado'
            WHEN 2 THEN 'Entregado'
            WHEN 3 THEN 'Cancelado'
            WHEN 4 THEN 'Devolución'
            WHEN 5 THEN 'Anulado'
            ELSE 'Estado desconocido'
        END AS EstadoNota,
        per.NombrePer AS NombrePerIdPer, 
        per2.NombrePer AS NombrePerIdRes, 
        cli.NombreCli AS NombreCliNota, 
        cli.RucCli, 
        cli.DireccionCli AS DireccionCliNota
    FROM tb_notapedido AS np
    INNER JOIN tb_personal AS per ON np.IdPer = per.IdPer
    INNER JOIN tb_personal AS per2 ON np.IdRes = per2.IdPer
    INNER JOIN tb_cliente AS cli ON np.IdCliente = cli.IdCli
    WHERE np.FechaNotaPedido BETWEEN :fechaInicioNot AND :fechaFinNot
    ORDER BY IdNotaP DESC");

    $statement->bindParam(":fechaInicioNot", $fechaInicioNot, PDO::PARAM_STR);
    $statement->bindParam(":fechaFinNot", $fechaFinNot, PDO::PARAM_STR);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    // PASO 2: Obtener todos los IDs de productos
    $productIds = [];
    foreach ($results as $result) {
      if (isset($result['DatosProductosNotaPedidoJson'])) {
        $productsJson = json_decode($result['DatosProductosNotaPedidoJson'], true);
        if (is_array($productsJson)) {
          foreach ($productsJson as $product) {
            if (isset($product['codProduct'])) {
              $productIds[] = (int) $product['codProduct'];
            }
          }
        }
      }
    }

    // PASO 3: Una sola consulta para todos los productos
    $productNames = [];
    if (!empty($productIds)) {
      $uniqueIds = array_values(array_unique($productIds)); // Reindexar para PDO
      $placeholders = implode(',', array_fill(0, count($uniqueIds), '?'));

      $stmtProducts = Conexion::conn()->prepare("
        SELECT IdProd, NombreProducto
        FROM tb_producto
        WHERE IdProd IN ($placeholders)
      ");

      $stmtProducts->execute($uniqueIds);
      $productResults = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);

      foreach ($productResults as $prod) {
        $productNames[$prod['IdProd']] = $prod['NombreProducto'];
      }
    }

    // PASO 4: Agregar nombres a los productos
    foreach ($results as &$result) {
      if (isset($result['DatosProductosNotaPedidoJson'])) {
        $productsJson = json_decode($result['DatosProductosNotaPedidoJson'], true);

        if (is_array($productsJson)) {
          foreach ($productsJson as &$product) {
            $codProduct = isset($product['codProduct']) ? (int) $product['codProduct'] : 0;

            if (isset($productNames[$codProduct])) {
              $product['NombreProducto'] = $productNames[$codProduct];
            } else {
              $product['NombreProducto'] = "Producto no encontrado";
            }
          }

          $result['DatosProductosNotaPedidoJson'] = json_encode($productsJson);
        }
      }
    }

    return $results;
  }

  /* fin */


  /* Imprimir Pdf para Notas de Pedido */
  public static function mdlGetAllPrintPDFNotPe($table, $codNotaPe)
  {
    $statement = Conexion::conn()->prepare("SELECT np.DatosProductosNotaPedidoJson, np.IdPer, np.IdRes, np.IdNotaP, np.FechaNotaPedido, np.Total,
        CASE np.EstadoNota
        WHEN 1 THEN 'Retirado'
            WHEN 2 THEN 'Entregado'
            WHEN 3 THEN 'Cancelado'
            WHEN 4 THEN 'Devolución'
            WHEN 5 THEN 'Anulado'
            ELSE 'Estado desconocido'
        END AS EstadoNota,
        per.NombrePer AS NombrePerIdPer, 
        per2.NombrePer AS NombrePerIdRes, 
        cli.NombreCli AS NombreCliNota, 
        cli.RucCli, 
        cli.DireccionCli AS DireccionCliNota
    FROM tb_notapedido AS np
    INNER JOIN tb_personal AS per ON np.IdPer = per.IdPer
    INNER JOIN tb_personal AS per2 ON np.IdRes = per2.IdPer
    INNER JOIN tb_cliente AS cli ON np.IdCliente = cli.IdCli
    WHERE np.IdNotaP = :codNotaPe
    ORDER BY 
    IdNotaP DESC");

    $statement->bindParam(":codNotaPe", $codNotaPe, PDO::PARAM_STR);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as &$result) {
      // Procesar el campo JSON
      if (isset($result['DatosProductosNotaPedidoJson'])) {
        $productsJson = json_decode($result['DatosProductosNotaPedidoJson'], true);

        foreach ($productsJson as &$product) {
          $statement = Conexion::conn()->prepare("
          SELECT NombreProducto, Unidad
          FROM tb_producto
          WHERE IdProd = :codProduct
        ");

          $statement->bindParam(":codProduct", $product['codProduct'], PDO::PARAM_INT);

          $statement->execute();

          $productResult = $statement->fetch(PDO::FETCH_ASSOC);

          $product['NombreProducto'] = $productResult['NombreProducto'];
          $product['Unidad'] = $productResult['Unidad']; // Agregar la unidad al producto
        }

        $result['DatosProductosNotaPedidoJson'] = json_encode($productsJson);
      }
    }

    return $results;
  }

  /* fin */
  //  Actualizar el estado de la nota de pedido
  public static function mdlUpdateNotaPedidoRetirado($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET EstadoNota=:EstadoNota, Observacion=:Observacion, DateUpdate=:DateUpdate WHERE IdNotaP=:IdNotaP");
    $statement->bindParam(":EstadoNota", $dataUpdate["EstadoNota"], PDO::PARAM_STR);
    $statement->bindParam(":Observacion", $dataUpdate["Observacion"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":IdNotaP", $dataUpdate["IdNotaP"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  public static function mdlUpdateNotaPedidoDevolucion($table, $dataUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $table SET EstadoNota=:EstadoNota, FechaDevolucion=:FechaDevolucion, DateUpdate=:DateUpdate WHERE IdNotaP=:IdNotaP");
    $statement->bindParam(":EstadoNota", $dataUpdate["EstadoNota"], PDO::PARAM_STR);
    $statement->bindParam(":FechaDevolucion", $dataUpdate["FechaDevolucion"], PDO::PARAM_STR);
    $statement->bindParam(":DateUpdate", $dataUpdate["DateUpdate"], PDO::PARAM_STR);
    $statement->bindParam(":IdNotaP", $dataUpdate["IdNotaP"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}
