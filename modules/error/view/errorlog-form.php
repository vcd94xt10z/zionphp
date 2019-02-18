<?php
use zion\core\System;
use zion\utils\TextFormatter;
$obj = System::get("obj");
$action = System::get("action");
?>
<div class="body-content-limit container-fluid">

	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/mod/error/ErrorLog/save" method="POST" data-callback="defaultRegisterCallback">
		<br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Formulário</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[errorid]">errorid</label>
					<div class="col-md-4">
						<input id="obj[errorid]" name="obj[errorid]" type="text" class="form-control input-md type-string" value="<?=TextFormatter::format("string",$obj->get("errorid"))?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[type]">type</label>
					<div class="col-md-4">
						<input id="obj[type]" name="obj[type]" type="text" class="form-control input-md type-string" value="<?=TextFormatter::format("string",$obj->get("type"))?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[created]">created</label>
					<div class="col-md-4">
						<input id="obj[created]" name="obj[created]" type="text" class="form-control input-md type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("created"))?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[duration]">duration</label>
					<div class="col-md-4">
						<input id="obj[duration]" name="obj[duration]" type="text" class="form-control input-md type-integer" value="<?=TextFormatter::format("integer",$obj->get("duration"))?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[http_ipaddr]">http_ipaddr</label>
					<div class="col-md-4">
						<input id="obj[http_ipaddr]" name="obj[http_ipaddr]" type="text" class="form-control input-md type-string" value="<?=TextFormatter::format("string",$obj->get("http_ipaddr"))?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[http_method]">http_method</label>
					<div class="col-md-4">
						<input id="obj[http_method]" name="obj[http_method]" type="text" class="form-control input-md type-string" value="<?=TextFormatter::format("string",$obj->get("http_method"))?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[http_uri]">http_uri</label>
					<div class="col-md-4">
						<input id="obj[http_uri]" name="obj[http_uri]" type="text" class="form-control input-md type-string" value="<?=TextFormatter::format("string",$obj->get("http_uri"))?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[level]">level</label>
					<div class="col-md-4">
						<input id="obj[level]" name="obj[level]" type="text" class="form-control input-md type-string" value="<?=TextFormatter::format("string",$obj->get("level"))?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[code]">code</label>
					<div class="col-md-4">
						<input id="obj[code]" name="obj[code]" type="text" class="form-control input-md type-string" value="<?=TextFormatter::format("string",$obj->get("code"))?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[message]">message</label>
					<div class="col-md-4">
						<input id="obj[message]" name="obj[message]" type="text" class="form-control input-md type-string" value="<?=TextFormatter::format("string",$obj->get("message"))?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[stack]">stack</label>
					<div class="col-md-4">
						<input id="obj[stack]" name="obj[stack]" type="text" class="form-control input-md type-string" value="<?=TextFormatter::format("string",$obj->get("stack"))?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[input]">input</label>
					<div class="col-md-4">
						<input id="obj[input]" name="obj[input]" type="text" class="form-control input-md type-string" value="<?=TextFormatter::format("string",$obj->get("input"))?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[file]">file</label>
					<div class="col-md-4">
						<input id="obj[file]" name="obj[file]" type="text" class="form-control input-md type-string" value="<?=TextFormatter::format("string",$obj->get("file"))?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="obj[line]">line</label>
					<div class="col-md-4">
						<input id="obj[line]" name="obj[line]" type="text" class="form-control input-md type-integer" value="<?=TextFormatter::format("integer",$obj->get("line"))?>">
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" id="register-button" class="btn btn-primary">Salvar</button>
				<?}?>
				<button type="button" class="btn btn-default button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>