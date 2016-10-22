<?php

require_once("../www/sistema/conecta.php");
require_once("../Action/funcoes-de-controle.php");
require_once("../Action/banco-email.php");
require_once("../Action/banco-empresa.php");

$query = "	SELECT * FROM 
			usuarios as U inner join estagio as E on U.Id_Usuario=E.Id_Aluno   
			WHERE E.Data_Fim = CURRENT_DATE + INTERVAL 30 DAY OR E.Data_Fim = CURRENT_DATE + INTERVAL 15 DAY";

$estagios = mysqli_query($mysqli, $query) or die( mysqli_error($mysqli) );

$empresas = GetEmpresas($mysqli);

$assunto = "Seu estágio está chegando ao fim";

while($estagio = mysqli_fetch_assoc($estagios))
{

	$nomeCompleto = $estagio['Nome_Completo'];
	$nomeEmpresa  =	$empresas[$estagio['Id_Empresa']]['Nome'];
	$dataFinal = $estagio["Data_Fim"];
	$dataFinal = $dataFinal[8].$dataFinal[9]."/".$dataFinal[5].$dataFinal[6]."/".$dataFinal[0].$dataFinal[1].$dataFinal[2].$dataFinal[3];
	$mensagem =
	"Prezado aluno $nomeCompleto, seu estágio na empresa $nomeEmpresa está chegando ao fim($dataFinal).
	Por favor, não se esqueça de enviar o termo aditivo caso queira continuar no estágio.
	A declaração final também está disponível para o envio.";

	InsereEmail($mysqli, $estagio["Email"], $assunto, $mensagem);
	

}
