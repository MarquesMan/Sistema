<?php

require_once("../conecta.php");
require_once("../../../Action/funcoes-de-controle.php");
require_once("../../../Action/banco-email.php");

$mysqli->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

$query = "SELECT * FROM email_buffer";

$result = mysqli_query($mysqli, $query) or die( mysqli_error($mysqli) );

$query = "DELETE FROM email_buffer";

$delete =  mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

$mysqli->commit();

$mysqli->close();

while($row = mysqli_fetch_assoc($result))
{
	if(Send_Email_To($row['Destinatario'], $row['Assunto'], $row['Texto'])!=1){
		InsereEmail($conexao, $destinatario, $assunto, $mensagem);
	}

}

