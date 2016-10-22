<?php if ( ! defined('ABSPATH')) exit; ?>
<?php $modelo->validate_recovery_form();?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" charset='UTF-8'>
    <link rel="shortcut icon" href="images/favicon.ico"/>

    <title>Sistema de Estágios - UFMS - Login</title>
    <?php $this->css("bootstrap");?>
    <?php $this->css("index");?>
    <?php $this->css("fontello-ie7-codes");?>
    <?php $this->js("jquery-1.11.1.min");?>
    <?php $this->js("jquery-ui.min");?>
    <?php $this->js("bootstrap.min");?>
    <?php $this->js("jquery.maskedinput");?>
    <?php $this->js("cadastros");?>
</head>

<body>
<div class="container-fluid">
    <div class="row rowh">
        <?php echo chk_array( $modelo->form_msg, 'erro'); ?>
        <div class="centro">
            <div class="centro-f">
                <?php /*
										  []------------------------------------------------------------------------------------------------------[]
									      |									Formul�rio de Reuperar Senha										  |
										  []------------------------------------------------------------------------------------------------------[]
										  */
                ?>

                <form id="Form_Recovery" name="form" method="post" action="" class="form-horizontal">

                    <div class="row">
                        <label class="col-sm-3 col-md-2 col-lg-2">Tipo de Dado:</label>
                        <div class="col-sm-3 col-md-2 col-lg-2" style="margin-bottom: 20px;">
                            <select id="tipo-dado" name="tipo-dado" class="form-control">
                                <option value="email" <?= (chk_array( $modelo->form_data, 'tipo-dado') == "email")?"selected":"";?>>E-mail</option>
                                <option value="rga" <?= (chk_array( $modelo->form_data, 'tipo-dado') == "rga")?"selected":"";?>>RGA</option>
                                <option value="user" <?= (chk_array( $modelo->form_data, 'tipo-dado') == "user")?"selected":"";?>>Nome de Usuário</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Dado:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="dado" class="form-control" />
                        </div>
                        <span class="help-inline"><?php echo chk_array( $modelo->form_msg, 'dado'); ?></span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-md-offset-2 col-lg-offset-2 col-sm-2 col-md-2 col-lg-2">
                            <button id="botao_recuperacao" name="botao_recuperar" value="Recuperar"  class="btn btn-primary" style="width: 100%;">Recuperar</button>
                        </div>
                        <div class="col-sm-1 col-md-2 col-lg-2">
                            <a href="<?= HOME_URI?>" class="btn btn-default">Fazer Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>