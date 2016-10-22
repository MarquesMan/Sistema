<?php if ( ! defined('ABSPATH')) exit; ?>

<?php if ( $this->login_required && ! $this->logged_in ) return; ?>

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

	<div class="collapse navbar-collapse pg-w" id="barra-superior">
		<ul class = "nav navbar-nav">
			<?php

			if(in_array("estudante", $_SESSION['userdata']['user_permissions'])){

				if($this->controlador == "meus-estagios"){
					echo '<li class="active"><a href="'.HOME_URI.'/meus-estagios"> Meus Estágios </a></li>';
				}
				else{
					echo '<li><a href="'.HOME_URI.'/meus-estagios"> Meus Estágios </a></li>';
				}

			}

			if(in_array("presidente", $_SESSION['userdata']['user_permissions'])){
				if($this->controlador == "cadastros-pendentes"){
					echo '<li class="active"><a href="'.HOME_URI.'/cadastros-pendentes"> Cadastros </a></li>';
				}
				else{
					echo '<li><a href="'.HOME_URI.'/cadastros-pendentes"> Cadastros </a></li>';
				}
			}

			if(in_array("presidente", $_SESSION['userdata']['user_permissions']) || in_array("supervisor", $_SESSION['userdata']['user_permissions'])){
				if($this->controlador == "documentos-pendentes"){
					echo '<li class="active"><a href="'.HOME_URI.'/documentos-pendentes"> Documentos </a></li>';
				}
				else{
					echo '<li><a href="'.HOME_URI.'/documentos-pendentes"> Documentos </a></li>';
				}

				if($this->controlador == "administracao"){
					echo '<li class="active"><a href="'.HOME_URI.'/administracao"> Adiministração </a></li>';
				}
				else{
					echo '<li><a href="'.HOME_URI.'/administracao"> Adiministração </a></li>';
				}
			}
			?>

			<!--<li <?//= ($this->controlador == "messages")?"class='active'": ""?>><a href='messages.php'>Mensagens</a></li>-->

			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Perfil de usuário<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li <?= ($this->controlador == "perfil-usuario")?"class='active'": ""?>><a href="<?= HOME_URI."/perfil-usuario"?>">Mudar Senha</a></li>
				</ul>
			</li>

			<li><a href="<?= HOME_URI."/user/logoutaction"?>">Sair</a></li>
		</ul>
	</div>
</nav>