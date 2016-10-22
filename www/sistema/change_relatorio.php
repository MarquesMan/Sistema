<html>
	<?php
		session_start(); // começa a session
		require "conecta.php";

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
		
		// Fazer aqui verificacao fodida !!!!!!!!!!!!!!!!!!!!!!



		//<!-- Dados do Usuario -->

		if(isset($_POST['relatorio'])){
			$id_relatorio = $_POST['relatorio'];
			$status = "alterar";
		}
		else if(isset($_POST['relatorio-s'])){
			$id_relatorio = $_POST['relatorio-s'];
			$status = "supervisor";
		}

		$Numero = $_SESSION["id"];
		$idEstagio = $_POST['idEstagio'];

		$tiporelatorio = $_POST['tiporelatorio'];
		$datainicial = mysqli_real_escape_string($mysqli,  $_POST['datainicial']);
		$datafinal = mysqli_real_escape_string($mysqli,  $_POST['datafinal']);
		$atividades = mysqli_real_escape_string($mysqli,  $_POST['atividades']);
		$comaluno = mysqli_real_escape_string($mysqli,  $_POST['comaluno']);
		$erros = $_POST['erros'];	

		date_default_timezone_set('America/Manaus');
		$time_stamp = date('d/m/Y H:i:s', time() );
		$time_stamp = mysqli_real_escape_string($mysqli, $time_stamp);

		$sql = mysqli_query($mysqli, 	"UPDATE relatorio
											SET	
												tipo= '$tiporelatorio',
												inicio= '$datainicial',
												fim= '$datafinal',
												atividades= '$atividades',
												com_aluno= '$comaluno',
												time= '$time_stamp',
												status='$status',
												erros='$erros'
											WHERE id='".$id_relatorio."' AND id_aluno='".$Numero."' AND id_estagio='".$idEstagio."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($mysqli));

		header("Location: documentos-estagio.php?idEstagio=".$_POST['idEstagio']); /* Redirect browser */
		exit();


		//DEREPREPREPRPRPERPERPERPERPERPDERP
	?>

</html>