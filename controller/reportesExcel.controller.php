<?php
date_default_timezone_set('America/Lima');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ControllerReportesExcel
{
  //  Report donwload excel Orders
  public static function ctrDowlReportsExeIng()
  {
    if (isset($_GET["reporteExeIngresos"])) {
      $listAllDataExeIng = IngresosController::ctrGetAllDowlReportsExeIng();

      //  cell Titles
      $titleArray = ['RESPONSABLE', 'ESTADO', 'FECHA INGRESO', 'OBSERVACIÓN', 'PRODUCTOS', 'FECHA VENCIMIENTO', 'FECHA REINGRESO', 'FECHA INGRESO MERMA'];
      $dataArray = [];
      $spreadsheet = new Spreadsheet();
      $activeWorksheet = $spreadsheet->getActiveSheet();
      $activeWorksheet->fromArray($titleArray, null, 'A1');

      foreach ($listAllDataExeIng as $value) {
        $data = array(
         /*  $value["IdIng"], */
          $value["NombrePerIdPer"],
          $value["TipoEstado"],
          $value["FechaProduccionIng"],
          $value["DescripcionIng"],
          $value["DatosProductosIngresoJson"],
          $value["FechaVencimientoIng"],
          $value["FechaReingresoIng"],
          $value["FechaMermaIng"],
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
}
