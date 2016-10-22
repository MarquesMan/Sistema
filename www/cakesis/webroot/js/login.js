
$(document).ready(function()
{

	$('html').click(function() {
		$("#menuslide_cadastrar").hide("slide",{ direction: "right"});
		$("#menuslide_recuperar").hide("slide",{ direction: "right"});
		$(".escurecer").remove();
	});

	$('#menuslide_cadastrar').click(function(event){
	    event.stopPropagation();
	});

	$('#menuslide_recuperar').click(function(event){
	    event.stopPropagation();
	});

	$("#botao_recuperacao").click(function()
	{
		var cont = 0;
		$("#Form_Recovery input").each(function()
		{
			if($(this).val() == "")
     		cont++;
		});

		if(cont == 0)
		{
			$("#Form_Recovery").submit();
		}
		else
			return false;
	});

	$("[name=fechar_slide]").click(function(event){
		$("#menuslide_cadastrar").hide("slide",{ direction: "right"});
		$("#menuslide_recuperar").hide("slide",{ direction: "right"});
		$(".escurecer").remove();
	});

	$("#cadastrar").click(function(event){
		event.stopPropagation();
		$("#menuslide_recuperar").hide("slide",{ direction: "right"});
		$("#menuslide_cadastrar").toggle("slide",{ direction: "right"});
		$("body").append("<div class='escurecer'></div>");
	});

	$("#recuperar").click(function(event){
		event.stopPropagation();
		$("#menuslide_cadastrar").hide("slide",{ direction: "right"});
		$("#menuslide_recuperar").toggle("slide",{ direction: "right"});
		$("body").append("<div class='escurecer'></div>");
	});	


	$("input").blur(function()
	{
		if($(this).val() == "")
		{
			$(this).css({"border" : "1px solid #F00"});
		}
		else{
			$(this).css({"border" : "1px solid #FFF"});
		}
	});

	$("#form_login").submit(function(event){
		var cont = 0;
		$("#form_login > div > div > input").each(function()
		{
			if($(this).val() == ""){
				cont++;
				$(this).css({"border" : "1px solid #F00"});
			}
		});

		if(cont > 0)
		{
			event.preventDefault();
		}

	});

	setTimeout(function() {
		$("#alerta").remove();
	}, 5000);

	 $("#cadastro_pessoa").click(function()
	{
    	var cont = 0;
    	$("#form-pessoa input").each(function()
		{
    		if($(this).val() == ""){
    			cont++;
    		}
    	});

    	if($("#proforaluno").val() == "P" && (document.forms["Form"]["rga"].value == null  || document.forms["Form"]["rga"].value == "")){
    		cont--;
    	}


		if(cont == 0)
    	{
    		var x = document.forms["Form"]["password"].value;
    		var y = document.forms["Form"]["conf_password"].value;
    		if(x == y){
    			$("#form").submit();
    		}
    		else
    		{
				alert("Senhas não conferem");
				document.forms["Form"]["password"].value = "";
				document.forms["Form"]["conf_password"].value = "";
				return false;
        	}
        }
        else{         				
        	alert("Todos os campos devem ser preenchidos");
        	return false;
        }
    });

	$("#cadastro_empresa").click(function()
	{
		var cont = 0;
		$("#form-empresa input").each(function()
		{
			if($(this).val() == "")
	   			cont++;
		});

		if(document.forms["#form-empresa"]["complemento"].value = "")
			cont--;

		if(cont == 0)
		{
	    	$("#form-empresa").submit();
	    }
	    else{
   			alert("Todos os campos devem ser preenchidos");
   			return false;
   		}
	});

	if($("#proforaluno").val() == 'E' || $("#proforaluno").val() == 'P'){
		$("#form-pessoa").show();
		$("#form-empresa").hide();
		var tipo = $("#proforaluno").val();
		$("#tipo").val(tipo);
	}
	else{
		$("#form-pessoa").hide();
		$("#form-empresa").show();
	}

	$("#proforaluno").change(function()
	{
		if($("#proforaluno").val() == 'E'){
			$("#rgaID").show();
			$('#cursoID').show();
			$("#form-pessoa").show();
			$("#form-empresa").hide();
			$("#tipo").val('E');
			document.forms["Form"]["rga"].value = "";
		}
		else if($("#proforaluno").val() == 'P'){
			$("#rgaID").hide();
			$('#cursoID').hide();
			$("#form-pessoa").show();
			$("#form-empresa").hide();
			$("#tipo").val('P');
		}
		else{
			$("#form-pessoa").hide();
			$("#form-empresa").show();
			document.forms["Form"]["rga"].value = "";
		}
	});

	$("#telefone").mask("(99) 9999-9999");
	$("#cep").mask("99999-999");
});

$(function() {
  $("input[name='username']").focus();
});