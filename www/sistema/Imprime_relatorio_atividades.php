<?php

require_once("conecta.php");
require_once("../../Action/funcoes-de-controle.php");

session_start();
   		 	 	 		
// Check se o aluno esta logado
	if(Check_Login_Status())
	{
		Update_Login_Status();
	}
	else
	{
		session_unset();
		$_SESSION["Failed"] = "ACESSO NEGADO";
		header("index.php");
		die();
	}

// Fim check


$id = $_POST['relatorio']; // pega id do doc
$idEstagio = $_POST['idEstagio'];// Pega id do estagio
$aluno 		= $_SESSION["id"]; //pega id do aluno

// Dados do Aluno

$dadosAluno = mysqli_query($mysqli,"SELECT * FROM usuarios WHERE Id_Usuario='".$aluno."'") or die(mysqli_error($mysqli));
$dadosAluno = mysqli_fetch_assoc($dadosAluno);

//Dados Curso

$stringCurso = mysqli_query($mysqli,"SELECT Nome FROM cursos WHERE Id_Curso='".$dadosAluno['Id_Curso']."'") or die(mysqli_error($mysqli));
$stringCurso = mysqli_fetch_assoc($stringCurso);


// Dados do estagio

$estagio = mysqli_query($mysqli,"SELECT * FROM estagio WHERE Id_Estagio='".$idEstagio."'") or die(mysqli_error($mysqli));
$estagio = mysqli_fetch_assoc($estagio);

// Dados Supervisor

$supervisor = mysqli_query($mysqli,"SELECT * FROM usuarios WHERE Id_Usuario='".$estagio['Id_Supervisor']."'") or die(mysqli_error($mysqli));
$supervisor 	= mysqli_fetch_assoc($supervisor);

// dados relatorio
$relatorio = mysqli_query($mysqli,"SELECT * FROM relatorio WHERE Id_Relatorio='".$id."' AND Id_Aluno='".$aluno."' AND Id_Estagio='".$idEstagio."'") or die(mysqli_error($mysqli));
$relatorio = mysqli_fetch_assoc($relatorio);

// Empresa
$empresa =  mysqli_query($mysqli,"SELECT * FROM empresa WHERE Id_Empresa='".$estagio['Id_Empresa']."'") or die(mysqli_error($mysqli));
$empresa = mysqli_fetch_assoc($empresa);


//Varias Variaveis 



$tiporelatorio = $relatorio['Tipo'];// Tipo relatorio 
$Modalidade = $estagio['Modalidade']; // Modalidade do estagio
$Curso 		= utf8_decode($stringCurso['Nome'] ); // Curso
$Nome 		= $dadosAluno['Nome_Completo']; // Nome
$Email 		= utf8_decode($dadosAluno['Email']); // Email
$inicio = $relatorio['Data_Inicio']; // inicio
$fim = $relatorio['Data_Fim']; // fim do relatorio
$avaliacao = $relatorio['Avaliacao'];

require 'Fpdf/fpdf.php';
define('FPDF_FONTPATH','font' );

class PDF extends FPDF
{
	// Page header
	function header(){
		$this->Image('images/logo.png',30,3,-130,-130);
	}

	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    //$this->SetY(+15);

	   // $this->Image('images/logo.png',30,270,-130,-130);
	}

}


// Instanciation of inherited class
$pdf = new PDF();
$pdf->header('charset=ISO-8859-1');
$pdf->SetTitle("Text",1);
$pdf->SetMargins(25, 28 , 25 );
$pdf->AliasNbPages();
$pdf->AddPage();

// Arial bold 15
$pdf->SetFont('helvetica','B',18);
// Move to the right
$pdf->Cell(63);
// Title
$title = utf8_decode('Relatório de Atividades de Estágio');
$pdf->Cell(30,0,$title,0,1,'C');
// Line break
$pdf->Ln(7);

$pdf->SetFont('Arial','',10);

if($Modalidade==1)
{
	$pdf->Cell(47,7,utf8_decode('          Estágio obrigatório'), 'LTB',0);
	$pdf->Cell(43,7,utf8_decode('Estágio não obrigatório'), 'RTB',0,'C');
	$pdf->Image('images/checked.png',28,35,-2200,-2200);
	$pdf->Image('images/unchecked.png',69,35,-2200,-2200);
}
else
{
	$pdf->Cell(47,7,utf8_decode('          Estágio obrigatório'), 'LTB',0);
	$pdf->Cell(43,7,utf8_decode('Estágio não obrigatório'), 'RTB',0,'C');
	$pdf->Image('images/unchecked.png',28,35,-2200,-2200);
	$pdf->Image('images/checked.png',69,35,-2200,-2200);
}


if($tiporelatorio==1)
{
	$pdf->Cell(41,7,utf8_decode('         Relatório parcial'), 'LTB',0);
	$pdf->Cell(0,7,utf8_decode('Relatório final'), 'RTB',1,'C');
	$pdf->Image('images/unchecked.png',118,35,-2200,-2200);
	$pdf->Image('images/checked.png',154,35,-2200,-2200);
}
else
{
	$pdf->Cell(41,7,utf8_decode('         Relatório parcial'), 'LTB',0);
	$pdf->Cell(0,7,utf8_decode('Relatório final'), 'RTB',1,'C');
	$pdf->Image('images/checked.png',118,35,-2200,-2200);
	$pdf->Image('images/unchecked.png',154,35,-2200,-2200);
}

$Nome_Empresa = $empresa['Nome'];
$Nome_Supervisor = $supervisor['Nome_Completo'];
$Curso 		= $stringCurso['Nome'];


$pdf->Cell(0,6,utf8_decode(' Estagiário(a): '.$Nome), 'RLB',1);
$pdf->Cell(0,6,utf8_decode(' Email: '.$Email), 'RLB',1);
$pdf->Cell(0,6,utf8_decode(' Curso: '.$Curso ), 'RLB',1);
$pdf->Cell(0,6,utf8_decode(' Empresa: '.$Nome_Empresa), 'RLB',1);
$pdf->Cell(0,6,utf8_decode(' Supervisor: '.$Nome_Supervisor), 'RLB',1);
$pdf->Cell(0,6,utf8_decode(' Período a que se refere este relatório: '.imprimeData($inicio).' a '.imprimeData($fim)), 'RLB',1);
$pdf->Ln(4);
$pdf->Cell(0,6, utf8_decode( ' Atividades desenvolvidas:') , 'TRL',1);
$pdf->MultiCell(0,4.5,utf8_decode($relatorio['Atividades']),'RL', 'J' );

$tam = ceil(strlen($relatorio['Atividades'])/80);

for($i=$tam;$i < 6; $i++){
	$pdf->Cell(0,5, utf8_decode( '') , 'RL',1);
}

$pdf->Cell(0,0, utf8_decode( '') , 'B',1);
$pdf->Ln(4);
$pdf->Cell(0,6, utf8_decode( ' Comentários e dificuldades do(a) estagiário(a):') , 'TRL',1);

#echo ceil( strlen($relatorio['Comentario_Aluno'])/80 );

$tam = ceil( strlen($relatorio['Comentario_Aluno'])/80 );

$pdf->MultiCell(0,5,utf8_decode($relatorio['Comentario_Aluno']),'RL', 'J' );

for($i= $tam;$i < 4; $i++){
	$pdf->Cell(0,5, utf8_decode( '') , 'RL',1);
}

$pdf->Cell(0,0, utf8_decode( '') , 'B',1);
$pdf->Ln(4);
$pdf->Cell(0,2,utf8_decode(' Avaliação pelo supervisor do estágio:'), 0,1);
$pdf->Ln(4);

$Aspectos = array('Aspectos', utf8_decode('Ótimo'),'Bom','Ruim','Insuficiente' );

$pdf->SetFont('Arial','B',9);

for($i = 0; $i < 5; $i++ ){
	$pdf->Cell(32,3.5,$Aspectos[$i], 1,0,'C');
}
$pdf->Ln(); 
$pdf->SetFont('Arial','',9);

$coluna = array(' Assiduidade' ,' Disciplina' , utf8_decode(' Cooperação' ), utf8_decode(' Produção' ), ' Iniciativa' ,utf8_decode(' Assimilação' ),' Conhecimentos' ,' Responsabilidade' ,utf8_decode(' Dedicação' ),utf8_decode(' Organização' ) );

for($i = 0; $i < 10; $i++ ){
	
	$pdf->Cell(32,5,$coluna[$i], 1,0,'L');

	for($f = 0; $f < 4; $f++ ){
		if($avaliacao[$i]==$f){
			//$pdf->Image('images/checked.png',72+(32*$f),166.5+(5*$i),-3000,-3000);
			$pdf->Cell(32,5, $pdf->Image('images/checked.png',$pdf->GetX()+15,$pdf->GetY(),-3000,-3000), 1,0);
		}
		else{
			$pdf->Cell(32,5, $pdf->Image('images/unchecked.png',$pdf->GetX()+15,$pdf->GetY(),-3000,-3000), 1,0);
			//$pdf->Image('images/unchecked.png',72+(32*$f),166.5+(5*$i),-3000,-3000);
		}
		
	}

	$pdf->Ln(); 
}
$pdf->Ln(4);

$pdf->Cell(0,6, utf8_decode( ' Outras observações sobre o desempenho do(a) estagiário(a):') , 'TRL',1);
$pdf->MultiCell(0,4,utf8_decode($relatorio['Observacao']),'RL', 'J' );

$tam = ceil( strlen($relatorio['Observacao'])/80 );
if($tam==0){
	$tam = 1;
}

for($i=$tam;$i < 3; $i++){
	$pdf->Cell(0,4, utf8_decode( '') , 'RL',1);
}

$pdf->Cell(0,0, utf8_decode( '') , 'B',1);
$pdf->Ln(4);
$pdf->Cell(0,2,utf8_decode(' Data: ____/____/____ '), 0,1);
$pdf->Ln(13);
$pdf->Cell(0,2,utf8_decode('  ___________________________________________      ___________________________________________'), 0,1);
$pdf->Cell(100,6, utf8_decode( '                      Assinatura do(a) estagiário(a)') , 0,0 );
$pdf->Cell(45,6, utf8_decode( '   Assinatura do supervisor') , 0,1);
$pdf->Output();

?>