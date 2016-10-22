<?php

require_once("../conecta.php");
require_once("../../../Action/funcoes-de-controle.php");
require_once("../../../Action/banco-email.php");

$query = "DELETE FROM usuarios WHERE Ativa_Email=0 AND Data_de_Ingresso<=CURRENT_DATE - INTERVAL 7 DAY ";

$delete = mysqli_query($mysqli, $query) or die( mysqli_error($mysqli) );

$query = "	SELECT * FROM 
			usuarios as U inner join estagio as E on U.Id_Usuario=E.Id_Aluno   
			WHERE E.Data_Fim = CURRENT_DATE + INTERVAL 30 DAY";