<html>

<head>
		
		<meta charset = 'UTF-8'>
		<link rel="shortcut icon" href="images/favicon.ico"/>		
		<title>Sistema de Estágios - UFMS - Plano de Ativadades</title>
		<link href = "css/bootstrap.css" rel = "stylesheet" >
		<link href = "css/plano.css" rel = "stylesheet" >
		
</head>


<?php
	session_start();
	require_once("conecta.php");


	//<!-- Dados do Usuario -->

	$Numero 	= $_POST['numbAdd'];
	$User 		= $_SESSION["sessioname"];

	echo $Numero;

	$prof = mysqli_query($mysqli,"SELECT * FROM usuarios WHERE Id_Usuario=".$_POST['Codigo-Supervisor']) or die(mysql_error());
	$prof = mysqli_fetch_assoc($prof);

	//mysqli_query($mysqli,"DELETE FROM plano_de_atividades WHERE Numero='".$Numero."' AND User='".$User."'") or die(mysql_error());

	
	$Curso 		= mysqli_real_escape_string( $mysqli ,$_POST['Curso']);
	$Modalidade = $_POST['Modalidade'];
	$Nome 		= mysqli_real_escape_string( $mysqli ,$_POST['Nome']);
	$Endereco 	= mysqli_real_escape_string( $mysqli ,$_POST['Endereco']);
	$Telefone 	= mysqli_real_escape_string( $mysqli ,$_POST['Telefone']);
	$Email 		= mysqli_real_escape_string( $mysqli ,$_POST['Email']);

	//<!-- Dados da Empresa -->

	$Nome_Empresa 		= mysqli_real_escape_string( $mysqli ,$_POST['Nome-Empresa']);
	$Endereco_Empresa 	= mysqli_real_escape_string( $mysqli ,$_POST['Endereco-Empresa']);
	$Cidade_Empresa		= mysqli_real_escape_string( $mysqli ,$_POST['Cidade-Empresa']);
	$Estado_Empresa		= mysqli_real_escape_string( $mysqli ,$_POST['Estado-Empresa']);
	$CEP_Empresa		= mysqli_real_escape_string( $mysqli ,$_POST['CEP-Empresa']);
	$Telefone_Empresa 	= mysqli_real_escape_string( $mysqli ,$_POST['Telefone-Empresa']);
	$Ramal_Empresa		= mysqli_real_escape_string( $mysqli ,$_POST['Ramal-Empresa']);
	$Fax_Empresa		= mysqli_real_escape_string( $mysqli ,$_POST['Fax-Empresa']);
	$Email_Empresa 		= mysqli_real_escape_string( $mysqli ,$_POST['Email-Empresa']);

	//<!-- Dados do Supervisor -->

	$Nome_Supervisor 		= $prof['full_name'];
	$Telefone_Supervisor 	= mysqli_real_escape_string( $mysqli ,$_POST['Telefone-Supervisor']);
	$Ramal_Supervisor		= mysqli_real_escape_string( $mysqli ,$_POST['Ramal-Supervisor']);
	$Fax_Supervisor			= mysqli_real_escape_string( $mysqli ,$_POST['Fax-Supervisor']);
	$Email_Supervisor 		= mysqli_real_escape_string( $mysqli ,$_POST['Email-Supervisor']);
	$Codigo_Supervisor 		= mysqli_real_escape_string( $mysqli ,$_POST['Codigo-Supervisor']);

	$sql = mysqli_query($mysqli, "UPDATE plano_de_atividades SET
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
																	Email_Supervisor = '$Email_Supervisor',
																	Codigo_Supervisor = '$Codigo_Supervisor'
																	WHERE Numero='$Numero' AND User= '$User'"
																	)or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($mysqli));

$sql = mysqli_query($mysqli, "UPDATE plano_de_bool SET
																	Curso = 'FALSE', 
																	Modalidade = 'FALSE', 
																	Nome = 'FALSE',
																	Endereco = 'FALSE',
																	Telefone = 'FALSE',
																	Email = 'FALSE',
																	Nome_Empresa = 'FALSE',
																	Endereco_Empresa = 'FALSE',
																	Cidade_Empresa = 'FALSE',
																	Estado_Empresa = 'FALSE',
																	CEP_Empresa = 'FALSE',
																	Telefone_Empresa = 'FALSE',
																	Ramal_Empresa = 'FALSE',
																	Fax_Empresa = 'FALSE',
																	Email_Empresa = 'FALSE',
																	Nome_Supervisor = 'FALSE',
																	Telefone_Supervisor = 'FALSE',
																	Ramal_Supervisor = 'FALSE',
																	Fax_Supervisor = 'FALSE',
																	Email_Supervisor = 'FALSE'
																	WHERE Numero='FALSE'"
																	)or die("Alguma coisa correu mal durante o registo. MySQL erro: ".mysqli_error($mysqli));

							header("Location:meus-estagios.php"); /* Redirect browser */
							exit();

?>

	



</html>