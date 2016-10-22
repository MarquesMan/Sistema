<?php
	session_start();
	require_once("conecta.php");


	//<!-- Dados do Usuario -->

	//$str = $_POST['dataObject']; 
	var_dump($_POST); 

	$Numero 	= $_POST['Numero'];
	$User 		= $_POST["User"];

	$Curso 		= $_POST['Curso'];
	$Modalidade = $_POST['Modalidade'];
	$Nome 		= $_POST['Nome'];
	$Endereco 	= $_POST['Endereco'];
	$Telefone 	= $_POST['Telefone'];
	$Email 		= $_POST['Email'];

	//<!-- Dados da Empresa -->

	$Nome_Empresa 		= $_POST['Nome_Empresa'];
	$Endereco_Empresa 	= $_POST['Endereco_Empresa'];
	$Cidade_Empresa		= $_POST['Cidade_Empresa'];
	$Estado_Empresa		= $_POST['Estado_Empresa'];
	$CEP_Empresa		= $_POST['CEP_Empresa'];
	$Telefone_Empresa 	= $_POST['Telefone_Empresa'];
	$Ramal_Empresa		= $_POST['Ramal_Empresa'];
	$Fax_Empresa		= $_POST['Fax_Empresa'];
	$Email_Empresa 		= $_POST['Email_Empresa'];

	//<!-- Dados do Supervisor -->

	$Nome_Supervisor 		= $_POST['Nome_Supervisor'];
	$Telefone_Supervisor 	= $_POST['Telefone_Supervisor'];
	$Ramal_Supervisor		= $_POST['Ramal_Supervisor'];
	$Fax_Supervisor			= $_POST['Fax_Supervisor'];
	$Email_Supervisor 		= $_POST['Email_Supervisor'];

$sql = mysqli_query($mysqli, "UPDATE plano_de_bool SET
																	Curso = '$Curso', 
																	Modalidade = '$Modalidade', 
																	Nome = '$Nome',
																	Endereco = '$Endereco',
																	Telefone = '$Telefone',
																	Email = '$Email',
																	Nome_Empresa = '$Nome_Empresa',
																	Endereco_Empresa = '$Endereco_Empresa',
																	Cidade_Empresa = '$Cidade_Empresa',
																	Estado_Empresa = '$Estado_Empresa',
																	CEP_Empresa = '$CEP_Empresa',
																	Telefone_Empresa = '$Telefone_Empresa',
																	Ramal_Empresa = '$Ramal_Empresa',
																	Fax_Empresa = '$Fax_Empresa',
																	Email_Empresa = '$Email_Empresa',
																	Nome_Supervisor = '$Nome_Supervisor',
																	Telefone_Supervisor = '$Telefone_Supervisor',
																	Ramal_Supervisor = '$Ramal_Supervisor',
																	Fax_Supervisor = '$Fax_Supervisor',
																	Email_Supervisor = '$Email_Supervisor'
																	WHERE Numero='$Numero' AND User='$User' "
																	)or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($mysqli));
							exit();

?>