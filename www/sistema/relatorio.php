<?php 	session_start(); 	
		require_once("conecta.php"); 
		?>
		<script src="js/jquery.maskedinput.js"></script>
		
		<link rel="stylesheet" type="text/css" href="css/relatorio.css">
	
		<?php
		
			if(isset($_POST['idEstagio'])){
				$idEstagio = $_POST['idEstagio'];
				$estagio = mysqli_query($mysqli,"SELECT * FROM estagio WHERE Id_Estagio='".$idEstagio."' AND Id_Aluno='".$_SESSION["id"]."'") or die(mysqli_error($mysqli));
				$estagio = mysqli_fetch_assoc($estagio);	
			}else{
				erroPadrao("Erro ao acessar estagio");
			}

			if(empty($estagio)|| !isset($_POST['relatorio']) ){ 
					erroPadrao("Parametros incorretos");
			}

			$relatorio = $_POST['relatorio'];
			$relarioRow = mysqli_query($mysqli,"SELECT * FROM relatorio WHERE Id_Estagio='".$idEstagio."' AND Id_Aluno='".$_SESSION["id"]."' AND Id_Relatorio='".$relatorio."'") or die(mysqli_error($mysqli));			
			$relarioRow = mysqli_fetch_assoc($relarioRow);

			if(empty($relarioRow)){
				erroPadrao("Erro ao abrir relatório");
			}
			$erros = explode(";", $relarioRow['Erros']);

			$pos = strpos($relarioRow['Erros'], "1");
			//if($relarioRow['Erros'][0]=='1')
			//	$pos = true;

			if($pos!==false){
				$comentarioRow = mysqli_query($mysqli,"SELECT * FROM comentario_relatorio WHERE Id_Relatorio='".$relatorio."'") or die(mysqli_error($mysqli));			
				$comentarioRow = mysqli_fetch_assoc($comentarioRow);
			}

			$dataInicio = DateTime::createFromFormat("Y-m-d" ,$relarioRow['Data_Inicio'])->format("d/m/Y");
			$dataFim =  DateTime::createFromFormat("Y-m-d" , $relarioRow['Data_Fim'])->format("d/m/Y");
		?>
		
		<form method="post" action="Controllers/Controller-mudar-relatorio.php">
			<div class="row">		

					<div class="col-xs-12 col-md-4"  style="margin-top:10px">
						<b>Atividades Desenvolvidas:<?php echo $erros[3]==1?'<span id="3" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Atividades'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b>
							<textarea id="Atividade_Desenvolvidas_Aluno"  boolt="<?php echo $erros[3];?>"  name='atividades' style="resize:none" rows="10" cols="58"><?php echo $relarioRow['Atividades'];?></textarea>
						<p class="pull-right" id="contadorAtividades" style="cursor:pointer;padding-top:5px;padding-right:10px">480</p>
					</div>

					<div class="col-xs-12 col-md-4" style="margin-top:10px">
						<b>Comentários:<?php echo $erros[4]==1?'<span id="4" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Comentario'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b>
							<textarea  name='comaluno' id="Comentario_Aluno" style="resize:none" rows="10" cols="58" boolt="<?php echo $erros[4];?>" ><?php echo $relarioRow['Comentario_Aluno'] ;?></textarea>
						<p class="pull-right" id="contadorComentario" style="padding-top:5px;padding-right:10px">360</p>
					</div>					

					<input hidden name="idEstagio" value="<?php echo $_POST["idEstagio"] ?>">
					<input hidden name="erros" id="erros" value="0;0;0;0;0">


					<div class="col-xs-12 col-md-3" align="center"  style="margin-top:10px;vertical-align:middle;" >
						<div id="datas">
							<b>Data Inicial<?php echo $erros[1]==1?'<span id="0" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Data_Inicial'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b><br>
							<input  type="text"  id="data"  boolt="<?php echo $erros[1];?>" value="<?php echo $dataInicio; ?>" name="datainicial" style="width: 50%; text-align: center;"><br><br>
							<b>Data Final<?php echo $erros[2]==1?'<span id="1" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Data_Final'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b><br>
							<input type="text"  id="data1"  boolt="<?php echo $erros[2];?>" value="<?php echo $dataFim; ?>" name="datafinal" style="width: 50%; text-align: center;"><br><br>						
						</div>
						<b>Relatório<?php echo $erros[0]==1?'<span id="2" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Tipo_Relatorio'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b><br>
							<div>
								<?php
									if($relarioRow['Tipo']){?>
										<input type="radio"   boolt="0"  id="radio2" name="tiporelatorio" value="0" /><b>Parcial</b>
										<input type="radio" checked boolt="<?php echo $erros[0];?>" id="radio1" name="tiporelatorio" value="1" 	/><b>Final</b>
									<?php } 
									else{?>
										<input type="radio" checked  boolt="<?php echo $erros[0];?>" id="radio1" name="tiporelatorio" value="0" style="cursor:pointer;margin-right: 5px;"/><b>Parcial</b>
										<input type="radio"  boolt="0" id="radio2" name="tiporelatorio" value="1" style="cursor:pointer;margin-left: 20px;"/><b>Final</b>
									<?php } 
								?>
							</div>
					</div>
					
				</div>

				<div class="row">		
					<div class="col-md-offset-4 col-xs-12 col-md-4" align="center" style="margin-top:15px;">
						<button id="Save"  name="relatorio"   class="btn btn-success" value="<?php echo $_POST['relatorio']; ?>" width="100%" style="margin-right:5px">Salvar</button>
						<button id="Saves" name="relatorio-s" class="btn btn-primary" value="<?php echo $_POST['relatorio']; ?>" width="100%">Submeter</button>
					</div>	
				</div>
			</form>
			<?php
			//	<div class="modal fade bs-example-modal-lg" id="modelComment" tabindex="-1" role="dialog" data-focus-on="input:first" aria-labelledby="myModalLabel" aria-hidden="true" width="90%">
			?>
			<div class="modal fade bs-example-modal-lg" id="modelComment" tabindex="-1" width="80%">
					<div class="modal-dialog">
					    <div class="modal-content">
						    <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ></button>
							        <h4 class="modal-title" id="myModalLabel">Comentário</h4>
						    </div>
						    <div class="modal-body">
				        		<div class="row">	
					        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
					        				<span><?php echo $comentarioRow['Comentario_Tipo_Relatorio']; ?></span>
					        				<span><?php echo $comentarioRow['Comentario_Data_Inicial']; ?></span>
					        				<span><?php echo $comentarioRow['Comentario_Data_Final']; ?></span>
					        				<span><?php echo $comentarioRow['Comentario_Atividades']; ?></span>
					        				<span><?php echo $comentarioRow['Comentario_Comentario']; ?></span>					        				
					        			</div>	
								</div>
							</div>
						 </div>
					</div>
				</div>