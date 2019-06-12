<?php
use zion\core\System;
use zion\utils\TextFormatter;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$key = array("objectid");
$keyString = $obj->concat($key,":");
?>
<div class="center-content form-page">
<div class="container-fluid">

<br>
<h3>Formulário de Object</h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/monitor/Object/" method="<?=$method?>" data-callback="defaultRegisterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Formulário
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[objectid]">objectid</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[objectid]" name="obj[objectid]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("objectid"))?>" required>
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
						<label class="required control-label" for="obj[created]">created</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[created]" name="obj[created]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("created"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[type]">type</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[type]" name="obj[type]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("type"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[url]">url</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[url]" name="obj[url]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("url"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[interval]">interval</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[interval]" name="obj[interval]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("interval"))?>" required>
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
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[last_check]">last_check</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[last_check]" name="obj[last_check]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("last_check"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[notify_by_email]">notify_by_email</label>
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
						<label class="control-label" for="obj[notify_by_sms]">notify_by_sms</label>
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
						<label class="control-label" for="obj[notify_by_tts]">notify_by_tts</label>
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
						<label class="control-label" for="obj[notify_email]">notify_email</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[notify_email]" name="obj[notify_email]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("notify_email"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[notify_phone]">notify_phone</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[notify_phone]" name="obj[notify_phone]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("notify_phone"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[sound_enabled]">sound_enabled</label>
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
						<label class="control-label" for="obj[enabled]">enabled</label>
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
						<label class="control-label" for="obj[counter_success]">counter_success</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[counter_success]" name="obj[counter_success]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("counter_success"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[counter_error]">counter_error</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[counter_error]" name="obj[counter_error]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("counter_error"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[counter_timeout]">counter_timeout</label>
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
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/monitor/Object/<?=$keyString?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/monitor/Object/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>