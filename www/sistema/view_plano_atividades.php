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
		<link rel="shortcut icon" href="images/favicon.ico"/>		
		<title>Sistema de Estágios - UFMS - Plano de Ativadades</title>
		<link href = "css/bootstrap.css" rel = "stylesheet" >
		<link href = "css/plano.css" rel = "stylesheet" >
	</head>

	<body>
		<?php
		Set_Barra_Superior($mysqli, $_SESSION["auto"], $_SESSION["id"]);
		
		$Numero 	= $_POST['numbAdd'];
		$User 		= $_SESSION["sessioname"];
		$query = mysqli_query($mysqli,"SELECT * FROM plano_de_atividades WHERE Numero='".$Numero."' AND User='".$User."'") or die(mysql_error());
		$row = mysqli_fetch_assoc($query);

		?>
		<table class="form-p">
			<form method = "post" action="save_change.php" >
				<thead class="nav nav-bar">
					<th colspan="2">
						<font size="4" style="margin: 20px;" >Plano de Atividades Do Estagiário</font>   
					</th>

					<?php $moda = $row['Modalidade']; ?>
				</thead>

				<tr>
					<td>Curso:</td>
					<td><input type="text" name="Curso"class="form-control" value="<?php echo $row['Curso']; ?>" ></td>
				</tr>
				
				<?php
				if($moda=='0')
				{
					?>
					<tr>
						<td>Modalidade:<input type="radio" name="Modalidade" value="1"> Obrigatório</td>
						<td><input type="radio" name="Modalidade" value="0" checked>Não Obrigatório</td>
					</tr>
					<?php
				}
				else
				{
					?>
					<tr>
						<td>Modalidade:<input type="radio" name="Modalidade" value="1" checked> Obrigatório</td>
						<td><input type="radio" name="Modalidade" value="0" >Não Obrigatório</td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td>Nome:</td>
					<td><input type="text" name="Nome"class="form-control" value="<?php echo $row['Nome']; ?>"></td>
				</tr>

				<tr>
					<td>Endereço:</td>
					<td><input type="text" name="Endereco"class="form-control" value="<?php echo $row['Endereco']; ?>"></td>
				</tr>

				<tr>
					<td>Telefone:</td>
					<td><input type="text" name="Telefone"class="form-control" value="<?php echo $row['Telefone']; ?>"></td>
				</tr>

				<tr>
					<td>E-mail:</td>
					<td><input type="text" name="Email"class="form-control" value="<?php echo $row['Email']; ?>"></td>
				</tr>

				<!-- Dados da  Empresa -->
				<tr>
					<td>Nome da Empresa:</td>
					<td><input type="text" name="Nome-Empresa"class="form-control" value="<?php echo $row['Nome_Empresa']; ?>"></td>
				</tr>
				<tr>
					<td>Endereço da Empresa:</td>
					<td><input type="text" name="Endereco-Empresa"class="form-control" value="<?php echo $row['Endereco_Empresa']; ?>"></td>
				</tr>
				<tr>
					<td>Cidade:</td>
					<td><input type="text" name="Cidade-Empresa"class="form-control" value="<?php echo $row['Cidade_Empresa']; ?>"></td>
				</tr>

				<tr>
					<td>Estado:</td>
					<td><input type="text" name="Estado-Empresa"class="form-control" value="<?php echo $row['Estado_Empresa']; ?>"></td>
				</tr>

				<tr>
					<td>CEP:</td>
					<td><input type="text" name="CEP-Empresa"class="form-control" value="<?php echo $row['CEP_Empresa']; ?>"></td>
				</tr>						

				<tr>
					<td>Telefone da Empresa:</td>
					<td><input type="text" name="Telefone-Empresa"class="form-control" value="<?php echo $row['Telefone_Empresa']; ?>"></td>
				</tr>

				<tr>
					<td>Ramal da Empresa:</td>
					<td><input type="text" name="Ramal-Empresa"class="form-control" value="<?php echo $row['Ramal_Empresa']; ?>"></td>
				</tr>

				<tr>
					<td>Fax da Empresa:</td>
					<td><input type="text" name="Fax-Empresa" class="form-control" value="<?php echo $row['Fax_Empresa']; ?>"></td>
				</tr>

				<tr>
					<td>E-mail:</td>
					<td><input type="text" name="Email-Empresa"class="form-control" value="<?php echo $row['Email_Empresa']; ?>"></td>
				</tr>

				<!-- Dados do Supervisor -->
				<tr>
					<td>Nome do Supervisor:</td>
					<td>
						<?php
						$prof = mysqli_query($mysqli,"SELECT * FROM usuarios WHERE Tipo = 'P'") or die(mysql_error());
						?>
						<select name="Codigo-Supervisor" class="form-control">
							<?php while($rowp = mysqli_fetch_assoc($prof))
							{
								?>
								<option value="<?php echo $rowp['id'];?>"
									<?php
									if(!strcmp($rowp['full_name'], $row['Nome_Supervisor']))
									{
										echo "selected=\"selected\"";
									}
									
									?>
									>
									<?php
									echo $rowp['full_name'];
									?>
								</option>
								<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Telefone do Supervisor:</td>
					<td><input type="text" name="Telefone-Supervisor"class="form-control" value="<?php echo $row['Telefone_Supervisor']; ?>"></td>
				</tr>

				<tr>
					<td>Ramal do Supervisor:</td>
					<td><input type="text" name="Ramal-Supervisor"class="form-control" value="<?php echo $row['Ramal_Supervisor']; ?>"></td>
				</tr>

				<tr>
					<td>Fax do Supervisor:</td>
					<td><input type="text" name="Fax-Supervisor" class="form-control" value="<?php echo $row['Fax_Supervisor']; ?>"></td>
				</tr>

				<tr>
					<td>Email do Supervisor:</td>
					<td><input type="text" name="Email-Supervisor"class="form-control" value="<?php echo $row['Email_Supervisor']; ?>"></td>
				</tr>

				<input type="hidden" name="numbAdd" class="form-control" value="<?php echo $Numero; ?>">

				<tr>
					<td></td>
					<td><input type="submit" value="Salvar" class="btn btn-success" style="align:center;"  ></td>
				</tr>

			</form>

			<tr>
				<td>
					<form action="export.php" method="POST">
						<button type="submit" name="numbAdd" value="<?php echo $Numero; ?>"  class="btn btn-default" > Imprimir </button>
					</form>
				</td>
			</tr>
			<!--<tr><td></td><td><a href="export.php"><button style="float:right;" class="btn">Imprimir</button></a></td></tr>-->
		</table>
	</body>
</html>