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
			<td>logid</td>
			<td>created</td>
			<td>server</td>
			<td>user</td>
			<td>from</td>
			<td>to</td>
			<td>subject</td>
			<td>content_type</td>
			<td>content_body_size</td>
			<td>attachment_count</td>
			<td>result</td>
			<td>result_message</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$key = $obj->concat(array("mandt","logid"),":");
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("logid"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("created"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("server"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("user"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("from"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("to"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("subject"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("content_type"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("content_body_size"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("attachment_count"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("result"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("result_message"))?></td>
				<td>
					<a class="view" href="/zion/mod/mail/MailSendLog/view/<?=$key?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/mail/MailSendLog/edit/<?=$key?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>