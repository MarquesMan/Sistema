<?php
function ListaConversas($conexao){

	//Este switch define quais usuario serão selecionados para que o usuario possa enviar uma mensagem.
	switch ($_SESSION['auto']){
		//Caso estudante. Pode conversar com o presidente e com os supervisores dos estagios que ele participa
		case 'E':
			$string =
			"SELECT DISTINCT us.full_name, c.ID, us.id 
			FROM (
				SELECT e.id_supervisor as id, u.full_name as full_name
				FROM estagio e, usuarios u
				WHERE (e.id_aluno = '$_SESSION[id]' and u.id = e.id_supervisor)
				
				UNION

				SELECT u.id, u.full_name
				FROM usuarios u
				WHERE u.tipo = 'V'

				) as us
			LEFT JOIN conversas as c ON (us.id = c.ID_User1 and '$_SESSION[id]' = c.ID_User2)
									 or (us.id = c.ID_User2 and '$_SESSION[id]' = c.ID_User1)
			ORDER BY us.full_name";
			break;
		//Caso professor. Pode conversar com o presidente e com os alunos dos estagios que ele supervisiona
		case 'P':
			$string =
			"SELECT DISTINCT us.full_name, c.ID, us.id 
			FROM (
				SELECT e.id_aluno as id, u.full_name as full_name
				FROM estagio e, usuarios u
				WHERE (e.id_supervisor = '$_SESSION[id]' and u.id = e.id_aluno)

				UNION

				SELECT u.id, u.full_name
				FROM usuarios u
				WHERE u.tipo = 'V'
				
				) as us
			LEFT JOIN conversas as c ON (us.id = c.ID_User1 and '$_SESSION[id]' = c.ID_User2)
									 or (us.id = c.ID_User2 and '$_SESSION[id]' = c.ID_User1)
			ORDER BY us.full_name";
			break;
		//Caso presidente. Pode conversar com todos os usuarios do sistema
		case 'V':
			$string =
			"SELECT DISTINCT us.full_name, c.ID, us.id 
			FROM  usuarios us
			LEFT JOIN conversas as c ON (us.id = c.ID_User1 and '$_SESSION[id]' = c.ID_User2)
									 or (us.id = c.ID_User2 and '$_SESSION[id]' = c.ID_User1)
			WHERE us.tipo != 'V'
			ORDER BY us.full_name";
			break;

		default:
			phpAlert("Erro interno. Por favor recarregue a página");
			exit();
			break;
	}

	$Usuarios = mysqli_query($conexao, $string) or die(mysqli_error($conexao));
	$Conversas = array();

	while($row = mysqli_fetch_assoc($Usuarios))
		array_push($Conversas, $row);

	return $Conversas;
}

function Send_Message($mysqli, $ID_Conversa, $message, $Sender)
{
	date_default_timezone_set('America/Manaus');
	
	$time_stamp =mysqli_real_escape_string($mysqli, date('Y/m/d H:i:s', time()));

	$Scaped_message = mysqli_real_escape_string($mysqli, $message);
	$Sender = mysqli_real_escape_string($mysqli, $Sender);

	$string =
	"SELECT *
	FROM mensagens
	WHERE ID_Conversa = $ID_Conversa and Marca_De_Tempo = '$time_stamp'";

	$msgs = mysqli_query($mysqli, $string) or die(mysqli_error($mysqli));

	if(mysqli_num_rows($msgs) == 0)
	{
		$string=
		"INSERT INTO mensagens (
			ID_Conversa,
			Marca_De_Tempo,
			Conteudo,
			nome_remetente)
		VALUES (
			$ID_Conversa,
			'$time_stamp',
			'$Scaped_message',
			'$Sender')
		";
		mysqli_query($mysqli, $string) or die(mysqli_error($mysqli));

		$string=
		"UPDATE conversas
		SET TotalMensagens=TotalMensagens+1
		WHERE ID=$ID_Conversa
		";

		mysqli_query($mysqli, $string) or die(mysqli_error($mysqli));	
	}
}


?>