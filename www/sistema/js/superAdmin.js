

$(document).ready(function(){

    $("#telefone").mask("(99) 9999-9999");

	var antigo = 0;
    var antigoCoordenador = 0;

	$('[name=linhaArea]').click(function(){
		if(antigo!=0){	
			antigo.style.backgroundColor = "#FFF";
			antigo.style.color = "#333";
		}

		document.getElementById('nomeArea').value = $(this).html();
		document.getElementById('codigoArea').value = $(this).attr("value");

		this.style.backgroundColor = "rgb(0, 147, 255)";
		this.style.color = "#FFF";
		antigo = this;

	});

    $('[class=linhaCoordenador]').click(function(){

        if(antigoCoordenador!=0){  
            
            $(antigoCoordenador).children().css({'background-color':'#FFF'});
            antigoCoordenador.style.color = "#333";
        }

        //document.getElementById('nomeArea').value = $(this).html();
        //document.getElementById('codigoArea').value = $(this).attr("value");

       
        $(this).children().css({'background-color':'#0093ff'});
        this.style.color = "#FFF";
            
        var Id = $(this).children().first().html();

        $('#idCoordenadorAlterar').val(Id);
        $('#idCoordenadorRemover').val(Id);

        antigoCoordenador = this;

    });

    $('#BotaoAlterarCoordenador').click(function(){

        if($('#idUsuario').val()=='')
            return false;

        $("#AlterarCoordenadorModal").empty();

        var xmlhttp = (window.XMLHttpRequest)?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");

        //Após receber os dados execute a seguinte função
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                $("#AlterarCoordenadorModal").append(xmlhttp.responseText);
            }
        }

        //determina o metodo
        xmlhttp.open("POST","Controllers/Controller-informacao-coordenador.php", true);

        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        //Envia a requisição
        alert($('#idUsuario').val());
        xmlhttp.send("idUsuario="+( $(antigoCoordenador).children().first().html() ));

        $("#AlterarCoordenadorModal").modal();


    });

});