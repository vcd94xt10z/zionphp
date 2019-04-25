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
			<td>objectid</td>
			<td>created</td>
			<td>type</td>
			<td>url</td>
			<td>interval</td>
			<td>status</td>
			<td>last_check</td>
			<td>notify_by_email</td>
			<td>notify_by_sms</td>
			<td>notify_by_sound</td>
			<td>notify_email</td>
			<td>notify_phone</td>
			<td>notify_sound</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$key = $obj->concat(array("objectid"),":");
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("string",$obj->get("objectid"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("created"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("type"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("url"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("interval"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("status"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("last_check"))?></td>
				<td><?=TextFormatter::format("boolean",$obj->get("notify_by_email"))?></td>
				<td><?=TextFormatter::format("boolean",$obj->get("notify_by_sms"))?></td>
				<td><?=TextFormatter::format("boolean",$obj->get("notify_by_sound"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("notify_email"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("notify_phone"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("notify_sound"))?></td>
				<td>
					<a class="view" href="/zion/rest/monitor/Object/<?=$key?>/readonly" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/rest/monitor/Object/<?=$key?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>