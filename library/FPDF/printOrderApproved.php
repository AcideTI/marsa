<?php
//  Controladores
require_once "../../controller/notaPedido.controller.php";

//  Modelos

require_once "../../model/notaPedido.model.php";

require('tfpdf.php');

//  Historia en PDF
class PDFOrder extends TFPDF
{
  // Header
  function Header()
  {
    // Logo
    $this->Image('../../view/img/background.png', 10 , 8, 35);
    $this->Image('../../view/img/logo-cariluis.png', 155, 10, 45);

    $this->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);

    //  Title
    $this->Ln(15);
    $this->SetFont('Arial', 'B', 16);
    $this->SetTextColor(64, 7, 12);

    $this->Ln(10);
    $this->Cell(0, 10, utf8_decode('DETALLE DE PEDIDO'), 0, 0, 'C');

    $this->Ln(15);
  }

  // Footer
  function Footer()
  {
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
    $this->SetFont('DejaVu', '', 8);
    // Número de página
    $this->Cell(0, 8, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'L');
    $this->Cell(0, 8, 'Textil Cariluis', 0, 0, 'R');
  }

  function TableDetailOrder($header, $detailList)
  {
    $this->SetFont('Arial', 'B', 12);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(100,8,$header[0],0,0,'C'); 
    $this->Cell(40,8,$header[1],0,0,'C'); 
    $this->Cell(40,8,$header[2],0,0,'C'); 

    foreach($detailList as $value)
    {
      $this->SetFont('DejaVu', '', 12);
      $this->SetTextColor(0, 0, 0);
      $this->Ln();
      $this->Cell(118,5,$value["DescriptionModel"],0);
      $this->Cell(22,5,$value["SizeModel"],0);
      $this->Cell(40,5,$value["ColorModel"],0);
    }
  }
}
$codNotaPe = $_GET["codNotaPe"];

$dataHeader = NotaPedidoController::ctrGetAllPrintPDFNotPe($codNotaPe);


/* $dataDetail = OrdersController::ctrGetDetailOrderPrint($codOrder); */

//  New Order
$pdf = new PDFOrder();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);

$pdf->SetFillColor(64, 7, 12);
$pdf->Cell(190, 4, '', 0, 1, 'L', true);


$pdf->SetTextColor(64, 7, 12);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(80, 10, 'Datos Generales del Cliente', 0, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 8, 'Cliente:', 0);
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(80, 8, $dataHeader["NameClient"], 0);

$pdf->Ln(8);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(43, 8, 'Detalle del Pedido:', 0);
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(77, 8, $dataHeader["DetailOrder"], 0);

$pdf->Ln(8);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 8, 'Fecha de Pedido:', 0);
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(35, 8, $dataHeader["DateOrder"], 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 8, 'Fecha de Entrega:', 0);
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(35, 8, $dataHeader["DateEnd"], 0);


$pdf->Ln(8);

$pdf->SetFillColor(64, 7, 12);
$pdf->Cell(190, 4, '', 0, 1, 'L', true);

$pdf->Ln(8);


$header=array('Descripcion','Talla','Color');
$pdf->TableDetailOrder($header, $dataDetail);

$pdf->Ln(16);

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(64, 7, 12);
$pdf->Cell(175, 8, 'SubTotal', 0, 0, 'R');
$pdf->Ln(8);
$pdf->Cell(175, 8, '(S/.) ' . $dataHeader["SubTotal"], 0, 0, 'R');
$pdf->Cell(175, 8, 'IGV', 0, 0, 'R');
$pdf->Ln(8);
$pdf->Cell(175, 8, '(S/.) ' . $dataHeader["IGV"], 0, 0, 'R');
$pdf->Cell(175, 8, 'Total', 0, 0, 'R');
$pdf->Ln(8);
$pdf->Cell(175, 8, '(S/.) ' . $dataHeader["TotalOrder"], 0, 0, 'R');

$pdf->Output();

