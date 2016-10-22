<script src="js/jquery.maskedinput.js"></script>
<script src="js/novo-estagio.js"></script>

<?php
	require_once "conecta.php";
	require_once("../../Action/banco-area.php");
	session_start();
?>


<form action="Controllers/Controller-novo-estagio.php" method="POST" enctype="multipart/form-data">  <!-- fomulario do novo estagio -->			       
					       
					        <div class="row" id="infoEstagio" ><!-- Informacoes do estagio -->	
		
		
								<div class="col-xs-11 col-md-11"  style="margin-top:10px"> 	
									
									<div class="col-xs-12 col-md-12" >
										<center><b>Informações do Estágio</b></center>
									</div>
									
									<div class="col-xs-12 col-md-6"  style="margin-top:10px"> <!-- Linha 1 -->
										<!-- Modalidade do estagio -->
										<center><b>Modalidade</b><br></center> 	
										<input type="radio" name="Modalidade" style="margin-left: 40px;margin-right: 6px;" value="1"> Obrigatório
										<input type="radio" name="Modalidade" style="margin-left: 10px;margin-right: 6px;" value="0" checked >Não Obrigatório<br><br>
										<!-- modalidade do estagio -->	

										<!-- Supervisor do estagio -->
										<center><b>Supervisor</b></center>
										<?php

											$prof = mysqli_query($mysqli,"SELECT * FROM usuarios WHERE Tipo = 'P'") or die(mysqli_error($mysqli)); ?> <!-- Recupera lista de supervisores -->

											<center><select name="Codigo_Supervisor" class="form-control" style="width:80%" ></center>
												<?php while($row = mysqli_fetch_assoc($prof))
												{
													?>
													<option value=<?php echo $row['Id_Usuario'];?>><?php echo $row['Nome_Completo'];?></option>
													<?php 
												}
												?>
											</select><br>
										<!-- Supervisor do estagio -->

										<!-- Empresa do estagio -->
										<center><b>Empresa</b></center>
										<?php
											$empresa = mysqli_query($mysqli,"SELECT * FROM empresa WHERE Ativa='1'" ) or die(mysql_error()); ?> <!-- Empresa do estagio -->

											<center><select name="Codigo_Empresa" class="form-control" style="width:80%" >
												<?php while($rowEmpresa = mysqli_fetch_assoc($empresa))
												{
													?>
													<option value=<?php echo $rowEmpresa['Id_Empresa'];?>><?php echo $rowEmpresa['Nome'];?></option>
													<?php 
												}
												?>
											</select></center>
										<!-- Empresa do estagio -->
									
									</div><!-- Linha 1 -->

									<div class="col-xs-12 col-md-6"  style="margin-top:10px"> <!-- Linha 2 -->
										<center><b>Área</b> <!-- Area -->
										<select name="Codigo_Area" class="form-control" style="width:80%" >
													<?php
													
													$areas = getAreasIdENomes($mysqli);

													foreach($areas as $elementoArea)
													{	


														?>
															<option value=<?php echo "\"".$elementoArea['Id_Area']."\"";?>> <?php echo $elementoArea['Nome'];?> </option>
														<?php 
													}
													?>
										</select><br>
										<b>Data Ínicio</b><br>
										<input type="text" name="dataInicial" id="dataInicial" style="line-height:1; padding:0;width:70%;height:5%;text-align: center;" /><br>
										<b>Data Final</b><br>	
										<input type="text" name="dataFinal" id="dataFinal" style="line-height:1; padding:0;width:70%;height:5%;text-align: center;" /></center>
									</div> <!-- Linha 2 -->
								</div>
								
								<div class="col-xs-1 col-md-1" >
									<span  class="glyphicon glyphicon-chevron-right " id="InfoBotaoDireita" style="vertical-align:middle" aria-hidden="true"></span>
								</div>

							</div><!-- Informacoes do estagio -->

						<div class="row" id="planoEstagio" hidden> <!-- Plano de atividades -->

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
									<b class="plano-titulo">Horário</b><br>
									<span class="plano-hora">Segunda-feira das</span><br>
									<span class="plano-hora">Terça-feira das</span><br>
									<span class="plano-hora">Quarta-feira das</span><br>
									<span class="plano-hora">Quinta-feira das</span><br>
									<span class="plano-hora">Sexta-feira das</span><br>
									<span class="plano-hora">Sábado das</span><br>
								</div> <!-- Texto das linhas -->

								<div class="col-xs-6 col-md-3" > <!-- coluna do meio -->
									<br>
									<div linha="1" align="center">
									<input type="text" horario="1" name="segunda1" id="segunda1"  class="plano-input"/>
									<span class="plano-hora" >às</span>
									<input type="text" horario="1" name="segunda2" id="segunda2"  class="plano-input"/><br>
									</div>  
									
									<div linha="1" align="center">
									<input type="text" horario="1" name="terca1" id="terca1"  class="plano-input"/>
									<span class="plano-hora" >às</span>
									<input type="text" horario="1" name="terca2" id="terca2" class="plano-input"/><br>
									</div> 
								
									<div linha="1" align="center">
									<input type="text" horario="1" name="quarta1" id="quarta1"  class="plano-input"/>
									<span class="plano-hora" >às</span>
									<input type="text" horario="1" name="quarta2" id="quarta2" class="plano-input"/><br>
									</div> 
								
									<div linha="1" align="center">
									<input type="text" horario="1" name="quinta1" id="quinta1" class="plano-input"/>
									<span class="plano-hora" >às</span>
									<input type="text" horario="1" name="quinta2" id="quinta2" class="plano-input"/><br>		
									</div> 
								
									<div linha="1" align="center">
									<input type="text" horario="1" name="sexta1" id="sexta1"  class="plano-input"/>
									<span class="plano-hora" >às</span>
									<input type="text" horario="1" name="sexta2" id="sexta2" class="plano-input"/><br>
									</div> 
								
									<div linha="1" align="center">
									<input type="text" horario="1" name="sabado1" id="sabado1"  class="plano-input"/>
									<span class="plano-hora" >às</span>
									<input type="text" horario="1" name="sabado2" id="sabado2"  class="plano-input"/><br>
									</div> 
								
								</div> <!-- coluna do meio -->


								<div class="col-xs-12 col-md-4"	> <!-- texto -->
									<b>Atividades a serem desenvoldidas</b><br>
									<textarea rows="7" cols="71" maxlength="497"  style="resize:none"  class=" status-box"  name="descricao" id="descricao"> </textarea>
									<p class="counter pull-right" style="padding-top:5px;padding-right:10px">497</p> <!-- caracteres restantes -->
								</div> <!-- texto -->

								<div class="col-xs-12 col-md-2"> <!-- coluna da esquerda -->				 
										<center><b>Local</b></center><input id="local" type="text" class="plano-local" name="local" > <br><br>
										<center><b>Carga horária</b></center><input type="text" class="plano-local" id="carga" name="carga" disabled="true" value=""><br><br>
										<center><b>Data</b></center><input type="text" class="plano-local" id="data" name="data" ><br><br>
								</div> <!-- coluna da esquerda -->
							</div>


							<div class="col-xs-1 col-md-1" >
								 <span  class="glyphicon glyphicon-chevron-right " id="PlanoBotaoDireita" style="vertical-align:middle" aria-hidden="true"></span>
							</div>

							</div><!-- Plano de atividades -->
							
							<div class="row" id="termoEstagio" hidden>
								<div class="col-xs-1 col-md-1" >
									 <span id="TermoBotaoEsquerda"  class="glyphicon glyphicon-chevron-left " aria-hidden="true"></span>
								</div>

								<div class="col-xs-10 col-md-10" >

									<div class="col-xs-12 col-md-12" >
										<center><b>Termo de Compromisso</b></center>
									</div>
									<div class="col-xs-12 col-md-12" >
										<input type="hidden" name="MAX_FILE_SIZE" value="16777216">
										<center><input name="termo_arquivo" type="file" id="termo_arquivo"></center>
									</div>

			    	   			</div>
							</div>
						</div>

									<button id="SalvarEstagio" class="btn btn-success">Salvar</button>
								
						</form>