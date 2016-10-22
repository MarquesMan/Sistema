<?php 
	session_start();
	require_once("conecta.php");
    require_once("../../Action/banco-plano-de-atividades.php");
    require_once("../../Action/banco-estagios.php");
    require_once("../../Action/funcoes-de-controle.php");
?>

	
	<link rel="stylesheet" type="text/css" href="css/plano-de-atividades.css">
	<link href = "css/bootstrap.vertical-tabs.css" rel = "stylesheet" >
	<script src="js/jquery.maskedinput.js"></script>

	
		<?php
			

			if(isset($_POST['idEstagio'])){
				$idEstagio = $_POST['idEstagio'];

                if($_SESSION['auto']=='P')
                    $pessoa = "supervisor";
                else
                    $pessoa = "presidente";

                $estagio = ListaEstagios($mysqli, $_SESSION["id"], $pessoa, $idEstagio);//mysqli_query($mysqli,"SELECT * FROM estagio WHERE Id_Estagio='".$idEstagio."' AND Id_Aluno='".$_SESSION["id"]."'") or die(mysqli_error($mysqli));
                //$estagio = mysqli_fetch_assoc($estagio);
			}else{
				erroPadrao("Não tem permissão para acessar esse estágio");
			}

			if(empty($estagio)|| !isset($_POST['plano']) ){ 
					erroPadrao("Não tem permissão para acessar esse plano de atividades");
            }

            $plano = $_POST['plano'];
            $planoRow = ListaPlanoDeAtividades($mysqli, $idEstagio, $plano);//mysqli_query($mysqli,"SELECT * FROM estagio WHERE Id_Estagio='".$idEstagio."' AND Id_Aluno='".$_SESSION["id"]."'") or die(mysqli_error($mysqli));
            $planoRow = $planoRow[0];

            if(empty($planoRow)){
				erroPadrao();
			}

            $horarios = $planoRow['Horario'];
            $horarios = explode(";", $horarios);

            $erros = explode(";", $planoRow['Erros']);

            if($planoRow['Erros'][0]=="1"){
                $pos = 1;
            }else{
                $pos = strpos($planoRow['Erros'], "1");
            }

            if($pos!=false){
                $errosHorario = substr( $planoRow['Erros'],6,23);

                if($errosHorario[0]=="1"){
                    $errosHorario = 1;
                }else{
                    $errosHorario = strpos($errosHorario, "1");
                    $errosHorario = (string)$errosHorario;
                }

                $comentarioRow = mysqli_query($mysqli,"SELECT * FROM comentario_plano_de_atividades WHERE Id_Plano_De_Atividades ='".$_POST["plano"]."'") or die(mysqli_error($mysqli));
                $comentarioRow = mysqli_fetch_assoc($comentarioRow);

            }else{
                $errosHorario = false;
                $comentarioRow = array('Comentario_Horarios' => "",
                    "Comentario_Descricao" => "",
                    "Comentario_Local" => "",
                    "Comentario_Carga" => "",
                    "Comentario_Data" => "");

            }

            if($_SESSION['auto']=='V'){
                $disabled = false;
            }else{
                $disabled = "disabled=\"disabled\"";
            }



        ?>
		<div class="row">
			<form method="post" action="Controllers/Controller-mudar-plano-de-atividades.php">


                <?php if($disabled===false){?>
				<input type="hidden" name="id_estagio" value="<?php echo $idEstagio; ?>" >
				<input hidden name="erros"		id="erros" 		value="0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0">
				<input hidden name="horarios" 	id="horarios" 	value="">
                <?php } ?>
				
					<div class="col-xs-5 col-md-2" align="right">
						<b class="plano-titulo">Horário<?php echo $errosHorario!=false?'<span id="0" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Horarios'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b><br>
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
							<input <?php echo $disabled?> type="text" name="segunda1" id="segunda1" horario="1" value="<?php echo $horarios[0]; ?>"   boolt="<?php echo $erros[3];?>" class="plano-input"/>
							<span class="plano-hora" >às</span>  
							<input <?php echo $disabled?> type="text" name="segunda2" id="segunda2"  horario="1" value="<?php echo $horarios[1]; ?>"  boolt="<?php echo $erros[4];?>" class="plano-input"/><br>
						</div>
						<div linha="1" align="center">
							<input <?php echo $disabled?> type="text" name="terca1" id="terca1" horario="1" value="<?php echo $horarios[2]; ?>"  boolt="<?php echo $erros[6];?>"  class="plano-input"/>
							<span class="plano-hora" >às</span> 
							<input <?php echo $disabled?> type="text" name="terca2" id="terca2" horario="1" value="<?php echo $horarios[3]; ?>"  boolt="<?php echo $erros[6];?>" class="plano-input"/><br>
						</div>
						<div linha="1" align="center">
							<input <?php echo $disabled?> type="text" name="quarta1" id="quarta1" horario="1" value="<?php echo $horarios[4]; ?>"  boolt="<?php echo $erros[7];?>"  class="plano-input"/>
							<span class="plano-hora" >às</span> 
							<input <?php echo $disabled?> type="text" name="quarta2" id="quarta2" horario="1" value="<?php echo $horarios[5]; ?>"  boolt="<?php echo $erros[8];?>" class="plano-input"/><br>
						</div>
							<div linha="1" align="center">
							<input <?php echo $disabled?> type="text" name="quinta1" id="quinta1" horario="1" value="<?php echo $horarios[6]; ?>"  boolt="<?php echo $erros[9];?>" class="plano-input"/>
							<span class="plano-hora" >às</span> 
						<input <?php echo $disabled?> type="text" name="quinta2" id="quinta2" horario="1" value="<?php echo $horarios[7]; ?>"  boolt="<?php echo $erros[10];?>" class="plano-input"/><br>
						</div>
						<div linha="1" align="center">
							<input <?php echo $disabled?> type="text" name="sexta1" id="sexta1" horario="1" value="<?php echo $horarios[8]; ?>"  boolt="<?php echo $erros[11];?>"  class="plano-input"/>
							<span class="plano-hora" >às</span> 
							<input <?php echo $disabled?> type="text" name="sexta2" id="sexta2" horario="1" value="<?php echo $horarios[9]; ?>"  boolt="<?php echo $erros[12];?>" class="plano-input"/><br>
						</div>
						<div linha="1" align="center">
							<input <?php echo $disabled?> type="text" name="sabado1" id="sabado1" horario="1" value="<?php echo $horarios[10]; ?>"  boolt="<?php echo $erros[13];?>"  class="plano-input"/>
							<span class="plano-hora" >às</span> 
							<input <?php echo $disabled?> type="text" name="sabado2" id="sabado2"  horario="1" value="<?php echo $horarios[11]; ?>"  boolt="<?php echo $erros[14];?>" class="plano-input"/><br>
						</div>
					</div>


				<div class="col-xs-12 col-md-6">
					<b>Atividades a serem desenvoldidas<?php echo $erros[15]==1?'<span id="1" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Descricao'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b><br>
					<textarea <?php echo $disabled?>  rows="7" id="Atividades_Desenvolvidas" cols="71" maxlength="497"  style="resize:none"  class=" status-box"  name="descricao" boolt="<?php echo $erros[15];?>"> <?php echo $planoRow['Descricao']; ?> </textarea>
					<p class="counter pull-right" style="padding-top:5px;padding-right:10px">497</p>
				</div>

				<div class="col-xs-12 col-md-2">					 
						<center><b>Local<?php echo $erros[0]==1?'<span id="1" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Local'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b></center><input <?php echo $disabled?>  boolt="<?php echo $erros[0];?>" type="text" class="plano-local" value="<?php echo $planoRow['Local']; ?>" id="local" name="local" > <br><br>
						<center><b>Carga horária<?php echo $erros[1]==1?'<span id="1" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Carga'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b></center><input <?php echo $disabled?> type="text"  boolt="<?php echo $erros[1];?>" class="plano-local" id="carga" value="<?php echo $planoRow	['Carga_Horaria']; ?>" name="carga" ><br><br>
						<center><b>Data<?php echo $erros[2]==1?'<span id="1" class="glyphicon  glyphicon-comment" value="'.$comentarioRow['Comentario_Data'].'" style="cursor:pointer;margin-left: 5px;color:#45AB35" ></span>':"" ?></b></center><input <?php echo $disabled?> type="text"  boolt="<?php echo $erros[2];?>" class="plano-local" id="data" value="<?php EchoDate($planoRow['Data']); ?>" name="data" ><br><br>
				</div>
                <?php if($_SESSION['auto']=='V'){ ?>
				<div class="col-xs-offset-3  col-xs-8 col-md-offset-4 col-md-6 ">					
					<button id="Save"   name="plano"   class="btn btn-success" value="<?php echo $_POST['plano']; ?>" width="100%">Salvar</button>
					<!--<button id="Saves"   name="plano-s" class="btn btn-primary" value="<?php echo $_POST['plano']; ?>" width="100%" style="margin-left:10px;">Submeter</button>-->
				</div>
                <?php }?>
			</form>
		</div>


