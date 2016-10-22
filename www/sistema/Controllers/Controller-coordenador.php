<?php
	require_once("../conecta.php"); // inclui a conexão a database
	require_once("../../../Action/funcoes-de-controle.php");
	require_once("../../../Action/banco-usuarios.php");

	session_start(); // começa a session

	if($_SERVER['REQUEST_METHOD'] != "POST"){
		$_SESSION["Failed"] = "Método de requisição incorreto. Por Favor tente novamente.";
		header("Location: ../index.php");
		die();
	}

	if($_SESSION['auto'] != "Z"){
		$_SESSION["Failed"] = "Permissão não concedida.";
		header("Location: ../index.php");
		die();
	}

	switch ($_POST['acao']) {
		case 'novo':
			var_dump($_POST);
			die();
			CadastrarCoordenador($mysqli, $_POST['curso'], $_POST['nomeCompleto'], $_POST['nomeUsuario'], $_POST['email'],$_POST['telefone'], $_POST['senha']);
			break;
		case 'alterar':
			alteraDadosSuperAdmin($conexao,$_POST['idUsuario'],$_POST['nomeCompleto'], $_POST['curso'], $_POST['email'],$_POST['telefone'], $_POST['senha'],$_POST['nomeUsuario']);
			break;
		case 'remover':
			break;
		default:
			# code...
			break;
	}

	header("Location: ../superAdmin.php");
