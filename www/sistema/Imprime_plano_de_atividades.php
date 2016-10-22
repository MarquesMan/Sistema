<?php

require_once "conecta.php";
require_once("../../Action/funcoes-de-controle.php");
require_once("../../Action/banco-area.php");
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

$id =        mysqli_real_escape_string($mysqli, $_POST['plano']); // pega id do doc
$idEstagio = mysqli_real_escape_string($mysqli,$_POST['idEstagio']); // Pega id do estagio
$aluno 	=    mysqli_query($mysqli,"SELECT Id_Aluno FROM estagio WHERE Id_Estagio='".$idEstagio."'") or die(mysqli_error($mysqli));
$aluno 	=    mysqli_fetch_assoc($aluno);
$aluno 	=    $aluno['Id_Aluno'];

$dadosAluno = mysqli_query($mysqli,"SELECT * FROM usuarios WHERE Id_Usuario='".$aluno."'") or die(mysqli_error($mysqli));
$dadosAluno = mysqli_fetch_assoc($dadosAluno);

$stringCurso = mysqli_query($mysqli,"SELECT Nome FROM cursos WHERE Id_Curso='".$dadosAluno['Id_Curso']."'") or die(mysqli_error($mysqli));
$stringCurso = mysqli_fetch_assoc($stringCurso);
$plano = mysqli_query($mysqli,"SELECT * FROM plano_de_atividades WHERE Id_Plano_De_Atividades='".$id."' AND Id_Aluno='".$aluno."' AND id_estagio='".$idEstagio."'") or die(mysqli_error($mysqli));
$plano = mysqli_fetch_assoc($plano);



$estagio = mysqli_query($mysqli,"SELECT * FROM estagio WHERE Id_Estagio='".$idEstagio."'") or die(mysqli_error($mysqli));
$estagio = mysqli_fetch_assoc($estagio);

$empresa =  mysqli_query($mysqli,"SELECT * FROM empresa WHERE Id_Empresa='".$estagio['Id_Empresa']."'") or die(mysqli_error($mysqli));
$empresa = mysqli_fetch_assoc($empresa);

$supervisor = mysqli_query($mysqli,"SELECT * FROM usuarios WHERE Id_Usuario='".$estagio['Id_Supervisor']."'") or die(mysqli_error($mysqli));
$supervisor 	= mysqli_fetch_assoc($supervisor);

$Modalidade = $estagio['Modalidade'];

$atividades = $plano['Descricao'];

$Curso 		= utf8_decode($stringCurso['Nome'] ); // Curso
$Nome 		= utf8_decode($dadosAluno['Nome_Completo']);
$Telefone 	= utf8_decode($dadosAluno['Telefone']);
$Email 		= utf8_decode($dadosAluno['Email']);
$carga 		= $plano['Carga_Horaria'];
$horarios 	= explode(";", $plano['Horario']);

//<!-- Dados da Empresa -->

$Nome_Empresa 		= utf8_decode($empresa['Nome']);
$Telefone_Empresa 	= utf8_decode($empresa['Telefone']);
$Email_Empresa 		= utf8_decode($empresa['Email']);

//<!-- Dados do Supervisor -->

$Nome_Supervisor 		= utf8_decode($supervisor['Nome_Completo']);
$Telefone_Supervisor 	= utf8_decode($supervisor['Telefone']);
$Email_Supervisor 		= utf8_decode($supervisor['Email']);


$areas = GetAreaById($mysqli,5);
$areas = $areas[0]['Nome'];


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
$pdf->Ln(17);

$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'Curso:   '.$Curso,0,0);
$pdf->Rect(27,30,155,0);
$pdf->Ln();
$pdf->Cell(60,5, utf8_decode('Modalidade do estágio:') );

if($Modalidade==1)
{
	$pdf->Cell(50,5,utf8_decode('Obrigatório'));
	$pdf->Image('images/checked.png',78,45,-1900,-1800);
	$pdf->Cell(50,5,utf8_decode('Não Obrigatório'));
	$pdf->Image('images/unchecked.png',128,45,-1900,-1800);
	$pdf->ln();
}
else
{
	$pdf->Cell(50,5,utf8_decode('Obrigatório'));
	$pdf->Image('images/unchecked.png',78,45,-1900,-1800);
	$pdf->Cell(50,5,utf8_decode('Não Obrigatório'));
	$pdf->Image('images/checked.png',128,45,-1900,-1800);
	$pdf->ln();
}
$pdf->Ln();

/*for($i=1;$i<=20;$i++)
    $pdf->Cell(0,10,'Printing line number '.$i,0,1);*/
$pdf->SetFont('Times','B',13);
$pdf->Cell(0,10, utf8_decode('01) Identificacao do Estagiário'),0,0);
$pdf->Ln();

$pdf->SetFont('Times','',12);
$pdf->SetLeftMargin(32);// Seta margem para subitem
$pdf->Cell(0,10,'Nome: '.$Nome,0,0);

$pdf->Ln();


$pdf->Cell(90,10,'Telefone: ('.substr($Telefone,1,2).') '.substr($Telefone,3,4).'-'.substr($Telefone,7),0,0);
$pdf->Ln();
$pdf->Cell(50,10,'E-mail: '.$Email,0,0);

$pdf->SetLeftMargin(25);// Define o estado normal da margem
$pdf->Ln();



$pdf->SetFont('Times','B',13);
$pdf->Cell(0,10,'02) Empresa',0,0);
$pdf->Ln();
$pdf->SetLeftMargin(32);// Seta margem para subitem
$pdf->SetFont('Times','',12);

$pdf->Cell(0,10,'Nome: '.$Nome_Empresa,0,0);
$pdf->Ln();


$pdf->Cell(90,10,'Telefone: ('.substr($Telefone_Empresa,1,2).') '.substr($Telefone_Empresa,3,4).'-'.substr($Telefone_Empresa,7),0,0);
$pdf->Ln();
$pdf->Cell(50,10,'E-mail: '.$Email_Empresa,0,0);

$pdf->SetLeftMargin(25);// Define o estado normal da margem
$pdf->Ln();
$pdf->SetFont('Times','B',13);
$pdf->Cell(0,10,'03) Supervisor',0,0);
$pdf->SetLeftMargin(32);// Seta margem para subitem
$pdf->Ln();
$pdf->SetFont('Times','',12);

$pdf->Cell(0,10,'Nome: '.$Nome_Supervisor,0,0);
$pdf->Ln();


$pdf->Cell(90,10,'Telefone: ('.substr($Telefone_Supervisor,1,2).') '.substr($Telefone_Supervisor,3,4).'-'.substr($Telefone_Supervisor,7),0,0);
$pdf->Ln();
$pdf->Cell(0,10,'E-mail: '.$Email_Supervisor,0,1);


$header = array(utf8_decode('Graduação'),utf8_decode('Especialização'),utf8_decode('Mestrado'),utf8_decode('Doutorado'),utf8_decode('Pós-Doutorado') );
// Header

$dias = array('Segunda-Feira ','Terça-Feira      ','Quarta-Feira  ','Quinta-Feira  ','Sexta-Feira   ', 'Sábado        ' );

$pdf->SetFillColor(214,214,214);

$pdf->SetFont('Times','B',12);
$pdf->SetLeftMargin(24);// Seta margem para subitem
$pdf->Ln(0.8);
$pdf->Cell(0,7,utf8_decode('Formação Acadêmica'),0,1);
$pdf->SetFont('Times','B',10);
$pdf->SetLineWidth(.1);
$pdf->Cell(25,10,' ',1,0,'',1);
$pdf->Cell(76,10,utf8_decode('Área'),1,0,'C',1);
$pdf->Cell(36,10,utf8_decode('Instituição'),1,0,'C',1);
$pdf->Cell(25,10,utf8_decode('Conclusão'),1,0,'C',1);
$pdf->SetFont('Times','',10);
$pdf->Ln();

    // Data
    foreach($header as $row)
    {
    	$pdf->Cell(25,10,$row,1,0,'',1);
        $pdf->Cell(76,10,' ',1,0,'C',0);
        $pdf->Cell(36,10,' ',1,0,'C',0);
       	$pdf->Cell(25,10,' ',1,0,'C',0);
        $pdf->Ln();
    }

$pdf->AddPage();
$pdf->SetLeftMargin(25);// Seta margem para subitem
$pdf->SetFont('Times','B',13);
$pdf->Cell(0,10,utf8_decode('04) Dados sobre o Estágio'),0,0);
$pdf->SetLeftMargin(32);// Seta margem para subitem
$pdf->Ln();
$pdf->SetFont('Times','',12);
$pdf->Cell(85,10, utf8_decode('  Área: '.$areas),0,1);

$aux = explode(":", $carga);

if($aux[1]=="00"){
	$pdf->Cell(0,10, utf8_decode('Carga Horária Total Prevista: '.$carga[0]." Horas"),0,1);
}
else{
	$pdf->Cell(0,10, utf8_decode('Carga Horária Total Prevista: '.$carga),0,1);
}

$pdf->Cell(0,10, utf8_decode('  Duração Prevista             Início:  '.imprimeData($estagio['Data_Inicio']).'                  Término:  '.imprimeData($estagio['Data_Fim'])),0,1);
$pdf->Cell(0,10, utf8_decode('Horário do Estágio (Máximo de 6 Horas Diária):'),0,0);
$pdf->Ln();
	
	for($i = 0; $i < 12; $i = $i+2 ){
		$pdf->Cell(28,8, utf8_decode($dias[$i/2]),0,0);
		if($horarios[$i]!=""){
			$pdf->Cell(0,8, utf8_decode('das '.$horarios[$i].' às '.$horarios[$i+1]) ,0,0);
		}else{
			$pdf->Cell(0,8, utf8_decode('das '."__:__".' às '."__:__") ,0,0);
		}
		if($i==5){
			$pdf->SetLeftMargin(25);// Define o estado normal da margem
		}	
		$pdf->Ln();
	}

$pdf->SetFont('Times','B',13);
$pdf->Cell(0,10,utf8_decode('05) Descreva em detalhes as atividades que serão desenvolvidas'),0,0);
$pdf->SetLeftMargin(32);// Seta margem para subitem
$pdf->Ln();
$pdf->SetFont('Times','',12);


	$pdf->MultiCell(0,7, utf8_decode($plano['Descricao']) ,0 ,'J');
	$pdf->SetLeftMargin(25);// Define o estado normal da margem
	$pdf->Ln();

	for( $i = strlen($plano['Descricao'])/71 ; $i<=7; $i++ ){
		$pdf->Ln();		
	}


$dataReal = explode(' ',$plano['Hora_Do_Envio']);

$pdf->Cell(69,6,utf8_decode( $plano['Local'] ),'B',0,'C');
$pdf->Cell(20,6,'',0,0);
$pdf->Cell(69,6,utf8_decode( imprimeData($dataReal[0]) ),'B',1,'C');
$pdf->SetFont('Times','B',12);
$pdf->Cell(69,6,utf8_decode( "Local" ),0,0);
$pdf->Cell(20,6,'',0,0);
$pdf->Cell(69,6,utf8_decode( "Data" ),0,1,'R');
$pdf->SetFont('Times','',12);
$pdf->Ln();
$pdf->Cell(69,6,utf8_decode( '' ),'B',0);
$pdf->Cell(20,6,'',0,0);
$pdf->Cell(69,6,utf8_decode( '' ),'B',1);
$pdf->SetFont('Times','B',12);
$pdf->Cell(69,6,utf8_decode( "Estágiario" ),0,0);
$pdf->Cell(20,6,'',0,0);
$pdf->Cell(69,6,utf8_decode( "Supervisor" ),0,1,'R');
$pdf->SetFont('Times','',12);
$pdf->Ln();
$pdf->SetFont('Times','B',12);
$pdf->Cell(0,6,utf8_decode( "Parecer da COE:" ),'TLR',1);
$pdf->Cell(74,8,utf8_decode( "Campo Grande-MS,  ____/____/____" ), 'L' ,0);
$pdf->Cell(0,8,'_______________________________________', 'R',1);
$pdf->Cell(74,4,utf8_decode( "" ), 'L' ,0);
$pdf->Cell(0,4,utf8_decode( "Orientador/Presidente da COE/Facom" ), 'R' ,1, 'C');
$pdf->Cell(0,2,'','RLB',0);
$pdf->SetFont('Times','',12);
$pdf->Ln();


$pdf->Output();

?>