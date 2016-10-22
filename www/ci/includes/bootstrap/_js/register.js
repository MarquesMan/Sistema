$(document).ready(function()
{
    $("form").hide();
    $form = $(this).find(':selected').data('show');

    $($form).show();

    $("#proforaluno").change(function()
    {
        $("form").hide();
        $form = $(this).find(':selected').data('show');

        $($form).show();
    });

    $("#telefone").mask("(99) 9999-9999");
    $("#cep").mask("99999-999");
});