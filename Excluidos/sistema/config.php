<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");

function Check_Login_Status() {
	return isset($_SESSION["sessioname"]) && $_SESSION["session_time"] >= time();
}

function Update_Login_Status() {
	$_SESSION["session_time"] = time() + 1200;
}

function phpAlert($msg) {
    echo '<script type="text/javascript">alert("'. $msg .'");</script>';
}

function phpAlert_Redirect($msg, $dest) {
	if($msg != "" && $msg != null)
    	phpAlert($msg);
    echo '<script type="text/javascript"> window.location.href = "'. $dest .'";</script>';
}

function Set_Barra_Superior($mysqli, $tipo, $userId) {
	?>
	<center>
		<div class = "navbar">
			<div class = "container">
				<ul class = "nav navbar-nav">
					<li><a href="users.php"> Página Inicial </a></li>
					<?php

					if(!strcmp($tipo, "E")) {
						?><li><a href="meus-estagios.php">Meus Estágios</a></li><?php
					}

					if(!strcmp($tipo, "P")) {
						?><li><a href="estagios_alunos.php">Alunos</a></li><?php
					}

					$query = mysqli_query($mysqli, "SELECT * FROM `mensagens` WHERE To_id = '".$userId."' and Seen = 0") or die(mysql_error());
					$numberOfMessages = mysqli_num_rows($query);
					
					if($numberOfMessages == 0)
						echo "<li><a href='messages.php'>Mensagens</a></li>";
					else
						echo "<li><a href='messages.php'>Mensagens (".$numberOfMessages.")</a></li>";
					?>
					
					<li><a href="change_password.php">Mudar Senha</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</center>
	<?php
}

function Send_Email_To($dest, $subj, $message) {
	require 'PHPMailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;
	$headers = 'From:noreply@sistema.com' . '\r\n'; // Set from headers
	
	$message = str_replace('\n.', '\n..', $message);
	$headers = str_replace('\n.', '\n..', $headers);
	

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com'; 			 		  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'sistemadeestagiosfacom@gmail.com';	  // SMTP username
	$mail->Password = 'sistemadegerenciamentodeestagiosfacom';// SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->From = 'noreply@sistema.com';
	$mail->FromName = 'Sistema';
	$mail->addAddress($dest);  						  // Add a recipient

	$mail->Subject = $subj;
	$mail->Body    = $message;

	if(!$mail->send())
	{
	    return $mail->ErrorInfo;
	}
	else
		return 1;
}

function Send_Message($mysqli, $fromId, $toId, $message)
{
	date_default_timezone_set('America/Manaus');
	
	$time_stamp = date('d/m/Y H:i:s', time());
	$time_stamp = mysqli_real_escape_string($mysqli, $time_stamp);
	$Scaped_message = mysqli_real_escape_string($mysqli, $message);

	mysqli_query($mysqli, "INSERT INTO mensagens (`From_id`, `To_id`, `Time_Stamp`, `Mensagem`) VALUES (`".$fromId."`, ".$toId.", `".$time_stamp."`, `".$message."`)") or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($mysqli));
}

function Recieve_msgs($mysqli, $userId, $max, $fromId)
{
	if($max == 0) {
		$msgs = mysqli_query($mysqli, "SELECT * FROM `mensagens` WHERE To_id = '".$userId."' and From_id = '".$fromId."' ORDER BY Time_Stamp") or die(mysql_error());
		mysqli_query($mysqli, "UPDATE `mensagens` SET Seen='1' WHERE To_id = '".$userId."' and From_id = '".$fromId."'") or die(mysql_error());
	}
	else {
		$msgs = mysqli_query($mysqli, "SELECT * FROM `mensagens` WHERE To_id = '".$userId."' and From_id = '".$fromId."' ORDER BY Time_Stamp LIMIT ".$max) or die(mysql_error());
		mysqli_query($mysqli, "UPDATE `mensagens` SET Seen='1' WHERE To_id = '".$userId."' and From_id = '".$fromId."' LIMIT ".$max) or die(mysql_error());
	}
	return $msgs;
}

/*
Anotações:
18/01/2015, 18:06: Victor Gaíva
	"session_start()" está sendo ultilizada para guardar o nome da ultima tentativa de Login em "entra.php" nas linhas 14 e 17, e depois é ultilizada pra preencher automaticamento o campo de "username" em "index.php". Isso pode ser muito inseguro e uma maneira melhor de fazer isso deve existir. 


TODO:
Funcionalidades:
 	36% - Implementar a guia "Mensagens" {
 		- Mostrar mensagens separadas de acordo com usuário destino/origem
 		- Implementar envio de mensagem
 		- Escolher usuário destino [por lista de rolagem ou por nome de usuário]
 	}

Segurança:

Melhorias Gráficas:
	 0% - Melhorar o método de aviso ao usuário quando um "username" ou "e-mail" já está em uso.
	 0% - Criar Tabela pagina de visualização de informações sobre estágio antes da página de edição.

Organização:
   	10% - Organizar disposição de scripts php dentro da pasta "sistema".
	10% - Comentar scripts

Bugs:
	#1 - Ao abrir a vizualização de mensagem o numero de mensagens nao lidas ainda não foi atualizado na barra superior

*/
?>

