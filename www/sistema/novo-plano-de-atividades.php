<?php 
	session_start();
	require_once("conecta.php");
    require_once("../../Action/funcoes-de-controle.php");?>

	
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.maskedinput.js"></script>
    <script src="js/novo-plano-de-atividades.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/plano-de-atividades.css">
    <link href = "css/bootstrap.vertical-tabs.css" rel = "stylesheet" >


		<?php
			

			if(isset($_GET['idEstagio'])){
				$idEstagio = mysqli_real_escape_string( $mysqli  ,$_GET['idEstagio']);
				$estagio = mysqli_query($mysqli,"SELECT * FROM estagio WHERE Id_Estagio='".$idEstagio."' AND Id_Aluno='".$_SESSION["id"]."'") or die(mysqli_error($mysqli));
				$estagio = mysqli_fetch_assoc($estagio);	
			}else{
                erroPadrao("Não tem permissão para acessar esse estágio");
            }

        if(empty($estagio)){
            erroPadrao("Não tem permissão para acessar esse estágio");
        }
			
		?>
		<div class="row">
			<form method="post" action="Controllers/Controller-novo-plano-de-atividades.php">
				<input type="hidden" name="id_estagio" value="<?php echo $idEstagio; ?>" >
				<input hidden name="erros"		id="erros" 		value="0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0">
				<input hidden name="horarios" 	id="horarios" 	value="">

				
					<div class="col-xs-5 col-md-2" align="right">
						<strong class="plano-titulo">Horário</strong><br>
						<span class="plano-hora">Segunda-feira das</span><br>
						<span class="plano-hora">Terça-feira das</span><br>
						<span class="plano-hora">Quarta-feira das</span><br>
						<span class="plano-hora">Quinta-feira das</span><br>
						<span class="plano-hora">Sexta-feira das</span><br>
						<span class="plano-hora">Sábado das</span><br>
					</div>
					
					<div class="col-xs-6 col-md-2">
						<br>
						<div linha="1" align="center">
							<input type="text" name="segunda1" id="segunda1" horario="1" value=""   class="plano-input"/>
							<span class="plano-hora" >às</span>  
							<input type="text" name="segunda2" id="segunda2"  horario="1" value=""  class="plano-input"/><br>
						</div>
						<div linha="1" align="center">
							<input type="text" name="terca1" id="terca1" horario="1" value=""   class="plano-input"/>
							<span class="plano-hora" >às</span> 
							<input type="text" name="terca2" id="terca2" horario="1" value=""  class="plano-input"/><br>
						</div>
						<div linha="1" align="center">
							<input type="text" name="quarta1" id="quarta1" horario="1" value=""   class="plano-input"/>
							<span class="plano-hora" >às</span> 
							<input type="text" name="quarta2" id="quarta2" horario="1" value=""  class="plano-input"/><br>
						</div>
							<div linha="1" align="center">
							<input type="text" name="quinta1" id="quinta1" horario="1" value=""  class="plano-input"/>
							<span class="plano-hora" >às</span> 
						<input type="text" name="quinta2" id="quinta2" horario="1" value=""  class="plano-input"/><br>
						</div>
						<div linha="1" align="center">
							<input type="text" name="sexta1" id="sexta1" horario="1" value=""  class="plano-input"/>
							<span class="plano-hora" >às</span> 
							<input type="text" name="sexta2" id="sexta2" horario="1" value="" class="plano-input"/><br>
						</div>
						<div linha="1" align="center">
							<input type="text" name="sabado1" id="sabado1" horario="1" value=""  class="plano-input"/>
							<span class="plano-hora" >às</span> 
							<input type="text" name="sabado2" id="sabado2"  horario="1" value="" class="plano-input"/><br>
						</div>
					</div>


				<div class="col-xs-12 col-md-6">
					<b>Atividades a serem desenvoldidas</b><br>
					<textarea rows="7" id="Atividades_Desenvolvidas" cols="71" maxlength="497"  style="resize:none"  class=" status-box"  name="descricao" > </textarea>
					<p class="counter pull-right" style="padding-top:5px;padding-right:10px">497</p>
				</div>

				<div class="col-xs-12 col-md-2">					 
						<b>Local</b><input type="text" class="plano-local" value="" id="local" name="local" > <br><br>
						<b>Carga horária</b><input type="text"  class="plano-local" id="carga" value="" name="carga" ><br><br>
						<b>Data</b><input type="text" class="plano-local" id="data" value="" name="data" ><br><br>
				</div>

				<div class="col-xs-offset-3  col-xs-8 col-md-offset-4 col-md-6 ">					
					<button id="Save"   name="plano"   class="btn btn-success" value="" width="100%">Salvar</button>
					<button id="Saves"   name="plano-s" class="btn btn-primary" value="" width="100%" style="margin-left:10px;">Submeter</button>
				</div>

			</form>
		</div>
							



