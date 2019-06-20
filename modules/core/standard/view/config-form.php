<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("mandt","env","key","name"));
$t = Text::getEntityTexts("core","Config");
?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/core/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/core/Config/list">Consulta de <?=$t->entity()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de <?=$t->entity()?></li>
		</ol>
	</nav>
	<h3>Formulário de <?=$t->entity()?></h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/core/Config/" method="<?=$method?>" data-callback="defaultRegisterCallback" data-accept="text/plain">
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
						<label class="pk required control-label" for="obj[env]" alt="<?=$t->tip("env")?>" title="<?=$t->tip("env")?>">
							<?=$t->field("env")?>
						</label>
					</div>
					<div class="col-sm-5">
						<select id="obj[env]" name="obj[env]" class="form-control type-string" required>
							<option></option>
							<?
							$list = System::get("tabval","env");
							$list = (is_array($list)?$list:array());
							?>
							<?foreach($list AS $item){
								$SELECTED = "";
								if($item->get("key") == $obj->get("env")){
									$SELECTED = " SELECTED";
								}
								?>
							<option value="<?=$item->get("key")?>"<?=$SELECTED?>><?=$item->get("value")?></option>
							<?}?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[key]" alt="<?=$t->tip("key")?>" title="<?=$t->tip("key")?>">
							<?=$t->field("key")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[key]" name="obj[key]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("key"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[name]" alt="<?=$t->tip("name")?>" title="<?=$t->tip("name")?>">
							<?=$t->field("name")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[name]" name="obj[name]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("name"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[value]" alt="<?=$t->tip("value")?>" title="<?=$t->tip("value")?>">
							<?=$t->field("value")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[value]" name="obj[value]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("value"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[created]" alt="<?=$t->tip("created")?>" title="<?=$t->tip("created")?>">
							<?=$t->field("created")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[created]" name="obj[created]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("created"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[updated]" alt="<?=$t->tip("updated")?>" title="<?=$t->tip("updated")?>">
							<?=$t->field("updated")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[updated]" name="obj[updated]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("updated"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[sequence]" alt="<?=$t->tip("sequence")?>" title="<?=$t->tip("sequence")?>">
							<?=$t->field("sequence")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[sequence]" name="obj[sequence]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("sequence"))?>">
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" class="btn btn-outline-primary" id="register-button">Salvar</button>
				<?}?>
				<?if(in_array($action,array("edit"))){?>
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/core/Config/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/core/Config/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>