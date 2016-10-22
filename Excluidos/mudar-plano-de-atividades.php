
	<?php
		
		require_once("conecta.php");
		require_once("../../../Action/banco-planbo-de-atividades.php");

		//<!-- Dados do Usuario -->

		if(isset($_POST['plano'])){
			$id_plano = $_POST['plano'];
			$status = "alterar";
		}
		else if(isset($_POST['plano-s'])){
			$id_plano = $_POST['plano-s'];
			$status = "supervisor";
		}

		if(	isset($_POST['local'])&&	
			isset($_POST['plano'])&&
			isset($_POST['carga'])&&
			isset($_POST['horarios'])&&
			isset($_POST['data'])&&
			isset($_POST['descricao'])&&
			isset($_POST['erros'])){
		
			$local 		= mysqli_real_escape_string($mysqli,  $_POST['local']);
			$carga 		= mysqli_real_escape_string($mysqli,  $_POST['carga']);
			$horarios 	= mysqli_real_escape_string($mysqli,  $_POST['horarios']);
			$descricao 	= mysqli_real_escape_string($mysqli,  $_POST['descricao']);
			$data 		= mysqli_real_escape_string($mysqli,  $_POST['data']);
			$erros 		= mysqli_real_escape_string($mysqli,  $_POST['erros']);

			AtualizaPlanoDeAtividades($mysqli,$id_plano,$id_estagio,$horarios,$carga,$descricao,$local,$data,$status,$erros);
			
		}else{
			$_SESSION["Failed"] = "Paramêtros incorretos.";
			header("Location: documentos-estagio.php?idEstagio=".$_POST['idEstagio']); /* Redirect browser */
		}

			
	

	?>