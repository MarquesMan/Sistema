<?php
include_once 'connect.php';
include_once 'functions.php';
 
$error_msg = "";
 
if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Limpa e valida os dados passados em 
    
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Email inválido
        $error_msg .= '<p class="error">O endereço de email digitado não é válido</p>';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // A senha com hash deve ter 128 caracteres.
        // Caso contrário, algo muito estranho está acontecendo
        $error_msg .= '<p class="error">Configuração de senha inválida.</p>';
    }
 
    // O nome de usuário e a validade da senha foram conferidas no lado cliente.
    // Não deve haver problemas nesse passo já que ninguém ganha 
    // violando essas regras.
    //
 
    $prep_stmt = "SELECT IdUsuario FROM Usuario WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // Um usuário com esse email já esixte
            $error_msg .= '<p class="error">Um usuário com este email já existe.</p>';
        }
    } else {
        $error_msg .= '<p class="error">Erro banco de dados. Contate o administrador</p>';
    }
 
    // LISTA DE TAREFAS: 
    // Precisamos bolar soluções para quando o usuário não tem 
    // direito a se registrar, verificando que tipo de usuário está tentando 
    // realizar a operação.
 
    if (empty($error_msg)) {
        // Crie um salt aleatório
        $random_salt = hash('sha512', uniqid(mt_rand(), TRUE));
 
        // Crie uma senha com salt 
        $password = hash('sha512', $password . $random_salt);

        $fullname =mysqli_real_escape_string($mysqli,$_POST['fullname']);
        $dataNasc =mysqli_real_escape_string($mysqli,$_POST['dataNasc']);
        $dataNasc = transformaDataBD($dataNasc);
        $rua =mysqli_real_escape_string($mysqli,$_POST['rua']);
        $cep =mysqli_real_escape_string($mysqli,$_POST['cep']);
        $bairro =mysqli_real_escape_string($mysqli,$_POST['bairro']);
        $cidade =mysqli_real_escape_string($mysqli,$_POST['cidade']);
        $uf =mysqli_real_escape_string($mysqli,$_POST['uf']);
        $fone1 =mysqli_real_escape_string($mysqli,$_POST['fone1']);
        $fone2 =mysqli_real_escape_string($mysqli,$_POST['fone2']);        
        $numero =mysqli_real_escape_string($mysqli,$_POST['numero']);        
 
        // Inserir o novo usuário no banco de dados 
        if ($insert_stmt = $mysqli->prepare("INSERT INTO Usuario (apelido, email, password, salt,nome,data_nasc,endereco,numero,bairro,cidade,uf,cep,fone1,fone2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
            $insert_stmt->bind_param('ssssssssssssss', $username, $email, $password, $random_salt,$fullname,$dataNasc,$rua,$numero,$bairro,$cidade,$uf,$cep,$fone1,$fone2);
            // Executar a tarefa pré-estabelecida.
            if (! $insert_stmt->execute()) {
                die();
                header('Location: ../error.php?err=Registration failure: INSERT');
            }
        }
        header('Location: ./register_success.php');
    }
}
