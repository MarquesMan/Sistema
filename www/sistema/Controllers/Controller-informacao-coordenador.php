<?php 

	session_start();

	if($_SESSION['auto']!='Z'){
		return "";
	}

	require_once("../conecta.php");
    require_once("../../../Action/banco-usuarios.php");

    $id = mysqli_escape_string($mysqli, $_POST['idUsuario']);

    $informacoes = getCoordenadores($mysqli,$id);

    var_dump($informacoes);
