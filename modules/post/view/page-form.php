<?php
use zion\core\System;
use zion\utils\TextFormatter;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("mandt","pageid"));?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/post/">post</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/post/Page/list">Consulta de Page</a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de Page</li>
		</ol>
	</nav>
<h3>Formulário de Page</h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/post/Page/" method="<?=$method?>" data-callback="defaultRegisterCallback">
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
						<label class="pk control-label" for="obj[pageid]">pageid</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[pageid]" name="obj[pageid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("pageid"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[rewrite]">rewrite</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[rewrite]" name="obj[rewrite]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("rewrite"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[title]">title</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[title]" name="obj[title]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("title"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[categoryid]">categoryid</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[categoryid]" name="obj[categoryid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("categoryid"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[content_html]">content_html</label>
					</div>
					<div class="col-sm-5">
						<textarea id="obj[content_html]" name="obj[content_html]" class="form-control type-string" required><?=TextFormatter::format("string",$obj->get("content_html"))?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[created_at]">created_at</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[created_at]" name="obj[created_at]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("created_at"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[created_by]">created_by</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[created_by]" name="obj[created_by]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("created_by"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[updated_at]">updated_at</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[updated_at]" name="obj[updated_at]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("updated_at"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[updated_by]">updated_by</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[updated_by]" name="obj[updated_by]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("updated_by"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[meta_description]">meta_description</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[meta_description]" name="obj[meta_description]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("meta_description"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[meta_keywords]">meta_keywords</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[meta_keywords]" name="obj[meta_keywords]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("meta_keywords"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[status]">status</label>
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
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/post/Page/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/post/Page/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>