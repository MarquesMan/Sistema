//===================================================================
//                        Verifica a data 
//===================================================================
function isValidDate(s) { // valida a data
    var bits = s.split('/'); // separar a string por '/'
    var y = bits[2], m  = bits[1], d = bits[0]; // atribui os numeros em anos, meses, dias
    // dias dos meses, janeiro = 0)
    var daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31]; 

    //se divisel por 4 e nao por 100,
    // or se eh divisivel por 400, ano bissexto
    if ( (!(y % 4) && y % 100) || !(y % 400)) {
        daysInMonth[1] = 29;
    }

    return d <= daysInMonth[--m] // decrementa o ano para ficar no formato [0-11], e verifica se os dias batem 
}

//===================================================================
//                      Minuto para String
//===================================================================
function MinToString(Min){
    var Str = "";
    //Calculando as horas
    if(Min/60 < 10)
        Str = "0" +  String(Min/60);
    else
        Str = String(Min/60);
    //Calculando os minutos
    if(Min%60 < 10)
        Str = Str + ":" +  "0" +  String(Min%60);
    else
        Str = Str + ":" +  String(Min%60);
    return Str;
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


//===================================================================
//          Verifica se plano de atividades esta invisivel
//===================================================================
function checaVisibilidadePlano(){

    if($("#planoEstagio").is(':visible')) {// checa se atributo esta visivel
        // faca nada
    }else{
        $( ".row" ).hide();
        $("#planoEstagio").show();
    }

}

//===================================================================
//          Verifica se o painel de Informacoes esta invisivel
//===================================================================
function checaVisibilidadeInfo(){

    if($("#infoEstagio").is(':visible')) {// checa se atributo esta visivel
        // faca nada
    }else{
        $( ".row" ).hide();
        $("#infoEstagio").show();
    }

}

//===================================================================
//          Verifica se o painel de Informacoes esta invisivel
//===================================================================
function checaVisibilidadeTermo(){

    if($("#termoEstagio").is(':visible')) {// checa se atributo esta visivel
        // faca nada
    }else{
        $( ".row" ).hide();
        $("#termoEstagio").show();
    }

}


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

$(document).ready(function(){

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

	$('.glyphicon-comment').click(function(){
		alert( $(this).attr("value") );
	});


	//============================================================
	// 						Info do Estagio
	//============================================================


	$("#InfoBotaoDireita").click(function(){

	    $( ".row" ).hide("fast");
	    $("#planoEstagio").show("fast");

  	});

  	// atribuicao de mascaras
	$("#dataFinal").mask("99/99/9999");
  	$("#dataInicial").mask("99/99/9999");

	//============================================================
	// 						Termo Estagio
	//============================================================

	    $("#TermoBotaoEsquerda").click(function(){

	        $( ".row" ).hide("fast");
	        $("#planoEstagio").show("fast");

	    });

	    $("#termo_arquivo").click(function(){
	        $("#termo_arquivo").popover("destroy");
	    }); 

	//============================================================
	// 						Plano de Atividades
	//============================================================

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


	$("#PlanoBotaoEsquerda").click(function(){

	    $( ".row" ).hide("fast");
	    $("#infoEstagio").show("fast");

  	});

	$("#PlanoBotaoDireita").click(function(){

	    $( ".row" ).hide("fast");
    	$("#termoEstagio").show("fast");

	});

	var horarios= {}

	var nomes = ["segunda1","segunda2","terca1", "terca2" , "quarta1" , "quarta2", "quinta1" , "quinta2" , "sexta1" , "sexta2", "sabado1" , "sabado2" ]

	document.getElementById("carga").value = "0:0";
	//document.getElementById("carga").disabled = true;

	$('.counter').text( 497-  $('#Atividades_Desenvolvidas').val().length );


	$("#removePlano").click();

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
			$('#carga').css( {"border-color":"#777","border-width":"1px"});

	});

	$("input").each(function(){ // Para cada input
		if($(this).attr("boolt") == 1){ // Se o atributo dele na array bool for 1
	  		$(this).css( {"border-color":"rgba(255,0,0, 0.8)","border-style":"solid","border-width":"1px"});
	 		// Defina o background como vermelho
		}
	});// Fim para

  	$("select").each(function(){ // Para cada input
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

		

  	$("#SalvarEstagio").click(function(){

    //===================================================================
    //                 verificacao das informacoes do estagio
    //===================================================================

    var dataFinal=$("#dataFinal").val();
    var dataInicial = $("#dataInicial").val();


    if(!isValidDate(dataInicial)){
        checaVisibilidadeInfo();
        $("#dataInicial").popover({content: "Data Inicial não é válida.",placement: "top"}).popover("show");
        return false;    
    }else{
        $("#dataInicial").popover("destroy");
    }
   

    if(!isValidDate(dataFinal)){
        checaVisibilidadeInfo();
        $("#dataFinal").popover({content: "Data final não é válida.",placement: "top"}).popover("show");
        return false;    
    }else{
        $("#dataFinal").popover("destroy");
    }

    dataInicial = dataInicial.split("/");
    dataFinal = dataFinal.split("/");

    if(parseInt(dataFinal[2])==parseInt(dataInicial[2])){// ano final igual ao inicial
        if(parseInt(dataFinal[1])==parseInt(dataInicial[1])){ // mes final  igual ao inicial
            if(parseInt(dataFinal[0])>parseInt(dataInicial[0])){
              // passa na verificacao
              $("#dataInicial").popover("destroy");
            }else{
                checaVisibilidadeInfo();
                $("#dataInicial").popover({content: "Intervalo não é válido.",placement: "top"}).popover("show");                
                return false;
            }
        }
        else if(parseInt(dataFinal[1])>parseInt(dataInicial[1])){ // mes final maior que o inicial
            //passa na checagem
            $("#dataInicial").popover("destroy");
        }
        else{
            checaVisibilidadeInfo();
            $("#dataInicial").popover({content: "Intervalo não é válido.",placement: "top"}).popover("show");
            return false;       
        }
    }else if(parseInt(dataFinal[2])>parseInt(dataInicial[2])){// ano final maior que o inicial
        //passa na checagem
        $("#dataInicial").popover("destroy");
    }else{// ano final menor
      checaVisibilidadeInfo();
      $("#dataInicial").popover({content: "Intervalo não é válido.",placement: "top"}).popover("show");
      return false;
    }

    //===================================================================
    //             Fim verificacao das informacoes do estagio
    //===================================================================

    //===================================================================
    //              Verificacao do plano de atividades do estagio
    //===================================================================

    if(verificaDatas()==false){
        checaVisibilidadePlano();// verifica se o plano esta visivel
        return false;
    }

    var data = $("#data").val();

    var result = $("#segunda1").val()+";"+$("#segunda2").val()+";"+$("#terca1").val()+";"+$("#terca2").val()+";"+$("#quarta1").val()+";"+$("#quarta2").val()+";"+$("#quinta1").val()+";"+$("#quinta2").val()+";"+$("#sexta1").val()+";"+$("#sexta2").val()+";"+$("#sabado1").val()+";"+$("#sabado2").val();
    $("#horarios").val(result);

    recalculaHorarios();

    if(!isValidDate(data)){
        //alert("A data inserida não é válida");
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#data").popover({content: "A data inserida não é válida.",placement: "top"}).popover("show");    
        return false;
    }

    var CargaHorariaAtual = $("#carga").val();// pega o valor da carga

    CargaHorariaAtual = CargaHorariaAtual.split(":"); // separa

    if(parseInt(CargaHorariaAtual[0])>30){ // carga horaria eh maior?
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#carga").popover({content: "Carga Horária excede 30h semanais.",placement: "top"}).popover("show");
        return false;
    }
    else if(parseInt(CargaHorariaAtual[0])==30&&parseInt(CargaHorariaAtual[1])>0){ // nao eh redonda?
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#carga").popover({content: "Carga Horária excede 30h semanais.",placement: "top"}).popover("show");
        return false;
    }
    else{ // esta dentro do limite de 30h
        $("#carga").popover("destroy");
    }

    // deixe me esplicar... ambos os valores podem estar vazios, porem, nao pode se deixar apenas um deles vazio
    // a verificacao ficou meio bizarra mas eh isso ai

    //===================================================================
    //        Verificacao dos valores, se sao vazios ou nao
    //===================================================================
    if( ($("#segunda1").val().length==0&&$("#segunda2").val().length>0)||($("#segunda1").val().length>0&&$("#segunda2").val().length==0)){
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#segunda1").parent("div").popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
        $("#segunda1").focus(); 
        return false;
    }
    else if( ($("#terca1").val().length==0&&$("#terca2").val().length>0)||($("#terca1").val().length>0&&$("#terca2").val().length==0)){
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#terca1").parent("div").popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
        $("#terca1").focus(); 
        return false;
    }
    else if( ($("#quarta1").val().length==0&&$("#quarta2").val().length>0)||($("#quarta1").val().length>0&&$("#quarta2").val().length==0)){
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#quarta1").parent("div").popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
        $("#quarta1").focus();  
        return false;
    }
    else if( ($("#quinta1").val().length==0&&$("#quinta2").val().length>0)||($("#quinta1").val().length>0&&$("#quinta2").val().length==0)){
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#quinta1").parent("div").popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
        $("#quinta1").focus();  
        return false;
    }
    else if( ($("#sexta1").val().length==0&&$("#sexta2").val().length>0)||($("#sexta1").val().length>0&&$("#sexta2").val().length==0)){
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#sexta1").parent("div").popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
        $("#sexta1").focus(); 
        return false;
    }
    else if( ($("#sabado1").val().length==0&&$("#sabado2").val().length>0)||($("#sabado1").val().length>0&&$("#sabado2").val().length==0)){
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#sabado1").parent("div").popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
        $("#sabado1").focus();  
        return false;
    }

    //===================================================================
    //              Verificacao do intervalo dos horarios
    //===================================================================

    if(($("#segunda1").val()>=$("#segunda2").val())&&($("#segunda1").val().length!=0)&&($("#segunda2").val().length!=0)  ){
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#segunda1").parent("div").popover({content: "Hora de ínicio deve ser menor que a de término.",placement: "top"}).popover("show");
        document.getElementById("segunda1").focus();  
        return false;
    }
    else if(($("#terca1").val()>=$("#terca2").val())&&$("#terca1").val().length!=0&&$("#terca2").val().length!=0 ){
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#terca1").parent("div").popover({content: "Hora de ínicio deve ser menor que a de término.",placement: "top"}).popover("show");
        document.getElementById("terca1").focus();
        return false;
    }
    else if(($("#quarta1").val()>=$("#quarta2").val())&&$("#quarta1").val().length!=0&&$("#quarta2").val().length!=0 ){
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#quarta1").parent("div").popover({content: "Hora de ínicio deve ser menor que a de término.",placement: "top"}).popover("show");
        document.getElementById("quarta1").focus();
        return false;
    }
    else if(($("#quinta1").val()>=$("#quinta2").val())&&$("#quinta1").val().length!=0&&$("#quinta2").val().length!=0 ){
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#quinta1").parent("div").popover({content: "Hora de ínicio deve ser menor que a de término.",placement: "top"}).popover("show");
        document.getElementById("quinta1").focus();
        return false;
    }
    else if(($("#sexta1").val()>=$("#sexta2").val())&&$("#sexta1").val().length!=0&&$("#sexta2").val().length!=0 ){
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#sexta1").parent("div").popover({content: "Hora de ínicio deve ser menor que a de término.",placement: "top"}).popover("show");
        document.getElementById("sexta1").focus();
        return false;
    }
    else if(($("#sabado1").val()>=$("#sabado2").val())&&$("#sabado1").val().length!=0&&$("#sabado2").val().length!=0 ){
        checaVisibilidadePlano();// verifica se o plano esta visivel
        $("#sabado1").parent("div").popover({content: "Hora de ínicio deve ser menor que a de término.",placement: "top"}).popover("show");
        document.getElementById("sabado1").focus();
        return false;
    }

    // verificacao do plano de atividades do estagio


    //===================================================================
    //              Verificacao do termo de compromisso
    //===================================================================
    if($("#termo_arquivo").val() == '' ){
        // your validation error action
        if($("#termo_arquivo").attr("required") === undefined){
        	// arquivo nao requisitado e nao atualizado
        }
        else{
	        checaVisibilidadeTermo();
	        $("#termo_arquivo").popover({content: "Termo de Compromisso não é válido.",placement: "top"}).popover("show");
	        return false;
    	}
    }

		var contadorDeErros = 0; // contador de erros

	$("input").each(function(){ // Para cada input
	  	if($(this).attr("boolt") == 1){ // Se o atributo dele na array bool for 1
	   		contadorDeErros = contadorDeErros + 1; // Increment o contador de erros
	}

	});// Fim para

	$("select").each(function(){ // Para cada input
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
	
}); // Fim funcao Salvar


  	$('input').focus(function(){ // Para cada input ao ser clicado

		if($(this).attr("boolt") == 1){
	  		this.setAttribute("boolt","0");
	  		$(this).css( {"border-color":"#777", "border-width":"1px"} ); // define o background de branco
		}
  	}); // Fim para

  	$('select').focus(function(){ // Para cada input ao ser clicado

		if($(this).attr("boolt") == 1){
	  		this.setAttribute("boolt","0");
	  		$(this).css( {"border-color":"#777", "border-width":"1px"} ); // define o background de branco
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



});