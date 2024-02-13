<?php
require_once "conexion.php";

class NotaPedidoModel
{
  // Obtener todos los REGISTROS de Nota de pedido
public static function mdlGetAllSalidasNotaPe($table)
{
  $statement = Conexion::conn()->prepare("
    SELECT np.*, 
      l.CodigoLote, 
      per.NombrePer AS NombrePerIdPer, 
      per2.NombrePer AS NombrePerNotaPorFA, 
      cli.NombreCli AS NombreCliNota, 
      cli.RucCli, 
      cli.DireccionCli AS DireccionCliNota, 
      e.TipoEstado
    FROM $table AS np
    LEFT JOIN tb_lote AS l ON np.IdLote = l.IdLote
    INNER JOIN tb_personal AS per ON np.IdPer = per.IdPer
    INNER JOIN tb_personal AS per2 ON np.NotaPorFA = per2.IdPer
    INNER JOIN tb_cliente AS cli ON np.NombreCliNota = cli.IdCli AND np.RucCli = cli.IdCli AND np.DireccionCliNota = cli.IdCli
    INNER JOIN tb_estado AS e ON np.Estado = e.IdEstado
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

        $product['NombreProducto'] = $productResult['NombreProducto'];
      }

      $result['DatosProductosNotaPedidoJson'] = json_encode($productsJson);
    }
  }

  return $results;
}


// Crear Nota de pedido
public static function mdlGetAjaxDatosJson($table, $data) {
   
  // Prepara la consulta SQL
  $stmt = Conexion::conn()->prepare("INSERT INTO $table (IdLote, IdPer, IdRes,NotaPorFA, RucCli, NombreCliNota, DireccionCliNota, TipoDeNotaPe, TipoNotaPeFactura, DatosProductosNotaPedidoJson, SubTotal, IGV, Total, ComentarioNotaDev, Estado, FechaNotaPedido, FechaNotaDevolucion, DateCreate, DateUpdate) VALUES (:IdLote, :IdPer, :IdRes,:NotaPorFA, :RucCli, :NombreCliNota, :DireccionCliNota, :TipoDeNotaPe, :TipoNotaPeFactura, :DatosProductosNotaPedidoJson, :SubTotal, :IGV, :Total, :ComentarioNotaDev, :Estado, :FechaNotaPedido, :FechaNotaDevolucion, :DateCreate, :DateUpdate)");

  // Vincula los parámetros
  $stmt->bindParam(":IdLote", $data["IdLote"], PDO::PARAM_STR);
  $stmt->bindParam(":IdPer", $data["IdPer"], PDO::PARAM_STR);
  $stmt->bindParam(":IdRes", $data["IdRes"], PDO::PARAM_STR);
  $stmt->bindParam(":NotaPorFA", $data["NotaPorFA"], PDO::PARAM_STR);
  $stmt->bindParam(":RucCli", $data["RucCli"], PDO::PARAM_STR);
  $stmt->bindParam(":NombreCliNota", $data["NombreCliNota"], PDO::PARAM_STR);
  $stmt->bindParam(":DireccionCliNota", $data["DireccionCliNota"], PDO::PARAM_STR);
  $stmt->bindParam(":TipoDeNotaPe", $data["TipoDeNotaPe"], PDO::PARAM_STR);
  $stmt->bindParam(":TipoNotaPeFactura", $data["TipoNotaPeFactura"], PDO::PARAM_STR);
  $stmt->bindParam(":DatosProductosNotaPedidoJson", $data["DatosProductosNotaPedidoJson"], PDO::PARAM_STR);
  $stmt->bindParam(":SubTotal", $data["SubTotal"], PDO::PARAM_STR);
  $stmt->bindParam(":IGV", $data["IGV"], PDO::PARAM_STR);
  $stmt->bindParam(":Total", $data["Total"], PDO::PARAM_STR);
  $stmt->bindParam(":ComentarioNotaDev", $data["ComentarioNotaDev"], PDO::PARAM_STR);
  $stmt->bindParam(":Estado", $data["Estado"], PDO::PARAM_STR);
  $stmt->bindParam(":FechaNotaPedido", $data["FechaNotaPedido"], PDO::PARAM_STR);
  $stmt->bindParam(":FechaNotaDevolucion", $data["FechaNotaDevolucion"], PDO::PARAM_STR);
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


    // Mostrar los productos a agregar nota de pedido
    public static function mdlGetProductData($table)
    {
        $statement = Conexion::conn()->prepare("SELECT 
        tb_almacen.IdAlma,
        tb_almacen.IdProd,
        tb_producto.NombreProducto,
        tb_categoriaprod.NombreCategoria,
        tb_producto.Unidad,
        tb_almacen.CantidadTotal,
        tb_producto.Precio
      FROM 
        $table
      INNER JOIN 
        tb_producto ON tb_almacen.IdProd = tb_producto.IdProd
      INNER JOIN 
        tb_categoriaprod ON tb_producto.IdCate = tb_categoriaprod.IdCate
      ORDER BY 
        GREATEST(CONCAT(tb_almacen.DateCreate, ' ', tb_almacen.HoraCreate), CONCAT(tb_almacen.DateUpdate, ' ', tb_almacen.HoraUpdate)) DESC");
        $statement->execute();
        return $statement->fetchAll();
    }


    //   Ajax que devuelve  los productos a nota pedido
    public static function mdlGetProductDataAjx($table, $codProductAdd)
    {
        $statement = Conexion::conn()->prepare("SELECT tb_producto.IdProd, tb_producto.NombreProducto, tb_producto.Precio FROM $table WHERE IdProd = $codProductAdd");
        $statement->execute();
        return $statement->fetch();
    }

    
/* mostrar detalles complentarios de nota de pedido por el boton */
  public static function mdlGetDetallNotPeData($table, $codDetNotPeData)
  {
    $statement = Conexion::conn()->prepare("
      SELECT np.*, 
           l.CodigoLote, 
           per.NombrePer AS NombrePerIdPer, 
           per2.NombrePer AS NombrePerNotaPorFA, 
           cli.NombreCli AS NombreCliNota, 
           cli.RucCli, 
           cli.DireccionCli AS DireccionCliNota, 
           e.TipoEstado
      FROM $table AS np
      LEFT JOIN tb_lote AS l ON np.IdLote = l.IdLote
      INNER JOIN tb_personal AS per ON np.IdPer = per.IdPer
      INNER JOIN tb_personal AS per2 ON np.NotaPorFA = per2.IdPer
      INNER JOIN tb_cliente AS cli ON np.NombreCliNota = cli.IdCli AND np.RucCli = cli.IdCli AND np.DireccionCliNota = cli.IdCli
      INNER JOIN tb_estado AS e ON np.Estado = e.IdEstado
      WHERE np.IdNotaP = :codDetNotPeData
    ");

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
}
