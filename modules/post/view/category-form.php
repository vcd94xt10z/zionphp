<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("mandt","categoryid"));
$t = Text::getEntityTexts("post","Category");
?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/post/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/post/Category/list">Consulta de <?=$t->entity()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de <?=$t->entity()?></li>
		</ol>
	</nav>
	<h3>Formulário de <?=$t->entity()?></h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/post/Category/" method="<?=$method?>" data-callback="defaultRegisterCallback" data-accept="text/plain">
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
						<label class="pk control-label" for="obj[categoryid]" alt="<?=$t->tip("categoryid")?>" title="<?=$t->tip("categoryid")?>">
							<?=$t->field("categoryid")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[categoryid]" name="obj[categoryid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("categoryid"))?>">
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
						<label class="control-label" for="obj[updated_at]" alt="<?=$t->tip("updated_at")?>" title="<?=$t->tip("updated_at")?>">
							<?=$t->field("updated_at")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[updated_at]" name="obj[updated_at]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("updated_at"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[status]" alt="<?=$t->tip("status")?>" title="<?=$t->tip("status")?>">
							<?=$t->field("status")?>
						</label>
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
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/post/Category/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/post/Category/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>