<?php

function InsereEmail($conexao, $destinatario, $assunto, $mensagem){


	$destinatario = mysqli_escape_string($conexao,$destinatario);
	$mensagem = str_replace("\n","<br><br>",$mensagem);

	$result = mysqli_query($conexao, "INSERT INTO email_buffer(Destinatario,Texto,Assunto) VALUES ('$destinatario', '$mensagem', '$assunto')") or die( mysqli_error($conexao) );
	
	
	if($result)
		return true;
	else
		return false;

}

