<script src="js/jquery.maskedinput.js"></script>
<script src="js/edita-estagio.js"></script>

<?php

require_once "conecta.php";
require_once("../../Action/banco-area.php");
require_once("../../Action/banco-termo-de-compromisso.php");
session_start();

if(isset($_POST['idEstagio'])){
	$idEstagio = $_POST['idEstagio'];
	$estagio = mysqli_query($mysqli,"SELECT * FROM estagio WHERE Id_Estagio='".$idEstagio."' AND Id_Aluno='".$_SESSION["id"]."'") or die(mysqli_error($mysqli));
	$estagio = mysqli_fetch_assoc($estagio);
	$errosInfoEstagio =  explode(";", $estagio["Erros"]);
}else{
	erroPadrao();
}

if(empty($estagio)){ 
	erroPadrao();
}

$query = mysqli_query($mysqli,"SELECT * FROM plano_de_atividades WHERE Id_Estagio='".$idEstagio."' AND Id_Aluno='".$_SESSION["id"]."'") or die(mysqli_error($mysqli));
$planoRow = mysqli_fetch_assoc($query);

if(empty($planoRow)){
	erroPadrao();
}


$horarios = $planoRow['Horario'];
$horarios = explode(";", $horarios);

$erros = explode(";", $planoRow['Erros']);

$pos = strpos($planoRow['Erros'], "1");

if($pos===false){
	$errosHorario = false;
	$comentarioRow = 	array('Comentario_Horarios' => "",
		"Comentario_Descricao" => "",
		"Comentario_Local" => "",
		"Comentario_Carga" => "",
		"Comentario_Data" => "");

}else{
	$errosHorario = substr( $planoRow['Erros'],6,23);
	//$errosHorario = strpos($errosHorario, "1"); 

	$errosHorario = (string)$errosHorario;

	$comentarioRow = mysqli_query($mysqli,"SELECT * FROM comentario_plano_de_atividades WHERE Id_Plano_De_Atividades ='".$planoRow["Id_Plano_De_Atividades"]."'") or die(mysqli_error($mysqli));			
	$comentarioRow = mysqli_fetch_assoc($comentarioRow);

}

	$data_inicial_formatada =  date_create($estagio["Data_Inicio"]);
	$data_final_formatada = date_create($estagio["Data_Fim"]);
	$data_inicial_formatada = $data_inicial_formatada->format("d/m/Y");
	$data_final_formatada = $data_final_formatada->format("d/m/Y");

			// Comentarios das Info de Estagio

$pos = strpos($estagio["Erros"], "1");

if($pos===false){
	$comentarioInfoRow = 	array('Comentario_Empresa' => "",
		"Comentario_Supervisor" => "",
		"Comentario_Modalidade" => "",
		"Comentario_Area" => "",
		"Comentario_Data_Inicio" => "",
		"Comentario_Termo" => "",
		"Comentario_Data_Fim" => "");


}else{
	$comentarioInfoRow = mysqli_query($mysqli,"SELECT * FROM comentario_estagio WHERE Id_Estagio ='".$idEstagio."'") or die(mysqli_error($mysqli));			
	$comentarioInfoRow = mysqli_fetch_assoc($comentarioInfoRow);
}


	$Modalidade = $estagio['Modalidade']; // Modalidade do estagio

	$termo = ListaTermoDeCompromisso($mysqli, false, $idEstagio);
	$termo = $termo[0];

	$stringStatus = array(
		"alterar" => "Editável",
		"supervisor" => "Esperando aprovação do supervisor",
		"presidente" => "Esperando aprovação do Presidente da COE",
		"aprovado" => "Aprovado"
		);

		?>

		<form action="Controllers/Controller-edita-estagio.php" method="POST" enctype="multipart/form-data">  <!-- fomulario do novo estagio -->			       

			<input name="plano" hidden value='<?php echo $planoRow["Id_Plano_De_Atividades"]; ?>' type="hidden"> 
			<input name="idEstagio" hidden value='<?php echo $idEstagio; ?>' type="hidden"> 

			<div class="row" id="infoEstagio" ><!-- Informacoes do estagio -->	


				<div class="col-xs-11 col-md-11"  style="margin-top:10px"> 	

					<div class="col-xs-12 col-md-12" >
						<center><b>Informações do Estágio</b></center>
					</div>

					<div class="col-xs-12 col-md-6"  style="margin-top:10px"> <!-- Linha 1 -->
						<!-- Modalidade do estagio -->
						<center><b>Modalidade</b><?php echo $errosInfoEstagio[0]!=false?'<span id="0" class="glyphicon  glyphicon-comment" value="'.$comentarioInfoRow['Comentario_Modalidade'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?><br></center> 	
						<div>
							<?php
							if ($Modalidade){?>
							<input type="radio"  checked boolt="0"  id="radio2" name="Modalidade" style="margin-left: 40px;margin-right: 6px;" value="1" > Obrigatório
							<input type="radio"  boolt="<?php echo $errosInfoEstagio[0];?>" id="radio1" name="Modalidade" style="margin-left: 10px;margin-right: 6px;" value="0" >Não Obrigatório<br><br>
							<?php } 
							else{?>
							<input type="radio"  boolt="<?php echo $errosInfoEstagio[0];?>"  id="radio1" name="Modalidade" style="margin-left: 40px;margin-right: 6px;" value="1" > Obrigatório
							<input type="radio"  checked boolt="0" id="radio2" name="Modalidade" style="margin-left: 10px;margin-right: 6px;" value="0" >Não Obrigatório<br><br>
							<?php } 
							?>
						</div>
						<!-- modalidade do estagio -->	

						<!-- Supervisor do estagio -->
						<center><b>Supervisor</b> <?php echo $errosInfoEstagio[1]!=false?'<span id="0" class="glyphicon  glyphicon-comment" value="'.$comentarioInfoRow['Comentario_Supervisor'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?> </center>
						<?php

						$prof = mysqli_query($mysqli,"SELECT * FROM usuarios WHERE Tipo = 'P'") or die(mysql_error()); ?> <!-- Recupera lista de supervisores -->

						<center><select boolt="<?php echo $errosInfoEstagio[1];?>" name="Codigo_Supervisor" class="form-control" style="width:80%" ></center>
						<?php while($row = mysqli_fetch_assoc($prof))
						{
							?>
							<option <?php  echo ($estagio["Id_Supervisor"]==$row['Id_Usuario']) ? 'selected="selected"' : "";  ?> value=<?php echo $row['Id_Usuario'];?>><?php echo $row['Nome_Completo'];?></option>
							<?php 
						}
						?>
					</select><br>
					<!-- Supervisor do estagio -->

					<!-- Empresa do estagio -->
					<center><b>Empresa</b><?php echo $errosInfoEstagio[2]!=false?'<span id="0" class="glyphicon  glyphicon-comment" value="'.$comentarioInfoRow['Comentario_Empresa'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></center>
					<?php
					$empresa = mysqli_query($mysqli,"SELECT * FROM empresa WHERE Ativa='1'" ) or die(mysql_error()); ?> <!-- Empresa do estagio -->

					<center><select name="Codigo_Empresa" boolt="<?php echo $errosInfoEstagio[2];?>" class="form-control" style="width:80%" >
						<?php while($rowEmpresa = mysqli_fetch_assoc($empresa))
						{
							?>
							<option <?php  echo ($estagio["Id_Empresa"]==$rowEmpresa['Id_Empresa']) ? 'selected="selected"' : "";  ?> value=<?php echo $rowEmpresa['Id_Empresa'];?>><?php echo $rowEmpresa['Nome'];?></option>
							<?php 
						}
						?>
					</select></center>
					<!-- Empresa do estagio -->

				</div><!-- Linha 1 -->

				<div class="col-xs-12 col-md-6"  style="margin-top:10px"> <!-- Linha 2 -->
					<center><b>Área</b> <?php echo $errosInfoEstagio[3]!=false?'<span id="0" class="glyphicon  glyphicon-comment" value="'.$comentarioInfoRow['Comentario_Area'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?> <!-- Area -->
						<select name="Codigo_Area" boolt="<?php echo $errosInfoEstagio[3];?>" class="form-control" style="width:80%" >
							<?php

							$areas = getAreasIdENomes($mysqli);

							foreach($areas as $elementoArea)
							{	


								?>
								<option <?php  echo ($estagio["Area"]==$elementoArea['Id_Area']) ? 'selected="selected"' : "";  ?>  value=<?php echo "\"".$elementoArea['Id_Area']."\"";?>> <?php echo $elementoArea['Nome'];?> </option>
								<?php 
							}
							?>
						</select><br>
						<b>Data Ínicio</b> <?php echo $errosInfoEstagio[4]!=false?'<span id="0" class="glyphicon  glyphicon-comment" value="'.$comentarioInfoRow['Comentario_Data_Inicio'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?> <br>
						<input type="text" boolt="<?php echo $errosInfoEstagio[4];?>" name="dataInicial" value=<?php echo $data_inicial_formatada; ?> id="dataInicial" style="line-height:1; padding:0;width:70%;height:5%;text-align: center;" /><br>
						<b>Data Final</b> <?php echo $errosInfoEstagio[5]!=false?'<span id="0" class="glyphicon  glyphicon-comment" value="'.$comentarioInfoRow['Comentario_Data_Fim'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?> <br>	
						<input type="text" boolt="<?php echo $errosInfoEstagio[5];?>" name="dataFinal"  value=<?php  echo $data_final_formatada; ?> id="dataFinal" style="line-height:1; padding:0;width:70%;height:5%;text-align: center;" /></center>
					</div> <!-- Linha 2 -->
				</div>

				<div class="col-xs-1 col-md-1" >
					<span  class="glyphicon glyphicon-chevron-right " id="InfoBotaoDireita" style="vertical-align:middle" aria-hidden="true"></span>
				</div>

			</div><!-- Informacoes do estagio -->

<!--
=========================================================================
							Plano de atividades 						 
=========================================================================
-->



<div class="row" id="planoEstagio" hidden> 

	<input hidden name="erros"		id="erros" 		value="0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0"> <!-- input default dos erros, pode ser feito no bd -->
	<input hidden name="horarios" 	id="horarios" 	value=""> <!-- array de horarios -->
	<input hidden name="cargaTot"   id="cargaTot" 	value="0"> <!-- soma total de horas -->


	<div class="col-xs-1 col-md-1" >
		<span id="PlanoBotaoEsquerda"  class="glyphicon glyphicon-chevron-left " aria-hidden="true"></span>
	</div>

	<div class="col-xs-10 col-md-10" >
		<div class="col-xs-12 col-md-12" >
			<center><b>Plano de Atividades</b></center>
		</div>

		<div class=" col-xs-6 col-md-3" align="right"> <!-- Texto das linhas -->
			<b class="plano-titulo">Horário<?php echo $errosHorario!==false?'<span id="0" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Horarios'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b><br>
			<span class="plano-hora">Segunda-feira das</span><br>
			<span class="plano-hora">Terça-feira das</span><br>
			<span class="plano-hora">Quarta-feira das</span><br>
			<span class="plano-hora">Quinta-feira das</span><br>
			<span class="plano-hora">Sexta-feira das</span><br>
			<span class="plano-hora">Sábado das</span><br>
		</div> <!-- Texto das linhas -->

		<div class="col-xs-6 col-md-3">
			<br>
			<div linha="1" align="center">
				<input type="text" name="segunda1" id="segunda1" horario="1" value="<?php echo $horarios[0]; ?>"   boolt="<?php echo $erros[3];?>" class="plano-input"/>
				<span class="plano-hora" >às</span>  
				<input type="text" name="segunda2" id="segunda2"  horario="1" value="<?php echo $horarios[1]; ?>"  boolt="<?php echo $erros[4];?>" class="plano-input"/><br>
			</div>
			<div linha="1" align="center">
				<input type="text" name="terca1" id="terca1" horario="1" value="<?php echo $horarios[2]; ?>"  boolt="<?php echo $erros[6];?>"  class="plano-input"/>
				<span class="plano-hora" >às</span> 
				<input type="text" name="terca2" id="terca2" horario="1" value="<?php echo $horarios[3]; ?>"  boolt="<?php echo $erros[6];?>" class="plano-input"/><br>
			</div>
			<div linha="1" align="center">
				<input type="text" name="quarta1" id="quarta1" horario="1" value="<?php echo $horarios[4]; ?>"  boolt="<?php echo $erros[7];?>"  class="plano-input"/>
				<span class="plano-hora" >às</span> 
				<input type="text" name="quarta2" id="quarta2" horario="1" value="<?php echo $horarios[5]; ?>"  boolt="<?php echo $erros[8];?>" class="plano-input"/><br>
			</div>
			<div linha="1" align="center">
				<input type="text" name="quinta1" id="quinta1" horario="1" value="<?php echo $horarios[6]; ?>"  boolt="<?php echo $erros[9];?>" class="plano-input"/>
				<span class="plano-hora" >às</span> 
				<input type="text" name="quinta2" id="quinta2" horario="1" value="<?php echo $horarios[7]; ?>"  boolt="<?php echo $erros[10];?>" class="plano-input"/><br>		
			</div>
			<div linha="1" align="center">
				<input type="text" name="sexta1" id="sexta1" horario="1" value="<?php echo $horarios[8]; ?>"  boolt="<?php echo $erros[11];?>"  class="plano-input"/>
				<span class="plano-hora" >às</span> 
				<input type="text" name="sexta2" id="sexta2" horario="1" value="<?php echo $horarios[9]; ?>"  boolt="<?php echo $erros[12];?>" class="plano-input"/><br>
			</div>
			<div linha="1" align="center">
				<input type="text" name="sabado1" id="sabado1" horario="1" value="<?php echo $horarios[10]; ?>"  boolt="<?php echo $erros[13];?>"  class="plano-input"/>
				<span class="plano-hora" >às</span> 
				<input type="text" name="sabado2" id="sabado2"  horario="1" value="<?php echo $horarios[11]; ?>"  boolt="<?php echo $erros[14];?>" class="plano-input"/><br>
			</div>
		</div>


		<div class="col-xs-12 col-md-4">
			<b>Atividades a serem desenvoldidas<?php echo $erros[15]==1?'<span id="1" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Descricao'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b><br>
			<textarea rows="7" id="Atividades_Desenvolvidas" cols="71" maxlength="497"  style="resize:none"  class=" status-box"  name="descricao" boolt="<?php echo $erros[15];?>"> <?php echo $planoRow['Descricao']; ?> </textarea>
			<p class="counter pull-right" style="padding-top:5px;padding-right:10px">497</p>
		</div>

		<div class="col-xs-12 col-md-2">					 
			<center><b>Local<?php echo $erros[0]==1?'<span id="1" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Local'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b></center><input  boolt="<?php echo $erros[0];?>" type="text" class="plano-local" value="<?php echo $planoRow['Local']; ?>" id="local" name="local" > <br><br>
			<center><b>Carga horária<?php echo $erros[1]==1?'<span id="1" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Carga'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b></center><input type="text"  boolt="<?php echo $erros[1];?>" class="plano-local" id="carga" value="<?php echo $planoRow	['Carga_Horaria']; ?>" name="carga" ><br><br>
			<center><b>Data<?php echo $erros[2]==1?'<span id="1" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Data'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b></center><input type="text"  boolt="<?php echo $erros[2];?>" class="plano-local" id="data" value="<?php echo $planoRow['Data']; ?>" name="data" ><br><br>
		</div>
	</div>

	<div class="col-xs-1 col-md-1" >
		<span  class="glyphicon glyphicon-chevron-right " id="PlanoBotaoDireita" style="vertical-align:middle" aria-hidden="true"></span>
	</div>

</div><!-- Plano de atividades -->

<!--
=========================================================================
							Termo Estagio 						 
=========================================================================
-->

<div class="row" id="termoEstagio" hidden>
	<div class="col-xs-1 col-md-1" >
		<span id="TermoBotaoEsquerda"  class="glyphicon glyphicon-chevron-left " aria-hidden="true"></span>
	</div>

	<div class="col-xs-10 col-md-10" >


		<div class="col-xs-12 col-md-12" >
			<center><b>Termo de Compromisso</b><?php echo $errosInfoEstagio[6]!=false?'<span id="0" class="glyphicon  glyphicon-comment" value="'.$comentarioInfoRow['Comentario_Termo'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></center>
		</div>
		<div class="col-xs-12 col-md-12" >

			<table class="table doca">
				<thead>
					<tr>
						<td>Nome</td>
						<td>Status</td>
						<td>Documento</td>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td><?= $termo["Nome_Termo"]?></td>
						<td><?= $stringStatus[$termo["Status_Termo"]] ?></td>
						<td><a href=<?= "mostra-arquivo.php?idEstagio=".$idEstagio."&tipo-documento=termo" ?> target="_blank">Visualizar</a></td>
					</tr>
					
					<tr colspan="3"><td colspan="3">
						Alterar Arquivo:
						<div class="form-group"> 
							<?php echo ($termo["Status_Termo"] == "alterar")? '<input name="termo_arquivo" type="file" boolt="'.$errosInfoEstagio[6].'" required id="termo_arquivo">' : '<input name="termo_arquivo" type="file" boolt="'.$errosInfoEstagio[6].' type="file" id="termo_arquivo">'; ?>
						</div>													
					</td></tr>
				</tbody>
			</table>

		</div>
	</div>

</div>

<button id="SalvarEstagio" class="btn btn-success">Salvar</button>

</form>