<?php
use zion\core\System;
use zion\utils\TextFormatter;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("mandt","projid","featid"));?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/proj/">proj</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/proj/Feature/list">Consulta de Feature</a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de Feature</li>
		</ol>
	</nav>
<h3>Formulário de Feature</h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/proj/Feature/" method="<?=$method?>" data-callback="defaultRegisterCallback">
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
						<label class="pk control-label" for="obj[projid]">projid</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[projid]" name="obj[projid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("projid"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="pk control-label" for="obj[featid]">featid</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[featid]" name="obj[featid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("featid"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[sequence]">sequence</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[sequence]" name="obj[sequence]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("sequence"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[name]">name</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[name]" name="obj[name]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("name"))?>" required>
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
						<label class="control-label" for="obj[created_by]">created_by</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[created_by]" name="obj[created_by]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("created_by"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[main_developer]">main_developer</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[main_developer]" name="obj[main_developer]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("main_developer"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[status]">status</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[status]" name="obj[status]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("status"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[released_to_test]">released_to_test</label>
					</div>
					<div class="col-sm-5">
						<?php
						$checked1 = "";
						$checked0 = "";
						if($obj->get("released_to_test") === true){
							$checked1 = " CHECKED";
							$checked0 = "";
						}elseif($obj->get("released_to_test") === false){
							$checked1 = "";
							$checked0 = " CHECKED";
						}
						?>
						<label class="radio-inline" for="obj[released_to_test]-1">
							<input type="radio" name="obj[released_to_test]" id="obj[released_to_test]-1" value="true"<?=$checked1?>>
							Sim
						</label>
						<label class="radio-inline" for="obj[released_to_test]-0">
							<input type="radio" name="obj[released_to_test]" id="obj[released_to_test]-0" value="false"<?=$checked0?>>
							Não
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[complexity]">complexity</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[complexity]" name="obj[complexity]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("complexity"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[version]">version</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[version]" name="obj[version]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("version"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[estimated_time]">estimated_time</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[estimated_time]" name="obj[estimated_time]" type="text" class="form-control type-double" value="<?=TextFormatter::format("double",$obj->get("estimated_time"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[url]">url</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[url]" name="obj[url]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("url"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[note]">note</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[note]" name="obj[note]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("note"))?>">
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" class="btn btn-outline-primary" id="register-button">Salvar</button>
				<?}?>
				<?if(in_array($action,array("edit"))){?>
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/proj/Feature/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/proj/Feature/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>