<?php
use zion\orm\Filter;
use zion\core\System;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("waf","RequestLog");
$fields = array("requestid","USER","HOME","SCRIPT_NAME","REQUEST_URI","QUERY_STRING","REQUEST_METHOD","SERVER_PROTOCOL","GATEWAY_INTERFACE","REDIRECT_URL","REMOTE_PORT","SCRIPT_FILENAME","SERVER_ADMIN","CONTEXT_DOCUMENT_ROOT","CONTEXT_PREFIX","REQUEST_SCHEME","DOCUMENT_ROOT","REMOTE_ADDR","SERVER_PORT","SERVER_ADDR","SERVER_NAME","SERVER_SOFTWARE","SERVER_SIGNATURE","PATH","HTTP_PRAGMA","HTTP_COOKIE","HTTP_ACCEPT_LANGUAGE","HTTP_ACCEPT_ENCODING","HTTP_ACCEPT","HTTP_DNT","HTTP_USER_AGENT","HTTP_UPGRADE_INSECURE_REQUESTS","HTTP_CONNECTION","HTTP_HOST","UNIQUE_ID","REDIRECT_STATUS","REDIRECT_UNIQUE_ID","FCGI_ROLE","PHP_SELF","REQUEST_TIME_FLOAT","REQUEST_TIME","HTTP_REFERER","REQUEST_BODY");
sort($fields);
?>
<div class="center-content filter-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/waf/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Consulta de <?=$t->entity()?></li>
		</ol>
	</nav>
<h3>Consulta de <?=$t->entity()?></h3>
	<form class="form-inline hide-advanced-fields ajaxform" action="/zion/rest/waf/RequestLog/" method="POST" data-callback="defaultFilterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Filtro
			</div>
			<div class="card-body">
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[requestid][low]" alt="<?=$t->tip("requestid")?>" title="<?=$t->tip("requestid")?>">
							<?=$t->field("requestid")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[requestid][operator]" name="filter[requestid][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[requestid][low]" name="filter[requestid][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[requestid][high]" name="filter[requestid][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[USER][low]" alt="<?=$t->tip("USER")?>" title="<?=$t->tip("USER")?>">
							<?=$t->field("USER")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[USER][operator]" name="filter[USER][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[USER][low]" name="filter[USER][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[USER][high]" name="filter[USER][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[HOME][low]" alt="<?=$t->tip("HOME")?>" title="<?=$t->tip("HOME")?>">
							<?=$t->field("HOME")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[HOME][operator]" name="filter[HOME][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[HOME][low]" name="filter[HOME][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[HOME][high]" name="filter[HOME][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[SCRIPT_NAME][low]" alt="<?=$t->tip("SCRIPT_NAME")?>" title="<?=$t->tip("SCRIPT_NAME")?>">
							<?=$t->field("SCRIPT_NAME")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[SCRIPT_NAME][operator]" name="filter[SCRIPT_NAME][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[SCRIPT_NAME][low]" name="filter[SCRIPT_NAME][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[SCRIPT_NAME][high]" name="filter[SCRIPT_NAME][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[REQUEST_URI][low]" alt="<?=$t->tip("REQUEST_URI")?>" title="<?=$t->tip("REQUEST_URI")?>">
							<?=$t->field("REQUEST_URI")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[REQUEST_URI][operator]" name="filter[REQUEST_URI][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[REQUEST_URI][low]" name="filter[REQUEST_URI][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[REQUEST_URI][high]" name="filter[REQUEST_URI][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[QUERY_STRING][low]" alt="<?=$t->tip("QUERY_STRING")?>" title="<?=$t->tip("QUERY_STRING")?>">
							<?=$t->field("QUERY_STRING")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[QUERY_STRING][operator]" name="filter[QUERY_STRING][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[QUERY_STRING][low]" name="filter[QUERY_STRING][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[QUERY_STRING][high]" name="filter[QUERY_STRING][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[REQUEST_METHOD][low]" alt="<?=$t->tip("REQUEST_METHOD")?>" title="<?=$t->tip("REQUEST_METHOD")?>">
							<?=$t->field("REQUEST_METHOD")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[REQUEST_METHOD][operator]" name="filter[REQUEST_METHOD][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[REQUEST_METHOD][low]" name="filter[REQUEST_METHOD][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[REQUEST_METHOD][high]" name="filter[REQUEST_METHOD][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[SERVER_PROTOCOL][low]" alt="<?=$t->tip("SERVER_PROTOCOL")?>" title="<?=$t->tip("SERVER_PROTOCOL")?>">
							<?=$t->field("SERVER_PROTOCOL")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[SERVER_PROTOCOL][operator]" name="filter[SERVER_PROTOCOL][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[SERVER_PROTOCOL][low]" name="filter[SERVER_PROTOCOL][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[SERVER_PROTOCOL][high]" name="filter[SERVER_PROTOCOL][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[GATEWAY_INTERFACE][low]" alt="<?=$t->tip("GATEWAY_INTERFACE")?>" title="<?=$t->tip("GATEWAY_INTERFACE")?>">
							<?=$t->field("GATEWAY_INTERFACE")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[GATEWAY_INTERFACE][operator]" name="filter[GATEWAY_INTERFACE][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[GATEWAY_INTERFACE][low]" name="filter[GATEWAY_INTERFACE][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[GATEWAY_INTERFACE][high]" name="filter[GATEWAY_INTERFACE][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[REDIRECT_URL][low]" alt="<?=$t->tip("REDIRECT_URL")?>" title="<?=$t->tip("REDIRECT_URL")?>">
							<?=$t->field("REDIRECT_URL")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[REDIRECT_URL][operator]" name="filter[REDIRECT_URL][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[REDIRECT_URL][low]" name="filter[REDIRECT_URL][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[REDIRECT_URL][high]" name="filter[REDIRECT_URL][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[REMOTE_PORT][low]" alt="<?=$t->tip("REMOTE_PORT")?>" title="<?=$t->tip("REMOTE_PORT")?>">
							<?=$t->field("REMOTE_PORT")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[REMOTE_PORT][operator]" name="filter[REMOTE_PORT][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[REMOTE_PORT][low]" name="filter[REMOTE_PORT][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[REMOTE_PORT][high]" name="filter[REMOTE_PORT][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[SCRIPT_FILENAME][low]" alt="<?=$t->tip("SCRIPT_FILENAME")?>" title="<?=$t->tip("SCRIPT_FILENAME")?>">
							<?=$t->field("SCRIPT_FILENAME")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[SCRIPT_FILENAME][operator]" name="filter[SCRIPT_FILENAME][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[SCRIPT_FILENAME][low]" name="filter[SCRIPT_FILENAME][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[SCRIPT_FILENAME][high]" name="filter[SCRIPT_FILENAME][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[SERVER_ADMIN][low]" alt="<?=$t->tip("SERVER_ADMIN")?>" title="<?=$t->tip("SERVER_ADMIN")?>">
							<?=$t->field("SERVER_ADMIN")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[SERVER_ADMIN][operator]" name="filter[SERVER_ADMIN][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[SERVER_ADMIN][low]" name="filter[SERVER_ADMIN][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[SERVER_ADMIN][high]" name="filter[SERVER_ADMIN][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[CONTEXT_DOCUMENT_ROOT][low]" alt="<?=$t->tip("CONTEXT_DOCUMENT_ROOT")?>" title="<?=$t->tip("CONTEXT_DOCUMENT_ROOT")?>">
							<?=$t->field("CONTEXT_DOCUMENT_ROOT")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[CONTEXT_DOCUMENT_ROOT][operator]" name="filter[CONTEXT_DOCUMENT_ROOT][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[CONTEXT_DOCUMENT_ROOT][low]" name="filter[CONTEXT_DOCUMENT_ROOT][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[CONTEXT_DOCUMENT_ROOT][high]" name="filter[CONTEXT_DOCUMENT_ROOT][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[CONTEXT_PREFIX][low]" alt="<?=$t->tip("CONTEXT_PREFIX")?>" title="<?=$t->tip("CONTEXT_PREFIX")?>">
							<?=$t->field("CONTEXT_PREFIX")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[CONTEXT_PREFIX][operator]" name="filter[CONTEXT_PREFIX][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[CONTEXT_PREFIX][low]" name="filter[CONTEXT_PREFIX][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[CONTEXT_PREFIX][high]" name="filter[CONTEXT_PREFIX][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[REQUEST_SCHEME][low]" alt="<?=$t->tip("REQUEST_SCHEME")?>" title="<?=$t->tip("REQUEST_SCHEME")?>">
							<?=$t->field("REQUEST_SCHEME")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[REQUEST_SCHEME][operator]" name="filter[REQUEST_SCHEME][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[REQUEST_SCHEME][low]" name="filter[REQUEST_SCHEME][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[REQUEST_SCHEME][high]" name="filter[REQUEST_SCHEME][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[DOCUMENT_ROOT][low]" alt="<?=$t->tip("DOCUMENT_ROOT")?>" title="<?=$t->tip("DOCUMENT_ROOT")?>">
							<?=$t->field("DOCUMENT_ROOT")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[DOCUMENT_ROOT][operator]" name="filter[DOCUMENT_ROOT][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[DOCUMENT_ROOT][low]" name="filter[DOCUMENT_ROOT][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[DOCUMENT_ROOT][high]" name="filter[DOCUMENT_ROOT][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[REMOTE_ADDR][low]" alt="<?=$t->tip("REMOTE_ADDR")?>" title="<?=$t->tip("REMOTE_ADDR")?>">
							<?=$t->field("REMOTE_ADDR")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[REMOTE_ADDR][operator]" name="filter[REMOTE_ADDR][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[REMOTE_ADDR][low]" name="filter[REMOTE_ADDR][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[REMOTE_ADDR][high]" name="filter[REMOTE_ADDR][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[SERVER_PORT][low]" alt="<?=$t->tip("SERVER_PORT")?>" title="<?=$t->tip("SERVER_PORT")?>">
							<?=$t->field("SERVER_PORT")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[SERVER_PORT][operator]" name="filter[SERVER_PORT][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[SERVER_PORT][low]" name="filter[SERVER_PORT][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[SERVER_PORT][high]" name="filter[SERVER_PORT][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[SERVER_ADDR][low]" alt="<?=$t->tip("SERVER_ADDR")?>" title="<?=$t->tip("SERVER_ADDR")?>">
							<?=$t->field("SERVER_ADDR")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[SERVER_ADDR][operator]" name="filter[SERVER_ADDR][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[SERVER_ADDR][low]" name="filter[SERVER_ADDR][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[SERVER_ADDR][high]" name="filter[SERVER_ADDR][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[SERVER_NAME][low]" alt="<?=$t->tip("SERVER_NAME")?>" title="<?=$t->tip("SERVER_NAME")?>">
							<?=$t->field("SERVER_NAME")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[SERVER_NAME][operator]" name="filter[SERVER_NAME][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[SERVER_NAME][low]" name="filter[SERVER_NAME][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[SERVER_NAME][high]" name="filter[SERVER_NAME][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[SERVER_SOFTWARE][low]" alt="<?=$t->tip("SERVER_SOFTWARE")?>" title="<?=$t->tip("SERVER_SOFTWARE")?>">
							<?=$t->field("SERVER_SOFTWARE")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[SERVER_SOFTWARE][operator]" name="filter[SERVER_SOFTWARE][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[SERVER_SOFTWARE][low]" name="filter[SERVER_SOFTWARE][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[SERVER_SOFTWARE][high]" name="filter[SERVER_SOFTWARE][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[SERVER_SIGNATURE][low]" alt="<?=$t->tip("SERVER_SIGNATURE")?>" title="<?=$t->tip("SERVER_SIGNATURE")?>">
							<?=$t->field("SERVER_SIGNATURE")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[SERVER_SIGNATURE][operator]" name="filter[SERVER_SIGNATURE][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[SERVER_SIGNATURE][low]" name="filter[SERVER_SIGNATURE][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[SERVER_SIGNATURE][high]" name="filter[SERVER_SIGNATURE][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[PATH][low]" alt="<?=$t->tip("PATH")?>" title="<?=$t->tip("PATH")?>">
							<?=$t->field("PATH")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[PATH][operator]" name="filter[PATH][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[PATH][low]" name="filter[PATH][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[PATH][high]" name="filter[PATH][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[HTTP_PRAGMA][low]" alt="<?=$t->tip("HTTP_PRAGMA")?>" title="<?=$t->tip("HTTP_PRAGMA")?>">
							<?=$t->field("HTTP_PRAGMA")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[HTTP_PRAGMA][operator]" name="filter[HTTP_PRAGMA][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[HTTP_PRAGMA][low]" name="filter[HTTP_PRAGMA][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[HTTP_PRAGMA][high]" name="filter[HTTP_PRAGMA][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[HTTP_COOKIE][low]" alt="<?=$t->tip("HTTP_COOKIE")?>" title="<?=$t->tip("HTTP_COOKIE")?>">
							<?=$t->field("HTTP_COOKIE")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[HTTP_COOKIE][operator]" name="filter[HTTP_COOKIE][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[HTTP_COOKIE][low]" name="filter[HTTP_COOKIE][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[HTTP_COOKIE][high]" name="filter[HTTP_COOKIE][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[HTTP_ACCEPT_LANGUAGE][low]" alt="<?=$t->tip("HTTP_ACCEPT_LANGUAGE")?>" title="<?=$t->tip("HTTP_ACCEPT_LANGUAGE")?>">
							<?=$t->field("HTTP_ACCEPT_LANGUAGE")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[HTTP_ACCEPT_LANGUAGE][operator]" name="filter[HTTP_ACCEPT_LANGUAGE][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[HTTP_ACCEPT_LANGUAGE][low]" name="filter[HTTP_ACCEPT_LANGUAGE][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[HTTP_ACCEPT_LANGUAGE][high]" name="filter[HTTP_ACCEPT_LANGUAGE][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[HTTP_ACCEPT_ENCODING][low]" alt="<?=$t->tip("HTTP_ACCEPT_ENCODING")?>" title="<?=$t->tip("HTTP_ACCEPT_ENCODING")?>">
							<?=$t->field("HTTP_ACCEPT_ENCODING")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[HTTP_ACCEPT_ENCODING][operator]" name="filter[HTTP_ACCEPT_ENCODING][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[HTTP_ACCEPT_ENCODING][low]" name="filter[HTTP_ACCEPT_ENCODING][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[HTTP_ACCEPT_ENCODING][high]" name="filter[HTTP_ACCEPT_ENCODING][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[HTTP_ACCEPT][low]" alt="<?=$t->tip("HTTP_ACCEPT")?>" title="<?=$t->tip("HTTP_ACCEPT")?>">
							<?=$t->field("HTTP_ACCEPT")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[HTTP_ACCEPT][operator]" name="filter[HTTP_ACCEPT][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[HTTP_ACCEPT][low]" name="filter[HTTP_ACCEPT][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[HTTP_ACCEPT][high]" name="filter[HTTP_ACCEPT][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[HTTP_DNT][low]" alt="<?=$t->tip("HTTP_DNT")?>" title="<?=$t->tip("HTTP_DNT")?>">
							<?=$t->field("HTTP_DNT")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[HTTP_DNT][operator]" name="filter[HTTP_DNT][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[HTTP_DNT][low]" name="filter[HTTP_DNT][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[HTTP_DNT][high]" name="filter[HTTP_DNT][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[HTTP_USER_AGENT][low]" alt="<?=$t->tip("HTTP_USER_AGENT")?>" title="<?=$t->tip("HTTP_USER_AGENT")?>">
							<?=$t->field("HTTP_USER_AGENT")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[HTTP_USER_AGENT][operator]" name="filter[HTTP_USER_AGENT][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[HTTP_USER_AGENT][low]" name="filter[HTTP_USER_AGENT][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[HTTP_USER_AGENT][high]" name="filter[HTTP_USER_AGENT][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[HTTP_UPGRADE_INSECURE_REQUESTS][low]" alt="<?=$t->tip("HTTP_UPGRADE_INSECURE_REQUESTS")?>" title="<?=$t->tip("HTTP_UPGRADE_INSECURE_REQUESTS")?>">
							<?=$t->field("HTTP_UPGRADE_INSECURE_REQUESTS")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[HTTP_UPGRADE_INSECURE_REQUESTS][operator]" name="filter[HTTP_UPGRADE_INSECURE_REQUESTS][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[HTTP_UPGRADE_INSECURE_REQUESTS][low]" name="filter[HTTP_UPGRADE_INSECURE_REQUESTS][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[HTTP_UPGRADE_INSECURE_REQUESTS][high]" name="filter[HTTP_UPGRADE_INSECURE_REQUESTS][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[HTTP_CONNECTION][low]" alt="<?=$t->tip("HTTP_CONNECTION")?>" title="<?=$t->tip("HTTP_CONNECTION")?>">
							<?=$t->field("HTTP_CONNECTION")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[HTTP_CONNECTION][operator]" name="filter[HTTP_CONNECTION][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[HTTP_CONNECTION][low]" name="filter[HTTP_CONNECTION][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[HTTP_CONNECTION][high]" name="filter[HTTP_CONNECTION][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[HTTP_HOST][low]" alt="<?=$t->tip("HTTP_HOST")?>" title="<?=$t->tip("HTTP_HOST")?>">
							<?=$t->field("HTTP_HOST")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[HTTP_HOST][operator]" name="filter[HTTP_HOST][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[HTTP_HOST][low]" name="filter[HTTP_HOST][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[HTTP_HOST][high]" name="filter[HTTP_HOST][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[UNIQUE_ID][low]" alt="<?=$t->tip("UNIQUE_ID")?>" title="<?=$t->tip("UNIQUE_ID")?>">
							<?=$t->field("UNIQUE_ID")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[UNIQUE_ID][operator]" name="filter[UNIQUE_ID][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[UNIQUE_ID][low]" name="filter[UNIQUE_ID][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[UNIQUE_ID][high]" name="filter[UNIQUE_ID][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[REDIRECT_STATUS][low]" alt="<?=$t->tip("REDIRECT_STATUS")?>" title="<?=$t->tip("REDIRECT_STATUS")?>">
							<?=$t->field("REDIRECT_STATUS")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[REDIRECT_STATUS][operator]" name="filter[REDIRECT_STATUS][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[REDIRECT_STATUS][low]" name="filter[REDIRECT_STATUS][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[REDIRECT_STATUS][high]" name="filter[REDIRECT_STATUS][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[REDIRECT_UNIQUE_ID][low]" alt="<?=$t->tip("REDIRECT_UNIQUE_ID")?>" title="<?=$t->tip("REDIRECT_UNIQUE_ID")?>">
							<?=$t->field("REDIRECT_UNIQUE_ID")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[REDIRECT_UNIQUE_ID][operator]" name="filter[REDIRECT_UNIQUE_ID][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[REDIRECT_UNIQUE_ID][low]" name="filter[REDIRECT_UNIQUE_ID][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[REDIRECT_UNIQUE_ID][high]" name="filter[REDIRECT_UNIQUE_ID][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[FCGI_ROLE][low]" alt="<?=$t->tip("FCGI_ROLE")?>" title="<?=$t->tip("FCGI_ROLE")?>">
							<?=$t->field("FCGI_ROLE")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[FCGI_ROLE][operator]" name="filter[FCGI_ROLE][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[FCGI_ROLE][low]" name="filter[FCGI_ROLE][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[FCGI_ROLE][high]" name="filter[FCGI_ROLE][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[PHP_SELF][low]" alt="<?=$t->tip("PHP_SELF")?>" title="<?=$t->tip("PHP_SELF")?>">
							<?=$t->field("PHP_SELF")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[PHP_SELF][operator]" name="filter[PHP_SELF][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[PHP_SELF][low]" name="filter[PHP_SELF][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[PHP_SELF][high]" name="filter[PHP_SELF][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[REQUEST_TIME_FLOAT][low]" alt="<?=$t->tip("REQUEST_TIME_FLOAT")?>" title="<?=$t->tip("REQUEST_TIME_FLOAT")?>">
							<?=$t->field("REQUEST_TIME_FLOAT")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[REQUEST_TIME_FLOAT][operator]" name="filter[REQUEST_TIME_FLOAT][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[REQUEST_TIME_FLOAT][low]" name="filter[REQUEST_TIME_FLOAT][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[REQUEST_TIME_FLOAT][high]" name="filter[REQUEST_TIME_FLOAT][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[REQUEST_TIME][low]" alt="<?=$t->tip("REQUEST_TIME")?>" title="<?=$t->tip("REQUEST_TIME")?>">
							<?=$t->field("REQUEST_TIME")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[REQUEST_TIME][operator]" name="filter[REQUEST_TIME][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-datetime" id="filter[REQUEST_TIME][low]" name="filter[REQUEST_TIME][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-datetime" id="filter[REQUEST_TIME][high]" name="filter[REQUEST_TIME][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[HTTP_REFERER][low]" alt="<?=$t->tip("HTTP_REFERER")?>" title="<?=$t->tip("HTTP_REFERER")?>">
							<?=$t->field("HTTP_REFERER")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[HTTP_REFERER][operator]" name="filter[HTTP_REFERER][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[HTTP_REFERER][low]" name="filter[HTTP_REFERER][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[HTTP_REFERER][high]" name="filter[HTTP_REFERER][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[REQUEST_BODY][low]" alt="<?=$t->tip("REQUEST_BODY")?>" title="<?=$t->tip("REQUEST_BODY")?>">
							<?=$t->field("REQUEST_BODY")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[REQUEST_BODY][operator]" name="filter[REQUEST_BODY][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[REQUEST_BODY][low]" name="filter[REQUEST_BODY][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[REQUEST_BODY][high]" name="filter[REQUEST_BODY][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="order[field]">Ordenação</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control" id="order[field]" name="order[field]">
							<option value=""></option>
							<?foreach($fields AS $key){?>
							<option value="<?=$key?>"><?=$key?></option>
							<?}?>
						</select>
						
						<select class="form-control" id="order[type]" name="order[type]">
							<option value=""></option>
							<option value="ASC">ASC</option>
							<option value="DESC">DESC</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="limit">Limite</label>
					</div>
					<div class="col-sm-9">
						<input class="form-control type-integer" id="limit" name="limit" value="100">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="offset">Ignorar</label>
					</div>
					<div class="col-sm-9">
						<input class="form-control type-integer" id="offset" name="offset" value="0">
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" id="filter-button" class="btn btn-primary">Filtrar</button>
				<button type="button" id="button-filter-basic" class="btn btn-outline-secondary">Basico</button>
				<button type="button" id="button-filter-advanced" class="btn btn-outline-secondary">Avançado</button>
				<a id="button-new" class="btn btn-outline-info" href="/zion/mod/waf/RequestLog/new" target="_blank">Novo</a>
			</div>
		</div>
	</form>

	<div id="filter-result">
		<div class="container-fluid">Execute o filtro</div>
	</div>
</div></div>