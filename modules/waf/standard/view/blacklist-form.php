<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("ipaddr"));
$t = Text::getEntityTexts("waf","BlackList");
?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/waf/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/waf/BlackList/list">Consulta de <?=$t->entity()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de <?=$t->entity()?></li>
		</ol>
	</nav>
	<h3>Formulário de <?=$t->entity()?></h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/waf/BlackList/" method="<?=$method?>" data-callback="defaultRegisterCallback" data-accept="text/plain">
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
						<label class="control-label" for="obj[created]" alt="<?=$t->tip("created")?>" title="<?=$t->tip("created")?>">
							<?=$t->field("created")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[created]" name="obj[created]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("created"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[user_agent]" alt="<?=$t->tip("user_agent")?>" title="<?=$t->tip("user_agent")?>">
							<?=$t->field("user_agent")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[user_agent]" name="obj[user_agent]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("user_agent"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[request_uri]" alt="<?=$t->tip("request_uri")?>" title="<?=$t->tip("request_uri")?>">
							<?=$t->field("request_uri")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[request_uri]" name="obj[request_uri]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("request_uri"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[server_name]" alt="<?=$t->tip("server_name")?>" title="<?=$t->tip("server_name")?>">
							<?=$t->field("server_name")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[server_name]" name="obj[server_name]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("server_name"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[hits]" alt="<?=$t->tip("hits")?>" title="<?=$t->tip("hits")?>">
							<?=$t->field("hits")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[hits]" name="obj[hits]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("hits"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[policy]" alt="<?=$t->tip("policy")?>" title="<?=$t->tip("policy")?>">
							<?=$t->field("policy")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[policy]" name="obj[policy]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("policy"))?>">
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
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/waf/BlackList/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/waf/BlackList/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>