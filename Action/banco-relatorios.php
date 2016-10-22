<?php

function AvaliaRelatorio($conexao, $id_relatorio, $erros, $status){


	$id_pessoa = mysqli_real_escape_string($conexao, $_SESSION["id"]);

	if($_SESSION["auto"] == "P"){
		$autorizacao_query = "SELECT * FROM relatorio INNER JOIN estagio ON relatorio.Id_Estagio = estagio.Id_Estagio 
										WHERE relatorio.Id_Relatorio='".$id_relatorio."'AND relatorio.Status='supervisor' AND estagio.Id_Supervisor = '".$id_pessoa."'";

		$autorizacao = mysqli_query($conexao, $autorizacao_query)or die(mysqli_error($conexao));

		if(mysqli_num_rows($autorizacao) == 1){
			$atualiza_erros_query = "UPDATE relatorio SET Erros='$erros', Status='$status' WHERE Id_Relatorio='$id_relatorio'";
			$atualiza_erros = mysqli_query($conexao, $atualiza_erros_query) or die(mysqli_error($conexao));

			$_SESSION["Success"] = "Relatório alterado com sucesso.";
		}
		else{
			$_SESSION["Failed"] = "Você não tem permição para alterar esse relatório.";
		}
	}

	elseif($_SESSION["auto"] == "V"){



		$autorizacao_query = "SELECT *
							  FROM relatorio
							  WHERE Id_Relatorio='$id_relatorio' AND
							  		( Status='presidente' OR Status='entrega') ";



		$autorizacao = mysqli_query($conexao, $autorizacao_query);

		if(mysqli_num_rows($autorizacao) <= 1){
				$row = mysqli_fetch_assoc($autorizacao);

				

			if( ($status=="entrega")&&($row['Tipo']=="1")){
				$query = "UPDATE estagio SET Status='declaracao' WHERE Id_Estagio='".$row['Id_Estagio']."'";
				$result = mysqli_query($conexao, $query) or die(mysqli_error($conexao));
			}

			$atualiza_erros_query = "UPDATE relatorio SET Erros='$erros', Status='$status' WHERE Id_Relatorio='$id_relatorio'";
			$atualiza_erros = mysqli_query($conexao, $atualiza_erros_query)or die(mysqli_error($conexao));


			$_SESSION["Success"] = "Relatório avaliado com sucesso.";
		}
		else{
			$_SESSION["Failed"] = "Você não tem permição para alterar esse relatório.";	
		} 
	}

}

function AvaliaRelatorioComNotas($conexao, $id_relatorio, $erros, $status, $notas, $observacao ){

	$id_pessoa = mysqli_real_escape_string($conexao, $_SESSION["id"]);

	if($_SESSION["auto"] == "P"){
		$autorizacao_query = "SELECT * FROM relatorio INNER JOIN estagio ON relatorio.Id_Estagio = estagio.Id_Estagio 
										WHERE relatorio.Id_Relatorio='".$id_relatorio."'AND relatorio.Status='supervisor' AND estagio.Id_Supervisor = '".$id_pessoa."'";

		$autorizacao = mysqli_query($conexao, $autorizacao_query)or die(mysqli_error($conexao));


		if(mysqli_num_rows($autorizacao) == 1){
			$atualiza_erros_query = "UPDATE relatorio SET Erros='$erros', Status='$status',Observacao='$observacao',Avaliacao='$notas' WHERE Id_Relatorio='$id_relatorio'";
			$atualiza_erros = mysqli_query($conexao, $atualiza_erros_query) or die(mysqli_error($conexao));

			$_SESSION["Success"] = "Relatório avaliado com sucesso.";
		}
		else{
			$_SESSION["Failed"] = "Você não tem permição para alterar esse relatório.";
		}
	}

	elseif($_SESSION["auto"] == "V"){
		$autorizacao_query = "SELECT *
							  FROM relatorio
							  WHERE Id_Relatorio='$id_relatorio' AND
							  		( Status='presidente' AND Status='aprovado' )";

		$autorizacao = mysqli_query($conexao, $autorizacao_query);

		if(mysqli_num_rows($autorizacao) <= 1){

			$atualiza_erros_query = "UPDATE relatorio SET Erros='$erros', Status='$status' WHERE Id_Relatorio='$id_relatorio'";
			$atualiza_erros = mysqli_query($conexao, $atualiza_erros_query);



			$_SESSION["Success"] = "Plano de atividades alterado com sucesso.";
		}
		else{
			$_SESSION["Failed"] = "Você não tem permição para alterar esse plano de atividades.";	
		} 
	}	



}

function AvaliaRelatorioComComentarios($conexao, $id_relatorio, $erros, $status, $tipoRelatorioErro,$dataInicialErro,$dataFinalErro,$atividadesErro,$comentariosErro){


	$id_pessoa = mysqli_real_escape_string($conexao, $_SESSION["id"]);

	if($_SESSION["auto"] == "P"){
		$autorizacao_query = "SELECT * FROM relatorio INNER JOIN estagio ON relatorio.Id_Estagio = estagio.Id_Estagio 
										WHERE relatorio.Id_Relatorio='".$id_relatorio."'AND relatorio.Status='supervisor' AND estagio.Id_Supervisor = '".$id_pessoa."'";

		$autorizacao = mysqli_query($conexao, $autorizacao_query)or die(mysqli_error($conexao));

		if(mysqli_num_rows($autorizacao) == 1){
			$atualiza_erros_query = "UPDATE relatorio SET Erros='$erros', Status='$status' WHERE Id_Relatorio='$id_relatorio'";
			$atualiza_erros = mysqli_query($conexao, $atualiza_erros_query) or die(mysqli_error($conexao));


			$sql = mysqli_query($conexao, 	"INSERT INTO comentario_relatorio (Id_Relatorio, Comentario_Tipo_Relatorio, Comentario_Data_Inicial, Comentario_Data_Final, Comentario_Atividades, Comentario_Comentario)
											VALUES(
												'$id_relatorio',
												'$tipoRelatorioErro',
												'$dataInicialErro',
												'$dataFinalErro',
												'$atividadesErro',
												'$comentariosErro')
												")or 
				   mysqli_query($conexao, 	"UPDATE comentario_relatorio
											SET	
												Id_Relatorio= '$id_relatorio',
												Comentario_Tipo_Relatorio= '$tipoRelatorioErro',
												Comentario_Data_Inicial= '$dataInicialErro',
												Comentario_Data_Final= '$dataFinalErro',
												Comentario_Atividades= '$atividadesErro',
												Comentario_Comentario= '$comentariosErro'
											WHERE Id_Relatorio='".$id_relatorio."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));

			$_SESSION["Success"] = "Relatório avaliado com sucesso.";
		}
		else{
			$_SESSION["Failed"] = "Você não tem permissão para alterar esse relatório.";
		}
	}

	elseif($_SESSION["auto"] == "V"){
		$autorizacao_query = "SELECT *
							  FROM relatorio
							  WHERE Id_Relatorio='$id_relatorio' AND
							  		( Status='presidente' AND Status='aprovado' )";

		$autorizacao = mysqli_query($conexao, $autorizacao_query);

		if(mysqli_num_rows($autorizacao) <= 1){

			$atualiza_erros_query = "UPDATE relatorio SET Erros='$erros', Status='$status' WHERE Id_Relatorio='$id_relatorio'";
			$atualiza_erros = mysqli_query($conexao, $atualiza_erros_query);

			$sql = mysqli_query($conexao, 	"INSERT INTO comentario_relatorio (Id_Relatorio, Comentario_Tipo_Relatorio, Comentario_Data_Inicial, Comentario_Data_Final, Comentario_Atividades, Comentario_Comentario)
											VALUES(
												'$id_relatorio',
												'$tipoRelatorioErro',
												'$dataInicialErro',
												'$dataFinalErro',
												'$atividadesErro',
												'$comentariosErro')
												")or 
				   mysqli_query($conexao, 	"UPDATE comentario_relatorio
											SET	
												Id_Relatorio= '$id_relatorio',
												Comentario_Tipo_Relatorio= '$tipoRelatorioErro',
												Comentario_Data_Inicial= '$dataInicialErro',
												Comentario_Data_Final= '$dataFinalErro',
												Comentario_Atividades= '$atividadesErro',
												Comentario_Comentario= '$comentariosErro'
											WHERE Id_Relatorio='".$id_relatorio."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));

			$_SESSION["Success"] = "Relatório avaliado com sucesso.";
		}
		else{
			$_SESSION["Failed"] = "Você não tem permissão para alterar esse plano de atividades.";	
		} 
	}



}

function ListaRelatorio($conexao, $id_estagio=NULL, $id_relatorio = NULL){

    $condicao = "";
	$lista_ralatorios = array();
	$estagioIsDefined = !is_null($id_estagio) && $id_estagio != "";
	$relatorioIsDefined = !is_null($id_relatorio) && $id_relatorio != "";

    if($estagioIsDefined && $relatorioIsDefined){

        $id_estagio = mysqli_real_escape_string($conexao, $id_estagio);
        $id_relatorio = mysqli_real_escape_string($conexao, $id_relatorio);
        $condicao = "WHERE Id_Estagio='$id_estagio' AND Id_Relatorio='$id_relatorio'";

    }elseif($estagioIsDefined){
    	$id_estagio = mysqli_real_escape_string($conexao, $id_estagio);
    	$condicao = "WHERE Id_Estagio='$id_estagio'";
    }elseif($relatorioIsDefined){
    	$id_relatorio = mysqli_real_escape_string($conexao, $id_relatorio);
    	$condicao = "WHERE Id_Relatorio='$id_relatorio'";
    }

	$relatorio = mysqli_query($conexao, "SELECT * FROM relatorio $condicao ORDER BY Hora_Do_Envio DESC");

	while($row = mysqli_fetch_assoc($relatorio)){
		array_push($lista_ralatorios, $row);
	}

	return $lista_ralatorios;
}

function InsereRelatorio($conexao, $Numero, $idEstagio, $tiporelatorio, $datainicial, $datafinal, $atividades, $comaluno){

		$datainicial = $datainicial->format('Y/m/d H:i:s');
		$datafinal = $datafinal->format('Y/m/d H:i:s');

		$sql = mysqli_query($conexao, 	"INSERT INTO relatorio (Id_Aluno,Id_Estagio,Tipo,Data_Inicio,Data_Fim,Atividades,Comentario_Aluno,Status,Erros)
											VALUES(
												'".$_SESSION['id']."',
												'$idEstagio',
												'$tiporelatorio',
												'$datainicial',
												'$datafinal',
												'$atividades',
												'$comaluno',
												'alterar',
												'0;0;0;0;0')
												")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));
	

}

function AtualizaRelatorio($conexao, $Numero, $id_relatorio, $idEstagio, $tiporelatorio, $datainicial, $datafinal, $atividades, $comaluno, $erros, $status){

	$datainicial = $datainicial->format('Y/m/d H:i:s');
	$datafinal = $datafinal->format('Y/m/d H:i:s');

	$query = mysqli_query($conexao,"SELECT * FROM relatorio WHERE Id_Relatorio='".$id_relatorio."' AND Id_Estagio='".$idEstagio."' AND Id_Aluno='".$_SESSION['id']."'") or die(mysqli_error());
	$getNumero = mysqli_fetch_assoc($query);

	if(empty($getNumero)){
		$_SESSION["Failed"] = "Você não tem permissão para alterar esse plano de atividades.";
	}
	else{

		$sql = mysqli_query($conexao, 	"UPDATE relatorio
											SET	
												Tipo= '$tiporelatorio',
												Data_Inicio= '$datainicial',
												Data_Fim= '$datafinal',
												Atividades= '$atividades',
												Comentario_Aluno= '$comaluno',
												Status='$status',
												Erros='$erros'
											WHERE Id_Relatorio='".$id_relatorio."' AND Id_Aluno='".$Numero."' AND Id_Estagio='".$idEstagio."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));
	}

}

function EntregaRelatorio($conexao, $idRelatorio){

    if($_SESSION["auto"] != 'V') {
        return false;
    }

    $idRelatorio = mysqli_real_escape_string($conexao, $idRelatorio);

    $query = "UPDATE relatorio SET Status='aprovado' WHERE Id_Relatorio=$idRelatorio";

    return mysqli_query($conexao, $query) or die(mysqli_error($conexao));

}

function RemoveRelatorio($conexao, $id_estagio, $id_relatorio){

    $id_relatorio = mysqli_real_escape_string($conexao,$id_relatorio);
    $id_estagio = mysqli_real_escape_string($conexao,$id_estagio);

    if($_SESSION['auto'] == 'E' ) {
        $query = mysqli_query($conexao, "SELECT * FROM relatorio WHERE Id_Relatorio='" . $id_relatorio . "' AND Id_Estagio='" . $id_estagio . "' AND Id_Aluno='" . $_SESSION['id'] . "'") or die(mysqli_error($conexao));
    }else{
        $query = mysqli_query($conexao, "SELECT * FROM relatorio WHERE Id_Relatorio='" . $id_relatorio . "' AND Id_Estagio='" . $id_estagio ."'") or die(mysqli_error($conexao));

    }

    $getNumero = mysqli_fetch_assoc($query);

    if(empty($getNumero)){
        $_SESSION["Failed"] = "Você não tem permição para alterar esse relatório.";
    }
    else{
        $sql = mysqli_query($conexao, "DELETE FROM relatorio WHERE Id_Relatorio='".$id_relatorio."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));
    }

}
