<?php

    require_once("cabecalho.php");
 
	if($_SESSION["auto"] != "V"&&$_SESSION["auto"] != "P"){
		$_SESSION["Failed"] = "Você não tem autorização para acessar essa pagina!";
		header("Location: users.php");
		die();
	}
	
	require_once("conecta.php");
	require_once("../../Action/banco-area.php");
	require_once("../../Action/banco-estagios.php");
	require_once("../../Action/banco-usuarios.php");


    if($_SESSION['auto']=='V')
        $estagios = ListaEstagios($mysqli,$_SESSION['id'],"presidente");
    else if($_SESSION['auto']=='P'){
        $estagios = ListaEstagios($mysqli,$_SESSION['id'],"supervisor");
    }else{
	    $_SESSION["Failed"] = "Você não tem autorização para acessar essa pagina!";
		header("Location: users.php");
		die();
    }

    $alunos = getEstagiarios($mysqli);
    $cursos = Lista_Cursos();


?>
	<link href = "css/administracao.css" rel = "stylesheet" >
	<link href = "css/bootstrap.vertical-tabs.css" rel = "stylesheet" >
	<script src="js/administracao.js"></script>

	<div id="ArquivosNav">
		<ul class="nav nav-tabs">
			<?php if($_SESSION['auto']=='V'){?>
                <li class="active"><a href="#areas" data-toggle="tab">
                    <span class="glyphicon  glyphicon-file" style="top:2px;"></span> Áreas</a>
                </li>
			<?php } ?>

			<?php if($_SESSION['auto']=='P'){?>
				<li class="active"><a href="#estagios" data-toggle="tab">
			<?php
			}else{?>
				<li><a href="#estagios" data-toggle="tab">
			<?php } ?>
				<span class="glyphicon  glyphicon-th-list" style="top:2px;"></span> Estágios</a>
			</li>
			<li><a href="#alunos" data-toggle="tab">
				<span class="glyphicon  glyphicon-user" style="top:2px;"></span> Estagiários</a>
			</li>

		</ul>	
	</div>

	<div class="table" style="margin-top: 20px; width: 90%; margin-left: auto; margin-right: auto;">
		<div class="tab-content">
		<?php if($_SESSION['auto']=='P'){ echo '<div class="tab-pane" id="areas">';}
			 else{ echo '<div class="tab-pane active" id="areas">';}	?>				
				<div class="table-responsive">			
					<div class="row">								
						<div class="col-xs-12 col-md-offset-1 col-md-5">
							<table class="scrollTable" cellpadding="0" cellspacing="0" 	border-radius="5px" >
							    <thead class="fixedHeader">
							            <th><center><b>Áreas</b></center></th>
							    </thead>
							    <tbody class="scrollContent">
							    	<?php 
							    		$areas = getAreasIdENomes($mysqli);
							    		$first = next($areas);

							    		foreach ($areas as $area){
							    			if($area['Id_Area']!='0')
								        	echo '<tr > <td name="linhaArea" value="'.$area['Id_Area'].'">'.$area['Nome'].'</td></tr>';
								   		}
								    ?>
							    </tbody>
							</table>
						</div>
						<div class="col-xs-12 col-md-offset-1 col-md-4">
							<div class="col-xs-12 col-md-12" style="margin-top:10px; border:1px solid ; border-radius: 5px;" >
								<form action="Controllers/Controller-area.php" method="POST" >
									<center><span><p style="border-bottom: 1px solid" ><b>Alterar/Remover</b></p></span></center>
									<center><span><b>Nome:</b></span><br>
									<input id="codigoArea" hidden name="idArea" value=""/>
									<input id="nomeArea" style="width: 100%; margin-bottom: 10px;" type="text" name="nomeArea" value=""/>
									<input type="submit" name="botaoArea" value="Salvar" class="btn btn-success" >
									<input type="submit" name="botaoArea" value="Excluir" class="btn btn-danger" >	</center>
								</form>
							</div>
							<div class="col-xs-12 col-md-12" style="margin-top:10px; border:1px solid ; border-radius: 5px;" >
								<center><span><p style="border-bottom: 1px solid" ><b>Inserir</b></p></span></center>
								<form action="Controllers/Controller-area.php" method="POST" >
									<center><span>Nome:</span><br>
									<input id="nomeArea" style="width: 100%; margin-bottom: 10px;" type="text" name="nomeArea" value=""/>
									<input type="submit" name="botaoArea" value="Adicionar" class="btn btn-success" >	</center>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php 
			if($_SESSION['auto']=='P'){ echo '<div class="tab-pane active" id="estagios">';}
			else{ echo '<div class="tab-pane" id="estagios">';}?>
				<div class="table-responsive">
					<div class="row">
						<?php

                        if(count($estagios) > 0){
                            ?>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>Nome Completo do Aluno</td>
                                            <td>Área</td>
                                            <td>Modalidade</td>
                                            <td>Data de Inicio</td>
                                            <td>Data Fim</td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach($estagios as $row){


                                            $NomeArea = GetAreaById($mysqli, $row["Area"]); // pega o nome da area

                                            ?>
                                            <form method="get" action="documentos-estagio-admin.php" id="<?= $i ?>">

                                                <input hidden name="idEstagio" value=<?php echo "\"" . $row['Id_Estagio'] . "\"" ?>/><!-- id da empresa -->

                                                <tr class="linhaEstagio" style="cursor: pointer;" >
                                                    <td><?= $row["Nome_Completo"];?></td>
                                                    <td><?= $NomeArea[0]['Nome'];//Otimizar-Aqui?></td>
                                                    <?php echo $row['Modalidade']==1? "<td>Obrigatório</td>" : "<td>Não Obrigatório</td>" ?>
                                                    <td><?php EchoDate($row["Data_Inicio"])?></td> 	<!-- data inicial -->
                                                    <td><?php EchoDate($row["Data_Fim"])?></td> 	<!-- data inicial -->

                                                </tr>
                                           </form>
                                        <?php
                                        $i = $i + 1;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php

                        }
                        else{ ?>
                            <p class="center" >Nenhum Estágio pendente.</p>
                        <?php } ?>

					</div>
				</div>
			</div>

			<div class="tab-pane" id="alunos">						
				<div class="table-responsive">
					<div class="row">
						<?php

                        if(count($estagios) > 0){
                            ?>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>Nome Completo do Aluno</td>
                                            <td>RGA</td>
                                            <td>Curso</td>
                                            <td>Telefone</td>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach($alunos as $row){

                                            ?>
                                                <tr class="linhaEstagiario" style="cursor: pointer;" value="<?php echo $row["Id_Usuario"]; ?>" >
                                                    <td><?=  $row["Nome_Completo"];?></td>
                                                    <td><?= substr($row["Rga"],0,4).".".substr($row["Rga"],4,4)."-".substr($row["Rga"],8) ;?></td>
                                                    <td><?= $cursos[$row["Id_Curso"]]["nome"];?></td>
                                                    <td><?= "(".substr($row["Telefone"],0,3).") ".substr($row["Telefone"],3,4)."-".substr($row["Telefone"],7) ;?></td>

                                                </tr>
                                        <?php
                                        $i = $i + 1;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php

                        }
                        else{ ?>
                            <p class="center" >Nenhum Estágio pendente.</p>
                        <?php } ?>

					</div>
				</div>
			</div>
		
		</div>
	</div>

    <div class="modal fade bs-example-modal-lg" id="EstagiarioModal" width="80%">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                        <h4 class="modal-title"> Informações do Aluno </h4>
                </div>
                <div class="modal-body" id="EstagiarioModalBody">

                </div>
             </div>
        </div>
    </div>


<?php require_once("rodape.php");?>