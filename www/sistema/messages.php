<?php
require_once("cabecalho.php");
require_once("conecta.php");
require_once("../../Action/banco-messages.php");
?>

	<link href = "css/messages.css" rel = "stylesheet" >
	<script src="js/messages.js"></script>

	<?php
	$Usuarios = ListaConversas($mysqli);
	?>

	<div class="principal">
		<div class="conversas">
			<section>
				<table style="margin-left:auto; margin-right:auto; width: 100%; height: 10%;" class="table-conversas"> 
					<?php
					$i = 0;
					foreach ($Usuarios as $row) {
						?>
						<!--Para cada outro usuário na lista-->

						<tr class="linha" style="cursor: hand; height: 38px;">
							<td hidden id ="<?php echo 'Conversa_num_'.$i;?>" value="<?php echo ($row['ID'] != "")?$row['ID']:-1?>"></td>
							<td value="<?php echo $row['full_name'];?>"><?php echo $row['full_name'];?></td>
							<td hidden value="<?php echo $row['id'];?>"></td>
						</tr>
						<?php
						$i++;
					}
					?>
				</table>
			</section>
		</div>

		<div class="mensagens" width="600px"></div>

		<div class="enviar">
			<!--Area de entrada de texto-->
			<textarea unselectable disabled="disabled" rows="4" name="MessageTextArea" id="MessageTextArea">Escolha o usuário destino...</textarea>
			<!--Botão-->
			<div name="SendButton" id="SendButton" disabled="disabled" onclick="Sendmsg()" class="btn btn-primary" >
				<span style="padding-top: 2px">Enviar</span>
				<img hidden src="./images/ajax-loader.gif"></img>
			</div>
		</div>
	</div>
<?php require_once("rodape.php");?>
