<?php
	
function insereArea($conexao,$Nome){

	if($_SESSION["auto"] != "V"){
		$_SESSION["Failed"] = "Não tem permissão para realizar esta operação.";
		return;
	}

	$query = "INSERT INTO areas(Nome) VALUES ('".$Nome."')";
	$_SESSION["Success"] = "Cadastro de Área realizado com sucesso.";
	mysqli_query($conexao, $query)or die(mysqli_error($conexao));

}

function alteraArea($conexao,$idArea,$operacao,$nome){

	if($_SESSION["auto"] != "V"){
		$_SESSION["Failed"] = "Não tem permissão para realizar esta operação.";
		return;
	}
	if($operacao=="Salvar"){
		$query = "UPDATE areas SET Nome='".$nome."' WHERE Id_Area='$idArea'";
		$_SESSION["Success"] = "Atualização de Área realizado com sucesso.";

		mysqli_query($conexao, $query)or die(mysqli_error($conexao));
	}
	else{
		$query = "DELETE FROM areas WHERE Id_Area='$idArea'";
		$_SESSION["Success"] = "Área removida com sucesso.";
		mysqli_query($conexao, $query)or die(mysqli_error($conexao));
	}

}

function GetAreas($conexao){
	$area = array();

	$result = mysqli_query($conexao, "SELECT * FROM areas");

	while($row = mysqli_fetch_assoc($result)){
		$area[$row['Id_Area']]= $row['Nome'];
	}

	return $area;
} 

function getAreasIdENomes($conexao){
	$area = array();

	$result = mysqli_query($conexao, "SELECT * FROM areas");

	$row = mysqli_fetch_assoc($result); // retira a primeira 

	while($row = mysqli_fetch_assoc($result)){
		array_push($area, $row);
	}

	return $area;
}

function GetAreaById($conexao, $Id_Area){
	$Id_Area = mysqli_real_escape_string($conexao, $Id_Area);
	$area = array();

	$result = mysqli_query($conexao, "SELECT * FROM areas WHERE Id_Area = $Id_Area");

	while($row = mysqli_fetch_assoc($result)){
		array_push($area, $row);
	}
	return $area;
}

?>