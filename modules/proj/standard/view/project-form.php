<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("mandt","projid"));
$t = Text::getEntityTexts("proj","Project");
?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/proj/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/proj/Project/list">Consulta de <?=$t->entity()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de <?=$t->entity()?></li>
		</ol>
	</nav>
	<h3>Formulário de <?=$t->entity()?></h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/proj/Project/" method="<?=$method?>" data-callback="defaultRegisterCallback" data-accept="text/plain">
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
						<label class="required control-label" for="obj[name]" alt="<?=$t->tip("name")?>" title="<?=$t->tip("name")?>">
							<?=$t->field("name")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[name]" name="obj[name]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("name"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[description]" alt="<?=$t->tip("description")?>" title="<?=$t->tip("description")?>">
							<?=$t->field("description")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[description]" name="obj[description]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("description"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[url]" alt="<?=$t->tip("url")?>" title="<?=$t->tip("url")?>">
							<?=$t->field("url")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[url]" name="obj[url]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("url"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[created_at]" alt="<?=$t->tip("created_at")?>" title="<?=$t->tip("created_at")?>">
							<?=$t->field("created_at")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[created_at]" name="obj[created_at]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("created_at"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[created_by]" alt="<?=$t->tip("created_by")?>" title="<?=$t->tip("created_by")?>">
							<?=$t->field("created_by")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[created_by]" name="obj[created_by]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("created_by"))?>" required>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" class="btn btn-outline-primary" id="register-button">Salvar</button>
				<?}?>
				<?if(in_array($action,array("edit"))){?>
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/proj/Project/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/proj/Project/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>