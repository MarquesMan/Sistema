<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" charset='UTF-8'>
    <link rel="shortcut icon" href="images/favicon.ico"/>

    <title>Sistema de Estágios - UFMS - Login</title>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo base_url('includes/bootstrap/_css/bootstrap.min.css') ?>">

    <!-- Latest compiled and minified JavaScript -->
    <script src="<?php echo base_url('includes/bootstrap/_js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('includes/bootstrap/_js/register.js') ?>"></script>

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

        input:focus::invalid{
            border : 1px solid #F00;
        }
        input:invalid { border: 1px solid red; }

    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row rowh">
        <div class="col-xs-12 col-md-12 alerta">
            <?php validation_errors(); ?>
        </div>

        <div class="centro">
            <div class="centro-f">
                <div class="row">
                    <label class="col-sm-3 col-md-2 col-lg-2">Tipo Cadastro:</label>
                    <div class="col-sm-3 col-md-2 col-lg-2" style="margin-bottom: 20px;">
                        <select id="proforaluno" name="tipo" class="form-control" ><!--Na tela 4:3 precisa pelo menos 22% senao o texto fica cortado-->
                            <option data-show="#form-estudante">Estudante</option>
                            <option data-show="#form-supervisor">Surpevisor</option>
                            <option data-show="#form-empresa">Empresa</option>
                        </select>
                    </div>
                </div>

                <?php /*
				[]------------------------------------------------------------------------------------------------------[]
				|								Formulário de Cadastro Estudante                                         |
				[]------------------------------------------------------------------------------------------------------[]
				 */
                ?>

                <form id="form-estudante" name="Form" method="post" action="<?= base_url('user/register_estudante')?>" class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Nome Completo:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="user_name" class="form-control" type="text" pattern="([a-z] | [A-Z]){*}"  value="<?php
                            echo set_value('user_name');?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Nome de Usuário:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="user" class="form-control"  value="<?php
                            echo set_value('user');?>"/>

                        </div>

                    </div>

                    <div id="cursoID" class="form-group row">
                        <label class="col-sm-3 col-md-2 col-lg-2">Curso:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <select class="form-control" name="id_curso"  style="text-overflow: ellipsis;">
                                <?php

                                foreach($cursos as $item ){
                                    if($item['curso']!='Nenhum'){?>
                                        <option <?= (set_value("id_curso") == $item["id"])?"selected": "";?>
                                            value="<?= $item['id']?>" > <?= $item['nome']?> </option>
                                    <?php }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div id="rgaID" class="form-group row">
                        <label class="col-sm-3 col-md-2 col-lg-2">RGA:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="rga" class="form-control"  value="<?php
                            echo set_value( 'rga');?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">E-mail:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="email" type="email" class="form-control"   value="<?php
                            echo set_value( 'email');?>"/>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Senha:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="user_password" type="password"  class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Confirmar Senha:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="conf_password" type="password"  class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-md-offset-2 col-lg-offset-2 col-sm-2 col-md-2 col-lg-2">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Cadastrar</button>
                        </div>
                        <div class="col-sm-1 col-md-2 col-lg-2">
                            <a href="<?= base_url('user')?>" class="btn btn-default">Fazer Login</a>
                        </div>
                    </div>
                </form>



                <?php /*
				[]------------------------------------------------------------------------------------------------------[]
				|								Formulário de Cadastro Supervisor                                        |
				[]------------------------------------------------------------------------------------------------------[]
				 */
                ?>

                <form id="form-supervisor" name="Form" method="post" action="<?= base_url('user/register_supervisor')?>" class="form-horizontal" hidden="true">

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Nome Completo:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="user_name" class="form-control" type="text" pattern="([a-z] | [A-Z]){*}"  value="<?php
                            echo set_value( 'user_name');?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Nome de Usuário:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="user" class="form-control"  value="<?php
                            echo set_value( 'user');?>"/>

                        </div>

                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">E-mail:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="email" class="form-control" type="email"  value="<?php
                            echo set_value( 'email');?>"/>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Senha:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="user_password" type="password"  class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Confirmar Senha:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="conf_password" type="password"  class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-md-offset-2 col-lg-offset-2 col-sm-2 col-md-2 col-lg-2">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Cadastrar</button>
                        </div>
                        <div class="col-sm-1 col-md-2 col-lg-2">
                            <a href="<?= base_url('user')?>" class="btn btn-default">Fazer Login</a>
                        </div>
                    </div>
                </form>



                <?php /*
									  []------------------------------------------------------------------------------------------------------[]
								      |									Formulário de Cadastro de Empresa									  |
									  []------------------------------------------------------------------------------------------------------[]
									  */
                ?>

                <form id="form-empresa" name="Form-empresa" method="post" action="<?= base_url('user/register_empresa')?>" class="form-horizontal" hidden="true">

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Nome:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="nome_empresa" class="form-control"  />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">CEP:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input id="cep" type="text" name="cep_empresa" class="form-control"  />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Rua:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="rua_empresa" class="form-control"  />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Número:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="numero_empresa" class="form-control"  />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">Bairro:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="bairro_empresa" class="form-control"  />
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
                            <input id="telefone" type="text" name="telefone_empresa" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 col-lg-2">E-mail:</label>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input name="email_empresa" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-md-offset-3 col-lg-offset-2 col-sm-2 col-md-2 col-lg-2">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Cadastrar</button>
                        </div>
                        <div class="col-sm-1 col-md-2 col-lg-2">
                            <a href="<?= base_url('user')?>" class="btn btn-default">Fazer Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>