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
			<td><?=$t->field("lang")?></td>
			<td><?=$t->field("moduleid")?></td>
			<td><?=$t->field("entityid")?></td>
			<td><?=$t->field("field")?></td>
			<td><?=$t->field("short_text")?></td>
			<td><?=$t->field("medium_text")?></td>
			<td><?=$t->field("full_text")?></td>
			<td><?=$t->field("tip")?></td>
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
				<td><?=TextFormatter::format("string",$obj->get("short_text"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("medium_text"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("full_text"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("tip"))?></td>
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