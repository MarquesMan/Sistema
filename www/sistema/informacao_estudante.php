<?php 
	session_start();
	require_once("conecta.php");
    require_once("../../Action/banco-usuarios.php");
    require_once("../../Action/funcoes-de-controle.php");
?>

	
	<link rel="stylesheet" type="text/css" href="css/plano-de-atividades.css">
	<link href = "css/bootstrap.vertical-tabs.css" rel = "stylesheet" >
	<script src="js/jquery.maskedinput.js"></script>
    <script>
        $(document).ready(function() {

            $("#telefone").mask("(999)9999-9999?9");// Mascara Telefone
            $("#RGA").mask("9999.9999-9999");// Mascara RGA

            $("#Save").click(function(){

                var error = false;

                $(".infoInput").each(function() {

                    if($(this).val()==""){
                        $(this).popover({content: "Campo não é válido.",placement: "top"}).popover("show");
                        error = true;
                    }
                });

                if(error)
                    return false;

            });
        });
    </script>

	
<?php

    if(isset($_POST['idEstagiario'])){

        $idEstagiario = $_POST['idEstagiario'];

        if($_SESSION['auto']=='P')
            $pessoa = "supervisor";
        else
            $pessoa = "presidente";

        $estagiario = GetUsuarioById($mysqli, $idEstagiario, $pessoa);
        $estagiario = $estagiario[0];
        //$estagio = mysqli_fetch_assoc($estagio);

    }else{
        erroPadrao("Não tem permissão para acessar esse estagiário");
    }

    if($_SESSION['auto']=='V'){
        $disabled = false;
    }else{
        $disabled = "disabled=\"disabled\"";
    }

    $cursos = Lista_Cursos();

?>
<div class="row">
    <form method="post" action="Controllers/Controller-perfil-usuario.php">


        <?php if($disabled===false){?>
        <input type="hidden" name="id_estagiario" value="<?php echo $idEstagiario; ?>" >
        <?php } ?>

        <div class="col-xs-5 col-md-3" align="right">
            <label for="nomeCompleto">Nome Completo:</label>
            <label for="telefone">Telefone:</label>

        </div>

        <div class="col-xs-6 col-md-3">
            <input class="infoInput" name="nomeCompleto" id="nomeCompleto" value="<?php echo $estagiario["Nome_Completo"]; ?>" >
            <input class="infoInput" name="telefone" id="telefone" value="<?php echo $estagiario["Telefone"]; ?>" >
        </div>


        <div class="col-xs-12 col-md-1" style="margin-left:10px">
            <label for="RGA">Rga:</label><br>
            <label for="email">Email:</label>
        </div>

        <div class="col-xs-12 col-md-3">

            <input class="infoInput" name="RGA" id="RGA" value="<?php echo $estagiario["Rga"]; ?>" >
            <input class="infoInput" name="email" id="email" value="<?php echo $estagiario["Email"]; ?>" >
        </div>

        <div class="col-xs-12 col-md-6">
            <label for="curso">Curso:</label>
            <select class="form-control infoInput" id="curso" name="curso" style="text-overflow: ellipsis;">
                <?php

                foreach($cursos as $item ){

                    if($item['nome']!='Nenhum'){
                        if($item['Id_Curso']== $estagiario["Id_Curso"] ){
                            echo '<option selected="selected" value="' . $item['Id_Curso'] . '">' . $item['nome'] . '</option>';
                        }
                        else {
                            echo '<option value="' . $item['Id_Curso'] . '">' . $item['nome'] . '</option>';
                        }
                    }
                }

                ?>
            </select>
        </div>

        <div class="col-xs-12 col-md-6">
        <?php if($_SESSION['auto']=='V'){ ?>
                <button id="Save" name="editaPerfilAdmin" class="btn btn-success" width="100%">Salvar</button>
        <?php }?>
        </div>

    </form>
</div>


