<?php
require_once('PasswordHash.php');
require_once('funcoes-de-controle.php');

function VerificaRepeticao($conexao, $rga, $usuario, $email){
	if($rga == ""){
		$query = "	SELECT Email, Nome_De_Usuario
					FROM usuarios
					WHERE Email = '$email' or Nome_De_Usuario = '$usuario'";
	}
	else{
		$query = "	SELECT Rga, Email, Nome_De_Usuario
					FROM usuarios
					WHERE Rga = $rga or Email = '$email' or Nome_De_Usuario = '$usuario'";	
	}
	

	if($value = mysqli_query($conexao, $query) or die(mysqli_error($conexao)))
	{
		if(mysqli_num_rows($value) == 0)
			return "";
		while($row = mysqli_fetch_assoc($value))
		{
			if($rga != "" && $row['Rga'] == $rga)
				return "rga";
			if($row['Email'] == $email)
				return "email";
			if($row['Nome_De_Usuario'] == $usuario)
				return "usuario";
		}
	}
	else
		return "erro";
}

function CadastrarUsuario($conexao, $rga, $curso, $nome, $usuario, $email, $senha, $tipo){
	$rga 	 	= mysqli_real_escape_string($conexao, $rga);
	$curso 	 	= mysqli_real_escape_string($conexao, $curso);
	$nome 	 	= mysqli_real_escape_string($conexao, $nome);
	$usuario 	= mysqli_real_escape_string($conexao, $usuario);
	$email 	 	= mysqli_real_escape_string($conexao, $email);
	$tipo 	 	= mysqli_real_escape_string($conexao, $tipo);
	//$hash_email = mysqli_real_escape_string($conexao, $hash_email);

	$hash_email = md5(rand(0, 10000));
	$t_hasher 	= new PasswordHash(8, TRUE);
	$senha 		= $t_hasher->HashPassword($senha);
	$senha 	 	= mysqli_real_escape_string($conexao, $senha);
	$data = date("Y/m/d");

	$query = "INSERT INTO usuarios (Rga, Id_Curso, Nome_Completo, Nome_De_Usuario, Email, Senha, Tipo, Hash_Email, Data_de_Ingresso)
			  VALUES ('$rga', '$curso', '$nome', '$usuario', '$email', '$senha', '$tipo', '$hash_email', '$data' )";

	//Verifica atributos únicos no BD: rga, usuario, email
	if($tipo == "E")
		$Status = VerificaRepeticao($conexao, $rga, $usuario, $email);
	elseif($tipo == "P")
		$Status = VerificaRepeticao($conexao, "", $usuario, $email);
	else{
		return;
	}

	if($Status == "rga"){
		$_SESSION["Failed"] = "RGA já presente no sistema.";
		return "";
	}
	else if ($Status == "usuario"){
		$_SESSION["Failed"] = "Nome de usuario já em uso.";
		return "";
	}
	else if ($Status == "email"){
		$_SESSION["Failed"] = "E-Mail já em uso.";
		return "";
	}
	else if($Status == "erro"){
		$_SESSION["Failed"] = "Erro interno.";
		return "";
	}

	if(mysqli_query($conexao, $query))
		return $hash_email;
	else
	{
		$_SESSION["Failed"] = mysqli_error($conexao);
		return "";
	}
}

function CadastrarCoordenador($conexao, $curso, $nome, $usuario, $email,$telefone, $senha){
	
	$curso 	 	= mysqli_real_escape_string($conexao, $curso);
	$nome 	 	= mysqli_real_escape_string($conexao, $nome);
	$usuario 	= mysqli_real_escape_string($conexao, $usuario);
	$email 	 	= mysqli_real_escape_string($conexao, $email);
	$telefone = mysqli_real_escape_string($conexao, $telefone);

	$hash_email = md5(rand(0, 10000));
	$t_hasher 	= new PasswordHash(8, TRUE);

	$senha 		= $t_hasher->HashPassword($senha);
	$senha 	 	= mysqli_real_escape_string($conexao, $senha);

	$data = date("Y/m/d");

	$query = "INSERT INTO usuarios (Id_Curso, Nome_Completo, Nome_De_Usuario, Email, Senha, Telefone, Hash_Email, Data_de_Ingresso)
			  VALUES ('$curso', '$nome', '$usuario', '$email', '$senha', '$telefone', '$hash_email', '$data' )";
	
	$Status = VerificaRepeticao($conexao, "", $usuario, $email);

	if ($Status == "usuario"){
		$_SESSION["Failed"] = "Nome de usuario já em uso.";
		return "";
	}
	else if ($Status == "email"){
		$_SESSION["Failed"] = "E-Mail já em uso.";
		return "";
	}
	else if($Status == "erro"){
		$_SESSION["Failed"] = "Erro interno.";
		return "";
	}

	if(mysqli_query($conexao, $query))
		return $hash_email;
	else
	{
		$_SESSION["Failed"] = mysqli_error($conexao);
		return "";
	}
}

function alteraDadosUsuario($conexao,$idUsuario,$nomeCompleto ='', $curso='', $RGA ='' ,$email = '',$telefone = ''){

    $before = false; // variaval para controlar virgulas

    if($_SESSION['auto']=='V'){
        $query = "UPDATE usuarios SET ";
        $idUsuario = mysqli_real_escape_string($conexao, $idUsuario );
        $queryEnd = "WHERE Id_Usuario='$idUsuario'";
    }else{

        return false;
    }

    if($nomeCompleto!=''){
        $nomeCompleto = mysqli_real_escape_string($conexao, $nomeCompleto);
        $query = $query."Nome_Completo='$nomeCompleto'";
        $before = true;
    }

    if($curso!=''){
        $curso = mysqli_real_escape_string($conexao, $curso);

        if($before){
            $query = $query.", Id_Curso='$curso'";
        }else{
            $query = $query."Id_Curso='$curso'";
            $before = true;
        }
    }

    if($RGA!=''){
        $RGA = $RGA[0].$RGA[1].$RGA[2].$RGA[3].$RGA[5].$RGA[6].$RGA[7].$RGA[8].$RGA[10].$RGA[11].$RGA[12].$RGA[13];
        $RGA = mysqli_real_escape_string($conexao, $RGA);

        if($before){
            $query = $query.", Rga='$RGA'";
        }else{
            $query = $query."Rga='$RGA'";
            $before = true;
        }
    }

    if($email!=''){
        $email = mysqli_real_escape_string($conexao, $email);

        if($before){
            $query = $query.", Email='$email'";
        }else{
            $query = $query."Email='$email'";
            $before = true;
        }
    }

    if($telefone!=''){

        if(isset($telefone[14]))
            $end = $telefone[14];
        else
            $end = "";

        $telefone = $telefone[1].$telefone[2].$telefone[3].$telefone[5].$telefone[6].$telefone[7].$telefone[8].$telefone[10].$telefone[11].$telefone[12].$telefone[13].$end;
        $telefone = mysqli_real_escape_string($conexao, $telefone);

        if($before){
            $query = $query.", Telefone='$telefone'";
        }else{
            $query = $query."Telefone='$telefone'";
        }
    }

    $result = mysqli_query($conexao, $query.$queryEnd);

    return $result ;

}

function alteraDadosSuperAdmin($conexao,$idUsuario,$nomeCompleto ='', $curso='', $email = '',$telefone = '', $senha = '',
	$nomeUsuario=''){

    $before = false; // variaval para controlar virgulas

    if($_SESSION['auto']=='Z'){
        $query = "UPDATE usuarios SET ";
        $idUsuario = mysqli_real_escape_string($conexao, $idUsuario );
        $queryEnd = "WHERE Id_Usuario='$idUsuario'";
    }else{

        return false;
    }

    if($nomeCompleto!=''){
        $nomeCompleto = mysqli_real_escape_string($conexao, $nomeCompleto);
        $query = $query."Nome_Completo='$nomeCompleto'";
        $before = true;
    }

    if($curso!=''){
        $curso = mysqli_real_escape_string($conexao, $curso);

        if($before){
            $query = $query.", Id_Curso='$curso'";
        }else{
            $query = $query."Id_Curso='$curso'";
            $before = true;
        }
    }

    if($RGA!=''){
        $RGA = $RGA[0].$RGA[1].$RGA[2].$RGA[3].$RGA[5].$RGA[6].$RGA[7].$RGA[8].$RGA[10].$RGA[11].$RGA[12].$RGA[13];
        $RGA = mysqli_real_escape_string($conexao, $RGA);

        if($before){
            $query = $query.", Rga='$RGA'";
        }else{
            $query = $query."Rga='$RGA'";
            $before = true;
        }
    }

    if($email!=''){
        $email = mysqli_real_escape_string($conexao, $email);

        if($before){
            $query = $query.", Email='$email'";
        }else{
            $query = $query."Email='$email'";
            $before = true;
        }
    }

    if($telefone!=''){

        if(isset($telefone[14]))
            $end = $telefone[14];
        else
            $end = "";

        $telefone = $telefone[1].$telefone[2].$telefone[3].$telefone[5].$telefone[6].$telefone[7].$telefone[8].$telefone[10].$telefone[11].$telefone[12].$telefone[13].$end;
        $telefone = mysqli_real_escape_string($conexao, $telefone);

        if($before){
            $query = $query.", Telefone='$telefone'";
        }else{
            $query = $query."Telefone='$telefone'";
        }
    }

    if($senha!=''){
        $senha = mysqli_real_escape_string($conexao, $senha);
        $hash_email = md5(rand(0, 10000));
		$t_hasher 	= new PasswordHash(8, TRUE);

		$senha 		= $t_hasher->HashPassword($senha);

        if($before){
            $query = $query.", Senha='$senha', Hash_Email='$hash_email'";
        }else{
            $query = $query."Senha='$senha', Hash_Email='$hash_email'";
            $before = true;
        }
    }

    if($nomeUsuario!=''){
    	$nomeUsuario = mysqli_real_escape_string($conexao, $nomeUsuario);

        if($before){
            $query = $query.", Nome_De_Usuario='$nomeUsuario'";
        }else{
            $query = $query."Nome_De_Usuario='$nomeUsuario'";
            $before = true;
        }
    }

    $result = mysqli_query($conexao, $query.$queryEnd);

    return $result ;

}

function getEstagiarios($conexao){

    if($_SESSION['auto']=='V'){
        $query = 'SELECT * FROM usuarios WHERE Id_Curso='.$_SESSION["curso"].' AND Tipo=\'E\' ORDER BY Nome_Completo ASC';

    }else if($_SESSION['auto']=='P'){
        $query = "SELECT * FROM usuarios AS U INNER JOIN estagio AS E ON U.Id_Usuario=E.Id_Aluno
                  WHERE U.Tipo='E' AND E.Id_Supervisor=".$_SESSION["id"]." ORDER BY Nome_Completo ASC ";
    }else{
        return array();
    }

    $lista = array();

    $result = mysqli_query($conexao, $query);

    if(!$result)
        return array();

    while($row = mysqli_fetch_assoc($result)){
        array_push($lista, $row);
    }

    return $lista;


}

function getCoordenadores($conexao,$id='')
{	
	$where = '';

	if($id!==''){
		$where = 'AND Id_Usuario='.$id;
	}

	if($_SESSION['auto']=='Z'){
        $query = 'SELECT * FROM usuarios WHERE Tipo=\'V\' '.$where.' ORDER BY Nome_Completo ASC';
    }else{
        return array();
    }

    $lista = array();

    $result = mysqli_query($conexao, $query);

    if(!$result)
        return array();

    while($row = mysqli_fetch_assoc($result)){
        array_push($lista, $row);
    }

    return $lista;

}

function AprovaCadastroUsuario($conexao, $id_usuario, $tipo_usuario){

	$aprova_query = "SELECT * FROM usuarios WHERE Id_Usuario='$id_usuario' AND Tipo='$tipo_usuario' AND Ativa_Email='1'";
	$aprova = mysqli_query($conexao, $aprova_query);

	if(mysqli_num_rows($aprova) == 1){
		$query = "UPDATE usuarios SET Ativa='1' WHERE Id_Usuario='$id_usuario'";
		$_SESSION["Success"] = "Cadastro aprovado com sucesso.";

		mysqli_query($conexao, $query);
	}

	else{
		$_SESSION["Failed"] = "Usuário não existe ou o email ainda não foi verificado.";
	}
}

function RemoveUsuario($conexao, $id_usuario, $observacao){

	$result = mysqli_query($conexao, "SELECT Nome_Completo, Email FROM usuarios WHERE Id_Usuario=\"".$_SESSION['auto']."\"");

	$PresidenteFetch = mysqli_fetch_assoc($result);
	$emailPresidente = $PresidenteFetch['Email'];
	$nomePresidente = $PresidenteFetch['Nome_Completo'];

	$result = mysqli_query($conexao, "SELECT Ativa, Email FROM usuarios WHERE Id_Usuario=\"".$id_usuario."\"");

	$usuarioFetch = mysqli_fetch_assoc($result);

	$emailUsuario = $usuarioFetch['Email'];
	$ativo = $usuarioFetch['Ativa'];

	if($ativo){
		$query = "UPDATE usuarios SET Ativa=0 WHERE Id_Usuario='$id_usuario'";
		$assunto = "Cadastro no Sistema de Estágios removido";
		$message = "
					Sua cadastro foi removido do Sistema de Estágios UFMS. Por favor,<br><br>
					caso isso tenha sido um engano, entre em contato com ".$emailPresidente.".<br><br>
					------------------------<br><br>
					<br><br>
					Atenciosamente, ".$nomePresidente." 
					------------------------<br><br>
					<br><br>					 				
				";
	}
	else{
		$query = "DELETE FROM usuarios WHERE Id_Usuario='$id_usuario'";
		$assunto = "Cadastro no Sistema de Estágios recusado";
		$message = "
						Sua cadastro no Sistema de Estágios UFMS foi negado. Por favor,<br><br>
						verifique todos os dados e tente novamente.<br><br>
						------------------------<br><br>
						Observações:<br><br>
						".$observacao."
						<br><br>
						Atenciosamente, ".$nomePresidente." 
						------------------------<br><br>
						<br><br>					 				
					";
	}

	require("banco-email.php");


	if(!mysqli_query($conexao, $query)){
		$_SESSION["Sucess"] = "Ocorreu um erro ao remover usuário.";
	}

	if(InsereEmail($conexao, $email, $assunto , $message)){
		$_SESSION["Success"] = "Usuário removido com sucesso.";
	}
	else{
		$_SESSION["Failed"] = "Erro ao enviar e-mail.\nTente novamente mais tarde.";
	}
	
}

function GetUsuarioByUsername($conexao, $Nome_usuario){
	$usuario = array();


	$result = mysqli_query($conexao, "SELECT * FROM usuarios WHERE Nome_De_Usuario=\"".$Nome_usuario."\"");

	while($row = mysqli_fetch_assoc($result)){
	
		array_push($usuario, $row);
	}

	return $usuario;
}

function GetUsuarioById($conexao, $Id_usuario, $pessoa = NULL){
	$usuario = array();

    if($pessoa!==NULL){
        if($pessoa=="supervisor"){
            $consulta = "SELECT * FROM usuarios AS U INNER JOIN estagio AS E ON U.Id_Usuario=E.Id_Aluno
                  WHERE U.Id_Usuario=".$Id_usuario." AND E.Id_Supervisor=".$_SESSION["id"];

        }else if($pessoa=="presidente"){
            $consulta = 'SELECT * FROM usuarios WHERE Id_Curso='.$_SESSION["curso"].' AND Id_Usuario='.$Id_usuario;
        }else{
            $consulta = "SELECT * FROM usuarios WHERE Id_Usuario=\"".$Id_usuario."\"";
        }

    }else{
        $consulta = "SELECT * FROM usuarios WHERE Id_Usuario=\"".$Id_usuario."\"";
    }


	$result = mysqli_query($conexao, $consulta );

	while($row = mysqli_fetch_assoc($result)){
		array_push($usuario, $row);
	}

	return $usuario;
}

function TrocarSenha($conexao, $Senha_passada, $Nova_senha, $Confirmar_senha){
	$Id_Usuario = mysqli_real_escape_string($conexao, $_SESSION["id"]);

	$query = "SELECT Senha FROM usuarios WHERE Id_Usuario = '$Id_Usuario'";
	$Senha_atual = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

	if(mysqli_num_rows($Senha_atual) != 1)
		return false;

	$Senha_atual = mysqli_fetch_assoc($Senha_atual);

	$t_hasher = new PasswordHash(8, TRUE);

	if($t_hasher->CheckPassword($Senha_passada, $Senha_atual['Senha'])){
		if($Nova_senha == $Senha_passada){
			$_SESSION["Failed"] = "Nova senha deve ser diferente da antiga. Por favor tente novamente.";
			return false;
			die();
		}

		if($Nova_senha != $Confirmar_senha){
			$_SESSION["Failed"] = "Senhas não são iguais.";
			return false;
			die();
		}

		//Criptografe a senha
		$passHash = $t_hasher->HashPassword($Nova_senha);
		$passHash = mysqli_real_escape_string($conexao, $passHash);

		//Insira no BD
		$result = mysqli_query($conexao, "UPDATE usuarios SET Senha = '$passHash' WHERE Id_Usuario = '$Id_Usuario' ");

		if(!$result)
			return false;

		return true;
	}

	else {
		$_SESSION["Failed"] = "Senha inserida incorreta. Tente novamente";
		return false;
		die();
	}
}

//Esta funcao recupera a senha do usuario
function RecuperarSenha($conexao, $NovaSenha, $ID){
	//Procura usuario no banco de dados
	$Id_Usuario = mysqli_real_escape_string($conexao, $ID);
	$query = "SELECT Id_Usuario FROM usuarios WHERE Id_Usuario = '$Id_Usuario'";
	$Usuario = mysqli_query($conexao, $query) or die(mysqli_error($conexao));

	if(mysqli_num_rows($Usuario) != 1)
		return false;

	$t_hasher = new PasswordHash(8, TRUE);

	//Criptografe a nova senha
	$passHash = $t_hasher->HashPassword($NovaSenha);
	$passHash = mysqli_real_escape_string($conexao, $passHash);

	//Atualiza a senha do usuario
	$result = mysqli_query($conexao, "UPDATE usuarios SET Senha = '$passHash' WHERE Id_Usuario = '$Id_Usuario' ");

	if(!$result)
		return false;

	return true;
}

//Esta função recebe como parametro o RGA ou o EMAIL ou o NOMEDEUSUARIO e retorna o EMAIL desse usuario caso ele exista. Senao retorna ""
function ProcuraUsuario($conexao, $Id, $Tipo){
	//Cria texto de consulta
	$Pesquisa="SELECT Email, Id_Usuario, Nome_De_Usuario
			  FROM usuarios
			  WHERE ";
	
	if($Tipo == "R")
		$Pesquisa = $Pesquisa."Rga='".mysqli_real_escape_string($conexao, $Id)."'";
	else if($Tipo == "E")
		$Pesquisa = $Pesquisa."Email='".mysqli_real_escape_string($conexao, $Id)."'";
	else if($Tipo == "U")
		$Pesquisa = $Pesquisa."Nome_De_Usuario='".mysqli_real_escape_string($conexao, $Id)."'";
	else if($Tipo == "I")
		$Pesquisa = $Pesquisa."Id='".mysqli_real_escape_string($conexao, $Id)."'";
	else
		return "";
	
	//Realiza a consulta
	if($query = mysqli_query($conexao, $Pesquisa)){
		//Verifica se houve um na consulta
		if(mysqli_num_rows($query) == 1){
			$result = mysqli_fetch_assoc($query);
			//retorna o resultado
			return $result;
		}
		else
			return "";
	}
	return "";
}

//Esta função retorna o numero de minutos que o usuario já realiza por mes dado seu ID
function TotalMinutos($conexao, $UserID){
	$pesquisa =
	"SELECT Carga_Horaria
	FROM plano_de_atividades
	WHERE Id_Aluno = ".mysqli_real_escape_string($conexao, $UserID);

	$query = mysqli_query($conexao, $pesquisa);
	
	$totalH = 0;
	$totalM = 0;

	//Para cada termo de compromisso do aluno, some as horas
	while($row = mysqli_fetch_assoc($query)){
		$time = explode(':', $row['Carga_Horaria']);
		
		$totalH = $totalH + intval($time[0]);
		$totalM = $totalM + intval($time[1]);
	}
	return $totalH*60 + $totalM;

}

function FazerLogin($conexao, $nome_usuario, $senha){
	$t_hasher 	  = new PasswordHash(8, TRUE);

	if($nome_usuario == "" || $senha==""){
		$_SESSION["Failed"] = "Todos os campos devem ser preenchidos";
		return false;
	}

	$nome_usuario = mysqli_real_escape_string($conexao, $nome_usuario);

	$query = mysqli_query($conexao, "SELECT * FROM usuarios WHERE Nome_De_Usuario=\"$nome_usuario\"") or die( mysqli_error($conexao) );	

	if(mysqli_num_rows($query) == 1)
	{
		$result = mysqli_fetch_assoc($query);

		if(!$t_hasher->CheckPassword($senha, $result['Senha'])){
			$_SESSION["Failed"] = "Combinação de usuário e senha não correspondem.";
			return false;
			die();
		}

		if($result['Ativa_Email'] == '0'){
			session_unset();
			$_SESSION["Failed"] = "Email ainda não foi confirmado.";
			return false;
			die();
		}

		else if($result['Ativa'] == '0'){
			session_unset();
			$_SESSION["Failed"] = "Cadastro ainda não foi aprovado.";
			return false;
			die();
		}
		
		else{
			header("Cache-control: private");
			$_SESSION["sessioname"] = $result['Nome_De_Usuario'];
			$_SESSION["auto"] = $result["Tipo"];
			$_SESSION["id"]= $result["Id_Usuario"];
			$_SESSION["nome_completo"]= $result["Nome_Completo"];
			$_SESSION["curso"] = $result["Id_Curso"];
			$_SESSION["email"] = $result["Email"];
			Update_Login_Status();
			return true;
			die();
		}
	}

	else{
		session_unset();
		$_SESSION["Failed"] = "Combinação de usuário e senha não correspondem.";
		return false;
		die();
	}
}


