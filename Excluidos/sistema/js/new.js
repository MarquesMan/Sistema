$(document).ready(function(){

	$( ".not-active" ).click(function(e) {

  		if(e.target.id=='plano'){
  			
  			$('#p-atividades').show();
  			$('#r-atividades').hide();
  			$('#d-atividades').hide();
  		}
  		else if(e.target.id=='relatorio'){
  			
  			$('#r-atividades').show();
  			$('#p-atividades').hide();
  			$('#d-atividades').hide();

  		}
  		else{

  			$('#d-atividades').show();
  			$('#r-atividades').hide();
  			$('#p-atividades').hide();

  		}
	
	});


});