//===================================================================
//                 Quando o documento estiver pronto
//===================================================================
$(document).ready(function(){

    //===================================================================
    //              Linhas da tabela de estagios
    //===================================================================

	$("tr").click(function(){
		
        if( $(this).attr("aprovado")==1){
            var formulario = $(this).attr("name");	
            document.getElementById(formulario).submit();
        }else if( $(this).attr("aprovado")== 0 ){

            $("#myModalLabel").text("Editar estágio");
            $(".modal-body").empty();

            var xmlhttp = (window.XMLHttpRequest)?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");
            //var xhttp = new XMLHttpRequest();
            //Após receber os dados execute a seguinte função
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    $(".modal-body").append(xmlhttp.responseText);
                }
            }

            xmlhttp.open("POST","editar-estagio.php", true);
                
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            //Envia a requisição
            xmlhttp.send("idEstagio="+encodeURIComponent($(this).attr('value') ));


        }

	});

    $("#BotaoNovoEstagio").click(function(){

        $("#myModalLabel").text("Adicionar estágio");
        $(".modal-body").empty();
        $(".modal-body").load("novo-estagio.php");  
        
    });


});