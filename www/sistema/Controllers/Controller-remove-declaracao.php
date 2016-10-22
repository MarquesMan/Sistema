<?php

	session_start(); // começa a session

	require_once("../conecta.php");
	require_once("../../../Action/banco-declaracao-final.php");

	if(isset($_POST['idEstagio'])){

		$id_Estagio = $_POST['idEstagio'];

	}else{

		$_SESSION["Failed"] = "Paramêtros incorretos.";
		header("Location: ../users.php"); /* Redirect browser */
	}

	if(isset($_POST['declaracao'])){
		$id_Declaracao = $_POST['declaracao'];
	}
	else{
		$_SESSION["Failed"] = "Paramêtros incorretos.";
        if($_SESSION[''] == 'E' ){
            header("Location: ../documentos-estagio.php?idEstagio=".$id_Estagio); /* Redirect browser */
        }else{
            header("Location: ../documentos-estagio-admin.php?idEstagio=".$id_Estagio); /* Redirect browser */
        }
	}

	RemoveDeclaracao($mysqli, $id_Estagio, $id_Declaracao);

    if($_SESSION[''] == 'E' ){
        header("Location: ../documentos-estagio.php?idEstagio=".$id_Estagio); /* Redirect browser */
    }else{
        header("Location: ../documentos-estagio-admin.php?idEstagio=".$id_Estagio); /* Redirect browser */
    }



?>