//===================================================================
//          Verifica se plano de atividades esta invisivel
//===================================================================
function checaVisibilidadePlano(){

    if($("#planoEstagio").is(':visible')) {// checa se atributo esta visivel
        // faca nada
    }else{
        $( ".row_avalia" ).hide();
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
        $( ".row_avalia" ).hide();
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
        $( ".row_avalia" ).hide();
        $("#termoEstagio").show();
    }

}

//===================================================================
//			Confirma quais erros foram setados e da show nos divs
//===================================================================

function showErros(){

		
		var string, stringInfoEstagio;
		var certo = true;

	 	Filhos = $("#planoEstagio").find("input:checked");

		FilhosInfoEstagio = $("#infoEstagio").find("input:checked");

		FilhosTermo = $("#termoEstagio").find("input:checked");
		
		//==========================================================
		//		Info Estagio
		//==========================================================

		// Tipo Estagio

		if(FilhosInfoEstagio[0].value==1){

			certo = false;
			stringInfoEstagio = "1;";
			textareas[0].parentNode.style.display= "block";

		}else{
			stringInfoEstagio = "0;";
			textareas[0].parentNode.style.display= "none";
		}

		// Supervisor
		if(FilhosInfoEstagio[1].value==1){
			certo = false;
			stringInfoEstagio = stringInfoEstagio+"1;"
			textareas[1].parentNode.style.display= "block";
		}else{
			stringInfoEstagio = stringInfoEstagio+"0;";
			textareas[1].parentNode.style.display= "none";
		}

		// Empresa
		if(FilhosInfoEstagio[2].value==1){
			certo = false;
			stringInfoEstagio = stringInfoEstagio+"1;"
			textareas[2].parentNode.style.display= "block";
		}else{
			stringInfoEstagio = stringInfoEstagio+"0;";
			textareas[2].parentNode.style.display= "none";
		}


		// Data inicial
		if(FilhosInfoEstagio[3].value==1){
			certo = false;
			stringInfoEstagio = stringInfoEstagio+"1;"
			textareas[3].parentNode.style.display= "block";
		}else{
			stringInfoEstagio = stringInfoEstagio+"0;";
			textareas[3].parentNode.style.display= "none";
		}

		// Data Final

		if(FilhosInfoEstagio[4].value==1){
			certo = false;
			stringInfoEstagio = stringInfoEstagio+"1;"
			textareas[4].parentNode.style.display= "block";
		}else{
			stringInfoEstagio = stringInfoEstagio+"0;";
			textareas[4].parentNode.style.display= "none";
		}

		// Area
		if(FilhosInfoEstagio[5].value==1){
			certo = false;
			stringInfoEstagio = stringInfoEstagio+"1;"
			textareas[5].parentNode.style.display= "block";
		}else{
			stringInfoEstagio = stringInfoEstagio+"0;";
			textareas[5].parentNode.style.display= "none";
		}
		


		//==========================================================
		//		Plano de atividades Estagio
		//==========================================================		

		if(Filhos[0].value==1){
			certo = false;
			string = "1;"
			textareas[6].parentNode.style.display= "block";

		}else{
			string = "0;";
			textareas[6].parentNode.style.display= "none";
		}
		if(Filhos[1].value==1){
			certo = false;
			string = string+"1;"
			textareas[7].parentNode.style.display= "block";
		}else{
			string = string+"0;";
			textareas[7].parentNode.style.display= "none";
		}

		if(Filhos[2].value==1){
			certo = false;
			string = string+"1;"
			textareas[8].parentNode.style.display= "block";
		}else{
			string = string+"0;";
			textareas[8].parentNode.style.display= "none";
		}	

			//==========================================
			// Horarios
			//==========================================
		
		if(Filhos[3].value==1){
			certo = false; 
			string = string+"1;1;"
			textareas[9].parentNode.style.display= "block";
		}else{
			string = string+"0;0;";
			if(certo)
				if(certo)
					textareas[9].parentNode.style.display= "none";
		}

		if(Filhos[4].value==1){
			certo = false;
			string = string+"1;1;"
			textareas[9].parentNode.style.display= "block";
		}else{
			string = string+"0;0;";
			if(certo)
				textareas[9].parentNode.style.display= "none";
		}

		if(Filhos[5].value==1){
			certo = false;
			string = string+"1;1;"
			textareas[9].parentNode.style.display= "block";
		}else{
			string = string+"0;0;";
			if(certo)
				textareas[9].parentNode.style.display= "none";
		}

		if(Filhos[6].value==1){
			certo = false;
			string = string+"1;1;"
			textareas[9].parentNode.style.display= "block";
		}else{
			string = string+"0;0;";
			if(certo)
				textareas[9].parentNode.style.display= "none";
		}

		if(Filhos[7].value==1){
			certo = false;
			string = string+"1;1;"
			textareas[9].parentNode.style.display= "block";
		}else{
			string = string+"0;0;";
			if(certo)
				textareas[9].parentNode.style.display= "none";
		}

		if(Filhos[8].value==1){
			certo = false;
			string = string+"1;1;"
			textareas[9].parentNode.style.display= "block";
		}else{
			string = string+"0;0;";
			if(certo)
				textareas[9].parentNode.style.display= "none";
		}
		// -- 
		if(Filhos[9].value==1){
			certo = false;
			string = string+"1"
			textareas[10].parentNode.style.display= "block";
		}else{
			string = string+"0";
			textareas[10].parentNode.style.display= "none";
		}

		//==========================================================
		//		Termo de compromisso
		//==========================================================
		if( FilhosTermo[0].value==1){
			certo = false;
			stringInfoEstagio = stringInfoEstagio+"1"
			textareas[11].parentNode.style.display= "block";
		}else{
			stringInfoEstagio = stringInfoEstagio+"0";
			textareas[11].parentNode.style.display= "none";
		}

		if(certo){
			$("#semErrosWarning").removeClass( "hidden" );
		}else{
			$("#semErrosWarning").addClass( "hidden" );
		}

		document.getElementById("erros").value = String(string);
		//$("#errosEstagio").val(stringInfoEstagio);

		document.getElementById("errosEstagio").value = String(stringInfoEstagio);

}


$(document).ready(function(){

 	lastTab = $("#infoEstagio") ;

	textareas = $("#comentariosReprova").find("textarea");


	//============================================================
	// 						Info do Estagio
	//============================================================


		$("#InfoBotaoDireita").click(function(){
		    $( ".row_avalia" ).hide("fast");
		    $("#planoEstagio").show("fast");
			lastTab = $("#planoEstagio");

	  	});

	//============================================================
	// 						Termo Estagio
	//============================================================

	    $("#TermoBotaoEsquerda").click(function(){
	        $( ".row_avalia" ).hide("fast");
	        $("#planoEstagio").show("fast");
	    	lastTab = $("#planoEstagio");

	    });

	    $("#termo_arquivo").click(function(){
	        $("#termo_arquivo").popover("destroy");
	    }); 

	//============================================================
	// 						Plano de Atividades
	//============================================================


	$("#PlanoBotaoEsquerda").click(function(){

	    $( ".row_avalia" ).hide("fast");
	    $("#infoEstagio").show("fast");
	    lastTab =  $("#infoEstagio");

  	});

	$("#PlanoBotaoDireita").click(function(){

	    $( ".row_avalia" ).hide("fast");
    	$("#termoEstagio").show("fast");
	    lastTab =  $("#termoEstagio");
	});

	$("#botaoAprova").click(function(){

		if( $("#botaoReprova").is(":visible") ){
		
			$( ".row_avalia" ).hide( );
			$("#aprova").show("slide",{ direction: "right"}, "fast");
			$("#botaoReprova").hide();
			$("#botaoCancela").show();
			return false;		
		}else{
			//$("#AvaliaForm").submit();
		
		}
  	});

	$("#botaoCancela").click(function(){
		
		if( $("#botaoReprova").is(":visible") ){
			$("#botaoAprova").show();
			$( ".row_avalia" ).hide();
		}else{
			$("#botaoReprova").show();
			$( ".row_avalia" ).hide();
		}

		lastTab.show( "slide",{ direction: "left"}, "fast" );
		$("#botaoCancela").hide();
		return false;
	
	});

	$("#botaoReprova").click(function(){
		if( $("#botaoAprova").is(":visible") ){
			showErros();
			$( ".row_avalia" ).hide( );		
			$("#comentariosReprova").show("slide",{ direction: "right"}, "fast");		
		    $("#botaoAprova").hide();
		    $("#botaoCancela").show();
		    return false;
		}else{
			
		}

  	});

});