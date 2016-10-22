<?php
		
		require_once("conecta.php");
		require_once("../../../Action/banco-planbo-de-atividades.php");
		

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
		$descricao = mysqli_real_escape_string($mysqli,  $_POST['comment']);
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

		// Por enquanto só funciona para um plano de atividades(OBS: tentar LAST_INSERT_ID())
		$sql = mysqli_query($mysqli, "INSERT INTO plano_de_bool(
															id_plano
															)VALUES (
															LAST_INSERT_ID()
															)"
															)or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($mysqli));
	


		header("Location: documentos-estagio.php?idEstagio=".$id_estagio); /* Redirect browser */
		exit();


		//DEREPREPREPRPRPERPERPERPERPERPDERP
	?>





</html>