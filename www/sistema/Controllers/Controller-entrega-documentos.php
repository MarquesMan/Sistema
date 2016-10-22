<?php
	session_start();
	require_once("../conecta.php");
	require_once("../../../Action/banco-estagios.php");
    require_once("../../../Action/banco-declaracao-final.php");
	require_once("../../../Action/banco-relatorios.php");
	require_once("../../../Action/banco-termo-de-compromisso.php");
    require_once("../../../Action/banco-termo-aditivo.php");

	if(isset($_POST['EntregaEstagio'] )){


        $result = EntregaDocumentosEstagio($mysqli, $_POST['idEstagio']);

        if($result){
            $_SESSION["Success"] = "Estágio aprovado com sucesso.";
        }else{
            $_SESSION["Failed"] = "Ocorreu um erro.";
        }

        header("Location:../documentos-pendentes.php"); /* Redirect browser */

    }else if(isset($_POST['EntregaRelatorio'] )){

        $result = EntregaRelatorio($mysqli, $_POST['idRelatorio']);

        if($result){
            $_SESSION["Success"] = "Relatório aprovado com sucesso.";
        }else{
            $_SESSION["Failed"] = "Ocorreu um erro.";
        }

        header("Location:../documentos-pendentes.php"); /* Redirect browser */

    }else if(isset($_POST['EntregaDeclaracao'] )){

        $result = EntregaDeclaracao($mysqli, $_POST['idDeclaracao']);

        if($result){
            $_SESSION["Success"] = "Declaração final aprovada com sucesso.";
        }else{
            $_SESSION["Failed"] = "Ocorreu um erro.";
        }

        header("Location:../documentos-pendentes.php"); /* Redirect browser */

    }
    else if(isset($_POST['EntregaTermoAditivo'] )){

        $result = EntregaTermoAditivo($mysqli, $_POST['idTermo']);

        if($result){
            $_SESSION["Success"] = "Termo aditivo aprovado com sucesso.";
        }else{
            $_SESSION["Failed"] = "Ocorreu um erro.";
        }

        header("Location:../documentos-pendentes.php"); /* Redirect browser */

    }


