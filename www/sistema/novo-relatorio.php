<?php
	session_start(); // começa a session
	require_once("conecta.php");

	?>

	<script src="js/jquery.maskedinput.js"></script>
	<link rel="stylesheet" type="text/css" href="css/relatorio.css">
	<link rel="stylesheet" type="text/css" href="css/popover-erro.css">		

	<?php
	if(isset($_GET['idEstagio'])){
		$idEstagio = $_GET['idEstagio'];
		$estagio = mysqli_query($mysqli,"SELECT * FROM estagio WHERE Id_Estagio='".$idEstagio."' AND Id_Aluno='".$_SESSION["id"]."'") or die(mysql_error());
		$estagio = mysqli_fetch_assoc($estagio);	
	}

	if(!isset($_GET['idEstagio'])||empty($estagio)){ 
		erroPadrao('Parâmetros incorretos');		
	}			

	?>

	<form method="post" action="Controllers/Controller-novo-relatorio.php">
			<div class="row">		

					<div class="col-xs-12 col-md-4"  style="margin-top:10px">
						<b>Atividades Desenvolvidas:</b>
						<textarea id="Atividade_Desenvolvidas_Aluno"    name='atividades' style="resize:none" rows="10" cols="58"></textarea>
						<p class="pull-right" id="contadorAtividades" style="padding-top:5px;padding-right:10px">480</p>
					</div>

					<div class="col-xs-12 col-md-4" style="margin-top:10px">
						<b>Comentários:</b>
						<textarea  name='comaluno' id="Comentario_Aluno" style="resize:none" rows="10" cols="58"  ></textarea>
						<p class="pull-right" id="contadorComentario" style="padding-top:5px;padding-right:10px">360</p>
					</div>					

					<input hidden name="idEstagio" value="<?php echo $idEstagio ?>">

					<div class="col-xs-12 col-md-3" align="center"  style="margin-top:10px;vertical-align:middle;" >
						<div id="datas">
							<b>Data Inicial</b><br>
							<input  type="text" id="data"   name="datainicial" style="width: 50%; text-align: center;"><br><br>
							<b>Data Final</b><br>
							<input type="text"  id="data1"   name="datafinal" style="width: 50%; text-align: center;"><br><br>						
						</div>
						<b>Relatório</b><br>
						<input type="radio"  checked  id="radio2" name="tiporelatorio" value="0" /><b>Parcial</b>
						<input type="radio" id="radio1" name="tiporelatorio" value="1" 	/><b>Final</b>
					</div>
					
				</div>

				<div class="row">		
					<div class="col-md-offset-4 col-xs-12 col-md-4" align="center" style="margin-top:15px;">
						<button id="Save"  name="relatorio"   class="btn btn-success" width="100%" style="margin-right:5px">Salvar</button>		
					</div>	
				</div>
			</form>