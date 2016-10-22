<?php

		require_once("conecta.php");
        require_once("cabecalho.php");
		
		require_once("../../Action/banco-estagios.php");
        require_once("../../Action/funcoes-de-controle.php");
		require_once("../../Action/banco-plano-de-atividades.php");
		require_once("../../Action/banco-relatorios.php");
		require_once("../../Action/banco-termo-de-compromisso.php");
		require_once("../../Action/banco-declaracao-final.php");
        require_once("../../Action/banco-termo-aditivo.php");
	?>

	<link href = "css/documentos-estagio.css" rel = "stylesheet" >
	<script src="js/jquery.maskedinput.js"></script>
	<script src="js/documentos-estagio.js"></script>

	<?php
	//Verifica se todas as variaves foram passadas corretamente
	if(!isset($_GET['idEstagio']) || empty($_GET['idEstagio'])){
		erroPadrao("Estágio não definido.");
	}


	//verifica se o estagio passado realmente pertence ao aluno

	$valida_estagio = ListaEstagios($mysqli, $_SESSION["id"], "aluno", $_GET["idEstagio"]);


	$datetime1 = date_create($valida_estagio[0]['Data_Fim']);
    $datetime2 = date_create(date('Y/m/d', time()));
    
    $tempoRestante = date_diff($datetime1, $datetime2);

	// Recebe um inteiro correspondendo a que estado esta do estagio
	$estado_estagio = EstadoEstagio($mysqli, $_GET["idEstagio"]);

	if( count($valida_estagio) == 0){
		erroPadrao("Estágio não definido");
	}

	//recupera documentos referentes ao estagio
	$planos 	= ListaPlanoDeAtividades($mysqli, $_GET["idEstagio"]);
	$relatorios = ListaRelatorio($mysqli, $_GET['idEstagio']);
	$termo 		= ListaTermoDeCompromisso($mysqli, false, $_GET['idEstagio']);	
	$declaracao = ListaDeclaracaoFinal($mysqli, false, $_GET['idEstagio']);
    $termosAditivos = ListaTermosAditivos($mysqli, $_GET['idEstagio']);
    $comentariosTermoAditivo = ListaComentariosTermos($mysqli, $_GET['idEstagio']);

    if($termosAditivos===false){
        $_SESSION['Failed'] = "Erro ao acessor termos aditivos";
        header("Location:users.php");

    }


	$stringStatus = array(
		"alterar" 	=> "Editável",
		"supervisor"=> "Esperando aprovação do supervisor",
		"presidente"=> "Esperando aprovação do Presidente da COE",
		"aprovado"	=> "Aprovado",
		"entrega" => "Entrega de documentos"
	);
	?>

	<div id="ArquivosNav">
		<ul class="nav nav-tabs" >
			<?php echo ($estado_estagio==1)? '<li class="active">':'<li>';?><a href="#planos" data-toggle="tab"><span class="glyphicon  glyphicon-file" style="top:2px;"></span> Plano de Atividades</a></li>
			<?php echo ($estado_estagio==2)? '<li class="active">':'<li>';?><a href="#relatorios" data-toggle="tab"><span class="glyphicon  glyphicon-th-list" style="top:2px;"></span> Relatórios</a></li>
			<?php echo ($estado_estagio==0)? '<li class="active">':'<li>';?><a href="#termo" data-toggle="tab"><span class="glyphicon glyphicon-pencil" style="top:2px;"></span> Termo de Compromisso</a></li>
			<?php echo ($estado_estagio==4)? '<li class="active">':'<li>';?><a href="#declaracaoFinal" data-toggle="tab"><span class="glyphicon glyphicon-list-alt" style="top:2px;"></span> Declaração Final</a></li>
            <li><a href="#termoAditivo" data-toggle="tab">Termos Aditivos</a></li>
        </ul>
	</div>
	<!-- <div id="corpo" style="margin-top: 70px; height: 100%;"> -->
	<div id="corpo" style="margin-top: 10px; height: 100%;">
		<div class="tab-content">
    	   	<div class="tab-pane <?php echo ($estado_estagio==1)? 'active':'';?>" id="planos">
    	   		<div class="table-responsive">
    	   			<?php  
    	   			if($estado_estagio>=1){
	    	   			if(count($planos) > 0){ ?>
							<table class="table table-hover">
								<thead>
									<tr>
										<td>Dia</td>
										<td>Hora</td>
										<td>Status</td>
										<td>Impressão</td>
										<td><center>Excluir</center></td>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($planos as $row){
										$date = DateTime::createFromFormat("Y-m-d H:i:s" ,$row['Hora_Do_Envio']);
										$dia  = $date->format("d/m/Y");
										$hora = $date->format("H:i:s");
										?>

										<tr name="plano" style="cursor: pointer;" <?= ($row['Status'] == "alterar")?'data-toggle="modal" data-target="#Modal"': "" ?> value="<?= $row['Id_Plano_De_Atividades']?>">
											<td><?php echo $dia  ?></td>						
											<td><?php echo $hora ?></td>
											<td><?php echo $stringStatus[$row['Status']]?></td>
											<td>
												<?php if(strcmp($row['Status'],"aprovado")==0||strcmp($row['Status'],"entrega")==0){ ?>
													<form method="post" style="margin-bottom: 0px;" target="_blank" action="imprime_plano_de_atividades.php">
														<input hidden name="plano" value=<?php echo "\"".$row['Id_Plano_De_Atividades']."\""?>/>
														<input hidden name="idEstagio" value=<?php echo "\"".$_GET['idEstagio']."\"" ?>/>
														<button type="submit" class="btn btn-primary" >Imprimir</button>
													</form>
												<?php
												}
												else{ ?>
													<button type="submit" class="btn btn-primary disabled" >Imprimir</button>
												<?php } ?>
											</td>
											<td><center>
												<form method="post" style="margin-bottom: 0px;" action="Controllers/Controller-remove-plano-de-atividades.php">
														<input hidden name="plano" value=<?php echo "\"".$row['Id_Plano_De_Atividades']."\""?>/>
														<input hidden name="idEstagio" value=<?php echo "\"".$_GET['idEstagio']."\"" ?>/>
													<button type="submit" id="removerPlano" style="padding: 9px 10px;" class="btn btn-warning removerItem"><span class="glyphicon glyphicon-trash" style="top:2px;"></span></button>
												</form></center>
											</td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						<?php 
						}else{
						 	echo "<div class='alert alert-info text-center' style='width: 90%; margin-left: auto; margin-right: auto;'>
						 	Nenhum plano de atividades adicionado ainda.
						 	</div>";
						}
					?>
    	   		</div>

                    <div class="novo-documento">
                        <button data-toggle="modal" data-target="#Modal" id="BotaoNovoPlano" class="btn btn-success">Adcionar Plano de Atividades </button>
                    </div>

    	   		<?php 

    	   			}
					else{
						 	echo "
						 	</div>
						 	<div class='alert alert-info text-center' style='width: 80%; margin-left: auto; margin-right: auto;'>
						 	Há outros documentos a serem entregues antes desse.
						 	</div>";
					}

    	   		?>
    	   	</div>


    	   	<div class="tab-pane <?php echo ($estado_estagio==2)? 'active':'';?>" id="relatorios">
    	   		<div class="table-responsive">
    	   		<?php
    	   		if($estado_estagio>=2){
	    	   				if(count($relatorios) > 0){ ?>

							<table class="table table-hover">
								<thead>
									<tr>
										<td>Dia</td>
										<td>Hora</td>
										<td>Status</td>
										<td>Impressão</td>
									</tr>
								</thead>

								<tbody>
									<?php foreach($relatorios as $row){
										$date = DateTime::createFromFormat("Y-m-d H:i:s", $row['Hora_Do_Envio']);
										$dia  = $date->format("d/m/Y");
										$hora = $date->format("H:i:s");
										?>

										<tr name="relatorio" style="cursor: pointer;" <?= ($row['Status'] == "alterar")?'data-toggle="modal" data-target="#Modal"': "" ?> value="<?= $row['Id_Relatorio']?>">
											<td><?php echo $dia  ?></td>
											<td><?php echo $hora ?></td>
											<td><?php echo $stringStatus[$row['Status']]?></td>
											<td>
												<?php if(strcmp($row['Status'],"aprovado")==0||strcmp($row['Status'],"entrega")==0){ ?>
													<form method="post" style="margin-bottom: 0px;" target="_blank" action="imprime_relatorio_atividades.php">
														<input hidden name="relatorio" value=<?php echo "\"".$row['Id_Relatorio']."\""?>/>
														<input hidden name="idEstagio" value=<?php echo "\"".$_GET['idEstagio']."\"" ?>/>
														<button type="submit" class="btn btn-primary" >Imprimir</button>
													</form>
												<?php
												}
												else{ ?>
													<button type="submit" class="btn btn-primary disabled" >Imprimir</button>
												<?php } ?>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						<?php 
						} 
					 	else{
						 	echo "<div class='alert alert-info text-center' style='width: 90%; margin-left: auto; margin-right: auto;'>
						 	Nenhum relátorio adicionado ainda.
						 	</div>";
					 	}

					?>
    	   		</div>

	    	   		<div class="novo-documento">
						<button data-toggle="modal" data-target="#Modal" id="BotaoNovoRelatorio" class="btn btn-success">Adcionar Relatórios</button>	
					</div>
				<?php
				}
				else{
						 	echo "
						 	</div>
						 	<div class='alert alert-info text-center' style='width: 80%; margin-left: auto; margin-right: auto;'>
						 	Há outros documentos a serem entregues antes desse.
						 	</div>";
				}


				?>

    	   	</div>
    	
    	   	<div class="tab-pane <?php echo ($estado_estagio==0)? 'active':'';?>" id="termo" style="width:80%;margin-left: auto; margin-right: auto;">
    	   		<?php 
    	   			if($estado_estagio>=0){
	    	   			if(count($termo) == 1){
	    	   				foreach ($termo as $t) { ?>
	    	   					<div class="table-responsive">
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
			    	   							<td><?= $t["Nome_Termo"]?></td>
			    	   							<td><?= $stringStatus[$t["Status_Termo"]] ?></td>
			    	   							<td><a href=<?= "mostra-arquivo.php?idEstagio=".$_GET['idEstagio']."&tipo-documento=termo" ?> target="_blank">Visualizar</a></td>
		    	   							</tr>
		    	   							<?php if($t["Status_Termo"] == "alterar"){ ?>
		    	   								<tr><td colspan="3">O Comentário vai aqui</td></tr>
		    	   								<tr colspan="3"><td colspan="3">
		    	   									Alterar Arquivo:		    	   									<br>
		    	   									<form method="post" action=<?= "Controllers/Controller-documentos-estagio.php?idEstagio=".$_GET['idEstagio']?> enctype="multipart/form-data" class="form-inline">
							    	   					<div class="form-group">
															<input type="hidden" name="MAX_FILE_SIZE" value="16777216">
															<input name="termo_arquivo" type="file" id="termo_arquivo">
														</div>
														<div class="form-group">
															<input name="termo_update" type="submit" class="box" id="termo_up" value="Enviar">
														</div>
													</form>
		    	   								</td></tr>
		    	   							<?php } ?>
		    	   						</tbody>
		    	   					</table>
	    	   					</div>
	    	   				<?php } ?>

	    	   				
	    	   			
	    	   			<?php }

	    	   			else{?>
	    	   			<div class="table-responsive">
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
		    	   								<td>Ainda não enviado</td>
		    	   								<form method="post" action=<?= "Controllers/Controller-documentos-estagio.php?idEstagio=".$_GET['idEstagio']?> enctype="multipart/form-data" class="form-inline">
						    	   					<td>
														<input type="hidden" name="MAX_FILE_SIZE" value="16777216">
														<input name="termo_arquivo" type="file" id="termo_arquivo">
													</td>
													<td>
														<input name="termo_up" type="submit" class="box" id="termo_up" value="Enviar">
													</td>
												</form>
		    	   							</tr>
		    	   							<tr><td></td></tr>
		    	   						</tbody>
		    	   					</table>
	    	   					</div>
	    	   			<?php }
	    	   	}
	   			else{
	   				echo 	"<div class='alert alert-info text-center' style='width: 90% margin-left: auto; margin-right: auto;'>
						 		Há outros documentos a serem entregues antes desse.
					 		</div>";
	   			}
	   		?>  	   		
    	   	</div>

    	   	<div class="tab-pane <?php echo ($estado_estagio==4)? 'active':'';?>" id="declaracaoFinal" style="width:80%;margin-left: auto; margin-right: auto;">
    	   		<?php 
    	   			if($tempoRestante->days<=30||$estado_estagio>=4){
	    	   			if(count($declaracao) == 1){
	    	   				foreach ($declaracao as $d) { ?>
	    	   					<div class="table-responsive">
		    	   					<table class="table table-hover doca">
		    	   						<thead>
		    	   							<tr>
			    	   							<td>Nome</td>
			    	   							<td>Status</td>
			    	   							<td>Documento</td>
		    	   							</tr>
		    	   						</thead>

		    	   						<tbody>
		    	   							<tr>
			    	   							<td><?= $d["Nome_Declaracao"]?></td>
			    	   							<?php if($d["Status_Declaracao"] == "alterar"){ 
			    	   								echo "<td>Rejeitado</td>";
			    	   							}else{ 
			    	   								echo "<td>".$stringStatus[$d["Status_Declaracao"]]."</td>";
			    	   							}
			    	   							?>
			    	   							<td><a href=<?= "mostra-arquivo.php?idEstagio=".$_GET['idEstagio']."&tipo-documento=declaracao" ?> target="_blank">Visualizar</a></td>
		    	   							
		    	   							<?php if($d["Status_Declaracao"] == "alterar"){ ?>		    	   			<td>					
		    	   									Alterar Arquivo:<span id="3" class="glyphicon  glyphicon-comment" value="<?= $d['Comentario'] ?>" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span><br>
		    	   									<form method="post" action=<?= "Controllers/Controller-documentos-estagio.php?idEstagio=".$_GET['idEstagio']?> enctype="multipart/form-data" class="form-inline">
									    	   			<div class="form-group">
															<input type="hidden" name="MAX_FILE_SIZE" value="16777216">
															<input name="declaracao_arquivo" type="file" id="declaracao_arquivo">
														</div>
														<div class="form-group">
															<input name="declaracao_update" type="submit" class="box" id="declaracao_up" value="Enviar">
														</div>
													</form>
		    	   								</td>
		    	   							</tr>
		    	   							<?php } ?>
		    	   						</tbody>
		    	   					</table>
	    	   					</div>
	    	   				<?php } ?>
	    	   				
	    	   			<?php }

	    	   			else{?>
	    	   					<div class="table-responsive">
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
		    	   								<td>Ainda não enviado</td>
		    	   								<form method="post" action=<?= "Controllers/Controller-documentos-estagio.php?idEstagio=".$_GET['idEstagio']?> enctype="multipart/form-data" class="form-inline">
													<td>
														<input type="hidden" name="MAX_FILE_SIZE" value="16777216">
														<input name="declaracao_arquivo" type="file" id="declaracao_arquivo">
													</td>
													<td>
														<input name="declaracao_up" type="submit" class="box" id="declaracao_up" value="Enviar">
													</td>
												</form>
		    	   							</tr>
		    	   							<tr><td colspan="3">
		    	   								
		    	   							</td></tr>
		    	   							
		    	   						</tbody>
		    	   					</table>
	    	   					</div>
							
	    	   			<?php 
	    	   			}

    	   		}
	   			else{
   					echo 	"<div class='alert alert-info text-center' style='width: 90% margin-left: auto; margin-right: auto;'>
						 		Há outros documentos a serem entregues antes desse.
					 		</div>";
	   				
	   			}

    	   		?>   	   		
    	   	</div>

            <div class="tab-pane" id="termoAditivo" style="width:80%;margin-left: auto; margin-right: auto;">

            <?php if($estado_estagio>4||$tempoRestante->days<=30&&$estado_estagio!=4){ ?>	
                <?php if(count($termosAditivos) > 0){ ?>
                    <div class="table-responsive" >

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Nome documento</td>
                                    <td>Documento</td>
                                    <td>Data final</td>
                                    <td>Data de prorrogação</td>
                                    <td>Status</td>
                                </tr>
                            </thead>

                            <tbody>
                            <?php


                            foreach($termosAditivos as $d){

                                if( $d["Status_TermoAditivo"]=="alterar" )
                                    echo "<tr class=\"termoAditivoRow\" value=".$d['Id_TermoAditivo']." comentario=".$comentariosTermoAditivo[$d['Id_TermoAditivo']]." style=\"cursor:pointer\" >";
                                else
                                    echo '<tr>';
                                ?>

                                        <td><?= $d["Nome_TermoAditivo"]?></td>
                                        <td><a href=<?= "mostra-arquivo.php?idEstagio=".$d['Id_Estagio']."&tipo-documento=termo" ?> target="_blank">visualizar</a></td>
                                        <td><?= $d["Data_Fim"]?></td>
                                        <td class="dataP" ><?= $d["Data_Prorrogacao"]?></td>
                                        <td>
                                        <?php
                                        echo $stringStatus[$d['Status_TermoAditivo']];

                                            /*if($d["Status_TermoAditivo"]=="supervisor"|| $d["Status_TermoAditivo"]=="presidente" ){
                                                echo "Esperando aprovação";
                                            }
                                            else if( $d["Status_TermoAditivo"]=="aprovado" ){
                                                echo "Aprovado";
                                            }else{
                                                echo "Rejeitado";
                                            }*/
                                            ?>
                                        </td>


                                </tr>
                                <?php

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
                                            <h4 class="modal-title">Editar Termo Aditivo</h4>
                                        </div>

                                        <form action="Controllers/Controller-termo-aditivo.php"  method="post" enctype="multipart/form-data" >
                                            <div class="modal-body">
                                                <div class="col-xs-12 col-md-12" >

                                                    <div class="col-xs-6 col-md-6 center" >
                                                        <strong>Termo de Compromisso</strong>


                                                        <input type="hidden" name="MAX_FILE_SIZE" value="16777216">
                                                        <input type="file"  name="termo_aditivo_arquivo" id="termo_aditivo_arquivo">


                                                    </div>
                                                    <div class="col-xs-6 col-md-6 center" >

                                                        <strong>Data:</strong></br>
                                                        <input name="dataTA" id="termo_aditivo_data" class="dataTA" required >
                                                        <input type="hidden" name="idTermoAditivo" id="idTermoAditivo" value="" >

                                                    </div>

                                                    <div class="col-xs-12 col-md-12 center" >
                                                        <label for="ComentarioTA" display="block">Cometário:</label>
                                                        <textarea class="center" rows="5" cols="52" id="ComentarioTA" style="width:100%;resize: none" disabled="disabled" ></textarea>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <!-- Botoes-->
                                                <span id="TAModal-button">
                                                    <input   type="submit" id="botaoTAModal" name="botaoTAModal" value="Enviar"  class="btn btn-success center" style="margin-left: 20px;">
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </table>
                    </div>

                <?php
            	}
                else{ ?>
                    <div class="alert alert-info text-center" style="width: 90%; margin-left: auto; margin-right: auto;">
                        Nenhum Termo aditivo pendente.
                    </div>
                <?php } ?>
                    <div class="novo-documento">
                        <button data-toggle="modal" data-target="#TAModalNovo" id="BotaoNovoTermoAditivo" class="btn btn-success">Adcionar Termo aditivo </button>
                    </div>
                <?php
                }else{
	
				 	echo ($estado_estagio==4)? "<div class='alert alert-info text-center' style='width: 90% margin-left: auto; margin-right: auto;'>
						 		Não é possível mais enviar este documento.
					 		</div>":"<div class='alert alert-info text-center' style='width: 90% margin-left: auto; margin-right: auto;'>
						 		Há outros documentos a serem entregues antes desse.
				 		</div>";
	   			}?>

                <!-- Modal -->
                <div class="modal fade" id="TAModalNovo" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <!-- Header-->
                                <button id="TAModalNovo-c" class="close" type="button" data-dismiss="modal" aria-label="close" >&times;</button>
                                <h4 class="modal-title">Novo Termo Aditivo</h4>
                            </div>

                            <form action="Controllers/Controller-termo-aditivo.php"  method="post" enctype="multipart/form-data" >
                                <div class="modal-body">
                                    <div class="col-xs-12 col-md-12" >

                                        <div class="col-xs-6 col-md-6 center" >

                                                <strong>Termo Aditivo:</strong>


                                                <input type="hidden" name="MAX_FILE_SIZE" value="16777216">
                                                <input type="file"  name="novo_termo_aditivo_arquivo" id="novo_termo_aditivo_arquivo">
                                                <input type="hidden" name="idEstagio" id="idEstagio" value="<?= $_GET["idEstagio"] ?>" >

                                        </div>

                                        <div class="col-xs-6 col-md-6 center" >

                                                <strong>Data:</strong></br>
                                                <input name="dataTA" class="dataTA" required >

                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!-- Botoes-->
                                                <span id="TAModal-button">
                                                    <input   type="submit" id="botaoTAModalNovo" name="botaoTAModalNovo" value="Enviar"  class="btn btn-success center" style="margin-left: 20px;">
                                                </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

    	</div>
    	<?php
	    //<div class="modal fade bs-example-modal-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-focus-on="input:first" aria-hidden="true" width="90%">
	    ?>
	    <div class="modal fade bs-example-modal-lg" id="Modal" width="80%">
			<div class="modal-dialog">
			    <div class="modal-content">
				    <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
					        <h4 class="modal-title" id="myModalLabel"></h4>
				    </div>
				    <div class="modal-body" id="myModalBody">
				       
					</div>
				 </div>
			</div>
		</div>
	</div>

<?php require_once("rodape.php");?>