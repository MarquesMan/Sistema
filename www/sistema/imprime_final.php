<?php

require_once "conecta.php";
session_start();
   		 	 	 		

//<!-- Dados da Empresa -->
				 			 		

//<!-- Dados do Supervisor -->'



require 'Fpdf/fpdf.php';
define('FPDF_FONTPATH', 'font');

class PDF extends FPDF
{

}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->SetTitle("Text",1);
$pdf->SetMargins(25, 20 , 25 );
$pdf->AliasNbPages();
$pdf->AddFont('Verdana', 'B', 'verdanab.php');
$pdf->AddPage();

// Arial bold 15
$pdf->SetFont('Verdana','B',18);
// Move to the right
$pdf->Cell(63);
// Title
$title = utf8_decode('Declaração Final de Atividades de Estágio');
$pdf->Cell(30,0,$title,0,1,'C');
// Line break
$pdf->Ln(20);

$pdf->Rect(27,30,150,0);

$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,utf8_decode('Declaramos para os devidos fins que o(a) acadêmico(a) _[nome do acadêmico]_, do curso '),0,0);
$pdf->Ln();
$pdf->Cell(0,10,utf8_decode('_[nome do curso]_, da Faculdade de Computação da Universidade Federal de Mato Grosso'),0,0);
$pdf->Ln();
$pdf->Cell(0,10,utf8_decode('do Sul, cumpriu _[quantidade de horas]_ horas de estágio no período de _[data de início]_'),0,0);
$pdf->Ln();
$pdf->Cell(0,10,utf8_decode('a _[data final]_, na _[nome da empresa/instuição onde foi realizado o estágio]_, na área de'),0,0);
$pdf->Ln();
$pdf->Cell(0,10,utf8_decode('_[área do estágio]_, onde, supervisionado por _[nome do supervisor]_, desenvolveu as'),0,0);
$pdf->Ln();
$pdf->Cell(0,10,utf8_decode('seguintes atividades:'),0,0);
$pdf->Ln(100);




$pdf->Cell(65, 10, 'Local',0,0, 'C');
$pdf->Cell(115, 10, 'Data',0,0, 'C');
$pdf->Ln(25);
$pdf->Cell(0, 10, utf8_decode('Assinatura e carimbo do Responsável'),0,0);

$pdf->SetLineWidth(0.4);
$pdf->Line(26, 108, 180, 108);
$pdf->Line(26, 116, 180, 116);
$pdf->Line(26, 124, 180, 124);
$pdf->Line(26, 132, 180, 132);
$pdf->Line(26, 140, 180, 140);
$pdf->Line(26, 148, 180, 148);
$pdf->Line(26, 156, 180, 156);
$pdf->Line(26, 164, 180, 164);

$pdf->SetLineWidth(0.2);
$pdf->Line(26, 190, 90, 190);
$pdf->Line(116, 190, 180, 190);
$pdf->Line(26, 215, 90, 215);


/*for($i=1;$i<=20;$i++)
    $pdf->Cell(0,10,'Printing line number '.$i,0,1);*/
$pdf->Output();

?>