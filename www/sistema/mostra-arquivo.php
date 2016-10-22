<?php
	session_start();

	require_once("conecta.php");
	require_once("../../Action/banco-termo-de-compromisso.php");
	require_once("../../Action/banco-declaracao-final.php");

	if($_GET["tipo-documento"] == "termo"){
		$arquivo = ListaTermoDeCompromisso($mysqli, true, $_GET["idEstagio"]);
		$arq_echo = "Arquivo_Termo";
		$nome = "Nome_Termo";
	}

	elseif($_GET["tipo-documento"] == "declaracao"){
		$arquivo = ListaDeclaracaoFinal($mysqli, true, $_GET["idEstagio"]);
		$arq_echo = "Arquivo_Declaracao";
		$nome = "Nome_Declaracao";
	}

	if(count($arquivo) > 0){
		if($arquivo == false){ ?>
		    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" charset='UTF-8'>
			<link href = "css/bootstrap.min.css" rel = "stylesheet">
			<div class="alert alert-danger alert-dismissible text-center" role="alert" style="width: 80%; margin-left: auto; margin-right: auto; margin-top: 70px;">
	  			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  			<?php echo $_SESSION["Failed"]?>
			</div>
	
			<?php unset($_SESSION["Failed"]);
		}

		else{
			foreach($arquivo as $row){
				header('Content-type: application/pdf');
				header('Content-Disposition: inline; filename="' . $row[$nome] . '"');
				header('Content-Transfer-Encoding: binary');
				header('Accept-Ranges: bytes');
				echo $row[$arq_echo];
			}
		}
	}

	else{?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" charset='UTF-8'>
		<link href = "css/bootstrap.min.css" rel = "stylesheet">
		<div class="alert alert-danger alert-dismissible text-center" role="alert" style="width: 80%; margin-left: auto; margin-right: auto; margin-top: 70px;">
  			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  			Arquivo não encontrado
		</div>	
	<?php }
?>