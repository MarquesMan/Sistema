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

    $(".horario > div > div").each(function(){ // para cada linha de horario

        Filhos = $(this).children(); // pega os filhos

        if( (Filhos[1].value!=""&&Filhos[3].value!="") ){
            string1 = Filhos[1].value;
            string2 = Filhos[3].value;
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




//===================================================================
//          Verifica se plano de atividades esta invisivel
//===================================================================
function checaVisibilidadePlano(){

    if($("#planoEstagio").is(':visible')) {// checa se atributo esta visivel
        // faca nada
    }else{
        $( "form > div > div" ).hide();
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
        $("form > div > div").hide();
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
        $( "form > div > div" ).hide();
        $("#termoEstagio").show();
    }

}

//===================================================================
//                 Quando o documento estiver pronto
//===================================================================

$(document).ready(function(){
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR",
        autoclose: true
    });

    //===================================================================
    //          controle das setas
    //===================================================================
    $("#next").click(function(){
        var currentDiv = $("div.conteudo > div:visible");
        currentDiv.hide();
        if(currentDiv.attr("id") == "infoEstagio"){
            $("#planoEstagio").show("fast");
            $(".arrows > div > h4").text("Plano de Atividades");
        }
        else if(currentDiv.attr("id") == "planoEstagio"){
            $("#termoEstagio").show("fast");
            $(".arrows > div > h4").text("Termo de Compromissso");
        }
        else if(currentDiv.attr("id") == "termoEstagio"){
            $("#infoEstagio").show("fast");
            $(".arrows > div > h4").text("Informações Estágio");
        }
    });

    $("#prev").click(function(){
        var currentDiv = $("div.conteudo > div:visible");
        currentDiv.hide();
        if(currentDiv.attr("id") == "infoEstagio"){
            $("#termoEstagio").show("fast");
            $(".arrows > div > h4").text("Termo de Compromissso");
        }
        else if(currentDiv.attr("id") == "planoEstagio"){
            $("#infoEstagio").show("fast");
            $(".arrows > div > h4").text("Informações Estágio");
        }
        else if(currentDiv.attr("id") == "termoEstagio"){
            $("#planoEstagio").show("fast");
            $(".arrows > div > h4").text("Plano de Atividades");
        }
    });


    // Plano de atividades

    //===================================================================
    //          toda vez que o usuario digita um intervalo e da um tab
    //===================================================================
    $(".input-hora").blur(function(){
        var value = $(this).val().split(":");

        if( (parseInt(value[0])>24)|| (parseInt(value[1])>59)){ // se os minutos ou horas excederem os padroes terrestres
            $(this).focus();
            $(this).parent("div").popover({content: "Hora inválida",placement: "top"}).popover("show");
            return false;
        }
        
        $(this).popover("destroy"); // destroi o aviso
        var Filhos = $(this).parent("div").children(); // pega as kianssa 
        var string1, string2;
        var cargaValorHoras, cargaValorMinutos;

        if( (Filhos[1].value!=""&&Filhos[3].value!="") ){
            string1 = Filhos[1].value;
            string2 = Filhos[3].value;

            horarios[Filhos[1].name] = string1[1];
            horarios[Filhos[3].name] = string2[0];
            
            recalculaHorarios();
        }
    });


  var horarios= {};

  var nomes = ["#segunda1","#segunda2","#terca1", "#terca2" , "#quarta1" , "#quarta2", "#quinta1" , "#quinta2" , "#sexta1" , "#sexta2", "#sabado1" , "#sabado2" ];

  $('.counter').text( 497-  $('#descricao').val().length ); // caracteres do texto

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


  // atribuicao de mascaras
  $(".input-hora").mask("99:99");


  // Termo Estagio


    $("#termo_arquivo").click(function(){
        $("#termo_arquivo").popover("destroy");
    });  

  // Termo Estagio


//===================================================================
//                 Acao do botao de salvar
//===================================================================

$("#SalvarEstagio").click(function(){

    //===================================================================
    //              Verificacao do plano de atividades do estagio
    //==================================================================


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
    var campo_errado = false;

    $('.input-hora:nth-child(2)').each(function(){
        var actual = $(this);
        var next = $(this).next().next();

        if( actual.val().length == 0){
            if(next.val().length > 0){
                checaVisibilidadePlano();// verifica se o plano esta visivel
                actual.popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
                actual.focus();
                campo_errado = true;
                return false;
            }
        }
        else if(next.val().length == 0){
            checaVisibilidadePlano();// verifica se o plano esta visivel
            next.popover({content: "Intervalo inválido.",placement: "top"}).popover("show");
            next.focus();
            campo_errado = true;
            return false;
        }

    });

    if(campo_errado){
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
    
    if($("#termo_arquivo").val() == ''){
        // your validation error action
        checaVisibilidadeTermo();
        $("#termo_arquivo").popover({content: "Termo de Compromisso não é válido.",placement: "top"}).popover("show");
        return false;
    }

  });


});