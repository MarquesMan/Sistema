<?php
//require_once "Mail/Queue.php";

function MostraAlerta(){
	if(isset($_SESSION["Success"])){ ?>

		<div class="alert alert-success alert-dismissible text-center" role="alert" style="width: 80%; margin-left: auto; margin-right: auto;">
  			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  			<?php echo $_SESSION["Success"]?>
		</div>
		
		<?php unset($_SESSION["Success"]);
	}

	if(isset($_SESSION["Failed"])){ ?>

		<div class="alert alert-danger alert-dismissible text-center" role="alert" style="width: 80%; margin-left: auto; margin-right: auto;">
  			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  			<?php echo $_SESSION["Failed"]?>
		</div>
	
		<?php unset($_SESSION["Failed"]);
	}
}

function Lista_Cursos(){

	require("../../www/sistema/conecta.php");

	$query = "SELECT * FROM cursos";
	$query = mysqli_query($mysqli, $query);

	$cursos = array();

	while($row = mysqli_fetch_assoc($query))
		$cursos[$row['Id_Curso']] = $row;

	return $cursos;

}

function Pagina_navegacao(){
	$file = basename($_SERVER['REQUEST_URI']);

	$name = explode("?", $file);

	$string = '<li class="active">Página Inicial</li>';

	if($name[0] == "meus-estagios.php")
		$string = '	<li><a href="users.php">Página Inicial</a></li>
					<li class="active">Meus Estágios</li>';

	else if($name[0] == "documentos-pendentes.php")
		$string = '	<li><a href="users.php">Página Inicial</a></li>
					<li class="active">Documentos Pendentes</li>';

	else if($name[0] == "cadastros-pendentes.php")
		$string = '	<li><a href="users.php">Página Inicial</a></li>
					<li class="active">Cadastros Pendentes</li>';

	else if($name[0] == "messages.php")
		$string = '	<li><a href="users.php">Página Inicial</a></li>
					<li class="active">Mensagens</li>';

	else if($name[0] == "perfil-usuario.php")
		$string = '	<li><a href="users.php">Página Inicial</a></li>
					<li class="active">Perfil de usuário</li>';

	else if($name[0] == "documentos-estagio.php")
		$string = '	<li><a href="users.php">Página Inicial</a></li>
					<li><a href="meus-estagios.php">Meus Estágios</a></li>
					<li class="active">Documentos</li>';

	else if($name[0] == "administracao.php")
		$string = '	<li><a href="users.php">Página Inicial</a></li>
					<li class="active" >Adiministração</a></li>';
    else if($name[0] == "documentos-estagio-admin.php")
        $string = '	<li><a href="users.php">Página Inicial</a></li>
					<li><a href="administracao.php" >Adiministração</a></li>
					<li class="active" >Documentos Estágio</a></li>';
	else if($name[0] == "superAdmin.php")
        $string = '	<li><a href="users.php">Página Inicial</a></li>
					<li><a class="active" href="superAdmin.php" >Adiministração</a></li>';
					

	?>

	<ol class="breadcrumb" style=" position: static;">
  		<?= $string?>
	</ol>

	<?php
}

function Set_Barra_Superior(){ 
	$file = substr($_SERVER["SCRIPT_NAME"], 9);  ?>

	<nav class="navbar navbar-default">
		
			<!-- Brand and toggle get grouped for better mobile display -->
    		<div class="navbar-header">
      			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#barra-superior">
        			<span class="sr-only">Toggle navigation</span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
      			</button>
    		</div>

			<div class="collapse navbar-collapse" id="barra-superior">
				<ul class = "nav navbar-nav">
						<li <?= ($file == "users.php")?"class='active'": ""?>><a href="users.php"> Página Inicial </a></li>
					
					<?php if($_SESSION['auto']=='Z'){?>
						<li <?= ($file == "superAdmin.php")?"class='active'": ""?>><a href="superAdmin.php"> Administração </a></li>
					<?php }?>
					<?php						
						if($_SESSION['auto']=='E'){
							if($file == "meus-estagios.php" || $file == "documentos-estagio.php"){
								echo '<li class="active"><a href="meus-estagios.php"> Meus Estágios </a></li>';
							}
							else{
								echo '<li><a href="meus-estagios.php"> Meus Estágios </a></li>';
							}							
						}

						if($_SESSION['auto']=='V'){
							if($file == "cadastros-pendentes.php"){
								echo '<li class="active"><a href="cadastros-pendentes.php"> Cadastros </a></li>';
							}
							else{
								echo '<li><a href="cadastros-pendentes.php"> Cadastros </a></li>';
							}							
						}

						if($_SESSION['auto']=='V' || $_SESSION['auto']=='P'){
							if($file == "documentos-pendentes.php"){
								echo '<li class="active"><a href="documentos-pendentes.php"> Documentos </a></li>';
							}
							else{
								echo '<li><a href="documentos-pendentes.php"> Documentos </a></li>';
							}
						}
					
						if($_SESSION['auto']=='V'|| $_SESSION['auto']=='P'){
							if($file == "administracao.php"){
								echo '<li class="active"><a href="administracao.php"> Adiministração </a></li>';
							}
							else{
								echo '<li><a href="administracao.php"> Adiministração </a></li>';
							}							
						}

					?>

					<!--<li <?//= ($file == "messages.php")?"class='active'": ""?>><a href='messages.php'>Mensagens</a></li>-->
					
					<li class="dropdown">
          				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Perfil de usuário<span class="caret"></span></a>
					    <ul class="dropdown-menu">
					    	<li <?= ($file == "perfil-usuario.php")?"class='active'": ""?>><a href="perfil-usuario.php">Mudar Senha</a></li>
					    </ul>
        			</li>
        			
					<li <?= ($file == "logout.php")?"class='active'": ""?>><a href="logout.php">Sair</a></li>
				</ul>
			</div>
		
	</nav>
	
	<?php
}

function Check_Login_Status() {
	return isset($_SESSION["sessioname"]) && $_SESSION["session_time"] >= time();
}

function Update_Login_Status() {
	$_SESSION["session_time"] = time() + 1800;
}


function ValidaUsuario(){
	$file = urlencode(basename($_SERVER['REQUEST_URI']));

	if(Check_Login_Status())
	{
		Update_Login_Status();
	}

	else
	{
    	$_SESSION["Failed"] = "Acesso negado!";
    	unset($_SESSION["sessioname"]);
    	unset($_SESSION["session_time"]);
   		header("Location: index.php?redirect=$file");
   		die();
	}
}

//E-mails devem ser enfilerados quando a requisição de envio de emial foi feita pelo usuario. Caso contrario o email deve ser enviado diretamente.
function EnfileraEmail($dest, $subj, $message, $altMessage){
	$dest		= mysqli_real_escape_string($dest);
	$subj		= mysqli_real_escape_string($subj);
	$message 	= mysqli_real_escape_string($message);
	$altMessage	= mysqli_real_escape_string($altMessage);

	$queryTxt = "INSERT INTO 'fila_email'
				Destino 	= '$dest',
				Assunto 	= '$subj',
				Conteudo	= '$message',
				AltConteudo	= '$altMessage'
	";
	$query = mysqli_query($conexao,$queryTxt) or die(mysqli_error($mysqli));
}


// Transforma data do bd (1111-11-22) em 22/11/1111
function imprimeData($data){

	return $data[8].$data[9]."/".$data[5].$data[6]."/".$data[0].$data[1].$data[2].$data[3];

}

function Send_Email_To($dest, $subj, $message, $altMessage = "") {
	require_once("PHPMailer/PHPMailerAutoload.php");

	$mail = new PHPMailer;
	$headers = 'From:noreply@sistema.com' . '\r\n'; 			// Set from headers
	
	$message = str_replace('\n.', '\n..', $message);
	$headers = str_replace('\n.', '\n..', $headers);
	$subj 	 = str_replace('\n.', '\n..', $subj);
	

	//$mail->SMTPDebug = 3;                               		// Enable verbose debug output

	$mail->isSMTP();                                      		// Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com'; 			 		  		// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               		// Enable SMTP authentication
	$mail->Username = 'sistemadeestagiosfacom@gmail.com';	  	// SMTP username
	$mail->Password = 'sistemadegerenciamentodeestagiosfacom';	// SMTP Password
	$mail->SMTPSecure = 'tls';                            		// Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    		// TCP port to connect to
	$mail->CharSet = 'UTF-8';
	$mail->From = 'noreply@sistema.com';
	$mail->FromName = 'Sistema';
	$mail->addAddress($dest);  						  			// Add a recipient
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subj;
	$mail->Body    = $message;
	//Se o corpo alternativo estiver setado, use-o
	if($altMessage == "")
		$mail->AltBody = $message;
	else
		$mail->AltBody = $altMessage;

	if(!$mail->send())
	{
	    return $mail->ErrorInfo;
	}
	else
		return 1;
}

function erroPadrao($descricaoErro){

	echo "<center>
			<img src=\"images/notfound.png\"><br>
			<b style=\"font-size:25px;\">$descricaoErro</b>
		  </center>";
	die();
}
function EchoDate($date){
	echo date_format(date_create($date), 'd/m/Y');
}

?>