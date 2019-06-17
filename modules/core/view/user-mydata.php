<?php 
use zion\core\Session;
$user = Session::get("user");
?>
<div class="container-fluid">
    <div class="center-content">
    	<br>
    	<h3>Meus Dados</h3>
    	
    	<div class="row">
    		<div class="col-6">
    			<br>
    			<h6>Nome</h6>
    			<?=$user->name?><br>
    			<br>
    			<h6>Perfil</h6>
    			<?=$user->perfil?><br>
    			<br>
    			<h6>E-mail</h6>
    			<?=$user->email?><br>
    		</div>
    		<div class="col-6">
        		
        		<form class="form-horizontal ajaxform" action="/zion/mod/core/User/changePassword" method="POST" data-callback="defaultCallback">
        		<div class="card">
        			<div class="card-header">
        				Redefinição de Senha
        			</div>
        			<div class="card-body">
        				<div class="row">
        					<div class="col-sm-4">
        						<label class="control-label" for="password1">
        							Senha Atual
        						</label>
        					</div>
        					<div class="col-sm-6">
        						<input id="password1" name="password1" type="password" class="form-control" value="">
        					</div>
        				</div>
        				<div class="row">
        					<div class="col-sm-4">
        						<label class="control-label" for="password2">
        							Nova senha
        						</label>
        					</div>
        					<div class="col-sm-6">
        						<input id="password2" name="password2" type="password" class="form-control" value="">
        					</div>
        				</div>
        				<div class="row">
        					<div class="col-sm-4">
        						<label class="control-label" for="password3">
        							Confirmação da Senha
        						</label>
        					</div>
        					<div class="col-sm-6">
        						<input id="password3" name="password3" type="password" class="form-control" value="">
        					</div>
        				</div>
        			</div>
        			<div class="card-footer">
        				<button type="submit" class="btn btn-outline-primary">Atualizar</button>
        			</div>
        		</div>
        		</form>
        		
        	</div>
    	</div>
    </div>
</div>