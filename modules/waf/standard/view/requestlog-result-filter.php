<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("waf","RequestLog");
$objList = System::get("objList");
?>
<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered table-sm">
		<thead>
		<tr>
			<td><input type="checkbox"></td>
			<td>#</td>
			<td alt="<?=$t->tip("requestid")?>" title="<?=$t->tip("requestid")?>">
				<?=$t->field("requestid")?>
			</td>
			<td alt="<?=$t->tip("USER")?>" title="<?=$t->tip("USER")?>">
				<?=$t->field("USER")?>
			</td>
			<td alt="<?=$t->tip("HOME")?>" title="<?=$t->tip("HOME")?>">
				<?=$t->field("HOME")?>
			</td>
			<td alt="<?=$t->tip("SCRIPT_NAME")?>" title="<?=$t->tip("SCRIPT_NAME")?>">
				<?=$t->field("SCRIPT_NAME")?>
			</td>
			<td alt="<?=$t->tip("REQUEST_URI")?>" title="<?=$t->tip("REQUEST_URI")?>">
				<?=$t->field("REQUEST_URI")?>
			</td>
			<td alt="<?=$t->tip("QUERY_STRING")?>" title="<?=$t->tip("QUERY_STRING")?>">
				<?=$t->field("QUERY_STRING")?>
			</td>
			<td alt="<?=$t->tip("REQUEST_METHOD")?>" title="<?=$t->tip("REQUEST_METHOD")?>">
				<?=$t->field("REQUEST_METHOD")?>
			</td>
			<td alt="<?=$t->tip("SERVER_PROTOCOL")?>" title="<?=$t->tip("SERVER_PROTOCOL")?>">
				<?=$t->field("SERVER_PROTOCOL")?>
			</td>
			<td alt="<?=$t->tip("GATEWAY_INTERFACE")?>" title="<?=$t->tip("GATEWAY_INTERFACE")?>">
				<?=$t->field("GATEWAY_INTERFACE")?>
			</td>
			<td alt="<?=$t->tip("REDIRECT_URL")?>" title="<?=$t->tip("REDIRECT_URL")?>">
				<?=$t->field("REDIRECT_URL")?>
			</td>
			<td alt="<?=$t->tip("REMOTE_PORT")?>" title="<?=$t->tip("REMOTE_PORT")?>">
				<?=$t->field("REMOTE_PORT")?>
			</td>
			<td alt="<?=$t->tip("SCRIPT_FILENAME")?>" title="<?=$t->tip("SCRIPT_FILENAME")?>">
				<?=$t->field("SCRIPT_FILENAME")?>
			</td>
			<td alt="<?=$t->tip("SERVER_ADMIN")?>" title="<?=$t->tip("SERVER_ADMIN")?>">
				<?=$t->field("SERVER_ADMIN")?>
			</td>
			<td alt="<?=$t->tip("CONTEXT_DOCUMENT_ROOT")?>" title="<?=$t->tip("CONTEXT_DOCUMENT_ROOT")?>">
				<?=$t->field("CONTEXT_DOCUMENT_ROOT")?>
			</td>
			<td alt="<?=$t->tip("CONTEXT_PREFIX")?>" title="<?=$t->tip("CONTEXT_PREFIX")?>">
				<?=$t->field("CONTEXT_PREFIX")?>
			</td>
			<td alt="<?=$t->tip("REQUEST_SCHEME")?>" title="<?=$t->tip("REQUEST_SCHEME")?>">
				<?=$t->field("REQUEST_SCHEME")?>
			</td>
			<td alt="<?=$t->tip("DOCUMENT_ROOT")?>" title="<?=$t->tip("DOCUMENT_ROOT")?>">
				<?=$t->field("DOCUMENT_ROOT")?>
			</td>
			<td alt="<?=$t->tip("REMOTE_ADDR")?>" title="<?=$t->tip("REMOTE_ADDR")?>">
				<?=$t->field("REMOTE_ADDR")?>
			</td>
			<td alt="<?=$t->tip("SERVER_PORT")?>" title="<?=$t->tip("SERVER_PORT")?>">
				<?=$t->field("SERVER_PORT")?>
			</td>
			<td alt="<?=$t->tip("SERVER_ADDR")?>" title="<?=$t->tip("SERVER_ADDR")?>">
				<?=$t->field("SERVER_ADDR")?>
			</td>
			<td alt="<?=$t->tip("SERVER_NAME")?>" title="<?=$t->tip("SERVER_NAME")?>">
				<?=$t->field("SERVER_NAME")?>
			</td>
			<td alt="<?=$t->tip("SERVER_SOFTWARE")?>" title="<?=$t->tip("SERVER_SOFTWARE")?>">
				<?=$t->field("SERVER_SOFTWARE")?>
			</td>
			<td alt="<?=$t->tip("SERVER_SIGNATURE")?>" title="<?=$t->tip("SERVER_SIGNATURE")?>">
				<?=$t->field("SERVER_SIGNATURE")?>
			</td>
			<td alt="<?=$t->tip("PATH")?>" title="<?=$t->tip("PATH")?>">
				<?=$t->field("PATH")?>
			</td>
			<td alt="<?=$t->tip("HTTP_PRAGMA")?>" title="<?=$t->tip("HTTP_PRAGMA")?>">
				<?=$t->field("HTTP_PRAGMA")?>
			</td>
			<td alt="<?=$t->tip("HTTP_COOKIE")?>" title="<?=$t->tip("HTTP_COOKIE")?>">
				<?=$t->field("HTTP_COOKIE")?>
			</td>
			<td alt="<?=$t->tip("HTTP_ACCEPT_LANGUAGE")?>" title="<?=$t->tip("HTTP_ACCEPT_LANGUAGE")?>">
				<?=$t->field("HTTP_ACCEPT_LANGUAGE")?>
			</td>
			<td alt="<?=$t->tip("HTTP_ACCEPT_ENCODING")?>" title="<?=$t->tip("HTTP_ACCEPT_ENCODING")?>">
				<?=$t->field("HTTP_ACCEPT_ENCODING")?>
			</td>
			<td alt="<?=$t->tip("HTTP_ACCEPT")?>" title="<?=$t->tip("HTTP_ACCEPT")?>">
				<?=$t->field("HTTP_ACCEPT")?>
			</td>
			<td alt="<?=$t->tip("HTTP_DNT")?>" title="<?=$t->tip("HTTP_DNT")?>">
				<?=$t->field("HTTP_DNT")?>
			</td>
			<td alt="<?=$t->tip("HTTP_USER_AGENT")?>" title="<?=$t->tip("HTTP_USER_AGENT")?>">
				<?=$t->field("HTTP_USER_AGENT")?>
			</td>
			<td alt="<?=$t->tip("HTTP_UPGRADE_INSECURE_REQUESTS")?>" title="<?=$t->tip("HTTP_UPGRADE_INSECURE_REQUESTS")?>">
				<?=$t->field("HTTP_UPGRADE_INSECURE_REQUESTS")?>
			</td>
			<td alt="<?=$t->tip("HTTP_CONNECTION")?>" title="<?=$t->tip("HTTP_CONNECTION")?>">
				<?=$t->field("HTTP_CONNECTION")?>
			</td>
			<td alt="<?=$t->tip("HTTP_HOST")?>" title="<?=$t->tip("HTTP_HOST")?>">
				<?=$t->field("HTTP_HOST")?>
			</td>
			<td alt="<?=$t->tip("UNIQUE_ID")?>" title="<?=$t->tip("UNIQUE_ID")?>">
				<?=$t->field("UNIQUE_ID")?>
			</td>
			<td alt="<?=$t->tip("REDIRECT_STATUS")?>" title="<?=$t->tip("REDIRECT_STATUS")?>">
				<?=$t->field("REDIRECT_STATUS")?>
			</td>
			<td alt="<?=$t->tip("REDIRECT_UNIQUE_ID")?>" title="<?=$t->tip("REDIRECT_UNIQUE_ID")?>">
				<?=$t->field("REDIRECT_UNIQUE_ID")?>
			</td>
			<td alt="<?=$t->tip("FCGI_ROLE")?>" title="<?=$t->tip("FCGI_ROLE")?>">
				<?=$t->field("FCGI_ROLE")?>
			</td>
			<td alt="<?=$t->tip("PHP_SELF")?>" title="<?=$t->tip("PHP_SELF")?>">
				<?=$t->field("PHP_SELF")?>
			</td>
			<td alt="<?=$t->tip("REQUEST_TIME_FLOAT")?>" title="<?=$t->tip("REQUEST_TIME_FLOAT")?>">
				<?=$t->field("REQUEST_TIME_FLOAT")?>
			</td>
			<td alt="<?=$t->tip("REQUEST_TIME")?>" title="<?=$t->tip("REQUEST_TIME")?>">
				<?=$t->field("REQUEST_TIME")?>
			</td>
			<td alt="<?=$t->tip("HTTP_REFERER")?>" title="<?=$t->tip("HTTP_REFERER")?>">
				<?=$t->field("HTTP_REFERER")?>
			</td>
			<td alt="<?=$t->tip("REQUEST_BODY")?>" title="<?=$t->tip("REQUEST_BODY")?>">
				<?=$t->field("REQUEST_BODY")?>
			</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$keys = $obj->toQueryStringKeys(array("requestid"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("requestid"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("USER"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("HOME"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("SCRIPT_NAME"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("REQUEST_URI"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("QUERY_STRING"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("REQUEST_METHOD"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("SERVER_PROTOCOL"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("GATEWAY_INTERFACE"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("REDIRECT_URL"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("REMOTE_PORT"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("SCRIPT_FILENAME"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("SERVER_ADMIN"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("CONTEXT_DOCUMENT_ROOT"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("CONTEXT_PREFIX"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("REQUEST_SCHEME"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("DOCUMENT_ROOT"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("REMOTE_ADDR"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("SERVER_PORT"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("SERVER_ADDR"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("SERVER_NAME"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("SERVER_SOFTWARE"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("SERVER_SIGNATURE"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("PATH"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("HTTP_PRAGMA"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("HTTP_COOKIE"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("HTTP_ACCEPT_LANGUAGE"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("HTTP_ACCEPT_ENCODING"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("HTTP_ACCEPT"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("HTTP_DNT"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("HTTP_USER_AGENT"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("HTTP_UPGRADE_INSECURE_REQUESTS"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("HTTP_CONNECTION"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("HTTP_HOST"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("UNIQUE_ID"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("REDIRECT_STATUS"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("REDIRECT_UNIQUE_ID"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("FCGI_ROLE"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("PHP_SELF"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("REQUEST_TIME_FLOAT"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("REQUEST_TIME"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("HTTP_REFERER"))?></td>
				<td>
					Texto
					[<a href="#" class="viewFullText" data-text="<?=$obj->get("REQUEST_BODY")?>">Ver</a>]
				</td>
				<td>
					<a class="view" href="/zion/mod/waf/RequestLog/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/waf/RequestLog/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>