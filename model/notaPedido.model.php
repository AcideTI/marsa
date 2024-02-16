<?php
require_once "conexion.php";

class NotaPedidoModel
{
  // Obtener todos los REGISTROS de Nota de pedido
public static function mdlGetAllSalidasNotaPe($table)
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
public static function mdlCreateNotaPedido($table, $data) {
   
    // Prepara la consulta SQL
    $stmt = Conexion::conn()->prepare("INSERT INTO $table (IdLote, IdPer, IdRes, NotaPorFA, IdCliente, TipoDeNotaPe, TipoNotaPeFactura, DatosProductosNotaPedidoJson, Total, Estado, FechaNotaPedido, DateCreate, DateUpdate) VALUES (:IdLote, :IdPer, :IdRes, :NotaPorFA, :IdCliente, :TipoDeNotaPe, :TipoNotaPeFactura, :DatosProductosNotaPedidoJson, :Total, :Estado, :FechaNotaPedido, :DateCreate, :DateUpdate)");

    // Vincula los parámetros
    $stmt->bindParam(":IdLote", $data["IdLote"], PDO::PARAM_STR);
    $stmt->bindParam(":IdPer", $data["IdPer"], PDO::PARAM_STR);
    $stmt->bindParam(":IdRes", $data["IdRes"], PDO::PARAM_STR);
    $stmt->bindParam(":NotaPorFA", $data["NotaPorFA"], PDO::PARAM_STR);
    $stmt->bindParam(":IdCliente", $data["IdCliente"], PDO::PARAM_STR);
    $stmt->bindParam(":TipoDeNotaPe", $data["TipoDeNotaPe"], PDO::PARAM_STR);
    $stmt->bindParam(":TipoNotaPeFactura", $data["TipoNotaPeFactura"], PDO::PARAM_STR);
    $stmt->bindParam(":DatosProductosNotaPedidoJson", $data["DatosProductosNotaPedidoJson"], PDO::PARAM_STR);
    $stmt->bindParam(":Total", $data["Total"], PDO::PARAM_STR);
    $stmt->bindParam(":Estado", $data["Estado"], PDO::PARAM_STR);
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
        $statement = Conexion::conn()->prepare("SELECT tb_almacen.IdProd, tb_producto.NombreProducto, tb_almacen.CantidadTotal FROM $table INNER JOIN tb_producto ON tb_almacen.IdProd = tb_producto.IdProd WHERE	tb_almacen.CantidadTotal > 0");
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
    $statement -> bindParam(":IdNotaP", $codNotaPe, PDO::PARAM_INT);
    if ($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }
    /* fin */

  // Obtener datos de la nota de pedido para editar -> CORREGIR
  public static function mdlGetNotaPeById($table, $codNota)
  {
    $statement = Conexion::conn()->prepare("SELECT tb_almacen.IdProd, tb_almacen.CantidadTotal, tb_producto.NombreProducto, tb_producto.Precio FROM $table INNER JOIN tb_producto ON tb_almacen.IdProd = tb_producto.IdProd WHERE tb_producto.IdProd = $codNota");
    $statement->execute();
    return $statement->fetch();
  }

   // Verificar un Cliente si se esta usando en nota pedido
   public static function mdlGetHistorialCliente($table, $codClient) {
    $stmt = Conexion::conn()->prepare("SELECT COUNT(IdCliente) as IdCliente FROM $table WHERE IdCliente = :IdCliente");
    $stmt->bindParam(":IdCliente", $codClient, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
  }

   // Verificar un vendedor si se esta usando en nota pedido
   public static function mdlGetHistorialPerVend($table, $codPersonal) {
    $stmt = Conexion::conn()->prepare("SELECT COUNT(IdRes) as IdRes FROM $table WHERE IdRes = :IdRes");
    $stmt->bindParam(":IdRes", $codPersonal, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
  }

  // Verificar un responsable si se esta usando en nota pedido
  public static function mdlGetHistorialPerRes($table, $codPersonal) {
    $stmt = Conexion::conn()->prepare("SELECT COUNT(IdPer) as IdPer FROM $table WHERE IdPer = :IdPer");
    $stmt->bindParam(":IdPer", $codPersonal, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
  }

}
