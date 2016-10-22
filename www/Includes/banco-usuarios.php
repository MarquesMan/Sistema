<?php 
	

function listaUsuariosPendentes( $mysqli){
	
	$array = array();

	$stmt = $mysqli->prepare("SELECT IdUsuario, nome, data_nasc, email, endereco, numero, bairro, cidade, uf, cep, fone1, fone2 FROM Usuario WHERE aprovado = 0");
	$stmt->execute();    // Executa a tarefa estabelecida.

    $stmt->bind_result($user_id, $username, $data, $email,$endereco,$numero, $bairro, $cidade, $uf, $cep, $fone1, $fone2);
    
	while( $stmt-> fetch() ){
		$array[$user_id] = array('IdUsuario' => $user_id ,'Nome' => $username,'Data_Nasc' =>  $data,'Email' => $email,'Numero' => $numero, 'Bairro' =>  $bairro,'Cidade' =>  $cidade,'Unidade_Federal' =>  $uf,'CEP' =>  $cep,'Fone1' =>  $fone1,'Fone2' =>  $fone2  );
	}

	$stmt->close();

	return $array;
}

function aprovaUsuario($mysqli,$arrayDeUsuario){

	foreach ($arrayDeUsuario as $usuario){		
		$idUsuario = mysqli_real_escape_string($mysqli, $usuario);
		$stmt = $mysqli->prepare("UPDATE Usuario SET aprovado ='1'  WHERE IdUsuario = '$idUsuario'");
		$stmt->execute();    // Executa a tarefa estabelecida.
	}	
	$stmt->close();
	
}

function alterarSenha($mysqli,$idUsuario,$senha){
		

		$random_salt = hash('sha512', uniqid(mt_rand(), TRUE));

		$senha = hash('sha512', $senha);

		$senha = hash('sha512', $senha . $random_salt);		

		$query = "UPDATE Usuario SET password='".$senha."',salt='".$random_salt."'  WHERE IdUsuario='".$idUsuario."'";
		
		$user_browser = $_SERVER['HTTP_USER_AGENT'];

		unset($_SESSION['login_string']);
        $_SESSION['login_string'] = hash('sha512', 
        $senha . $user_browser);

		return mysqli_query($mysqli, $query);

}