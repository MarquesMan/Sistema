<script src="js/jquery.maskedinput.js"></script>
<script src="js/avalia-estagio.js"></script>
	<link href = "css/cadastros-pendentes.css" rel = "stylesheet" >
<?php
	
	require_once "conecta.php";
	require_once("../../Action/banco-area.php");
	require_once("../../Action/banco-usuarios.php");
	require_once("../../Action/banco-empresa.php");
	require_once("../../Action/banco-termo-de-compromisso.php");
	session_start();
 
			if(isset($_POST['idEstagio'])){
				$idEstagio = mysqli_real_escape_string($mysqli,$_POST['idEstagio']);
				if($_SESSION["auto"]=="P"){
					$estagio = mysqli_query($mysqli,"SELECT * FROM estagio WHERE Id_Estagio='".$idEstagio."' AND Id_Supervisor='".$_SESSION["id"]."'") or die(mysqli_error($mysqli));
				} else{
					$estagio = mysqli_query($mysqli,"SELECT * FROM estagio WHERE Id_Estagio='".$idEstagio."'") or die(mysqli_error($mysqli));
				}
				$estagio = mysqli_fetch_assoc($estagio);
			}else{
				erroPadrao();
			}

			if(empty($estagio)){ 
					erroPadrao();
			}

			$query = mysqli_query($mysqli,"SELECT * FROM plano_de_atividades WHERE Id_Estagio='".$idEstagio."' AND Id_Aluno='".$estagio["Id_Aluno"]."'") or die(mysqli_error($mysqli));
            $planoRow = mysqli_fetch_assoc($query);

			if(empty($planoRow)){
				erroPadrao("Nao tem permissão para acessar este plano de atividades");
			}


			$horarios = $planoRow['Horario'];
			$horarios = explode(";", $horarios);

			// Comentarios das Info de Estagio

	$aluno = GetUsuarioById($mysqli, $estagio['Id_Aluno']);
	$aluno = $aluno[0];

	$supervisor = GetUsuarioById($mysqli, $estagio['Id_Supervisor']);
	$supervisor = $supervisor[0];
	
	$termo = ListaTermoDeCompromisso($mysqli, false, $idEstagio);
    if(!empty($termo))
	    $termo = $termo[0];

	$empresa = GetEmpresaById($mysqli, $estagio['Id_Empresa']);
	$empresa = $empresa[0];


	$NomeArea = GetAreaById($mysqli, $estagio["Area"]); // pega o nome da area

?>

<form id="AvaliaForm" action="Controllers/Controller-avalia-estagio.php" method="POST" enctype="multipart/form-data">  <!-- fomulario do novo estagio -->			       
					       
					       <input name="plano" hidden value='<?php echo $planoRow["Id_Plano_De_Atividades"]; ?>' type="hidden"> 
					       <input name="idEstagio" hidden value='<?php echo $idEstagio; ?>' type="hidden"> 

					        <div class="row row_avalia" id="infoEstagio" ><!-- Informacoes do estagio -->	
								

		
								<div class="col-xs-11 col-md-11"   > 	
								
								<div class="table-responsive">

										<div class="col-xs-12 col-md-12"  style="margin-top:10px">
												<center><b>Informações</b></center>
										</div>

										<div class="col-xs-12 col-md-12" style="margin-top:10px" >
											<div class="col-xs-8 col-md-8" ><b>Nome: </b><?php echo $aluno["Nome_Completo"];?></div>
											<div class="col-xs-2 col-md-2" ><b>Correto</b></div>
											<div class="col-xs-2 col-md-2" ><b>Incorreto</b></div>
										</div>

										<div class="col-xs-12 col-md-12" style="margin-top:10px" >
											<div class="col-xs-8 col-md-8" ><b>Tipo de Estágio: </b><?= ($estagio["Modalidade"] == '0')? "Parcial": "Final";?></div>						
											<div class="col-xs-2 col-md-2" ><center><input type="radio" name="Radio_Modalidade" value="0" checked="checked"/></center></div>
											<div class="col-xs-2 col-md-2" ><center><input type="radio" name="Radio_Modalidade" value="1"/></center></div>
										</div>

										<div class="col-xs-12 col-md-12" style="margin-top:10px" >
											<div class="col-xs-8 col-md-8" ><b>Supervisor: </b><?= $supervisor["Nome_Completo"]?></div>
											<div class="col-xs-2 col-md-2" ><center><input type="radio" name="Radio_Supervisor" value="0" checked="checked"/></center></div>
											<div class="col-xs-2 col-md-2" ><center><input type="radio" name="Radio_Supervisor" value="1"/></center></div>						
										</div>

										<div class="col-xs-12 col-md-12" style="margin-top:10px" >
											<div class="col-xs-8 col-md-8" ><b>Empresa: </b><?= $empresa["Nome"]?></div>
											<div class="col-xs-2 col-md-2" ><center><input type="radio" name="Radio_Empresa" value="0" checked="checked"/></center></div>
											<div class="col-xs-2 col-md-2" ><center><input type="radio" name="Radio_Empresa" value="1"/></center></div>						
										</div>

										<div class="col-xs-12 col-md-12" style="margin-top:10px" >
											<div class="col-xs-8 col-md-8" ><b>Data Inicial:</b> <?= date_create($estagio['Data_Inicio'])->format("d/m/Y");?></div>
											<div class="col-xs-2 col-md-2" ><center><input type="radio" name="Radio_Data_Inicio" value="0" checked="checked"/></center></div>
											<div class="col-xs-2 col-md-2" ><center><input type="radio" name="Radio_Data_Inicio" value="1"/></center></div>
										</div>

										<div class="col-xs-12 col-md-12" style="margin-top:10px" >
											<div class="col-xs-8 col-md-8" ><b>Data Final:</b> <?= date_create($estagio['Data_Fim'])->format("d/m/Y") ;?></div>
											<div class="col-xs-2 col-md-2" ><center><input type="radio" name="Radio_Data_Fim" value="0" checked="checked"/></center></div>
											<div class="col-xs-2 col-md-2" ><center><input type="radio" name="Radio_Data_Fim" value="1"/></center></div>
										</div>
										
										<div class="col-xs-12 col-md-12" style="margin-top:10px" >
											<div class="col-xs-8 col-md-8" ><b>Área:</b> <?= $NomeArea[0]["Nome"];?></div>
											<div class="col-xs-2 col-md-2" ><center><input type="radio" name="Radio_Area" value="0" checked="checked"/></center></div>
											<div class="col-xs-2 col-md-2" ><center><input type="radio" name="Radio_Area" value="1"/></center></div>
										</div>


								</div>


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

					<div class="row row_avalia" id="planoEstagio" hidden> 

						<input hidden name="erros"		id="erros" 		value="0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0"> <!-- input default dos erros, pode ser feito no bd -->
						<input hidden name="errosEstagio"		id="errosEstagio" value="0;0;0;0;0;0;0"> <!-- input default dos erros, pode ser feito no bd -->
						<input hidden name="horarios" 	id="horarios" 	value=""> <!-- array de horarios -->
						<input hidden name="cargaTot"   id="cargaTot" 	value="0"> <!-- soma total de horas -->
							
							
						<div class="col-xs-1 col-md-1" >
							 <span id="PlanoBotaoEsquerda"  class="glyphicon glyphicon-chevron-left " aria-hidden="true"></span>
						</div>

						<div class="col-xs-10 col-md-10" >
							<div class="col-xs-12 col-md-12" >
								<center><b>Plano de Atividades</b></center>
							</div>
						
										
								<div class="col-xs-12 col-md-12" style="margin-top:10px" >
									<div class="col-xs-10 col-md-8" ><b>Nome:</b> <?php echo $aluno["Nome_Completo"];?></div>
									<div class="col-xs-1 col-md-2" ><b>Correto</b></div>
									<div class="col-xs-1 col-md-2" ><b>Incorreto</b></div>								
								</div>

								<div class="col-xs-12 col-md-12" style="margin-top:10px" >
									<div class="col-xs-10 col-md-8" ><b>Local:</b> <?php echo $planoRow["Local"];?></div>
									<div class="col-xs-1 col-md-2" ><center><input type="radio" name="local" value="0" checked="checked"/></center></div>
									<div class="col-xs-1 col-md-2" ><center><input type="radio" name="local" value="1"/></center></div>
								</div>
								
								<div class="col-xs-12 col-md-12" style="margin-top:10px" >
									<div class="col-xs-10 col-md-8" ><b>Data/Hora:</b> <?php echo date_create($planoRow["Hora_Do_Envio"])->format("d/m/y H:i") ;?></div>
									<div class="col-xs-1 col-md-2" ><center><input type="radio" name="data" value="0" checked="checked"/></center></div>
									<div class="col-xs-1 col-md-2" ><center><input type="radio" name="data" value="1"/></center></div>
								</div>

								<div class="col-xs-12 col-md-12" style="margin-top:10px" >
									<div class="col-xs-10 col-md-8" ><b>Carga Horária:</b> <?php echo $planoRow["Carga_Horaria"];?></div>
									<div class="col-xs-1 col-md-2" ><center><input type="radio" name="carga-h" value="0" checked="checked"/></center></div>
									<div class="col-xs-1 col-md-2" ><center><input type="radio" name="carga-h" value="1"/></center></div>
								</div>

								<div class="col-xs-12 col-md-12" style="margin-top:10px" >
										<div class="col-xs-8 col-md-8" >						
											Segunda-Feira: <?php echo $horarios[0]!=''?$horarios[0]:"__:__";?> até <?php echo $horarios[1]!=''?$horarios[1]:"__:__";?><br> 
										</div>
										<div class="col-xs-2 col-md-2" >
											<center><input type="radio" name="segunda" value="0" checked="checked" /><br></center>
										</div>
										<div class="col-xs-2 col-md-2" >
											<center><input type="radio" name="segunda" value="1" /><br></center>
										</div>
																				
										<div class="col-xs-8 col-md-8" >
											Terça-Feira: <?php echo $horarios[2]!=''?$horarios[2]:"__:__";?> até <?php echo $horarios[3]!=''?$horarios[3]:"__:__";?><br> 
										</div>
										<div class="col-xs-2 col-md-2" >
											<center><input type="radio" name="terca"   value="0" checked="checked" /><br></center>
										</div>
										<div class="col-xs-2 col-md-2" >
											<center><input type="radio" name="terca"   value="1" /><br></center>
										</div>

										<div class="col-xs-8 col-md-8" >
											Quarta-Feira: <?php echo $horarios[4]!=''?$horarios[4]:"__:__";?> até <?php echo $horarios[5]!=''?$horarios[5]:"__:__";?><br>  
										</div>
										<div class="col-xs-2 col-md-2" >
											<center><input type="radio" name="quarta"  value="0" checked="checked" /><br></center>
										</div>
										<div class="col-xs-2 col-md-2" >
											<center><input type="radio" name="quarta"  value="1" /><br></center>
										</div>
										
										<div class="col-xs-8 col-md-8" >										
											Quinta-Feira: <?php echo $horarios[6]!=''?$horarios[6]:"__:__";?> até <?php echo $horarios[7]!=''?$horarios[7]:"__:__";?><br>  
										</div>
										<div class="col-xs-2 col-md-2" >
											<center><input type="radio" name="quinta"  value="0" checked="checked" /><br></center>
										</div>
										<div class="col-xs-2 col-md-2" >
											<center><input type="radio" name="quinta"  value="1" /><br></center>
										</div>

										<div class="col-xs-8 col-md-8" >
											Sexta-Feira: <?php echo $horarios[8]!=''?$horarios[8]:"__:__";?> até <?php echo $horarios[9]!=''?$horarios[9]:"__:__";?><br>  
										</div>
										<div class="col-xs-2 col-md-2" >
											<center><input type="radio" name="sexta"   value="0" checked="checked" /><br></center>
										</div>
										<div class="col-xs-2 col-md-2" >
											<center><input type="radio" name="sexta"   value="1" /><br></center>
										</div>

										<div class="col-xs-8 col-md-8" >
											Sabado: <?php echo $horarios[10]!=''?$horarios[10]:"__:__";?> até <?php echo $horarios[11]!=''?$horarios[11]:"__:__";?><br>
										</div>
										<div class="col-xs-2 col-md-2" >
											<center><input type="radio" name="sabado"  value="0" checked="checked" /><br></center>
										</div>
										<div class="col-xs-2 col-md-2" >
											<center><input type="radio" name="sabado"  value="1" /><br></center>
										</div>
								</div>

								
									<div class="col-xs-12 col-md-12" style="margin-top:10px" >
										<b>Descrição:</b>
									</div>

									<div class="col-xs-12 col-md-12" style="border-width:1px;border-style: solid;border-color:#777;" >
										<p><?php echo $planoRow["Descricao"];?></p>
									</div>

									<div class="col-xs-12 col-md-12" style="margin-top:10px" >

										<div class="col-xs-3 col-md-3" >
										</div>
										
										<div class="col-xs-3 col-md-3" >
											<center><b> Correto </b></center>
										</div>
										
										<div class="col-xs-3 col-md-3" >
										<center><b> Incorreto </b></center>
										</div>

										<div class="col-xs-3 col-md-3" >
										</div>
									</div>

									<div class="col-xs-12 col-md-12" style="margin-top:10px" >

										<div class="col-xs-3 col-md-3" >
										</div>
										
										<div class="col-xs-3 col-md-3" >
											<center><input type="radio" name="descricao" value="0" checked="checked" /></center>
										</div>
										
										<div class="col-xs-3 col-md-3" >
											<center><input type="radio" name="descricao" value="1" /></center>
										</div>

										<div class="col-xs-3 col-md-3" >
										</div>
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

							<div class="row row_avalia" id="termoEstagio" hidden>
								<div class="col-xs-1 col-md-1" >
									 <span id="TermoBotaoEsquerda"  class="glyphicon glyphicon-chevron-left " aria-hidden="true"></span>
								</div>

								<div class="col-xs-10 col-md-10" >

									 
									<div class="col-xs-12 col-md-12" >
										<center><b>Termo de Compromisso</b></center>
									</div>

									<div class="col-xs-12 col-md-12" >

										<table class="table doca">
			    	   						<thead>
			    	   							<tr>
				    	   							<td>Nome</td>
				    	   							<td>Documento</td>
			    	   							</tr>
			    	   						</thead>

			    	   						<tbody>
			    	   							<tr>
				    	   							<td><?= $termo["Nome_Termo"]?></td>
				    	   							<td><a href=<?= "mostra-arquivo.php?idEstagio=".$idEstagio."&tipo-documento=termo" ?> target="_blank">Visualizar</a></td>
			    	   							</tr>
			    	   						</tbody>
			    	   					</table>

				    	   			</div>
									<div class="col-xs-12 col-md-12" >

										<div class="col-xs-3 col-md-3" >
											</div>
											
											<div class="col-xs-3 col-md-3" >
												<center><b> Correto </b></center>
											</div>
											
											<div class="col-xs-3 col-md-3" >
											<center><b> Incorreto </b></center>
											</div>

											<div class="col-xs-3 col-md-3" >
											</div>
										</div>

										<div class="col-xs-12 col-md-12" >

											<div class="col-xs-3 col-md-3" >
											</div>
											
											<div class="col-xs-3 col-md-3" >
												<center><input type="radio" name="Radio_Termo" value="0" checked="checked" /></center>
											</div>
											
											<div class="col-xs-3 col-md-3" >
												<center><input type="radio" name="Radio_Termo" value="1" /></center>
											</div>

											<div class="col-xs-3 col-md-3" >
											</div>
									</div>
								</div>
							</div>

							<div class="row row_avalia" id="comentariosReprova" hidden>	
				        	<!--  Info estagio painel de erro  -->		
				        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
				        				<span><b>Tipo do estágio:</b><br></span>
				        				<textarea id="tipoEstagioErro" name="tipoEstagioErro" style="resize:none;width:100%;"  ></textarea>
				        			</div>

				        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
				        				<span><b>Supervisor:</b><br></span>
				        				<textarea id="supervisorErro" name="supervisorErro" style="resize:none;width:100%;"  ></textarea>
				        			</div>

				        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
				        				<span><b>Empresa:</b><br></span>
				        				<textarea id="empresaErro" name="empresaErro" style="resize:none;width:100%;"  ></textarea>
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
				        				<span><b>Área:</b><br></span>
				        				<textarea id="areaErro" name="areaErro" style="resize:none;width:100%;"  ></textarea>
				        			</div>
				        	<!--  Info estagio painel de erro  -->
				        	
				        	<!--  plano de atividades de um estagio painel de erro  -->
				        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
				        				<span><b>Local:</b><br></span>
				        				<textarea id="LocalErro" name="LocalErro" style="resize:none;width:100%;"  ></textarea>
				        			</div>

				        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
				      		  			<span><b>Data de entrega:</b><br></span>
				      		  			<textarea id="dataEntregaErro" name="dataEntregaErro" style="resize:none;width:100%;"  ></textarea>
				        			</div>
				        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
				        				<span><b>Carga Horária:</b><br></span>
				        				<textarea id="cargaHorariaErro" name="cargaHorariaErro" style="resize:none;width:100%;"  ></textarea>
				        			</div>
				        			
				        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
				        				<span><b>Horários:</b><br></span>
				      		  			<textarea id="horariosErro" name="horariosErro" style="resize:none;width:100%;"  ></textarea>
				        			</div>	

				        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
				        				<span><b>Descrição do Estágio:</b><br></span>
				      		  			<textarea id="comentariosErro" name="comentariosErro" style="resize:none;width:100%;"></textarea>
				        			</div>

				        			<div class="col-xs-12 col-md-12" style="margin-top:10px;display:none;">
				        				<span><b>Termo de compromisso:</b><br></span>
				      		  			<textarea id="termoErro" name="termoErro" style="resize:none;width:100%;"></textarea>
				        			</div>

				        			<div id="semErrosWarning" class="col-xs-12 col-md-12 hidden" style="margin-top:10px;align:center">
										<span><b>Deseja realmente reprovar? Nenhum campo marcado como errado</b><br></span>
									</div>

							</div>


							<div class="row row_avalia" id="aprova" hidden >

								<div id="semErrosWarning" class="col-xs-12 col-md-12" style="margin-top:10px;align:center">
										
									<span ><b>Deseja realmente Aprovar?</b><br></span>
								</div>
									

								<!--
			        			<div class="col-xs-2 col-md-2" style="margin-top:10px">
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
								<div class="col-xs-1 col-md-1" style="margin-top:10px">
								</div>
				    			<div class="col-xs-2 col-md-2" style="margin-top:10px">
									<center><span><b>Ótimo</b><br></span>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assiduidade" value="0" checked="checked" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Disciplina" value="0" checked="checked" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Cooperacao" value="0" checked="checked" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Producao" value="0" checked="checked" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Iniciativa" value="0" checked="checked" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assimilacao" value="0" checked="checked" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Conhecimentos" value="0" checked="checked" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Responsabilidade" value="0" checked="checked" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Dedicacao" value="0" checked="checked" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Organizacao" value="0" checked="checked" /><br></center>		
								</div>
				    			<div class="col-xs-2 col-md-2" style="margin-top:10px">
									<center><span><b>Bom</b><br></span>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assiduidade" value="1" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Disciplina" value="1" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Cooperacao" value="1" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Producao" value="1" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Iniciativa" value="1" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assimilacao" value="1" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Conhecimentos" value="1" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Responsabilidade" value="1" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Dedicacao" value="1" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Organizacao" value="1" /><br></center>		
								</div>
				    			<div class="col-xs-2 col-md-2" style="margin-top:10px">
									<center><span><b>Ruim</b><br></span>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assiduidade" value="2" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Disciplina" value="2" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Cooperacao" value="2" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Producao" value="2" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Iniciativa" value="2" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assimilacao" value="2" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Conhecimentos" value="2" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Responsabilidade" value="2" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Dedicacao" value="2" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Organizacao" value="2" /><br></center>		
								</div>
				    			<div class="col-xs-2 col-md-2" style="margin-top:10px">
									<center><span><b>Insuficiente</b><br></span>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assiduidade" value="3" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Disciplina" value="3" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Cooperacao" value="3" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Producao" value="3" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Iniciativa" value="3" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Assimilacao" value="3" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Conhecimentos" value="3" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Responsabilidade" value="3" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Dedicacao" value="3" /><br>
									<input type="radio" style="margin-bottom: 3px;width: 16px;" class="radiocheck" name="Organizacao" value="3" /><br></center>		
								</div>

			        			<div class="col-xs-12 col-md-12" style="margin-top:10px;">
			        				<span><b>Observações:</b><br></span>
			      		  			<textarea id="Observacoes" name="Observacoes" style="resize:none;width:100%;"></textarea>
			        			</div>	-->



							</div>
								
								<div style=" display: table; margin: 20px auto">
   								<button  name="botaoAprova"  id="botaoAprova"   class="btn btn-primary"style="margin-left: 20px;">Aceitar</button>
   								<button  name="botaoReprova" id="botaoReprova"  class="btn btn-danger" style="margin-left: 20px;">Recusar</button>
   								<button  name="botaoCancela" id="botaoCancela" 	class="btn btn-danger" style="margin-left: 20px; display: none;" >Cancelar</button>

						</form>