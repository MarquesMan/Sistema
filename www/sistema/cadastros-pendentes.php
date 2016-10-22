<?php require_once("cabecalho.php");?>

<?php
		require_once("conecta.php");
		require_once("../../Action/pessoas-documentos-pendentes.php"); 
?>
		<?php 
			if($_SESSION["auto"] != "V"){
				$_SESSION["Failed"] = "Você não tem autorização para acessar essa pagina!";
				header("Location: users.php");
				die();
			}
		?>
		
		<script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
		<script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>
		<script src="js/padrao_tabela.js"></script>

		<script src="js/cadastros-pendentes.js"></script>

		<link href = "css/cadastros-pendentes.css" rel = "stylesheet" >

		<?php
			$alunos = ListaAlunosPendentes($mysqli);
			$supervisores = ListaSupervisoresPendentes($mysqli);
			$empresas = ListaEmpresasPendentes($mysqli); 
			$id = $_SESSION["id"];
		?>

		<div>
			<ul class="nav nav-tabs">
				<li class="active"><a href="#alunos" data-toggle="tab">Alunos</a></li>
			    
				<li><a href="#supervisores" data-toggle="tab">Supervisores</a></li>
			    <li><a href="#empresas" data-toggle="tab">Empresas</a></li>
			</ul>	
		</div>

		<div style="margin-top: 20px; width: 90%; margin-left: auto; margin-right: auto;">
			<div class="tab-content">

				<div class="tab-pane active" id="alunos">
					<?php if(count($alunos) > 0){ ?>							
						<div class="table-responsive">
							<table id="tabelaAlunos" class="table table-bordered table-striped">
								<thead>
									<td>Nome Completo</td>
									<td>RGA</td>
									<td>E-Mail</td>
									<td>Ação</td>
								</thead>
								<tbody>
									<?php foreach($alunos as $row){ ?>
										
										<form method="post" action="Controllers/Controller-cadastros-pendentes.php">
											<tr class="linha">
												<td class="celula-p"><?php echo $row["Nome_Completo"]?></td>
												<td><?php echo $row["Rga"]?></td>
												<td><?php echo $row["Email"]?></td>												
												<td>
													<input type="submit" class="btn btn-success" name="tipo-decisao" value="Aceitar">
													<input type="submit" class="btn btn-danger recusar"  name="tipo-decisao" value="Recusar" style="margin-left: 5px;">
												</td>
											</tr>
											<input hidden="hidden" name="id" value="<?php echo $row['Id_Usuario']; ?>"/>
											<input hidden="hidden" name="comentario" value="" >	
											<input hidden="hidden" name="tipo-cadastro" value="aluno"  >
											<input hidden="hidden" name="tipo-decisao" value="Recusar"  >

										</form>
									<?php }?>
								</tbody>
							</table>
						</div>							
					<?php }

					else{ 
						echo "<div class='alert alert-info text-center' style='width: 90%; margin-left: auto; margin-right: auto;'>
						 	Nenhum Cadastro pendente.
						 	</div>";
					} ?>					
				</div>

				
				<div class="tab-pane" id="supervisores">
					<?php if(count($supervisores) > 0){ ?>						
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<td>Nome Completo</td>
									<td>E-Mail</td>
									<td>Ação</td>
								</thead>
								<tbody>
									<?php foreach($supervisores as $row){ ?>
										<form method="post" action="Controllers/Controller-cadastros-pendentes.php">
											<tr>
												<td class="celula-p"><?php echo $row["Nome_Completo"]?></td>
												<td><?php echo $row["Email"]?></td>
												<td>
													<input type="submit" class="btn btn-success" name="tipo-decisao" value="Aceitar">
													<input type="submit" class="btn btn-danger recusar"  name="tipo-decisao" value="Recusar" style="margin-left: 5px;">
														
												</td>
											</tr>
											<input hidden="hidden" name="id" value="<?php echo $row['Id_Usuario']; ?>"/>
											<input hidden="hidden" name="tipo-cadastro" value="supervisor">
											<input hidden="hidden" name="tipo-decisao" value="Recusar">
											<input name="comentario" value="" hidden="hidden">
										</form>
									<?php } ?>
								</tbody>
							</table>
						</div>
					<?php }

					else{ 
						echo "<div class='alert alert-info text-center' style='width: 90%; margin-left: auto; margin-right: auto;'>
						 	Nenhum Cadastro pendente.
						 	</div>";
					} ?>
				</div>

				<div class="tab-pane" id="empresas">
					<?php if(count($empresas) > 0){ ?>							
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<td>Nome Completo</td>
									<td>E-Mail</td>
									<td>Telefone</td>
									<td>Ação</td>
								</thead>
								<tbody>
									<?php foreach($empresas as $row){ ?>
										<form method="post"  action="Controllers/Controller-cadastros-pendentes.php">
											<tr>
												<td class="celula-p"><?php echo $row["Nome"]?></td>
												<td><?php echo $row["Email"]?></td>
												<td><?php echo $row["Telefone"]?></td>
												<td>
													<input type="submit" class="btn btn-success" name="tipo-decisao" value="Aceitar">
													<input type="submit" class="btn btn-danger recusar"  name="tipo-decisao" value="Recusar" style="margin-left: 5px;">
														
												</td>
											</tr>

											<input hidden="hidden" name="id" value="<?php echo $row['Id_Empresa']; ?>"/>
											<input hidden="hidden" name="tipo-cadastro" value="empresa">
											<input hidden="hidden" name="tipo-decisao" value="Recusar">		
											<input name="comentario" value="" hidden="hidden">
										</form>
									<?php } ?>
								</tbody>
							</table>
						</div>
					<?php }

					else{ 
						echo "<div class='alert alert-info text-center' style='width: 90%; margin-left: auto; margin-right: auto;'>
						 	Nenhum Cadastro pendente.
						 	</div>";
					} ?>

				</div>

			</div>
		</div>	

<!-- 
=====================================================================
					Modal de observacao para reprovacao
=====================================================================
-->

<div class="modal fade bs-example-modal-lg" id="ModalObservacao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" width="90%"> <!-- modal do novo estagio -->
	<div class="modal-dialog"><!-- dialogo do modal -->
	    <div class="modal-content"> <!-- conteudo do dialogo do modal -->
		    
		    <div class="modal-header">  <!-- cabecalho modal -->
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>  <!-- botao de fechar o modal -->
			        <h4 class="modal-title">Observação</h4>  <!-- texto cabecalho -->
		    </div>  <!-- cabecalho modal -->

		    <div  class="modal-body">

		       	<textarea id="conteudoObservacao" style="width:100%;resize: vertical;margin-left:auto;margin-right:auto;margin-bottom:10px;" cols="50" rows="10" ></textarea>

		       	<div style="margin:auto 0;text-align: center;">
			       	<button  name="botaoReprova" id="botaoReprova"  class="btn btn-danger" style="margin-left: 20px;">Recusar</button>
					<button  name="botaoCancela" id="botaoCancela" 	class="btn btn-danger" style="margin-left: 20px;" >Cancelar</button>
				</div>

			</div>
		</div><!-- conteudo do dialogo do modal -->
	</div><!-- dialogo do modal -->
</div><!-- modal do novo estagio --> 	
		
<?php require_once("rodape.php");?>