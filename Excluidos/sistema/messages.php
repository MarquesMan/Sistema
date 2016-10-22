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

	?>
	<head>
		<meta charset = 'UTF-8'>
		
		<title>Sistema de Estágios - UFMS - Mensagens</title>

		<link rel="shortcut icon" href="images/favicon.ico"/>			
		
		<link href = "css/bootstrap.css" rel = "stylesheet" >	
		<link href = "css/plano.css" rel = "stylesheet" >
		
		<script type="text/javascript" src="jquery.js"> </script>
	</head>
	<body>
		<center>
			<table class="form-p">
				<?php
				if(mysqli_connect_errno())
				{
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				if(!isset($_GET['ID']))//Essa verificação evita o bug #1
					Set_Barra_Superior($mysqli, $_SESSION["auto"], $_SESSION["id"]);
				

				$query = mysqli_query($mysqli, "SELECT Time_Stamp, From_id, Seen FROM `mensagens` WHERE To_id = ".$_SESSION["id"]." ORDER BY Time_Stamp LIMIT 10") or die(mysql_error());
				$numberOfMessages = mysqli_num_rows($query);
				if(!isset($_GET['ID']))
				{
					?>
					<form method="get" action="messages.php">
						<?php

						if($numberOfMessages==0)
							echo "<tr><td>Nenhuma Mensagem no Sistema.</td></tr>";
						else {
							$count = 1;
							while($row = mysqli_fetch_assoc($query))
							{
								if($row["Seen"] == 0)
								{
								?>
								<tr>
									<td>
										<button style="background-color:lightgreen" type="submit" name="ID" value="<?php echo $row['From_id']; ?>"  class="btn btn-default" ><?php echo $row['Time_Stamp'];?></button>
									</td>
								</tr>
								<?php 
								}
								else
								{
								?>
								<tr>
									<td>
										<button type="submit" name="ID" value="<?php echo $row['From_id']; ?>"  class="btn btn-default" ><?php echo $row['Time_Stamp'];?></button>
									</td>
								</tr>
								<?php
								}
								$count = $count + 1;
							}
						}
						?>
					</form>
					<?php
				}
				else
				{
					$query = Recieve_msgs($mysqli, $_SESSION["id"], 10, $_GET['ID']);
					$numberOfMessages = mysqli_num_rows($query);
					Set_Barra_Superior($mysqli, $_SESSION["auto"], $_SESSION["id"]);
					//Enquanto houverem linhas recebidas do banco de dados, imprima-as
					while($row = mysqli_fetch_assoc($query))
					{
						if($row['From_id'] == $_GET['ID'])
						{
						?>
							<tr>
								<td width="500px">
									<?php
										echo $row['Time_Stamp'].":"."</br>".$row['Mensagem'];
									?>
								</td>
							</tr>
							<?php
						}
					}
					?>
					<form method= "post" name="MsgField" action="Send_Text_Msg.php">
						<tr>
							<td><input id="MessageTextAre" type="text" name="MessageTextArea" class="form-control"></td>
							<button id="Send_msg "type="submit" name="Button" value="Responder"  class="btn btn-default"</button>
							<td><input type="hidden" name="ToID" value=<?php$_GET['ID']?></td>
						</tr>
					</form>
					<?php
				}
				?>
			</table>
		</center>
	</body>
</html>
