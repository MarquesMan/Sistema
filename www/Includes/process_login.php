<?php
include_once 'connect.php';
include_once 'functions.php';

$statusSessao = session_status();
if($statusSessao == PHP_SESSION_NONE){
    //Nao ha sessao ativa
    sec_session_start(); // Funcao de segurança personalizada para iniciar uma sessão php.
}else if($statusSessao == PHP_SESSION_DISABLED){
    //Sessions are not available
}else if($statusSessao == PHP_SESSION_ACTIVE){
    //Destroy current and start new one
    //session_destroy();
    //sec_session_start(); // Funcao de segurança personalizada para iniciar uma sessão php.
}
  
if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // The hashed password.
    
    $status = login($email, $password, $mysqli);

    if ($status == 0) {
        // Login com sucesso 
        header('Location:index.php');
    }
}

?>