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
			<td>server</td>
			<td>smtp_host</td>
			<td>smtp_port</td>
			<td>smtp_auth</td>
			<td>smtp_secure</td>
			<td>pop_host</td>
			<td>pop_port</td>
			<td>pop_secure</td>
			<td>status</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$key = $obj->concat(array("mandt","server"),":");
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
					<a class="view" href="/zion/mod/mail/Server/view/<?=$key?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/mail/Server/edit/<?=$key?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>