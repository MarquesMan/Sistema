<?php
	session_start();
	require_once("../conecta.php");
	require_once("../../../Action/banco-plano-de-atividades.php");
	require_once("../../../Action/banco-relatorios.php");
	require_once("../../../Action/banco-estagios.php");
	require_once("../../../Action/banco-termo-de-compromisso.php");
	require_once("../../../Action/banco-termo-aditivo.php");
	require_once("../../../Action/banco-declaracao-final.php");



	if(isset($_POST["tipo-documento"])) {

		if($_POST["tipo-documento"] == "plano"){

			if(isset($_POST["local"]) && isset($_POST["carga-h"]) && isset($_POST["data"]) && isset($_POST["segunda"]) && isset($_POST["terca"])
				&& isset($_POST["quarta"]) && isset($_POST["quinta"]) && isset($_POST["sexta"]) && isset($_POST["sabado"]) && isset($_POST["descricao"]) && isset($_POST["Id_planoatividades"]) && isset($_POST["botaoPlano"]) ){


				$string_erros = $_POST["local"].";";
				$string_erros .= $_POST["carga-h"].";";
				$string_erros .= $_POST["data"].";";
				$string_erros .= $_POST["segunda"].";".$_POST["segunda"].";";
				$string_erros .= $_POST["terca"].";".$_POST["terca"].";";
				$string_erros .= $_POST["quarta"].";".$_POST["quarta"].";";
				$string_erros .= $_POST["quinta"].";".$_POST["quinta"].";";
				$string_erros .= $_POST["sexta"].";".$_POST["sexta"].";";
				$string_erros .= $_POST["sabado"].";".$_POST["sabado"].";";
				$string_erros .= $_POST["descricao"];

				$id_plano = mysqli_real_escape_string($mysqli, $_POST["Id_planoatividades"]);
				$string_erros = mysqli_real_escape_string($mysqli, $string_erros);

				$pos = strpos($string_erros, "1");

				$status = "";

				if($pos === false){
					if($_SESSION["auto"] == "P"){
						$status = "presidente";
					}
					elseif($_SESSION["auto"] == "V"){
						$status = "aprovado";
					}
				}
				else{
					$status = "alterar";
				}

				if($_POST["botaoPlano"]=="Enviar"){
					AvaliaPlanoDeAtividades($mysqli, $id_plano, $string_erros, $status);
				}else{

			 		$local = mysqli_real_escape_string($mysqli, $_POST['localRadio']);
					$dataHorario = mysqli_real_escape_string($mysqli, $_POST['dataHoraRadio']);
					$cargaH = mysqli_real_escape_string($mysqli, $_POST['cargaHorariaRadio']);
					$dias = mysqli_real_escape_string($mysqli, $_POST['diasRadio']);
					$descricao = mysqli_real_escape_string($mysqli, $_POST['descricaoRadio']);

					AvaliaPlanoDeAtividadesComComentarios($mysqli, $id_plano, $string_erros, $status, $local,$dataHorario ,$cargaH ,$dias ,$descricao );
				}


			}
			else{
				$_SESSION["Failed"] = "Os dados não foram enviados corretamente. Por favor tente denovo.";
			}

		}
		elseif($_POST["tipo-documento"] == "relatorio"){

			$status = "";

			if(isset($_POST['reprovarRelatorioButton'])){

				$id_relatorio = mysqli_real_escape_string($mysqli, $_POST["id-relatorio"]);
				$string_erros = $_POST['tipo-relatorio'].";".$_POST['data_inicial'].";".$_POST['data_final'].";".$_POST['atividades'].";".$_POST['comentarios'];
				$status = "alterar";
				
				$tipoRelatorioErro= mysqli_real_escape_string($mysqli, $_POST["tipoRelatorioErro"]);
				$dataInicialErro= mysqli_real_escape_string($mysqli, $_POST["dataInicialErro"]);
				$dataFinalErro= mysqli_real_escape_string($mysqli, $_POST["dataFinalErro"]);
				$atividadesErro= mysqli_real_escape_string($mysqli, $_POST["atividadesErro"]);
				$comentariosErro = mysqli_real_escape_string($mysqli, $_POST["comentariosErro"]);
			
				AvaliaRelatorioComComentarios($mysqli, $id_relatorio, $string_erros, $status,$tipoRelatorioErro,$dataInicialErro,$dataFinalErro,$atividadesErro,$comentariosErro);
				
			}
			else{


				
				$id_relatorio = mysqli_real_escape_string($mysqli, $_POST["id-relatorio"]);
				$string_erros = "0;0;0;0;0";

				if($_SESSION["auto"] == "P"){
					$status = "presidente";
					$observacao = mysqli_real_escape_string($mysqli, $_POST["Observacoes"]);
					$notas = $_POST['Assiduidade'].$_POST['Disciplina'].$_POST['Cooperacao'].$_POST['Producao'].$_POST['Iniciativa'].$_POST['Assimilacao'].$_POST['Conhecimentos'].$_POST['Responsabilidade'].$_POST['Dedicacao'].$_POST['Organizacao'];
					AvaliaRelatorioComNotas($mysqli, $id_relatorio, $string_erros, $status, $notas, $observacao );
				}
				elseif($_SESSION["auto"] == "V"){
					$status = "entrega";
					AvaliaRelatorio($mysqli, $id_relatorio, $string_erros, $status);	
				}


					
			}			
		
			header("Location: ../documentos-pendentes.php#relatorios");

		}

		elseif($_POST["tipo-documento"] == "estagio"){
			AvaliaEstagio($mysqli, $_POST["id-estagio"], $_POST["Enviar"]);		
		}

		elseif($_POST["tipo-documento"] == "termo"){
			if(isset($_POST["avalia-a"]))
				AvaliaTermoDeCompromisso($mysqli, $_POST["id-estagio"], "Aceitar");
			elseif(isset($_POST["avalia-r"]))
				AvaliaTermoDeCompromisso($mysqli, $_POST["id-estagio"], "Recusar");
		}
		elseif($_POST["tipo-documento"] == "declaracao"){
			if(isset($_POST['avalia-a']))
				AvaliaDeclaracaoFinal($mysqli, $_POST["id-estagio"], "Aceitar", "");
			else{
                AvaliaDeclaracaoFinal($mysqli, $_POST["id-estagio"], "Recusar", $_POST["comentario"]);
			}
		}
	}
    elseif(isset($_POST['avaliaTermoAditivo-a']))
    {

        if( !isset($_POST['id-estagio'],$_POST['idTermoAditivo']) ){
            $_SESSION['Failed'] = "Paramêtros incorretos";
            header("Location: ../documentos-pendentes.php");
            die();
        }

        $idTermoAditivo = mysqli_real_escape_string($mysqli,$_POST['idTermoAditivo']);

        $idEstagio = mysqli_real_escape_string($mysqli,$_POST['id-estagio']);
        $comentario = mysqli_real_escape_string($mysqli,$_POST['comentario']);

        avaliaTermoAditivo($mysqli, $idEstagio,$idTermoAditivo ,"", "aprova");

        header("Location: ../documentos-pendentes.php");
        die();
    }
	elseif( isset($_POST['id-estagio'],$_POST['comentario'] ) )
	{

        if( !isset($_POST['id-estagio'],$_POST['idTermoAditivo']) ){
            $_SESSION['Failed'] = "Paramêtros incorretos";
            header("Location: ../documentos-pendentes.php");
            die();
        }

		$idEstagio = mysqli_real_escape_string($mysqli,$_POST['id-estagio']);
        $idTermoAditivo = mysqli_real_escape_string($mysqli,$_POST['idTermoAditivo']);
		$comentario = mysqli_real_escape_string($mysqli,$_POST['comentario']);

		avaliaTermoAditivo($mysqli, $idEstagio, $idTermoAditivo , $comentario, "reprova" );

		header("Location: ../documentos-pendentes.php");
		die();
	}


	header("Location: ../documentos-pendentes.php");
