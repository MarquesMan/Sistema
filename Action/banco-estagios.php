<?php 

function insereEstagio($conexao,$Modalidade,$Codigo_Area,$Codigo_Empresa,$DataInicial,$DataFinal,$Codigo_Supervisor,$Numero){


	$sql = mysqli_query($conexao, "INSERT INTO estagio(
														Id_Aluno,
														Id_Empresa, 
														Id_Supervisor, 
														Modalidade,
														Area,
														Data_Inicio,
														Data_Fim,
														Status
														)VALUES (
														'$Numero', 
														'$Codigo_Empresa', 
														'$Codigo_Supervisor',
														'$Modalidade',
														'$Codigo_Area',
														'".$DataInicial->format('Y-m-d')."',
														'".$DataFinal->format('Y-m-d')."',
														'supervisor'
														)"
														)or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));


}

function atualizaEstagio($conexao, $idEstagio ,$Modalidade,$Codigo_Area,$Codigo_Empresa,$DataInicial,$DataFinal,$Codigo_Supervisor,$Numero){

	$query = mysqli_query($conexao,"SELECT * FROM estagio WHERE Id_Estagio='".$idEstagio."' AND Id_Aluno='".$_SESSION['id']."'") or die(mysqli_error($conexao));
	$getNumero = mysqli_fetch_assoc($query);

	if(empty($getNumero)){
		$_SESSION["Failed"] = "Você não tem permição para alterar esse estagio.";
	}
	else{
		var_dump($DataInicial);

		$sql = mysqli_query($conexao, 	"UPDATE estagio
										SET	
											Id_Empresa= '$Codigo_Empresa',
											Id_Supervisor= '$Codigo_Supervisor',
											Modalidade= '$Modalidade',
											Area= '$Codigo_Area',
											Data_Inicio= '".$DataInicial->format('Y-m-d')."',
											Data_Fim= '".$DataFinal->format('Y-m-d')."',
											Status='supervisor',
											Erros = '0;0;0;0;0;0;0'
										WHERE Id_Aluno='".$_SESSION["id"]."' AND Id_Estagio='".$idEstagio."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));
	}

}

function EstadoEstagio($conexao, $id_estagio){

	$listaDeInteiros = $arrayName = array(
						'alterar'=> -2,
						'supervisor'=> -1,
						'presidente' => -1,
						'termocomp' => 0,
						'planoativ' => 1,
					    'relatorio'=> 2,
					    'relatfinal'=> 3,
					    'declaracao'=> 4,
					    'finalizado'=>5					    					    
						);

	$query = "SELECT Status
			  FROM estagio
			  WHERE Id_Estagio='$id_estagio'";	

	$estagio = mysqli_query($conexao, $query) or die(mysqli_error($conexao));
	$estagio = mysqli_fetch_assoc($estagio);
	$estagio = $estagio['Status'];



	return $listaDeInteiros[$estagio];

}

function TraduzEstadoEstagio($estado){

	$listaDeInteiros = $arrayName = array(
						'alterar'=> -2,
						'supervisor'=> -1,
						'presidente' => -1,
						'entrega' => -1.5,
						'termocomp' => 0,
						'planoativ' => 1,
					    'relatorio'=> 2,
					    'relatfinal'=> 3,
					    'declaracao'=> 4,
					    'finalizado'=>5						    					    
						);

	return $listaDeInteiros[$estado];

}

function ListaEstagios($conexao, $id_pessoa, $pessoa, $id_estagio=NULL){
	$lista_estagios = array();

	$id_pessoa = mysqli_real_escape_string($conexao, $id_pessoa);

	if($pessoa == "supervisor"){
        $query = "SELECT *
                  FROM estagio INNER JOIN usuarios on estagio.Id_Aluno=usuarios.Id_Usuario
                  WHERE estagio.Id_Supervisor='".$_SESSION['id']."'";
	}
	else if($pessoa == "aluno"){
        $query = "SELECT * FROM estagio WHERE Id_Aluno='$id_pessoa'";
	}
	else if($pessoa == "presidente" ){
        $query = "SELECT *
                  FROM estagio INNER JOIN usuarios on estagio.Id_Aluno=usuarios.Id_Usuario
                  WHERE usuarios.Id_Curso='".$_SESSION['curso']."'";

	}
	else{
		$_SESSION["Failed"] = "Usuário não reconhecido";
		header("Location: #");
		die();
	}

	if(!is_null($id_estagio) && $id_estagio != ""){
		$id_estagio = mysqli_real_escape_string($conexao, $id_estagio);
        $query .= " AND Id_Estagio='$id_estagio'";
	}


	$estagios = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

	while($row = mysqli_fetch_assoc($estagios)){
		array_push($lista_estagios, $row);
	}

	return $lista_estagios;
}

function EntregaDocumentosEstagio($conexao, $id_estagio){

    if($_SESSION["auto"] != 'V') {
        return false;
    }

    $id_estagio = mysqli_real_escape_string($conexao, $id_estagio);

    $query = "UPDATE termo_de_compromisso SET Status_Termo='aprovado' WHERE Id_Estagio=$id_estagio";

    $result = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

    if($result == false )
        return false;

    $query = "UPDATE plano_de_atividades SET Status='aprovado' WHERE Id_Estagio=$id_estagio";

    $result = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

    if($result == false )
        return false;

    $query = "UPDATE estagio SET Status='relatorio' WHERE Id_Estagio=$id_estagio";

    return mysqli_query($conexao, $query) or die(mysqli_error($conexao));

}

function AvaliaEstagio($conexao, $id_estagio, $acao){

	if($_SESSION["auto"] == 'P'){
				$pessoa = "supervisor";
	}
	elseif($_SESSION["auto"] == 'V') {
		$pessoa = "presidente";
	}
	else{
		$_SESSION["Failed"] = "Pessoa não autorizada a fazer esta ação.";
		header("Location: ../documentos-pendentes.php");
		die();
	}

	$id_estagio = mysqli_real_escape_string($conexao, $id_estagio);

	if($pessoa == "supervisor"){
		$condicao = "Id_Estagio='$id_estagio' AND Id_Supervisor='$_SESSION[id]' AND Status='supervisor'";
		$status = "presidente";
	}

	elseif($pessoa == "presidente"){
		$condicao = "Id_Estagio='$id_estagio' AND ( Status='presidente' OR Status='aprovado' )";
		$status = "termocomp";
	}

	else{
		$_SESSION["Failed"] = "Não autorizado a fazer esta ação.";
		return;
		die();
	}

	$permissao = mysqli_query($conexao, "SELECT * FROM estagio WHERE ".$condicao);
	
	if(mysqli_num_rows($permissao) > 0){

		if($acao == "Aceitar"){
			//mysqli_query($conexao, "UPDATE estagio SET Status='$status' WHERE Id_Estagio='$id_estagio'");
			$_SESSION["Success"] = "Estágio aprovado com sucesso.";
			//ja que temos de avaliar o estagio com ele ainda no estado de supervisor/presidente, nao podemos dar update ainda
			return true;
		}
		elseif($acao == "Recusar"){
			//mysqli_query($conexao, "UPDATE estagio SET Status='alterar' WHERE Id_Estagio='$id_estagio'");
			$_SESSION["Success"] = "Estágio recusado com sucesso.";
			//ja que temos de avaliar o estagio com ele ainda no estado de supervisor/presidente, nao podemos dar update ainda
			return true;
		}
		else{
			$_SESSION["Failed"] = "Ação não reconhecida. Por Favor tente novamente.";
			return false;
			die();
		}

	}
	else{
		$_SESSION["Failed"] = "Não tem autorização para avaliar este estágio.";
		return;
		die();
	}

}

function insereComentariosEstagio($conexao ,$id_estagio, $tipoEstagio, $supervisorErro, $empresaErro, $dataInicial, $DataFinal, $areaErro, $termoErro ){

	$sql = mysqli_query($conexao, 	"INSERT INTO comentario_estagio (Id_Estagio, Comentario_Empresa , Comentario_Supervisor, Comentario_Modalidade, Comentario_Area, Comentario_Data_Inicio, Comentario_Data_Fim, Comentario_Termo)
											VALUES(
												'$id_estagio',
												'$empresaErro',
												'$supervisorErro',
												'$tipoEstagio',
												'$areaErro',
												'$dataInicial',
												'$DataFinal',
												'$termoErro')
												")or 
				   mysqli_query($conexao, 	"UPDATE comentario_estagio
											SET	
												Comentario_Empresa = '$empresaErro',
												Comentario_Supervisor = '$supervisorErro',
												Comentario_Modalidade = '$tipoEstagio',
												Comentario_Area = '$areaErro',
												Comentario_Data_Inicio = '$dataInicial',
												Comentario_Data_Fim = '$DataFinal',
												Comentario_Termo = '$termoErro'
											WHERE Id_Estagio ='".$id_estagio."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));

			$_SESSION["Success"] = "Relatório avaliado com sucesso.";


}

function atualizaEstadoEstagio($conexao,$id_estagio, $string_erros_estagio, $id_plano ,$string_erros_plano, $status ){

		
	mysqli_query($conexao, "UPDATE estagio SET Status='$status', Erros='$string_erros_estagio' WHERE Id_Estagio='$id_estagio'");

	$atualiza_erros_query = "UPDATE plano_de_atividades SET Erros = '".$string_erros_plano."', Status='".$status."' WHERE Id_Plano_De_Atividades='".$id_plano."'";
	mysqli_query($conexao, $atualiza_erros_query) or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));
	
	if($string_erros_estagio[12]=="0")
		mysqli_query($conexao,"UPDATE termo_de_compromisso SET Status_Termo = 'aprovado' WHERE Id_Estagio = $id_estagio") or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));
	else
		mysqli_query($conexao,"UPDATE termo_de_compromisso SET Status_Termo = '$status' WHERE Id_Estagio = $id_estagio") or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));
}

?>