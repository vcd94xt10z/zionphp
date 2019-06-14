<?php
use zion\core\System;
use zion\utils\TextFormatter;
$objList = System::get("objList");
?>
<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered table-sm">
		<thead>
		<tr>
			<td><input type="checkbox"></td>
			<td>#</td>
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
			<td>status</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$keys = $obj->toQueryStringKeys(array("errorid"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("string",$obj->get("errorid"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("type"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("created"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("duration"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("http_ipaddr"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("http_method"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("http_uri"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("level"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("code"))?></td>
				<td>
					Texto
					[<a href="#" class="viewFullText" data-text="<?=$obj->get("message")?>">Ver</a>]
				</td>
				<td>
					Texto
					[<a href="#" class="viewFullText" data-text="<?=$obj->get("stack")?>">Ver</a>]
				</td>
				<td>
					Texto
					[<a href="#" class="viewFullText" data-text="<?=$obj->get("input")?>">Ver</a>]
				</td>
				<td><?=TextFormatter::format("string",$obj->get("file"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("line"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("status"))?></td>
				<td>
					<a class="view" href="/zion/mod/error/Log/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/error/Log/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>