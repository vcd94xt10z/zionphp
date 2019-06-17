<?php
use zion\core\System;
use zion\utils\TextFormatter;
$t = System::get("entityTexts");
$objList = System::get("objList");
?>
<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered table-sm">
		<thead>
		<tr>
			<td><input type="checkbox"></td>
			<td>#</td>
			<td><?=$t->field("mandt")?></td>
			<td><?=$t->field("server")?></td>
			<td><?=$t->field("smtp_host")?></td>
			<td><?=$t->field("smtp_port")?></td>
			<td><?=$t->field("smtp_auth")?></td>
			<td><?=$t->field("smtp_secure")?></td>
			<td><?=$t->field("pop_host")?></td>
			<td><?=$t->field("pop_port")?></td>
			<td><?=$t->field("pop_secure")?></td>
			<td><?=$t->field("status")?></td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$keys = $obj->toQueryStringKeys(array("mandt","server"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("server"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("smtp_host"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("smtp_port"))?></td>
				<td><?=TextFormatter::format("boolean",$obj->get("smtp_auth"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("smtp_secure"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("pop_host"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("pop_port"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("pop_secure"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("status"))?></td>
				<td>
					<a class="view" href="/zion/mod/mail/Server/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/mail/Server/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>