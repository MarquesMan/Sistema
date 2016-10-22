<?php
	session_start();
	require_once("../conecta.php");
	require_once("../../../Action/banco-termo-de-compromisso.php");
	require_once("../../../Action/banco-declaracao-final.php");

	if(!isset($_GET["idEstagio"])){
		$_SESSION["Failed"] = "Estagio não encontrado. Por favor selecione um estágio.";
		header("Location: ../meus-estagios.php");
		die();
	}

	elseif($_SERVER['REQUEST_METHOD'] != 'POST'){
		$_SESSION["Failed"] = "Método de requisição incorreto. Por favor tente novamente.";
		header("Location: ../documentos-estagio.php?idEstagio=".$_GET["idEstagio"]);
		die();
	}

	if(isset($_POST['termo_up']) && $_FILES['termo_arquivo']['size'] > 0)
	{ 
		$NomeArquivo 	 = $_FILES['termo_arquivo']['name'];
		$NomeTemporario  = $_FILES['termo_arquivo']['tmp_name'];
		$TamanhoArquivo  = $_FILES['termo_arquivo']['size'];
		$TipoArquivo 	 = $_FILES['termo_arquivo']['type'];

		$fp       = fopen($NomeTemporario, 'r');
		$conteudo = fread($fp, filesize($NomeTemporario));
		$conteudo = addslashes($conteudo);
		fclose($fp);

		if(!get_magic_quotes_gpc())
		{
	    	$NomeArquivo = addslashes($NomeArquivo);
		}

		InsereTermoDeCompromisso($mysqli, $_GET["idEstagio"], $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo);

		header("Location: ../documentos-estagio.php?idEstagio=".$_GET["idEstagio"]);
		die();
	}

	elseif(isset($_POST['termo_update']) && $_FILES['termo_arquivo']['size'] > 0){
		$NomeArquivo 	 = $_FILES['termo_arquivo']['name'];
		$NomeTemporario  = $_FILES['termo_arquivo']['tmp_name'];
		$TamanhoArquivo  = $_FILES['termo_arquivo']['size'];
		$TipoArquivo 	 = $_FILES['termo_arquivo']['type'];

		$fp       = fopen($NomeTemporario, 'r');
		$conteudo = fread($fp, filesize($NomeTemporario));
		$conteudo = addslashes($conteudo);
		fclose($fp);

		if(!get_magic_quotes_gpc())
		{
	    	$NomeArquivo = addslashes($NomeArquivo);
		}

		AlteraTermoDeCompromisso($mysqli, $_GET["idEstagio"], $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo);

		header("Location: ../documentos-estagio.php?idEstagio=".$_GET["idEstagio"]);
		die();
	}

	elseif(isset($_POST['declaracao_up']) && $_FILES['declaracao_arquivo']['size'] > 0)
	{ 
		$NomeArquivo 	 = $_FILES['declaracao_arquivo']['name'];
		$NomeTemporario  = $_FILES['declaracao_arquivo']['tmp_name'];
		$TamanhoArquivo  = $_FILES['declaracao_arquivo']['size'];
		$TipoArquivo 	 = $_FILES['declaracao_arquivo']['type'];

		$fp       = fopen($NomeTemporario, 'r');
		$conteudo = fread($fp, filesize($NomeTemporario));
		$conteudo = addslashes($conteudo);
		fclose($fp);

		if(!get_magic_quotes_gpc())
		{
	    	$NomeArquivo = addslashes($NomeArquivo);
		}

		InsereDeclaracaoFinal($mysqli, $_GET["idEstagio"], $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo);

		header("Location: ../documentos-estagio.php?idEstagio=".$_GET["idEstagio"]);
		die();
	}

	elseif(isset($_POST['declaracao_update']) && $_FILES['declaracao_arquivo']['size'] > 0)
	{ 
		$NomeArquivo 	 = $_FILES['declaracao_arquivo']['name'];
		$NomeTemporario  = $_FILES['declaracao_arquivo']['tmp_name'];
		$TamanhoArquivo  = $_FILES['declaracao_arquivo']['size'];
		$TipoArquivo 	 = $_FILES['declaracao_arquivo']['type'];

		$fp       = fopen($NomeTemporario, 'r');
		$conteudo = fread($fp, filesize($NomeTemporario));
		$conteudo = addslashes($conteudo);
		fclose($fp);

		if(!get_magic_quotes_gpc())
		{
	    	$NomeArquivo = addslashes($NomeArquivo);
		}

		AlterarDeclaracaoFinal($mysqli, $_GET["idEstagio"], $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo);

		header("Location: ../documentos-estagio.php?idEstagio=".$_GET["idEstagio"]);
		die();
	}
	else{
		$_SESSION["Failed"] = "Informações passadas incorretamente. Por favor envie novamente.";
		header("Location: ../documentos-estagio.php?idEstagio=".$_GET["idEstagio"]);
		die();
	}
?>