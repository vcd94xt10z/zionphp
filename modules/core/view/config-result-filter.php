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
			<td>env</td>
			<td>category</td>
			<td>group</td>
			<td>name</td>
			<td>value</td>
			<td>created</td>
			<td>updated</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$key = $obj->concat(array("mandt","env","category","group","name"),":");
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("env"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("category"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("group"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("name"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("value"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("created"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("updated"))?></td>
				<td>
					<a class="view" href="/zion/rest/core/Config/<?=$key?>/readonly" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/rest/core/Config/<?=$key?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>