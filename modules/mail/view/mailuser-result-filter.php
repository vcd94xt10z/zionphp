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
			<td>password</td>
			<td>server</td>
			<td>status</td>
			<td>hourly_quota</td>
			<td>daily_quota</td>
			<td>sent_success</td>
			<td>sent_error</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$key = $obj->concat(array("mandt","user"),":");
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("user"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("password"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("server"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("status"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("hourly_quota"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("daily_quota"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("sent_success"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("sent_error"))?></td>
				<td>
					<a class="view" href="/zion/mod/mail/MailUser/view/<?=$key?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/mail/MailUser/edit/<?=$key?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>