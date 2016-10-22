

$(document).ready(function(){

	var antigo = 0;

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

    $(".linhaEstagiario").click(function(e){

        $("#EstagiarioModalBody").empty();

        var xmlhttp = (window.XMLHttpRequest)?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");

        //Após receber os dados execute a seguinte função
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                $("#EstagiarioModalBody").append(xmlhttp.responseText);
            }
        }

        //determina o metodo
        xmlhttp.open("POST","informacao_estudante.php", true);

        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        //Envia a requisição
        xmlhttp.send("idEstagiario="+($(this).attr('value')));

        $("#EstagiarioModal").modal();

    });

    $(".linhaEstagio").click(function(){


        $(this).prev().submit() ;

    });

});