<?php

include_once 'connect.php';
include_once 'email.php';
include_once 'PasswordHash.php';
 
$error_msg = "";

 
if (isset($_POST['email']) ) {
    // Limpa e valida os dados passados em 
    
   
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Email inválido
        $error_msg .= '<p class="error">O endereço de email digitado não é válido</p>';
    }

 
    $prep_stmt = "SELECT IdUsuario,apelido FROM Usuario WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
    if ($stmt) {

        $stmt->bind_param('s', $email);
        $stmt->execute();

        $stmt->bind_result($IdUsuario, $username);
        $stmt->fetch();

        $stmt->store_result();
        $stmt->close();

        if ($IdUsuario===null||$username===null) {
            // Um usuário com esse email já esixte
            $error_msg .= '<p class="error">Não existe um usuário com este email.</p>';
        }
    } else {
        $error_msg .= '<p class="error">Erro banco de dados. Contate o administrador</p>';
    }
 
    if (empty($error_msg)) {

        $tempPassword = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 8)), 0, 8);             
       
        $random_salt = hash('sha512', uniqid(mt_rand(), TRUE));
 
        $antTempPassword = $tempPassword;



        // Crie uma senha com salt 
        $tempPassword = hash('sha512', $tempPassword);

        $tempPassword = hash('sha512', $tempPassword . $random_salt);
        //passo2.2 Atualize a senha no banco de dados 
        

        $query = "UPDATE Usuario SET password='".$tempPassword."',salt='".$random_salt."'  WHERE IdUsuario='".$IdUsuario."'";

        $result = mysqli_query($mysqli, $query) or mysqli_error($mysqli);

        //passo2.3: Envie o e-mail com a nova senha
        $mensagem = '

        <p>E-mail de recuperação de senha. Seguem seus dados atualizados:</p>
        <p>------------------------</p>
        <p>Nome de usuário: "'.$username.'"</p>
        <p>Senha temporária: "'.$antTempPassword.'"</p>
        <p>'.$tempPassword.'</p>
        <br>
        <p>'.$random_salt.'</p>
        <p>------------------------</p>
        <p>http://www.campeonet.com.br</p>
        
        ';

        $assunto = "Recuperação de senha CampeoNET";

        $resultado = enviaEmail($email, $assunto, $mensagem);

        if($resultado)
            $error_msg = true;
        else
            $error_msg = '<p class="error">Email não pôde ser enviado, favor contatar administrador.</p>';
        

    }
}
