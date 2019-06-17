<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("mandt","projid","featid"));
$t = Text::getEntityTexts("proj","Test");
?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/proj/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/proj/Test/list">Consulta de <?=$t->entity()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de <?=$t->entity()?></li>
		</ol>
	</nav>
	<h3>Formulário de <?=$t->entity()?></h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/proj/Test/" method="<?=$method?>" data-callback="defaultRegisterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Formulário
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-3">
						<label class="pk control-label" for="obj[mandt]" alt="<?=$t->tip("mandt")?>" title="<?=$t->tip("mandt")?>">
							<?=$t->field("mandt")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[mandt]" name="obj[mandt]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("mandt"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk control-label" for="obj[projid]" alt="<?=$t->tip("projid")?>" title="<?=$t->tip("projid")?>">
							<?=$t->field("projid")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[projid]" name="obj[projid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("projid"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk control-label" for="obj[featid]" alt="<?=$t->tip("featid")?>" title="<?=$t->tip("featid")?>">
							<?=$t->field("featid")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[featid]" name="obj[featid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("featid"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[version]" alt="<?=$t->tip("version")?>" title="<?=$t->tip("version")?>">
							<?=$t->field("version")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[version]" name="obj[version]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("version"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[testid]" alt="<?=$t->tip("testid")?>" title="<?=$t->tip("testid")?>">
							<?=$t->field("testid")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[testid]" name="obj[testid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("testid"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[test_at]" alt="<?=$t->tip("test_at")?>" title="<?=$t->tip("test_at")?>">
							<?=$t->field("test_at")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[test_at]" name="obj[test_at]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("test_at"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[test_by]" alt="<?=$t->tip("test_by")?>" title="<?=$t->tip("test_by")?>">
							<?=$t->field("test_by")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[test_by]" name="obj[test_by]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("test_by"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[result]" alt="<?=$t->tip("result")?>" title="<?=$t->tip("result")?>">
							<?=$t->field("result")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[result]" name="obj[result]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("result"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[device]" alt="<?=$t->tip("device")?>" title="<?=$t->tip("device")?>">
							<?=$t->field("device")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[device]" name="obj[device]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("device"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[browser]" alt="<?=$t->tip("browser")?>" title="<?=$t->tip("browser")?>">
							<?=$t->field("browser")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[browser]" name="obj[browser]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("browser"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[note]" alt="<?=$t->tip("note")?>" title="<?=$t->tip("note")?>">
							<?=$t->field("note")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[note]" name="obj[note]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("note"))?>">
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" class="btn btn-outline-primary" id="register-button">Salvar</button>
				<?}?>
				<?if(in_array($action,array("edit"))){?>
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/proj/Test/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/proj/Test/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>