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
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/app.js"></script>
	</head>
	<body>
		<center>
			<?php
			Set_Barra_Superior($mysqli, $_SESSION["auto"], $_SESSION["id"]);

			$Numero	= $_POST['numbAdd'];
			$User 		= $_POST["Aluno"];
			$query = mysqli_query($mysqli,"SELECT * FROM plano_de_atividades WHERE Numero='".$Numero."' AND User='".$User."'") or die(mysql_error());
			$row = mysqli_fetch_assoc($query);
			mysqli_query($mysqli,'SET CHARACTER SET utf8');
			$bquery = mysqli_query($mysqli,"SELECT * FROM plano_de_bool WHERE Numero='".$Numero."' AND User='".$User."'") or die(mysql_error());
			$brow = mysqli_fetch_array($bquery,MYSQLI_ASSOC);
			?>
			<script>
				var ArrayofBool = <?php echo json_encode($brow)?>;
			</script>
				
			<table class="form-p">
				<thead class="nav nav-bar"> 
					<th colspan="2">
						<font size="4" style="margin: 20px;" >Plano de Atividades Do Estagiário</font>   
					</th>
					<?php
					$moda = $row['Modalidade'];
					?>
				</thead>
				<tr>
					<td>Curso:</td>
					<td><input  boolt="<?php echo $brow['Curso'];?>" type="button" name="Curso"  onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Curso']; ?>" ></td>
				</tr>
				<?php
				if($moda=='0')
				{
					?>
					<tr>
						<td>Modalidade:</td>
						<td><input boolt="<?php echo $brow['Modalidade'];?>" type="button" name="Modalidade"  onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="Obrigatório" ></td>
					</tr>
					<?php
				}
				else
				{
					?>
					<tr>
						<td>Modalidade:</td>
						<td><input boolt="<?php echo $brow['Modalidade'];?>" type="button" name="Modalidade"  onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="Não Obrigatório" ></td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td>Nome:</td>
					<td><input boolt="<?php echo $brow['Nome'];?>" type="button" name="Nome" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Nome']; ?>"></td>
				</tr>

				<tr>
					<td>Endereço:</td>
					<td><input boolt="<?php echo $brow['Endereco'];?>" type="button" name="Endereco" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Endereco']; ?>"></td>
				</tr>

				<tr>
					<td>Telefone:</td>
					<td><input boolt="<?php echo $brow['Telefone'];?>" type="button" name="Telefone" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Telefone']; ?>"></td>
				</tr>

				<tr>
					<td>E-mail:</td>
					<td><input boolt="<?php echo $brow['Email'];?>" type="button" name="Email" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Email']; ?>"></td>
				</tr>

				<!-- Dados da  Empresa -->
				<tr>
					<td>Nome da Empresa:</td>
					<td><input boolt="<?php echo $brow['Nome_Empresa'];?>" type="button" name="Nome_Empresa" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Nome_Empresa']; ?>"></td> 
				</tr>
				<tr>
					<td>Endereço da Empresa:</td>
					<td><input boolt="<?php echo $brow['Endereco_Empresa'];?>" type="button" name="Endereco_Empresa" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Endereco_Empresa']; ?>"></td>
				</tr>

				<tr>
					<td>Cidade:</td>
					<td><input boolt="<?php echo $brow['Cidade_Empresa'];?>" type="button" name="Cidade_Empresa" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Cidade_Empresa']; ?>"></td>
				</tr>

				<tr>
					<td>Estado:</td>
					<td><input boolt="<?php echo $brow['Estado_Empresa'];?>" type="button" name="Estado_Empresa" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Estado_Empresa']; ?>"></td>
				</tr>

				<tr>
					<td>CEP:</td>
					<td><input boolt="<?php echo $brow['CEP_Empresa'];?>" type="button" name="CEP_Empresa" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['CEP_Empresa']; ?>"></td>
				</tr>

				<tr>
					<td>Telefone da Empresa
					</td> <td><input boolt="<?php echo $brow['Telefone_Empresa'];?>" type="button" name="Telefone_Empresa" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Telefone_Empresa']; ?>"></td> 
				</tr>

				<tr>
					<td>Ramal da Empresa
					</td> <td><input boolt="<?php echo $brow['Ramal_Empresa'];?>" type="button" name="Ramal_Empresa" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Ramal_Empresa']; ?>"></td> 
				</tr>

				<tr>
					<td>Fax da Empresa
					</td> <td><input boolt="<?php echo $brow['Fax_Empresa'];?>" type="button" name="Fax_Empresa"  onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Fax_Empresa']; ?>"></td> 
				</tr>

				<tr>
					<td>E-mail:</td>
					<td><input boolt="<?php echo $brow['Email_Empresa'];?>" type="button" name="Email_Empresa" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Email_Empresa']; ?>"></td>
				</tr>

				<!-- Dados do Supervisor -->
				<tr> 
					<td>Nome do Supervisor:</td>
					<td><input boolt="<?php echo $brow['Nome_Supervisor'];?>" type="button" name="Nome_Supervisor" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Nome_Supervisor']; ?>"></td> 
				</tr>
				
				<tr>
					<td>Telefone do Supervisor:</td> 
					<td><input boolt="<?php echo $brow['Telefone_Supervisor'];?>" type="button" name="Telefone_Supervisor" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Telefone_Supervisor']; ?>"></td>
				</tr>

				<tr>
					<td>Ramal do Supervisor:</td>
					<td><input boolt="<?php echo $brow['Ramal_Supervisor'];?>" type="button" name="Ramal_Supervisor" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Ramal_Supervisor']; ?>"></td>
				</tr>
				
				<tr>
					<td>Fax do Supervisor:</td>
					<td><input boolt="<?php echo $brow['Fax_Supervisor'];?>" type="button" name="Fax_Supervisor"  onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Fax_Supervisor']; ?>"></td>
				</tr>
				
				<tr>
					<td>E-mail do Supervisor:</td>
					<td><input boolt="<?php echo $brow['Email_Supervisor'];?>" type="button" name="Email_Supervisor" onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $row['Email_Supervisor']; ?>"></td>
				</tr>

				<input type="hidden" name="numbAdd"  onClick="reply_click(ArrayofBool,this,this.name)" class="form-control" value="<?php echo $Numero; ?>">
				<tr>
					<td><center><input type="button" value="Aprovar" onClick="reprove(ArrayofBool)" class="btn btn-success" style="align:center;"  ></td> 
					<td>		<input type="button" value="Reprovar" onClick="reprove(ArrayofBool)" class="btn btn-warning" style="align:center;" ></td>
				</tr>
				<!--<tr><td></td><td><a href="export.php"><button style="float:right;" class="btn">Imprimir</button></a></td></tr>-->
			</table>
		</center>
	</body>
</html>