<?php
require 'conecta.php';

if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
{
    //empresa
    if(isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] == 'Empresa')
    {
        $email = mysqli_real_escape_string($mysqli, $_GET['email']);    // Set email variable
        $hash = mysqli_real_escape_string($mysqli, $_GET['hash']);      // Set hash variable

        $search = mysqli_query($mysqli, "SELECT * FROM empresa WHERE email='".$email."' AND hash='".$hash."'") or die(mysql_error());

        $match  = mysqli_num_rows($search);
        //Encontrou o 
        if($match > 0)
        {
            $row = mysqli_fetch_assoc($search);
            if($row['Ativa_Email'] == '0')
            {
                mysqli_query($mysqli, "UPDATE empresa SET Ativa_Email='1' WHERE email='".$email."' AND hash='".$hash."'") or die(mysql_error());
                $_SESSION["Success"] = "E-mail verificado com sucesso";
                header("Location: index.php");
                exit();
            }
            else
            {
                $_SESSION["Success"] = "E-mail já verificado.";
                header("Location: index.php");
                exit();
            }
        }
        else
        {
            $_SESSION["Failed"] = "Erro interno.";
            header("Location: index.php");
            exit();
        }
    }
    //supervisor ou estudante
    else
    {

        $email = mysqli_real_escape_string($mysqli, $_GET['email']);    // Set email variable
        $hash = mysqli_real_escape_string($mysqli, $_GET['hash']);      // Set hash variable
        
        $search = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE Email='".$email."' AND Hash_Email='".$hash."'") or die(mysql_error()); 
        $match  = mysqli_num_rows($search);


        if($match > 0)
        {

            $row = mysqli_fetch_assoc($search);
            if($row['Ativa_Email'] == '0')
            {
                mysqli_query($mysqli, "UPDATE usuarios SET Ativa_Email='1' WHERE Email='".$email."' AND Hash_Email='".$hash."'") or die(mysqli_error($mysqli));
                $_SESSION["Success"] = "E-mail verificado com sucesso";
                header("Location: index.php");
                exit();
            }
            else
            {
                $_SESSION["Success"] = "E-mail já verificado.";
                header("Location: index.php");
                exit();
            }
        }
        else
        {
            $_SESSION["Failed"] = "Erro interno.";
            header("Location: index.php");
            exit();
        }
    }

}

else
{

    header("Location: index.php");
    exit();
}
?> 
