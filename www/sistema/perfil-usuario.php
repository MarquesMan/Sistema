<?php require_once("cabecalho.php");?>

<script src="js/perfil-usuario.js"></script>

<div>
  <form id="form" class="form-horizontal" method="post" action="Controllers/Controller-perfil-usuario.php">
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-offset-3 col-sm-2 control-label">Senha atual:</label>
      <div class="col-sm-3">
        <input type="password" class="form-control" placeholder="Senha atual" name="senha_atual">
      </div>
    </div>
    
    <div class="form-group">
      <label for="inputPassword3" class="col-sm-offset-3 col-sm-2 control-label">Nova senha:</label>
      <div class="col-sm-3">
        <input type="password" class="form-control" placeholder="Nova senha" name="nova_senha">
      </div>
    </div>
    
    <div class="form-group">
      <label for="inputPassword3" class="col-sm-offset-3 col-sm-2 control-label">Confirmar nova senha:</label>
      <div class="col-sm-3">
        <input type="password" class="form-control" placeholder="Corfirmar senha" name="confirma_senha">
      </div>
    </div>
    
    <div class="form-group">
      <div class="col-sm-offset-5 col-sm-3">
        <button type="submit" class="btn btn-success">Salvar</button>
      </div>
    </div>
  </form>
</div>
<?php require_once("rodape.php"); ?>