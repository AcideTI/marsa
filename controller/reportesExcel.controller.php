<?php
date_default_timezone_set('America/Lima');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ControllerReportesExcel
{
 /* //  Descargar todos los ingresos para el reporte exel de ingresos */
  public static function ctrDowlReportsExeIng()
  {
    if (isset($_GET["reporteExeIngresos"])) {
      $listAllDataExeIng = IngresosController::ctrGetAllDowlReportsExeIng();

      //  cell Titles
      $titleArray = ['#', 'CODIGO','RESPONSABLE', 'ESTADO', 'FECHA INGRESO', 'OBSERVACIÓN', 'PRODUCTO', 'CANTIDAD'];
      $dataArray = [];
      $spreadsheet = new Spreadsheet();
      $activeWorksheet = $spreadsheet->getActiveSheet();
      $activeWorksheet->fromArray($titleArray, null, 'A1');

      foreach ($listAllDataExeIng as $key => $value) {
        $data = array(
          $key + 1,
          $value["IdIng"],
          $value["FullNamePersonal"],
          $value["TipoEstado"],
          $value["FechaProduccionIng"],
          $value["DescripcionIng"],
          $value["Producto"],
          $value["Cantidad"],
        );
        //  Data  cell
        array_push($dataArray, $data);
      }
      $activeWorksheet->fromArray($dataArray, null, 'A2');
      $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }
  }
  /* fin */

   /* Report donwload excel Ingresos por fechas */
   public static function ctrDowlReportsExeIngFech($fechaInicio, $fechaFin)
   {
     if (isset($_GET["reporteIngPorFechas"])) {
       $listAllDataExeIngFech = IngresosController::ctrGetAllDowlReportsExeIngFech($fechaInicio, $fechaFin);
 
       //  cell Titles
       $titleArray = ['Nr Registro','RESPONSABLE', 'ESTADO', 'FECHA INGRESO', 'OBSERVACIÓN', 'PRODUCTOS', 'CANTIDAD','FECHA VENCIMIENTO'];
       $dataArray = [];
       $spreadsheet = new Spreadsheet();
       $activeWorksheet = $spreadsheet->getActiveSheet();
       $activeWorksheet->fromArray($titleArray, null, 'A1');
 
       foreach ($listAllDataExeIngFech as $value) {
         $data = array(
          $value["IdIng"],
           $value["NombrePerIdPer"],
           $value["TipoEstado"],
           $value["FechaProduccionIng"],
           $value["DescripcionIng"],
           $value["Producto"],
           $value["Cantidad"],
           $value["FechaVencimientoIng"],
         );
         //  Data  cell
         array_push($dataArray, $data);
       }
       $activeWorksheet->fromArray($dataArray, null, 'A2');
       $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       $writer = new Xlsx($spreadsheet);
       $writer->save('php://output');
     }
   }
   /* fin */

  //  Report donwload excel Almacen
  public static function ctrDowlReportsExeAlmacen()
  {
    if (isset($_GET["reporteExeAlmacen"])) {
      $listAllDataExeAlmacen = AlmacenController::ctrGetAllDowlReportsAlmacen();

      //  cell Titles
      $titleArray = ['CATEGORIA', 'MEDIDA', ' PRODUCTO', 'UNIDADES EN ALAMCEN'];
      $dataArray = [];
      $spreadsheet = new Spreadsheet();
      $activeWorksheet = $spreadsheet->getActiveSheet();
      $activeWorksheet->fromArray($titleArray, null, 'A1');

      foreach ($listAllDataExeAlmacen as $value) {
        $data = array(
         /*  $value["IdAlma"], */
          $value["NombreCategoria"],
          $value["Unidad"],
          $value["NombreProducto"],
          $value["CantidadTotal"],
        );
        //  Data  cell
        array_push($dataArray, $data);
      }
      $activeWorksheet->fromArray($dataArray, null, 'A2');
      $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }
  }
  /* fin */

  /*  Descargar todos las Notas para el reporte exel de Notas pedido */
  public static function ctrDowlReportsExeNotPe()
  {
    if (isset($_GET["reporteExeNotaPe"])) {
      $listAllDataExeNotPe = NotaPedidoController::ctrGetAllDowlReportsExeNotPe();
      //  cell Titles
      $titleArray = ['Nr Registro','RESPONSABLE', 'ESTADO', 'FECHA NOTA', 'CLIENTE', 'RUC', 'DIRRECCION','PRODUCTO', 'CANTIDAD', 'TOTAL PRODUCTO','TOTAL NOTA PEDIDO', 'VENDEDOR'];
      $dataArray = [];
      $spreadsheet = new Spreadsheet();
      $activeWorksheet = $spreadsheet->getActiveSheet();
      $activeWorksheet->fromArray($titleArray, null, 'A1');

      foreach ($listAllDataExeNotPe as $value) {
        $data = array(
         $value["IdNotaP"],
          $value["NombrePerIdRes"],
          $value["EstadoNota"],
          $value["FechaNotaPedido"],
          $value["NombreCliNota"],
          $value["RucCli"],
          $value["DireccionCliNota"],
          $value["Producto"],
          $value["Cantidad"],
          $value["TotalP"],
          $value["Total"],
          $value["NombrePerIdPer"],
        );
        //  Data  cell
        array_push($dataArray, $data);
      }
      $activeWorksheet->fromArray($dataArray, null, 'A2');
      $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }
  }
  /* fin */

 /* Reporte excel Notas por fechas  */
   public static function ctrDowlReportsExeNotPeFech($fechaInicioNot, $fechaFinNot)
   {
     if (isset($_GET["reporteExeNotaPeFech"])) {
       $listAllDataExeNotPeFech = NotaPedidoController::ctrGetAllDowlReportsExeNotPeFech($fechaInicioNot, $fechaFinNot);
 
       //  cell Titles
       $titleArray = ['Nr Registro','RESPONSABLE', 'ESTADO', 'FECHA NOTA', 'CLIENTE', 'RUC', 'DIRRECCION','PRODUCTO', 'CANTIDAD', 'TOTAL PRODUCTO', 'TOTAL NOTA PEDIDO', 'VENDEDOR'];
       $dataArray = [];
       $spreadsheet = new Spreadsheet();
       $activeWorksheet = $spreadsheet->getActiveSheet();
       $activeWorksheet->fromArray($titleArray, null, 'A1');
 
       foreach ($listAllDataExeNotPeFech as $value) {
        $data = array(
          $value["IdNotaP"],
           $value["NombrePerIdRes"],
           $value["EstadoNota"],
           $value["FechaNotaPedido"],
           $value["NombreCliNota"],
           $value["RucCli"],
           $value["DireccionCliNota"],
           $value["Producto"],
           $value["Cantidad"],
           $value["TotalP"],
           $value["Total"],
           $value["NombrePerIdPer"],
         );
         //  Data  cell
         array_push($dataArray, $data);
       }
       $activeWorksheet->fromArray($dataArray, null, 'A2');
       $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       $writer = new Xlsx($spreadsheet);
       $writer->save('php://output');
     }
   }
  /* fin */

  /*  Descargar todos los Lotes para el reporte exel de Lotes */
  public static function ctrDowlReportsExeLote()
  {
    if (isset($_GET["reporteExeLotes"])) {
      $listAllDataExeLote = LotesController::ctrGetAllDowlReportsExeLote();

      //  cell Titles
      $titleArray = ['Nr REGISTRO','RESPONSABLE', 'ESTADO', 'DESCRIPCION', 'CODIGO', 'FECHA LOTE','TIPO SALIDA','N° FACTURA','CLIENTE','RUC', 'PRODUCTO', 'CANTIDAD'];
      $dataArray = [];
      $spreadsheet = new Spreadsheet();
      $activeWorksheet = $spreadsheet->getActiveSheet();
      $activeWorksheet->fromArray($titleArray, null, 'A1');

      foreach ($listAllDataExeLote as $value) {
        $data = array(
          $value["IdLote"],
          $value["NombrePer"],
          $value["Estado"],
          $value["DescripcionLote"],
          $value["CodigoLote"],
          $value["FechaProduccionLote"],
          $value["TipoSalida"],
          $value["NroFactura"],
          $value["NombreCli"],
          $value["RucCli"],
          $value["Producto"],
          $value["Cantidad"],
        );
        //  Data  cell
        array_push($dataArray, $data);
      }
      $activeWorksheet->fromArray($dataArray, null, 'A2');
      $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
      $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }
  }
  /* fin */

   /* Reporte excel Lotes por fechas  */
   public static function ctrDowlReportsExeLoteFech($fechaInicioLt, $fechaFinLt)
   {
     if (isset($_GET["reporteExeLotesFech"])) {
       $listAllDataExeLoteFech = LotesController::ctrGetAllDowlReportsExeLoteFech($fechaInicioLt, $fechaFinLt);
 
       //  cell Titles
       $titleArray = ['Nr REGISTRO','RESPONSABLE', 'ESTADO', 'DESCRIPCION', 'CODIGO', 'FECHA LOTE','TIPO SALIDA','N° FACTURA','CLIENTE','RUC', 'PRODUCTO','CANTIDAD'];
       $dataArray = [];
       $spreadsheet = new Spreadsheet();
       $activeWorksheet = $spreadsheet->getActiveSheet();
       $activeWorksheet->fromArray($titleArray, null, 'A1');
 
       foreach ($listAllDataExeLoteFech as $value) {
         $data = array(
          $value["IdLote"],
          $value["NombrePer"],
          $value["Estado"],
          $value["DescripcionLote"],
          $value["CodigoLote"],
          $value["FechaProduccionLote"],
          $value["TipoSalida"],
          $value["NroFactura"],
          $value["NombreCli"],
          $value["RucCli"],
          $value["Producto"],
          $value["Cantidad"],
         );
         //  Data  cell
         array_push($dataArray, $data);
       }
       $activeWorksheet->fromArray($dataArray, null, 'A2');
       $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
       $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       $writer = new Xlsx($spreadsheet);
       $writer->save('php://output');
     }
   }
   /* fin */
}
