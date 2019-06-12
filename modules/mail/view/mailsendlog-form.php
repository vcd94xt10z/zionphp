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
<h3>Formulário de MailSendLog</h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/mail/MailSendLog/" method="<?=$method?>" data-callback="defaultRegisterCallback">
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
						<label class="pk required control-label" for="obj[logid]">logid</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[logid]" name="obj[logid]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("logid"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[created]">created</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[created]" name="obj[created]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("created"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[server]">server</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[server]" name="obj[server]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("server"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[user]">user</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[user]" name="obj[user]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("user"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[from]">from</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[from]" name="obj[from]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("from"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[to]">to</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[to]" name="obj[to]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("to"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[subject]">subject</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[subject]" name="obj[subject]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("subject"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[content_type]">content_type</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[content_type]" name="obj[content_type]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("content_type"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[content_body_size]">content_body_size</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[content_body_size]" name="obj[content_body_size]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("content_body_size"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[attachment_count]">attachment_count</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[attachment_count]" name="obj[attachment_count]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("attachment_count"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[result]">result</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[result]" name="obj[result]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("result"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[result_message]">result_message</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[result_message]" name="obj[result_message]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("result_message"))?>">
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
				<a class="btn btn-outline-info button-new" href="/zion/mod/mail/MailSendLog/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>