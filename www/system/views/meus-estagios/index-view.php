<?php if ( ! defined('ABSPATH')) exit;

    $this->css("meus-estagios");

    $this->js("meus-estagios");

    $estagios = $modelo->estagios->lista_aluno();   // lista de estagios do usurio

    $this->show_msg($modelo->form_msg["msg"]);

if(count($estagios) > 0){ // aluno possui ao menos um estagio? ?>

    <header>
        <h2>Meus Estagios</h2>
    </header>

    <?php foreach ($estagios as $row) {

        if($modelo->estagios->estado($row->status) != -2){ // verifica na array de estado do estagio o numero dele, caso seja negativo, aidna nao foi aprovado ?>
                    <div class="estagio">
                        <label class="estagio-label">Empresa:</label> <?= $modelo->empresas->get($row->empresa_id)->nome      ?><br>
                        <label class="estagio-label">Supervisor:</label> <?= $modelo->users->get($row->supervisor_id)->user_name ?><br>
                        <label class="estagio-label">Área:</label> <?= $modelo->areas->get($row->area_id)->nome            ?><br>
                        <label class="estagio-label">Status:</label> <?php
                        if($modelo->estagios->estado($row->status)==5){
                            echo "Finalizado";
                        }
                        elseif($modelo->estagios->estado($row->status) < 0){
                            echo "Esperando Aprovação";
                        }
                        else{
                            echo "Em andamento";
                        }
                        ?><br>
                        <label class="estagio-label">Data Início:</label> <?= date_format(date_create($row->data_inicio), 'd/m/Y')?><br>
                        <label class="estagio-label">Data Término:</label> <?= date_format(date_create($row->data_fim), 'd/m/Y')?><br>
                        <label class="estagio-label">Carga Horária:</label> <?= $modelo->plano_atividades->get_estagio($row->id)->carga_horaria ?> h/semana<br>

                        <form class="estagio-button" method="get">
                            <input hidden name="estagioid" value="<?= $row->id ?>" ><!-- id da empresa -->
                            <button type="submit" class="btn btn-default">Documentos</button>
                        </form>
                    </div>
        <?php }

        else{ ?>

            <div class="estagio">
                <label class="estagio-label">Empresa:</label> <?= $modelo->empresas->get($row->empresa_id)->nome      ?><br>
                <label class="estagio-label">Supervisor:</label> <?= $modelo->users->get($row->supervisor_id)->user_name ?><br>
                <label class="estagio-label">Área:</label> <?= $modelo->areas->get($row->area_id)->nome            ?><br>
                <label class="estagio-label">Status:</label> <?= "Rejeitado"?><br>
                <label class="estagio-label">Data Início:</label> <?= date_format(date_create($row->data_inicio), 'd/m/Y')?><br>
                <label class="estagio-label">Data Término:</label> <?= date_format(date_create($row->data_fim), 'd/m/Y')?><br>
                <label class="estagio-label">Carga Horária:</label> <?= $modelo->plano_atividades->get_estagio($row->id)->carga_horaria ?> h/semana<br>

                <form class="estagio-button" method="get">
                    <button type="submit" class="btn btn-default" disabled="true">Documentos</button>
                </form>
            </div>
        <?php }
    }
}



else{
    echo "<div class='alert alert-info' style='width: 90%; margin-left: auto; margin-right: auto;'>Nenhum Estágio no Sistema.</div>"; // nao ha nenhum  estagio :<
} ?>

<div class="modal fade bs-example-modal-lg" id="ModalNovoEstagio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ModalLabelNovoEstagi">Novo Estágio</h4>
            </div>

            <div class="modal-body" id="ModalNovoEstagioBody">
                <?php $this->novoestagio();?>
            </div>
        </div>
    </div>
</div>


<!-- modal para editar o estagio -->
<div class="modal fade bs-example-modal-lg" id="ModalAlterarEstagio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ModalLabelAlterarEstagio">Editar Estágio Estágio</h4>
            </div>

            <div class="modal-body" id="ModalAterarEstagioBody">

            </div>
        </div>
    </div>
</div>

<div class="novo-estagio">
    <!--<button type="submit" name="numbAdd" value="<?php echo count($estagios); ?>"  class="btn btn-success" style="height: 40px; width: 200px;"  </button>-->
    <button data-toggle="modal" data-target="#ModalNovoEstagio" id="BotaoNovoEstagio" class="btn btn-success">Adcionar Estágio</button>
</div>
