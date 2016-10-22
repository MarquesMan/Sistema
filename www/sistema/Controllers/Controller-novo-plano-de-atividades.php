<?php
		
		session_start(); // começa a session
		require_once("../conecta.php");
		require_once("../../../Action/banco-plano-de-atividades.php");

		if(isset($_POST['plano'])){
		
			$status = "alterar";
		}
		else if(isset($_POST['plano-s'])){
			
			$status = "supervisor";
		}


	
		//<!-- Dados do Usuario -->

		if(		
			isset($_POST['id_estagio'],
                  $_POST['plano'],
                  $_POST['descricao'],
                  $_POST['local'],
                  $_POST['horarios'],
                  $_POST['data']) ){

            $idEstagio = mysqli_real_escape_string($mysqli, $_POST['id_estagio'] );

			if( (strlen($_POST['segunda1'])==0&&strlen($_POST['segunda2'])>0)||(strlen($_POST['segunda1'])>0&&strlen($_POST['segunda2'])==0)){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
			}
			else if( (strlen($_POST['terca1'])==0&&strlen($_POST['terca2'])>0)||(strlen($_POST['terca1'])>0&&strlen($_POST['terca2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
			}
			else if( (strlen($_POST['quarta1'])==0&&strlen($_POST['quarta2'])>0)||(strlen($_POST['quarta1'])>0&&strlen($_POST['quarta2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
			}
			else if( (strlen($_POST['quinta1'])==0&&strlen($_POST['quinta2'])>0)||(strlen($_POST['quinta1'])>0&&strlen($_POST['quinta2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
			}
			else if( (strlen($_POST['sexta1'])==0&&strlen($_POST['sexta2'])>0)||(strlen($_POST['sexta1'])>0&&strlen($_POST['sexta2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
			}
			else if( (strlen($_POST['sabado1'])==0&&strlen($_POST['sabado2'])>0)||(strlen($_POST['sabado1'])>0&&strlen($_POST['sabado2'])==0)){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
			}

			if(( $_POST['segunda1']>= $_POST['segunda2'])&& strlen($_POST['segunda1'])!=0 && strlen($_POST['segunda2'])!=0  ){
	  			$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */

			}
			else if(( $_POST['terca1']>= $_POST['terca2'])&& strlen($_POST['terca1'])!=0&& strlen($_POST['terca2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
			}
			else if(( $_POST['quarta1']>= $_POST['quarta2'])&& strlen($_POST['quarta1'])!=0&& strlen($_POST['quarta2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
			}
			else if(( $_POST['quinta1']>= $_POST['quinta2'])&& strlen($_POST['quinta1'])!=0&& strlen($_POST['quinta2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
			}
			else if(( $_POST['sexta1']>= $_POST['sexta2'])&& strlen($_POST['sexta1'])!=0&& strlen($_POST['sexta2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
			}
			else if(( $_POST['sabado1']>= $_POST['sabado2'])&& strlen($_POST['sabado1'])!=0&& strlen($_POST['sabado2'])!=0 ){
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
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
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
			}
			else if($cargaValorHoras==30&&$cargaValorMinutos>0){				
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location: ../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
			}
			
			$query 		= mysqli_query($mysqli,"SELECT * FROM estagio WHERE Id_Estagio='".$_POST['id_estagio']."'") or die(mysqli_error($mysqli));
			$getNumero 	= mysqli_fetch_assoc($query);
			$id_estagio = $_POST['id_estagio'];
			$Numero 	= mysqli_real_escape_string($mysqli, $_SESSION['id']);	
			$descricao 	= mysqli_real_escape_string($mysqli, $_POST['descricao']);
			$local 		= mysqli_real_escape_string($mysqli, $_POST['local']);
			$carga 		= $cargaValorHoras.":".$cargaValorMinutos;
			$horarios 	= mysqli_real_escape_string($mysqli, $_POST['horarios']);
			$data 		= DateTime::createFromFormat('d/m/Y',$_POST['data']);
			//$data		= mysqli_real_escape_string($mysqli,  $_POST['data']);
			$time_stamp = date('Y/m/d H:i:s', time());				
			InserirPlanoDeAtividades($mysqli,$id_estagio,$horarios,$carga,$descricao,$local,$data,$time_stamp,$status);			

			header("Location:../documentos-estagio.php?idEstagio=".$id_estagio); /* Redirect browser */
			exit();
		}else{
			$_SESSION["Failed"] = "Paramêtros incorretos.";
			header("Location:../documentos-estagio.php?idEstagio=".$id_estagio); /* Redirect browser */
		}

		//DEREPREPREPRPRPERPERPERPERPERPDERP
