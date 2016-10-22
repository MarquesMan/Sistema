<?php
	require_once("../conecta.php"); // inclui a conexão a database
	require_once("../../../Action/funcoes-de-controle.php");
	require_once("../../../Action/banco-usuarios.php");
	require_once("../../../Action/banco-empresa.php");
	require_once("../../../Action/banco-email.php");

	session_start(); // começa a session

	if($_SERVER['REQUEST_METHOD'] != "POST"){
		$_SESSION["Failed"] = "Método de requisição incorreto. Por Favor tente novamente.";
		header("Location: ../index.php");
		die();
	}

	//Caso o envio tenha sido a partir do formulário de login
	if(isset($_POST["botao_envio"]) && $_POST["botao_envio"] == "botao_login"){
		
		$logar = FazerLogin($mysqli, $_POST['username'], $_POST["password"]);

		$_SESSION["Last_try"] = $_POST['username'];

		$redirect = isset($_GET["redirect"])?urldecode($_GET["redirect"]):"users.php";

		if($logar){
			header("Location: ../$redirect");
			die();
		}
		else{
			header("Location: ../index.php");
			die();
		}
	}

	//caso o envio tenha sido a partir do formulário de cadastro de um estudande ou supervisor 
	else if(isset($_POST["botao_envio"]) && $_POST["botao_envio"] == "botao_pessoa"){
		
		$count = 0;


		//verifica a quantidade de campos não preenchidos
		foreach($_POST as $chave => $valor) {
			if(empty($_POST[$chave]))
				$count++;
		}

		//Insere um Estudante
		if(!strcmp($_POST["tipo"], "E") && $count == 0)
		{
			//verifica se o e-mail esta no formato correto
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$_SESSION["Failed"] = "E-mail inválido.";
			    header("Location: ../index.php");
			    die();
			}

			$hash = CadastrarUsuario($mysqli, $_POST['rga'], $_POST["idCurso"], $_POST['fullname'], $_POST['username'], 
								 $_POST['email'], $_POST['password'], "E");
			if($hash != "")
			{
				$mensagem = '
					Obrigado por se cadastrar!\n
					------------------------\n
					Nome de usuário: "'.$_POST['username'].'"
					------------------------

					Por favor, clique no link abaixo para confirmar seu E-mail:
					http://localhost/sistema/verify.php?email='.$_POST['email'].'&hash='.$hash.'

				';
				
				if( InsereEmail($mysqli, $_POST['email'] , "Verificação de E-mail", $mensagem) ){
					$_SESSION["Success"] = "Solicitação de registro de aluno efetuado com sucesso.\nNós enviamos um E-mail para confirmação.";
				}
				else{
					$_SESSION["Failed"] = "Erro ao enviar e-mail.\nTente novamente mais tarde.";
				}
			}
			header("Location: ../index.php");
			die();
		}

		//Insere um professor
		else if(!strcmp($_POST["tipo"], "P") && ($count == 0 || ($count == 1 && empty($_POST["rga"]))))
		{		
			//verifica se o e-mail esta no formato correto
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$_SESSION["Failed"] = "E-mail inválido.";
			    header("Location: ../index.php");
			    die();
			}

			$hash = CadastrarUsuario($mysqli, "", "0", $_POST['fullname'], $_POST['username'],
							 $_POST['email'], $_POST['password'], "P", "0");

			if($hash != ""){
				$mensagem = '
					Obrigado por se cadastrar!
					------------------------
					Nome de usuário: "'.$_POST['username'].'"
					------------------------

					Por favor, clique no link abaixo para confirmar seu E-mail:
					http://localhost/sistema/verify.php?email='.$_POST['email'].'&hash='.$hash.'

				';

				if( InsereEmail($mysqli, $_POST['email'] , "Verificação de E-mail", $mensagem) ){
					$_SESSION["Success"] = "Solicitação de registro de supervisor efetuado com sucesso.\nPor favor, aguarde um E-mail para confirmação.";
				}
				else{
					$_SESSION["Failed"] = "Erro ao enviar e-mail.\nTente novamente mais tarde.";
				}
			}
			header("Location: ../index.php");
			die();
		}

		else{
			$_SESSION["Failed"] = "Todos os campos devem ser preenchidos.";
			header("Location: ../index.php");
			die();
		}
	}

	//Caso o envio tenha sido a partir do formulário de cadastro de empresa
	else if(isset($_POST["botao_envio"]) && $_POST["botao_envio"] == "botao_empresa"){
		$count = 0;

		//verifica a quantidade de campos não preenchidos
		foreach($_POST as $chave => $valor) {
			if(empty($_POST[$chave]))
				$count++;
		}

		//insere uma empresa
		if(!strcmp($_POST["tipo"], "B") && ($count == 0 || ($count == 1 && empty($_POST["complemento"]))))
		{	
			//verifica se o e-mail esta no formato correto
			if ($_POST["email-empresa"] != filter_var($_POST['email-empresa'], FILTER_VALIDATE_EMAIL)) {
				$_SESSION["Failed"] = "E-mail inválido.";
			    header("Location: ../index.php");
			    die();
			}

			$hash = CadastrarEmpresa($mysqli, $_POST["nome-empresa"], $_POST["email-empresa"], $_POST["telefone-empresa"], $_POST["cep-empresa"], 
						  		     $_POST["rua-empresa"], $_POST["numero-empresa"], $_POST["bairro-empresa"], $_POST["complemento"]);

			$mensagem = "
				Olá ".$_POST['nome-empresa']."!
				O cadastro da sua empresa no Sistema de Gerenciamento de Estágios FACOM-UFMS está sendo processado.
				Por favor, clique no link abaixo para confirmar seu E-mail
				http://localhost/sistema/verify.php?email=".$_POST['email-empresa']."&hash=$hash&type=Empresa
				
				";

			if( InsereEmail($mysqli, $_POST['email-empresa'] , "Verificação de E-mail", $mensagem) ){
					$_SESSION["Success"] = "Solicitação de registro de empresa efetuado com sucesso.\nNós enviaremos um E-mail para confirmação.";
			}
			else{
				$_SESSION["Failed"] = "Erro ao enviar e-mail.\nTente novamente mais tarde.";
			}

			header("Location: ../index.php");
		}

		else{
			$_SESSION["Failed"] = "Todos os campos devem ser preenchidos.";
			header("Location: ../index.php");
			die();
		}	
	}

	//Caso o envio tenha sido a partir do formulário de recuperação de senha
	else if(isset($_POST["botao_recuperar"]) && $_POST["botao_recuperar"] == "Recuperar"){
		if(isset($_POST["inp_indentificacao"]) && isset($_POST["tipo"]))
		{
			//Passo1: Verificar existencia do usuario no BD e recuperar seu e-mail
			$Retorno = ProcuraUsuario($mysqli, $_POST["inp_indentificacao"], $_POST["tipo"]);

			if($Retorno != "")
			{
				//Passo2: Gere a senha temporaria
				$tempPassword = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 8)), 0, 8);

				//Passo3: Troque a senha no sistema
				if(RecuperarSenha($mysqli, $tempPassword, $Retorno["Id_Usuario"])){
					//Passo4: Envie o e-mail com a nova senha para o usuario
					$message = '

						Você entrou com um pedido de recuperação de senha. A senha abaixo foi gerada automaticamente e sua senha antiga não é mais válida.
						É possivel trocar a senha gerada na aba "Mudar Senha" após realizar o login
						Segue abaixo a nova senha junto com seu nome de usuário.
						------------------------
						Username: "'.$Retorno['Nome_De_Usuario'].'"
						Password: "'.$tempPassword.'"
						------------------------
						http://localhost/sistema

						Caso você não tenha feito esse pedido de recuperação de senha por favor entre em contato com o administrador do Sistema.
						
						Att. Equipe PET-FACOM
						';

					if(InsereEmail($mysqli,$Retorno['Email'], 'Recuperacao de Senha', $message))
						$_SESSION["Success"] = "Senha temporaria enviada para o e-mail.";
					else
						$_SESSION["Failed"] = "Senha alterada mas ocorreu um erro no envio do e-mail com a nova senha. Por favor repita a operação.";
				}
				else
					$_SESSION["Failed"] = "Usuário não encontrado.";
			}
			else
				$_SESSION["Failed"] = "Erro interno. Tente novamente.";

			header("Location: ../index.php");
			die();

		}
		else{
			$_SESSION["Failed"] = "Erro interno. Tente novamente.";
			header("Location: ../index.php");
			die();
		}
	}

	else{
		$_SESSION["Failed"] = "Tipo de envio incorreto. Por Favor tente novamente.";
		header("Location: ../index.php");
		die();
	}
?>	