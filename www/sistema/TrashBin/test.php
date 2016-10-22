<html>	

	<head>
		
		<meta charset = 'UTF-8'>		
		<title>Sistema de Estágios - UFMS - Login</title>
		<link href = "css/bootstrap.css" rel = "stylesheet" >
		<link href = "css/index.css" rel = "stylesheet" >

		<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
		<script type="text/javascript">
			tinymce.init({
    			selector: "textarea",
    			language : 'pt_BR'
 			});
 			tinyMCE.init({
 				theme : "advanced",
        		theme_advanced_layout_manager : "SimpleLayout",
       		 	theme_advanced_buttons1 : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
       		  	theme_advanced_buttons2 : "bullist,numlist,separator,outdent,indent,separator,undo,redo,separator",
       		 	theme_advanced_buttons3 : "hr,removeformat,visualaid,separator,sub,sup,separator,charmap"
			});

			window.onload = function(){
        document.getElementById('ok').onclick = function(){
                alert( tinyMCE.get('teste').get);
        }
}
		</script>

	
	</head>
	<body>

		<?php 
			$fn = "file.odt"; 
			$file = fopen($fn, "rb"); 
			$size = filesize($fn);  

			$text = fread($file, $size); 
			fclose($file); 
		?> 


		<center> <center>
		<div class = "container">	
			<div class = "principal">			
						<form method="post"> 
							<textarea><?=$text?></textarea><br/> 
							<input type="text" name="addition"/> 
							<input type="submit"/> 
						</form>	
			</div>
		</div>
	</body>

</html>