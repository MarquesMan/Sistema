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
	/*
		[]--------------------------------------------------------------------------------------[]
		|				Recuperando Documento Pendentes do Banco de Dados						|
		[]--------------------------------------------------------------------------------------[]
	*/ 

	if($_SESSION['auto']!='V'&&$_SESSION['auto']!='P'){
			$_SESSION['Failed'];
			header('Location:users.php');
	}
	$planos 	 = ListaPlanoDeAtividadesPendentes($mysqli);
	$relatorios  = ListaRelatoriosPendentes($mysqli);
	$estagios 	 = ListaEstagiosPendentes($mysqli);
	$termos		 = ListaTermosDeCompromissoPendentes($mysqli);
	$declaracoes = ListaDeclaracoesFinaisPendentes($mysqli);
	$termosAditivos = ListaTermosAditivosPendentes($mysqli);
	$areas 		 = getAreas($mysqli);

 
/*
	[]--------------------------------------------------------------------------------------[]
	|							Navbar Documentos Pendentes 								|
	[]--------------------------------------------------------------------------------------[]
*/ 

?>
<div class="nav-docs">
	<ul class="nav nav-tabs">
	    <li class="active"><a href="#estagios" data-toggle="tab">Estágios(<?= sizeof($estagios) ?>)</a></li>
		<!--<li><a href="#planos" data-toggle="tab">Plano de Atividades</a></li>
	    <li><a href="#termos" data-toggle="tab">Termos de Compromisso</a></li>-->
		<li><a href="#relatorios" data-toggle="tab">Relatórios (<?= sizeof($relatorios) ?>)</a></li>
	    <li><a href="#declaracoes" data-toggle="tab">Declarações Finais(<?= sizeof($declaracoes) ?>)</a></li>
	    <li><a href="#termoAditivo" data-toggle="tab">Termos Aditivos(<?= sizeof($termosAditivos) ?>)</a></li>
	</ul>	
</div>


<?php 
/*
	[]--------------------------------------------------------------------------------------[]
	|								Abas Documentos Pendentes 								|
	[]--------------------------------------------------------------------------------------[]
*/ 

?>
<div id="corpo" class="corpo">
	<div class="tab-content">

    	<?php 
      			/*
      			[]--------------------------------------------------------------------------------------[]
				|						Aba Plano de Atividades Pendentes								|
				[]--------------------------------------------------------------------------------------[]
      			*/ 

      	?>
	<div class="tab-pane" id="planos">
      		<?php if(count($planos) > 0){ ?>

				<table class="tabela-cabecalho">
					<tr>
						<td width="50%">
							Nome Completo do Aluno
						</td>
						<td width="50%">
							Data/Hora de Envio
						</td>
					</tr>
				</table>


				<?php foreach($planos as $row){ 
					$horarios = $row['Horario'];
					$horarios = explode(";", $horarios);
					$date     = DateTime::createFromFormat("Y-m-d H:i:s", $row['Hora_Do_Envio']);
					$HoraEnvio= $date->format("d/m/Y H:i:s");
					?>
						<!--
							Linha que contém o nome e data de envio do plano de atividades.
							Quando a pessoa clica na linha, ela abre uma tabela que contém
							os dados referentes ao plano de atividades, para serem aprovados.
						-->
					<div class="panel panel-primary">
						<div class="panel-heading">
							<table width="100%">
								<tr>
									<td width="50%"><?php echo $row["Nome_Completo"]?></td>
									<td><?php echo $HoraEnvio ?></td>
								</tr>
							</table>
						</div>
						
						<div class="panel-body" hidden="true">
							<!-- Formulário de envio -->
							<form action="Controllers/Controller-documentos-pendentes.php" method="post">
								<!-- Identificador do plano de atividades -->
								<input name="Id_planoatividades" value="<?php echo $row['id_planoatividades'];?>" hidden="true">
								<input name="tipo-documento" value="plano" hidden="true">
									<div class="table-responsive">
									<table class="table" style="margin-top: 10px;">
										<thead>
											<td width="500px">Nome: <?php echo $row["Nome_Completo"];?></td>
											<td width="80px">Correto</td>
											<td width="80px">Incorreto</td>
											<td width="517px"></td>									
										</thead>
										<tbody>
											<tr>
												<td>Local: <?php echo $row["Local"];?></td>
												<td align="center"><input type="radio" name="local" value="0" checked="checked"/></td>
												<td align="center"><input type="radio" name="local" value="1"/></td>
											</tr>
											<tr>
												<td>Data/Hora: <?php echo $HoraEnvio ?></td>
												<td align="center"><input type="radio" name="data" value="0" checked="checked"/></td>
												<td align="center"><input type="radio" name="data" value="1"/></td>
											</tr>
											<tr>
												<td>Carga Horaria: <?php echo $row["Carga_Horaria"];?></td>
												<td align="center"><input type="radio" name="carga-h" value="0" checked="checked"/></td>
												<td align="center"><input type="radio" name="carga-h" value="1"/></td>
											</tr>
											<tr>										
												<td>											
													Segunda-Feira: 	<?php echo $horarios[0]	!=''?$horarios[0] :"__:__";?> até <?php echo $horarios[1] !=''?$horarios[1] :"__:__";?><br> 
													Terça-Feira:   	<?php echo $horarios[2]	!=''?$horarios[2] :"__:__";?> até <?php echo $horarios[3] !=''?$horarios[3] :"__:__";?><br> 
													Quarta-Feira: 	<?php echo $horarios[4]	!=''?$horarios[4] :"__:__";?> até <?php echo $horarios[5] !=''?$horarios[5] :"__:__";?><br>  
													Quinta-Feira: 	<?php echo $horarios[6]	!=''?$horarios[6] :"__:__";?> até <?php echo $horarios[7] !=''?$horarios[7] :"__:__";?><br>  
													Sexta-Feira: 	<?php echo $horarios[8]	!=''?$horarios[8] :"__:__";?> até <?php echo $horarios[9] !=''?$horarios[9] :"__:__";?><br>  
													Sabado:			<?php echo $horarios[10]!=''?$horarios[10]:"__:__";?> até <?php echo $horarios[11]!=''?$horarios[11]:"__:__";?><br>
												</td>											
												<td align="center">
													<input type="radio" name="segunda" value="0" checked="checked" /><br>
													<input type="radio" name="terca"   value="0" checked="checked" /><br>
													<input type="radio" name="quarta"  value="0" checked="checked" /><br>
													<input type="radio" name="quinta"  value="0" checked="checked" /><br>
													<input type="radio" name="sexta"   value="0" checked="checked" /><br>
													<input type="radio" name="sabado"  value="0" checked="checked" /><br>
												</td>
												<td align="center">
													<input type="radio" name="segunda" value="1" /><br>
													<input type="radio" name="terca"   value="1" /><br>
													<input type="radio" name="quarta"  value="1" /><br>
													<input type="radio" name="quinta"  value="1" /><br>
													<input type="radio" name="sexta"   value="1" /><br>
													<input type="radio" name="sabado"  value="1" /><br>
												</td>
											</tr>
											<tr>
												<td>
													Descrição:<br>
													<p><?php echo $row["Descricao"];?></p>
												</td>

												<td align="center">
													<input type="radio" name="descricao" value="0" checked="checked" />
												</td>

												<td align="center">
													<input type="radio" name="descricao" value="1" />
												</td>
											</tr>
											<!-- Botão de envio do formulário-->
											<tr>
												<td>
													<input class="btn btn-primary" type="submit" name="botaoPlano" value="Enviar" id_plano="<?php echo $row['id_planoatividades'];?>">
												</td>
											</tr>
										</tbody>
									</table>
								</div>
									<div class="modal fade bs-example-modal-lg" id="modelplano<?php echo $row['id_planoatividades'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" width="90%">
										<div class="modal-dialog">
										    <div class="modal-content">
											    <div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title" id="myModalLabel">Comentários sobre os erros</h4>
											    </div>
											    <div class="modal-body">
									        		<div class="row row_avaliaestagio">	
									        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
									        				<span><b>Local:</b><br></span>
									        				<textarea id="localRadio" name="localRadio" style="resize:none;width:100%;"  ></textarea>
									        			</div>
									        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
									      		  			<span><b>Data/Hora:</b><br></span>
									      		  			<textarea id="dataHoraRadio" name="dataHoraRadio" style="resize:none;width:100%;"  ></textarea>
									        			</div>
									        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
									        				<span><b>Carga Horaria:</b><br></span>
									        				<textarea id="cargaHorariaRadio" name="cargaHorariaRadio" style="resize:none;width:100%;"  ></textarea>
									        			</div>
									        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
									        				<span><b>Dias:</b><br></span>
									      		  			<textarea id="diasRadio" name="diasRadio" style="resize:none;width:100%;"  ></textarea>
									        			</div>						
									        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
									        				<span><b>Descrição:</b><br></span>
									      		  			<textarea id="descricaoRadio" name="descricaoRadio" style="resize:none;width:100%;"></textarea>
									        			</div>

									        			<div class="col-xs-12 col-md-12" style="margin-top:50px;">
									      		  			<center><input type="submit" class="btn btn-danger" value="Reprovar"  name="botaoPlano"></center>
									        			</div>		
													</div>
												</div>
											 </div>
										</div>
									</div>
							</form>
						</div>
					</div>
					<!-- Tabela que contém os dados relacionados ao plano de atividades -->
					<?php
				}
			}
			//<!-- Caso contrario, mostre a seguinte mensagem-->
			else{ ?>

				<center>Nenhum Plano de Atividdades pendente.</center>
			<?php } ?>
      	</div>

      	<?php 
      			/*
      			[]--------------------------------------------------------------------------------------[]
				|								Aba Relatórios Pendentes								|
				[]--------------------------------------------------------------------------------------[]
      			*/ 

      	?>
      	<div class="tab-pane" id="relatorios">
			<?php if(count($relatorios) > 0){ ?>
			<table class="table table-bordered table-striped tabela-cabecalho">
				
				<thead>
					<tr>
						<td style="width: 50%;">Nome Completo do Aluno</td>
						<td style="width: 50%;">Data/Hora de Envio</td>
		                <?php if($_SESSION['auto']=='V')echo '<td style="width: 50%;padding-right: 50px">Entrega</td>'?>
					</tr>
				</thead>

				<tbody>
						
				<?php foreach($relatorios as $row){
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

					
						 
							
								<tr class="panel-heading" <?php echo "value=\"".$row["Id_Relatorio"]."\""?> >
								
									<td class="celula-p" width="50%"><?php echo $row["Nome_Completo"]?></td>
									<td><?=$HoraEnvio ?></td>
	                                <?php if($_SESSION['auto']=='V')
	                                    if($row['Status']=="entrega")
	                                    echo '<td>
	                                            <form method="post" style="margin-bottom: 0px;text-align: center" action="Controllers/Controller-entrega-documentos.php">
	                                                <input hidden="hidden" name="idRelatorio" value="'.$row["Id_Relatorio"].'" >
	                                                <button type="submit" name="EntregaRelatorio" style="padding: 9px 10px;" class="entrega btn btn-success"><span class="glyphicon glyphicon-ok" style="top:2px;"></span></button>
	                                            </form>
	                                        </td>';
	                                    else
	                                        echo "<td style=\"margin-bottom: 0px;text-align: center\" ><button title='Precisa ser aprovado primeiro.' style=\"padding: 9px 10px;\" class=\"btn btn-disabled\"><span class=\"glyphicon glyphicon-ok\" style=\"top:2px;\"></span></button></td>";
	                                ?>
								</tr>

								<?php
/*

<div class="panel-body" hidden="true">
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
*/
					}


								?>
								
				</tbody>

				
			</table>

			<?php
			}
			else{?>
			    <div class='alert alert-info text-center' style='width: 90%; margin-left: auto; margin-right: auto;'>
			        Nenhum Relatório pendente.
			    </div>
			<?php
			}?>
		</div>

      	<?php 
      			/*
      			[]--------------------------------------------------------------------------------------[]
				|								Aba Estágios Pendentes									|
				[]--------------------------------------------------------------------------------------[]
      			*/ 

      	?>
      	<div class="tab-pane active " id="estagios">
      		<?php if(count($estagios) > 0){ ?>

	      		<div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Nome Completo do Aluno</td>
                                <td>Área</td>
                                <td>Empresa</td>
                                <td>Surpevisor</td>
                                <td>Data de Inicio</td>
                                <?php if($_SESSION['auto']=='V')echo '<td style="text-align: center" >Entrega de Documentos</td>'?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 0;
                            foreach($estagios as $row){

                                $getEmpresa = $row['nome_empresa']; 			// pega o nome da empresa
                                $getSurpervisor = $row['nome_supervisor']; 		// pega o nome do supervisor
                                $NomeArea = GetAreaById($mysqli, $row["Area"]); // pega o nome da area

                                ?>
                                <tr style="cursor: pointer;" name="<?= $i; ?>" estagio value='<?= $row["Id_Estagio"]?>' data-toggle="modal" data-target="#AvaliaEstagioModal" >
                                    <td><?= $row["nome_aluno"];?></td>
                                    <td><?= $NomeArea[0]['Nome'];//Otimizar-Aqui?></td>
                                    <td><?= $getEmpresa ?></td> 					<!-- nome da empresa -->
                                    <td><?= $getSurpervisor ?></td>					<!-- nome do supervisor -->
                                    <td><?php EchoDate($row["Data_Inicio"])?></td> 	<!-- data inicial -->
                                    <?php if($_SESSION['auto']=='V')
                                        if($row['Status']=="entrega")
                                        echo ' <td>
                                                <form method="post" style="margin-bottom: 0px;text-align: center" action="Controllers/Controller-entrega-documentos.php">
                                                    <input hidden="hidden" name="idEstagio" value="'.$row["Id_Estagio"].'" >
                                                    <button type="submit" name="EntregaEstagio" style="padding: 9px 10px;" class="entrega btn btn-success"><span class="glyphicon glyphicon-ok" style="top:2px;"></span></button>
                                                </form>
                                            </td>';
                                        else
                                            echo "<td style=\"margin-bottom: 0px;text-align: center\" ><button title='Precisa ser aprovado primeiro.' style=\"padding: 9px 10px;\" class=\"btn btn-disabled\"><span class=\"glyphicon glyphicon-ok\" style=\"top:2px;\"></span></button></td>";
                                    ?>
                                </tr>
                            <?php
                            $i = $i + 1;
                            } ?>
                        </tbody>
                    </table>
                </div>

<!--				<table class="tabela-cabecalho">
					<tr>
						<td style="width: 50%;">Nome Completo do Aluno</td>
						<td style="width: 50%;">Área</td>
					</tr>
				</table>

				
				<?php foreach($estagios as $row){ ?>
					<div class="panel panel-primary">
						<?php $NomeArea = GetAreaById($mysqli, $row["Area"]); ?>
						<div class="panel-heading">
							<table width="100%">
								<tr>
									<td width="50%"><?php echo $row["nome_aluno"]?></td>
									<td><?= $NomeArea[0]["Nome"];?></td>
								</tr>
							</table>
						</div>

						<div class="panel-body" hidden="true">
							<form  action="Controllers/Controller-documentos-pendentes.php" method="post">

								<input name="id-estagio" value="<?php echo $row['Id_Estagio'];?>" hidden="true">
								<input name="tipo-documento" value="estagio" hidden="true">

								<div class="table-responsive">
									<table class="table">
										<tr>
											<td ><b>Nome:</b> <?php echo $row['nome_aluno'];?></td>
										</tr>

										<tr>
											<td><b>Tipo de Estágio: </b><?= ($row["Modalidade"] == '0')? "Parcial": "Final";?></td>						
										</tr>

										<tr>
											<td><b>Empresa: </b><?= $row["nome_empresa"]?></td>						
										</tr>

										<tr>
											<td><b>Data Inicial:</b> <?= $row['Data_Inicio'];?></td>
										</tr>

										<tr>
											<td><b>Data Final:</b> <?= $row['Data_Fim'];?></td>
										</tr>
										
										<tr>
											<td><b>Área:</b> <?= $NomeArea[0]["Nome"];?></td>
										</tr>

										<tr>
											<td>
												<input class="btn btn-primary" type="submit" name="Enviar" value="Aceitar">
												<input class="btn btn-danger" style="margin-left: 20px;" type="submit" name="Enviar" value="Recusar">
											</td>
										</tr>

									</table>
								</div>
							</form>
						</div>
					</div>
				<?php } ?> -->				
			<?php }

			else{ ?>
                <div class='alert alert-info text-center' style='width: 90%; margin-left: auto; margin-right: auto;'>
                    Nenhum Estágio pendente.
                </div>
			<?php } ?>
      	</div>

      	<?php
      			/*
      			[]--------------------------------------------------------------------------------------[]
				|						Aba Termos de Compromisso Pendentes								|
				[]--------------------------------------------------------------------------------------[]
      			*/ 

      	?>
      	<div class="tab-pane" id="declaracoes">
      		<?php if(count($declaracoes) > 0){ ?>
      			<div class="table-responsive">

					 <table class="table table-bordered table-striped">
						<thead>
							<tr>
								<td>Nome Completo do Aluno</td>
								<td>Nome documento</td>
								<td>Documento</td>
								<td>Avaliação</td>
								 <?php if($_SESSION['auto']=='V')echo '<td style="text-align:center">Entrega</td>'?>
							</tr>
						</thead>

						<tbody>
							<?php
							foreach($declaracoes as $d){?>
								<!--Row-->
								<tr>
		    	   					<td><?= $d["Nome_Completo"]?></td>
		    	   					<td><?= $d["Nome_Declaracao"]?></td>
		    	   					<td><a href=<?= "mostra-arquivo.php?idEstagio=".$d['Id_Estagio']."&tipo-documento=declaracao" ?> target="_blank">visualizar</a></td>
	    	   						<td>
	    	   							<form method="post" action="Controllers/Controller-documentos-pendentes.php">
	    	   								<input hidden="true" name="tipo-documento" value="declaracao">
	    	   								<input hidden="true" name="id-estagio" value="<?=$d['Id_Estagio']?>">
											<input hidden="true" name="TipoDeSubmissao" value="">

											<input id="avalia-a" type="submit" name="avalia-a" value="Aceitar" class="btn btn-primary">
	    	   								<input id="avalia-r" type="submit" name="avalia-r" value="Recusar" class="btn btn-danger reprovaDF" data-toggle="modal" data-target="#DFModal" style="margin-left: 20px;">

	    	   								<input hidden="true" name="comentario" value="">
	    	   							</form>
	    	   						</td>
	    	   						<?php if($_SESSION['auto']=='V') 	
                                        if($d['Status_Declaracao']=="entrega")
                                        echo ' <td>
                                                <form method="post" style="margin-bottom: 0px;text-align: center" action="Controllers/Controller-entrega-documentos.php">
                                                    <input hidden="hidden" name="idDeclaracao" value="'.$d["Id_Declaracao"].'" >
                                                    <button type="submit" name="EntregaDeclaracao" style="padding: 9px 10px;" class="entrega btn btn-success"><span class="glyphicon glyphicon-ok" style="top:2px;"></span></button>
                                                </form>
                                            </td>';
                                        else
                                            echo "<td style=\"margin-bottom: 0px;text-align: center\" ><button title='Precisa ser aprovado primeiro.' style=\"padding: 9px 10px;\" class=\"btn btn-disabled\"><span class=\"glyphicon glyphicon-ok\" style=\"top:2px;\"></span></button></td>";
                                    ?>
	    	   					</tr>
							<?php
							}?>
						</tbody>
						<!-- Modal -->
						<div class="modal fade" id="DFModal" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<!-- Header-->
										<button class="close" type="button" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Recusar declaração final</h4>
									</div>
									<div class="modal-body">
										<!-- Campos-->
										<label for="DFModalc" >Comentário:</label>
										<textarea style="resize:none;width:100%;" id="DFModalc"></textarea>
									</div>
									<div class="modal-footer">
										<!-- Botoes-->
										<span id="final-modal">
											<input type="button" id="DFModal-s" value="Confirmar" class="btn btn-primary " style="margin-left: 20px;">
		    	   							<input type="button" id="DFModal-n" value="Cancelar" data-dismiss="modal" class="btn btn-danger" style="margin-left: 20px;">
	    	   							</span>
									</div>
								</div>
							</div>
						</div>
					</table>
				</div>

			<?php }

			else{ ?>
                <div class='alert alert-info text-center' style='width: 90%; margin-left: auto; margin-right: auto;'>
					Nenhuma Declaração Final Pendente.
				</div>
			<?php } ?>
      	</div>



      	<?php 
      			/*
      			[]--------------------------------------------------------------------------------------[]
				|						Aba Declaraçoes Finais Pendentes								|
				[]--------------------------------------------------------------------------------------[]
      			*/ 

      	?>
      	<div class="tab-pane" id="termoAditivo">
      		<?php if(count($termosAditivos) > 0){ ?>
      			<div class="table-responsive">

					 <table class="table table-bordered table-striped">
						<thead>
							<tr>
								<td>Nome Completo do Aluno</td>
								<!-- <td>Nome documento</td>-->
								<td>Documento</td>
								<td>Data final</td>
								<td>Data de prorrogação</td>
								<td>Avaliação</td>
                                 <?php if($_SESSION['auto']=='V')echo '<td style="text-align:center">Entrega</td>'?>
							</tr>
						</thead>

						<tbody>
							<?php
							$i = 0;
							foreach($termosAditivos as $d){ ?>
								<tr>

		    	   					<td><?= $d["Nome_Completo"]?></td>
		    	   					<!--<td><?= $d["Nome_TermoAditivo"]?></td>-->
		    	   					<td><a href=<?= "mostra-arquivo.php?idEstagio=".$d['Id_Estagio']."&tipo-documento=termo" ?> target="_blank">visualizar</a></td>
	    	   						<td><?= $d["Data_Fim"]?></td>
	    	   						<td><?= $d["Data_Prorrogacao"]?></td>
	    	   						<td>
	    	   							<form method="post" action="Controllers/Controller-documentos-pendentes.php">
											<input hidden="true" name="id-estagio" value="<?=$d['Id_Estagio']?>">
											<input hidden="true" name="idTermoAditivo" value="<?=$d['Id_TermoAditivo']?>">

											<input id="avaliaTermoAditivo-a" type="submit" name="avaliaTermoAditivo-a" value="Aceitar" class="btn btn-primary">
											<input id="avaliaTermoAditivo-r" type="submit" name="avaliaTermoAditivo-r" value="Recusar" class="btn btn-danger reprovaTA" data-toggle="modal" data-target="#TAModal" style="margin-left: 20px;">

											<input hidden="true" name="comentario" value="">
	    	   							</form>
	    	   						</td>
	    	   						<?php if($_SESSION['auto']=='V')
                                        if($d['Status_TermoAditivo']=="entrega")
                                        echo ' <td>
                                                <form method="post" style="margin-bottom: 0px;text-align: center" action="Controllers/Controller-entrega-documentos.php">
                                                    <input hidden="hidden" name="idTermo" value="'.$d["Id_TermoAditivo"].'" >
                                                    <button type="submit" name="EntregaTermoAditivo" style="padding: 9px 10px;" class="entrega btn btn-success"><span class="glyphicon glyphicon-ok" style="top:2px;"></span></button>
                                                </form>
                                            </td>';
                                        else
                                            echo "<td style=\"margin-bottom: 0px;text-align: center\" ><button title='Precisa ser aprovado primeiro.' style=\"padding: 9px 10px;\" class=\"btn btn-disabled\"><span class=\"glyphicon glyphicon-ok\" style=\"top:2px;\"></span></button></td>";

                                    ?>
	    	   					</tr>
							<?php
							$i = $i + 1;
							} ?>
						</tbody>
						<!-- Modal -->
						<div class="modal fade" id="TAModal" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<!-- Header-->
										<button id="TAModal-c" class="close" type="button" data-dismiss="modal" aria-label="close" >&times;</button>
										<h4 class="modal-title">Reprovar Termo Aditivo</h4>
									</div>
									<div class="modal-body">
										<!-- Campos-->
										<label for="TermoAditivoText">Comentário:</label>
										<textarea id="TermoAditivoText" style="resize:none;width:100%;" value=""></textarea>
									</div>
									<div class="modal-footer">
										<!-- Botoes-->
										<span id="TAModal-button">
		    	   							<input type="button" id="TAModal-n" value="Recusar" class="btn btn-danger center" style="margin-left: 20px;">
	    	   							</span>
									</div>
								</div>
							</div>
						</div>
					</table>
				</div>

			<?php }

			else{ ?>
                <div class='alert alert-info text-center' style='width: 90%; margin-left: auto; margin-right: auto;'>
					Nenhuma Termo Aditivo Pendente.
				</div>
			<?php } ?>
      	</div>


      	<?php 
      			/*
      			[]--------------------------------------------------------------------------------------[]
				|						Aba de Termos aditivos pendentes								|
				[]--------------------------------------------------------------------------------------[]
      			*/ 

      	?>
        <div class="tab-pane" id="termos">
            <?php if(count($termos) > 0){ ?>
                <div class="table-responsive">

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td>Nome Completo do Aluno</td>
                            <td>Nome documento</td>
                            <td>Documento</td>
                            <td>Avaliação</td>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        foreach($termos as $t){ ?>
                            <tr>
                                <td><?= $t["Nome_Completo"]?></td>
                                <td><?= $t["Nome_Termo"]?></td>
                                <td><a href=<?= "mostra-arquivo.php?idEstagio=".$t['Id_Estagio']."&tipo-documento=termo" ?> target="_blank">visualizar</a></td>
                                <td>
                                    <form method="post" action="Controllers/Controller-documentos-pendentes.php" >
                                        <input hidden="true" name="tipo-documento" value="termo">
                                        <input hidden="true" name="id-estagio" value="<?= $t['Id_Estagio']?>">

                                        <input type="button" name="avalia-a" value="Aceitar" class="btn btn-primary">
                                        <input type="button" name="avalia-r" value="Recusar" class="btn btn-danger" style="margin-left: 20px;">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>
                </div>

            <?php }

            else{ ?>
                <div class='alert alert-info text-center' style='width: 90%; margin-left: auto; margin-right: auto;'>
                    Nenhum Termo de Compromisso Pendente.
                </div>
            <?php } ?>
        </div>


    </div>
</div>


<!-- 
=====================================================================
					Modal de avalia estagio
=====================================================================
-->

<div class="modal fade bs-example-modal-lg" id="AvaliaEstagioModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" width="90%"> <!-- modal do novo estagio -->
	<div class="modal-dialog"><!-- dialogo do modal -->
	    <div class="modal-content"> <!-- conteudo do dialogo do modal -->
		    
		    <div class="modal-header">  <!-- cabecalho modal -->
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>  <!-- botao de fechar o modal -->
			        <h4 class="modal-title" id="AvaliaEstagioModalTittle"></h4>  <!-- texto cabecalho -->
		    </div>  <!-- cabecalho modal -->

		    <div id="modalAvaliaEstagio" class="modal-body">
		       	
			</div>
		</div><!-- conteudo do dialogo do modal -->
	</div><!-- dialogo do modal -->
</div><!-- modal do novo estagio --> 

<!-- 
=====================================================================
					Modal Relatorio
=====================================================================
-->

<div class="modal fade bs-example-modal-lg" id="AvaliaRelatorioModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" width="90%"> <!-- modal do novo estagio -->
	<div class="modal-dialog"><!-- dialogo do modal -->
	    <div class="modal-content"> <!-- conteudo do dialogo do modal -->
		    
		    <div class="modal-header">  <!-- cabecalho modal -->
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>  <!-- botao de fechar o modal -->
			        <h4 class="modal-title">Relatório</h4>  <!-- texto cabecalho -->
		    </div>  <!-- cabecalho modal -->

		    <div id="modalAvaliaRelatorio" class="modal-body">
		       	
			</div>
		</div><!-- conteudo do dialogo do modal -->
	</div><!-- dialogo do modal -->
</div><!-- modal do novo estagio --> 

<?php require_once("rodape.php");?>