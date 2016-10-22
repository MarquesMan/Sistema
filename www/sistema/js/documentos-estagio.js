$(document).ready(function(){

		//$('a[href="' + location.hash + '"]').trigger('click');
		$('.glyphicon-comment').click(function(){
			alert($(this).attr('value'));
        });

		$('.dataTA').mask("99/99/9999");// Mascara

		function getUrlParameter(sParam){
			var sPageURL = window.location.search.substring(1);
			var sURLVariables = sPageURL.split('&');
			for (var i = 0; i < sURLVariables.length; i++) 
			{
				var sParameterName = sURLVariables[i].split('=');
				if (sParameterName[0] == sParam) 
				{
					return sParameterName[1];
				}
			}
		}

        $(".removerItem").click(function(e){

            e.stopPropagation();
            var escolha = confirm("Deseja realmente excluir este item?");
            if(!escolha)
                return false;
        });

		$("tr[name=plano]").click(function(e){

			if($(":nth-child(3)",this).html() == "Editável"){
				$("#myModalLabel").html("Editar Plano de Atividades");
				$("#myModalBody").empty();

				var xmlhttp = (window.XMLHttpRequest)?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");

				//Após receber os dados execute a seguinte função
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						$("#myModalBody").append(xmlhttp.responseText);
						Plano_java();
					}
				}

				//determina o metodo
				xmlhttp.open("POST","plano_de_atividades.php", true);
				
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				//Envia a requisição
				xmlhttp.send("idEstagio="+encodeURIComponent(getUrlParameter('idEstagio'))+"&plano="+encodeURIComponent($(this).attr('value')));
			}
		});

        $(".termoAditivoRow").click(function() {

            $("#termo_aditivo_data").attr("value",$(this).children(".dataP").html());
            $("#idTermoAditivo").val( $(this).attr("value") );
            $("#ComentarioTA").val($(this).attr("comentario"));
            $("#TAModal").modal('show');

        });


        $("#botaoTAModal").click(function(){

            if($("#termo_aditivo_arquivo").val() == ''){
                // your validation error action
                $("#termo_aditivo_arquivo").popover({content: "Termo Aditivo não é válido.",placement: "top"}).popover("show");
                return false;
            }

        });

        $("#botaoTAModalNovo").click(function(){

            if($("#novo_termo_aditivo_arquivo").val() == ''){
                // your validation error action
                $("#novo_termo_aditivo_arquivo").popover({content: "Termo Aditivo não é válido.",placement: "top"}).popover("show");
                return false;
            }

        });


		$("tr[name=relatorio]").click(function(e){
			$("#myModalLabel").html("Editar Relátorio");
			if($(":nth-child(3)",this).html() == "Editável"){
				$("#myModalBody").empty();

				var xmlhttp = (window.XMLHttpRequest)?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");

				//Após receber os dados execute a seguinte função
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						$("#myModalBody").append(xmlhttp.responseText);
						Relatorio_java();
					}
				}
				
				//determina o metodo
				xmlhttp.open("POST","relatorio.php", true);
				
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				//Envia a requisição
				xmlhttp.send("idEstagio="+encodeURIComponent(getUrlParameter('idEstagio'))+"&relatorio="+encodeURIComponent($(this).attr('value')));
			}
		});


		$("#BotaoNovoPlano").click(function(e){

			$("#myModalLabel").html("Novo Plano de Atividades");
			$("#myModalBody").empty();

			var xmlhttp = (window.XMLHttpRequest)?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");

			//Após receber os dados execute a seguinte função
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					$("#myModalBody").append(xmlhttp.responseText);
				}
			}
				
			//determina o metodo
			xmlhttp.open("GET","novo-plano-de-atividades.php?idEstagio="+getUrlParameter('idEstagio'), true);
				
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			//Envia a requisição
			xmlhttp.send();
		});

		$("#BotaoNovoRelatorio").click(function(e){
			$("#myModalLabel").html("Novo Relatorio");
			$("#myModalBody").empty();

			var xmlhttp = (window.XMLHttpRequest)?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");

			//Após receber os dados execute a seguinte função
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					$("#myModalBody").append(xmlhttp.responseText);
					Relatorio_java();
				}
			}
				
			//determina o metodo
			xmlhttp.open("GET","novo-relatorio.php?idEstagio="+getUrlParameter('idEstagio'), true);
				
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			//Envia a requisição
			xmlhttp.send();
		});



});	

// *******************************************************************************

// ===================================================
// Quando plano de atividades é aberto
// ===================================================
function Plano_java(){

	$('.glyphicon-comment').click(function(){
		alert( $(this).attr("value") );
	});


	var horarios= {}

	var nomes = ["segunda1","segunda2","terca1", "terca2" , "quarta1" , "quarta2", "quinta1" , "quinta2" , "sexta1" , "sexta2", "sabado1" , "sabado2" ]

	document.getElementById("carga").value = "0:0";
	document.getElementById("carga").disabled = true;

	$('.counter').text( 497-  $('#Atividades_Desenvolvidas').val().length );


	$("#removePlano").click(function(e){

            e.stopPropagation();
    });

  	$('.status-box').keydown(function(){

		var postLength = $(this).val().length;

	  	var charactersLeft = 497 - postLength;

	  	$('.counter').text(charactersLeft);
	});

	$('.status-box').keyup(function() {

	  	var postLength = $(this).val().length;

	  	var charactersLeft = 497 - postLength;

	  	$('.counter').text(charactersLeft);
  	});

  	$('[linha="1"]').each(function(){ // Para cada input
  		var Filhos = $(this).children();
		var string1, string2, valorAtual, auxiliarCalculoMinutos;
		var cargaValorHoras, cargaValorMinutos;

		horarios[Filhos[0].name] = Filhos[0].value;

		horarios[Filhos[2].name] = Filhos[2].value;

		if( (Filhos[0].value!=""&&Filhos[2].value!="") ){		

			string1 = Filhos[0].value;
			string2 = Filhos[2].value;
			
			valorAtual = document.getElementById("carga").value;
			valorAtual = valorAtual.split(":");

			string1 = string1.split(":");
			string2 = string2.split(":");

			auxiliarCalculoMinutos = (parseInt(string2[1]) - parseInt(string1[1]) );

			if(auxiliarCalculoMinutos<0){
				cargaValorMinutos = parseInt(valorAtual[1]) + (59+auxiliarCalculoMinutos);
				cargaValorHoras   = parseInt(valorAtual[0]) + (parseInt(string2[0]) - parseInt(string1[0]) ) -1;
			}
			else{
				cargaValorMinutos = parseInt(valorAtual[1]) + auxiliarCalculoMinutos;
				cargaValorHoras   = parseInt(valorAtual[0]) + (parseInt(string2[0]) - parseInt(string1[0]) );	
			}

			cargaValorHoras = parseInt(cargaValorHoras)+cargaValorMinutos/60;
			cargaValorMinutos = cargaValorMinutos%60;

			document.getElementById("carga").value = parseInt(cargaValorHoras)+":"+parseInt(cargaValorMinutos);

	}

	});// Fim para

  	//===================================================================
	//          verifica os horarios do plano de atividades
	//===================================================================
	function recalculaHorarios(){
	    var Filhos = {};
	    var string1, string2;
	    var auxiliarCalculoMinutos;
	    var cargaValorHoras, cargaValorMinutos;

	    cargaValorHoras = 0;
	    cargaValorMinutos = 0;

	    $('[linha="1"]').each(function(){ // para cada linha de horario

	        Filhos = $(this).children(); // pega os filhos  

	        if( (Filhos[0].value!=""&&Filhos[2].value!="") ){
	            string1 = Filhos[0].value;
	            string2 = Filhos[2].value;
	            string1 = string1.split(":"); // separar por ':'
	            string2 = string2.split(":"); // separar por ':'

	            auxiliarCalculoMinutos = (parseInt(string2[1]) - parseInt(string1[1]) ); // pega diferencas entre os minutos 

	            if(auxiliarCalculoMinutos<0){// se for negativo
	                cargaValorMinutos = cargaValorMinutos + (59+auxiliarCalculoMinutos); // reseta os minutos e soma com o anterior
	                cargaValorHoras = parseInt(cargaValorHoras) +(parseInt(string2[0]) - parseInt(string1[0]) ) -1; // decremeneta hora
	                                                                                                                // somando com os outros
	            }
	            else{ // se for normal
	                cargaValorMinutos = cargaValorMinutos + auxiliarCalculoMinutos; // soma minutos com o anterior
	                cargaValorHoras = parseInt(cargaValorHoras) +(parseInt(string2[0]) - parseInt(string1[0]) ); // soma horas com o valor anterior 
	            }
	        }
	    });

	    cargaValorHoras = parseInt(cargaValorHoras) + cargaValorMinutos/60; // valor de horas com as horas extraidas dos minutos 
	    cargaValorMinutos = cargaValorMinutos%60; // minutos definitivos restantes

	    if(cargaValorHoras>30){// se a carga horaria for maior que 30h
	        $("#carga").popover({content: "Carga Horária excede 30h semanais.",placement: "top"}).popover("show");
	    }
	    else if(cargaValorHoras==30&&cargaValorMinutos>0){// se a carga horaria nao for 30h redondos
	        $("#carga").popover({content: "Carga Horária excede 30h semanais.",placement: "top"}).popover("show");
	    }
	    else{// se a carga horaria for menor ou igual 30h
	        $("#carga").popover("destroy"); // remove erro
	    }
	    if($.isNumeric(cargaValorHoras)){
	        document.getElementById("carga").value = parseInt(cargaValorHoras)+":"+parseInt(cargaValorMinutos); // atribui o valor pra o elemento
	    }
	    else{
	        document.getElementById("carga").value = "Infinito";
	    }
	}

	$('[horario="1"]').blur(function(){
		var value = $(this).val().split(":");

		if( (parseInt(value[0])>24)|| (parseInt(value[1])>59)){
			$(this).focus();
			$(this).parent("div").popover({content: "Hora inválida",placement: "top"}).popover("show");
			return false;
		}
		
		$(this).parent("div").popover("destroy");
		var Filhos = $(this).parent("div").children();
		var string1, string2;
		var cargaValorHoras, cargaValorMinutos;

		if( (Filhos[0].value!=""&&Filhos[2].value!="") ){		

			string1 = Filhos[0].value;
			string2 = Filhos[2].value;
			

			horarios[Filhos[0].name] = string1[1];
			horarios[Filhos[2].name] = string2[0];
				
		}
			recalculaHorarios();
			document.getElementById('carga').setAttribute("boolt","0");
			$('#carga').css( {"border-color":"","border-style":"inset","border-width":"1px"});

	});

  	$("input").each(function(){ // Para cada input
		if($(this).attr("boolt") == 1){ // Se o atributo dele na array bool for 1
	  		$(this).css( {"border-color":"rgba(255,0,0, 0.8)","border-style":"solid","border-width":"1px"});
	 		// Defina o background como vermelho
		}
	});// Fim para

  	$("textarea").each(function(){
		if($(this).attr("boolt") == 1){ // Se o atributo dele na array bool for 1
			$(this).css( {"border-color":"rgba(255,0,0, 0.8)","border-style":"solid","border-width":"1px"});
		   // Defina o background como vermelho
		}
  	});

  	function isValidDate(s) {
		var bits = s.split('/');
		var y = bits[2], m  = bits[1], d = bits[0];
		// Assume not leap year by default (note zero index for Jan)
		var daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];

		// If evenly divisible by 4 and not evenly divisible by 100,
		// or is evenly divisible by 400, then a leap year
		if ( (!(y % 4) && y % 100) || !(y % 400)) {
	  		daysInMonth[1] = 29;
		}

		return d <= daysInMonth[--m];
  	}


  	//===================================================================
	//          verifica os horarios do plano de atividades
	//===================================================================
	function verificaDatas(){ 
	    
	    var certo = true; // variavel que indica se as datas estao certas
	    var Filhos = {};
	    var string1,string2, cargaValorHoras,cargaValorMinutos;

	    $('[linha="1"]').each(function(){ // cada intervalo de horarios

	        Filhos = $(this).children(); // pega os filhos da linha 

	        if( (Filhos[0].value!=""&&Filhos[2].value!="") ){// se ambos forem vazios, ignora-se, assume que nao tem horario naquele dia   

	            string1 = Filhos[0].value; // pega valor no formato 00:00
	            string2 = Filhos[2].value; // pega valor no formato 00:00
	            string1 = string1.split(":"); // separa pelos ':' 
	            string2 = string2.split(":"); // separa pelos ':'

	            // imagine que os valores sejam 6:45  e 12:15 
	            auxiliarCalculoMinutos = (parseInt(string2[1]) - parseInt(string1[1]) );// pega diferencas entre os minutos, no exemplo
	                                                                                    // o valor fica 15-45=-30

	            if(auxiliarCalculoMinutos<0){ // se for negativo , o que eh no caso de -30
	                cargaValorMinutos = (59+auxiliarCalculoMinutos); // reseta os numeros, no caso, 29 
	                cargaValorHoras = (parseInt(string2[0]) - parseInt(string1[0]) ) -1; // decrementa uma hora do valor, ja que se resetou os min
	            }
	            else{ // se for normal
	                cargaValorMinutos =  auxiliarCalculoMinutos; // atribui para o valor sem nenhuma alteracao
	                cargaValorHoras = (parseInt(string2[0]) - parseInt(string1[0]) ); 
	            }
	            
	            if(cargaValorHoras>6){ // se o valor ficar mais de 6, da erro
	                $(this).popover({content: "Mais de 6h diárias.",placement: "top"}).popover("show");
	                certo = false; // eh errado
	                return false;
	            }
	            else if(cargaValorHoras==6&&cargaValorMinutos>0){ // se nao for 6h redondo 
	                $(this).popover({content: "Mais de 6h diárias.",placement: "top"}).popover("show");
	                certo = false; // eh errado
	                return false; 
	            }
	        }
	    });

		$('[horario="1"]').each(function(){
			var value = $(this).val().split(":");

			if( (parseInt(value[0])>24)|| (parseInt(value[1])>59)){
				$(this).focus();
				$(this).parent("div").popover({content: "Hora inválida",placement: "top"}).popover("show");
				certo = false;
				return false;
			}

		});

		if(certo==false){
			return false;
		}

		var CargaHorariaAtual = $("#carga").val();

		CargaHorariaAtual = CargaHorariaAtual.split(":");

		if(parseInt(CargaHorariaAtual[0])>30){
			$("#carga").popover({content: "Carga Horária excede 30h semanais.",placement: "top"}).popover("show");
			return false;
		}
		else if(parseInt(CargaHorariaAtual[0])==30&&parseInt(CargaHorariaAtual[1])>0){
			$("#carga").popover({content: "Carga Horária excede 30h semanais.",placement: "top"}).popover("show");
			return false;
		}
		else{
			$("#carga").popover("destroy");
		}


  		if( ($("#segunda1").val().length==0&&$("#segunda2").val().length>0)||($("#segunda1").val().length>0&&$("#segunda2").val().length==0)){
			$("#segunda1").parent("div").popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
			$("#segunda1").focus();	
			return false;

		}
		else if( ($("#terca1").val().length==0&&$("#terca2").val().length>0)||($("#terca1").val().length>0&&$("#terca2").val().length==0)){
  			$("#terca1").parent("div").popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
			$("#terca1").focus();	
			return false;
		}
		else if( ($("#quarta1").val().length==0&&$("#quarta2").val().length>0)||($("#quarta1").val().length>0&&$("#quarta2").val().length==0)){
  			$("#quarta1").parent("div").popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
			$("#quarta1").focus();	
			return false;
		}
		else if( ($("#quinta1").val().length==0&&$("#quinta2").val().length>0)||($("#quinta1").val().length>0&&$("#quinta2").val().length==0)){
  			$("#quinta1").parent("div").popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
			$("#quinta1").focus();	
			return false;
		}
		else if( ($("#sexta1").val().length==0&&$("#sexta2").val().length>0)||($("#sexta1").val().length>0&&$("#sexta2").val().length==0)){
  			$("#sexta1").parent("div").popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
			$("#sexta1").focus();	
			return false;
		}
		else if( ($("#sabado1").val().length==0&&$("#sabado2").val().length>0)||($("#sabado1").val().length>0&&$("#sabado2").val().length==0)){
  			$("#sabado1").parent("div").popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
			$("#sabado1").focus();	
			return false;
		}

		if(($("#segunda1").val()>=$("#segunda2").val())&&($("#segunda1").val().length!=0)&&($("#segunda2").val().length!=0)  ){
  			$("#segunda1").parent("div").popover({content: "Hora de ínicio deve ser menor que a de término.",placement: "top"}).popover("show");
			document.getElementById("segunda1").focus();	
			return false;

		}
		else if(($("#terca1").val()>=$("#terca2").val())&&$("#terca1").val().length!=0&&$("#terca2").val().length!=0 ){
			$("#terca1").parent("div").popover({content: "Hora de ínicio deve ser menor que a de término.",placement: "top"}).popover("show");
			document.getElementById("terca1").focus();
			return false;
		}
		else if(($("#quarta1").val()>=$("#quarta2").val())&&$("#quarta1").val().length!=0&&$("#quarta2").val().length!=0 ){
			$("#quarta1").parent("div").popover({content: "Hora de ínicio deve ser menor que a de término.",placement: "top"}).popover("show");
			document.getElementById("quarta1").focus();
			return false;
		}
		else if(($("#quinta1").val()>=$("#quinta2").val())&&$("#quinta1").val().length!=0&&$("#quinta2").val().length!=0 ){
			$("#quinta1").parent("div").popover({content: "Hora de ínicio deve ser menor que a de término.",placement: "top"}).popover("show");
			document.getElementById("quinta1").focus();
			return false;
		}
		else if(($("#sexta1").val()>=$("#sexta2").val())&&$("#sexta1").val().length!=0&&$("#sexta2").val().length!=0 ){
			$("#sexta1").parent("div").popover({content: "Hora de ínicio deve ser menor que a de término.",placement: "top"}).popover("show");
			document.getElementById("sexta1").focus();
			return false;
		}
		else if(($("#sabado1").val()>=$("#sabado2").val())&&$("#sabado1").val().length!=0&&$("#sabado2").val().length!=0 ){
			$("#sabado1").parent("div").popover({content: "Hora de ínicio deve ser menor que a de término.",placement: "top"}).popover("show");
			document.getElementById("sabado1").focus();
			return false;
		}

  	}

  	$("#Save").click(function(){ // Caso o usuario clique em salvar 

  		if(verificaDatas()==false){
  			return false;
  		}

		var erros = "";

		erros =   erros
		+		$('#local').attr("boolt")+";"
		+       $('#carga').attr("boolt")+";"
		+       $('#data').attr("boolt")+";"
		+       $('#segunda1').attr("boolt")+";"
		+       $('#segunda2').attr("boolt")+";"
		+       $('#terca1').attr("boolt")+";"
		+       $('#terca2').attr("boolt")+";"
		+       $('#quarta1').attr("boolt")+";"
		+       $('#quarta2').attr("boolt")+";"
		+       $('#quinta1').attr("boolt")+";"
		+       $('#quinta2').attr("boolt")+";"
		+       $('#sexta1').attr("boolt")+";"
		+       $('#sexta2').attr("boolt")+";"
		+       $('#sabado1').attr("boolt")+";"
		+       $('#sabado2').attr("boolt")+";"
		+       $('#Atividades_Desenvolvidas').attr("boolt");
		

		
		

		$("#erros").val(erros); // atribui o valor a o hidden input

		var data = $("#data").val(); // pega o valor do input data

		var result = $("#segunda1").val()+";"+$("#segunda2").val()+";"+$("#terca1").val()+";"+$("#terca2").val()+";"+$("#quarta1").val()+";"+$("#quarta2").val()+";"+$("#quinta1").val()+";"+$("#quinta2").val()+";"+$("#sexta1").val()+";"+$("#sexta2").val()+";"+$("#sabado1").val()+";"+$("#sabado2").val();
		$("#horarios").val(result);// Concatena todos os horarios
		recalculaHorarios();
		if(!isValidDate(data)){// Verifica se a data eh valida
	  		alert("A data inserida não é válida");
	  		return false;    
		} // fim se
		
		
	}); // Fim funcao Salvar


  	$('input').focus(function(){ // Para cada input ao ser clicado

		if($(this).attr("boolt") == 1){
	  		this.setAttribute("boolt","0");
	  		$(this).css( {"border-color":"", "border-style":"inset","border-width":"2px"} ); // define o background de branco
		}
  	}); // Fim para

  	$('#Atividades_Desenvolvidas').focus(function(){ // Para cada input ao ser clicado

		if($(this).attr("boolt") == 1){
	  		this.setAttribute("boolt","0");
	  		$(this).css("border-color", ""); // define o background de branco
		}
  	}); // Fim para

	$("#Saves").click(function(){ // Caso o usuario clique em submeter 
		var contadorDeErros = 0;

  		if(verificaDatas()==false){
  			return false;
  		}

		$("input").each(function(){ // Para cada input
			if($(this).attr("boolt") == 1){ // Se o atributo dele na array bool for 1
	   			contadorDeErros = contadorDeErros + 1; // Increment o contador de erros
	  		}
		});// Fim para

		if($('#descricao').attr("boolt") == 1){
	  		contadorDeErros = contadorDeErros + 1;
	 	}

	 	if(contadorDeErros>1){ // Caso haja mais de um erro
	  		var escolha = confirm(contadorDeErros+" erros pendentes!\nDeseja enviar assim mesmo?");	 
	 	}

	 	else if(contadorDeErros==1){ // Caso um erro for encontrado
	  		var escolha = confirm(contadorDeErros+" erro pendente!\nDeseja enviar assim mesmo?");
	 	}


		if (escolha == false) {
			return false;
		}

		var data = $("#data").val(); // pega o valor do input data

			
		verificaDatas();


		var result = $("#segunda1").val()+";"+$("#segunda2").val()+";"+$("#terca1").val()+";"+$("#terca2").val()+";"+$("#quarta1").val()+";"+$("#quarta2").val()+";"+$("#quinta1").val()+";"+$("#quinta2").val()+";"+$("#sexta1").val()+";"+$("#sexta2").val()+";"+$("#sabado1").val()+";"+$("#sabado2").val();
	
		$("#horarios").val(result); // Concatena todos os horarios
		recalculaHorarios();
		if(!isValidDate(data)){ // Verifica se a data eh valida
	  		alert("A data inserida não é válida");
	  		return false;    
		} 
  	});// Fim funcao submeter
	

  $("#data").mask("99/99/9999");// Mascara
  $("#segunda1").mask("99:99");// Mascara
  $("#segunda2").mask("99:99");// Mascara
  $("#terca1").mask("99:99");// Mascara
  $("#terca2").mask("99:99");// Mascara
  $("#quarta1").mask("99:99");// Mascara
  $("#quarta2").mask("99:99");// Mascara
  $("#quinta1").mask("99:99");// Mascara
  $("#quinta2").mask("99:99");// Mascara
  $("#sexta1").mask("99:99");// Mascara
  $("#sexta2").mask("99:99");// Mascara
  $("#sabado1").mask("99:99");// Mascara
  $("#sabado2").mask("99:99");// Mascara

}
// ===================================================
// Fim plano de atividades
// ===================================================

// ************************************************************************************************************

// ===================================================
// Quando um relatorio é aberto
// ===================================================
function Relatorio_java(){


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

		return verificaDatasRelatorio();

 	});// Fim funcao salvar


	$("#Saves").click(function(){ // Caso o usuario clique em submeter 

		if(!verificaDatasRelatorio())
			return false;
		
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
}//Fim relatorio_java