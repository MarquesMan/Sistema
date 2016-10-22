<?php 
	session_start();
	require_once("../conecta.php");
	require_once("../../../Action/banco-termo-aditivo.php");


	if( isset($_POST['idTermoAditivo'], $_POST['MAX_FILE_SIZE'], $_POST['botaoTAModal'], $_POST['dataTA']  ) ){
		
			if($_FILES['termo_aditivo_arquivo']['size'] > 0)
			{ 
				$NomeArquivo 	 = $_FILES['termo_aditivo_arquivo']['name'];
				$NomeTemporario  = $_FILES['termo_aditivo_arquivo']['tmp_name'];
				$TamanhoArquivo  = $_FILES['termo_aditivo_arquivo']['size'];
				$TipoArquivo 	 = $_FILES['termo_aditivo_arquivo']['type'];
                $idTermoAditivo =  $_POST['idTermoAditivo'];
                $Data = DateTime::createFromFormat('d/m/Y', mysqli_real_escape_string( $mysqli ,$_POST['dataTA']) )->format('Y/m/d') ;

				$fp       = fopen($NomeTemporario, 'r');
				$conteudo = fread($fp, filesize($NomeTemporario));
				$conteudo = addslashes($conteudo);
				fclose($fp);

				if(!get_magic_quotes_gpc())
				{
			    	$NomeArquivo = addslashes($NomeArquivo);
				}

				$resultado = atualizaTermoAditivo($mysqli, $idTermoAditivo, $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo, $Data);
				
			}else{

				$_SESSION["Failed"] = "Paramêtros incorretos.";
				header("Location:../meus-estagios.php"); /* Redirect browser */		
			}

        if($resultado)
	    	$_SESSION["Success"] = "Termo Aditivo enviado para aprovação.";

        header("Location:../meus-estagios.php"); /* Redirect browser */
		exit();
	
	}else if( isset($_POST['idEstagio'], $_POST['MAX_FILE_SIZE'], $_POST['botaoTAModalNovo'], $_POST['dataTA']  ) ){

        if($_FILES['novo_termo_aditivo_arquivo']['size'] > 0)
        {
            $NomeArquivo 	 = $_FILES['novo_termo_aditivo_arquivo']['name'];
            $NomeTemporario  = $_FILES['novo_termo_aditivo_arquivo']['tmp_name'];
            $TamanhoArquivo  = $_FILES['novo_termo_aditivo_arquivo']['size'];
            $TipoArquivo 	 = $_FILES['novo_termo_aditivo_arquivo']['type'];
            $idEstagio =  $_POST['idEstagio'];

            $Data = DateTime::createFromFormat('d/m/Y', mysqli_real_escape_string( $mysqli ,$_POST['dataTA']) )->format('Y/m/d');

            $fp       = fopen($NomeTemporario, 'r');
            $conteudo = fread($fp, filesize($NomeTemporario));
            $conteudo = addslashes($conteudo);
            fclose($fp);

            if(!get_magic_quotes_gpc())
            {
                $NomeArquivo = addslashes($NomeArquivo);
            }

            InsereTermoAditivo($mysqli, $idEstagio, $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo,$Data );
            header("Location:../meus-estagios.php"); /* Redirect browser */
            exit();

        }else{

            $_SESSION["Failed"] = "Paramêtros incorretos.";
            header("Location:../meus-estagios.php"); /* Redirect browser */
        }

        if($resultado)
            $_SESSION["Success"] = "Termo Aditivo enviado para aprovação.";

        header("Location:../documentos-estagio.php?idEstagio=".$idEstagio); /* Redirect browser */
        exit();

    }
    else{

		$_SESSION["Failed"] = "Paramêtros incorretos.";
		header("Location:../meus-estagios.php"); /* Redirect browser */
	}
	
	?>