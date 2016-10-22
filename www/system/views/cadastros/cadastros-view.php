<?php if ( ! defined('ABSPATH')) exit; ?>
<?php $modelo->validate_register_form();?>
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
        <div class="col-xs-12 col-md-12 alerta">
            <?php echo chk_array( $modelo->form_msg, 'empty'); ?>
        </div>

        <div class="centro">
            <div class="centro-f">
                <div class="row">
                    <label class="col-sm-3 col-md-2 col-lg-2">Tipo Cadastro:</label>
                    <div class="col-sm-3 col-md-2 col-lg-2" style="margin-bottom: 20px;">
                        <select id="proforaluno" name="tipo" class="form-control" ><!--Na tela 4:3 precisa pelo menos 22% senao o texto fica cortado-->
                            <option value="E">Estudante</option>
                            <option value="P">Surpevisor</option>
                            <option value="B">Empresa</option>
                        </select>
                    </div>
                </div>

                <?php /*
				[]------------------------------------------------------------------------------------------------------[]
				|								Formulário de Cadastro Pessoas                                           |
				[]------------------------------------------------------------------------------------------------------[]
				 */
                ?>

                <form id="form-pessoa" name="Form" method="post" action="" class="form-horizontal">
                    <input id="tipo" name="tipo" hidden />

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Nome Completo:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="user_name" class="form-control" value="<?php
                            echo htmlentities( chk_array( $modelo->form_data, 'user_name'));?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Nome de Usuário:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="user" class="form-control" value="<?php
                            echo htmlentities( chk_array( $modelo->form_data, 'user'));?>"/>
                            <span class="help-inline"><?php echo chk_array( $modelo->form_msg, 'user'); ?></span>
                        </div>

                    </div>

                    <div id="cursoID" class="form-group row">
                        <label class="col-sm-3 col-md-2 col-lg-2">Curso:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <select class="form-control" name="id_curso" style="text-overflow: ellipsis;">
                                <?php
                                $cursos = $modelo->get_curso_list();
                                foreach($cursos as $item ){
                                    if($item['curso']!='Nenhum'){?>
                                        <option <?= (chk_array( $modelo->form_data, "id_curso") == $item["Id_Curso"])?"selected": "";?>
                                             value="<?= $item['Id_Curso']?>" > <?= $item['curso']?> </option>
                                    <?php }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div id="rgaID" class="form-group row">
                        <label class="col-sm-3 col-md-2 col-lg-2">RGA:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="rga" class="form-control" value="<?php
                            echo htmlentities( chk_array( $modelo->form_data, 'rga'));?>"/>
                            <span class="help-inline"><?php echo chk_array( $modelo->form_msg, 'rga');?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">E-mail:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="email" class="form-control" value="<?php
                            echo htmlentities( chk_array( $modelo->form_data, 'email'));?>"/>
                            <span class="help-inline"><?php echo chk_array( $modelo->form_msg, 'email');?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Senha:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="user_password" type="password" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Confirmar Senha:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="conf_password" type="password" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-md-offset-2 col-lg-offset-2 col-sm-2 col-md-2 col-lg-2">
                            <button id="cadastro_pessoa" name="botao_envio" value="botao_pessoa" value="Cadastrar" class="btn btn-primary" style="width: 100%;">Cadastrar</button>
                        </div>
                        <div class="col-sm-1 col-md-2 col-lg-2">
                            <a href="<?= HOME_URI?>" class="btn btn-default">Fazer Login</a>
                        </div>
                    </div>
                </form>

                <?php /*
									  []------------------------------------------------------------------------------------------------------[]
								      |									Formulário de Cadastro de Empresa									  |
									  []------------------------------------------------------------------------------------------------------[]
									  */
                ?>

                <form id="form-empresa" name="Form-empresa" method="post" action="Controllers/Controller-index.php" class="form-horizontal" hidden>
                    <input name="tipo" value="B" hidden></input>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Nome:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="nome_empresa" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">CEP:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input id="cep" type="text" name="cep_empresa" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Rua:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="rua_empresa" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Número:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="numero_empresa" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Bairro:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="bairro_empresa" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Complemento:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="complemento" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Telefone:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input id="telefone" type="text" name="telefone_empresa" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">E-mail:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="email_empresa" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-md-offset-3 col-lg-offset-2 col-sm-2 col-md-2 col-lg-2">
                            <button id="cadastro_empresa" name="botao_envio" value="botao_empresa" value="Cadastrar" class="btn btn-primary" style="width: 100%;">Cadastrar</button>
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