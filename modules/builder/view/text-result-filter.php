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
			<td>lang</td>
			<td>moduleid</td>
			<td>entityid</td>
			<td>field</td>
			<td>text</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$keys = $obj->toQueryStringKeys(array("mandt","lang","moduleid","entityid","field"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("lang"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("moduleid"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("entityid"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("field"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("text"))?></td>
				<td>
					<a class="view" href="/zion/mod/builder/Text/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/builder/Text/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>