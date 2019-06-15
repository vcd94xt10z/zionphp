<?php
use zion\core\System;
use zion\utils\TextFormatter;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("mandt","lang","moduleid","entityid","field"));?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/builder/">builder</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/builder/Text/list">Consulta de Text</a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de Text</li>
		</ol>
	</nav>
<h3>Formulário de Text</h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/builder/Text/" method="<?=$method?>" data-callback="defaultRegisterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Formulário
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-3">
						<label class="pk control-label" for="obj[mandt]">mandt</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[mandt]" name="obj[mandt]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("mandt"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[lang]">lang</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[lang]" name="obj[lang]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("lang"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[moduleid]">moduleid</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[moduleid]" name="obj[moduleid]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("moduleid"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[entityid]">entityid</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[entityid]" name="obj[entityid]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("entityid"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[field]">field</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[field]" name="obj[field]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("field"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[text]">text</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[text]" name="obj[text]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("text"))?>" required>
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