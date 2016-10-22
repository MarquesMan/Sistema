$(document).ready(function(){

  $("#dataFinal").mask("99/99/9999");
  $("#dataInicial").mask("99/99/9999");

  function isValidDate(s) {
  var bits = s.split('/');
  var d = new Date(bits[2], bits[1] - 1, bits[0]);
  return d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[0]);
} 

  function isValidDate2(s) {
    var bits = s.split('/');
    var y = bits[2], m  = bits[1], d = bits[0];
    // Assume not leap year by default (note zero index for Jan)
    var daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];

    // If evenly divisible by 4 and not evenly divisible by 100,
    // or is evenly divisible by 400, then a leap year
    if ( (!(y % 4) && y % 100) || !(y % 400)) {
      daysInMonth[1] = 29;
    }
    return d <= daysInMonth[--m]
}


  $("#Save").click(function(){

  var dataFinal=$("#dataFinal").val();
  var dataInicial = $("#dataInicial").val();


  if(!isValidDate(dataInicial)){
    alert("Data Inicial não é válida");
    return false;    
  }
   

   if(!isValidDate(dataFinal)){
    alert("Data final não é válida");
    return false;    
  }

  });



/*	$( ".not-active" ).click(function(e) {

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
	
	});*/


});