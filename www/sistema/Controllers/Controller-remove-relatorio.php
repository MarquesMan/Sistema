<?php

	session_start(); // começa a session

	require_once("../conecta.php");
	require_once("../../../Action/banco-relatorios.php");

	if(isset($_POST['idEstagio'])){

		$id_Estagio = $_POST['idEstagio'];

	}else{

		$_SESSION["Failed"] = "Paramêtros incorretos.";
		header("Location: ../users.php"); /* Redirect browser */
	}

	if(isset($_POST['relatorio'])){
		$id_Plano = $_POST['relatorio'];
	}
	else{
		$_SESSION["Failed"] = "Paramêtros incorretos.";
        if($_SESSION[''] == 'E' ){
            header("Location: ../documentos-estagio.php?idEstagio=".$id_Estagio); /* Redirect browser */
        }else{
            header("Location: ../documentos-estagio-admin.php?idEstagio=".$id_Estagio); /* Redirect browser */
        }
	}


	RemoveRelatorio($mysqli, $id_Estagio, $id_Plano);

    if($_SESSION[''] == 'E' ){
        header("Location: ../documentos-estagio.php?idEstagio=".$id_Estagio); /* Redirect browser */
    }else{
        header("Location: ../documentos-estagio-admin.php?idEstagio=".$id_Estagio); /* Redirect browser */
    }



?>