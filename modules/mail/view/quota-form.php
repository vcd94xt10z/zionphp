<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("mandt","user","server","date","hour"));
$t = Text::getEntityTexts("mail","Quota");
?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/mail/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/mail/Quota/list">Consulta de <?=$t->entity()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de <?=$t->entity()?></li>
		</ol>
	</nav>
	<h3>Formulário de <?=$t->entity()?></h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/mail/Quota/" method="<?=$method?>" data-callback="defaultRegisterCallback">
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
						<label class="pk required control-label" for="obj[user]" alt="<?=$t->tip("user")?>" title="<?=$t->tip("user")?>">
							<?=$t->field("user")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[user]" name="obj[user]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("user"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[server]" alt="<?=$t->tip("server")?>" title="<?=$t->tip("server")?>">
							<?=$t->field("server")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[server]" name="obj[server]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("server"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[date]" alt="<?=$t->tip("date")?>" title="<?=$t->tip("date")?>">
							<?=$t->field("date")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[date]" name="obj[date]" type="text" class="form-control type-date" value="<?=TextFormatter::format("date",$obj->get("date"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk control-label" for="obj[hour]" alt="<?=$t->tip("hour")?>" title="<?=$t->tip("hour")?>">
							<?=$t->field("hour")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[hour]" name="obj[hour]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("hour"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[total]" alt="<?=$t->tip("total")?>" title="<?=$t->tip("total")?>">
							<?=$t->field("total")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[total]" name="obj[total]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("total"))?>" required>
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
			</div>
			<div class="card-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" class="btn btn-outline-primary" id="register-button">Salvar</button>
				<?}?>
				<?if(in_array($action,array("edit"))){?>
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/mail/Quota/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/mail/Quota/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>