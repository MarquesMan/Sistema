$(document).ready(function(){
    $("input").blur(function(){
    	if($(this).val() == "")
    	{
    		$(this).css({"border" : "1px solid #F00"});
        }
        else
        	$(this).css({"border" : "1px solid #FFF"});
    });

    $("#form").submit(function(event){
        var cont = 0;

        $(".alert").remove();

        $("input").each(function()
        {
            if($(this).val() == ""){
                cont++;
                $(this).css({"border" : "1px solid #F00"});
            }
        });

        if(cont == 0){
            var z = $("input[name=senha_atual]").val();
            var x = $("input[name=nova_senha]").val();
            var y = $("input[name=confirma_senha]").val();

            if(x == y){
                if(x == z){
                    $("input[name=senha_atual]").val("");
                    $("input[name=nova_senha]").val("");
                    $("input[name=confirma_senha]").val("");
                    $("form").before('<div class="alert alert-danger alert-dismissible text-center" role="alert" style="width: 80%; margin-left: auto; margin-right: auto;">       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Nova senha deve ser diferente da antiga.</div>');
                    return false;
                }       
            }

            else{
                $("input[name=senha_atual]").val("");
                $("input[name=nova_senha]").val("");
                $("input[name=confirma_senha]").val("");
                $("form").before('<div class="alert alert-danger alert-dismissible text-center" role="alert" style="width: 80%; margin-left: auto; margin-right: auto;">       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>As senhas são diferentes.</div>');
                return false;
            }
        }

        else{
            $("form").before('<div class="alert alert-danger alert-dismissible text-center" role="alert" style="width: 80%; margin-left: auto; margin-right: auto;">       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Todos os campos devem ser preenchidos.</div>');
            return false;
        }
    });
});