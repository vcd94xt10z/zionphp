<?php
use zion\core\System;
use zion\utils\TextFormatter;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
?>
<div class="center-content form-page">
<div class="container-fluid">

	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/proj/Test/" method="<?=$method?>" data-callback="defaultRegisterCallback">
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
						<label class="pk required control-label" for="obj[projid]">projid</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[projid]" name="obj[projid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("projid"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[featid]">featid</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[featid]" name="obj[featid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("featid"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[version]">version</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[version]" name="obj[version]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("version"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[testid]">testid</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[testid]" name="obj[testid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("testid"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[test_at]">test_at</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[test_at]" name="obj[test_at]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("test_at"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[test_by]">test_by</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[test_by]" name="obj[test_by]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("test_by"))?>" required>
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
						<label class="control-label" for="obj[device]">device</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[device]" name="obj[device]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("device"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[browser]">browser</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[browser]" name="obj[browser]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("browser"))?>">
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
				<a class="btn btn-outline-info button-new" href="/zion/mod/proj/Test/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>