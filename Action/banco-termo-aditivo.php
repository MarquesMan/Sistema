<?php

function atualizaTermoAditivo($conexao, $IdTermoAditivo , $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo, $data){

    $IdTermoAditivo  = mysqli_real_escape_string($conexao, $IdTermoAditivo);

    //Verifica se já não possui termo de compromisso
    $query = "SELECT *
				  FROM (SELECT Id_Estagio
				  		FROM estagio INNER JOIN usuarios ON estagio.Id_Aluno=usuarios.Id_Usuario
				  		where Id_Aluno='".$_SESSION['id']."') AS e INNER JOIN termos_aditivos AS ta ON e.Id_Estagio=ta.Id_Estagio
				  ";

    $autorizacao = mysqli_query($conexao, $query);

    if(mysqli_num_rows($autorizacao) > 0){
        //	$_SESSION["Failed"] = "Já possui Termo de Compromisso.";
        //	return;
        $query = "UPDATE termos_aditivos
		  SET Nome_TermoAditivo    = '$NomeArquivo',
		      Tamanho_TermoAditivo = '$TamanhoArquivo',
		      Tipo_TermoAditivo 	= '$TipoArquivo',
		      Arquivo_TermoAditivo = '$conteudo',
		      Status_TermoAditivo  = 'supervisor',
		      Data_Prorrogacao = '$data'
		 WHERE Id_TermoAditivo = '$IdTermoAditivo' ";

    }else{
        //Insere Termo de Compromisso
        $_SESSION["Failed"] = "Não tem permissão para acessar Termo aditivo.";
        return false;
    }

    mysqli_query($conexao, $query) or die();

    $_SESSION["Success"] = "Termo Aditivo enviado com sucesso.";
    return true;
}

function  ListaComentariosTermos($conexao, $idEstagio){

    $idEstagio = mysqli_real_escape_string($conexao, $idEstagio);

    $retorno = array();

    $query =    "SELECT *
                 FROM comentarios_termos_aditivos as ca NATURAL JOIN termos_aditivos as ta
                 WHERE Id_Estagio='".$idEstagio."'";

    $query = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

    while($row = mysqli_fetch_assoc( $query)){

        $retorno[$row['Id_TermoAditivo']] = $row['Comentario'];

    }

    return $retorno;

}

function InsereTermoAditivo($conexao, $Id_Estagio, $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo, $data){
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


        $query = "INSERT INTO termos_aditivos ( Id_Estagio, Nome_TermoAditivo, Tamanho_TermoAditivo, Tipo_TermoAditivo, Arquivo_TermoAditivo, Status_TermoAditivo, Data_Prorrogacao) ".
            "VALUES ($Id_Estagio, '$NomeArquivo', '$TamanhoArquivo', '$TipoArquivo', '$conteudo', 'supervisor','$data')";



    mysqli_query($conexao, $query) or die();

    $_SESSION["Success"] = "Termo aditivo enviado com sucesso.";

    return;
}

function ListaTermosAditivosPendentes($conexao){

	if($_SESSION['auto']=="P"){
		
		$query = "SELECT * 
				  FROM (SELECT Id_Estagio, Nome_Completo, Data_Fim
				  		FROM estagio INNER JOIN usuarios ON estagio.Id_Aluno=usuarios.Id_Usuario  
				  		where Id_Supervisor='".$_SESSION['id']."') AS e INNER JOIN termos_aditivos AS ta ON e.Id_Estagio=ta.Id_Estagio
				  WHERE ta.Status_TermoAditivo='supervisor'";
	
	}else if($_SESSION['auto']=="V"){
		
		$query = "SELECT * 
				  FROM (SELECT Id_Estagio, Nome_Completo, Data_Fim
				  		FROM estagio INNER JOIN usuarios ON estagio.Id_Aluno=usuarios.Id_Usuario  
				  		where usuarios.Id_Curso='".$_SESSION['curso']."') AS e INNER JOIN termos_aditivos AS ta ON e.Id_Estagio=ta.Id_Estagio
				  WHERE (ta.Status_TermoAditivo='presidente' OR ta.Status_TermoAditivo='entrega' )";

	}else{	
		$_SESSION["Failed"] = "Autorização requerida";
		return false;
		//header("Location: ../users.php");
	}

	$retorno = array(); 
	
	$consulta = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

	while($row = mysqli_fetch_assoc($consulta)){
		// criar a data aqui mesmo, ja que eh uma array
		$data = DateTime::createFromFormat("Y-m-d", $row['Data_Fim']);
		$row['Data_Fim']= $data->format("d/m/Y");
		$data = DateTime::createFromFormat("Y-m-d", $row['Data_Prorrogacao']);
		$row['Data_Prorrogacao']= $data->format("d/m/Y");	
		array_push($retorno, $row);
	}

	return $retorno;

}

function getTermoAditivo($conexao, $id){

    if($_SESSION['auto']=="E"){
        $query = "SELECT *
				  FROM (SELECT Id_Estagio, Data_Fim
				  		FROM estagio
				  		where Id_Aluno='".$_SESSION['id']."') AS e INNER JOIN termos_aditivos AS ta ON e.Id_Estagio=ta.Id_Estagio
				  WHERE ta.Status_TermoAditivo='alterar'";

    }
    else if($_SESSION['auto']=="P"){

        $query = "SELECT *
				  FROM (SELECT Id_Estagio, Nome_Completo, Data_Fim
				  		FROM estagio INNER JOIN usuarios ON estagio.Id_Aluno=usuarios.Id_Usuario
				  		where Id_Supervisor='".$_SESSION['id']."') AS e INNER JOIN termos_aditivos AS ta ON e.Id_Estagio=ta.Id_Estagio
				  WHERE ta.Status_TermoAditivo='supervisor'";

    }else if($_SESSION['auto']=="V"){

        $query = "SELECT *
				  FROM (SELECT Id_Estagio, Nome_Completo, Data_Fim
				  		FROM estagio INNER JOIN usuarios ON estagio.Id_Aluno=usuarios.Id_Usuario
				  		where usuarios.Id_Curso='".$_SESSION['curso']."') AS e INNER JOIN termos_aditivos AS ta ON e.Id_Estagio=ta.Id_Estagio
				  WHERE ta.Status_TermoAditivo='presidente'";

    }else{
        $_SESSION["Failed"] = "Autorização requerida";
        return false;
    }




}

function EntregaTermoAditivo($conexao, $idTermo){

    if($_SESSION["auto"] != 'V') {
        return false;
    }

    $idRelatorio = mysqli_real_escape_string($conexao, $idTermo);
    $query = "UPDATE termos_aditivos SET Status_TermoAditivo='aprovado' WHERE Id_TermoAditivo=$idTermo";

    $result = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

    if(!$result)
        return false;

    $query = "SELECT * FROM termos_aditivos WHERE Id_TermoAditivo=$idTermo";

    $result = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

    $row = mysqli_fetch_assoc($result);

    $query = "UPDATE estagio SET Data_Fim='".$row['Data_Prorrogacao']."' WHERE Id_Estagio='".$row['Id_Estagio']."'";

    $result = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

    return $result;

}

function ListaTermosAditivos($conexao,$idEstagio = NULL){

    if($_SESSION['auto']=="E"){

        $query = "SELECT *
				  FROM (SELECT Id_Estagio, Data_Fim
				  		FROM estagio
				  		where Id_Aluno='".$_SESSION['id']."' AND Id_Estagio='".$idEstagio."' ) AS e INNER JOIN termos_aditivos AS ta ON e.Id_Estagio=ta.Id_Estagio
				  ";

    }
    else if($_SESSION['auto']=="P"){

        $query = "SELECT *
				  FROM (SELECT Id_Estagio, Nome_Completo, Data_Fim
				  		FROM estagio INNER JOIN usuarios ON estagio.Id_Aluno=usuarios.Id_Usuario
				  		where Id_Supervisor='".$_SESSION['id']."' ) AS e INNER JOIN termos_aditivos AS ta ON e.Id_Estagio=ta.Id_Estagio
				  ";

    }else if($_SESSION['auto']=="V"){

        $query = "SELECT *
				  FROM (SELECT Id_Estagio, Nome_Completo, Data_Fim
				  		FROM estagio INNER JOIN usuarios ON estagio.Id_Aluno=usuarios.Id_Usuario
				  		where usuarios.Id_Curso='".$_SESSION['curso']."') AS e INNER JOIN termos_aditivos AS ta ON e.Id_Estagio=ta.Id_Estagio
				  ";

    }else{
        $_SESSION["Failed"] = "Autorização requerida";
        return false;
    }

    $retorno = array();

    $consulta = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

    while($row = mysqli_fetch_assoc($consulta)){


        // criar a data aqui mesmo, ja que eh uma array
        $data = DateTime::createFromFormat("Y-m-d", $row['Data_Fim']);
        $row['Data_Fim']= $data->format("d/m/Y");
        $data = DateTime::createFromFormat("Y-m-d", $row['Data_Prorrogacao']);
        $row['Data_Prorrogacao']= $data->format("d/m/Y");
        array_push($retorno, $row);
    }



    return $retorno;

}

function RemoveTermoAditivo($conexao, $id_estagio, $id_termo){

    $id_termo = mysqli_real_escape_string($conexao,$id_termo);
    $id_estagio = mysqli_real_escape_string($conexao,$id_estagio);

    if($_SESSION['auto'] == 'E' ) {
        $query = mysqli_query($conexao, "SELECT * FROM termos_aditivos WHERE Id_TermoAditivo='" . $id_termo . "' AND Id_Estagio='" . $id_estagio . "' AND Id_Aluno='" . $_SESSION['id'] . "'") or die(mysqli_error($conexao));
    }else{
        $query = mysqli_query($conexao, "SELECT * FROM termos_aditivos WHERE Id_TermoAditivo='" . $id_termo . "' AND Id_Estagio='" . $id_estagio ."'") or die(mysqli_error($conexao));
    }

    $getNumero = mysqli_fetch_assoc($query);

    if(empty($getNumero)){
        $_SESSION["Failed"] = "Você não tem permição para alterar esse Termo Aditivo.";
    }
    else{
        $sql = mysqli_query($conexao, "DELETE FROM termos_aditivos WHERE Id_TermoAditivo='".$id_termo."'")or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($conexao));
    }

}

function avaliaTermoAditivo($conexao, $idEstagio, $idTermoAditivo, $comentario, $status ){



	if($status=="aprova"){
		if($_SESSION['auto']=='P')
            $status = "presidente";
        else if($_SESSION['auto']=='V')
            $status = "entrega";
        else
            return false;

        $query = "UPDATE termos_aditivos SET Status_TermoAditivo='$status' WHERE Id_Estagio='$idEstagio' AND Id_TermoAditivo='$idTermoAditivo'";
        $consulta = mysqli_query($conexao, $query) or die(mysqli_error($conexao));
        $query = "DELETE FROM comentarios_termos_aditivos WHERE Id_Estagio='$idEstagio' AND Id_TermoAditivo='$idTermoAditivo'";
        $consulta = mysqli_query($conexao, $query) or die(mysqli_error($conexao));
        return true;

    }else if($status=="reprova"){

        $query = "UPDATE termos_aditivos SET Status_TermoAditivo='alterar' WHERE Id_Estagio='$idEstagio' AND Id_TermoAditivo='$idTermoAditivo'";

        $consulta = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

        $query = "INSERT INTO comentarios_termos_aditivos(Id_Estagio,Id_TermoAditivo, Comentario) VALUES ('$idEstagio','$idTermoAditivo','$comentario')";

        $query2 = "UPDATE comentarios_termos_aditivos SET Comentario='$comentario' WHERE Id_Estagio='$idEstagio' AND Id_TermoAditivo='$idTermoAditivo'";
        
		$consulta = mysqli_query($conexao, $query) or ( mysqli_query($conexao, $query2) or die(mysqli_error($conexao))) ;
        return true;

    }else{
        return false;
    }


}