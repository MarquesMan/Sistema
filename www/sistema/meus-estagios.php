<?php require_once("cabecalho.php");?>

	<?php 
		require_once("conecta.php");
		require_once("../../Action/banco-estagios.php");
		require_once("../../Action/banco-empresa.php");
		require_once("../../Action/banco-usuarios.php");
		require_once("../../Action/banco-area.php");
	?>

		<link href = "css/meus-estagios.css" rel = "stylesheet">
		<link href = "css/plano-de-atividades.css" rel = "stylesheet" >
		<script src="js/jquery.maskedinput.js"></script>
		<script src="js/meus-estagios.js"></script>

		<?php
			
			$pessoa = array(
						'E' => "aluno",
						'P' => "supervisor"
					  );

			$estagios = ListaEstagios($mysqli, $_SESSION["id"], $pessoa[$_SESSION["auto"]]); // lista de estagios do usurio

			$areas = getAreas($mysqli); // areas para impressao, ou uso do select

			if(count($estagios) > 0) {    // aluno possui ao menos um estagio?
                $i = 0;                    // variavel para contar dando o id atribuido somente na pagina, ajuda com o modal
                ?>
                <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>Empresa</td>
                            <td>Surpevisor</td>
                            <td>Área</td>
                            <td>Status</td>
                            <td>Data de Inicio</td>
                            <td>Data de Fim</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($estagios as $row) {
                        if (TraduzEstadoEstagio($row["Status"]) >= 0){                            // verifica na array de estado do estagio o numero dele, caso seja negativo, aidna nao foi aprovado
                            $i++;                                                                // incrementa id para o proximo
                            $getEmpresa = GetEmpresaById($mysqli, $row['Id_Empresa']);            // pega o nome da empresa
                            $getSurpervisor = GetUsuarioById($mysqli, $row['Id_Supervisor']);    // pega o nome do supervisor
                            $NomeArea = GetAreaById($mysqli, $row["Area"]);                    // pega o nome da area
                            ?>
                            <form method="get" action="documentos-estagio.php" id="<?= $i ?>">
                                <input hidden name="empresa" value=<?php echo "\"" . $row['Id_Empresa'] . "\"" ?>/><!-- id da empresa -->
                                <input hidden name="idEstagio" value=<?php echo "\"" . $row['Id_Estagio'] . "\"" ?>/><!-- id da empresa -->

                                <tr style="cursor: pointer;" name="<?= $i ?>" aprovado="1">
                                    <td><?php echo $getEmpresa[0]["Nome"] ?></td>
                                    <!-- nome da empresa -->
                                    <td><?php echo $getSurpervisor[0]["Nome_Completo"] ?></td>
                                    <!-- nome do supervisor -->
                                    <td><?php echo $NomeArea[0]["Nome"] ?></td>
                                    <!-- nome da area -->
                                    <td>Em andamento</td>
                                    <td><?php echo date_create($row["Data_Inicio"])->format("d/m/Y"); ?></td>
                                    <!-- data inicial -->
                                    <td><?php echo date_create($row["Data_Fim"])->format("d/m/Y"); ?></td>
                                    <!-- data final -->
                                </tr>

                            </form>
                            <?php
                        } else if (TraduzEstadoEstagio($row["Status"]) == -2) {
                            $i++;                                                                // incrementa id para o proximo
                            $getEmpresa = GetEmpresaById($mysqli, $row['Id_Empresa']);            // pega o nome da empresa
                            $getSurpervisor = GetUsuarioById($mysqli, $row['Id_Supervisor']);    // pega o nome do supervisor
                            $NomeArea = GetAreaById($mysqli, $row["Area"]);                    // pega o nome da area
                            ?>
                            <tr style="cursor: pointer;" name="<?= $i ?>"
                                value=<?php echo "\"" . $row['Id_Estagio'] . "\"" ?> data-toggle="modal"
                                data-target="#Modal" aprovado="0">
                                <td><?php echo $getEmpresa[0]["Nome"] ?></td>
                                <!-- nome da empresa -->
                                <td><?php echo $getSurpervisor[0]["Nome_Completo"] ?></td>
                                <!-- nome do supervisor -->
                                <td><?php echo $NomeArea[0]["Nome"] ?></td>
                                <!-- nome da area -->
                                <td>
                                    <?php
                                    if (TraduzEstadoEstagio($row["Status"]) >= 2) {
                                        echo "Em andamento";
                                    } else if (TraduzEstadoEstagio($row["Status"]) != -2) {
                                        echo "Esperando aprovação";
                                    } else {
                                        echo "Rejeitado";
                                    }
                                    ?>
                                </td>
                                <td><?php EchoDate($row["Data_Inicio"]) ?></td>
                                <!-- data inicial -->
                                <td><?php EchoDate($row["Data_Fim"]) ?></td>
                                <!-- data final -->
                            </tr>
                            <?php
                        } else { 
                            $i++;                                                                // incrementa id para o proximo
                            $getEmpresa = GetEmpresaById($mysqli, $row['Id_Empresa']);            // pega o nome da empresa
                            $getSurpervisor = GetUsuarioById($mysqli, $row['Id_Supervisor']);    // pega o nome do supervisor
                            $NomeArea = GetAreaById($mysqli, $row["Area"]);                    // pega o nome da area

                            ?>
                            <tr style="cursor: pointer;" >
                                <td><?php echo $getEmpresa[0]["Nome"] ?></td>
                                <!-- nome da empresa -->
                                <td><?php echo $getSurpervisor[0]["Nome_Completo"] ?></td>
                                <!-- nome do supervisor -->
                                <td><?php echo $NomeArea[0]["Nome"] ?></td>
                                <!-- nome da area -->
                                <?php 

                                if (TraduzEstadoEstagio($row["Status"]) == -1.5)
                                    echo "<td>Entrega de Documentos</td>";
                                else
                                    echo "<td>Esperando aprovação</td>";
                                ?>

                                <td><?php EchoDate($row["Data_Inicio"]) ?></td>
                                <!-- data inicial -->
                                <td><?php EchoDate($row["Data_Fim"]) ?></td>
                                <!-- data final -->
                            </tr>

                        <?php
                        }
                    }
                        ?>
                        </tbody>
                    </table>
                    </div>
                    <?php

            }else{
				echo "<div class='alert alert-info' style='width: 80%; margin-left: auto; margin-right: auto;'>Nenhum Estágio no Sistema.</div>"; // nao ha nenhum  estagio :<
	      	} ?>

	    <div class="modal fade bs-example-modal-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" width="90%"> <!-- modal do novo estagio -->
			<div class="modal-dialog">		<!-- dialogo do modal -->
			    <div class="modal-content"> <!-- conteudo do dialogo do modal -->
				    
				    <div class="modal-header">  <!-- cabecalho modal -->
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>  <!-- botao de fechar o modal -->
					        <h4 class="modal-title" id="myModalLabel"></h4>  <!-- texto cabecalho -->
				    </div>  <!-- cabecalho modal -->

				    <div class="modal-body">
				       	
					</div>
				</div><!-- conteudo do dialogo do modal -->
			</div><!-- dialogo do modal -->
		</div><!-- modal do novo estagio -->

	<!-- modal para editar o estagio -->

	    <div class="novo-estagio">
				<!--<button type="submit" name="numbAdd" value="<?php echo count($estagios); ?>"  class="btn btn-success" style="height: 40px; width: 200px;"  </button>-->
				<button data-toggle="modal" data-target="#Modal" id="BotaoNovoEstagio" class="btn btn-success">Adcionar Estágio</button>
		</div>

<?php require_once("rodape.php");?>