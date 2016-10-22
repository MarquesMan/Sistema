<?php

    require_once("cabecalho.php");
 
	if($_SESSION["auto"] != "Z"){
		$_SESSION["Failed"] = "Você não tem autorização para acessar essa pagina!";
		header("Location: users.php");
		die();
	}
	
	require_once("conecta.php");
	require_once("../../Action/banco-area.php");
	require_once("../../Action/banco-estagios.php");
	require_once("../../Action/banco-usuarios.php");

	$cursos = Lista_Cursos();


    if($_SESSION['auto']!='Z'){
	    $_SESSION["Failed"] = "Você não tem autorização para acessar essa pagina!";
		header("Location: users.php");
		die();
    }

?>
	<link href = "css/superAdmin.css" rel = "stylesheet" >
	<link href = "css/bootstrap.vertical-tabs.css" rel = "stylesheet" >
	<script src="js/jquery.maskedinput.js"></script>
	<script src="js/superAdmin.js"></script>

	<div id="ArquivosNav">
		<ul class="nav nav-tabs">
	        <li class="active"><a href="#areas" data-toggle="tab">
	            <span class="glyphicon  glyphicon-file" style="top:2px;"></span> Áreas</a>
	        </li>
	        <li><a href="#coordenadores" data-toggle="tab">
	            <span class="glyphicon  glyphicon-user" style="top:2px;"></span> Coordenadores</a>
	        </li>
		</ul>	
	</div>

	<div class="table" style="margin-top: 20px; width: 90%; margin-left: auto; margin-right: auto;">
		<div class="tab-content">
			<div class="tab-pane active" id="areas">				
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

			<div class="tab-pane" id="coordenadores" style="text-align: center;">				
				<div class="table-responsive">			
					<div class="row">								
						<div class="col-xs-12 col-md-offset-1 col-md-10">
							<table class="scrollTable" cellpadding="0" cellspacing="0" 	border-radius="5px" style="border-collapse: collapse;" >
							    <thead class="fixedHeader">
							            <th>Id</th>
							            <th>Nome Completo</th>
							            <th>Curso</th>
							    </thead>
							    <tbody class="scrollContent">
							    	<?php 
							    		$coordenadores = getCoordenadores($mysqli);
		
							    		foreach ($coordenadores as $coordenador){
								        	echo '<tr class="linhaCoordenador" > <td> '.$coordenador['Id_Usuario'].'</td><td>'.$coordenador['Nome_Completo'].'</td><td>'.$cursos[$coordenador['Id_Curso']]["nome"].'</td></tr>';
								   		}
								    ?>
							    </tbody>
							</table>
							<div class="col-xs-12 col-md-4">
								<button id="BotaoNovoCoordenador" data-toggle="modal" data-target="#NovoCoordenadorModal" class="btn btn-success">Adicionar</button>
							</div>
							<div class="col-xs-12 col-md-4">
								<button id="BotaoAlterarCoordenador" class="btn btn-primary">Alterar</button>
							</div>
							<div class="col-xs-12 col-md-4">
								<form action="Controllers/Controller-coordenador.php" method="POST" >
									<button id="BotaoRemoverCoordenador" class="btn btn-danger">Remover</button>
									<input hidden="hidden" name="idCoordenadorRemover" id="idCoordenadorRemover"></input>
								</form>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>	
	</div>

    <div class="modal fade bs-example-modal-lg" id="NovoCoordenadorModal" width="80%">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                        <h4 class="modal-title"> Informações do Coordenador </h4>
                </div>
                <div class="modal-body" id="NovoCoordenadorModalBody">
	                <div class="row" >
            			<form action="Controllers/Controller-coordenador.php" id="formNovo" method="POST" >
		                	<div class="col-xs-12 col-md-5 col-md-offset-1">		                
			                	<label >Nome Completo:</label>
			                	<input type="text" class="inputText" name="nomeCompleto" value=""></input>
		                	</div>
		                	
		                	<div class="col-xs-12 col-md-5">
			                	<label >Nome de usuário:</label>
			                	<input type="text" class="inputText" name="nomeUsuario" value=""></input>
		                	</div>

		                	<div class="col-md-1" ></div>

		                	<div class="col-xs-12 col-md-5 col-md-offset-1">
			                	<label >Senha:</label>
			                	<input type="text" class="inputText" name="senha" value=""></input>
		                	</div>
		                	
		                	<div class="col-xs-12 col-md-5  ">
			                	<label >Email:</label>
			                	<input type="text" class="inputText" name="email" value=""></input>
		                	</div>

		                	<div class="col-md-1" ></div>

		                	<div class="col-xs-12 col-md-5 col-md-offset-1">
			                	<label >Telefone:</label>
			                	<input type="text" class="inputText" id="telefone" name="telefone" value=""></input>
		                	</div>

		                	<div class="col-xs-12 col-md-5  ">
			                	<label >Curso:</label>
			                	<select class="form-control" name="idCurso" style="text-overflow: ellipsis;">
									<?php
										

										foreach(Lista_Cursos() as $item ){
											if($item['nome']!='Nenhum'){												
												echo '<option value="'.$item['Id_Curso'].'">'.$item['nome'].'</option>';
											}
										}
							
									?>
								</select>
		                	</div>

		                	<div class="col-md-1" ></div>
	                	</form>

		                <div class="col-xs-12 col-md-12" style="text-align: center;margin-top: 25px;">
							<button name="acao" form="formNovo" value="novo" type="submit" id="BotaoNovoCoordenador"  class="btn btn-success">Adicionar</button>
						</div>
					</div>
                </div>
             </div>
        </div>
    </div>

	<div class="modal fade bs-example-modal-lg" id="AlterarCoordenadorModal" width="80%">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                        <h4 class="modal-title"> Informações do Coordenador </h4>
                </div>
                <div class="modal-body" id="AlterarCoordenadorModalBody">
					<div class="row" >
            			<form action="Controllers/Controller-coordenador.php" id="formNovo" method="POST" >
		                	<div class="col-xs-12 col-md-5 col-md-offset-1">		                
			                	<label >Nome Completo:</label>
			                	<input type="text" class="inputText" name="nomeCompleto" value=""></input>
		                	</div>
		                	
		                	<div class="col-xs-12 col-md-5">
			                	<label >Nome de usuário:</label>
			                	<input type="text" class="inputText" name="nomeUsuario" value=""></input>
		                	</div>

		                	<div class="col-md-1" ></div>

		                	<div class="col-xs-12 col-md-5 col-md-offset-1">
			                	<label >Senha:</label>
			                	<input type="text" class="inputText" name="senha" value=""></input>
		                	</div>
		                	
		                	<div class="col-xs-12 col-md-5  ">
			                	<label >Email:</label>
			                	<input type="text" class="inputText" name="email" value=""></input>
		                	</div>

		                	<div class="col-md-1" ></div>

		                	<div class="col-xs-12 col-md-5 col-md-offset-1">
			                	<label >Telefone:</label>
			                	<input type="text" class="inputText" id="telefone" name="telefone" value=""></input>
		                	</div>

		                	<div class="col-xs-12 col-md-5  ">
			                	<label >Curso:</label>
			                	<input hidden="hidden" name="idCoordenadorAlterar" id="idCoordenadorAlterar" value=""></input>
			                	<select class="form-control" name="idCurso" style="text-overflow: ellipsis;">
									<?php

										foreach(Lista_Cursos() as $item ){
											if($item['nome']!='Nenhum'){												
												echo '<option value="'.$item['Id_Curso'].'">'.$item['nome'].'</option>';
											}
										}
							
									?>
								</select>
		                	</div>

		                	<div class="col-md-1" ></div>
	                	</form>

		                <div class="col-xs-12 col-md-12" style="text-align: center;margin-top: 25px;">
							<button name="acao" form="formNovo" value="novo" type="submit" id="BotaoNovoCoordenador"  class="btn btn-success">Alterar</button>
						</div>
					</div>
                </div>
             </div>
        </div>
    </div>

<?php require_once("rodape.php");?>