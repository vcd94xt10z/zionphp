<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("ipaddr"));
$t = Text::getEntityTexts("waf","IpLocation");
?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/waf/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/waf/IpLocation/list">Consulta de <?=$t->entity()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de <?=$t->entity()?></li>
		</ol>
	</nav>
	<h3>Formulário de <?=$t->entity()?></h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/waf/IpLocation/" method="<?=$method?>" data-callback="defaultRegisterCallback" data-accept="text/plain">
		<br>
		<div class="card">
			<div class="card-header">
				Formulário
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[ipaddr]" alt="<?=$t->tip("ipaddr")?>" title="<?=$t->tip("ipaddr")?>">
							<?=$t->field("ipaddr")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[ipaddr]" name="obj[ipaddr]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("ipaddr"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[type]" alt="<?=$t->tip("type")?>" title="<?=$t->tip("type")?>">
							<?=$t->field("type")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[type]" name="obj[type]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("type"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[continent_code]" alt="<?=$t->tip("continent_code")?>" title="<?=$t->tip("continent_code")?>">
							<?=$t->field("continent_code")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[continent_code]" name="obj[continent_code]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("continent_code"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[continent_name]" alt="<?=$t->tip("continent_name")?>" title="<?=$t->tip("continent_name")?>">
							<?=$t->field("continent_name")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[continent_name]" name="obj[continent_name]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("continent_name"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[country_code]" alt="<?=$t->tip("country_code")?>" title="<?=$t->tip("country_code")?>">
							<?=$t->field("country_code")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[country_code]" name="obj[country_code]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("country_code"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[country_name]" alt="<?=$t->tip("country_name")?>" title="<?=$t->tip("country_name")?>">
							<?=$t->field("country_name")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[country_name]" name="obj[country_name]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("country_name"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[region_code]" alt="<?=$t->tip("region_code")?>" title="<?=$t->tip("region_code")?>">
							<?=$t->field("region_code")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[region_code]" name="obj[region_code]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("region_code"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[region_name]" alt="<?=$t->tip("region_name")?>" title="<?=$t->tip("region_name")?>">
							<?=$t->field("region_name")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[region_name]" name="obj[region_name]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("region_name"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[city]" alt="<?=$t->tip("city")?>" title="<?=$t->tip("city")?>">
							<?=$t->field("city")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[city]" name="obj[city]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("city"))?>">
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
			</div>
			<div class="card-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" class="btn btn-outline-primary" id="register-button">Salvar</button>
				<?}?>
				<?if(in_array($action,array("edit"))){?>
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/waf/IpLocation/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/waf/IpLocation/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>