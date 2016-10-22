<html>
  <?php
    session_start(); // começa a session
    require "config.php";
    
    mysqli_set_charset($mysqli,"utf8");
    
    if(Check_Login_Status())
    {
      Update_Login_Status();
    }
    else
    {
      session_unset();
      echo "Sessão expirada. Por favor recarregue a página.";
      exit();
    }

  ?>
  <head>
    <meta charset = 'UTF-8'>
    <link href = "css/conversa.css" rel = "stylesheet" >
    <script type="text/javascript">function moveWin(){window.scroll(0,10000);}</script>
  </head>

  <body onLoad="moveWin();">
    <?php
      if(!isset($_GET['ID_Conversa']) )
      {
        echo "Ainda nenhuma mensagem com este usuário.";
        exit();
      }
      //caso a conversa com o usuario ainda nao exista
      if($_GET['ID_Conversa'] == -1)
        echo "Ainda nenhuma mensagem com este usuário.";
      //caso exista, imprima as mensagens
      else
      {
        $Id = mysqli_real_escape_string($mysqli, $_GET['ID_Conversa']);
        $i = 0;
        $string1 =
        "SELECT ID
        FROM conversas
        WHERE ID = $Id
        ";

        $Permit = mysqli_query($mysqli, $string1) or die(mysqli_error($mysqli));
        $row = mysqli_fetch_assoc($Permit);

        if(!isset($row['ID'])){
          echo "Você não tem permissão para ver esta conversa.";
          exit();
        }

        //Receba as mensagens do servidor
        $msgs = Recieve_msgs($mysqli, $_GET['ID_Conversa'], 0);
        
        //Para cada mensagem
        while($row = mysqli_fetch_assoc($msgs)){
          $i++;
          //imprima na posição correta
          if($row['nome_remetente'] == $_SESSION['nome_completo'])
          {
            ?>
            <div style="background-color: #E7EEFF;width=50%;" align="right">
              <?php echo "<span>".$row['Marca_De_Tempo']."</span><br>".$row['Conteudo'];?>
            </div>
            <?php echo "&nbsp";
          }
          else
          {
            ?>
            <div style="background-color: #E7EEFF;width=50%;" align="left">
              <?php echo "<span> ".$row['Marca_De_Tempo']."</span>:<br>&nbsp&nbsp&nbsp&nbsp".$row['Conteudo'];?>
            </div>
            <br><?php echo "&nbsp";
          }
        }
        if($i == 0)
          echo "Ainda nenhuma mensagem com este usuário.";
      }

    ?>
  </body>
</html>
