<?php 
	session_start();
	require_once("../conecta.php");
	require_once("../../../Action/banco-usuarios.php");
	require_once("../../../Action/banco-empresa.php");

	if(isset($_POST["tipo-cadastro"],$_POST["id"],$_POST["tipo-decisao"]) ){

		$id = mysqli_real_escape_string($mysqli, $_POST["id"]);

		if($_POST["tipo-cadastro"] == "empresa"){

			if ($_POST["tipo-decisao"] == "Aceitar"){
				AprovaCadastroEmpresa($mysqli, $id);
			}

			elseif ($_POST["tipo-decisao"] == "Recusar" AND isset($_POST["comentario"])){
				$observacao = mysqli_real_escape_string($mysqli, $_POST["comentario"]);
				RemoveEmpresa($mysqli, $id, $observacao);
			}else{
				$_SESSION["Failed"] = "Os campos Passados não estão corretos. Por favor tente de novo!";
			}
		}

		elseif ($_POST["tipo-cadastro"] == "aluno") {

			if ($_POST["tipo-decisao"] == "Aceitar"){
				AprovaCadastroUsuario($mysqli, $id, "E");
			}

			elseif ($_POST["tipo-decisao"] == "Recusar" AND isset($_POST["comentario"])){
				$observacao = mysqli_real_escape_string($mysqli, $_POST["comentario"]);
				RemoveUsuario($mysqli, $id, $observacao);
			}else{
				$_SESSION["Failed"] = "Os campos Passados não estão corretos. Por favor tente de novo!";
			}
			
		}
		elseif ($_POST["tipo-cadastro"] == "supervisor") {
			
			if ($_POST["tipo-decisao"] == "Aceitar"){
				AprovaCadastroUsuario($mysqli, $id, "P");
			}

			elseif ($_POST["tipo-decisao"] == "Recusar" AND isset($_POST["comentario"])){
				$observacao = mysqli_real_escape_string($mysqli, $_POST["comentario"]);
				RemoveUsuario($mysqli, $id, $observacao);
			}else{
				$_SESSION["Failed"] = "Os campos Passados não estão corretos. Por favor tente de novo!";
			}
		}

	}
	else{
		$_SESSION["Failed"] = "Os campos Passados não estão corretos. Por favor tente de novo!";
	}

	header("Location: ../cadastros-pendentes.php" );

?>