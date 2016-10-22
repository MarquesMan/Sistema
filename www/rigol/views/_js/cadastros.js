$(document).ready(function()
{
    $("#form-pessoa").show();
    $("#form-empresa").hide();

    if($("#proforaluno").val() == 'E'){
        $("#rgaID").show();
        $('#cursoID').show();
        $("#tipo").val('E');
    }

    else if($("#proforaluno").val() == 'P'){
        $("#tipo").val('P');
        $("#rgaID").hide();
        $('#cursoID').hide();
        document.forms["Form"]["rga"].value = "";
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
        }
        else if($("#proforaluno").val() == 'P'){
            $("#rgaID").hide();
            $('#cursoID').hide();
            $("#form-pessoa").show();
            $("#form-empresa").hide();
            $("#tipo").val('P');
            document.forms["Form"]["rga"].value = "";
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