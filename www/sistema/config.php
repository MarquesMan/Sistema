<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");

mysqli_set_charset($mysqli,"utf8");

function Check_Login_Status() {
	return isset($_SESSION["sessioname"]) && $_SESSION["session_time"] >= time();
}

function erroPadrao(){

	echo "<center>
			<table class=\"form-p\">
				<tr><td><img src=\"images/notfound.png\"></td></tr>
				<tr><td class=\"erroPadrao\"><center> Ops...Algo de errado não está certo</center></td></tr>
			</table>
		</center>";


	die();
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
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class = "container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
    		<div class="navbar-header">
      			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        			<span class="sr-only">Toggle navigation</span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
      			</button>
    		</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class = "nav navbar-nav">
					<li><a href="users.php"> Página Inicial </a></li>
					<?php 

						if($_SESSION['auto']=='E'){
							echo '<li class="active"><a href="meus-estagios.php"> Meus Estágios </a></li>';
						}

						if($_SESSION['auto']=='V'){
							echo '<li><a href="cadastros-pendentes.php"> Cadastros </a></li>';
						}

						if($_SESSION['auto']=='V' || $_SESSION['auto']=='P'){
							echo '<li><a href="documentos-pendentes.php"> Documentos </a></li>';
						}
					?>

					<li><a href='messages.php'>Mensagens</a></li>
					<li><a href="trocar-senha.php">Mudar Senha</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
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
	$mail->Password = 'sistemadegerenciamentodeestagiosfacom';// SMTP Password
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


function Recieve_msgs($mysqli, $ID, $max)
{
	$ID_c = mysqli_real_escape_string($mysqli, $ID);
	if($max == 0)
		$msgs = mysqli_query($mysqli, "SELECT *
										FROM `mensagens`
										WHERE ID_Conversa = $ID_c
										ORDER BY Marca_De_Tempo ASC") or die(mysqli_error($mysqli));
	else 
		$msgs = mysqli_query($mysqli, " SELECT *
										FROM (	SELECT *
												FROM `mensagens`
												WHERE ID_Conversa = $ID_c
												ORDER BY Marca_De_Tempo DESC LIMIT $max) as T1
										ORDER BY T1.Marca_De_Tempo ASC
										") or die(mysqli_error($mysqli));
	return $msgs;
}

/*
Anotações:
18/01/2015, 18:06: Victor Gaíva
	"session_start()" está sendo ultilizada para guardar o nome da ultima tentativa de Login em "entra.php" nas linhas 14 e 17, e depois é ultilizada pra preencher automaticamento o campo de "username" em "index.php". Isso pode ser muito inseguro e uma maneira melhor de fazer isso deve existir. 


TODO:
Funcionalidades:
 	65% - Implementar a guia "Mensagens" {
 		- Mostrar corretamente o nome do usuario com que está conversando
 		- Modificar a interface para ficar mais simplificada

 	}

Segurança:

Melhorias Gráficas:
	 0% - Melhorar o método de aviso ao usuário quando um "username" ou "e-mail" já está em uso.
	 0% - Criar Tabela pagina de visualização de informações sobre estágio antes da página de edição.

Organização:
   	10% - Organizar disposição de scripts php dentro da pasta "sistema".
	10% - Comentar scripts

*/
?>

