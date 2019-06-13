<?php
use zion\core\System;
use zion\utils\TextFormatter;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$key = array("mandt","server");
$keyString = $obj->concat($key,":");
?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/mail/">mail</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/mail/Server/list">Consulta de Server</a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de Server</li>
		</ol>
	</nav>
<h3>Formulário de Server</h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/mail/Server/" method="<?=$method?>" data-callback="defaultRegisterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Formulário
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[mandt]">mandt</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[mandt]" name="obj[mandt]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("mandt"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[server]">server</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[server]" name="obj[server]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("server"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[smtp_host]">smtp_host</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[smtp_host]" name="obj[smtp_host]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("smtp_host"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[smtp_port]">smtp_port</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[smtp_port]" name="obj[smtp_port]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("smtp_port"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[smtp_auth]">smtp_auth</label>
					</div>
					<div class="col-sm-5">
						<?php
						$checked1 = "";
						$checked0 = "";
						if($obj->get("smtp_auth") === true){
							$checked1 = " CHECKED";
							$checked0 = "";
						}elseif($obj->get("smtp_auth") === false){
							$checked1 = "";
							$checked0 = " CHECKED";
						}
						?>
						<label class="radio-inline" for="obj[smtp_auth]-1">
							<input type="radio" name="obj[smtp_auth]" id="obj[smtp_auth]-1" value="true"<?=$checked1?>>
							Sim
						</label>
						<label class="radio-inline" for="obj[smtp_auth]-0">
							<input type="radio" name="obj[smtp_auth]" id="obj[smtp_auth]-0" value="false"<?=$checked0?>>
							Não
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[smtp_secure]">smtp_secure</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[smtp_secure]" name="obj[smtp_secure]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("smtp_secure"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[pop_host]">pop_host</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[pop_host]" name="obj[pop_host]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("pop_host"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[pop_port]">pop_port</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[pop_port]" name="obj[pop_port]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("pop_port"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[pop_secure]">pop_secure</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[pop_secure]" name="obj[pop_secure]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("pop_secure"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[status]">status</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[status]" name="obj[status]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("status"))?>" required>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" class="btn btn-outline-primary" id="register-button">Salvar</button>
				<?}?>
				<?if(in_array($action,array("edit"))){?>
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/<?=$keyString?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/mail/Server/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>