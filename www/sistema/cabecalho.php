<html>	
	<?php
		session_start(); // começa a session
		require_once("../../Action/funcoes-de-controle.php");

		ValidaUsuario();
	?>

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" charset='UTF-8'>
		
		<title>Sistema de Estágios - UFMS</title>

		<link rel="shortcut icon" href="images/favicon.ico"/>			
		
		<link href = "css/bootstrap-theme.css" rel = "stylesheet">
		<link href = "css/bootstrap-theme.min.css" rel = "stylesheet">
		<link href = "css/bootstrap.css" rel = "stylesheet">
		<link href = "css/bootstrap.min.css" rel = "stylesheet">
		<link href = "css/default.css" rel = "stylesheet">
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.mobile.custom.min.js"></script>
		<script src="js/jquery.mobile.custom.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/jquery-ui.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function(){
				setTimeout(function() {
  					$("#alerta-s").remove();
  					$("#alerta-f").remove();
				}, 5000);
			});
		</script>

	</head>
	<body>
		<div class="container-fluid">
			<div > <?php //style="margin-bottom: 70px;?>
				<div style="background-color: #f5f5f5;top: 0; left: 0; width: 100%; z-index: 1030;">
					<?php Set_Barra_Superior(); 
					Pagina_navegacao();?>
				</div>
			</div>
			<?php MostraAlerta();?>