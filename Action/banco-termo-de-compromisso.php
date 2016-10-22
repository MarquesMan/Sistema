<?php
function InsereTermoDeCompromisso($conexao, $Id_Estagio, $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo){
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

	//Verifica se já não possui termo de compromisso
	$query = "SELECT Id_Estagio FROM termo_de_compromisso WHERE Id_Estagio = $Id_Estagio";
	$autorizacao = mysqli_query($conexao, $query);

	if(mysqli_num_rows($autorizacao) > 0){
		//	$_SESSION["Failed"] = "Já possui Termo de Compromisso.";
		//	return;
		$query = "UPDATE termo_de_compromisso 
		  SET Nome_Termo    = '$NomeArquivo',
		      Tamanho_Termo = '$TamanhoArquivo',
		      Tipo_Termo 	= '$TipoArquivo', 
		      Arquivo_Termo = '$conteudo', 
		      Status_Termo  = 'supervisor'
		 WHERE Id_Estagio = $Id_Estagio";
	
	}else{
		//Insere Termo de Compromisso
		$query = "INSERT INTO termo_de_compromisso ( Id_Estagio, Nome_Termo, Tamanho_Termo, Tipo_Termo, Arquivo_Termo, Status_Termo) ".
				 "VALUES ($Id_Estagio, '$NomeArquivo', '$TamanhoArquivo', '$TipoArquivo', '$conteudo', 'supervisor')";
	
	}

	mysqli_query($conexao, $query) or die();

	$_SESSION["Success"] = "Termo de compromisso inserido com sucesso.";

	return;
}

function AlteraTermoDeCompromisso($conexao, $Id_Estagio, $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo){
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
		$_SESSION["Failed"] = "Já possui Termo de Compromisso.";
		return;
	}

	//Verifica se já não possui termo de compromisso
	$query = "SELECT Id_Estagio FROM termo_de_compromisso WHERE Id_Estagio = $Id_Estagio AND Status_Termo = 'alterar'";
	

	$autorizacao = mysqli_query($conexao, $query);

	if(mysqli_num_rows($autorizacao) != 1){
		$_SESSION["Failed"] = "Ainda não possui Termo de Compromisso para alteração.";
		return;
	}

	//Insere Termo de Compromisso
	$query = "UPDATE termo_de_compromisso 
			  SET Nome_Termo    = '$NomeArquivo',
			      Tamanho_Termo = '$TamanhoArquivo',
			      Tipo_Termo 	= '$TipoArquivo', 
			      Arquivo_Termo = '$conteudo', 
			      Status_Termo  = 'supervisor'
			 WHERE Id_Estagio = $Id_Estagio";

	$result = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

	if($result)
		$_SESSION["Success"] = "Termo de compromisso alterado com sucesso.";
	else
		$_SESSION["Success"] = "Erro interno do sistema. Por Favor tente mais tarde.";

	return;
}

function ListaTermoDeCompromisso($conexao, $dados = false, $Id_Estagio = ""){
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

		$query = "SELECT * FROM termo_de_compromisso  WHERE Id_Estagio = $Id_Estagio";

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

			$query = "SELECT Id_Estagio, Id_Termo, Nome_Termo, Status_Termo, usuarios.*
				      FROM (termo_de_compromisso NATURAL JOIN estagio)
				      		INNER JOIN usuarios ON estagio.Id_Aluno = Id_Usuario
				      WHERE Id_Estagio = $Id_Estagio";
		}

		else{
			if($_SESSION["auto"] == "E"){
				$query = "SELECT Id_Estagio,Id_Termo, Nome_Termo, Status_Termo, usuarios.*
						  FROM (termo_de_compromisso  NATURAL JOIN estagio)
						  	    INNER JOIN usuarios ON estagio.Id_Aluno = Id_Usuario 
						  WHERE Id_Aluno = $id";
			}

			elseif($_SESSION["auto"] == "P"){
				$query = "SELECT Id_Estagio, Id_Termo, Nome_Termo, Status_Termo, usuarios.*
						  FROM (termo_de_compromisso  NATURAL JOIN estagio)
						  	    INNER JOIN usuarios ON estagio.Id_Aluno = Id_Usuario 
						  WHERE Id_Supervisor = $id";
			}

			elseif($_SESSION["auto"] == "V"){
				$curso = mysqli_real_escape_string($conexao, $_SESSION["curso"]);

				$query = "SELECT Id_Estagio, Id_Termo ,Nome_Termo, Status_Termo, usuarios.*
						  FROM (estagio INNER JOIN usuarios ON estagio.Id_Aluno = usuarios.Id_Usuario)
						  	   NATURAL JOIN termo_de_compromisso
						  WHERE Id_Curso = $curso";				
			}
			else{
				$_SESSION["Failed"] = "Autorização negada para acessar a página.";
				return false;
				exit();
			}
		}
	}	

	$result = mysqli_query($conexao, $query);

	$lista_termo = array();

	while($row = mysqli_fetch_assoc($result)){
		array_push($lista_termo, $row);
	}

	return $lista_termo;
}

function submeteTermoDeCompromisso($conexao, $Id_Estagio){
	$Id_Estagio = mysqli_real_escape_string($conexao, $Id_Estagio);
	$id = mysqli_real_escape_string($conexao, $_SESSION["id"]);

	if($_SESSION["auto"] == "E"){
		$query = "SELECT Id_Estagio
				  FROM estagio NATURAL JOIN termo_de_compromisso
				  WHERE Id_Estagio = $Id_Estagio AND Id_Aluno = $id ";	
	}
	else{
		$_SESSION["Failed"] = "Não possui permição para realizar essa operação.";
		return false;
		exit();
	}

	$autorizacao = mysqli_query($conexao, $query);

	if(mysqli_num_rows($autorizacao) != 1){
		$_SESSION["Failed"] = "Não possui autorização para alterar esse documento.";
		return false;
		exit();
	}

	$query = "UPDATE termo_de_compromisso 
		  		SET  Status_Termo  = 'supervisor'
		 WHERE Id_Estagio = $Id_Estagio";

	mysqli_query($conexao, $query) or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao)); 

}

function RemoveTermoDeCompromisso($conexao, $id_estagio, $id_termo){

    $id_termo = mysqli_real_escape_string($conexao,$id_termo);
    $id_estagio = mysqli_real_escape_string($conexao,$id_estagio);

    if($_SESSION['auto'] == 'E' ) {
        $query = mysqli_query($conexao, "SELECT * FROM termo_de_compromisso WHERE Id_Termo='" . $id_termo . "' AND Id_Estagio='" . $id_estagio . "' AND Id_Aluno='" . $_SESSION['id'] . "'") or die(mysqli_error($conexao));
    }else{
        $query = mysqli_query($conexao, "SELECT * FROM termo_de_compromisso WHERE Id_Termo='" . $id_termo . "' AND Id_Estagio='" . $id_estagio ."'") or die(mysqli_error($conexao));

    }

    $getNumero = mysqli_fetch_assoc($query);

    if(empty($getNumero)){
        $_SESSION["Failed"] = "Você não tem permição para alterar esse Termo de Compromisso.";
    }
    else{
        $sql = mysqli_query($conexao, "DELETE FROM termo_de_compromisso WHERE Id_Termo='".$id_termo."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));
    }

}

function AvaliaTermoDeCompromisso($conexao, $Id_Estagio, $avaliacao){
	$Id_Estagio = mysqli_real_escape_string($conexao, $Id_Estagio);
	$id = mysqli_real_escape_string($conexao, $_SESSION["id"]);

	if($_SESSION["auto"] == "P"){
		$query = "SELECT Id_Estagio
				  FROM estagio NATURAL JOIN termo_de_compromisso
				  WHERE Id_Estagio = $Id_Estagio AND Id_Supervisor = $id AND Status_Termo = 'supervisor'";	
	}
	elseif($_SESSION["auto"] == "V"){
		$curso = mysqli_real_escape_string($conexao, $_SESSION["curso"]);
		
		/*$query = "SELECT Id_Estagio FROM estagio WHERE Id_Estagio='$Id_Estagio' AND "

		$autorizacao = mysqli_query($conexao, $query);

		if(mysqli_num_rows($autorizacao) != 1){
			$_SESSION["Failed"] = "Não possui autorização para alterar esse documento.";
			return false;
			exit();
		}*/

		$query = "SELECT estagio.Id_Estagio
				  FROM (estagio NATURAL JOIN termo_de_compromisso)
				  		INNER JOIN usuarios ON estagio.Id_Aluno = usuarios.Id_Usuario
				  WHERE Id_Estagio = $Id_Estagio AND Id_Curso = $curso AND (Status_Termo = 'presidente' OR Status_Termo = 'aprovado'  ) ";
	}
	else{
		$_SESSION["Failed"] = "Não possui permição para realizar essa operação.";
		return false;
		exit();
	}

	$autorizacao = mysqli_query($conexao, $query);

	if(mysqli_num_rows($autorizacao) != 1){
		$_SESSION["Failed"] = "Não possui autorização para alterar esse documento.";
		return false;
		exit();
	}

	/*if($avaliacao == "Aceitar"){
		if($_SESSION["auto"] == "P"){
			//$query = "UPDATE termo_de_compromisso SET Status_Termo = 'presidente' WHERE Id_Estagio = $Id_Estagio";
		}
		else{
			//$query = "UPDATE estagio SET Status = 'planoativ' WHERE Id_Estagio = $Id_Estagio";
			//$result = mysqli_query($conexao, $query) or die(mysql_error($conexao));
			//$query = "UPDATE termo_de_compromisso SET Status_Termo = 'aprovado' WHERE Id_Estagio = $Id_Estagio";
		}
	}

	elseif($avaliacao == "Recusar"){
		//$query = "UPDATE termo_de_compromisso SET Status_Termo = 'alterar' WHERE Id_Estagio = $Id_Estagio";
	}

	else{
		$_SESSION["Failed"] = "Ação desejada não reconhecida pelo sistema. Por Favor tente novamente.";
		return;
		exit();
	}

	$result = mysqli_query($conexao, $query) or die(mysql_error($conexao));

	if($result){
		$_SESSION["Success"] = "Termo de Compromisso avaliado com sucesso.";
		return true;
	}
	else{
		$_SESSION["Failed"] = "Erro ao avaliar Termo de Compromisso.";
		return false;
	}*/

	return;
	exit();
}

?>