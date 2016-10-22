<html>
	<?php
	session_start(); // começa a session
	require_once("../../Action/funcoes-de-controle.php"); 


	if(Check_Login_Status())
	{
		Update_Login_Status();
		header("Location: users.php"); /* Redirect browser */
		exit();
	}

	?>

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" charset='UTF-8'>
		<link rel="shortcut icon" href="images/favicon.ico"/>
		
		<title>Sistema de Estágios - UFMS - Login</title>
		<link href = "css/bootstrap.css" rel = "stylesheet" >
		<link href = "css/index.css" rel = "stylesheet" >
		<link href = "css/fontello-ie7-codes.css" rel = "stylesheet" >
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.maskedinput.js"></script>
		<script src="js/index.js"></script>
		<script type="text/javascript">
			<?php
			if(isset($_SESSION["Last_try"])){?>
				var user =<?php echo $_SESSION["Last_try"];
			}
			else
			{
				?>
				var user = "";
				<?php
			}
			?>
			$("input[name=username]").val(user);
		</script>

		<?php 
			if(isset($_SESSION["Last_try"])){
				unset($_SESSION["Last_try"]);
			}
			$redirect = isset($_GET["redirect"])?"?redirect=".urlencode($_GET["redirect"]):"";
		?>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">		
				<div class="col-xs-12 col-md-12 alerta">
					<?php MostraAlerta();?>
				</div>


				<?php /* 
					  []------------------------------------------------------------------------------------------------------[]
				      |									Formulário de Login  												  |
					  []------------------------------------------------------------------------------------------------------[]
					  */ 
				?>
				<div class="centro">
					<div class="centro-f">
						<form class="form-horizontal" id="form_login" name="form_login" method="post" action="<?= 'Controllers/Controller-index.php'.$redirect ?>">
						 	
						 	<div class="form-group">
						    	<label for="inputEmail3" class="col-sm-3 col-md-2 control-label">Nome de Usuario:</label>
						    	<div class="col-sm-6 col-md-3 col-lg-3">
						      		<input type="text" name="username" class="form-control" id="inputEmail3" placeholder="Nome de Usuário">
						    	</div>
						  	</div>

						  	<div class="form-group">
						    	<label for="inputPassword3" class="col-sm-3 col-md-2 control-label">Senha:</label>
						    	<div class="col-sm-6 col-md-3 col-lg-3">
						    		<input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Senha">
						    	</div>
						  	</div>

						 	<div class="form-group">
						    	<div class="col-sm-offset-3 col-md-offset-2 col-sm-4 col-md-3">
						      		<button name="botao_envio" value="botao_login" type="submit" class="btn btn-default" style="width: 30%;">Login</button>
						    	</div>
						  	</div>
						</form>	
						
						<div class="col-sm-offset-3 col-md-offset-2 col-sm-4 col-md-3" style="padding: 5px;">
							<a id="cadastrar" href="#">Cadastre-se</a>
							<a id="recuperar" href="#" style="padding-left: 20px;">Recuperar Senha</a>
						</div>
					</div>
				</div>				
			</div>
		</div>

		<div id="menuslide_cadastrar" class="menuslide">
				<div class="container">
					<div class="row">
						
						<div name="fechar_slide">
							<button> >>> </button>
						</div>
						
						<div class="centro">
							<div class="centro-f">
							<div class="row">
								<label class="col-sm-3 col-md-3 col-lg-2">Tipo Cadastro:</label>
								<div class="col-sm-3 col-md-2 col-lg-2" style="margin-bottom: 20px;">
									<select id="proforaluno" name="tipo" class="form-control" ><!--Na tela 4:3 precisa pelo menos 22% senao o texto fica cortado-->
										<option value="E" selected="selected">Estudante</option>
										<option value="P">Surpevisor</option>
										<option value="B">Empresa</option>
									</select>
								</div>
							</div>

								<?php /* 
									  []------------------------------------------------------------------------------------------------------[]
								      |									Formulário de Cadastro Pessoas										  |
									  []------------------------------------------------------------------------------------------------------[]
									  */ 
								?>

								<form id="form-pessoa" name="Form" method="post" action="Controllers/Controller-index.php" class="form-horizontal">
									<input id="tipo" name="tipo" hidden></input>

									<div class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2">Nome Completo:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input name="fullname" class="form-control"/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2">Nome de Usuário:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input name="username" class="form-control"/>
										</div>
									</div>	

									<div id="cursoID" class="form-group row">
										<label class="col-sm-3 col-md-3 col-lg-2">Curso:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<select class="form-control" name="idCurso" style="text-overflow: ellipsis;">
											<?php
												

												foreach(Lista_Cursos() as $item ){
													if($item['nome']!='Nenhum'){												
														echo '<option value="'.$item['Id_Curso'].'">'.$item['nome'].'</option>';
													}
												}
									
											?>
											</select>
										</div>
									</div>

									<div id="rgaID" class="form-group row">
										<label class="col-sm-3 col-md-3 col-lg-2">RGA:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input name="rga" class="form-control"/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2">E-mail:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input name="email" class="form-control"/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2">Senha:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input name="password" type="password" class="form-control"/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2">Confirmar Senha:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input name="conf_password" type="password" class="form-control"/>
										</div>
									</div>

									<div class="form-group">
								    	<div class="col-sm-offset-3 col-md-offset-3 col-lg-offset-2 col-sm-3 col-md-2 col-lg-2">
								      		<button id="cadastro_pessoa" name="botao_envio" value="botao_pessoa" value="Cadastrar" class="btn btn-primary" style="width: 100%;">Cadastrar</button>
								    	</div>
								  	</div>
								</form>

								<?php /* 
									  []------------------------------------------------------------------------------------------------------[]
								      |									Formulário de Cadastro de Empresa									  |
									  []------------------------------------------------------------------------------------------------------[]
									  */ 
								?>

								<form id="form-empresa" name="Form-empresa" method="post" action="Controllers/Controller-index.php" class="form-horizontal" hidden>
									<input name="tipo" value="B" hidden></input>

									<div class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2">Nome:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input name="nome-empresa" class="form-control"/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2">CEP:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input id="cep" type="text" name="cep-empresa" class="form-control" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2">Rua:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input name="rua-empresa" class="form-control" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2">Número:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input name="numero-empresa" class="form-control" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2">Bairro:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input name="bairro-empresa" class="form-control" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2">Complemento:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input name="complemento" class="form-control"/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2">Telefone:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input id="telefone" type="text" id="telefone-empresa" name="telefone-empresa" class="form-control"/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2">E-mail:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">
											<input name="email-empresa" class="form-control"/>
										</div>
									</div>

									<div class="form-group">
								    	<div class="col-sm-offset-3 col-md-offset-3 col-lg-offset-2 col-sm-3 col-md-2 col-lg-2">
								      		<button id="cadastro_empresa" name="botao_envio" value="botao_empresa" value="Cadastrar" class="btn btn-primary" style="width: 100%;">Cadastrar</button>
								    	</div>
								  	</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				</div>

				<div id="menuslide_recuperar" class="menuslide">
					<div class="container">
						<div class="row">
							<div name="fechar_slide">
								<button> >>> </button>
							</div>
						
							<div class="centro">
								<div class="centro-f">
									<?php /* 
										  []------------------------------------------------------------------------------------------------------[]
									      |									Formulário de Reuperar Senha										  |
										  []------------------------------------------------------------------------------------------------------[]
										  */ 
									?>

									<form id="Form_Recovery" name="form" method="post" action="<?= 'Controllers/Controller-index.php'.$redirect ?>" class="form-horizontal">
										
										<div class="row">
											<div class="col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-sm-3 col-md-2 col-lg-2" style="margin-bottom: 20px;">
													<select id="Select_field" name="tipo" class="form-control">
													<option value="E" selected="selected">E-mail</option>
													<option value="R">RGA</option>
													<option value="U">Nome de Usuário</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<div class="col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-sm-4 col-md-4 col-lg-4">
												<input name="inp_indentificacao" class="form-control" /><br/>
											</div>
										</div>

										<div class="form-group">
									    	<div class="col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-sm-4 col-md-4 col-lg-3">
									      		<input id="botao_recuperacao" name="botao_recuperar" value="Recuperar" type="submit" class="btn btn-primary" style="width: 50%;">
									    	</div>
									  	</div>									
										
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
	</body>
</html>