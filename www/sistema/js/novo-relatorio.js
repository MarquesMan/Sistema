$(document).ready(function(){

		$('#contadorAtividades').text( 480-  $('#Atividade_Desenvolvidas_Aluno').val().length ); // Seta o contador( Atividades ) como o tamanho maximo - tam atual

		$('#contadorComentario').text( 360-  $('#Comentario_Aluno').val().length ); // Seta o contador(Comentario aluno) como o tamanho maximo - tam atual

		$("#data").mask("99/99/9999"); //Aplica mascara para data inicial
		$("#data1").mask("99/99/9999"); // Aplica mascara para data final

	});

	$('.glyphicon-comment').click(function(){

 		alert( $(this).attr("value") );
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


	function isValidDate(s){
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

  	function verificaDatasRelatorio(){

		  var data = $("#data").val(); // pega o valor da data inicial 
		  var data2 = $("#data1").val(); // pega o valor da data final

		  if(!isValidDate(data)){ // Checa data inicial
		    $("#data").popover({content: "A Data Inicial inserida não é válida.",placement: "top"}).popover("show");
		    return false;    
		  }

		  if(!isValidDate(data2)){ // Checa data final
		  	$("#data1").popover({content: "A Data Final não é válida.",placement: "top"}).popover("show");
		    return false;    
		  }

		  data = data.split("/"); // Separa a data inicial em um vetor de 3 posicoes
		  data2 = data2.split("/"); // Separa a data final em um vetor de 3 posicoes

		  if(parseInt(data2[2])>=parseInt(data[2])){ // se o ano final é maior que o inicial

		  	if(parseInt(data2[2])>parseInt(data[2])){
		  		return true;
		  	}else{

		  		if(parseInt(data2[1])>=parseInt(data[1])){ // se o mes final é maior que o inicial
					
					if(parseInt(data2[1])>parseInt(data[1])){
						return true;
					}else{
						if(parseInt(data2[0])>parseInt(data[0])){ // se o dia final é maior que o inicial
							return true;
						}else{ // dia final nao é maior que o inicial
						  	$("#datas").popover({content: "Intervalo não é válido.",placement: "top"}).popover("show");
						  	return false;
						}
					}
				}else{ // mes final nao é maior que o inicial
				  	$("#datas").popover({content: "Intervalo não é válido.",placement: "top"}).popover("show");
					  	return false;	  	
				}
		  	}

		  }else{ // ano final nao é maior que o inicial
		  	$("#datas").popover({content: "Intervalo não é válido.",placement: "top"}).popover("show");
		  	return false;
		  }

  	}

	if($("#data").attr("boolt") == 1){ // Se o atributo dele na array bool for 1
	  $("#data").css( {"border-color":"rgba(255,0,0, 0.8)","border-style":"solid","border-width":"1px"});
	 // Defina o background como vermelho
	}

	if($("#data1").attr("boolt") == 1){ // Se o atributo dele na array bool for 1
		  $("#data1").css( {"border-color":"rgba(255,0,0, 0.8)","border-style":"solid","border-width":"1px"});
		 // Defina o background como vermelho
	}


  	if($("#radio1").attr("boolt") == 1){ // Se o atributo dele na array bool for 1
		var pai = $("#radio1").parent("div");
		pai.css( {"border-color":"rgba(255,0,0, 0.8)","border-style":"solid","border-width":"1px"});
		pai.css("border-radius", "7px");

	}

	//usarei apenas o radio para alterar os valores relativos ao bool do tipo de estagio

	$("#radio1").focus(function(){ // ao clicar no botao em que foi atribuido o radio 1
		this.setAttribute("boolt","0"); // usuario corrigiu o erro
		var pai = $("#radio1").parent("div"); // pega o td pai dos radios	
		pai.css("border-color","white"); // retira a borda

	}); // Fim 	

	$("#radio2").focus(function(){ // ao clicar no botao em que foi atribuido o radio 2, que e o valor errado
		document.getElementById('radio1').setAttribute("boolt","1"); // volta o bool para errado, ja que o radio 2 sera sempre a opcao errada
		var pai = $("#radio1").parent("div");	// pega o td pai dos radios	
		pai.css( {"border-color":"rgba(255,0,0, 0.8)","border-style":"solid","border-width":"1px"}); // seta o background para vermelho
		pai.css("border-radius", "7px"); // retira a borda

	}); // Fim


	$("#data").focus(function(){ 
		 $(this).css("border-color", "");
		 this.setAttribute("boolt","0");
	}); // Fim 	

	$("#data1").focus(function(){ 
		$(this).css("border-color", "");
		this.setAttribute("boolt","0");
	}); // Fim 	 	
			

	$("textarea").each(function(){
		if($(this).attr("boolt") == 1){ // Se o atributo dele na array bool for 1
		  $(this).css( {"border-color":"rgba(255,0,0, 0.8)","border-style":"solid","border-width":"1px"});
		 // Defina o background como vermelho
		}
	});


	$("textarea").focus(function(){
		if($(this).attr("boolt") == 1){ // Se o atributo dele na array bool for 1
		  $(this).css("border-color", "");
		 // Defina o background como vermelho
			this.setAttribute("boolt","0");
		}
	});

	$("#Save").click(function(){ // Caso o usuario clique em salvar 

		var erros = ""; // string inicial de erros

	 	var contadorDeErros = 0; // contador de erros

		erros =   erros+$('#data').attr("boolt")+";"
				+       $('#data1').attr("boolt")+";"
				+       $('#radio1').attr("boolt")+";"
				+       $('#Atividade_Desenvolvidas_Aluno').attr("boolt")+";"
				+       $('#Comentario_Aluno').attr("boolt");

		$("#erros").val(erros); // atribui o valor a o hidden input

		var data = $("#data").val(); // pega o valor do input data

		if(!isValidDate(data)){ // Verifica se a data eh valida
	  		alert("A Data Inicial inserida não é válida");
	  		return false;    
		}

		var data1 = $("#data1").val(); // pega o valor do input data

		if(!isValidDate(data1)){ // Verifica se a data eh valida
	  		alert("A Data Final inserida não é válida"); 
	  		return false;     
		}  

		return verificaDatasRelatorio();

 	});// Fim funcao salvar


	$("#Saves").click(function(){ // Caso o usuario clique em submeter 

		var data = $("#data").val(); // pega o valor do input data

		if(!isValidDate(data)){ // Verifica se a data eh valida
		  	alert("A Data Inicial inserida não é válida");
		  	return false;    
		}

		var data1 = $("#data1").val(); // pega o valor do input data

		if(!isValidDate(data1)){ // Verifica se a data eh valida
			alert("A Data Final inserida não é válida");
		  	return false;    
		}  

		verificaDatasRelatorio();
		
		var contadorDeErros = 0; // contador de erros

		$("input").each(function(){ // Para cada input
		  	if($(this).attr("boolt") == 1){ // Se o atributo dele na array bool for 1
		   		contadorDeErros = contadorDeErros + 1; // Increment o contador de erros
		}

		});// Fim para

		$("textarea").each(function(){ // Para cada input
			if($(this).attr("boolt") == 1){ // Se o atributo dele na array bool for 1
		   		contadorDeErros = contadorDeErros + 1; // Increment o contador de erros
		}

		});// Fim para


		if(contadorDeErros>1){ // Caso haja mais de um erro
		 	var escolha = confirm(contadorDeErros+" erros pendentes!\nDeseja enviar assim mesmo?");	 
		}

		else if(contadorDeErros==1){ // Caso um erro for encontrado
		  	var escolha = confirm(contadorDeErros+" erro pendente!\nDeseja enviar assim mesmo?");
		}


		if (escolha == false) {
			return false;
		}

  	});// Fim funcao submeter

/*
$(document).ready(function(){
	$('#contadorAtividades').text( 480-  $('#Atividade_Desenvolvidas_Aluno').val().length );

	$('#Atividade_Desenvolvidas_Aluno').keydown(function() {

	  var postLength = $(this).val().length;

	  var charactersLeft = 480 - postLength;

	  $('#contadorAtividades').text(charactersLeft);

	});

	$('#Atividade_Desenvolvidas_Aluno').keyup(function() {

	  var postLength = $(this).val().length;

	  var charactersLeft = 480 - postLength;

	  $('#contadorAtividades').text(charactersLeft);

	});

	$('#contadorComentario').text( 360-  $('#Comentario_Aluno').val().length );

	$('#Comentario_Aluno').keydown(function() {

	  var postLength = $(this).val().length;

	  var charactersLeft = 360 - postLength;

	  $('#contadorComentario').text(charactersLeft);

	});

	$('#Comentario_Aluno').keyup(function() {

	  var postLength = $(this).val().length;

	  var charactersLeft = 360 - postLength;

	  $('#contadorComentario').text(charactersLeft);

	});

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

	$("#data").mask("99/99/9999");
	$("#data1").mask("99/99/9999");

	$('input[type="text"]').click(function(){
		$(this).popover("destroy");
	});
	$("#Save").click(function(){
	
  
	  var data = $("#data").val();
	  var data2 = $("#data1").val();

	  if(!isValidDate2(data)){
	    $("#data").popover({content: "A Data Inicial inserida não é válida.",placement: "top"}).popover("show");
	    return false;    
	  }

	  if(!isValidDate2(data2)){
	    $("#data1").popover({content: "A Data Final inserida não é válida.",placement: "top"}).popover("show");
	    return false;    
	  }

	  data = data.split("/");
	  data2 = data2.split("/");

	  if(parseInt(data2[2])>=parseInt(data[2])){
		if(parseInt(data2[1])>=parseInt(data[1])){
			if(parseInt(data2[0])>parseInt(data[0])){
				return true;
			}else{
			  	 $("#intervalos").popover({content: "Intervalo não é válido.",placement: "top"}).popover("show");
			  	return false;
			}
		}else{
		  	 $("#intervalos").popover({content: "Intervalo não é válido.",placement: "top"}).popover("show");
		  	return false;		  	
		}
	  }else{
	  	 $("#intervalos").popover({content: "Intervalo não é válido.",placement: "top"}).popover("show");
	  	return false;
	  }

  });


});*/