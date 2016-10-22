<?php

function CadastrarEmpresa($conexao, $nome, $email, $telefone, $cep, $rua, $numero, $bairro, $complemento){
	$nome 		 = mysqli_real_escape_string($conexao, $nome);
	$email 		 = mysqli_real_escape_string($conexao, $email);
	$telefone 	 = mysqli_real_escape_string($conexao, $telefone);
	$cep 		 = mysqli_real_escape_string($conexao, $cep);
	$rua 		 = mysqli_real_escape_string($conexao, $rua);
	$numero 	 = mysqli_real_escape_string($conexao, $numero);
	$bairro 	 = mysqli_real_escape_string($conexao, $bairro);
	$complemento = mysqli_real_escape_string($conexao, $complemento);

	$query = "SELECT Email FROM empresa WHERE Email = '$email'";
	$autorizacao = mysqli_query($conexao, $query);

	if(mysqli_num_rows($autorizacao) > 0){
		$_SESSION["Failed"] = "E-mail já cadastrado no sistema.";
		return;
		exit();
	}

	$hash_email = md5(rand(0, 10000));

	$query = "INSERT INTO empresa (Nome, Email, Telefone, Cep, Rua, Numero, Bairro, Complemento, Hash_Email) 
			  VALUES ('$nome', '$email', '$telefone', '$cep', '$rua', '$numero', '$bairro', '$complemento', '$hash_email')";
	
	mysqli_query($conexao, $query) or die(mysqli_error($conexao));

	return $hash_email;
}

function AprovaCadastroEmpresa($conexao, $id_empresa){

	$aprova_query = "SELECT * FROM empresa WHERE Id_Empresa='$id_empresa' AND Ativa_Email='1'";
	$aprova = mysqli_query($conexao, $aprova_query);
	
	if(mysqli_num_rows($aprova) == 1){

		$query = "UPDATE empresa SET Ativa='1' WHERE Id_Empresa='$id_empresa'";
		$_SESSION["Success"] = "Cadastro da empresa aprovado com sucesso.";

		mysqli_query($conexao, $query);
	}

	else{
		$_SESSION["Failed"] = "Empresa não existe ou o email ainda não foi verificado.";
	}
}

function RemoveEmpresa($conexao, $id_empresa,$observacao = ""){

	$result = mysqli_query($conexao, "SELECT Nome_Completo, Email FROM usuarios WHERE Id_Usuario=\"".$_SESSION['auto']."\"");
	
	$presidenteFetch = mysqli_fetch_assoc($result);

	$emailPresidente = $presidenteFetch['Email'];
	$nomePresidente = $presidenteFetch['Nome_Completo'];

	$result = mysqli_query($conexao, "SELECT Email, Ativa FROM empresa WHERE Id_Empresa=\"".$id_empresa."\"");

	$empresaFetch = mysqli_fetch_assoc($result); 

	$email = $empresaFetch['Email'];
	$ativa = $empresaFetch['Ativa'];

	$query = "DELETE FROM empresa WHERE Id_Empresa=$id_empresa";

	mysqli_query($conexao, $query);

	$error =  mysqli_errno($conexao);

	if($error!=0){

		if($error==1451)
			$_SESSION["Failed"] = "Existem alunos realizando estágio nessa empresa.";
		else	
			$_SESSION["Failed"] = "Erro desconhecido ao remover empresa.";
		return;

	}

	if($ativa){
		$assunto = "Cadastro no Sistema de Estágios removido";
		$message = "
					Sua empresa foi removida do Sistema de Estágios UFMS. Por favor,<br><br>
					caso isso tenha sido um engano, entre em contato com ".$emailPresidente.".<br><br>
					------------------------<br><br>
					<br><br>
					Atenciosamente, ".$nomePresidente." 
					------------------------<br><br>
					<br><br>					 				
				";
	}
	else{
		$assunto = "Cadastro no Sistema de Estágios recusado";
		$message = "
						Sua empresa teve o cadastro negado. Por favor,<br><br>
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

	if(InsereEmail($conexao, $email, $assunto , $message)){
		$_SESSION["Success"] = "Empresa removida com sucesso.";
	}
	else{
		$_SESSION["Failed"] = "Erro ao enviar e-mail.\nTente novamente mais tarde.";
	}

	

}

function GetEmpresaById($conexao, $id_empresa){
	$empresa = array();

	$query = "SELECT * FROM empresa WHERE Id_Empresa=\"".$id_empresa."\"";

	$result = mysqli_query($conexao, $query);

	while($row = mysqli_fetch_assoc($result)){
		array_push($empresa, $row);
		//$empresa[$row['Id_Empresa']]= $row;

	}

	return $empresa;
}

function GetEmpresas($conexao){
	$empresa = array();
	
	$query = "SELECT * FROM empresa" ;


	$result = mysqli_query($conexao, $query);

	while($row = mysqli_fetch_assoc($result)){
		$empresa[$row['Id_Empresa']]= $row;

	}

	return $empresa;
}