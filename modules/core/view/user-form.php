<?php
use zion\core\System;
use zion\utils\TextFormatter;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("mandt","userid"));?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/core/">core</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/list">Consulta de User</a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de User</li>
		</ol>
	</nav>
<h3>Formulário de User</h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/core/User/" method="<?=$method?>" data-callback="defaultRegisterCallback">
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
						<label class="pk control-label" for="obj[userid]">userid</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[userid]" name="obj[userid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("userid"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[login]">login</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[login]" name="obj[login]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("login"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[password]">password</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[password]" name="obj[password]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("password"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[perfil]">perfil</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[perfil]" name="obj[perfil]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("perfil"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[force_new_password]">force_new_password</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[force_new_password]" name="obj[force_new_password]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("force_new_password"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[redefine_password_hash]">redefine_password_hash</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[redefine_password_hash]" name="obj[redefine_password_hash]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("redefine_password_hash"))?>">
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
						<label class="control-label" for="obj[email]">email</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[email]" name="obj[email]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("email"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[phone]">phone</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[phone]" name="obj[phone]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("phone"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[docf]">docf</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[docf]" name="obj[docf]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("docf"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[doce]">doce</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[doce]" name="obj[doce]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("doce"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[docm]">docm</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[docm]" name="obj[docm]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("docm"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[validity_begin]">validity_begin</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[validity_begin]" name="obj[validity_begin]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("validity_begin"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[validity_end]">validity_end</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[validity_end]" name="obj[validity_end]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("validity_end"))?>">
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
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/core/User/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/core/User/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>