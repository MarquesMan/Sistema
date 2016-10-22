// ==========================================
// Comentario do supervisor/presidente
// ==========================================
$('.glyphicon-comment').click(function(){

  $(this).parent().parent().children("textarea").toggle();

});



// ==========================================
// Acoes do textarea de Atividades
// ==========================================
$('#Atividade_Desenvolvidas_Aluno').keydown(function() {

  var postLength = $(this).val().length; // tamanho atual

  var charactersLeft = 480 - postLength; // caracteres que faltam 

  $('#contadorAtividades').text(charactersLeft); // seta o cantador com o valor acima

});

$('#Atividade_Desenvolvidas_Aluno').keyup(function() {

  var postLength = $(this).val().length; // tamanho atual

  var charactersLeft = 480 - postLength; // caracteres que faltam

  $('#contadorAtividades').text(charactersLeft); // seta o cantador com o valor acima

});

// ==========================================
// Acoes do textarea de Comentario Aluno
// ==========================================

$('#Comentario_Aluno').keydown(function() {

	  var postLength = $(this).val().length; // tamanho atual

	  var charactersLeft = 360 - postLength;// caracteres que faltam

	  $('#contadorComentario').text(charactersLeft);// seta o cantador com o valor acima

});

$('#Comentario_Aluno').keyup(function() {

	  var postLength = $(this).val().length; // tamanho atual

	  var charactersLeft = 360 - postLength;// caracteres que faltam

	  $('#contadorComentario').text(charactersLeft);// seta o cantador com o valor acima

});

// ==========================================
// Funcoes para validacao de data
// ==========================================

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

// ==========================================
// Funcao que ao clicar no botao salvar
// ==========================================

$("#Save").click(function(){

  var data = $("#data").val(); // pega o valor da data inicial 
  var data2 = $("#data1").val(); // pega o valor da data final

  if(!isValidDate2(data)){ // Checa data inicial
    alert("A Data Inicial inserida não é válida");
    return false;    
  }

  if(!isValidDate2(data2)){ // Checa data final
    alert("A Data Final não é válida");
    return false;    
  }

  data = data.split("/"); // Separa a data inicial em um vetor de 3 posicoes
  data2 = data2.split("/"); // Separa a data final em um vetor de 3 posicoes

  if(parseInt(data2[2])>=parseInt(data[2])){ // se o ano final é maior que o inicial
	if(parseInt(data2[1])>=parseInt(data[1])){ // se o mes final é maior que o inicial
		if(parseInt(data2[0])>parseInt(data[0])){ // se o dia final é maior que o inicial
			return true;
		}else{ // dia final nao é maior que o inicial
		  	alert("Intervalo não é válido");
		  	return false;
		}
	}else{ // mes final nao é maior que o inicial
	  	alert("Intervalo não é válido");
	  	return false;		  	
	}
  }else{ // ano final nao é maior que o inicial
  	alert("Intervalo não é válido");
  	return false;
  }

});

// ==========================================
// Funcao que ao clicar no botao submeter
// ==========================================

$("#Saves").click(function(){


  var data = $("#data").val(); // pega o valor da data inicial
  var data2 = $("#data1").val(); // pega o valor da data final

  if(!isValidDate2(data)){ // Checa data inicial
    alert("A Data Inicial inserida não é válida");
    return false;    
  }

  if(!isValidDate2(data2)){ // Checa data final
    alert("A Data Final não é válida");
    return false;    
  }

  data = data.split("/"); // Separa a data inicial em um vetor de 3 posicoes
  data2 = data2.split("/"); // Separa a data final em um vetor de 3 posicoes

  if(parseInt(data2[2])>=parseInt(data[2])){ // se o ano final é maior que o inicial
	if(parseInt(data2[1])>=parseInt(data[1])){ // se o mes final é maior que o inicial
		if(parseInt(data2[0])>parseInt(data[0])){ // se o dia final é maior que o inicial
			return true;
		}else{ // dia final nao é maior que o inicial
		  	alert("Intervalo não é válido");
		  	return false;
		}
	}else{ // mes final nao é maior que o inicial
	  	alert("Intervalo não é válido");
	  	return false;		  	
	}
  }else{ // ano final nao é maior que o inicial
  	alert("Intervalo não é válido");
  	return false;
  }

});

$(document).ready(function(){
  

	$('#contadorAtividades').text( 480-  $('#Atividade_Desenvolvidas_Aluno').val().length ); // Seta o contador( Atividades ) como o tamanho maximo - tam atual

	$('#contadorComentario').text( 360-  $('#Comentario_Aluno').val().length ); // Seta o contador(Comentario aluno) como o tamanho maximo - tam atual

	$("#data").mask("99/99/9999"); //Aplica mascara para data inicial
	$("#data1").mask("99/99/9999"); // Aplica mascara para data final

});