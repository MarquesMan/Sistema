<!--Este codigo insere um cadastro no Banco de Dados e, em seguida, redireciona para index.php-->
<html>
	<head>	
		<meta charset = 'UTF-8'>	
		<title>Sistema de Estágios - UFMS - Recuperação</title>
		<center>
		<script src="js/jquery-1.11.1.min.js"></script>
	</head>

	<body>
		<?php
		require_once("conecta.php");
		require 'phpass/PasswordHash.php';
		
		$count = 0;
		$t_hasher = new PasswordHash(8, TRUE);

		//verifica a quantidade de campos preenhidos
		foreach($_POST as $chave => $valor)
		{
			if(empty($_POST[$chave]))
			{
				$count++;
			}
		}
		if($count == 2)
		{
			//passo1: Verificar se o usuario com as informações passadas existe
			if(strcmp($_POST["tipo"], "E") == 0)
				$query = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE Email = '".mysqli_real_escape_string($mysqli, $_POST['email'])."'") or die(mysql_error());

			else if(strcmp($_POST["tipo"], "R") == 0)
				$query = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE Rga = '".mysqli_real_escape_string($mysqli, $_POST['rga'])."'") or die(mysql_error());

			else
				$query = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE Nome_De_Usuario = '".mysqli_real_escape_string($mysqli, $_POST['username'])."'") or die(mysql_error());

			//passo2: caso exista, gere uma senha temporaria, atualize-a no banco de dados e envie um e-mail com a nova senha
			if(mysqli_num_rows($query) != 0)
			{
				//passo2.1: Gere a senha temporaria
				$tempPassword = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 8)), 0, 8);				
				$passHash = $t_hasher->HashPassword($tempPassword);

				//passo2.2 Atualize a senha no banco de dados
				$row = mysqli_fetch_assoc($query);
				mysqli_query($mysqli, "UPDATE usuarios SET Senha='".$passHash."' WHERE Id_Usuario='".$row['id']."'") or die(mysql_error());

				//passo2.3: Envie o e-mail com a nova senha
				$message = '

				E-mail de recuperação de senha. Seguem seus dados atualizados:
				------------------------
				Username: "'.$row['username'].'"
				Password: "'.$tempPassword.'"
				------------------------
				http://localhost/sistema
				
				';

				if(Send_Email_To($row['email'], 'Password Recovery', $message) == 1)
					phpAlert_Redirect("E-mail com senha temporaria enviado.", "index.php");
				else
					phpAlert_Redirect("Erro ao enviar e-mail.\nTente novamente mais tarde.", "recovery.php");
				exit();
			}
			else
				phpAlert_Redirect("Usuario nao encontrado!", "recovery.php");
		}
		else
		{
			phpAlert_Redirect("Apenas um campo deve ser preenchido. Pare de tentar quebrar o sistema, rapaz u.u", "recovery.php");
			exit();
		}
		?>
	</body>
</html>