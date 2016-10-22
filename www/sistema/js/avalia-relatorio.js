$(document).ready(function() {

    $('[name="botaoCancela"]').click(function(){

        if( $('.row_avaliaestagio').is(":visible") ){

            $('#formTable').show("slide",{ direction: "right"}, "fast");
            $('.row_avaliaestagio').hide("slide",{ direction: "right"}, "fast");
        }else{
            $('#formTable').show("slide",{ direction: "right"}, "fast");
            $('.row_errosestagio').hide("slide",{ direction: "right"}, "fast");
        }

        return false;

    });


    $('[envioRelatorio="1"]').click(function() {

        var id = $(this).attr('relatorio-id');
        var certo = true;
        var string = "";

        var Filhos = $("#formTable").find("input:checked");
        var textareas = $("#formRoot").find("textarea");
        // Tinha feito com uma array e um for mas nao deu muito certo
        // fiquei putzgrila da vida e decidi fazer assim

        if (Filhos[0].value == 1) {
            certo = false;
            string = string + "1;"
            textareas[0].parentNode.style.display = "block";
        } else {
            string = string + "0;"
        }
        if (Filhos[1].value == 1) {
            certo = false;
            string = string + "1;"
            textareas[1].parentNode.style.display = "block";
        } else {
            string = string + "0;"
        }

        if (Filhos[2].value == 1) {
            certo = false;
            string = string + "1;"
            textareas[2].parentNode.style.display = "block";
        } else {
            string = string + "0;"
        }

        if (Filhos[3].value == 1) {
            certo = false;
            string = string + "1;"
            textareas[3].parentNode.style.display = "block";
        } else {
            string = string + "0;"
        }

        if (Filhos[4].value == 1) {
            certo = false;
            string = string + "1"
            textareas[4].parentNode.style.display = "block";
        } else {
            string = string + "0"
        }

        if (certo == true) {
            //$(nomeModalAvaliacao).modal('show');
            $('#formTable').hide("slide",{ direction: "right"}, "fast");
            $('.row_avaliaestagio').show("slide",{ direction: "right"}, "fast");

            return false;
        } else {
            //$(nomeModal).modal('show');
            $('#formTable').hide("slide",{ direction: "right"}, "fast");
            $('.row_errosestagio').show("slide",{ direction: "right"}, "fast");
            return false;
        }
    });

});