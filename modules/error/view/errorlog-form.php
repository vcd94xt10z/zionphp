<?php
use zion\core\System;
use zion\utils\TextFormatter;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
?>
<div class="center-content form-page">
<div class="container-fluid">

	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/error/ErrorLog/" method="<?=$method?>" data-callback="defaultRegisterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Formulário
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[errorid]">errorid</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[errorid]" name="obj[errorid]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("errorid"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[type]">type</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[type]" name="obj[type]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("type"))?>" required>
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
						<label class="required control-label" for="obj[duration]">duration</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[duration]" name="obj[duration]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("duration"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[http_ipaddr]">http_ipaddr</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[http_ipaddr]" name="obj[http_ipaddr]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("http_ipaddr"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[http_method]">http_method</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[http_method]" name="obj[http_method]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("http_method"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[http_uri]">http_uri</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[http_uri]" name="obj[http_uri]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("http_uri"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[level]">level</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[level]" name="obj[level]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("level"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[code]">code</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[code]" name="obj[code]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("code"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[message]">message</label>
					</div>
					<div class="col-sm-5">
						<textarea id="obj[message]" name="obj[message]" class="form-control type-string"><?=TextFormatter::format("string",$obj->get("message"))?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[stack]">stack</label>
					</div>
					<div class="col-sm-5">
						<textarea id="obj[stack]" name="obj[stack]" class="form-control type-string"><?=TextFormatter::format("string",$obj->get("stack"))?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[input]">input</label>
					</div>
					<div class="col-sm-5">
						<textarea id="obj[input]" name="obj[input]" class="form-control type-string"><?=TextFormatter::format("string",$obj->get("input"))?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[file]">file</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[file]" name="obj[file]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("file"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[line]">line</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[line]" name="obj[line]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("line"))?>">
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
				<button type="button" class="btn btn-outline-danger button-delete">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/error/ErrorLog/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>