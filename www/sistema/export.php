<?php

require_once "conecta.php";
session_start();
$Numero 	= $_POST['numbAdd'];
$User 		= $_SESSION["sessioname"];
//echo "$Numero";
$query = mysqli_query($mysqli,"SELECT * FROM plano_de_atividades WHERE Numero='".$Numero."' AND User='".$User."'") or die(mysql_error());
$row = mysqli_fetch_assoc($query);

$Curso 		= utf8_decode($row['Curso']);
$Modalidade = $row['Modalidade'];
$Nome 		= utf8_decode($row['Nome']);
$Endereco 	= utf8_decode($row['Endereco']);
$Telefone 	= utf8_decode($row['Telefone']);
$Email 		= utf8_decode($row['Email']);

//<!-- Dados da Empresa -->

$Nome_Empresa 		= utf8_decode($row['Nome_Empresa']);
$Endereco_Empresa 	= utf8_decode($row['Endereco_Empresa']);
$Cidade_Empresa		= utf8_decode($row['Cidade_Empresa']);
$Estado_Empresa		= utf8_decode($row['Estado_Empresa']);
$CEP_Empresa		= utf8_decode($row['CEP_Empresa']);
$Telefone_Empresa 	= utf8_decode($row['Telefone_Empresa']);
$Ramal_Empresa		= utf8_decode($row['Ramal_Empresa']);
$Fax_Empresa		= utf8_decode($row['Fax_Empresa']);
$Email_Empresa 		= utf8_decode($row['Email_Empresa']);

//<!-- Dados do Supervisor -->

$Nome_Supervisor 		= utf8_decode($row['Nome_Supervisor']);
$Telefone_Supervisor 	= utf8_decode($row['Telefone_Supervisor']);
$Ramal_Supervisor		= utf8_decode($row['Ramal_Supervisor']);
$Fax_Supervisor			= utf8_decode($row['Fax_Supervisor']);
$Email_Supervisor 		= utf8_decode($row['Email_Supervisor']);





require 'Fpdf/fpdf.php';
define('FPDF_FONTPATH','font' );

class PDF extends FPDF
{
	// Page header
	function header(){

	}

	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    //$this->SetY(+15);

	    $this->Image('images/logo.png',30,270,-130,-130);
	}

}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->header('charset=ISO-8859-1');
$pdf->SetTitle("Text",1);
$pdf->SetMargins(25, 20 , 25 );
$pdf->AliasNbPages();
$pdf->AddPage();

// Arial bold 15
$pdf->SetFont('helvetica','B',18);
// Move to the right
$pdf->Cell(63);
// Title
$title = utf8_decode('Plano de Atividades Do Estágiario');
$pdf->Cell(30,0,$title,0,1,'C');
// Line break
$pdf->Ln(20);

$pdf->Rect(40,47,142,0.3,'F');

$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'Curso:   '.$Curso,0,0);
$pdf->Rect(27,30,155,0);
$pdf->Ln();
$pdf->Cell(60,5, utf8_decode('Modalidade do estágio:') );

if($Modalidade==1)
{
	$pdf->Cell(50,5,utf8_decode('Obrigatório'));
	$pdf->Image('images/checked.png',78,48,-1900,-1800);
	$pdf->Cell(50,5,utf8_decode('Não Obrigatório'));
	$pdf->Image('images/unchecked.png',128,48,-1900,-1800);
	$pdf->ln();
}
else
{
	$pdf->Cell(50,10,utf8_decode('Obrigatório'));
	$pdf->Image('images/unchecked.png',58,51,-1900,-1800);
	$pdf->Cell(50,10,utf8_decode('Não Obrigatório'));
	$pdf->Image('images/checked.png',108,51,-1900,-1800);
	$pdf->ln();
}

/*for($i=1;$i<=20;$i++)
    $pdf->Cell(0,10,'Printing line number '.$i,0,1);*/
$pdf->SetFont('Times','B',13);
$pdf->Cell(0,10, utf8_decode('01) Identificacao do Estagiário'),0,0);
$pdf->Ln();

$pdf->SetFont('Times','',12);
$pdf->SetLeftMargin(32);// Seta margem para subitem
$pdf->Cell(0,10,'Nome: '.$Nome,0,0);
$pdf->Rect(45,72,137,0.4,'F');// Reta do nome
$pdf->Ln();
$pdf->Rect(53,81.9,5,0.4,'F'); // reta do Telefone
$pdf->Rect(62,81.9,58,0.4,'F'); // reta do Telefone
$pdf->Cell(90,10,'Telefone: (       )  '.$Telefone,0,0);
$pdf->Cell(50,10,'E-mail: '.$Email,0,0);
$pdf->Rect(137,82,45,0.4,'F'); // reta do Email
$pdf->SetLeftMargin(25);// Define o estado normal da margem
$pdf->Ln();

$pdf->SetFont('Times','B',13);
$pdf->Cell(0,10,'02) Empresa',0,0);
$pdf->Ln();
$pdf->SetLeftMargin(32);// Seta margem para subitem
$pdf->SetFont('Times','',12);
$pdf->Rect(45,102,137,0.4,'F');// Reta do nome
$pdf->Cell(0,10,'Nome: '.$Nome_Empresa,0,0);
$pdf->Ln();
$pdf->Rect(53,111.9,5,0.4,'F'); // reta do Telefone
$pdf->Rect(62,111.9,58,0.4,'F'); // reta do Telefone
$pdf->Cell(90,10,'Telefone: (       )  '.$Telefone,0,0);
$pdf->Cell(50,10,'E-mail: '.$Email_Empresa,0,0);
$pdf->Rect(137,111.9,45,0.4,'F'); // reta do Email
$pdf->SetLeftMargin(25);// Define o estado normal da margem
$pdf->Ln();
$pdf->SetFont('Times','B',13);
$pdf->Cell(0,10,'03) Supervisor',0,0);
$pdf->SetLeftMargin(32);// Seta margem para subitem
$pdf->Ln();
$pdf->SetFont('Times','',12);
$pdf->Rect(45,132,137,0.4,'F');// Reta do nome
$pdf->Cell(0,10,utf8_decode('Nome: '.$Nome_Supervisor),0,0);
$pdf->Ln();
$pdf->Rect(53,141.9,5,0.4,'F'); // reta do Telefone
$pdf->Rect(62,141.9,58,0.4,'F'); // reta do Telefone
$pdf->Cell(90,10,'Telefone: (       )  '.$Telefone,0,0);
$pdf->Cell(0,10,'E-mail: '.$Email_Supervisor,0,0);
$pdf->Rect(137,141.9,45,0.4,'F'); // reta do Email
$pdf->Output();
$header = array('',utf8_decode('Área'),utf8_decode('Instituição'),utf8_decode('Conclusão') );
// Header
    foreach($header as $col)
        $pdf->Cell(0,7,$col,1);
    $pdf->Ln();
    // Data
    $data[][0]=['Graduação','Especialização','Mestrado','Doutorado','Pós-Doutorado'];
    foreach($data as $row)
    {
        foreach($row as $col)
            $pdf->Cell(40,6,$col,1);
        $pdf->Ln();
    }




?>