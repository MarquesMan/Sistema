<html>	
	<?php
		session_start(); // começa a session
		require "config.php"; // Pega funcoes de cabecalho e configura bd

		if(Check_Login_Status()) // Verifica se usuario esta logado ou seu tempo acabou
		{
			Update_Login_Status();
		}
		else // Do contrario, encerra 
		{
			session_unset();
			phpAlert_Redirect("ACESSO NEGADO", "index.php");
			exit();
		}
	?>
	<head>
		
		<meta charset = 'UTF-8'>	
		<link rel="shortcut icon" href="images/favicon.ico"/>		
		<title>Sistema de Estágios - UFMS - Cadastrar novo Estágio</title>
		<link href = "css/bootstrap.css" rel = "stylesheet" >
		<link href = "css/plano.css" rel = "stylesheet" >
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.maskedinput.js"></script>
		<script src="js/new.js"></script>

	</head>

	<body style="padding-top: 70px;">
		<!-- Dados do Usuario -->
		<?php
		Set_Barra_Superior($mysqli, $_SESSION["auto"], $_SESSION["id"]); // Usa a funcao definida em config.php 
		$_SESSION['Num_Estagios'] = $_POST['numbAdd'];
		$_SESSION['Num_Estagios'] = $_SESSION['Num_Estagios'] + 1;
		

		 // Crias a lista de Areas do estagio( usado temporariamente)
		$areas = array(1 => "Administração de Informática", 2 => "Análise e Desenvolvimento de Sistemas",3=> "Banco de Dados",4=> "Computação Gráfica",
		5=> "Desenvolvimento de Modelos Computacionais",6=> "Engenharia de Software",7=>"Hardware" ,8=> "Redes de Computadores",9=> "Suporte a Infraestrutura de Informática",
		 10=>"Suporte ao Usuário Final no Uso de Software",11=> "Organização, Sistemas e Métodos",12=> "Outras áreas aprovadas pela COE/CC/Facom" );

		?>

 	<div class="row">	
		<form action="save.php" method="POST" >

			
			<div class="col-xs-12 col-md-4"  style="margin-top:10px">
				<center><b>Modalidade</b><br></center>
				<input type="radio" name="Modalidade" style="margin-left: 40px;" value="1"> Obrigatório
				<input type="radio" name="Modalidade" value="0" checked >Não Obrigatório<br>
				<center><b>Supervisor</b></center><br>
				<?php
					$prof = mysqli_query($mysqli,"SELECT * FROM usuarios WHERE Tipo = 'P'") or die(mysql_error()); ?>
						<center><select name="Codigo_Supervisor" class="form-control" style="width:80%" ></center>
							<?php while($row = mysqli_fetch_assoc($prof))
							{
								?>
								<option value=<?php echo $row['Id_Usuario'];?>><?php echo $row['Nome_Completo'];?></option>
								<?php 
							}
							?>
						</select><br>
				<center><b>Empresa</b></center><br>

				<?php
					$empresa = mysqli_query($mysqli,"SELECT * FROM empresa WHERE Ativa='1'" ) or die(mysql_error()); ?>

						<center><select name="Codigo_Empresa" class="form-control" style="width:80%" >
							<?php while($rowEmpresa = mysqli_fetch_assoc($empresa))
							{
								?>
								<option value=<?php echo $rowEmpresa['Id_Empresa'];?>><?php echo $rowEmpresa['Nome'];?></option>
								<?php 
							}
							?>
						</select></center>
			</div>

			<div class="col-xs-12 col-md-4"  style="margin-top:10px">
				<b>Área</b>
				<center><select name="Codigo_Area" class="form-control" style="width:80%" >
							<?php
							$contadorArea = 1;
							 while($contadorArea<=12)
							{
								?>
									<option value=<?php echo "\"".$areas[$contadorArea]."\"";?>> <?php echo $areas[$contadorArea];?> </option>
								<?php 
								$contadorArea = $contadorArea + 1;
							}
							?>
				</select></center><br>
				<center><b>Data Ínicio</b></center><br>
				<center><input type="text" name="dataInicial" id="dataInicial" style="line-height:1; padding:0;" /></center><br>
				<center><b>Data Final</b></center><br>	
				<center><input type="text" name="dataFinal" id="dataFinal" style="line-height:1; padding:0;" /></center>

			</div>

			<button id="Save" class="btn btn-success">Salvar</button>

			</form>
		</div>
	</body>
</html>