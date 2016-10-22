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
	
		//<!-- Dados do Usuario -->

		
		$query = mysqli_query($mysqli,"SELECT * FROM estagio WHERE id='".$_POST['idEstagio']."' AND id_aluno='".$_SESSION["id"]."'") or die(mysqli_error());
		$estagio = mysqli_fetch_assoc($query);


		if(empty($estagio)){
			header("Location:meus-estagios.php"); /* Redirect browser */
			exit();
		}


		$id_aluno = $_SESSION["id"];
		$id_estagio = $_POST['idEstagio'];
		$tiporelatorio = $_POST['tiporelatorio'];
		$datainicial = mysqli_real_escape_string($mysqli,  $_POST['datainicial']);
		$datafinal = mysqli_real_escape_string($mysqli,  $_POST['datafinal']);
		$atividades = mysqli_real_escape_string($mysqli,  $_POST['atividades']);
		$comaluno = mysqli_real_escape_string($mysqli,  $_POST['comaluno']);	
		$erros = "0;0;0;0;0;0";
		date_default_timezone_set('America/Manaus');
		$time_stamp = date('d/m/Y H:i:s', time() );
		$time_stamp = mysqli_real_escape_string($mysqli, $time_stamp);



		$sql = mysqli_query($mysqli, "INSERT INTO relatorio(
																	id_aluno,
																	id_estagio,
																	tipo,
																	inicio,
																	fim,
																	atividades,
																	com_aluno,
																	time,
																	erros,
																	status
																	)VALUES (
																	'$id_aluno', 
																	'$id_estagio',
																	'$tiporelatorio',
																	'$datainicial',
																	'$datafinal',
																	'$atividades',																	
																	'$comaluno',
																	'$time_stamp',
																	'$erros',
																	'alterar'
																	)"
																	)or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($mysqli));


		header("Location: documentos-estagio.php?idEstagio=".$_POST['idEstagio']); /* Redirect browser */
		exit();


		//DEREPREPREPRPRPERPERPERPERPERPDERP
	?>





</html>