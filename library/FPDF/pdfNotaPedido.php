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
    $this->Image('../../view/img/head-pdf-marsa.png', 10, 1, 190); // Logo de AGROINDUSTRIAS MARSA
    $this->Ln(15);
    $this->Ln(5);
   // Titulo centrado al logo
   $this->SetFont('Arial', 'B', 14);
   $this->SetX(10); // Mover el cursor a la misma distancia que el logo
   $this->Cell(0, 10, 'NOTA DE PEDIDO', 0, 1, 'C');

    
  }


  // Footer
  function Footer()
  {
    $this->SetY(-15);
    // Arial italic 8
    $this->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
    $this->SetFont('DejaVu', '', 8);
    $this->Cell(0, 8, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'L');
    $this->Cell(0, 8, 'Agroindustrias Marsa', 0, 0, 'R');
  }

  function TableDetailOrder($header, $detailList)
  {
    //$header=array('Nr','Descripcion','Und','P.U.','Cantidad','Total');
    $this->SetFont('Arial', 'B', 11);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(10,8,$header[0],0,0,'C'); 
    $this->Cell(115,8,$header[1],0,0,'C');
    //$this->Cell(15,8,$header[2],0,0,'C'); 
    $this->Cell(20,8,$header[3],0,0,'C'); 
    $this->Cell(20,8,$header[4],0,0,'C');
    $this->Cell(30 ,8,$header[5],0,0,'C');

    $count = 1; // Contador de productos
    foreach($detailList as $value)
    {
      $this->SetFont('DejaVu', '', 11);
      $this->SetTextColor(0, 0, 0);
      $this->Ln();
      $this->Cell(10,5,$count,0, 0, 'C'); // Número de producto
      $this->Cell(115,5,$value["Producto"],0, 0, 'L'); // Alinear a la izquierda
      //$this->Cell(15,5,$value["UnidadM"],0, 0, 'C'); // Alinear a la izquierda
      $this->Cell(20,5,$value["Cantidad"],0, 0, 'C'); // Alinear a la izquierda
      $this->Cell(20,5,'S/.'.' '.number_format($value["PrecioUnitario"], 2),0, 0, 'C'); // Alinear a la derecha

      $this->Cell(30,5,'S/.'.' '.$value["Total"],0, 0, 'C'); // Alinear a la derecha el total
      $x = $this->GetX();
      $y = $this->GetY();
      $this->SetDrawColor(200, 200, 200); 
      $this->SetLineWidth(0.2);
      $this->Line(10, $y+5, 210-10, $y+5);
      $this->SetDrawColor(0, 0, 0);
      $this->SetLineWidth(0.2);
      $this->Ln(2);

      $count++; // Incrementar el contador de productos
    }
  }
}
$codNotaPe = $_GET["codNotaPe"];

$dataHeader = NotaPedidoController::ctrGetAllPrintPDFNotPe($codNotaPe);
$dataDetail = NotaPedidoController::procesarJsonPDF($dataHeader);


//  New Order
$pdf = new PDFOrder();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);

$pdf->SetDrawColor(64, 7, 12); // Cambiar el color de dibujo
$pdf->SetLineWidth(0.2); // Cambiar el ancho de la línea
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Dibujar una línea

$pdf->Ln(5);

$pdf->SetTextColor(64, 7, 12);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(80, 10, 'Datos del Cliente', 0, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(12, 8, 'Ruc :', 0);
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(0, 8, $dataHeader["RucCli"], 0);

$pdf->Ln(8);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(18, 8, 'Cliente :', 0);
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(0, 8, $dataHeader["NombreCliNota"], 0);
$pdf->SetFont('Arial', 'B', 12);

$pdf->Ln(8);
$pdf->Cell(23, 8, 'Direccion :', 0);
$pdf->SetFont('DejaVu', '', 12);
$pdf->MultiCell(0, 8, $dataHeader["DireccionCliNota"], 0);

//$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 8, 'Fecha de Pedido:', 0);
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(35, 8, $dataHeader["FechaNotaPedido"], 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 8, 'Fecha de Entrega:', 0);
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(35, 8, $dataHeader["FechaNotaPedido"], 0);


$pdf->Ln(8);

$pdf->SetDrawColor(64, 7, 12); // Cambiar el color de dibujo
$pdf->SetLineWidth(0.2); // Cambiar el ancho de la línea
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Dibujar una línea
$pdf->Ln(8);


$header=array('Nr','Descripcion','Und','Cantidad','P.U.','Total');
$pdf->TableDetailOrder($header, $dataDetail);

$pdf->Ln(16);

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(64, 7, 12);
$pdf->Cell(187, 8, 'TOTAL', 0, 0, 'R');
$pdf->Ln(8);
$pdf->Cell(187, 8, 'S/. ' . $dataHeader["Total"], 0, 0, 'R');

$pdf->Output();

