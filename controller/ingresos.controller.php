<?php

class IngresosController
{
  /* mostrar todos ingresos en la tabla */
  public static function ctrGetAllIngresos()
  {
    $table = "tb_ingreso";
    $listAllDataExeIng = IngresosModel::mdlGetAllIngresos($table);
    return $listAllDataExeIng;
  }

  // obtener datos de los productos para agregarlos a la lista
  public static function ctrGetListProducts()
  {
    $table = "tb_producto";
    $productData = IngresosModel::mdlGetProductData($table);
    return $productData;
  }

  //  Devolver productos para agregarlos a la lista de ingreso ajx
  public static function ctrGetProductDataAjx($codProductAdd)
  {
    $table = "tb_producto";
    $data = IngresosModel::mdlGetProductDataAjx($table, $codProductAdd);
    return $data;
  }

  /* funcion de controlador que toma el json de newIngJs e ingresa el registo a el ingreso */
  public static function ctrCreateIngresoNuevoAjx($newIngJs)
  {
    if (isset($newIngJs)) {
      $table = "tb_ingreso";

      // Decodificar el JSON
      $data = json_decode($newIngJs, true);

      $dataCreate = array(
        "IdPer" => $data["nameRes"],
        "DescripcionIng" => $data["DescripcionIng"],
        "DatosProductosIngresoJson" => $data["listProducts"],
        "FechaProduccionIng" => $data["dateProduction"],
        "FechaVencimientoIng" => $data["dateVenci"],
        "FechaReingresoIng" => $data["dateDev"],
        "FechaMermaIng" => $data["dateMerma"],
        "Estado" => $data["stateIng"],
        "DateCreate" => date("Y-m-d\TH:i:sP"),
        "DateUpdate" => date("Y-m-d\TH:i:sP")
      );
      $response = IngresosModel::mdlCreateIngresoNuevoAjx($table, $dataCreate);

      // Actualizar stock
      $listaProductos = json_decode($data["listProducts"], true);
      foreach ($listaProductos as $value) {

        // Comprobar stock
        $dataStock = AlmacenController::ctrComprobarStock($value["codProduct"]);
        //update stock
        if ($dataStock["IdAlma"] != "") {
          $newStock = $dataStock["CantidadTotal"] + $value["countProduct"];
          $dataUpdateStock = array(
            "CantidadTotal" => $newStock,
            "DateUpdate" => date("Y-m-d"),
            "HoraUpdate" => date("H:i:s"),
            "IdAlma" => $dataStock["IdAlma"]
          );
          $updateStock = AlmacenController::ctrUpdateStockAlmacen($dataUpdateStock);
          //crear stock
        } else {
          $dataCreateStock = array(
            "IdProd" => $value["codProduct"],
            "CantidadTotal" => $value["countProduct"],
            "DateCreate" => date("Y-m-d"),
            "HoraCreate" => date("H:i:s"),
            "DateUpdate" => date("Y-m-d"),
            "HoraUpdate" => date("H:i:s")
          );
          $updateStock = AlmacenController::ctrCreateStockAlmacen($dataCreateStock);
        }
      }
      return $response;
    }
  }

  // Eliminar nota pedido
  public static function ctrdeleteIngreso()
  {
    if (isset($_GET["codIngresoDelet"])) {
      $table = "tb_ingreso";
      $codIngreso = $_GET["codIngresoDelet"];
      //  Obtener la data del ingreso
      $listaProductos = IngresosModel::mdlGetIngresoList($table, $codIngreso);
      $listaProductos = json_decode($listaProductos["DatosProductosIngresoJson"], true);

      //  Actualizar stock con cada dato que se está eliminando
      foreach ($listaProductos as $value) {
        $stockActual = AlmacenController::ctrComprobarStock($value["codProduct"]);
        $nuevoStock = $stockActual["CantidadTotal"] - $value["countProduct"];

        $dataStock = array(
          "CantidadTotal" => $nuevoStock,
          "DateUpdate" => date("Y-m-d"),
          "HoraUpdate" => date("H:i:s"),
          "IdAlma" => $stockActual["IdAlma"]
        );
        $updateStock = AlmacenController::ctrUpdateStockAlmacen($dataStock);
      }

      if ($updateStock == "ok") {
        $response = IngresosModel::mdlDeleteIngreso($table, $codIngreso);
        if ($response == "ok") {
          $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Ingreso Eliminado Correctamente', 'index.php?ruta=ingresos');
          echo $message;
        } else {
          $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Eliminar el Ingreso ', 'index.php?ruta=ingresos');
          echo $message;
        }
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Eliminar el Ingreso ', 'index.php?ruta=ingresos');
        echo $message;
      }
    }
  }

  //  Obtener datos del ingreso para editar
  public static function ctrGetIngreso($codIngreso)
  {
    $table = "tb_ingreso";
    $data = IngresosModel::mdlGetIngreso($table, $codIngreso);
    return $data;
  }

  //  Editar un ingreso
  public static function ctrEditIngreso()
  {
    if (isset($_POST["editResponsable"]) && isset($_POST["editFechaProduccion"]) && isset($_POST["editFechaVencimiento"]) && isset($_POST["editDescripcionIngreso"])) {
      $table = "tb_ingreso";
      $codIngreso = $_POST["codIngreso"];
      //  Primero editamos la cabecera del ingreso
      $data = array(
        "IdPer" => $_POST["editResponsable"],
        "DescripcionIng" => $_POST["editDescripcionIngreso"],
        "FechaProduccionIng" => $_POST["editFechaProduccion"],
        "FechaVencimientoIng" => $_POST["editFechaVencimiento"],
        "DateUpdate" => date("Y-m-d\TH:i:sP"),
        "IdIng" => $codIngreso
      );
      $response = IngresosModel::mdlEditIngreso($table, $data);

      if ($response == "ok") {
        //  Actualizamos el stock del almacén, siempre que se haya modificado la lista de productos
        $nuevaListaProductos = json_decode($_POST["listProducts"], true);
        if ($nuevaListaProductos != "" || $nuevaListaProductos != null) {
          //  Obtener la lista antigua del ingreso
          $antiguaListaProductos = IngresosModel::mdlGetIngresoList($table, $codIngreso);
          $antiguaListaProductos = json_decode($antiguaListaProductos["DatosProductosIngresoJson"], true);
          //  Actualizar stock con cada dato de la lista antigua
          foreach ($antiguaListaProductos as $value) {
            $stockActual = AlmacenController::ctrComprobarStock($value["codProduct"]);
            $nuevoStock = $stockActual["CantidadTotal"] - $value["countProduct"];
            $dataStock = array(
              "CantidadTotal" => $nuevoStock,
              "DateUpdate" => date("Y-m-d"),
              "HoraUpdate" => date("H:i:s"),
              "IdAlma" => $stockActual["IdAlma"]
            );
            $updateStock = AlmacenController::ctrUpdateStockAlmacen($dataStock);
          }

          //  Actualizar stock con la lista nueva, si existe el stock de un producto solo se hace update, caso contrario se lo crea en el almacen
          foreach ($nuevaListaProductos as $value) {
            $stockActual = AlmacenController::ctrComprobarStock($value["codProduct"]);
            if ($stockActual["IdAlma"] == "") {
              $dataCreateStock = array(
                "IdProd" => $value["codProduct"],
                "CantidadTotal" => $value["countProduct"],
                "DateCreate" => date("Y-m-d"),
                "HoraCreate" => date("H:i:s"),
                "DateUpdate" => date("Y-m-d"),
                "HoraUpdate" => date("H:i:s")
              );
              $updateStock = AlmacenController::ctrCreateStockAlmacen($dataCreateStock);
            } else {
              $nuevoStock = $stockActual["CantidadTotal"] + $value["countProduct"];
              $dataStock = array(
                "CantidadTotal" => $nuevoStock,
                "DateUpdate" => date("Y-m-d"),
                "HoraUpdate" => date("H:i:s"),
                "IdAlma" => $stockActual["IdAlma"]
              );
              $updateStock = AlmacenController::ctrUpdateStockAlmacen($dataStock);
            }
            $nuevoStock = $stockActual["CantidadTotal"] + $value["countProduct"];
            $dataStock = array(
              "CantidadTotal" => $nuevoStock,
              "DateUpdate" => date("Y-m-d"),
              "HoraUpdate" => date("H:i:s"),
              "IdAlma" => $stockActual["IdAlma"]
            );
            
            //  Luego de actualizar el stock, actualizamos la lista de productos del ingreso
            $dataUpdate = array(
              "DatosProductosIngresoJson" => $_POST["listProducts"],
              "IdIng" => $codIngreso
            );
            $response = IngresosModel::mdlEditIngresoList($table, $dataUpdate);
          }
          if ($updateStock == "ok") {
            $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Ingreso Editado Correctamente', 'index.php?ruta=ingresos');
            echo $message;
          } else {
            $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Editar el Ingreso ', 'index.php?ruta=ingresos');
            echo $message;
          }
        } else {
          $message = FunctionsController::ctrShowAlert('success', 'Correcto', 'Ingreso Editado Correctamente', 'index.php?ruta=ingresos');
          echo $message;
        }
      } else {
        $message = FunctionsController::ctrShowAlert('error', 'Error', 'Error al Editar el Ingreso ', 'index.php?ruta=ingresos');
        echo $message;
      }
    }
  }

  // Verificar un personal se esta usando en alguna tabla
  public static function ctrGetHistorialPer($codPersonal)
  {
    $table = "tb_ingreso";
    $respuesta = IngresosModel::mdlGetHistorialPersonal($table, $codPersonal);
    return $respuesta;
  }

  /* Devolver todos los ingreso para el reporte exel */
  public static function ctrGetAllDowlReportsExeIng()
  {
    $table = "tb_ingreso";
    $listAllDataExeIng = IngresosModel::mdlGetAllDowlReportsExeIng($table);

    // Iterar sobre cada registro
    foreach ($listAllDataExeIng as $key => $record) {
      // Decodificar el JSON en el campo DatosProductosIngresoJson
      $products = json_decode($record['DatosProductosIngresoJson'], true);

      // Formatear los datos del producto
      foreach ($products as $index => $product) {
        $products[$index] = ($index + 1) . '-PRODUCTO: ' . $product['NombreProducto'] . '   CANTIDAD : ' . $product['countProduct'];
      }

      // Unir los datos del producto en una cadena de texto con saltos de línea entre cada producto
      $listAllDataExeIng[$key]['DatosProductosIngresoJson'] = implode("\n", $products);
    }

    return $listAllDataExeIng;
  }
  /* fin */

}
