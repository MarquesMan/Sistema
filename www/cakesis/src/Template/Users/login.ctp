<?php $this->layout = false;?>

<!DOCTYPE html>
    <html>

    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema de Estágios- UFMS</title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css('bootstrap')?>
        <?= $this->Html->css('login')?>
        <?= $this->Html->script('jquery-2.1.4.js')?>
        <?= $this->Html->script('jquery-ui.min.js')?>
        <?= $this->Html->script('jquery.maskedinput.js')?>

        <?= $this->Html->script('bootstrap.min.js')?>
        <?= $this->Html->script('login.js')?>
    </head>

    <body>
        <div id="container-fluid" style="height: 100%;">
            <div id="content" style="height: 100%;">
                <?= $this->Flash->render() ?>
                <div class="row" style="height: 100%;">
                    <div class="centro">
                        <div class="centro-f">
                            <?php
                            echo $this->Form->create(null, [
                                'horizontal' => true,
                                'cols' => [
                                    'sm' => ['label' => 3, 'input' => 6, 'error' => 4],
                                    'md' => ['label' => 2, 'input' => 3, 'error' => 4],
                                    'lg' => ['input' => 3]
                                ]
                            ]);
                            echo $this->Form->input('username', ['type' => 'text', 'label'=> 'Nome de Usuário']) ;
                            echo $this->Form->input('password', ['type' => 'password', 'label' => 'Senha']) ;
                            echo $this->Form->submit('Log In') ;
                            echo $this->Form->end() ;
                            ?>

                            <div class="col-sm-offset-3 col-md-offset-2 col-sm-4 col-md-3" style="padding: 5px;">
                                <a id="cadastrar" href="#">Cadastre-se</a>
                                <a id="recuperar" href="#" style="padding-left: 20px;">Recuperar Senha</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="menuslide_cadastrar" class="menuslide">
            <div class="container">
                <div class="row">

                    <div name="fechar_slide">
                        <button> >>> </button>
                    </div>

                    <div class="centro">
                        <div class="centro-f">
                            <div class="row">
                                <label class="col-sm-3 col-md-3 col-lg-2">Tipo Cadastro:</label>
                                <div class="col-sm-3 col-md-2 col-lg-2" style="margin-bottom: 20px;">
                                    <?= $this->Form->select('tipo', ['E' => 'Estudante', 'P' => 'Supervisor', 'B' => 'Empresa'], ['id' => 'proforaluno']);?>
                                </div>
                            </div>

                            <?php
                            /*
							  []------------------------------------------------------------------------------------------------------[]
							  |									Formulário de Cadastro Pessoas										  |
							  []------------------------------------------------------------------------------------------------------[]
							*/

                            echo $this->Form->create(null, [
                                'horizontal' => true,
                                'cols' => [
                                    'sm' => ['label' => 3, 'input' => 3, 'error' => 4, 'button' => 3],
                                    'md' => ['label' => 3, 'input' => 3, 'error' => 4, 'button' => 3],
                                    'lg' => ['label' => 2, 'input' => 4, 'button' => 3],
                                    'sm-offset' => ['button' => 3],
                                    'md-offset' => ['button' => 3],
                                    'lg-offset' => ['button' => 2]
                                ],
                                'id' => 'form-pessoa',
                                'name' => 'Form'
                            ]);
                            echo $this->Form->input('tipo', ['type' => 'hidden', 'id' => 'tipo']) ;
                            echo $this->Form->input('full_name', ['label' => 'Nome Completo:']) ;
                            echo $this->Form->input('username', ['label' => 'Nome de Usuario:']) ;
                            echo '<div id="cursoID" class="form-group">
										<label class="col-sm-3 col-md-3 col-lg-2 control-label">Curso:</label>
										<div class="col-sm-3 col-md-3 col-lg-4">';
                            echo $this->Form->select('Idcurso', ['1' => '1', '2' => '2']);
                            echo '	</div>
									</div>';
                            echo $this->Form->input('rga', ['label' => 'RGA:']) ;
                            echo $this->Form->input('email') ;
                            echo $this->Form->input('password', ['label' => 'Senha:']) ;
                            echo $this->Form->input('conf_password', ['type' => 'pasaword', 'label' => 'Senha:']) ;
                            echo $this->Form->submit('Cadastrar', ['id' => 'cadastro_pessoa', 'name' => 'botao_envio', 'value' => 'botao_pessoa']) ;
                            echo $this->Form->end() ;

                            /*
							    []------------------------------------------------------------------------------------------------------[]
								|									Formulário de Cadastro de Empresa    								 |
								[]------------------------------------------------------------------------------------------------------[]
						    */

                            echo $this->Form->create(null, [
                                'horizontal' => true,
                                'cols' => [
                                    'sm' => ['label' => 3, 'input' => 3, 'error' => 4, 'button' => 3],
                                    'md' => ['label' => 3, 'input' => 3, 'error' => 4, 'button' => 3],
                                    'lg' => ['label' => 2, 'input' => 4, 'button' => 3],
                                    'sm-offset' => ['button' => 3],
                                    'md-offset' => ['button' => 3],
                                    'lg-offset' => ['button' => 2]
                                ],
                                'id' => 'form-empresa',
                                'name' => 'form-empresa'
                            ]);
                            echo $this->Form->input('nome-empresa', ['type' => 'text', 'label' => 'Nome:']) ;
                            echo $this->Form->input('cep-empresa', ['type' => 'text', 'id' => 'cep','label' => 'CEP:']) ;
                            echo $this->Form->input('rua-empresa', ['type' => 'text', 'label' => 'Rua:']) ;
                            echo $this->Form->input('numero-empresa', ['type' => 'text', 'label' => 'Número:']) ;
                            echo $this->Form->input('bairro-empresa', ['type' => 'text', 'label' => 'Bairro:']) ;
                            echo $this->Form->input('complemento', ['type' => 'text', 'label' => 'Complemento:']) ;
                            echo $this->Form->input('telefone-empresa', ['type' => 'text', 'id' => 'telefone', 'label' => 'Telefone:']) ;
                            echo $this->Form->input('email', ['name' => 'email-empresa']) ;
                            echo $this->Form->submit('Cadastrar', ['id' => 'cadastro_empresa', 'name' => 'botao_envio', 'value' => 'botao_empresa']) ;
                            echo $this->Form->end() ;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="menuslide_recuperar" class="menuslide">
            <div class="container">
                <div class="row">
                    <div name="fechar_slide">
                        <button> >>> </button>
                    </div>

                    <div class="centro">
                        <div class="centro-f">
                            <?php /*
										  []------------------------------------------------------------------------------------------------------[]
									      |									Formulário de Reuperar Senha										  |
										  []------------------------------------------------------------------------------------------------------[]
										  */
                            echo $this->Form->create(null, [
                                'horizontal' => true,
                                'cols' => [
                                    'sm' => ['label' => 3, 'input' => 3, 'error' => 4, 'button' => 3],
                                    'md' => ['label' => 3, 'input' => 3, 'error' => 4, 'button' => 3],
                                    'lg' => ['label' => 2, 'input' => 4, 'button' => 3],
                                    'sm-offset' => ['button' => 1, 'input' => 1],
                                    'md-offset' => ['button' => 1, 'input' => 1],
                                    'lg-offset' => ['button' => 1, 'input' => 1]
                                ],
                                'id' => 'Form_Recovery',
                                'name' => 'form'
                            ]);
                            echo "<div class='row'>
                                    <div class='col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-sm-3 col-md-2 col-lg-2' style='margin-bottom: 20px;'>".
                                        $this->Form->select('tipo', ['E' => 'E-mail', 'R' => 'RGA', 'U' => 'Nome de Usuário'], ['default' => 'E', 'id' => 'Select_field'])
                                    ."</div>
                                </div>";
                            echo $this->Form->input('inp_indentificacao', ['type' => 'text', 'label' => false]) ;
                            echo $this->Form->submit('Recuperar', ['id' => 'botao_recuperacao', 'name' => 'botao_recuperar', 'value' => 'Recuperar']) ;
                            echo $this->Form->end() ;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>