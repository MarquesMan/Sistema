<html>	
	<?php
		session_start(); // começa a session
		require_once("conecta.php");

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
		
		<title>Sistema de Estágios - UFMS - Meus Estágios</title>

		<link rel="shortcut icon" href="images/favicon.ico"/>			
		
		<link href = "css/bootstrap.css" rel = "stylesheet" >	
		<link href = "css/plano.css" rel = "stylesheet" >
		
		<script type="text/javascript" src="jquery.js"> </script>
	</head>
	<body>
		<center>
			<!--Menu superior da tela-->
			<?php
			Set_Barra_Superior($mysqli, $_SESSION["auto"], $_SESSION["id"]);
			?>
			<!--Menu superior da tela-->
		
			<table class="form-p">
				<?php 

				$con=mysqli_connect("localhost","root","","sistema");
				// Check connection
				if (mysqli_connect_errno())
				{
				  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}

				$query = mysqli_query($con,"SELECT * FROM plano_de_atividades WHERE User='".$_POST["Aluno"]."'") or die(mysql_error());

				$numberOfEstagios = mysqli_num_rows($query);
				?>
				<form method="POST" action="plano-de-atividades-supervisor.php">
					<input type="hidden" name="Aluno" class="form-control" value="<?php echo $_POST["Aluno"]; ?>">
					<?php

					if($numberOfEstagios==0)
					{
						echo "<tr><td>Nenhum Estágio Encontrado</td></tr>";
					}

					$count = 1;

					while($row = mysqli_fetch_assoc($query))
					{
						?>
						<tr> <td><button type="submit" name="numbAdd" value="<?php echo $count; ?>"  class="btn btn-default" >Estágio em <?php echo $row['Nome_Empresa']; ?> </button></td></tr>
						<?php 
						$count = $count + 1;
					}
					?>

				</form>
				<tr style="height:10px;"></tr>
			</table>
		</center>
	</body>
</html>