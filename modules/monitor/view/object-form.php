<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("objectid"));
$t = Text::getEntityTexts("monitor","Object");
?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/monitor/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/monitor/Object/list">Consulta de <?=$t->entity()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de <?=$t->entity()?></li>
		</ol>
	</nav>
	<h3>Formulário de <?=$t->entity()?></h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/monitor/Object/" method="<?=$method?>" data-callback="defaultRegisterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Formulário
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[objectid]" alt="<?=$t->tip("objectid")?>" title="<?=$t->tip("objectid")?>">
							<?=$t->field("objectid")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[objectid]" name="obj[objectid]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("objectid"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[name]" alt="<?=$t->tip("name")?>" title="<?=$t->tip("name")?>">
							<?=$t->field("name")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[name]" name="obj[name]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("name"))?>" required>
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
						<label class="required control-label" for="obj[type]" alt="<?=$t->tip("type")?>" title="<?=$t->tip("type")?>">
							<?=$t->field("type")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[type]" name="obj[type]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("type"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[url]" alt="<?=$t->tip("url")?>" title="<?=$t->tip("url")?>">
							<?=$t->field("url")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[url]" name="obj[url]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("url"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[interval]" alt="<?=$t->tip("interval")?>" title="<?=$t->tip("interval")?>">
							<?=$t->field("interval")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[interval]" name="obj[interval]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("interval"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[status]" alt="<?=$t->tip("status")?>" title="<?=$t->tip("status")?>">
							<?=$t->field("status")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[status]" name="obj[status]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("status"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[last_check]" alt="<?=$t->tip("last_check")?>" title="<?=$t->tip("last_check")?>">
							<?=$t->field("last_check")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[last_check]" name="obj[last_check]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("last_check"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[notify_by_email]" alt="<?=$t->tip("notify_by_email")?>" title="<?=$t->tip("notify_by_email")?>">
							<?=$t->field("notify_by_email")?>
						</label>
					</div>
					<div class="col-sm-5">
						<?php
						$checked1 = "";
						$checked0 = "";
						if($obj->get("notify_by_email") === true){
							$checked1 = " CHECKED";
							$checked0 = "";
						}elseif($obj->get("notify_by_email") === false){
							$checked1 = "";
							$checked0 = " CHECKED";
						}
						?>
						<label class="radio-inline" for="obj[notify_by_email]-1">
							<input type="radio" name="obj[notify_by_email]" id="obj[notify_by_email]-1" value="true"<?=$checked1?>>
							Sim
						</label>
						<label class="radio-inline" for="obj[notify_by_email]-0">
							<input type="radio" name="obj[notify_by_email]" id="obj[notify_by_email]-0" value="false"<?=$checked0?>>
							Não
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[notify_by_sms]" alt="<?=$t->tip("notify_by_sms")?>" title="<?=$t->tip("notify_by_sms")?>">
							<?=$t->field("notify_by_sms")?>
						</label>
					</div>
					<div class="col-sm-5">
						<?php
						$checked1 = "";
						$checked0 = "";
						if($obj->get("notify_by_sms") === true){
							$checked1 = " CHECKED";
							$checked0 = "";
						}elseif($obj->get("notify_by_sms") === false){
							$checked1 = "";
							$checked0 = " CHECKED";
						}
						?>
						<label class="radio-inline" for="obj[notify_by_sms]-1">
							<input type="radio" name="obj[notify_by_sms]" id="obj[notify_by_sms]-1" value="true"<?=$checked1?>>
							Sim
						</label>
						<label class="radio-inline" for="obj[notify_by_sms]-0">
							<input type="radio" name="obj[notify_by_sms]" id="obj[notify_by_sms]-0" value="false"<?=$checked0?>>
							Não
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[notify_by_tts]" alt="<?=$t->tip("notify_by_tts")?>" title="<?=$t->tip("notify_by_tts")?>">
							<?=$t->field("notify_by_tts")?>
						</label>
					</div>
					<div class="col-sm-5">
						<?php
						$checked1 = "";
						$checked0 = "";
						if($obj->get("notify_by_tts") === true){
							$checked1 = " CHECKED";
							$checked0 = "";
						}elseif($obj->get("notify_by_tts") === false){
							$checked1 = "";
							$checked0 = " CHECKED";
						}
						?>
						<label class="radio-inline" for="obj[notify_by_tts]-1">
							<input type="radio" name="obj[notify_by_tts]" id="obj[notify_by_tts]-1" value="true"<?=$checked1?>>
							Sim
						</label>
						<label class="radio-inline" for="obj[notify_by_tts]-0">
							<input type="radio" name="obj[notify_by_tts]" id="obj[notify_by_tts]-0" value="false"<?=$checked0?>>
							Não
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[notify_email]" alt="<?=$t->tip("notify_email")?>" title="<?=$t->tip("notify_email")?>">
							<?=$t->field("notify_email")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[notify_email]" name="obj[notify_email]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("notify_email"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[notify_phone]" alt="<?=$t->tip("notify_phone")?>" title="<?=$t->tip("notify_phone")?>">
							<?=$t->field("notify_phone")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[notify_phone]" name="obj[notify_phone]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("notify_phone"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[sound_enabled]" alt="<?=$t->tip("sound_enabled")?>" title="<?=$t->tip("sound_enabled")?>">
							<?=$t->field("sound_enabled")?>
						</label>
					</div>
					<div class="col-sm-5">
						<?php
						$checked1 = "";
						$checked0 = "";
						if($obj->get("sound_enabled") === true){
							$checked1 = " CHECKED";
							$checked0 = "";
						}elseif($obj->get("sound_enabled") === false){
							$checked1 = "";
							$checked0 = " CHECKED";
						}
						?>
						<label class="radio-inline" for="obj[sound_enabled]-1">
							<input type="radio" name="obj[sound_enabled]" id="obj[sound_enabled]-1" value="true"<?=$checked1?>>
							Sim
						</label>
						<label class="radio-inline" for="obj[sound_enabled]-0">
							<input type="radio" name="obj[sound_enabled]" id="obj[sound_enabled]-0" value="false"<?=$checked0?>>
							Não
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[enabled]" alt="<?=$t->tip("enabled")?>" title="<?=$t->tip("enabled")?>">
							<?=$t->field("enabled")?>
						</label>
					</div>
					<div class="col-sm-5">
						<?php
						$checked1 = "";
						$checked0 = "";
						if($obj->get("enabled") === true){
							$checked1 = " CHECKED";
							$checked0 = "";
						}elseif($obj->get("enabled") === false){
							$checked1 = "";
							$checked0 = " CHECKED";
						}
						?>
						<label class="radio-inline" for="obj[enabled]-1">
							<input type="radio" name="obj[enabled]" id="obj[enabled]-1" value="true"<?=$checked1?>>
							Sim
						</label>
						<label class="radio-inline" for="obj[enabled]-0">
							<input type="radio" name="obj[enabled]" id="obj[enabled]-0" value="false"<?=$checked0?>>
							Não
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[counter_success]" alt="<?=$t->tip("counter_success")?>" title="<?=$t->tip("counter_success")?>">
							<?=$t->field("counter_success")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[counter_success]" name="obj[counter_success]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("counter_success"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[counter_error]" alt="<?=$t->tip("counter_error")?>" title="<?=$t->tip("counter_error")?>">
							<?=$t->field("counter_error")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[counter_error]" name="obj[counter_error]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("counter_error"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[counter_timeout]" alt="<?=$t->tip("counter_timeout")?>" title="<?=$t->tip("counter_timeout")?>">
							<?=$t->field("counter_timeout")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[counter_timeout]" name="obj[counter_timeout]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("counter_timeout"))?>">
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" class="btn btn-outline-primary" id="register-button">Salvar</button>
				<?}?>
				<?if(in_array($action,array("edit"))){?>
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/monitor/Object/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/monitor/Object/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>