<?php
use zion\core\System;
use zion\utils\TextFormatter;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
?>
<div class="center-content form-page">
<div class="container-fluid">

<br>
<h3>Formulário de MailQuota</h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/mail/MailQuota/" method="<?=$method?>" data-callback="defaultRegisterCallback">
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
						<label class="pk required control-label" for="obj[user]">user</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[user]" name="obj[user]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("user"))?>" required>
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
						<label class="pk required control-label" for="obj[date]">date</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[date]" name="obj[date]" type="text" class="form-control type-date" value="<?=TextFormatter::format("date",$obj->get("date"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[hour]">hour</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[hour]" name="obj[hour]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("hour"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[total]">total</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[total]" name="obj[total]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("total"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[updated_at]">updated_at</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[updated_at]" name="obj[updated_at]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("updated_at"))?>" required>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" class="btn btn-outline-primary" id="register-button">Salvar</button>
				<?}?>
				<?if(in_array($action,array("edit"))){?>
				<button type="button" class="btn btn-outline-danger button-delete">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/mail/MailQuota/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>