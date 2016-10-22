var ultimoForm;
var texto;
$(document).ready(function(){

	

	$('.table-striped').DataTable();



	$('.recusar').click(function(ev){
		ev.preventDefault();
		ev.stopPropagation();
		$('#conteudoObservacao').val($(this).next().val());
		ultimoForm = this.form;
		texto = $(this).next();
		$("#ModalObservacao").modal('show');
	});

	$('#botaoReprova').click(function(ev){
		texto.val($('#conteudoObservacao').val());
		$(ultimoForm).submit();
	});
	

	$('#botaoCancela').click(function(ev){
		$("#ModalObservacao").modal('hide');
	});

	$('#ModalObservacao').on('hidden.bs.modal', function (){
		if($('#conteudoObservacao').val()!='')
            texto.val($('#conteudoObservacao').val() );
		$('#conteudoObservacao').val("");
	});


});