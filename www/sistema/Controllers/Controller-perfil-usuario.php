<?php
	session_start(); // começa a session
	require_once("../conecta.php");
	require_once("../../../Action/funcoes-de-controle.php");
	require_once("../../../Action/banco-usuarios.php");

	ValidaUsuario();

    if(isset($_POST["editaPerfilAdmin"]) ){

        if( isset($_POST["editaPerfilAdmin"]) ){

            $result = alteraDadosUsuario($mysqli, $_POST['id_estagiario'], $_POST['nomeCompleto'],$_POST['curso'],$_POST['RGA'],$_POST['email'],$_POST['telefone']);

            if($result){
                $_SESSION["Success"] = "Alteração concluída.";
            }else{
                $_SESSION["Failed"] = "Alteração falhou.";
            }

            header("Location: ../administracao.php");
            die();


        }
        else{
            $_SESSION["Failed"] = "Parâmetros incorretos.";
            header("Location: ../administracao.php");
            die();
        }
    }

	if(!isset($_POST["senha_atual"]) || !isset($_POST["nova_senha"]) || !isset($_POST["confirma_senha"])){
		$_SESSION["Failed"] = "Erro no envio dos dados. Por favor tente novamente.";
		header("Location: ../trocar-senha.php");
		die();
	}

    $count = 0;
	//verifica a quantidade de campos preenhidos
	foreach($_POST as $chave => $valor){
		if(empty($_POST[$chave]))
			$count++;
	}

	if($count == 0){
		if(TrocarSenha($mysqli, $_POST["senha_atual"], $_POST["nova_senha"], $_POST["confirma_senha"])){
			$message = '

				Mudanca de senha realizada. Seguem seus dados atualizados:
				------------------------
				Username: "'.$_SESSION["sessioname"].'"
				Password: "'.$_POST["nova_senha"].'"
				------------------------
				http://localhost/sistema

			';

			$_SESSION["Success"] = "Senha alterada com sucesso.";

			$ret = Send_Email_To($_SESSION["email"], 'Mudanca de senha', $message);

			if($ret == 1){
				header("Location: ../users.php");
				die();
			}

			else{
				$_SESSION["Failed"] = "Erro ao enviar e-mail. Tente novamente mais tarde.".$_SESSION["email"].":".$ret;
				header("Location: ../perfil-usuario.php");
				die();
			}
		}
		else{
			header("Location: ../perfil-usuario.php");
			die();
		}
					
				
	}

	else{
		$_SESSION["Failed"] = "Alguns campos estao vazios.";
		header("Location: ../perfil-usuario.php");
		die();
	}

