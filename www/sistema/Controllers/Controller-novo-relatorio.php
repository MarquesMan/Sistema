<?php 
	session_start();
	require_once("../conecta.php");
	require_once("../../../Action/banco-relatorios.php");

		$Numero = $_SESSION["id"];
		$idEstagio = $_POST['idEstagio'];

	if(		
		isset($_POST['idEstagio'])&&
		isset($_POST['tiporelatorio'])&&
		isset($_POST['datainicial'])&&
		isset($_POST['datafinal'])&&
		isset($_POST['atividades'])&&
		isset($_POST['comaluno'])
		){


		$Numero = $_SESSION["id"];
		$idEstagio = $_POST['idEstagio'];

		$tiporelatorio 	= $_POST['tiporelatorio'];
		$DataInicial 	= DateTime::createFromFormat('d/m/Y', $_POST['datainicial']);
		//$datainicial 	= mysqli_real_escape_string($mysqli,  $_POST['datainicial']);
		$DataFinal 		= DateTime::createFromFormat('d/m/Y', $_POST['datafinal']);
		//$datafinal 	= mysqli_real_escape_string($mysqli,  $_POST['datafinal']);
		$atividades 	= mysqli_real_escape_string($mysqli,  $_POST['atividades']);
		$comaluno 		= mysqli_real_escape_string($mysqli,  $_POST['comaluno']);

		InsereRelatorio($mysqli, $Numero, $idEstagio, $tiporelatorio, $DataInicial, $DataFinal, $atividades, $comaluno);
		header("Location:../documentos-estagio.php?idEstagio=".$_POST['idEstagio']."#relatorios"); /* Redirect browser */

	}else{
		$_SESSION["Failed"] = "Paramêtros incorretos.";
		header("Location:../documentos-estagio.php?idEstagio=".$_POST['idEstagio']."#relatorios"); /* Redirect browser */
	}

?>