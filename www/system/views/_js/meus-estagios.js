//===================================================================
//                 Quando o documento estiver pronto
//===================================================================
$(document).ready(function(){

    //===================================================================
    //              Linhas da tabela de estagios
    //===================================================================

	$("div.no-form-row").click(function(){
        /*$("ModalAterarEstagioBody").empty();

        var xmlhttp = (window.XMLHttpRequest)?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");
        //var xhttp = new XMLHttpRequest();
        //Após receber os dados execute a seguinte função

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                $("#ModalAterarEstagioBody").append(xmlhttp.responseText);
            }
        }

        xmlhttp.open("POST","editar-estagio.php", true);

        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        //Envia a requisição
        xmlhttp.send("idEstagio="+encodeURIComponent($(this).attr('value') ));*/
        alert("entrou");
	});

    
    $("form.form-row").click(function (){
        $(this).submit();
    });


});