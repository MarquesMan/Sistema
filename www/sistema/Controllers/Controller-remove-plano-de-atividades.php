<?php

	session_start(); // começa a session

	require_once("../conecta.php");
	require_once("../../../Action/banco-plano-de-atividades.php");

	if(isset($_POST['idEstagio'])){

		$id_Estagio = $_POST['idEstagio'];

	}else{

		$_SESSION["Failed"] = "Paramêtros incorretos.";
		header("Location: ../users.php"); /* Redirect browser */
	}

	if(isset($_POST['plano'])){
		$id_Plano = $_POST['plano'];
	}
	else{
		$_SESSION["Failed"] = "Paramêtros incorretos.";
		header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */
	}


	RemovePlanoDeAtividades($mysqli, $id_Estagio, $id_Plano);

    if($_SESSION['auto'] == 'E' ){
        header("Location: ../documentos-estagio.php?idEstagio=".$id_Estagio); /* Redirect browser */
    }else{
        header("Location: ../documentos-estagio-admin.php?idEstagio=".$id_Estagio); /* Redirect browser */
    }



?>