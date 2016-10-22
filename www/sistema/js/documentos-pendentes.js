var Mo;
$(document).ready(function(){

	$('.table-striped').DataTable();
	
    $(".entrega").click(function(e){

        e.stopPropagation();
        var escolha = confirm("Deseja confirmar entrega?");
        if(!escolha)
            return false;
    });

	window.scrollTo(0, 0);

	$("tr.panel-heading").click(function(){
		
		 $("#modalAvaliaRelatorio").empty();

		var xmlhttp = (window.XMLHttpRequest)?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");
        //var xhttp = new XMLHttpRequest();
        //Após receber os dados execute a seguinte função
        xmlhttp.onreadystatechange = function() {
        	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        		//$("#AvaliaEstagioModal").find('.modal-body').append(xmlhttp.responseText);
        	    $("#modalAvaliaRelatorio").append(xmlhttp.responseText);
            }
        }
        xmlhttp.open("POST","relatorios_pagina.php", true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        //Envia a requisição
        xmlhttp.send("relatorio="+encodeURIComponent($(this).attr("value")));
		
        $("#AvaliaRelatorioModal").modal();

		//relatorio_open();

	});

	//Funcao a ser estudada
	$('.reprovaTA').click(function(ev){
		ev.preventDefault();	//this is for canceling your code : onClick="return false;"
		$('#TermoAditivoText').val($(this).next().val());
		Mo = $(this).next();
	});

	$('#TAModal-n').click(function(ev){
		Mo.val($('#TermoAditivoText').val());
		Mo.parent().submit();
	});

	$('#TAModal').on('hidden.bs.modal', function (){
		Mo.val($('#TermoAditivoText').val());
		$('#TermoAditivoText').val("");
	});


	$('.reprovaDF').click(function(ev){
		ev.preventDefault();
		$('#DFModalc').val($(this).next().val());
		DF = $(this).next();

	});

    $('#DFModal-n').click(function(){
        DF.val($('#DFModalc').val());
        $('#DFModalc').val("");
    });

	$('#DFModal-s').click(function(){
		DF.val($('#DFModalc').val());
		DF.parent().submit();
	});

	$('#DFModal').on('hidden.bs.modal', function (){
		if($('#DFModalc').val()!='')
            DF.val($('#DFModalc').val() );
		$('#DFModalc').val("");
	});

	//Funcao a ser estudada
	$("tr").click(function(){
		
		if( $(this).attr("estagio")===undefined){

		}
		else{

			$("#AvaliaEstagioModalTittle").text("Avaliar estágio");
			$("#modalAvaliaEstagio").empty();

			var xmlhttp = (window.XMLHttpRequest)?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");
            //var xhttp = new XMLHttpRequest();
            //Após receber os dados execute a seguinte função
            xmlhttp.onreadystatechange = function() {
            	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            		//$("#AvaliaEstagioModal").find('.modal-body').append(xmlhttp.responseText);
            	    $("#modalAvaliaEstagio").append(xmlhttp.responseText);
                }
            }
            xmlhttp.open("POST","avalia-estagio.php", true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            //Envia a requisição
            xmlhttp.send("idEstagio="+encodeURIComponent($(this).attr('value') ));
        }
    });


	/*

	function relatorio_open() {

		$('[envioRelatorio="1"]').click(function(){

			return false;

			var id = $(this).attr('relatorio-id');
			var certo = true;
			var string = "";

			var nomeModal = '#modelRelatorios'+id;

			var nomeModalAvaliacao = '#modelRelatoriosAvaliacao'+id;

			var Filhos = $(this).closest("table").find("input:checked");
			var textareas = $(this).find("textarea");
			// Tinha feito com uma array e um for mas nao deu muito certo
			// fiquei putzgrila da vida e decidi fazer assim

			alert(Filhos.length+" "+textareas.length);

			return false;

			if(Filhos[0].value==1){
				certo = false;
				string = string+"1;"
				textareas[0].parentNode.style.display= "block";
			}else{
				string = string+"0;"
			}
			if(Filhos[1].value==1){
				certo = false;
				string = string+"1;"
				textareas[1].parentNode.style.display= "block";
			}else{
				string = string+"0;"
			}

			if(Filhos[2].value==1){
				certo = false;
				string = string+"1;"
				textareas[2].parentNode.style.display= "block";
			}else{
				string = string+"0;"
			}

			if(Filhos[3].value==1){
				certo = false;
				string = string+"1;"
				textareas[3].parentNode.style.display= "block";
			}else{
				string = string+"0;"
			}

			if(Filhos[4].value==1){
				certo = false;
				string = string+"1"
				textareas[4].parentNode.style.display= "block";
			}else{
				string = string+"0"
			}


			if(certo==true){
				//$(nomeModalAvaliacao).modal('show');
				$('.row_errosestagio').show("fast");
				return false;
			}else{
				//$(nomeModal).modal('show');
				$('.row_avaliaestagio').show("fast");
				return false;
			}

	});

	$('[envioRelatorioPresidente="1"]').click(function(){


		var id = $(this).attr('relatorio-id');
		var certo = true;
		var string = "";

		nomeModal = '#modelRelatorios'+id;

		Filhos = $(this).closest("table").find("input:checked");
		textareas = $(nomeModal).find("textarea");
		// Tinha feito com uma array e um for mas nao deu muito certo
		// fiquei putzgrila da vida e decidi fazer assim

		if(Filhos[0].value==1){
			certo = false;
			string = string+"1;"
			textareas[0].parentNode.style.display= "block";
		}else{
			string = string+"0;";
			textareas[0].parentNode.style.display= "none";
		}
		if(Filhos[1].value==1){
			certo = false;
			string = string+"1;"
			textareas[1].parentNode.style.display= "block";
		}else{
			string = string+"0;";
			textareas[1].parentNode.style.display= "none";
		}

		if(Filhos[2].value==1){
			certo = false;
			string = string+"1;"
			textareas[2].parentNode.style.display= "block";
		}else{
			string = string+"0;";
			textareas[2].parentNode.style.display= "none";
		}

		if(Filhos[3].value==1){
			certo = false;
			string = string+"1;"
			textareas[3].parentNode.style.display= "block";
		}else{
			string = string+"0;";
			textareas[3].parentNode.style.display= "none";
		}

		if(Filhos[4].value==1){
			certo = false;
			string = string+"1"
			textareas[4].parentNode.style.display= "block";
		}else{
			string = string+"0";
			textareas[4].parentNode.style.display= "none";
		}


		if(certo==false){
			$(nomeModal).modal('show');
			return false;
		}


	});
		
	}*/

	$('[name=botaoPlano]').click(function(){

		var id = $(this).attr('id_plano');
		nomeModal = '#modelplano'+id;
		var string;
		var certo = true;
		Filhos = $(this).closest("table").find("input:checked");
		textareas = $(nomeModal).find("textarea");
		// Tinha feito com uma array e um for mas nao deu muito certo
		// fiquei putzgrila da vida e decidi fazer assim

		if(Filhos[0].value==1){
			certo = false;
			string = string+"1;"
			textareas[0].parentNode.style.display= "block";
		}else{
			string = string+"0;";
			textareas[0].parentNode.style.display= "none";
		}
		if(Filhos[1].value==1){
			certo = false;
			string = string+"1;"
			textareas[1].parentNode.style.display= "block";
		}else{
			string = string+"0;";
			textareas[1].parentNode.style.display= "none";
		}

		if(Filhos[2].value==1){
			certo = false;
			string = string+"1;"
			textareas[2].parentNode.style.display= "block";
		}else{
			string = string+"0;";
			textareas[2].parentNode.style.display= "none";
		}

		if(Filhos[3].value==1){ // Comeca aqui	
			certo = false;
			string = string+"1;1;"
			textareas[3].parentNode.style.display= "block";
		}else{
			string = string+"0;0;";
			textareas[3].parentNode.style.display= "none";
		}

		if(Filhos[4].value==1){
			certo = false;
			string = string+"1;1;"
			textareas[3].parentNode.style.display= "block";
		}else{
			string = string+"0;0;";
			textareas[3].parentNode.style.display= "none";
		}

		if(Filhos[5].value==1){
			certo = false;
			string = string+"1;1;"
			textareas[3].parentNode.style.display= "block";
		}else{
			string = string+"0;0;";
			textareas[3].parentNode.style.display= "none";
		}

		if(Filhos[6].value==1){
			certo = false;
			string = string+"1;1;"
			textareas[3].parentNode.style.display= "block";
		}else{
			string = string+"0;0;";
			textareas[3].parentNode.style.display= "none";
		}

		if(Filhos[7].value==1){
			certo = false;
			string = string+"1;1;"
			textareas[3].parentNode.style.display= "block";
		}else{
			string = string+"0;0;";
			textareas[3].parentNode.style.display= "none";
		}

		if(Filhos[8].value==1){
			certo = false;
			string = string+"1;1;"
			textareas[3].parentNode.style.display= "block";
		}else{
			string = string+"0;0;";
			textareas[3].parentNode.style.display= "none";
		}
		// -- 
		if(Filhos[9].value==1){
			certo = false;
			string = string+"1"
			textareas[4].parentNode.style.display= "block";
		}else{
			string = string+"0";
			textareas[4].parentNode.style.display= "none";
		}


		if(certo==false){
			$(nomeModal).modal('show');
			return false;
		}
	});

	//Eventos modal; Chama o "FechaModal" caso o usuario clique fora do modal fazendo ele fechar
	$('#FinalModal').on('hidden.bs.modal', function (){
		if($('#final-modal-n').attr("onclick") != '')
			$('#final-modal-n').click();
	})
	
});
