<html>
	
	<?php

		session_start(); // começa a session
		require "config.php";

		if(Check_Login_Status())
		{
			Update_Login_Status();
		}
		else
		{
			session_unset();
			phpAlert_Redirect("ACESSO NEGADO", "index.php");
			exit();
		}

		Send_Message($mysqli, $_SESSION["id"], $_POST["toId"], $_POST["MessageTextArea"]);
		phpAlert_Redirect("messages.php", NULL);
		exit();
	?>
</html>