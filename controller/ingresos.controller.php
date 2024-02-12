<?php

class IngresosController
{
  /* mostrar todos ingresos en la tabla */
  public static function ctrGetAllIngresos()
  {
    $table = "tb_ingreso";
    $ListNotaPedido = IngresosModel::mdlGetAllIngresos($table);
    return $ListNotaPedido;
  }

  // obtener datos de los productos para agregarlos a la lista
  public static function ctrGetListProducts()
  {
    $table = "tb_producto";
    $productData = IngresosModel::mdlGetProductData($table);
    return $productData;
  }

  // Obtener al responsable por login o sesión de usuario
  public static function ctrGetPersonRes()
  {
    $table = "tb_personal";
    $sessionUserId = $_SESSION["IdUsu"];
    $listIngresos = IngresosModel::mdlGetPersonRes($table, $sessionUserId);
    return $listIngresos;
  }


  //  Devolver productos para agregarlos a la lista de ingreso ajx
  public static function ctrGetProductDataAjx($codProductAdd)
  {
    $table = "tb_producto";
    $data = IngresosModel::mdlGetProductDataAjx($table, $codProductAdd);
    return $data;
  }


  //crear ingreso devuelve el ultimo ingreso
  public static function ctrGetLastIngreso()
  {
    $table = "tb_ingreso";
    $response = IngresosModel::mdlGetLastIngreso($table);
    return $response;
  }

  //crear ingreso devuelve el ultimo ingresodetalle
  public static function ctrGetLastIngresoDetalle()
  {
    $table = "tb_ingresodetalle";
    $response = IngresosModel::mdlGetLastIngresoDetalle($table);
    return $response;
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
  /* fin */

}

