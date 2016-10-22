<?php if ( ! defined('ABSPATH')) exit; ?>
<!DOCTYPE html>
<html>
	<head>

		<?php
		if ( $this->logged_in ) {
			if ($this->check_permissions("estudante", $this->userdata['user_permissions'])) {
				header("Location: ".HOME_URI . "/meus-estagios");
			}
		} ?>

		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="shortcut icon" href="images/favicon.ico"/>

		<title>Sistema de Estágios - UFMS - Login</title>
		<?php $this->css("bootstrap");?>
		<?php $this->css("index");?>
		<?php $this->js("jquery-1.11.1.min");?>
		<?php $this->js("jquery-ui.min");?>
		<?php $this->js("bootstrap.min");?>
	</head>

	<body>
		<div class="container-fluid">
			<div class="row rowh">
				<div class="col-xs-12 col-md-12 alerta">
					<?php echo $this->login_error ; ?>
				</div>


				<?php /*
							  []------------------------------------------------------------------------------------------------------[]
							  |									Formulário de Login  												  |
							  []------------------------------------------------------------------------------------------------------[]
							  */
				?>
				<div class="centro">
					<div class="centro-f">
						<form class="form-horizontal" id="form_login" name="form_login" method="post">

							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 col-md-2 control-label">Nome de Usuario:</label>
								<div class="col-sm-6 col-md-3 col-lg-3">
									<input type="text" name="userdata[user]" class="form-control" id="inputEmail3" placeholder="Nome de Usuário"
										   value="<?php
										   echo htmlentities( chk_array( $_SESSION, 'last_try') );
										   ?>" required autofocus>
								</div>
							</div>

							<div class="form-group">
								<label for="inputPassword3" class="col-sm-3 col-md-2 control-label">Senha:</label>
								<div class="col-sm-6 col-md-3 col-lg-3">
									<input type="password" name="userdata[user_password]" class="form-control" id="inputPassword3" placeholder="Senha" required>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-3 col-md-offset-2 col-sm-4 col-md-3">
									<button name="botao_envio" value="botao_login" type="submit" class="btn btn-default" style="width: 30%;">Login</button>
								</div>
							</div>
						</form>

						<div class="col-sm-offset-3 col-md-offset-2 col-sm-4 col-md-3" style="padding: 5px;">
							<a href="<?= HOME_URI?>/cadastros/">Cadastre-se</a>
							<a href="<?= HOME_URI?>/recuperar-senha/" style="padding-left: 20px;">Recuperar Senha</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>