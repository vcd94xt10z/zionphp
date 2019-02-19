<?php
use zion\core\System;
use zion\utils\TextFormatter;
$objList = System::get("objList");
?>
<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered table-sm">
		<thead>
		<tr>
			<td>errorid</td>
			<td>type</td>
			<td>created</td>
			<td>duration</td>
			<td>http_ipaddr</td>
			<td>http_method</td>
			<td>http_uri</td>
			<td>level</td>
			<td>code</td>
			<td>message</td>
			<td>stack</td>
			<td>input</td>
			<td>file</td>
			<td>line</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$key = $obj->concat(array("errorid"),"|");
				?>
			<tr>
				<td><?=TextFormatter::format("string",$obj->get("errorid"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("type"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("created"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("duration"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("http_ipaddr"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("http_method"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("http_uri"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("level"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("code"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("message"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("stack"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("input"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("file"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("line"))?></td>
				<td>
					<a class="view" href="/zion/rest/error/ErrorLog/<?=$key?>/readonly" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/rest/error/ErrorLog/<?=$key?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>