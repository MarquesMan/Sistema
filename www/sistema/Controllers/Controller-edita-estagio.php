<?php 
	session_start();
	require_once("../conecta.php");
	require_once("../../../Action/banco-estagios.php");
	require_once("../../../Action/banco-plano-de-atividades.php");
	require_once("../../../Action/banco-termo-de-compromisso.php");



	if(  isset($_POST["local"],$_POST['Modalidade'],$_POST['Codigo_Area'],$_POST['Codigo_Empresa'], $_POST['dataInicial'], $_POST['dataFinal'],$_POST['Codigo_Supervisor'], $_POST["carga"],$_POST["data"],$_POST["segunda1"],$_POST["segunda2"],$_POST["terca1"],$_POST["terca2"],$_POST["quarta1"],$_POST["quarta2"],$_POST["quinta1"],$_POST["quinta2"],$_POST["sexta1"],$_POST["sexta2"],$_POST["sabado1"],$_POST["sabado2"],$_POST["descricao"],$_POST["plano"],$_POST["idEstagio"]) ){

		//<!-- Dados do Usuario -->
		$Modalidade = mysqli_real_escape_string($mysqli,  $_POST['Modalidade']);
		$Codigo_Area = mysqli_real_escape_string($mysqli,  $_POST['Codigo_Area']);
		$Codigo_Empresa = mysqli_real_escape_string($mysqli,  $_POST['Codigo_Empresa']);
		$DataInicial = DateTime::createFromFormat('d/m/Y', $_POST['dataInicial']);
		//$DataInicial = mysqli_real_escape_string($mysqli, $_POST['dataInicial']);
		$DataFinal = DateTime::createFromFormat('d/m/Y', $_POST['dataFinal']);
		//$DataFinal = mysqli_real_escape_string($mysqli, $_POST['dataFinal']);
		//$DataFinal = DateTime::createFromFormat('d/m/Y', $_POST['dataFinal']);

		$Codigo_Supervisor = mysqli_real_escape_string($mysqli,  $_POST['Codigo_Supervisor']);
		$Numero = $_SESSION['id'];
		$id_plano = $_POST['plano'];
		$idEstagio = $_POST['idEstagio'];

		$termo = ListaTermoDeCompromisso($mysqli, false, $idEstagio);
		$termo = $termo[0];

		$Status_Termo =  $termo['Status_Termo'];

		atualizaEstagio($mysqli,$idEstagio, $Modalidade,$Codigo_Area,$Codigo_Empresa,$DataInicial,$DataFinal,$Codigo_Supervisor,$Numero);
			


		if( (strlen($_POST['segunda1'])==0&&strlen($_POST['segunda2'])>0)||(strlen($_POST['segunda1'])>0&&strlen($_POST['segunda2'])==0)){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */
			}
			else if( (strlen($_POST['terca1'])==0&&strlen($_POST['terca2'])>0)||(strlen($_POST['terca1'])>0&&strlen($_POST['terca2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */
			}
			else if( (strlen($_POST['quarta1'])==0&&strlen($_POST['quarta2'])>0)||(strlen($_POST['quarta1'])>0&&strlen($_POST['quarta2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */
			}
			else if( (strlen($_POST['quinta1'])==0&&strlen($_POST['quinta2'])>0)||(strlen($_POST['quinta1'])>0&&strlen($_POST['quinta2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */
			}
			else if( (strlen($_POST['sexta1'])==0&&strlen($_POST['sexta2'])>0)||(strlen($_POST['sexta1'])>0&&strlen($_POST['sexta2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */
			}
			else if( (strlen($_POST['sabado1'])==0&&strlen($_POST['sabado2'])>0)||(strlen($_POST['sabado1'])>0&&strlen($_POST['sabado2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */
			}

			if(( $_POST['segunda1']>= $_POST['segunda2'])&& strlen($_POST['segunda1'])!=0 && strlen($_POST['segunda2'])!=0  ){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */

			}
			else if(( $_POST['terca1']>= $_POST['terca2'])&& strlen($_POST['terca1'])!=0&& strlen($_POST['terca2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */
			}
			else if(( $_POST['quarta1']>= $_POST['quarta2'])&& strlen($_POST['quarta1'])!=0&& strlen($_POST['quarta2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */
			}
			else if(( $_POST['quinta1']>= $_POST['quinta2'])&& strlen($_POST['quinta1'])!=0&& strlen($_POST['quinta2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */
			}
			else if(( $_POST['sexta1']>= $_POST['sexta2'])&& strlen($_POST['sexta1'])!=0&& strlen($_POST['sexta2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */
			}
			else if(( $_POST['sabado1']>= $_POST['sabado2'])&& strlen($_POST['sabado1'])!=0&& strlen($_POST['sabado2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */
			}



			$horarios = $_POST['segunda1'].";".$_POST['segunda2'].";".$_POST['terca1'].";".$_POST['terca2'].";".$_POST['quarta1'].";".$_POST['quarta2'].";".$_POST['quinta1'].";".$_POST['quinta2'].";".$_POST['sexta1'].";".$_POST['sexta2'].";".$_POST['sabado1'].";".$_POST['sabado2'];


			$result = explode(";", $horarios);

			$hora1 = "";
			$hora2 = "";
			$cargaValorHoras =0;
			$cargaValorMinutos = 0;

			for($i = 0; $i < 12; $i = $i + 2){

				if( ($result[$i]!="")&&($result[$i+1]!="") ){		

					$hora1 = $result[$i];
					$hora2 = $result[$i+1];

					$hora1 = explode(":", $hora1);
					$hora2 = explode(":", $hora2);

					$auxiliarCalculoMinutos = $hora2[1] - $hora1[1];
					if($auxiliarCalculoMinutos<0){
						$cargaValorMinutos = intval($cargaValorMinutos) + (59+$auxiliarCalculoMinutos);
						$cargaValorHoras = intval($cargaValorHoras) + ( intval($hora2[0]) - intval($hora1[0]) ) -1;
					}
					else{
						$cargaValorMinutos = $cargaValorMinutos + $auxiliarCalculoMinutos;
						$cargaValorHoras = intval($cargaValorHoras) +(intval($hora2[0]) - intval($hora1[0]) );	
					}

				}
			}


			$cargaValorHoras = intval($cargaValorHoras) + $cargaValorMinutos/60;
			$cargaValorMinutos = $cargaValorMinutos%60;

			if($cargaValorHoras>30){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */
			}
			else if($cargaValorHoras==30&&$cargaValorMinutos>0){				
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */
			}
			
			$Numero 	= mysqli_real_escape_string($mysqli, $_SESSION['id']);	
			$descricao 	= mysqli_real_escape_string($mysqli,  $_POST['descricao']);
			$local 		= mysqli_real_escape_string($mysqli,  $_POST['local']);
			$carga 		= $cargaValorHoras.":".$cargaValorMinutos;
			$horarios 	= mysqli_real_escape_string($mysqli,  $_POST['horarios']);
			$data 		= DateTime::createFromFormat('d/m/Y', $_POST['data']);
			//$data 	= mysqli_real_escape_string($mysqli, $_POST['data']);
			$status 	= "supervisor";
			$erros 		= "0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0";
			
			AtualizaPlanoDeAtividades($mysqli,$id_plano,$idEstagio,$horarios,$carga,$descricao,$local,$data,$status,$erros);

		
			if( $_FILES['termo_arquivo']['size'] > 0)
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

				InsereTermoDeCompromisso($mysqli, $idEstagio, $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo);
			
			}elseif( $Status_Termo == "aprovado"){
				submeteTermoDeCompromisso($mysqli,$idEstagio);
			}else{
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */		
			}

		$_SESSION["Success"] = "Estágio submetido com sucesso.";	
		header("Location:../meus-estagios.php"); /* Redirect browser */
		exit();
	
	}else{
		$_SESSION["Failed"] = "Paramêtros incorretos.";
		header("Location:../meus-estagios.php"); /* Redirect browser */
	}
	
	?>