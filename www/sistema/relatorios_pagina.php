
	<?php
	require_once("../../Action/banco-relatorios.php");
	require_once("../../Action/banco-usuarios.php");
	session_start();
	require_once("conecta.php");


	if($_SESSION['auto']=='P'){
	    $pessoa = "supervisor";
		echo "<script src=\"js/avalia-relatorio.js\"></script>";
	}
	elseif($_SESSION['auto']=='V'){
	    $pessoa = "presidente";
		echo "<script src=\"js/avalia-relatorio-presidente.js\"></script>";
	}
	else
		erroPadrao("Parametros incorretos");

	if(!isset($_POST['relatorio']) ){ 
		erroPadrao("Parametros incorretos");
	}

	$relatorio = ListaRelatorio($mysqli,NULL,$_POST['relatorio']);

	if(empty($relatorio)){
		erroPadrao("Erro ao abrir relatório");
	}



	$relatorio = $relatorio[0];
	var_dump($relatorio);
	$usuario = GetUsuarioById($mysqli,$relatorio['Id_Aluno'], $pessoa);
	$usuario = $usuario[0];
	var_dump($usuario);
	?>

		
		<form id="formRoot" action="Controllers/Controller-documentos-pendentes.php" method="post">
			<input name="id-relatorio" value="<?php echo $relatorio['Id_Relatorio'];?>" hidden="true">
			<input name="tipo-documento" value="relatorio" hidden="true">

			<div id="formTable" class="relatorio_table table-responsive">
				<div class="relatorio_row">
					<div class="relatxorio_cell"><b>Nome:</b> <?php echo $usuario['Nome_Completo'];?></div>
					<div  class="relatorio_cell"width="80px" align="center" style="padding-right:10px">Correto</div>
					<div  class="relatorio_cell"width="80px" align="center">Incorreto</div>
					<div  class="relatorio_cell"width="517px"></div>	
				</div>

				<div class="relatorio_row">
					<div class="relatorio_cell"><b>Tipo de Relatório:</b> <?= ($relatorio['Tipo'] == '0')? "Parcial": "Final";?></div>
					<div  class="relatorio_cell"align="center"><input type="radio" name="tipo-relatorio" value="0" checked="checked"></div>
					<div  class="relatorio_cell"align="center"><input type="radio" name="tipo-relatorio" value="1"></div>
					<div class="relatorio_cell"></div>
				</div>

				<div class="relatorio_row">
					<div class="relatorio_cell"><b>Data Inicial:</b> <?= EchoDate($relatorio['Data_Inicio'])?></b></div>
					<div  class="relatorio_cell"align="center"><input type="radio" name="data_inicial" value="0" checked="checked"></div>
					<div  class="relatorio_cell"align="center"><input type="radio" name="data_inicial" value="1"></div>
					<div class="relatorio_cell"></div>
				</div>

				<div class="relatorio_row">
					<div class="relatorio_cell"><b>Data Final:</b> <?= EchoDate($relatorio['Data_Fim'])?></div>
					<div  class="relatorio_cell"align="center"><input type="radio" name="data_final" value="0" checked="checked"></div>
					<div  class="relatorio_cell"align="center"><input type="radio" name="data_final" value="1"></div>
					<div class="relatorio_cell"></div>
				</div>

				<div class="relatorio_row">
					<div class="relatorio_cell">
						<b>Atividades Desenvolvidas:</b><br>
						<p><?= $relatorio["Atividades"];?></p>
					</div>
					<div  class="relatorio_cell"align="center"><input type="radio" name="atividades" value="0" checked="checked"></div>
					<div  class="relatorio_cell"align="center"><input type="radio" name="atividades" value="1"></div>
					<div class="relatorio_cell"></div>
				</div>
				<div class="relatorio_row">
					<div class="relatorio_cell">
						<b>Comentários:</b><br>
						<p><?= $relatorio["Comentario_Aluno"];?></p>
					</div>
					<div  class="relatorio_cell"align="center"><input type="radio" name="comentarios" value="0" checked="checked"></div>
					<div  class="relatorio_cell"align="center"><input type="radio" name="comentarios" value="1"></div>
					<div class="relatorio_cell"></div>
				</div>

				<?php 
				if($_SESSION['auto']=='P'){?>
					<!-- Botão de envio do formulário-->
					<div class="relatorio_row">
						<div style="text-align:center;width:100%">
							<button id="teste" envioRelatorio="1" class="btn btn-primary" name="aprova" relatorio-id="<?php echo $relatorio['Id_Relatorio'];?>">Enviar</button>
						</div>
					</div>
					<?php
				}
				else{?>
					<!-- Botão de envio do formulário-->
					<div class="relatorio_row">
						<div class="relatorio_cell">
							<center>
								<button envioRelatorioPresidente="1" class="btn btn-primary" relatorio-id="<?php echo $relatorio['Id_Relatorio'];?>">Enviar</button>
							</center>
						</div>
					</div>
					<?php
				}?>
			</div>

			<?php
				if($_SESSION['auto']=='P'){?>

					<div class="row row_errosestagio" hidden="hidden">
							<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
								<span><b>Tipo de Relatório:</b><br></span>
								<textarea id="tipoRelatorioErro" name="tipoRelatorioErro" style="resize:none;width:100%;"  ></textarea>
							</div>
							<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
								<span><b>Data Inicial:</b><br></span>
								<textarea id="dataInicialErro" name="dataInicialErro" style="resize:none;width:100%;"  ></textarea>
							</div>
							<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
								<span><b>Data Final:</b><br></span>
								<textarea id="dataFinalErro" name="dataFinalErro" style="resize:none;width:100%;"  ></textarea>
							</div>
							<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
								<span><b>Atividades Desenvolvidas:</b><br></span>
								<textarea id="atividadesErro" name="atividadesErro" style="resize:none;width:100%;"  ></textarea>
							</div>						
							<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
								<span><b>Comentários:</b><br></span>
								<textarea id="comentariosErro" name="comentariosErro" style="resize:none;width:100%;"></textarea>
							</div>

							<div class="col-xs-12 col-md-12" style="margin-top:50px;">
								<center><input type="submit" class="btn btn-danger" value="Reprovar"  name="reprovarRelatorioButton">
									<button  name="botaoCancela" 	class="btn btn-danger" style="margin-left: 20px;" >Cancelar</button>
								</center>
							</div>		
					</div>

					<div class="row row_avaliaestagio" hidden="hidden">
	        			<div class="col-xs-2 col-md-2 linhas-avaliacao" style="margin-top:10px">
	        				<center><span><b>Aspectos</b></span></center>
							<span><b>Assiduidade</b><br></span>
							<span><b>Disciplina</b><br></span>
							<span><b>Cooperação</b><br></span>
							<span><b>Produção</b><br></span>
							<span><b>Iniciativa</b><br></span>
							<span><b>Assimilação</b><br></span>
							<span><b>Conhecimentos</b><br></span>
							<span><b>Responsabilidade</b><br></span>
							<span><b>Dedicação</b><br></span>
							<span><b>Organização</b><br></span>		
						</div>
						<div class="col-xs-1 col-md-1 linhas-avaliacao" style="margin-top:10px"></div>
		    			<div class="col-xs-2 col-md-2 linhas-avaliacao" style="margin-top:10px">
							<center>
							<span><b>Ótimo</b><br></span>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assiduidade" value="0" checked="checked" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Disciplina" value="0" checked="checked" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Cooperacao" value="0" checked="checked" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Producao" value="0" checked="checked" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Iniciativa" value="0" checked="checked" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assimilacao" value="0" checked="checked" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Conhecimentos" value="0" checked="checked" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Responsabilidade" value="0" checked="checked" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Dedicacao" value="0" checked="checked" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Organizacao" value="0" checked="checked" /><br>
							</center>
						</div>
		    			<div class="col-xs-2 col-md-2 linhas-avaliacao" style="margin-top:10px">
							<center>
								<span><b>Bom</b><br></span>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assiduidade" value="1" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Disciplina" value="1" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Cooperacao" value="1" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Producao" value="1" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Iniciativa" value="1" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assimilacao" value="1" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Conhecimentos" value="1" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Responsabilidade" value="1" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Dedicacao" value="1" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Organizacao" value="1" /><br>
							</center>
						</div>
						<div class="col-xs-2 col-md-2 linhas-avaliacao" style="margin-top:10px">
							<center>
								<span><b>Ruim</b><br></span>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assiduidade" value="2" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Disciplina" value="2" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Cooperacao" value="2" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Producao" value="2" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Iniciativa" value="2" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assimilacao" value="2" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Conhecimentos" value="2" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Responsabilidade" value="2" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Dedicacao" value="2" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Organizacao" value="2" /><br>
							</center>
						</div>
						<div class="col-xs-2 col-md-2 linhas-avaliacao" style="margin-top:10px">
							<center>
								<span><b>Insuficiente</b><br></span>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assiduidade" value="3" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Disciplina" value="3" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Cooperacao" value="3" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Producao" value="3" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Iniciativa" value="3" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assimilacao" value="3" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Conhecimentos" value="3" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Responsabilidade" value="3" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Dedicacao" value="3" /><br>
								<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Organizacao" value="3" /><br>
							</center>
						</div>
						<div class="col-xs-12 col-md-12" style="margin-top:10px;">
							<span><b>Observações:</b><br></span>
							<textarea id="Observacoes" name="Observacoes" style="resize:none;width:100%;"></textarea>
						</div>
						<div class="col-xs-12 col-md-12" style="margin-top:50px;">
							<center>
								<input type="submit" class="btn btn-success" value="Aprovar"  name="aprovarRelatorioButton">
								<button  name="botaoCancela" class="btn btn-danger" style="margin-left: 20px;" >Cancelar</button>
							</center>
						</div>		
					</div>


			<?php }else{ ?>

					<div class="row row_errosestagio" hidden="hidden">
							<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
								<span><b>Tipo de Relatório:</b><br></span>
								<textarea id="tipoRelatorioErro" name="tipoRelatorioErro" style="resize:none;width:100%;"  ></textarea>
							</div>
							<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
								<span><b>Data Inicial:</b><br></span>
								<textarea id="dataInicialErro" name="dataInicialErro" style="resize:none;width:100%;"  ></textarea>
							</div>
							<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
								<span><b>Data Final:</b><br></span>
								<textarea id="dataFinalErro" name="dataFinalErro" style="resize:none;width:100%;"  ></textarea>
							</div>
							<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
								<span><b>Atividades Desenvolvidas:</b><br></span>
								<textarea id="atividadesErro" name="atividadesErro" style="resize:none;width:100%;"  ></textarea>
							</div>						
							<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
								<span><b>Comentários:</b><br></span>
								<textarea id="comentariosErro" name="comentariosErro" style="resize:none;width:100%;"></textarea>
							</div>

							<div class="col-xs-12 col-md-12" style="margin-top:50px;">
								<center>
										<input type="submit" class="btn btn-danger" value="Reprovar"  name="reprovarRelatorioButton">
										<button  name="botaoCancela" class="btn btn-danger" style="margin-left: 20px;" >Cancelar</button>
								</center>
							</div>
					</div>

			<?php
				}
			?>
			
		</form>	