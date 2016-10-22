<html>
	<?php
		session_start(); // começa a session
		require_once("conecta.php");

		if(Check_Login_Status())
		{
			Update_Login_Status();
		}
		else
		{
			session_unset();
			phpAlert_Redirect("ACESSO NEGADO", "index.php");
			exit();
		}
	?>
	<head>
			
			<meta charset = 'UTF-8'>
			<link rel="shortcut icon" href="images/favicon.ico"/>		
			<title>Sistema de Estágios - UFMS - Plano de Ativadades</title>
			<link href = "css/bootstrap.css" rel = "stylesheet" >
			<link href = "css/plano.css" rel = "stylesheet" >
			<script src="js/jquery-1.11.1.min.js"></script>
	</head>



	<?php

		if(isset($_POST['plano'])){
		
			$status = "alterar";
		}
		else if(isset($_POST['plano-s'])){
			
			$status = "supervisor";
		}

	
		//<!-- Dados do Usuario -->

		
		$query = mysqli_query($mysqli,"SELECT * FROM estagio WHERE id='".$_POST['idEstagio']."'") or die(mysqli_error());
		$getNumero = mysqli_fetch_assoc($query);
		$id_estagio = $_POST['idEstagio'];
		$Numero = mysqli_real_escape_string($mysqli, $getNumero['id_aluno']);	
		$descricao = mysqli_real_escape_string($mysqli,  $_POST['descricao']);
		$local = mysqli_real_escape_string($mysqli,  $_POST['local']);
		$carga = mysqli_real_escape_string($mysqli,  $_POST['carga']);
		$horarios = mysqli_real_escape_string($mysqli,  $_POST['horarios']);
		$data = mysqli_real_escape_string($mysqli,  $_POST['data']);

		date_default_timezone_set('America/Manaus');
		$time_stamp = date('d/m/Y H:i:s', time() );
		$time_stamp = mysqli_real_escape_string($mysqli, $time_stamp);
		echo $time_stamp;

		$sql = mysqli_query($mysqli, "INSERT INTO plano_de_atividades(
																	id_aluno,
																	id_estagio,
																	horario,
																	cargaH, 
																	descricao,
																	local,
																	data,
																	time,
																	status
																	)VALUES (
																	'$Numero', 
																	'$id_estagio',
																	'$horarios',
																	'$carga',
																	'$descricao',
																	'$local',
																	'$data',																	
																	'$time_stamp',
																	'$status'
																	)"
																	)or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($mysqli));


		header("Location: documentos-estagio.php?idEstagio=".$id_estagio); /* Redirect browser */
		exit();


		//DEREPREPREPRPRPERPERPERPERPERPDERP
	?>





</html>