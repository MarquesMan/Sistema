<?php 

function ListaEstagiosPendentes($conexao){
	$condicao = "";
	$presidente = "";
	$id = mysqli_real_escape_string($conexao, $_SESSION["id"]);

	if($_SESSION["auto"] == "P"){
		$pessoa = "supervisor";
		$condicao = " `estagio`.`Id_Supervisor`= $id AND estagio.status='supervisor'";
	}
	elseif($_SESSION["auto"] == "V"){
		$pessoa = "presidente";
		$presidente = ",`usuarios` as presidente";
		$condicao = " `presidente`.`Id_Usuario`=$id AND `presidente`.`Id_Curso` = `aluno`.`Id_Curso` AND ( estagio.status='presidente' OR estagio.status='entrega' )";
	}
	else{
		return;
		die();
	}

	$estagios = array();

	$estagio_query = "SELECT `estagio`.*,
							 `estagio`.`Id_Estagio` AS id_estagio,
							 `aluno`.`Nome_Completo` AS nome_aluno,
							 `supervisor`.`Nome_Completo` AS nome_supervisor,
							 `empresa`.`Nome` AS nome_empresa
					  FROM ((estagio INNER JOIN (usuarios AS aluno) ON `estagio`.`Id_Aluno` = `aluno`.`Id_Usuario`)
					  		INNER JOIN (usuarios AS supervisor) ON `estagio`.`Id_Supervisor` = `supervisor`.`Id_Usuario`)
							INNER JOIN empresa ON `estagio`.`Id_Empresa` = `empresa`.`Id_Empresa`
							$presidente
					  WHERE".$condicao;

    $estagio = mysqli_query($conexao, $estagio_query);

    while($row = mysqli_fetch_assoc($estagio)){
        array_push($estagios, $row);
    }


    return $estagios;
}

function ListaPlanoDeAtividadesPendentes($conexao){
	$condicao = "";
	$presidente = "";
	$id = mysqli_real_escape_string($conexao, $_SESSION["id"]);

	if($_SESSION["auto"] == "P"){
		$pessoa = "supervisor";
		$condicao = " `estagio`.`Id_Supervisor`= $id AND";
	}
	elseif($_SESSION["auto"] == "V"){
		$pessoa = "presidente";
		$presidente = ",`usuarios` as presidente";
		$condicao = " `presidente`.`Id_Usuario`=$id AND `presidente`.`Id_Curso` = `usuarios`.`Id_Curso` AND ";
	}
	else{
		return;
		die();
	}

	$planos = array();

	$plano_query = "SELECT  `usuarios`.*,
							`plano_de_atividades`.*,
							`plano_de_atividades`.`Id_Plano_De_Atividades` as `id_planoatividades`
					FROM ((plano_de_atividades INNER JOIN usuarios ON `plano_de_atividades`.`Id_Aluno` = `usuarios`.`Id_Usuario`) 
						  INNER JOIN  `estagio` ON `plano_de_atividades`.`Id_Estagio`=`estagio`.`Id_Estagio`)
						  $presidente
					WHERE".$condicao."`plano_de_atividades`.`Status`='".$pessoa."'";

	$plano = mysqli_query($conexao, $plano_query) or die(mysqli_error($conexao));

	while($row = mysqli_fetch_assoc($plano)){
		array_push($planos, $row);
	}

	return $planos;
}

function ListaRelatoriosPendentes($conexao){
	$condicao = "";
	$presidente = "";
	$id = mysqli_real_escape_string($conexao, $_SESSION["id"]);

	if($_SESSION["auto"] == "P"){
		$pessoa = "supervisor";
		$condicao = " `estagio`.`Id_Supervisor`= $id AND";
	}
	elseif($_SESSION["auto"] == "V"){
		$pessoa = "presidente";
		$presidente = ",`usuarios` as presidente";
		$condicao = " `presidente`.`Id_Usuario`=$id AND `presidente`.`Id_Curso` = `usuarios`.`Id_Curso` AND ";
	}
	else{
		return;
		die();
	}	
	
	$relatorios = array();

	$relatorio_query = "SELECT `usuarios`.*,
							   `relatorio`.*,
							   `relatorio`.`Id_Relatorio` as `id_relatorio`
						FROM (relatorio INNER JOIN usuarios ON `relatorio`.`Id_Aluno` = `usuarios`.`Id_Usuario`) 
							  INNER JOIN  `estagio` ON `relatorio`.`Id_Estagio`=`estagio`.`Id_Estagio`
							  $presidente
						WHERE".$condicao." (`relatorio`.`Status`='".$pessoa."' OR `relatorio`.`Status`='entrega' )";

	$relatorio = mysqli_query($conexao, $relatorio_query);

	while($row = mysqli_fetch_assoc($relatorio)){
		array_push($relatorios, $row);
	}

	return $relatorios;
}

function ListaTermosDeCompromissoPendentes($conexao){
	$id = mysqli_real_escape_string($conexao, $_SESSION["id"]);
	$curso = mysqli_real_escape_string($conexao, $_SESSION["curso"]);

	if($_SESSION["auto"] == "P"){
		$query = "SELECT Id_Estagio, Nome_Termo, Status_Termo, usuarios.*
				  FROM (termo_de_compromisso  NATURAL JOIN estagio)
				  	    INNER JOIN usuarios ON estagio.Id_Aluno = Id_Usuario 
				  WHERE Id_Supervisor = $id AND Status_Termo = 'supervisor'";
	}

	elseif($_SESSION["auto"] == "V"){
		$curso = mysqli_real_escape_string($conexao, $_SESSION["curso"]);

		$query = "SELECT Id_Estagio, Nome_Termo, Status_Termo, usuarios.*
				  FROM (estagio INNER JOIN usuarios ON estagio.Id_Aluno = usuarios.Id_Usuario)
				  	   NATURAL JOIN termo_de_compromisso
				  WHERE Id_Curso = $curso AND Status_Termo = 'presidente' ";				
	}

	else{
		$_SESSION["Failed"] = "Autorização negada para acessar a página.";
		return false;
		exit();
	}

	$result = mysqli_query($conexao, $query) or die($query);

	$lista_termo = array();

	while($row = mysqli_fetch_assoc($result)){
		array_push($lista_termo, $row);
	}

	return $lista_termo;
}

function ListaDeclaracoesFinaisPendentes($conexao){
	$id = mysqli_real_escape_string($conexao, $_SESSION["id"]);
	$curso = mysqli_real_escape_string($conexao, $_SESSION["curso"]);

	if($_SESSION["auto"] == "P"){
		$query = "SELECT Id_Estagio, Nome_Declaracao, Id_Declaracao, Status_Declaracao, usuarios.*
				  FROM (declaracao_final  NATURAL JOIN estagio)
				  	    INNER JOIN usuarios ON estagio.Id_Aluno = Id_Usuario 
				  WHERE Id_Supervisor = $id AND Status_Declaracao = 'supervisor'";
	}

	elseif($_SESSION["auto"] == "V"){
		$curso = mysqli_real_escape_string($conexao, $_SESSION["curso"]);

		$query = "SELECT Id_Estagio, Id_Declaracao ,Nome_Declaracao, Status_Declaracao, usuarios.*
				  FROM (estagio INNER JOIN usuarios ON estagio.Id_Aluno = usuarios.Id_Usuario)
				  	   NATURAL JOIN declaracao_final
				  WHERE Id_Curso = $curso AND ( Status_Declaracao = 'presidente' OR Status_Declaracao = 'entrega' )";
	}

	else{
		$_SESSION["Failed"] = "Autorização negada para acessar a página.";
		return false;
		exit();
	}

	$result = mysqli_query($conexao, $query) or die();

	$lista_declaracao = array();
	while($row = mysqli_fetch_assoc($result)){
		array_push($lista_declaracao, $row);
	}
	
	return $lista_declaracao;
}

function ListaAlunosPendentes($conexao){
	$alunos = array();

	$aluno_query = "SELECT * FROM usuarios WHERE Ativa='0' AND Ativa_Email='1' AND Tipo='E'";
	$aluno = mysqli_query($conexao, $aluno_query);

	while($row = mysqli_fetch_assoc($aluno)){
		array_push($alunos, $row);
	}

	return $alunos;
}

function ListaSupervisoresPendentes($conexao){
	$supervisores = array();
	
	$supervisor_query = "SELECT * FROM usuarios WHERE Ativa='0' AND Ativa_Email='1' AND Tipo='P'";
	$supervisor = mysqli_query($conexao, $supervisor_query);

	while($row = mysqli_fetch_assoc($supervisor)){
		array_push($supervisores, $row);
	}

	return $supervisores;
}

function ListaEmpresasPendentes($conexao){
	$empresas = array();

	$empresa_query = "SELECT * FROM empresa WHERE Ativa='0' AND Ativa_Email='1'";
	$empresa = mysqli_query($conexao, $empresa_query);

	while($row = mysqli_fetch_assoc($empresa)){
		array_push($empresas, $row);
	}

	return $empresas; 
}

?>