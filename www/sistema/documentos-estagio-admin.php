<?php require_once("cabecalho.php"); ?>
	
	<?php
		require_once("conecta.php");
		require_once("../../Action/banco-estagios.php");
		require_once("../../Action/banco-plano-de-atividades.php");
		require_once("../../Action/banco-relatorios.php");
		require_once("../../Action/banco-termo-de-compromisso.php");
		require_once("../../Action/banco-declaracao-final.php");
        require_once("../../Action/banco-termo-aditivo.php");
	?>

	<link href = "css/documentos-estagio.css" rel = "stylesheet" >
	<script src="js/documentos-estagio-admin.js"></script>

	<?php
	//Verifica se todas as variaves foram passadas corretamente
	if(!isset($_GET['idEstagio']) || empty($_GET['idEstagio'])){
		erroPadrao("Estágio não definido.");
	}



	//verifica se o estagio passado realmente pertence ao aluno

    if($_SESSION['auto']=='P')
	    $valida_estagio = ListaEstagios($mysqli, $_SESSION["id"], "supervisor", $_GET["idEstagio"]);
    else
        $valida_estagio = ListaEstagios($mysqli, $_SESSION["id"], "presidente", $_GET["idEstagio"]);

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
		"aprovado"	=> "Aprovado"
	);
	?>

	<div id="ArquivosNav">
		<ul class="nav nav-tabs" >
			<li class="active"><a href="#planos" data-toggle="tab"><span class="glyphicon  glyphicon-file" style="top:2px;"></span> Plano de Atividades</a></li>
			<li><a href="#relatorios" data-toggle="tab"><span class="glyphicon  glyphicon-th-list" style="top:2px;"></span> Relatórios</a></li>
			<li><a href="#termoDeCompromisso" data-toggle="tab"><span class="glyphicon glyphicon-pencil" style="top:2px;"></span> Termo de Compromisso</a></li>
			<li><a href="#declaracaoFinal" data-toggle="tab"><span class="glyphicon glyphicon-list-alt" style="top:2px;"></span> Declaração Final</a></li>
            <li><a href="#termoAditivo" data-toggle="tab"><span class="glyphicon glyphicon-plus-sign" style="top:2px;"></span> Termos Aditivos</a></li>
        </ul>
	</div>
	<!-- <div id="corpo" style="margin-top: 70px; height: 100%;"> -->
	<div id="corpo" style="margin-top: 10px; height: 100%;">
		<div class="tab-content">
    	   	<div class="tab-pane active" id="planos">
    	   		<div class="table-responsive">
    	   			<?php
	    	   			if(count($planos) > 0){ ?>
							<table class="table table-hover">
								<thead>
									<tr>
										<td>Dia</td>
										<td>Hora</td>
										<td>Status</td>
										<td>Impressão</td>
										<?php if($_SESSION['auto']=='V')echo '<td style="text-align: center" >Excluir</td>'?>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($planos as $row){
										$date = DateTime::createFromFormat("Y-m-d H:i:s" ,$row['Hora_Do_Envio']);
										$dia  = $date->format("d/m/Y");
										$hora = $date->format("H:i:s");
                                    ?>

										<tr name="plano" style="cursor: pointer;" data-toggle="modal" data-target="#Modal" value="<?= $row['Id_Plano_De_Atividades']?>" >
											<td><?php echo $dia  ?></td>
											<td><?php echo $hora ?></td>
											<td><?php echo $stringStatus[$row['Status']]?></td>
											<td>
                                                <form method="post" style="margin-bottom: 0px;" target="_blank" action="imprime_plano_de_atividades.php">
                                                    <input hidden name="plano" value=<?php echo "\"".$row['Id_Plano_De_Atividades']."\""?>/>
                                                    <input hidden name="idEstagio" value=<?php echo "\"".$_GET['idEstagio']."\"" ?>/>
                                                    <button type="submit" class="imprimir btn btn-primary" >Imprimir</button>
                                                </form>
											</td>
                                            <?php if($_SESSION['auto']=='V')echo '
											<td>
                                                <form method="post" style="margin-bottom: 0px;text-align: center" action="Controllers/Controller-remove-plano-de-atividades.php">
                                                        <input hidden name="plano" value="'.$row["Id_Plano_De_Atividades"].'">
                                                        <input hidden name="idEstagio" value=".$_GET["idEstagio"].">
                                                    <button type="submit" style="padding: 9px 10px;" class="removerItem btn btn-warning"><span class="glyphicon glyphicon-trash" style="top:2px;"></span></button>
                                                </form>
											</td>'?>
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
    	   	</div>


            <div class="tab-pane" id="declaracaoFinal">
                <?php
                if(count($declaracao) >= 1){
                     ?>
                        <div class="table-responsive">
                            <table class="table table-hover doca">
                                <thead>
                                <tr>
                                    <td>Nome</td>
                                    <td>Status</td>
                                    <td>Documento</td>
                                    <?php if($_SESSION['auto']=='V')echo '<td style="text-align: center" >Excluir</td>'?>
                                </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($declaracao as $d) {

                                        ?>
                                        <tr>
                                            <td><?= $d["Nome_Declaracao"]?></td>
                                            <td><?= $stringStatus[$d["Status_Declaracao"]] ?></td>
                                            <td><a class="btn btn-primary" href=<?= "mostra-arquivo.php?idEstagio=".$_GET['idEstagio']."&tipo-documento=declaracao" ?> target="_blank">Visualizar</a></td>
                                            <?php if($_SESSION['auto']=='V')echo '
                                            <td>
                                                <form method="post" style="margin-bottom: 0px;text-align: center" action="Controllers/Controller-remove-declaracao.php">
                                                    <input hidden name="declaracao" value="'.$d["Id_Declaracao"].'">
                                                    <input hidden name="idEstagio" value="'.$_GET['idEstagio'].'">
                                                    <button type="submit" style="padding: 9px 10px;" class="removerItem btn btn-warning"><span class="glyphicon glyphicon-trash" style="top:2px;"></span></button>
                                                </form>

                                            </td>
                                            '?>
                                        </tr>

                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>


                <?php }

                else{

                    echo "<div class='alert alert-info text-center' style='width: 90%; margin-left: auto; margin-right: auto;'>
                        Nenhuma Declaração Final adicionada ainda.
                    </div>";


                }
                ?>
            </div>

    	   	<div class="tab-pane" id="relatorios">
    	   		<div class="table-responsive">
    	   		<?php
	    	   				if(count($relatorios) > 0){ ?>

							<table class="table table-hover">
								<thead>
									<tr>
										<td>Dia</td>
										<td>Hora</td>
										<td>Status</td>
										<td>Impressão</td>
                                        <?php if($_SESSION['auto']=='V')echo '<td style="text-align: center" >Excluir</td>'?>
									</tr>
								</thead>

								<tbody>
									<?php foreach($relatorios as $row){
										$date = DateTime::createFromFormat("Y-m-d H:i:s", $row['Hora_Do_Envio']);
										$dia  = $date->format("d/m/Y");
										$hora = $date->format("H:i:s");
										?>

										<tr name="relatorio" style="cursor: pointer;" data-toggle="modal" data-target="#Modal" value="<?= $row['Id_Relatorio']?>">
											<td><?php echo $dia  ?></td>
											<td><?php echo $hora ?></td>
											<td><?php echo $stringStatus[$row['Status']]?></td>
											<td>
                                                <form method="post" style="margin-bottom: 0px;" target="_blank" action="imprime_relatorio_atividades.php">
                                                    <input hidden name="relatorio" value=<?php echo "\"".$row['Id_Relatorio']."\""?>/>
                                                    <input hidden name="idEstagio" value=<?php echo "\"".$_GET['idEstagio']."\"" ?>/>
                                                    <button type="submit" class="imprimir btn btn-primary" >Imprimir</button>
                                                </form>
											</td>
                                            <?php if($_SESSION['auto']=='V')echo '
                                            <td>
                                                    <form method="post" style="margin-bottom: 0px;text-align: center" action="Controllers/Controller-remove-relatorio.php">
                                                        <input hidden name="relatorio" value="'.$row['Id_Relatorio'].'">
                                                        <input hidden name="idEstagio" value="'.$_GET['idEstagio'].'">
                                                        <button type="submit" style="padding: 9px 10px;" class="removerItem btn btn-warning"><span class="glyphicon glyphicon-trash" style="top:2px;"></span></button>
                                                    </form>
                                            </td>
                                            '?>

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

	    	   		<!--<div class="novo-documento">
						<button data-toggle="modal" data-target="#Modal" id="BotaoNovoRelatorio" class="btn btn-success">Adcionar Relatórios</button>
					</div>-->




    	   	</div>

    	   	<div class="tab-pane" id="termoDeCompromisso">
                <div class="table-responsive">
                    <?php if(count($termo) >= 1){ ?>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <td>Nome</td>
                                <td>Status</td>
                                <td>Documento</td>
                                <?php if($_SESSION['auto']=='V')echo '<td style="text-align: center" >Excluir</td>'?>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($termo as $t) { ?>

                                                <tr>
                                                    <td><?= $t["Nome_Termo"]?></td>
                                                    <td><?= $stringStatus[$t["Status_Termo"]] ?></td>
                                                    <td><a class="btn btn-primary" href=<?= "mostra-arquivo.php?idEstagio=".$_GET['idEstagio']."&tipo-documento=termo" ?> target="_blank">Visualizar</a></td>
                                                    <?php if($_SESSION['auto']=='V')echo '
                                                    <td>
                                                        <form method="post" style="margin-bottom: 0px;text-align: center" action="Controllers/Controller-remove-termo-compromisso.php">
                                                            <input hidden name="termoDeCompromisso" value="'.$t["Id_Termo"].'">
                                                            <input hidden name="idEstagio" value="'.$_GET['idEstagio'].'">
                                                            <button type="submit" style="padding: 9px 10px;" class="removerItem btn btn-warning"><span class="glyphicon glyphicon-trash" style="top:2px;"></span></button>
                                                        </form>
                                                    </td>
                                                    '?>
                                                </tr>


                                    </div>
                                <?php } ?>

                            </tbody>
                        </table>
	    	   			<?php }
	    	   			else{?>
                            <div class="alert alert-info text-center" style="width: 90%; margin-left: auto; margin-right: auto;">
                                Nenhum Termo de compromisso enviado.
                            </div>
	    	   			<?php }?>
                </div>
    	   	</div>

            <div class="tab-pane" id="termoAditivo">
                <?php if(count($termosAditivos) > 0){ ?>
                    <div class="table-responsive">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Nome documento</td>
                                    <td>Data final</td>
                                    <td>Data de prorrogação</td>
                                    <td>Status</td>
                                    <td>Documento</td>
                                    <?php if($_SESSION['auto']=='V')echo '<td style="text-align: center" >Excluir</td>'?>
                                </tr>
                            </thead>

                            <tbody>
                            <?php


                            foreach($termosAditivos as $d){
                                ?>

                                    <tr class="termoAditivoRow" value="<?php echo $d['Id_TermoAditivo'] ?>" >


                                        <td><?= $d["Nome_TermoAditivo"]?></td>
                                        <td><?= $d["Data_Fim"]?></td>
                                        <td class="dataP" ><?= $d["Data_Prorrogacao"]?></td>
                                        <td>
                                        <?php

                                            if($d["Status_TermoAditivo"]=="supervisor"|| $d["Status_TermoAditivo"]=="presidente" ){
                                                echo "Esperando aprovação";
                                            }
                                            else if( $d["Status_TermoAditivo"]=="aprovado" ){
                                                echo "Aprovado";
                                            }else{
                                                echo "Rejeitado";
                                            }
                                            ?>
                                        </td>
                                        <td><a class="btn btn-primary" href=<?= "mostra-arquivo.php?idEstagio=".$d['Id_Estagio']."&tipo-documento=termo" ?> target="_blank">visualizar</a></td>
                                        <?php if($_SESSION['auto']=='V')echo '
                                        <td>
                                            <form method="post" style="margin-bottom: 0px;text-align: center" action="Controllers/Controller-remove-termo-aditivo.php">
                                                <input hidden name="termoAditivo" value="'.$d['Id_TermoAditivo'].'">
                                                <input hidden name="idEstagio" value="'.$_GET['idEstagio'].'">
                                                <button type="submit" style="padding: 9px 10px;" class="removerItem btn btn-warning"><span class="glyphicon glyphicon-trash" style="top:2px;"></span></button>
                                            </form>

                                        </td>
                                        '?>
                                </tr>
                                <?php

                            } ?>
                            </tbody>
                        </table>
                    </div>

                <?php }

                else{ ?>
                    <div class="alert alert-info text-center" style="width: 90%; margin-left: auto; margin-right: auto;">
                        Nenhum Termo aditivo enviado.
                    </div>
                <?php } ?>

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
                                                <input name="dataTA" class="datepicker" required >

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