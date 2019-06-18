<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("mandt","lang","moduleid","entityid","field"));
$t = Text::getEntityTexts("builder","Text");
?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/builder/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/builder/Text/list">Consulta de <?=$t->entity()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de <?=$t->entity()?></li>
		</ol>
	</nav>
	<h3>Formulário de <?=$t->entity()?></h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/builder/Text/" method="<?=$method?>" data-callback="defaultRegisterCallback" data-accept="text/plain">
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
						<label class="pk required control-label" for="obj[lang]" alt="<?=$t->tip("lang")?>" title="<?=$t->tip("lang")?>">
							<?=$t->field("lang")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[lang]" name="obj[lang]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("lang"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[moduleid]" alt="<?=$t->tip("moduleid")?>" title="<?=$t->tip("moduleid")?>">
							<?=$t->field("moduleid")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[moduleid]" name="obj[moduleid]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("moduleid"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[entityid]" alt="<?=$t->tip("entityid")?>" title="<?=$t->tip("entityid")?>">
							<?=$t->field("entityid")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[entityid]" name="obj[entityid]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("entityid"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[field]" alt="<?=$t->tip("field")?>" title="<?=$t->tip("field")?>">
							<?=$t->field("field")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[field]" name="obj[field]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("field"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[short_text]" alt="<?=$t->tip("short_text")?>" title="<?=$t->tip("short_text")?>">
							<?=$t->field("short_text")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[short_text]" name="obj[short_text]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("short_text"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[medium_text]" alt="<?=$t->tip("medium_text")?>" title="<?=$t->tip("medium_text")?>">
							<?=$t->field("medium_text")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[medium_text]" name="obj[medium_text]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("medium_text"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[full_text]" alt="<?=$t->tip("full_text")?>" title="<?=$t->tip("full_text")?>">
							<?=$t->field("full_text")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[full_text]" name="obj[full_text]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("full_text"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[tip]" alt="<?=$t->tip("tip")?>" title="<?=$t->tip("tip")?>">
							<?=$t->field("tip")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[tip]" name="obj[tip]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("tip"))?>">
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" class="btn btn-outline-primary" id="register-button">Salvar</button>
				<?}?>
				<?if(in_array($action,array("edit"))){?>
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/builder/Text/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/builder/Text/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>