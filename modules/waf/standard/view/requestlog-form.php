<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";
$keys = $obj->toQueryStringKeys(array("requestid"));
$t = Text::getEntityTexts("waf","RequestLog");
?>
<div class="center-content form-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/waf/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/waf/RequestLog/list">Consulta de <?=$t->entity()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Formulario de <?=$t->entity()?></li>
		</ol>
	</nav>
	<h3>Formulário de <?=$t->entity()?></h3>
	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/waf/RequestLog/" method="<?=$method?>" data-callback="defaultRegisterCallback" data-accept="text/plain">
		<br>
		<div class="card">
			<div class="card-header">
				Formulário
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-3">
						<label class="pk control-label" for="obj[requestid]" alt="<?=$t->tip("requestid")?>" title="<?=$t->tip("requestid")?>">
							<?=$t->field("requestid")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[requestid]" name="obj[requestid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("requestid"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[USER]" alt="<?=$t->tip("USER")?>" title="<?=$t->tip("USER")?>">
							<?=$t->field("USER")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[USER]" name="obj[USER]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("USER"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[HOME]" alt="<?=$t->tip("HOME")?>" title="<?=$t->tip("HOME")?>">
							<?=$t->field("HOME")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[HOME]" name="obj[HOME]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("HOME"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[SCRIPT_NAME]" alt="<?=$t->tip("SCRIPT_NAME")?>" title="<?=$t->tip("SCRIPT_NAME")?>">
							<?=$t->field("SCRIPT_NAME")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[SCRIPT_NAME]" name="obj[SCRIPT_NAME]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("SCRIPT_NAME"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[REQUEST_URI]" alt="<?=$t->tip("REQUEST_URI")?>" title="<?=$t->tip("REQUEST_URI")?>">
							<?=$t->field("REQUEST_URI")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[REQUEST_URI]" name="obj[REQUEST_URI]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("REQUEST_URI"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[QUERY_STRING]" alt="<?=$t->tip("QUERY_STRING")?>" title="<?=$t->tip("QUERY_STRING")?>">
							<?=$t->field("QUERY_STRING")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[QUERY_STRING]" name="obj[QUERY_STRING]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("QUERY_STRING"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[REQUEST_METHOD]" alt="<?=$t->tip("REQUEST_METHOD")?>" title="<?=$t->tip("REQUEST_METHOD")?>">
							<?=$t->field("REQUEST_METHOD")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[REQUEST_METHOD]" name="obj[REQUEST_METHOD]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("REQUEST_METHOD"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[SERVER_PROTOCOL]" alt="<?=$t->tip("SERVER_PROTOCOL")?>" title="<?=$t->tip("SERVER_PROTOCOL")?>">
							<?=$t->field("SERVER_PROTOCOL")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[SERVER_PROTOCOL]" name="obj[SERVER_PROTOCOL]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("SERVER_PROTOCOL"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[GATEWAY_INTERFACE]" alt="<?=$t->tip("GATEWAY_INTERFACE")?>" title="<?=$t->tip("GATEWAY_INTERFACE")?>">
							<?=$t->field("GATEWAY_INTERFACE")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[GATEWAY_INTERFACE]" name="obj[GATEWAY_INTERFACE]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("GATEWAY_INTERFACE"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[REDIRECT_URL]" alt="<?=$t->tip("REDIRECT_URL")?>" title="<?=$t->tip("REDIRECT_URL")?>">
							<?=$t->field("REDIRECT_URL")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[REDIRECT_URL]" name="obj[REDIRECT_URL]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("REDIRECT_URL"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[REMOTE_PORT]" alt="<?=$t->tip("REMOTE_PORT")?>" title="<?=$t->tip("REMOTE_PORT")?>">
							<?=$t->field("REMOTE_PORT")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[REMOTE_PORT]" name="obj[REMOTE_PORT]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("REMOTE_PORT"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[SCRIPT_FILENAME]" alt="<?=$t->tip("SCRIPT_FILENAME")?>" title="<?=$t->tip("SCRIPT_FILENAME")?>">
							<?=$t->field("SCRIPT_FILENAME")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[SCRIPT_FILENAME]" name="obj[SCRIPT_FILENAME]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("SCRIPT_FILENAME"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[SERVER_ADMIN]" alt="<?=$t->tip("SERVER_ADMIN")?>" title="<?=$t->tip("SERVER_ADMIN")?>">
							<?=$t->field("SERVER_ADMIN")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[SERVER_ADMIN]" name="obj[SERVER_ADMIN]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("SERVER_ADMIN"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[CONTEXT_DOCUMENT_ROOT]" alt="<?=$t->tip("CONTEXT_DOCUMENT_ROOT")?>" title="<?=$t->tip("CONTEXT_DOCUMENT_ROOT")?>">
							<?=$t->field("CONTEXT_DOCUMENT_ROOT")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[CONTEXT_DOCUMENT_ROOT]" name="obj[CONTEXT_DOCUMENT_ROOT]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("CONTEXT_DOCUMENT_ROOT"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[CONTEXT_PREFIX]" alt="<?=$t->tip("CONTEXT_PREFIX")?>" title="<?=$t->tip("CONTEXT_PREFIX")?>">
							<?=$t->field("CONTEXT_PREFIX")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[CONTEXT_PREFIX]" name="obj[CONTEXT_PREFIX]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("CONTEXT_PREFIX"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[REQUEST_SCHEME]" alt="<?=$t->tip("REQUEST_SCHEME")?>" title="<?=$t->tip("REQUEST_SCHEME")?>">
							<?=$t->field("REQUEST_SCHEME")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[REQUEST_SCHEME]" name="obj[REQUEST_SCHEME]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("REQUEST_SCHEME"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[DOCUMENT_ROOT]" alt="<?=$t->tip("DOCUMENT_ROOT")?>" title="<?=$t->tip("DOCUMENT_ROOT")?>">
							<?=$t->field("DOCUMENT_ROOT")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[DOCUMENT_ROOT]" name="obj[DOCUMENT_ROOT]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("DOCUMENT_ROOT"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[REMOTE_ADDR]" alt="<?=$t->tip("REMOTE_ADDR")?>" title="<?=$t->tip("REMOTE_ADDR")?>">
							<?=$t->field("REMOTE_ADDR")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[REMOTE_ADDR]" name="obj[REMOTE_ADDR]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("REMOTE_ADDR"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[SERVER_PORT]" alt="<?=$t->tip("SERVER_PORT")?>" title="<?=$t->tip("SERVER_PORT")?>">
							<?=$t->field("SERVER_PORT")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[SERVER_PORT]" name="obj[SERVER_PORT]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("SERVER_PORT"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[SERVER_ADDR]" alt="<?=$t->tip("SERVER_ADDR")?>" title="<?=$t->tip("SERVER_ADDR")?>">
							<?=$t->field("SERVER_ADDR")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[SERVER_ADDR]" name="obj[SERVER_ADDR]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("SERVER_ADDR"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[SERVER_NAME]" alt="<?=$t->tip("SERVER_NAME")?>" title="<?=$t->tip("SERVER_NAME")?>">
							<?=$t->field("SERVER_NAME")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[SERVER_NAME]" name="obj[SERVER_NAME]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("SERVER_NAME"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[SERVER_SOFTWARE]" alt="<?=$t->tip("SERVER_SOFTWARE")?>" title="<?=$t->tip("SERVER_SOFTWARE")?>">
							<?=$t->field("SERVER_SOFTWARE")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[SERVER_SOFTWARE]" name="obj[SERVER_SOFTWARE]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("SERVER_SOFTWARE"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[SERVER_SIGNATURE]" alt="<?=$t->tip("SERVER_SIGNATURE")?>" title="<?=$t->tip("SERVER_SIGNATURE")?>">
							<?=$t->field("SERVER_SIGNATURE")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[SERVER_SIGNATURE]" name="obj[SERVER_SIGNATURE]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("SERVER_SIGNATURE"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[PATH]" alt="<?=$t->tip("PATH")?>" title="<?=$t->tip("PATH")?>">
							<?=$t->field("PATH")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[PATH]" name="obj[PATH]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("PATH"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[HTTP_PRAGMA]" alt="<?=$t->tip("HTTP_PRAGMA")?>" title="<?=$t->tip("HTTP_PRAGMA")?>">
							<?=$t->field("HTTP_PRAGMA")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[HTTP_PRAGMA]" name="obj[HTTP_PRAGMA]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("HTTP_PRAGMA"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[HTTP_COOKIE]" alt="<?=$t->tip("HTTP_COOKIE")?>" title="<?=$t->tip("HTTP_COOKIE")?>">
							<?=$t->field("HTTP_COOKIE")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[HTTP_COOKIE]" name="obj[HTTP_COOKIE]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("HTTP_COOKIE"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[HTTP_ACCEPT_LANGUAGE]" alt="<?=$t->tip("HTTP_ACCEPT_LANGUAGE")?>" title="<?=$t->tip("HTTP_ACCEPT_LANGUAGE")?>">
							<?=$t->field("HTTP_ACCEPT_LANGUAGE")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[HTTP_ACCEPT_LANGUAGE]" name="obj[HTTP_ACCEPT_LANGUAGE]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("HTTP_ACCEPT_LANGUAGE"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[HTTP_ACCEPT_ENCODING]" alt="<?=$t->tip("HTTP_ACCEPT_ENCODING")?>" title="<?=$t->tip("HTTP_ACCEPT_ENCODING")?>">
							<?=$t->field("HTTP_ACCEPT_ENCODING")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[HTTP_ACCEPT_ENCODING]" name="obj[HTTP_ACCEPT_ENCODING]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("HTTP_ACCEPT_ENCODING"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[HTTP_ACCEPT]" alt="<?=$t->tip("HTTP_ACCEPT")?>" title="<?=$t->tip("HTTP_ACCEPT")?>">
							<?=$t->field("HTTP_ACCEPT")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[HTTP_ACCEPT]" name="obj[HTTP_ACCEPT]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("HTTP_ACCEPT"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[HTTP_DNT]" alt="<?=$t->tip("HTTP_DNT")?>" title="<?=$t->tip("HTTP_DNT")?>">
							<?=$t->field("HTTP_DNT")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[HTTP_DNT]" name="obj[HTTP_DNT]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("HTTP_DNT"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[HTTP_USER_AGENT]" alt="<?=$t->tip("HTTP_USER_AGENT")?>" title="<?=$t->tip("HTTP_USER_AGENT")?>">
							<?=$t->field("HTTP_USER_AGENT")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[HTTP_USER_AGENT]" name="obj[HTTP_USER_AGENT]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("HTTP_USER_AGENT"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[HTTP_UPGRADE_INSECURE_REQUESTS]" alt="<?=$t->tip("HTTP_UPGRADE_INSECURE_REQUESTS")?>" title="<?=$t->tip("HTTP_UPGRADE_INSECURE_REQUESTS")?>">
							<?=$t->field("HTTP_UPGRADE_INSECURE_REQUESTS")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[HTTP_UPGRADE_INSECURE_REQUESTS]" name="obj[HTTP_UPGRADE_INSECURE_REQUESTS]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("HTTP_UPGRADE_INSECURE_REQUESTS"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[HTTP_CONNECTION]" alt="<?=$t->tip("HTTP_CONNECTION")?>" title="<?=$t->tip("HTTP_CONNECTION")?>">
							<?=$t->field("HTTP_CONNECTION")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[HTTP_CONNECTION]" name="obj[HTTP_CONNECTION]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("HTTP_CONNECTION"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[HTTP_HOST]" alt="<?=$t->tip("HTTP_HOST")?>" title="<?=$t->tip("HTTP_HOST")?>">
							<?=$t->field("HTTP_HOST")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[HTTP_HOST]" name="obj[HTTP_HOST]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("HTTP_HOST"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[UNIQUE_ID]" alt="<?=$t->tip("UNIQUE_ID")?>" title="<?=$t->tip("UNIQUE_ID")?>">
							<?=$t->field("UNIQUE_ID")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[UNIQUE_ID]" name="obj[UNIQUE_ID]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("UNIQUE_ID"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[REDIRECT_STATUS]" alt="<?=$t->tip("REDIRECT_STATUS")?>" title="<?=$t->tip("REDIRECT_STATUS")?>">
							<?=$t->field("REDIRECT_STATUS")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[REDIRECT_STATUS]" name="obj[REDIRECT_STATUS]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("REDIRECT_STATUS"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[REDIRECT_UNIQUE_ID]" alt="<?=$t->tip("REDIRECT_UNIQUE_ID")?>" title="<?=$t->tip("REDIRECT_UNIQUE_ID")?>">
							<?=$t->field("REDIRECT_UNIQUE_ID")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[REDIRECT_UNIQUE_ID]" name="obj[REDIRECT_UNIQUE_ID]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("REDIRECT_UNIQUE_ID"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[FCGI_ROLE]" alt="<?=$t->tip("FCGI_ROLE")?>" title="<?=$t->tip("FCGI_ROLE")?>">
							<?=$t->field("FCGI_ROLE")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[FCGI_ROLE]" name="obj[FCGI_ROLE]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("FCGI_ROLE"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[PHP_SELF]" alt="<?=$t->tip("PHP_SELF")?>" title="<?=$t->tip("PHP_SELF")?>">
							<?=$t->field("PHP_SELF")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[PHP_SELF]" name="obj[PHP_SELF]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("PHP_SELF"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[REQUEST_TIME_FLOAT]" alt="<?=$t->tip("REQUEST_TIME_FLOAT")?>" title="<?=$t->tip("REQUEST_TIME_FLOAT")?>">
							<?=$t->field("REQUEST_TIME_FLOAT")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[REQUEST_TIME_FLOAT]" name="obj[REQUEST_TIME_FLOAT]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("REQUEST_TIME_FLOAT"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[REQUEST_TIME]" alt="<?=$t->tip("REQUEST_TIME")?>" title="<?=$t->tip("REQUEST_TIME")?>">
							<?=$t->field("REQUEST_TIME")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[REQUEST_TIME]" name="obj[REQUEST_TIME]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("REQUEST_TIME"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[HTTP_REFERER]" alt="<?=$t->tip("HTTP_REFERER")?>" title="<?=$t->tip("HTTP_REFERER")?>">
							<?=$t->field("HTTP_REFERER")?>
						</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[HTTP_REFERER]" name="obj[HTTP_REFERER]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("HTTP_REFERER"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[REQUEST_BODY]" alt="<?=$t->tip("REQUEST_BODY")?>" title="<?=$t->tip("REQUEST_BODY")?>">
							<?=$t->field("REQUEST_BODY")?>
						</label>
					</div>
					<div class="col-sm-5">
						<textarea id="obj[REQUEST_BODY]" name="obj[REQUEST_BODY]" class="form-control type-string"><?=TextFormatter::format("string",$obj->get("REQUEST_BODY"))?></textarea>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" class="btn btn-outline-primary" id="register-button">Salvar</button>
				<?}?>
				<?if(in_array($action,array("edit"))){?>
				<button type="button" class="btn btn-outline-danger button-delete" data-url="/zion/rest/waf/RequestLog/?<?=$keys?>">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/waf/RequestLog/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>