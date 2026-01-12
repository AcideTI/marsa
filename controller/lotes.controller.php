<?php
date_default_timezone_set('America/Bogota');
class LotesController
{

  /* mostrar todos los lotes en la tabla */
  public static function ctrGetAllLotes()
  {
    $table = "tb_lote";
    $ListNotaPedido = LotesModel::mdlGetAllLotes($table);
    return $ListNotaPedido;
  }

  // obtener datos de los productos para agregarlos a la lista
  public static function ctrGetListProducts()
  {
    $table = "tb_almacen";
    $productData = LotesModel::mdlGetProductData($table);
    return $productData;
  }

  //  Devolver productos para agregarlos a la lista de ingreso ajx
  public static function ctrGetProductDataAjx($codProductAdd)
  {
    $table = "tb_producto";
    $data = LotesModel::mdlGetProductDataAjx($table, $codProductAdd);
    return $data;
  }

  //  Obtener los datos de un lote para mostrar en el modal
  public static function ctrGetDataLote($codLote)
  {
    $table = "tb_lote";
    $data = LotesModel::mdlGetDataLote($table, $codLote);
    /*  Enviar los datos de los productos decodificados
    $listaDatos = json_decode($data["DatosLoteIngresoJson"], true);
    $nombreProducto = ProductsController::ctrGetDataProducto($listaDatos[0]["codProduct"]);
    $listaDatos[0]["codProduct"] = $nombreProducto["NombreProducto"];
    $data["DatosLoteIngresoJson"] = $listaDatos;*/
    return $data;
  }

  /*  funcion para crear un nuevo lote */
  public static function ctrCreateIngresoLoteAjx($newIngLote)
  {
    if (isset($newIngLote)) {
      $table = "tb_lote";

      // Decodificar el JSON
      $data = json_decode($newIngLote, true);
      $listProducts = json_decode($data["listProducts"], true);
      /*  El codigo de lote, está compuesto por el día_mes_operador_producto
      $fecha = strtotime($data["dateCreatLot"]);
      $dia = date("d", $fecha);
      $mes = date("m", $fecha);
      $operador = $data["nameResLot"];
      $producto = $listProducts[0]["codProduct"];

      $codigoLote = 'L-' . $dia . '_' . $mes . '_' . $operador . '_' . $producto;*/

      $dataCreate = array(
        "IdCliente" => $data["notCli"],
        "IdPer" => $data["nameResLot"],
        "CodigoLote" => $data["numeroLote"],
        "NroFactura" => $data["numeroFactura"],
        "TotalFactura" => $data["totalFactura"],
        "TipoSalida" => $data["tipoSalida"],
        "DatosLoteIngresoJson" => $data["listProducts"],
        "FechaProduccionLote" => $data["dateCreatLot"],
        "FechaVencimientoLote" => $data["dateVenciLot"],
        "Estado" => "1",
        "DateCreate" => date("Y-m-d\TH:i:sP"),
        "DateUpdate" => date("Y-m-d\TH:i:sP")
      );
      $response = LotesModel::mdlCreateIngresoLoteAjx($table, $dataCreate);

      // Si la respuesta es exitosa, restar los productos del almacén
      if ($response == "ok") {
        foreach ($listProducts as $product) {
          //  Obtener el codigo del producto del almacén y la cantidad que se tiene actualmente
          $stock = AlmacenController::ctrComprobarStockRes($product["codProduct"]);
          if ($stock != null) {
            $newStock = $stock["CantidadTotal"] - $product["countProduct"];
            // Prepara los datos para la actualización en la base de datos
            $dataUpdate = array(
              "CantidadTotal" => $newStock,
              "DateUpdate" => date("Y-m-d"),
              "HoraUpdate" => date("H:i:s"),
              "IdAlma" => $stock["IdAlma"]
            );

            // Actualiza el stock del producto en la base de datos
            $response = AlmacenController::ctrUpdateStockAlmacenRes($dataUpdate);
          } else {
            $dataCreateStock = array(
              "IdProd" => $product["codProduct"],
              "CantidadTotal" => intval($product["countProduct"]) * (-1),
              "DateCreate" => date("Y-m-d"),
              "HoraCreate" => date("H:i:s"),
              "DateUpdate" => date("Y-m-d"),
              "HoraUpdate" => date("H:i:s")
            );
            $updateStock = AlmacenController::ctrCreateStockAlmacen($dataCreateStock);
          }
        }
      } else {
        $response = "error";
      }
      return $response;
    }
  }

  /* funcion para Editar  lote por el boton  */
  public static function ctrEditIngresoLoteAjx($editLote)
  {
    if (isset($editLote)) {
      $table = "tb_lote";
      $data = json_decode($editLote, true);
      $codLote = $data["codLoteEditar"];

      $listaAntigua = LotesModel::mdlGetListaProductos($table, $codLote);
      $listaAntigua = json_decode($listaAntigua["DatosLoteIngresoJson"], true);
      $listaNueva = json_decode($data["listProducts"], true);

      $tipoSalida = LotesModel::mdlGetTipoSalida($table, $codLote);

      $mapAntiguo = array_map('serialize', $listaAntigua);
      $mapNuevo = array_map('serialize', $listaNueva);
      sort($mapAntiguo);
      sort($mapNuevo);

      if ($mapAntiguo == $mapNuevo) {
        //  Verificamos si tiene codigo de lote, en el caso que tenga codigo de lote, significa que es un lote, caso contrario es una salida por factura.
        if ($tipoSalida["TipoSalida"] == "Factura") {
          $dataUpdate = array(
            "IdPer" => $data["editarResponsable"],
            "IdCliente" => $data["notCli"],
            "NroFactura" => $data["editarNumeroFactura"],
            "TotalFactura" => $data["totalFactura"],
            "FechaProduccionLote" => $data["editarFechaLote"],
            "DateUpdate" => date("Y-m-d\TH:i:sP"),
            "IdLote" => $codLote
          );
          $response = LotesModel::mdlEditSalidaFactura($table, $dataUpdate);
        } else {
          $dataUpdate = array(
            "IdPer" => $data["editarResponsable"],
            "IdCliente" => $data["notCli"],
            "NroFactura" => $data["editarNumeroFactura"],
            "TotalFactura" => $data["totalFactura"],
            "CodigoLote" => $data["editarNumeroLote"],
            "FechaProduccionLote" => $data["editarFechaLote"],
            "DateUpdate" => date("Y-m-d\TH:i:sP"),
            "IdLote" => $codLote
          );
          $response = LotesModel::mdlEditSalidaLote($table, $dataUpdate);
        }
      } else {
        //  Si los productos son distintos, primero actualizamos el stock con ambas listas y luego actualizamos el registro, primero en el stock del almacén y luego en el lote
        $actualizarStock = AlmacenController::ctrUpdateStockNota($listaAntigua, $listaNueva);
        if ($actualizarStock == "ok") {
          //  Actualizamos los datos de la salida, si es un lote. Modificamos el numero de lote más, caso contrario solo modificamos el número de factura y el total
          if ($tipoSalida["TipoSalida"] == "Factura") {
            $dataUpdate = array(
              "IdPer" => $data["editarResponsable"],
              "IdCliente" => $data["notCli"],
              "NroFactura" => $data["editarNumeroFactura"],
              "TotalFactura" => $data["totalFactura"],
              "FechaProduccionLote" => $data["editarFechaLote"],
              "DatosLoteIngresoJson" => $data["listProducts"],
              "DateUpdate" => date("Y-m-d\TH:i:sP"),
              "IdLote" => $codLote
            );
            $response = LotesModel::mdlEditSalidaFacturaCompleto($table, $dataUpdate);
          } else {
            $dataUpdate = array(
              "IdPer" => $data["editarResponsable"],
              "IdCliente" => $data["notCli"],
              "NroFactura" => $data["editarNumeroFactura"],
              "TotalFactura" => $data["totalFactura"],
              "CodigoLote" => $data["editarNumeroLote"],
              "FechaProduccionLote" => $data["editarFechaLote"],
              "DatosLoteIngresoJson" => $data["listProducts"],
              "DateUpdate" => date("Y-m-d\TH:i:sP"),
              "IdLote" => $codLote
            );
            $response = LotesModel::mdlEditSalidaLoteCompleto($table, $dataUpdate);
          }
        }
      }
      return $response;
    }
  }
  /* fin */

  //  Obtener los datos del lote para la vista de editar
  public static function ctrGetEditLoteData($codLoteEdit)
  {
    $table = "tb_lote";
    $response = LotesModel::mdlGetEditLoteData($table, $codLoteEdit);
    return $response;
  }

  // Eliminar lote
  public static function ctrDeleteLote()
  {
    if (isset($_GET["codLoteDelet"])) {
      $table = "tb_lote";
      $codLoteDelet = $_GET["codLoteDelet"];

      //  Verificar que el lote sea de estado 1 para que se pueda eliminar
      $estadoLote = self::ctrGetEstadoLote($codLoteDelet);
      if ($estadoLote["Estado"] != 1) {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Eliminar el Lote, solo se pueden eliminar los lotes en estado "Retirado"', 'verSalidas');
        echo $message;
      } else {
        $productos = LotesModel::mdlGetListaProductos($table, $codLoteDelet);
        $productos = json_decode($productos["DatosLoteIngresoJson"], true);

        //  Actualizar el stock del almacén
        foreach ($productos as $producto) {
          $stock = AlmacenController::ctrComprobarStockRes($producto["codProduct"]);
          $nuevoStock = $stock["CantidadTotal"] + $producto["countProduct"];
          $dataUpdate = array(
            "CantidadTotal" => $nuevoStock,
            "DateUpdate" => date("Y-m-d"),
            "HoraUpdate" => date("H:i:s"),
            "IdAlma" => $stock["IdAlma"]
          );
          AlmacenController::ctrUpdateStockAlmacenRes($dataUpdate);
        }
        $response = LotesModel::mdlDeleteLote($table, $codLoteDelet);
        if ($response == "ok") {
          $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Lote Eliminado Correctamente', 'verSalidas');
          echo $message;
        } else {
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Eliminar el Lote ', 'verSalidas');
          echo $message;
        }
      }
    }
  }

  //  Obtener el estado del lote
  public static function ctrGetEstadoLote($codLote)
  {
    $table = "tb_lote";
    $response = LotesModel::mdlGetEstadoLote($table, $codLote);
    return $response;
  }

  //  Actualizar el estado del lote
  public static function ctrUpdateLoteEstado()
  {
    if (isset($_GET["codUpateLote"])) {
      $table = "tb_lote";
      $codLote = $_GET["codUpateLote"];
      $observacion = $_GET["observacion"];
      $estado = self::ctrGetEstadoLote($codLote);
      $estado = intval($estado["Estado"]) + 1;
      $dataUpdate = array(
        "Estado" => $estado,
        "Observacion" => $observacion,
        "DateUpdate" => date("Y-m-d\TH:i:sP"),
        "IdLote" => $codLote
      );
      $actualizarLote = LotesModel::mdlUpdateLoteEstado($table, $dataUpdate);
      if ($actualizarLote == "ok") {
        $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Nota Pedido Actualizada Correctamente', 'verSalidas');
        echo $message;
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Actualizar la Nota Pedido', 'verSalidas');
        echo $message;
      }
    }
  }

  public static function ctrUpdateLoteDevolucion($dataUpdate)
  {
    $table = "tb_lote";
    $response = LotesModel::mdlUpdateLoteDevolucion($table, $dataUpdate);
    return $response;
  }

  /* fin */


  /*  Descargar todos los Lotes para el reporte excel de Lotes - CON FILTRO DE AÑO */

  public static function ctrGetAllDowlReportsExeLote($anio = null)
  {
    $table = "tb_lote";
    $listAllDataExeLote = LotesModel::mdlGetAllDowlReportsExeLote($table, $anio);

    $newlistAllDataExeLote = [];

    // Iterar sobre cada registro
    foreach ($listAllDataExeLote as $key => $Data) {
      $recordlistAllDataExeLote = self::procesarJson($Data);
      $newlistAllDataExeLote = array_merge($newlistAllDataExeLote, $recordlistAllDataExeLote);
    }

    return $newlistAllDataExeLote;
  }

  //  Descargar las facturas en excel de manera general - CON FILTRO DE AÑO
  public static function ctrDownloadExcelFacturas($anio = null)
  {
    $table = "tb_lote";
    $listFacturasGeneral = LotesModel::mdlDownloadExcelFacturas($table, $anio);
    return $listFacturasGeneral;
  }

  /* Función para procesar el campo JSON de un registro.*/

  private static function procesarJson($Data)
  {
    $recordlistAllDataExeLote = [];

    // Decodificar el JSON en el campo DatosProductosIngresoJson
    $products = json_decode($Data['DatosLoteIngresoJson'], true);

    // Formatear los datos del producto
    foreach ($products as $index => $product) {
      $newData = $Data;
      $newData['Producto'] = $product['NombreProducto'];
      $newData['Cantidad'] = $product['countProduct'];
      unset($newData['DatosLoteIngresoJson']);

      $recordlistAllDataExeLote[] = $newData;
    }
    return $recordlistAllDataExeLote;
  }

  /* fin */

  /* Reporte excel Lotes por fechas  */
  public static function ctrGetAllDowlReportsExeLoteFech($fechaInicioLt, $fechaFinLt)
  {
    $table = "tb_notapedido";
    $listAllDataExeLoteFech = LotesModel::mdlGetAllDowlReportsExeLoteFech($table, $fechaInicioLt, $fechaFinLt);
    $newlistAllDataExeLoteFech = [];
    // Iterar sobre cada registro
    foreach ($listAllDataExeLoteFech as $key => $Data) {
      $recordlistAllDataExeLoteFech = self::procesarJsonFech($Data);
      $newlistAllDataExeLoteFech = array_merge($newlistAllDataExeLoteFech, $recordlistAllDataExeLoteFech);
    }
    return $newlistAllDataExeLoteFech;
  }

  private static function procesarJsonFech($Data)
  {
    $recordlistAllDataExeLoteFech = [];
    $products = json_decode($Data['DatosLoteIngresoJson'], true);
    foreach ($products as $index => $product) {
      $newData = $Data; // Copiar el registro original
      $newData['Producto'] = $product['NombreProducto'];
      $newData['Cantidad'] = $product['countProduct'];
      unset($newData['DatosLoteIngresoJson']);
      $recordlistAllDataExeLoteFech[] = $newData;
    }
    return $recordlistAllDataExeLoteFech;
  }
  /* fin */

  //  Anular una salida (Lote)
  public static function ctrNullLote()
  {
    if (isset($_GET["codNullLote"])) {
      $table = "tb_lote";
      $codLote = $_GET["codNullLote"];
      $estadoLote = self::ctrGetEstadoLote($codLote);
      if ($estadoLote["Estado"] != 1) {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Anular el Lote, solo se pueden anular los lotes en estado "Retirado"', 'verSalidas');
        echo $message;
      } else {
        $dataUpdate = array(
          "Estado" => "5",
          "DateUpdate" => date("Y-m-d\TH:i:sP"),
          "IdLote" => $codLote
        );
        $response = LotesModel::mdlNullLote($table, $dataUpdate);
        if ($response == "ok") {
          $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Lote Anulado Correctamente', 'verSalidas');
          echo $message;
        } else {
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Anular el Lote', 'verSalidas');
          echo $message;
        }
      }
    }
  }
}
