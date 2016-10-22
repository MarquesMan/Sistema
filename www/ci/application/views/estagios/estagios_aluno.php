<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<link rel="stylesheet" href="<?php echo base_url('includes/bootstrap/_css/meus-estagios.css') ?>">
<script src="<?php echo base_url('includes/bootstrap/_js/meus-estagios.js') ?>"></script>

<?php


if(count($estagios) > 0){ // aluno possui ao menos um estagio? ?>

    <header>
        <h2>Meus Estagios</h2>
    </header>

    <?php foreach ($estagios as $row) {
        // verifica na array de estado do estagio o numero dele, caso seja negativo, aidna nao foi aprovado ?>
        <div class="estagio">
            <label class="estagio-label">Empresa:</label> <?= $row['empresa_nome'] ?><br>
            <label class="estagio-label">Supervisor:</label> <?= $row['supervisor_nome'] ?><br>
            <label class="estagio-label">Área:</label> <?= $row['area_nome'] ?><br>
            <label class="estagio-label">Status:</label> <?= $row['status'] ?><br>
            <label class="estagio-label">Data Início:</label> <?= date_format(date_create($row['data_inicio']), 'd/m/Y')?><br>
            <label class="estagio-label">Data Término:</label> <?= date_format(date_create($row['data_fim']), 'd/m/Y')?><br>
            <label class="estagio-label">Carga Horária:</label> <?= $row['carga_horaria'] ?> h/semana<br>

            <form class="estagio-button" method="get">
                <input hidden name="estagioid" value="<?= $row['id'] ?>" ><!-- id da empresa -->
                <button type="submit" class="btn btn-default" <?=($row['status'] == 'Rejeitado')? 'disabled':''?> >Documentos</button>
            </form>
        </div>
        <?php

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
                <?php $this->view('estagios/novo_estagio', $novo_estagio)?>
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
