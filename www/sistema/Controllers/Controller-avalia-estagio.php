<?php
	session_start();
	require_once("../conecta.php");
	require_once("../../../Action/banco-estagios.php");
	require_once("../../../Action/banco-plano-de-atividades.php");
	require_once("../../../Action/banco-termo-de-compromisso.php");



	if( isset($_POST["local"],$_POST["carga-h"],$_POST["data"],$_POST["segunda"],$_POST["terca"],$_POST["quarta"],$_POST["quinta"],$_POST["sexta"],$_POST["sabado"],$_POST["descricao"],$_POST["plano"],$_POST["idEstagio"],
		$_POST['errosEstagio'], $_POST['Radio_Modalidade'],$_POST['Radio_Supervisor'],$_POST['Radio_Empresa'],$_POST['Radio_Data_Inicio'],$_POST['Radio_Data_Fim'],$_POST['Radio_Area'],$_POST['Radio_Termo'], $_POST['termoErro']  ) ){

		$idEstagio = mysqli_real_escape_string($mysqli, $_POST["idEstagio"]);

		if($_SESSION["auto"] == "A"){
			$_SESSION["Failed"] = "Acesso negado! ";
			header("Location:../users.php"); /* Redirect browser */
		}
		else if( $_SESSION["auto"] == "P" ){
			$permissao = mysqli_query( $mysqli , "SELECT * FROM estagio WHERE Id_Estagio='".$idEstagio."' AND Id_Supervisor='".$_SESSION["id"]."'") or die(mysqli_error($conexao));
			$permissao = mysqli_fetch_assoc($permissao);

			if($permissao===null){
				$_SESSION["Failed"] = "Acesso negado! ";
				header("Location:../users.php"); /* Redirect browser */
			}

		}

		$estagioAprovado = true;

		//===================================================================
		// Info Estagio
		//===================================================================

		$string_erros_estagio = $_POST["Radio_Modalidade"].";";
		$string_erros_estagio .= $_POST["Radio_Area"].";";
		$string_erros_estagio .= $_POST["Radio_Empresa"].";";
		$string_erros_estagio .= $_POST["Radio_Data_Inicio"].";".$_POST["Radio_Data_Fim"].";";
		$string_erros_estagio .= $_POST["Radio_Area"].";";
		$string_erros_estagio .= $_POST["Radio_Termo"];

		$string_erros_estagio = mysqli_real_escape_string($mysqli, $string_erros_estagio);


		if( isset($_POST["botaoAprova"])){


			if( AvaliaEstagio($mysqli, $idEstagio, "Aceitar" )=== false ){
				header("Location:../documentos-pendentes.php"); /* Redirect browser */
				exit();
			}

		}elseif( isset($_POST["botaoReprova"])) {

			if(AvaliaEstagio($mysqli, $idEstagio, "Recusar")===false){
				header("Location:../documentos-pendentes.php"); /* Redirect browser */
				exit();
			}

			$tipoEstagio =	mysqli_real_escape_string( $mysqli ,$_POST['tipoEstagioErro'] );
			$supervisorErro = mysqli_real_escape_string( $mysqli ,$_POST['supervisorErro']);
			$empresaErro =	mysqli_real_escape_string( $mysqli ,$_POST['empresaErro']);
			$areaErro =	mysqli_real_escape_string( $mysqli ,$_POST['areaErro']);
			$dataInicial =	mysqli_real_escape_string( $mysqli ,$_POST['dataInicialErro']);
			$dataFinal =	mysqli_real_escape_string( $mysqli ,$_POST['dataFinalErro']);
			$termoErro = mysqli_real_escape_string(  $mysqli ,$_POST['termoErro'] );

			insereComentariosEstagio( $mysqli  ,$idEstagio , $tipoEstagio, $supervisorErro, $empresaErro, $dataInicial, $dataFinal, $areaErro, $termoErro );

			$estagioAprovado = false;

		}else{
			$_SESSION["Failed"] = "Paramêtros incorretos.";
			header("Location:../documentos-pendentes.php"); /* Redirect browser */
		}




		//===================================================================
		// Plano de atividades
		//===================================================================

		$string_erros_plano = $_POST["local"].";";
		$string_erros_plano .= $_POST["carga-h"].";";
		$string_erros_plano .= $_POST["data"].";";
		$string_erros_plano .= $_POST["segunda"].";".$_POST["segunda"].";";
		$string_erros_plano .= $_POST["terca"].";".$_POST["terca"].";";
		$string_erros_plano .= $_POST["quarta"].";".$_POST["quarta"].";";
		$string_erros_plano .= $_POST["quinta"].";".$_POST["quinta"].";";
		$string_erros_plano .= $_POST["sexta"].";".$_POST["sexta"].";";
		$string_erros_plano .= $_POST["sabado"].";".$_POST["sabado"].";";
		$string_erros_plano .= $_POST["descricao"];

		$id_plano = mysqli_real_escape_string($mysqli, $_POST["plano"]);
		$string_erros_plano = mysqli_real_escape_string($mysqli, $string_erros_plano);

		$pos = strpos($string_erros_plano, "1");

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

		if( isset($_POST["botaoAprova"])){
			if(AvaliaPlanoDeAtividades($mysqli, $id_plano, $string_erros_plano, $status)===false){
				header("Location:../documentos-pendentes.php"); /* Redirect browser */
			}
		}else{

	 		$LocalErro = mysqli_real_escape_string($mysqli, $_POST['LocalErro']);
			$dataEntregaErro = mysqli_real_escape_string($mysqli, $_POST['dataEntregaErro']);
			$cargaHorariaErro = mysqli_real_escape_string($mysqli, $_POST['cargaHorariaErro']);
			$horariosErro = mysqli_real_escape_string($mysqli, $_POST['horariosErro']);
			$descricao = mysqli_real_escape_string($mysqli, $_POST['comentariosErro']);

			if(AvaliaPlanoDeAtividadesComComentarios($mysqli, $id_plano, $string_erros_plano, $status, $LocalErro,$dataEntregaErro ,$cargaHorariaErro ,$horariosErro ,$descricao )===false){
				header("Location:../documentos-pendentes.php"); /* Redirect browser */
			}

			$estagioAprovado = false;
		}


		if($_SESSION['auto'] == "P" ){
			$permissao = mysqli_query( $mysqli , "SELECT * FROM termo_de_compromisso WHERE Id_Estagio='".$idEstagio."'") or die(mysqli_error($mysqli));
			$permissao = mysqli_fetch_assoc($permissao);
		}else if($_SESSION["auto"] == "V"){
			$permissao = true;
		}else{
			$permissao = null;
		}

		if($permissao===null){

			$_SESSION["Failed"] = "Acesso negado! ";
			header("Location:../documentos-pendentes.php"); /* Redirect browser */

		}else{

			if(isset($_POST['botaoAprova'])){
				AvaliaTermoDeCompromisso($mysqli, $idEstagio, "Aceitar");
			}
			elseif(isset($_POST['botaoReprova'])){
				AvaliaTermoDeCompromisso($mysqli, $idEstagio, "Recusar");
				$estagioAprovado = false;
			}
			else{
				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../documentos-pendentes.php"); /* Redirect browser */
			}
		}

		if($estagioAprovado){

			if($_SESSION["auto"] == "P"){
				$status = "presidente";
			}
			elseif($_SESSION["auto"] == "V"){
				$status = "entrega";//relatorio
			}

			atualizaEstadoEstagio($mysqli,$idEstagio, $string_erros_estagio, $id_plano ,$string_erros_plano, $status );
			$_SESSION["Success"] = "Estágio aprovado com sucesso.";
		}
		else{
			atualizaEstadoEstagio($mysqli,$idEstagio, $string_erros_estagio, $id_plano ,$string_erros_plano, "alterar" );
			$_SESSION["Success"] = "Estágio reprovado com sucesso.";
		}

		header("Location:../documentos-pendentes.php"); /* Redirect browser */

	}else{
		$_SESSION["Failed"] = "Paramêtros incorretos.";
		header("Location:../meus-estagios.php"); /* Redirect browser */
	}

	?>