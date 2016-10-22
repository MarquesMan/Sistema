/*Entradas do usuarios e respostas esperadas
*
*   U:Horas registradas no sistema somadas ao plano de atividades atual superam 30 horas semanais
*   S:Torna o botão "Submeter" não clicável. Campo "Carga Horária" fica com borda vermelha.
*
*
*
*
*
*
*
*/

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

    };

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
        
        recalculaHorarios();
    }
});

    

$('[horario="1"]').each(function(){
    var value = $(this).val().split(":");

    if( (parseInt(value[0])>24)|| (parseInt(value[1])>59)){
        $(this).focus();
        $(this).parent("div").popover({content: "Hora inválida",placement: "top"}).popover("show");
        return false;
    }
});


$("#Save").click(function(){

    if(verificaDatas()==false){
        return false;
    }

    var data = $("#data").val();

    var result = $("#segunda1").val()+";"+$("#segunda2").val()+";"+$("#terca1").val()+";"+$("#terca2").val()+";"+$("#quarta1").val()+";"+$("#quarta2").val()+";"+$("#quinta1").val()+";"+$("#quinta2").val()+";"+$("#sexta1").val()+";"+$("#sexta2").val()+";"+$("#sabado1").val()+";"+$("#sabado2").val();
    $("#horarios").val(result);

    recalculaHorarios();

    if(!isValidDate(data)){
        $("#data").popover({content: "A data inserida não é válida",placement: "top"}).popover("show");
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

});

$(document).ready(function(){
    var horarios= {}

    var nomes = ["segunda1","segunda2","terca1", "terca2" , "quarta1" , " quarta2", "quinta1" , "quinta2" , "sexta1" , "sexta2", "sabado1" , "sabado2" ]

    document.getElementById("carga").value = 0;
    document.getElementById("carga").disabled = true;

    $('.counter').text( 497-  $('#Atividades_Desenvolvidas').val().length );

    $('.status-box').keydown(function() {

        var postLength = $(this).val().length;

        var charactersLeft = 497 - postLength;

        $('.counter').text(charactersLeft);

    });

    $('.status-box').keyup(function() {

        var postLength = $(this).val().length;

        var charactersLeft = 497 - postLength;

        $('.counter').text(charactersLeft);

    });

    $("#data").mask("99/99/9999");
    $("#segunda1").mask("99:99");
    $("#segunda2").mask("99:99");
    $("#terca1").mask("99:99");
    $("#terca2").mask("99:99");
    $("#quarta1").mask("99:99");
    $("#quarta2").mask("99:99");
    $("#quinta1").mask("99:99");
    $("#quinta2").mask("99:99");
    $("#sexta1").mask("99:99");
    $("#sexta2").mask("99:99");
    $("#sabado1").mask("99:99");
    $("#sabado2").mask("99:99");

});