<?php 
	require_once("cabecalho.php");
	require_once("conecta.php");
	require_once("../../Action/pessoas-documentos-pendentes.php"); 
	require_once("../../Action/banco-area.php"); 
	require_once("../../Action/banco-empresa.php");
	require_once("../../Action/banco-termo-aditivo.php");
?>		
	<link href = "css/cadastros-pendentes.css" rel = "stylesheet" >
	<link href = "css/bootstrap.vertical-tabs.css" rel = "stylesheet" >

	<script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>
	<script src="js/padrao_tabela.js"></script>
	<script src="js/documentos-pendentes.js"></script>




<?php 


	if($_SESSION['auto']!='V'&&$_SESSION['auto']!='P'){
			$_SESSION['Failed'];
			header('Location:users.php');
	}




$date = DateTime::createFromFormat("Y-m-d H:i:s", $row['Hora_Do_Envio']);
$HoraEnvio= $date->format("d/m/Y H:i:s");

	/*
	[]--------------------------------------------------------------------------------------[]
|								Model Avaliar Relatórios								|
[]--------------------------------------------------------------------------------------[]
	*/ 
$avaliacao =
'<div class="modal fade bs-example-modal-lg" id="modelRelatoriosAvaliacao'.$row['id_relatorio'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" width="90%">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Avaliação do estagiário</h4>
		    </div>
		    <div class="modal-body">
        		<div class="row row_avaliaestagio">
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
						<center><input type="submit" class="btn btn-danger" value="Aprovar"  name="aprovarRelatorioButton"></center>
					</div>		
				</div>
			</div>
		</div>
	</div>
</div>';
	/*
	[]--------------------------------------------------------------------------------------[]
|								Model Conteúdo Relatórios								|
[]--------------------------------------------------------------------------------------[]
	*/ 
$comentarios =
'<div class="modal fade bs-example-modal-lg" id="modelRelatorios'.$row['id_relatorio'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" width="90%">
	<div class="modal-dialog">
	    <div class="modal-content">
		    <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Comentários sobre os erros</h4>
			</div>
			<div class="modal-body">
				<div class="row row_avaliaestagio">	
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
							<center><input type="submit" class="btn btn-danger" value="Reprovar"  name="reprovarRelatorioButton"></center>
						</div>		
				</div>
			</div>
		</div>
	</div>
</div>';?>

			<div class="panel-body" >
				<form action="Controllers/Controller-documentos-pendentes.php" method="post">
					<input name="id-relatorio" value="<?php echo $row['id_relatorio'];?>" hidden="true">
					<input name="tipo-documento" value="relatorio" hidden="true">

				<div class="relatorio_table table-responsive">
									<div class="relatorio_row">
										<div class="relatorio_cell"><b>Nome:</b> <?php echo $row['Nome_Completo'];?></div>
										<div  class="relatorio_cell"width="80px" align="center">Correto</div>
										<div  class="relatorio_cell"width="80px" align="center">Incorreto</div>
										<div  class="relatorio_cell"width="517px"></div>	
									</div>

									<div class="relatorio_row">
										<div class="relatorio_cell"><b>Tipo de Relatório:</b> <?= ($row['Tipo'] == '0')? "Parcial": "Final";?></div>
										<div  class="relatorio_cell"align="center"><input type="radio" name="tipo-relatorio" value="0" checked="checked"></div>
										<div  class="relatorio_cell"align="center"><input type="radio" name="tipo-relatorio" value="1"></div>
										<div class="relatorio_cell"></div>
									</div>

									<div class="relatorio_row">
										<div class="relatorio_cell"><b>Data Inicial:</b> <?= EchoDate($row['Data_Inicio'])?></b></div>
										<div  class="relatorio_cell"align="center"><input type="radio" name="data_inicial" value="0" checked="checked"></div>
										<div  class="relatorio_cell"align="center"><input type="radio" name="data_inicial" value="1"></div>
										<div class="relatorio_cell"></div>
									</div>

									<div class="relatorio_row">
										<div class="relatorio_cell"><b>Data Final:</b> <?= EchoDate($row['Data_Fim'])?></div>
										<div  class="relatorio_cell"align="center"><input type="radio" name="data_final" value="0" checked="checked"></div>
										<div  class="relatorio_cell"align="center"><input type="radio" name="data_final" value="1"></div>
										<div class="relatorio_cell"></div>
									</div>

									<div class="relatorio_row">
										<div class="relatorio_cell">
											<b>Atividades Desenvolvidas:</b><br>
											<p><?= $row["Atividades"];?></p>
										</div>
										<div  class="relatorio_cell"align="center"><input type="radio" name="atividades" value="0" checked="checked"></div>
										<div  class="relatorio_cell"align="center"><input type="radio" name="atividades" value="1"></div>
										<div class="relatorio_cell"></div>
									</div>
									<div class="relatorio_row">
										<div class="relatorio_cell">
											<b>Comentários:</b><br>
											<p><?= $row["Comentario_Aluno"];?></p>
										</div>
										<div  class="relatorio_cell"align="center"><input type="radio" name="comentarios" value="0" checked="checked"></div>
										<div  class="relatorio_cell"align="center"><input type="radio" name="comentarios" value="1"></div>
										<div class="relatorio_cell"></div>
									</div>

									<?php 
									if($_SESSION['auto']!='V'){?>	
										<!-- Botão de envio do formulário-->
										<div class="relatorio_row">
											<div class="relatorio_cell">
												<button envioRelatorio="1" class="btn btn-primary" name="aprova" relatorio-id="<?php echo $row['id_relatorio'];?>">Enviar</button>
											</div>
										</div>	
										<?php
										echo $comentarios;
										echo $avaliacao;
									}
									else{?>
										<!-- Botão de envio do formulário-->
										<div class="relatorio_row">
											<div class="relatorio_cell">
												<button envioRelatorioPresidente="1" class="btn btn-primary" relatorio-id="<?php echo $row['id_relatorio'];?>">Enviar</button>
											</div>
										</div>
										<?php
										echo $comentarios;
									}
									?>
				</div>
					
				</form>
			</div>
		
	 
<?php
}?>
				