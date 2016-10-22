<?php
	
function enviaEmail($destinatario, $assunto, $mensagem)
{

	// O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
	// O return-path deve ser ser o mesmo e-mail do remetente.
	$headers = "MIME-Version: 1.1\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: nao-responda@campeonet.com.br\r\n"; // remetente
	$headers .= "Return-Path: nao-responda@campeonet.com.br\r\n"; // return-path
	$envio = mail($destinatario,'=?utf-8?B?'.base64_encode($assunto).'?=' , $mensagem, $headers);
	 
	if($envio)
	 return true;
	else
	 return false;

}