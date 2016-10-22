<?php	

function AvaliaPlanoDeAtividades($conexao, $id_plano, $erros, $status){

	$id_pessoa = mysqli_real_escape_string($conexao, $_SESSION["id"]);

	if($_SESSION["auto"] == "P"){
		$autorizacao_query = "SELECT * 
							  FROM `plano_de_atividades` INNER JOIN `estagio` ON `plano_de_atividades`.`Id_Estagio` = `estagio`.`Id_Estagio`
							  WHERE `plano_de_atividades`.`Id_Plano_De_Atividades`='".$id_plano."' AND
							  		`plano_de_atividades`.`Status`='supervisor' AND  
							  		`estagio`.`Id_Supervisor` = '".$id_pessoa."'";

		$autorizacao = mysqli_query($conexao, $autorizacao_query);

		if(mysqli_num_rows($autorizacao) == 1){
			$atualiza_erros_query = "UPDATE plano_de_atividades SET Erros = '".$erros."', Status='".$status."' WHERE Id_Plano_De_Atividades='".$id_plano."'";
			$atualiza_erros = mysqli_query($conexao, $atualiza_erros_query);
			$_SESSION["Success"] = "Plano de atividades aprovado com sucesso.";
		}
		else{
			$_SESSION["Failed"] = "Você não tem permissão para alterar esse plano de atividades.";
		}
	}

	elseif($_SESSION["auto"] == "V"){
		$autorizacao_query = "SELECT *
							  FROM plano_de_atividades
							  WHERE Id_Plano_De_Atividades=".$id_plano." AND
							  		( Status='presidente' OR Status='aprovado' )";
		
		$autorizacao = mysqli_query($conexao, $autorizacao_query);

		if(mysqli_num_rows($autorizacao) >= 1){

			if($status=="aprovado"){
				$row = mysqli_fetch_assoc($autorizacao);

				$query = "UPDATE estagio SET Status='relatorio' WHERE Id_Estagio='".$row['Id_Estagio']."'";
				
				$result = mysqli_query($conexao, $query) or die(mysql_error($conexao));

			}
			//$atualiza_erros_query = "UPDATE plano_de_atividades SET Erros = '".$erros."', Status='".$status."' WHERE Id_Plano_De_Atividades='".$id_plano."'";
			//$atualiza_erros = mysqli_query($conexao, $atualiza_erros_query) or die(mysql_error($conexao));

			$remove_comentarios_query = "DELETE FROM comentario_plano_de_atividades WHERE Id_Plano_De_Atividades='".$id_plano."'";
			$remove_comentarios = mysqli_query($conexao, $remove_comentarios_query) or die(mysql_error($conexao));

			$_SESSION["Success"] = "Plano de atividades aprovado com sucesso.";
			return true;
		}
		else{
			$_SESSION["Failed"] = "Você não tem permição para alterar esse plano de atividades.";
			return false;	
		} 
	}
}

function AvaliaPlanoDeAtividadesComComentarios($conexao, $id_plano, $string_erros, $status, $local,$dataEntregaErro ,$cargaHorariaErro ,$horariosErro ,$descricao ){

	$id_pessoa = mysqli_real_escape_string($conexao, $_SESSION["id"]);

	if($_SESSION["auto"] == "P"){
		$autorizacao_query = "SELECT * 
							  FROM `plano_de_atividades` INNER JOIN `estagio` ON `plano_de_atividades`.`Id_Estagio` = `estagio`.`Id_Estagio`
							  WHERE `plano_de_atividades`.`Id_Plano_De_Atividades`='".$id_plano."' AND
							  		`plano_de_atividades`.`Status`='supervisor' AND  
							  		`estagio`.`Id_Supervisor` = '".$id_pessoa."'";

		$autorizacao = mysqli_query($conexao, $autorizacao_query);

		if(mysqli_num_rows($autorizacao) == 1){
			
			//$atualiza_erros_query = "UPDATE plano_de_atividades SET Erros = '".$string_erros."', Status='".$status."' WHERE Id_Plano_De_Atividades='".$id_plano."'";
			//$atualiza_erros = mysqli_query($conexao, $atualiza_erros_query);

			$sql = mysqli_query($conexao, 	"INSERT INTO comentario_plano_de_atividades (Id_Plano_De_Atividades, Comentario_Local, Comentario_Carga, Comentario_Horarios, Comentario_Descricao, Comentario_Data)
											VALUES(
												'$id_plano',
												'$local',
												'$cargaHorariaErro',
												'$horariosErro',
												'$descricao',
												'$dataEntregaErro')
												")or 
				   mysqli_query($conexao, 	"UPDATE comentario_plano_de_atividades
											SET	
												Comentario_Local= '$local',
												Comentario_Carga= '$cargaHorariaErro',
												Comentario_Horarios= '$horariosErro' ,
												Comentario_Descricao= '$descricao',
												Comentario_Data= '$dataEntregaErro'
											WHERE Id_Plano_De_Atividades='".$id_plano."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));


			$_SESSION["Success"] = "Plano de atividades reprovado com sucesso.";
		}
		else{
			$_SESSION["Failed"] = "Você não tem permição para alterar esse plano de atividades.";
		}
	}

	elseif($_SESSION["auto"] == "V"){
		$autorizacao_query = "SELECT *
							  FROM plano_de_atividades
							  WHERE Id_Plano_De_Atividades='".$id_plano."' AND
							  		( Status='presidente' OR Status='aprovado' )";
		$autorizacao = mysqli_query($conexao, $autorizacao_query);

		if(mysqli_num_rows($autorizacao) == 1){
			
			//$atualiza_erros_query = "UPDATE plano_de_atividades SET Erros = '".$string_erros."', Status='".$status."' WHERE Id_Plano_De_Atividades='".$id_plano."'";
			//$atualiza_erros = mysqli_query($conexao, $atualiza_erros_query);
				
				$sql = mysqli_query($conexao, 	"INSERT INTO comentario_plano_de_atividades (Id_Plano_De_Atividades, Comentario_Local, Comentario_Carga, Comentario_Horarios, Comentario_Descricao, Comentario_Data)
											VALUES(
												'$id_plano',
												'$local',
												'$cargaHorariaErro',
												'$horariosErro',
												'$descricao',
												'$dataEntregaErro')
												")or 
				   mysqli_query($conexao, 	"UPDATE comentario_plano_de_atividades
											SET	
												Comentario_Local= '$local',
												Comentario_Carga= '$cargaHorariaErro',
												Comentario_Horarios= '$horariosErro' ,
												Comentario_Descricao= '$descricao',
												Comentario_Data= '$dataEntregaErro'
											WHERE Id_Plano_De_Atividades='".$id_plano."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));

			$_SESSION["Success"] = "Plano de atividades reprovado com sucesso.";
		}
		else{
			$_SESSION["Failed"] = "Você não tem permição para alterar esse plano de atividades.";	
		} 
	}

}

function AtualizaPlanoDeAtividades($conexao,$id_plano,$id_estagio,$horarios,$carga,$descricao,$local,$data,$status,$erros){



	$query = mysqli_query($conexao,"SELECT * FROM plano_de_atividades WHERE Id_Plano_De_Atividades='".$id_plano."' AND Id_Estagio='".$id_estagio."' AND Id_Aluno='".$_SESSION['id']."'") or die(mysqli_error());
	$getNumero = mysqli_fetch_assoc($query);

	if(empty($getNumero)){
		$_SESSION["Failed"] = "Você não tem permição para alterar esse plano de atividades.";
	}
	else{

		$sql = mysqli_query($conexao, 	"UPDATE plano_de_atividades
										SET	
											Horario= '$horarios',
											Carga_Horaria= '$carga',
											Descricao= '$descricao',
											Local= '$local',
											Data= '".$data->format('Y-m-d')."',
											Status='$status',
											Erros = '$erros'
										WHERE Id_Plano_De_Atividades='".$id_plano."' AND Id_Aluno='".$_SESSION["id"]."' AND Id_Estagio='".$id_estagio."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));
	}
	
	header("Location:../documentos-estagio.php?idEstagio=".$id_estagio); /* Redirect browser */
	
}


function InserirPlanoDeAtividades($conexao,$id_estagio,$horarios,$carga,$descricao,$local,$data,$time_stamp,$status){


	$query = mysqli_query($conexao,"SELECT * FROM estagio WHERE Id_Estagio='".$id_estagio."' AND Id_Aluno='".$_SESSION['id']."'") or die(mysqli_error($conexao));
	$getNumero = mysqli_fetch_assoc($query);

	if(empty($getNumero)){
		$_SESSION["Failed"] = "Você não tem permissão para adicionar esse plano de atividades.";
	}
	else{

	$sql = mysqli_query($conexao, "INSERT INTO plano_de_atividades(
																		Id_Aluno,
																		Id_Estagio,
																		Horario,
																		Carga_Horaria, 
																		Descricao,
																		Local,
																		Data,
																		Hora_Do_Envio,
																		Status
																		)VALUES (
																		'".$_SESSION['id']."', 
																		'$id_estagio',
																		'$horarios',
																		'$carga',
																		'$descricao',
																		'$local',
																		'".$data->format('Y-m-d')."',																	
																		'$time_stamp',
																		'$status'
																		)"
																		)or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));

	}

}

function RemovePlanoDeAtividades($conexao, $id_estagio, $id_plano){
	
// Sim, dava pra fazer em uma, mas fazer o que...
    if($_SESSION['auto'] == 'E' ) {
        $query = mysqli_query($conexao, "SELECT * FROM plano_de_atividades WHERE Id_Plano_De_Atividades='" . $id_plano . "' AND Id_Estagio='" . $id_estagio . "' AND Id_Aluno='" . $_SESSION['id'] . "'") or die(mysqli_error($conexao));
    }else{
        $query = mysqli_query($conexao, "SELECT * FROM plano_de_atividades WHERE Id_Plano_De_Atividades='" . $id_plano . "' AND Id_Estagio='" . $id_estagio ."'") or die(mysqli_error($conexao));

    }

    $getNumero = mysqli_fetch_assoc($query);

	if(empty($getNumero)){
		$_SESSION["Failed"] = "Você não tem permição para alterar esse plano de atividades.";
	}
	else{
		$sql = mysqli_query($conexao, "DELETE FROM plano_de_atividades WHERE id_plano_de_atividades='".$id_plano."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));
	}

}


function ListaPlanoDeAtividades($conexao, $id_estagio=NULL, $id_plano=NULL){
	$condicao = "";
	$lista_planos = array();

	if(!is_null($id_estagio) && $id_estagio != ""){

        $id_estagio = mysqli_real_escape_string($conexao, $id_estagio);

        if(!is_null($id_plano) && $id_plano != ""){
            $id_plano = mysqli_real_escape_string($conexao, $id_plano);
            $condicao = "WHERE Id_Estagio='$id_estagio' AND Id_Plano_De_Atividades='$id_plano'";
        }else{
            $condicao = "WHERE Id_Estagio='$id_estagio'";
        }
    }

	$planos = mysqli_query($conexao, "SELECT * FROM plano_de_atividades $condicao");

	while($row = mysqli_fetch_assoc($planos)){

		array_push($lista_planos, $row);
	}


	return $lista_planos;
}


?>