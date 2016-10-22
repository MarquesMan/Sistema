<?php if ( ! defined('ABSPATH')) exit;

	$this->css("bootstrap-datepicker3");
	$this->js("bootstrap-datepicker");
	$this->js("bootstrap-datepicker.pt-BR.min");
	$this->js("novo-estagio");
?>


<style>
	h4, h5{	margin: 0px;}
	h5{margin-bottom: 5px;}
	.conteudo{margin-top: 15px;}
	.modalidade{height: 34px;}
	.modalidade > div{float: left;}
	.modalidade > div:first-child{margin-right: 15px;}
	select{width: 80% !important;}
	.datepicker{width: 20%; text-align: center;}
	input[type=radio]{margin-top: -1px;	vertical-align: middle;}
	#SalvarEstagio{margin-top: 15px;}
	.horario{padding-right: 20px;}
	.horario > div > div{ display: table-row; text-align: right; margin-bottom: 10px;}
	.horario > div > div > input{display: table-cell;width: 19% !important; height:  30px;}
	input[name=data], input[name=carga]{width: 30%;}
	@media (max-width: 767px) {
		.datepicker{width: 80%;}
		.horario{padding-right: 60px;}
		.modalidade > div {float: none;}
		.modalidade{margin-bottom: 20px;}
	}

</style>



<div class="row arrows">
	<div class="col-xs-2 col-md-1 col-lg-1 center">
		<span id="prev"  class="glyphicon glyphicon-chevron-left " aria-hidden="true"></span>
	</div>

	<div class="col-xs-8 col-md-10 col-lg-10 center">
		<h4>Informações Estágio</h4>
	</div>

	<div class="col-xs-2 col-md-1 col-lg-1 center">
		<span  id="next" class="glyphicon glyphicon-chevron-right " aria-hidden="true"></span>
	</div>
</div>

<form method="post" enctype="multipart/form-data">

	<div class="conteudo">
	<div class="row" id="infoEstagio" ><!-- Informacoes do estagio -->

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


	<div class="row" id="planoEstagio" hidden> <!-- Plano de atividades -->

		<div class="col-xs-12 col-md-4 col-lg-4 horario">
			<h5 class="center"><label>Horário</label></h5>

			<div class="row">
				<div class="col-xs-12">
					<label >Segunda-feira das</label>
					<input type="text" name="segunda1" id="segunda1"  class="form-control input-hora">

					<span>às</span>

					<input type="text" name="segunda2" id="segunda2"  class="form-control input-hora">
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<label>Terça-feira das</label>
					<input type="text" name="terca1" id="terca1"  class="form-control input-hora"/>

					<span>às</span>

					<input type="text" name="terca2" id="terca2" class="form-control input-hora"/>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<label>Quarta-feira das</label>
					<input type="text" name="quarta1" id="quarta1"  class="form-control input-hora"/>

					<span class="plano-hora" >às</span>

					<input type="text" name="quarta2" id="quarta2" class="form-control input-hora"/>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<label>Quinta-feira das</label>
					<input type="text" name="quinta1" id="quinta1" class="form-control input-hora"/>

					<span class="plano-hora" >às</span>

					<input type="text" name="quinta2" id="quinta2" class="form-control input-hora"/>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<label>Sexta-feira das</label>
					<input type="text" name="sexta1" id="sexta1"  class="form-control input-hora"/>

					<span class="plano-hora" >às</span>

					<input type="text" name="sexta2" id="sexta2" class="form-control input-hora"/>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<label>Sábado das</label>
					<input type="text" name="sabado1" id="sabado1"  class="form-control input-hora"/>

					<span class="plano-hora" >às</span>

					<input type="text" name="sabado2" id="sabado2"  class="form-control input-hora"/>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-md-4 col-lg-4">
			<label>Atividades a serem desenvoldidas</label>
			<textarea rows="7" cols="71" maxlength="497"  style="resize:none"  class="form-control status-box"  name="descricao" id="descricao"> </textarea>
			<p class="counter pull-right" style="padding-top:5px;padding-right:10px">497</p> <!-- caracteres restantes -->

		</div>

		<div class="col-xs-12 col-md-4 col-lg-4">
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


	<div class="row" id="termoEstagio" hidden>

		<div class="col-xs-10 col-md-10" >

			<div class="col-xs-12 col-md-12" >
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