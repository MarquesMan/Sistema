<?php
requie_once("../Action/funcoes-de-controle.php");
requie_once("../sistema/conecta.php");
/*
*	Esta rotina envia um e-mail para cada aluno que o estagio esteja com menos de 30 dias para o terminio informando-o que ele
* 		pode inserir um termo aditivo.
*/

//Seleciona todos os estagios com menos de 30 dias para o terminio
$queryTxt ="SELECT u.Nome_Completo, u.Email, e.Data_Fim, e.StatusEmail, e.Id_Estagio
			FROM usuarios u, estagio e
			WHERE u.Id_Usuario = e.Id_Usuario
			AND (
					(e.Data_Fim <= DATEADD(month, 1,GETDATE()) and e.StatusEmail = 0)
				OR  (e.Data_Fim <= DATEADD(day  ,15,GETDATE()) and e.StatusEmail = 1)
			)";
$query = mysqli_query($mysqli,$queryTxt) or die(mysqli_error($mysqli));
$Estagios = mysqli_fetch_assoc($query);

foreach ($Estagios as $row) {
	$Destino = $row['Email'];
	$Link	 = "";//TODO: Link para preenchimento de termo aditivo
	$Dias 	 = "";

	//Aviso de 30 dias
	if($row['StatusEmail'] == 0)
		$Dias = '30';

	//Aviso de 15 dias
	else if($row['StatusEmail'] == 1)
		$Dias = '15';
	
	$Assunto  = "Aviso: Sistema de Estagios. $Dias dias restantes.";
	$Conteudo =
	"<html style='height:100%;display:table;margin:auto;'>
		<head>
			<meta http-equiv='Content-Type' content='text/html;charset=UTF-8'>
		</head>
		<body style='display:table-cell;vertical-align:middle;'>
			<p>
				Nosso sistem indentificou que seu estágio será finalizado em".date_format(date_create($row['Data_Fim']), 'd/m/Y');.".
			</p>
			<p>
				<a href='$Link'>Clique aqui<a> para enviar um termo aditivo. Ignore esse E-mail casso não tenha interesse.
			</p>
		</body>
	</html>";
	$ConteudoAlt = 
	"Nosso sistem indentificou que seu estágio será finalizado em".date_format(date_create($row['Data_Fim']), 'd/m/Y');.".\n
	Acesse $Link para enviar um termo aditivo. Ignore esse E-mail casso não tenha interesse.";

	if(Send_Email_To($Destino, $Assunto, $Conteudo)){//email enviado com sucesso
		//Atualiza status
		$queryTxt =
		"UPDATE 'estagio'
		 SET StatusEmail = StatusEmail + 1
		 WHERE estagio.Id_Estagio = $row['Id_Estagio']
		";
		mysqli_query($mysqli, $queryTxt) or die(mysqli_error($mysqli));
	}
}


?>