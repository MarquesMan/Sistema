
	<?php
		
		session_start(); // começa a session

		require_once("../conecta.php");
		require_once("../../../Action/banco-plano-de-atividades.php");

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
			(isset($_POST['plano']) || isset($_POST['plano-s']))&&
			isset($_POST['horarios'])&&
			isset($_POST['data'])&&
			isset($_POST['descricao'])&&
			isset($_POST['erros'])&&
			isset($_POST['id_estagio']) ){

			if( (strlen($_POST['segunda1'])==0&&strlen($_POST['segunda2'])>0)||(strlen($_POST['segunda1'])>0&&strlen($_POST['segunda2'])==0)){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */	
			}
			else if( (strlen($_POST['terca1'])==0&&strlen($_POST['terca2'])>0)||(strlen($_POST['terca1'])>0&&strlen($_POST['terca2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */	
			}
			else if( (strlen($_POST['quarta1'])==0&&strlen($_POST['quarta2'])>0)||(strlen($_POST['quarta1'])>0&&strlen($_POST['quarta2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */	
			}
			else if( (strlen($_POST['quinta1'])==0&&strlen($_POST['quinta2'])>0)||(strlen($_POST['quinta1'])>0&&strlen($_POST['quinta2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */	
			}
			else if( (strlen($_POST['sexta1'])==0&&strlen($_POST['sexta2'])>0)||(strlen($_POST['sexta1'])>0&&strlen($_POST['sexta2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */	
			}
			else if( (strlen($_POST['sabado1'])==0&&strlen($_POST['sabado2'])>0)||(strlen($_POST['sabado1'])>0&&strlen($_POST['sabado2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */	
			}

			if(( $_POST['segunda1']>= $_POST['segunda2'])&& strlen($_POST['segunda1'])!=0 && strlen($_POST['segunda2'])!=0  ){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */

			}
			else if(( $_POST['terca1']>= $_POST['terca2'])&& strlen($_POST['terca1'])!=0&& strlen($_POST['terca2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */
			}
			else if(( $_POST['quarta1']>= $_POST['quarta2'])&& strlen($_POST['quarta1'])!=0&& strlen($_POST['quarta2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */
			}
			else if(( $_POST['quinta1']>= $_POST['quinta2'])&& strlen($_POST['quinta1'])!=0&& strlen($_POST['quinta2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */
			}
			else if(( $_POST['sexta1']>= $_POST['sexta2'])&& strlen($_POST['sexta1'])!=0&& strlen($_POST['sexta2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */
			}
			else if(( $_POST['sabado1']>= $_POST['sabado2'])&& strlen($_POST['sabado1'])!=0&& strlen($_POST['sabado2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */
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
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */
			}
			else if($cargaValorHoras==30&&$cargaValorMinutos>0){				
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */
			}


			$id_estagio = mysqli_real_escape_string($mysqli, $_POST['id_estagio']);
			$local 		= mysqli_real_escape_string($mysqli, $_POST['local']);
			$carga 		= $cargaValorHoras.":".$cargaValorMinutos;
			$horarios 	= mysqli_real_escape_string($mysqli, $_POST['horarios']);
			$descricao 	= mysqli_real_escape_string($mysqli, $_POST['descricao'] );
			if($descricao[0]==" ")
				$descricao = substr($descricao,1,-1);
			$data 		= DateTime::createFromFormat('d/m/Y', $_POST['data']);
			//$data 	= mysqli_real_escape_string($mysqli, $_POST['data']);
			$erros 		= mysqli_real_escape_string($mysqli, $_POST['erros']);

			AtualizaPlanoDeAtividades($mysqli,$id_plano,$id_estagio,$horarios,$carga,$descricao,$local,$data,$status,$erros);
			
	}else{
		$_SESSION["Failed"] = "Paramêtros incorretos.";
		header("Location: ../documentos-estagio.php?idEstagio=".$_POST['id_estagio']); /* Redirect browser */
	}	

	?>