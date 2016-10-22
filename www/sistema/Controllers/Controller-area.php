<?php 
	session_start();
	require_once("../conecta.php");
	require_once("../../../Action/banco-area.php");

	if(isset($_POST["botaoArea"])){
		
		if($_POST["botaoArea"]=="Salvar" ){

			if(isset($_POST["nomeArea"])&&isset($_POST["idArea"])){

				$nome   = mysqli_real_escape_string($mysqli, $_POST["nomeArea"]);
				$idArea = mysqli_real_escape_string($mysqli, $_POST["idArea"]);

				alteraArea($mysqli,$idArea,"Salvar",$nome);

			}
			else{
				$_SESSION["Failed"] = "Os campos Passados não estão corretos. Por favor tente denovo!";
			}	

		}
		else if($_POST["botaoArea"]=="Excluir" ){

			if(isset($_POST["nomeArea"])&&isset($_POST["idArea"])){
				$nome   = mysqli_real_escape_string($mysqli, $_POST["nomeArea"]);
				$idArea = mysqli_real_escape_string($mysqli, $_POST["idArea"]);

				alteraArea($mysqli,$idArea,"Excluir",$nome);
			}
			else{
				$_SESSION["Failed"] = "Os campos Passados não estão corretos. Por favor tente denovo!";
			}

		}
		else if($_POST["botaoArea"]=="Adicionar"){

			if(isset($_POST["nomeArea"]) ){
				$nome   = mysqli_real_escape_string($mysqli, $_POST["nomeArea"]);
				insereArea($mysqli,$nome);
			}
			else{
				$_SESSION["Failed"] = "Os campos Passados não estão corretos. Por favor tente denovo!";
			}			

		}
		else{
			$_SESSION["Failed"] = "Os campos Passados não estão corretos. Por favor tente denovo!";
		}		

	}
	else{
		$_SESSION["Failed"] = "Os campos Passados não estão corretos. Por favor tente denovo!";
	}

	header("Location: ../administracao.php");


?>