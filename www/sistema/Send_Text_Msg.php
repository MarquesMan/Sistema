<?php
	session_start(); // começa a session
	require_once("conecta.php");
	require_once("../../Action/banco-messages.php");


	if(Check_Login_Status())
	{
		Update_Login_Status();
	}
	else
		exit();
	//verifica se o usuário tem permissão para enviar uma mensagem a este usuário
	if($_POST['ID_Conversa'] == '-1'){//verifica se ele tem permissão para criar uma nova conversa com o outro usuario
		$Tipo_Remetente = $_SESSION['auto'];
		if($Tipo_Remetente == 'V')//presidente pode criar uma conversa com qualquer um
			$okay = 1;
		else{
			//Caso contrario deve-se recuperar o tipo do usuario destino
			$string1 =
			"SELECT Tipo
			FROM usuarios
			WHERE Id_Usuarios = '$_POST[ID_User]'
			";
			$Result = mysqli_query($mysqli, $string1) or die("-1");
			$row = mysqli_fetch_assoc($Result);
			$Tipo_Destinatario = $row['Tipo'];

			//Verifique se o remetente tem permissão para enviar criar conversa com o destinatario
			if($Tipo_Destinatario == 'V')
				$okay = 1;
			else{
				//Caso nenhum dos dois seja um presidente significa que eh entre um aluno e um professor.
				//Professores apenas conversam com alunos presentes em seus estágios e aluno apenas com os supervisores de seus estagios
				if($Tipo_Remetente == 'E'){
					$string1 =
					"SELECT CASE WHEN e.id_aluno = '$_SESSION[id]' and e.id_supervisor = '$_POST[ID_User]' THEN '1' ELSE '0' END as Permit
					FROM estagio e
					";
				}
				else{
					$string1 =
					"SELECT CASE WHEN e.id_supervisor = '$_SESSION[id]' and e.id_aluno = '$_POST[ID_User]' THEN '1' ELSE '0' END as Permit
					FROM estagio e
					";
				}
				$Permit = mysqli_query($mysqli, $string1) or die(mysqli_error($mysqli));
				$row = mysqli_fetch_assoc($Permit);

				if($row['Permit'] == '1')
					$okay = 1;
				else
					$okay = 0;
			}
		}
	}
	else
		$okay = 1;
	
	if($okay == 0){
		echo "-10";
		exit();
	}

	//Caso a conversa com este usuário ainda não exista, crie-a
	if($_POST['ID_Conversa'] == '-1'){
		//insira a nova conversa e recupere o id
		$string2 =
		"INSERT INTO conversas
		(
			User1,
			User2,
			ID_User1,
			ID_User2
		)
		VALUES
		('$_SESSION[nome_completo]','$_POST[Nome_Selecionado]', $_SESSION[id], $_POST[ID_User]);";

		$string1=
		"SELECT ID
		FROM conversas
		WHERE 	ID_User1 = $_SESSION[id] AND ID_User2 = $_POST[ID_User] or
				ID_User2 = $_SESSION[id] AND ID_User1 = $_POST[ID_User]";

		mysqli_query($mysqli, $string2) or die(mysqli_error($mysqli));
		$Conversa = mysqli_query($mysqli, $string1) or die(mysqli_error($mysqli));

		$row = mysqli_fetch_assoc($Conversa);

		$ID_Conversa = $row['ID'];
	}
	else
		$ID_Conversa = $_POST['ID_Conversa'];

	Send_Message($mysqli, $ID_Conversa, $_POST["MessageTextArea"], $_SESSION['nome_completo']);
	echo $ID_Conversa;
?>
