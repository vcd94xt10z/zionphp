<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("mandt","logid"));
$t = Text::getEntityTexts("mail","SendLog");
?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/mail/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/mail/SendLog/list">Consulta de <?=$t->entity()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de <?=$t->entity()?></li>
		</ol>
	</nav>
	<h3>Formulário de <?=$t->entity()?></h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/mail/SendLog/" method="<?=$method?>" data-callback="defaultRegisterCallback" data-accept="text/plain">
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
						<label class="pk required control-label" for="obj[logid]" alt="<?=$t->tip("logid")?>" title="<?=$t->tip("logid")?>">
							<?=$t->field("logid")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[logid]" name="obj[logid]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("logid"))?>" required>
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
						<label class="required control-label" for="obj[server]" alt="<?=$t->tip("server")?>" title="<?=$t->tip("server")?>">
							<?=$t->field("server")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[server]" name="obj[server]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("server"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[user]" alt="<?=$t->tip("user")?>" title="<?=$t->tip("user")?>">
							<?=$t->field("user")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[user]" name="obj[user]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("user"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[from]" alt="<?=$t->tip("from")?>" title="<?=$t->tip("from")?>">
							<?=$t->field("from")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[from]" name="obj[from]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("from"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[to]" alt="<?=$t->tip("to")?>" title="<?=$t->tip("to")?>">
							<?=$t->field("to")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[to]" name="obj[to]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("to"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[subject]" alt="<?=$t->tip("subject")?>" title="<?=$t->tip("subject")?>">
							<?=$t->field("subject")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[subject]" name="obj[subject]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("subject"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[content_type]" alt="<?=$t->tip("content_type")?>" title="<?=$t->tip("content_type")?>">
							<?=$t->field("content_type")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[content_type]" name="obj[content_type]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("content_type"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[content_body_size]" alt="<?=$t->tip("content_body_size")?>" title="<?=$t->tip("content_body_size")?>">
							<?=$t->field("content_body_size")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[content_body_size]" name="obj[content_body_size]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("content_body_size"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[attachment_count]" alt="<?=$t->tip("attachment_count")?>" title="<?=$t->tip("attachment_count")?>">
							<?=$t->field("attachment_count")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[attachment_count]" name="obj[attachment_count]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("attachment_count"))?>">
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
						<label class="control-label" for="obj[result_message]" alt="<?=$t->tip("result_message")?>" title="<?=$t->tip("result_message")?>">
							<?=$t->field("result_message")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[result_message]" name="obj[result_message]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("result_message"))?>">
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" class="btn btn-outline-primary" id="register-button">Salvar</button>
				<?}?>
				<?if(in_array($action,array("edit"))){?>
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/mail/SendLog/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/mail/SendLog/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>