<?php if ( ! defined('ABSPATH')) exit;

$this->css("bootstrap-datepicker3");
$this->js("bootstrap-datepicker");
$this->js("bootstrap-datepicker.pt-BR.min");
$this->js("novo-estagio");
?>


<style>
    h4, h5{	margin: 0px;}
    h5{margin-bottom: 5px;}

    .modalidade{height: 34px; margin-bottom: 10px;}
    .modalidade > div{float: left;}
    .modalidade > div:first-child{margin-right: 15px;}

    select{width: 80% !important;}
    .datepicker{min-width: 100px; width: 20%; text-align: center;}

    input[type=radio]{margin-top: -1px;	vertical-align: middle;}
    #SalvarEstagio{margin-top: 15px; min-width: 200px; float: right}
    input[name=data], input[name=carga]{width: 30%;}
    .nome-documento{border-bottom: 20px; font-size: 22px;}
    #planoEstagio, #termoEstagio{margin-top: 20px; border-top: solid 2px #e5e5e5; padding-top: 10px;}
    .input-hora{display: inline; max-width: 65px;}
    .label-dia{min-width: 140px; text-align: right;}
    .form-control{margin-bottom: 10px}


    .atividades > textarea{min-height: 210px}
    .atividades{ width: 33%; float: left; min-height: 289px; min-width: 285px;}
    .horarios{width: 350px; float: left; min-height: 289px; padding-left: 10px;}
    .local{width: 33%; float: left; min-height: 289px;}

    @media (max-width: 767px) {
        .datepicker{width: 80%;}
        .modalidade > div {float: none;}
        .modalidade{margin-bottom: 20px;}
        .atividades, .horarios, .local{ width: 90%; float: none; margin: auto}

    }



</style>


<form method="post" enctype="multipart/form-data" action="<?= HOME_URI.'/meus-estagios'?>">

    <div class="conteudo">
        <div class="row" id="infoEstagio" ><!-- Informacoes do estagio -->

            <div class="col-xs-12 col-md-12 nome-documento" >
                <label class="">Informações do estágio</label>
            </div>


            <div class="col-xs-12 col-md-6 col-lg-6">
                <label class="col-xs-12">Modalidade</label>

                <div class="col-xs-12 modalidade">
                    <div>
                        <label>Obrigatório</label>
                        <input type="radio" name="Modalidade"  value="1">
                    </div>

                    <div>
                        <label>Não Obrigatório</label>
                        <input type="radio" name="Modalidade"  value="0" checked >
                    </div>
                </div>

                <div class="col-xs-12">
                    <label>Supervisor</label>
                    <select name="Codigo_Supervisor" class="form-control">
                        <?php foreach($modelo->users->lista_supervisores() as $supervisor){
                            echo '<option value="'. $supervisor->user_id . '">' .$supervisor->user_name. '</option>';
                        } ?>
                    </select>


                    <label>Empresa</label>
                    <select name="Codigo_Empresa" class="form-control">
                        <?php foreach($modelo->empresas->lista() as $empresa) {
                            echo '<option value="'. $empresa->id .'">'.$empresa->nome.'</option>';
                        } ?>
                    </select>
                </div>

            </div>

            <div class="col-sm-12 col-md-6 col-lg-6" >

                <div class="col-xs-12">
                    <label>Área</label>
                    <select name="Codigo_Area" class="form-control">
                        <?php foreach($modelo->areas->lista() as $area) {
                            echo '<option value="'.$area->id.'">'.$area->nome.'</option>';
                        } ?>
                    </select>


                    <label>Data Ínicio</label>
                    <input type="text" name="dataInicial" id="dataInicial" class="form-control datepicker">


                    <label>Data Final</label><br>
                    <input type="text" name="dataFinal" id="dataFinal" class="form-control datepicker">
                </div>

            </div>

        </div>


        <div class="row" id="planoEstagio"> <!-- Plano de atividades -->
            <label class="col-xs-12 nome-documento">Plano de Atividades</label>
            <div class="horarios">
                <h5 class="center"><label>Horário</label></h5>

                <div class="row">
                    <div class="col-xs-12">
                        <label class="label-dia">Segunda-feira das</label>
                        <input type="text" name="segunda1" id="segunda1"  class="form-control input-hora">

                        <span>às</span>

                        <input type="text" name="segunda2" id="segunda2"  class="form-control input-hora">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <label class="label-dia">Terça-feira das</label>
                        <input type="text" name="terca1" id="terca1"  class="form-control input-hora"/>

                        <span>às</span>

                        <input type="text" name="terca2" id="terca2" class="form-control input-hora"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <label class="label-dia">Quarta-feira das</label>
                        <input type="text" name="quarta1" id="quarta1"  class="form-control input-hora"/>

                        <span class="plano-hora" >às</span>

                        <input type="text" name="quarta2" id="quarta2" class="form-control input-hora"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <label class="label-dia">Quinta-feira das</label>
                        <input type="text" name="quinta1" id="quinta1" class="form-control input-hora"/>

                        <span class="plano-hora" >às</span>

                        <input type="text" name="quinta2" id="quinta2" class="form-control input-hora"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <label class="label-dia">Sexta-feira das</label>
                        <input type="text" name="sexta1" id="sexta1"  class="form-control input-hora"/>

                        <span class="plano-hora" >às</span>

                        <input type="text" name="sexta2" id="sexta2" class="form-control input-hora"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <label class="label-dia">Sábado das</label>
                        <input type="text" name="sabado1" id="sabado1"  class="form-control input-hora"/>

                        <span class="plano-hora" >às</span>

                        <input type="text" name="sabado2" id="sabado2"  class="form-control input-hora"/>
                    </div>
                </div>
            </div>

            <div class="atividades">
                <label>Atividades a serem desenvoldidas</label>
                <textarea rows="7" cols="71" maxlength="497"  style="resize:none"  class="form-control status-box"  name="descricao" id="descricao"> </textarea>
                <p class="counter pull-right" style="padding-top:5px;padding-right:10px">497</p> <!-- caracteres restantes -->

            </div>

            <div class="local">
                <label class="col-xs-12">Local</label>
                <div class="col-xs-12">
                    <input id="local" type="text" class="form-control" name="local">
                </div>

                <label class="col-xs-12">Carga horária</label>
                <div class="col-xs-12">
                    <input type="text" class="form-control center" id="carga" name="carga" value="0:0">
                </div>

                <label class="col-xs-12">Data</label>
                <div class="col-xs-12">
                    <input type="text" class="form-control datepicker" id="data" name="data" >
                </div>

            </div>

        </div><!-- Plano de atividades -->


        <div class="row" id="termoEstagio">

            <div class="col-xs-10 col-md-10" >

                <div class="col-xs-12 col-md-12 nome-documento" >
                    <label>Termo de Compromisso</label>
                </div>

                <div class="col-xs-12 col-md-12" >
                    <input type="hidden" name="MAX_FILE_SIZE" value="16777216">
                    <p><input name="termo_arquivo" type="file" id="termo_arquivo" accept="application/pdf"></p>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-12">
                <button id="SalvarEstagio" class="btn btn-success">Salvar</button>
            </div>
        </div>
    </div>

</form>