<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>


    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="images/favicon.ico"/>

    <title>Sistema de Estágios - UFMS - Login</title>



    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo base_url('includes/bootstrap/_css/bootstrap.min.css') ?>">

    <!-- Latest compiled and minified JavaScript -->
    <script src="<?php echo base_url('includes/bootstrap/_js/bootstrap.min.js') ?>"></script>

    <style>
        html{
            width: 100%;
            height: 100%;
            overflow-x: hidden;
        }

        body {
            width: 100%;
            height: 100%;
            background-color: #f5f5f5;
        }

        .rowh, .container-fluid{
            height: 100%;
        }

        .alerta{
            position: absolute;
            top: 20px;
        }

        .centro{
            display: table;
            height: 100%;
            width: 100%;
        }

        .centro-f{
            display: table-cell;
            height: 100%;
            width: 100%;
            vertical-align: middle;
        }

        label{text-align: right;}

        @media (max-width: 767px) {
            .container-fluid {width: 95%;}
            .centro-f{vertical-align: top; padding-top: 80px;}

            label{text-align: left;}
            select{width: 100%;}
        }

        input:focus:required:invalid{
            border : 1px solid #F00;
        }

    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row rowh">

        <div class="col-xs-12 col-md-12 alerta">
            <?= (isset($error))?
                    '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="max-width: 1680px; margin-left: auto; margin-right: auto;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                            .$error.
                        '</div>':

            validation_errors(
                    '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="max-width: 1680px; margin-left: auto; margin-right: auto;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
                    '</div>'
            )?>
        </div>



        <?php /*
							  []------------------------------------------------------------------------------------------------------[]
							  |									Formulário de Login  												  |
							  []------------------------------------------------------------------------------------------------------[]
							  */
        ?>
        <div class="centro">
            <div class="centro-f">

                <form class="form-horizontal" id="form_login" name="form_login" method="post" action="<?= base_url('user/validate_credentials')?>">

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 col-md-2 control-label">Nome de Usuario:</label>
                        <div class="col-sm-6 col-md-3 col-lg-3">
                            <input type="text" name="user" class="form-control" id="inputEmail3" placeholder="Nome de Usuário"
                                <?=(isset($last_username))? 'value="'.$last_username.'"':'autofocus'?> required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 col-md-2 control-label">Senha:</label>
                        <div class="col-sm-6 col-md-3 col-lg-3">
                            <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Senha" required
                                <?=(isset($last_username))? 'autofocus' : ''?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-md-offset-2 col-sm-4 col-md-3">
                            <button name="botao_envio" value="botao_login" type="submit" class="btn btn-default" style="width: 30%;">Login</button>
                        </div>
                    </div>
                </form>

                <div class="col-sm-offset-3 col-md-offset-2 col-sm-4 col-md-3" style="padding: 5px;">
                    <a href="<?= base_url('user/register')?>">Cadastre-se</a>
                    <a href="" style="padding-left: 20px;">Recuperar Senha</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>