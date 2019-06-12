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
			<td>mandt</td>
			<td>user</td>
			<td>server</td>
			<td>date</td>
			<td>hour</td>
			<td>total</td>
			<td>updated_at</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$key = $obj->concat(array("mandt","user","server","date","hour"),":");
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("user"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("server"))?></td>
				<td><?=TextFormatter::format("date",$obj->get("date"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("hour"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("total"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("updated_at"))?></td>
				<td>
					<a class="view" href="/zion/mod/mail/MailQuota/view/<?=$key?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/mail/MailQuota/edit/<?=$key?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>