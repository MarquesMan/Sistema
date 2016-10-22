<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


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

			if(in_array("estudante", $user_permissions)){

				if($this->router->fetch_class() == "estagios"){
					echo '<li class="active"><a href="'.base_url("/estagios").'"> Meus Estágios </a></li>';
				}
				else{
					echo '<li id="papapa"><a href="'.base_url("/estagios").'"> Meus Estágios </a></li>';
				}

			}

			/*if(in_array("presidente", $_SESSION['user_permissions'])){
				if($this->router->fetch_class() == "cadastros-pendentes"){
					echo '<li class="active"><a href="'.HOME_URI.'/cadastros-pendentes"> Cadastros </a></li>';
				}
				else{
					echo '<li><a href="'.HOME_URI.'/cadastros-pendentes"> Cadastros </a></li>';
				}
			}

			if(in_array("presidente", $_SESSION['user_permissions']) || in_array("supervisor",['user_permissions'])){
				if($this->router->fetch_class() == "documentos-pendentes"){
					echo '<li class="active"><a href="'.HOME_URI.'/documentos-pendentes"> Documentos </a></li>';
				}
				else{
					echo '<li><a href="'.HOME_URI.'/documentos-pendentes"> Documentos </a></li>';
				}

				if($this->router->fetch_class() == "administracao"){
					echo '<li class="active"><a href="'.HOME_URI.'/administracao"> Adiministração </a></li>';
				}
				else{
					echo '<li><a href="'.HOME_URI.'/administracao"> Adiministração </a></li>';
				}
			}*/

			?>

			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Perfil de usuário<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li <?= ($this->router->fetch_class() == "perfil-usuario")?"class='active'": ""?>><a href="<?= base_url('/perfil-usuario');?>">Mudar Senha</a></li>
				</ul>
			</li>

			<li><a href="<?= base_url('/users/logout')?>">Sair</a></li>
		</ul>
	</div>
</nav>