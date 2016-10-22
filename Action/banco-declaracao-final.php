<?php
function InsereDeclaracaoFinal($conexao, $Id_Estagio, $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo){
	$Id_Estagio  = mysqli_real_escape_string($conexao, $Id_Estagio);
	$id 		 = mysqli_real_escape_string($conexao, $_SESSION["id"]);

	//Verifica se é um aluno que está tentando inserir
	if($_SESSION["auto"] != "E"){
		$_SESSION["Failed"] = "Não tem permissão para realizar esta operação.";
		return;
	}

	//Verifica se Aluno pertence ao estágio
	$query = "SELECT Id_Estagio FROM estagio WHERE Id_Estagio = $Id_Estagio AND Id_Aluno = $id";
	$autorizacao = mysqli_query($conexao, $query);

	if(mysqli_num_rows($autorizacao) != 1){
		$_SESSION["Failed"] = "Não tem acesso a este estágio.";
		return;
	}

	//Verifica se já não possui Declaração Final
	$query = "SELECT Id_Estagio FROM declaracao_final WHERE Id_Estagio = $Id_Estagio";
	$autorizacao = mysqli_query($conexao, $query);

	if(mysqli_num_rows($autorizacao) > 0){
		$_SESSION["Failed"] = "Já possui Declaração Final.";
		return;
	}

	//Insere Declaração Final
	$query = "INSERT INTO declaracao_final (Id_Estagio, Nome_Declaracao, Tamanho_Declaracao, Tipo_Declaracao, Arquivo_Declaracao, Status_Declaracao) ".
			 "VALUES ( $Id_Estagio, '$NomeArquivo', '$TamanhoArquivo', '$TipoArquivo', '$conteudo', 'supervisor')";

	mysqli_query($conexao, $query) or die(mysqli_error($conexao));

	$_SESSION["Success"] = "Declaração final inserida com sucesso.";

	return;
}

function AlterarDeclaracaoFinal($conexao, $Id_Estagio, $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo){
	$Id_Estagio  = mysqli_real_escape_string($conexao, $Id_Estagio);
	$id 		 = mysqli_real_escape_string($conexao, $_SESSION["id"]);

	//Verifica se é um aluno que está tentando inserir
	if($_SESSION["auto"] != "E"){
		$_SESSION["Failed"] = "Não tem permissão para realizar esta operação.";
		return;
	}

	//Verifica se Aluno pertence ao estágio
	$query = "SELECT Id_Estagio FROM estagio WHERE Id_Estagio = $Id_Estagio AND Id_Aluno = $id";
	$autorizacao = mysqli_query($conexao, $query);

	if(mysqli_num_rows($autorizacao) != 1){
		$_SESSION["Failed"] = "Não tem acesso a este estágio.";
		return;
	}

	//Verifica se já não possui Declaração Final
	$query = "SELECT Id_Estagio FROM declaracao_final WHERE Id_Estagio = $Id_Estagio AND Status_Declaracao = 'alterar'";
	$autorizacao = mysqli_query($conexao, $query);

	if(mysqli_num_rows($autorizacao) != 1){
		$_SESSION["Failed"] = "Ainda não possui Declaração Final para alteração.";
		return;
	}

	//Insere Declaração Final
	$query = "UPDATE declaracao_final 
			  SET Nome_Declaracao 	 = '$NomeArquivo',
			  	  Tamanho_Declaracao = '$TamanhoArquivo',
			  	  Tipo_Declaracao 	 = '$TipoArquivo',
			  	  Arquivo_Declaracao = '$conteudo',
			  	  Status_Declaracao  = 'supervisor'
			 WHERE Id_Estagio = $Id_Estagio";

	$result = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

	if($result)
		$_SESSION["Success"] = "Declaração final alterarda com sucesso.";
	else
		$_SESSION["Success"] = "Erro interno do sistema. Por Favor tente mais tarde.";

	return;
}

function RemoveDeclaracao($conexao, $id_estagio, $id_declaracao){

    $id_declaracao = mysqli_real_escape_string($conexao,$id_declaracao);
    $id_estagio = mysqli_real_escape_string($conexao,$id_estagio);

    if($_SESSION['auto'] == 'E' ) {
        $query = mysqli_query($conexao, "SELECT * FROM declaracao_final WHERE Id_Declaracao='" . $id_declaracao . "' AND Id_Estagio='" . $id_estagio . "' AND Id_Aluno='" . $_SESSION['id'] . "'") or die(mysqli_error($conexao));
    }else{
        $query = mysqli_query($conexao, "SELECT * FROM declaracao_final WHERE Id_Declaracao='" . $id_declaracao . "' AND Id_Estagio='" . $id_estagio ."'") or die(mysqli_error($conexao));

    }

    $getNumero = mysqli_fetch_assoc($query);

    if(empty($getNumero)){
        $_SESSION["Failed"] = "Você não tem permição para alterar essa Declaração Final.";
    }
    else{
        $sql = mysqli_query($conexao, "DELETE FROM declaracao_final WHERE Id_Declaracao='".$id_declaracao."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));
    }

}

function ListaDeclaracaoFinal($conexao, $dados = false, $Id_Estagio = ""){
	$id = mysqli_real_escape_string($conexao, $_SESSION["id"]);
	$Id_Estagio = mysqli_real_escape_string($conexao, $Id_Estagio);

	if($dados){

		if($Id_Estagio == ""){
			$_SESSION["Failed"] = "Estágio não definido.";
			return false;
		}

		if($_SESSION["auto"] == "E"){
			$query = "SELECT Id_Estagio FROM estagio WHERE Id_Estagio = $Id_Estagio AND Id_Aluno = $id";
		}

		elseif($_SESSION["auto"] == "P"){
			$query = "SELECT Id_Estagio FROM estagio WHERE Id_Estagio = $Id_Estagio AND Id_Supervisor = $id";
		}

		elseif($_SESSION["auto"] == "V"){
			$curso = mysqli_real_escape_string($conexao, $_SESSION["curso"]);
			$query = "SELECT estagio.Id_Estagio
					  FROM estagio INNER JOIN usuarios ON estagio.Id_Aluno = usuarios.Id_Usuario
					  WHERE Id_Estagio = $Id_Estagio AND Id_Curso = $curso";
		}

		$result = mysqli_query($conexao, $query);

		if(mysqli_num_rows($result) != 1){
			$_SESSION["Failed"] = "Não tem permissão para acessar esse estagio.";
			return false;
		}

		$query = "SELECT * FROM declaracao_final  WHERE Id_Estagio = $Id_Estagio";

	}

	else{

		if($Id_Estagio != ""){

			if($_SESSION["auto"] == "E"){
				$query = "SELECT Id_Estagio FROM estagio WHERE Id_Estagio = $Id_Estagio AND Id_Aluno = $id";
			}

			elseif($_SESSION["auto"] == "P"){
				$query = "SELECT Id_Estagio FROM estagio WHERE Id_Estagio = $Id_Estagio AND Id_Supervisor = $id";
			}

			elseif($_SESSION["auto"] == "V"){
				$curso = mysqli_real_escape_string($conexao, $_SESSION["curso"]);
				$query = "SELECT estagio.Id_Estagio
						  FROM estagio INNER JOIN usuarios ON estagio.Id_Aluno = usuarios.Id_Usuario
						  WHERE Id_Estagio = $Id_Estagio AND Id_Curso = $curso";
			}
			else{
				$_SESSION["Failed"] = "Autorização negada para acessar a página.";
				return false;
				exit();
			}

			$result = mysqli_query($conexao, $query);

			if(mysqli_num_rows($result) != 1){
				$_SESSION["Failed"] = "Não tem permissão para acessar esse estagio.";
				return false;
			}

			$query = "SELECT Id_Estagio, Id_Declaracao, Comentario, Nome_Declaracao, Status_Declaracao, usuarios.*
				      FROM (declaracao_final NATURAL JOIN estagio)
				      		INNER JOIN usuarios ON estagio.Id_Aluno = Id_Usuario
				      WHERE Id_Estagio = $Id_Estagio";
		}

		else{
			if($_SESSION["auto"] == "E"){
				$query = "SELECT Id_Estagio, Id_Declaracao,Comentario,   Nome_Declaracao, Status_Declaracao, usuarios.*
						  FROM (declaracao_final  NATURAL JOIN estagio)
						  	    INNER JOIN usuarios ON estagio.Id_Aluno = Id_Usuario 
						  WHERE Id_Aluno = $id";
			}

			elseif($_SESSION["auto"] == "P"){
				$query = "SELECT Id_Estagio,  Id_Declaracao,Comentario, Nome_Declaracao, Status_Declaracao, usuarios.*
						  FROM (declaracao_final  NATURAL JOIN estagio)
						  	    INNER JOIN usuarios ON estagio.Id_Aluno = Id_Usuario 
						  WHERE Id_Supervisor = $id";
			}

			elseif($_SESSION["auto"] == "V"){
				$curso = mysqli_real_escape_string($conexao, $_SESSION["curso"]);

				$query = "SELECT Id_Estagio, Id_Declaracao,Comentario,  Nome_Declaracao, Status_Declaracao, usuarios.*
						  FROM (estagio INNER JOIN usuarios ON estagio.Id_Aluno = usuarios.Id_Usuario)
						  	   NATURAL JOIN declaracao_final
						  WHERE Id_Curso = $curso";
			}

			else{
				$_SESSION["Failed"] = "Autorização negada para acessar a página.";
				return false;
				exit();
			}
		}
	}	

	$result = mysqli_query($conexao, $query) or die();

	$lista_declaracao = array();
	while($row = mysqli_fetch_assoc($result)){
		array_push($lista_declaracao, $row);
	}
	
	return $lista_declaracao;
}

function EntregaDeclaracao($conexao, $idDeclaracao){

    if($_SESSION["auto"] != 'V') {
        return false;
    }

    $idRelatorio = mysqli_real_escape_string($conexao, $idDeclaracao);

    $query = "UPDATE declaracao_final SET Status_Declaracao='aprovado' WHERE Id_Declaracao=$idDeclaracao";

    return mysqli_query($conexao, $query) or die(mysqli_error($conexao));

}

function AvaliaDeclaracaoFinal($conexao, $Id_Estagio, $avaliacao, $comentario){
	$Id_Estagio = mysqli_real_escape_string($conexao, $Id_Estagio);
	$id 		= mysqli_real_escape_string($conexao, $_SESSION["id"]);
	$comentario = mysqli_real_escape_string($conexao, $comentario);


	if($_SESSION["auto"] == "P"){
		$query = "SELECT Id_Estagio
				  FROM estagio NATURAL JOIN declaracao_final
				  WHERE Id_Estagio = $Id_Estagio AND Id_Supervisor = $id AND Status_Declaracao = 'supervisor'";	
	}
	elseif($_SESSION["auto"] == "V"){
		$curso = mysqli_real_escape_string($conexao, $_SESSION["curso"]);
		$query = "SELECT estagio.Id_Estagio
				  FROM (estagio NATURAL JOIN declaracao_final)
				  		INNER JOIN usuarios ON estagio.Id_Aluno = usuarios.Id_Usuario
				  WHERE Id_Estagio = $Id_Estagio AND Id_Curso = $curso AND Status_Declaracao = 'presidente' ";

	}
	else{
		$_SESSION["Failed"] = "Não possui permição para realizar essa operação.";
		return;
		exit();
	}

	$autorizacao = mysqli_query($conexao, $query) or die( mysqli_error($conexao));

	if(mysqli_num_rows($autorizacao) == 0){
		$_SESSION["Failed"] = "Não possui autorização para alterar esse documento.";
		return;
		exit();
	}



	if($avaliacao == "Aceitar"){
		if($_SESSION["auto"] == "P"){
			$query = "UPDATE declaracao_final SET Status_Declaracao = 'presidente' WHERE Id_Estagio = $Id_Estagio";
		}
		else{
			$query = "UPDATE estagio SET Status='finalizado' WHERE Id_Estagio='".$Id_Estagio."'";
			$result = mysqli_query($conexao, $query) or die(mysql_error($conexao));
			$query = "UPDATE declaracao_final SET Status_Declaracao = 'entrega' WHERE Id_Estagio = $Id_Estagio";
		}
	}

	elseif($avaliacao == "Recusar"){

		$query = "UPDATE declaracao_final SET Status_Declaracao = 'alterar', Comentario='$comentario' WHERE Id_Estagio = $Id_Estagio";
	}

	else{
		$_SESSION["Failed"] = "Ação desejada não reconhecida pelo sistema. Por Favor tente novamente.";
		return;
		exit();
	}

	$result = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

	if($result){
		$_SESSION["Success"] = "Declaração avaliada com sucesso.";
	}
	else{
		$_SESSION["Failed"] = "Erro ao avaliar Declaração.";
	}

	return;
	exit();
}
