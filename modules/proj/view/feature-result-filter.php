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
			<td>projid</td>
			<td>featid</td>
			<td>sequence</td>
			<td>name</td>
			<td>created_at</td>
			<td>created_by</td>
			<td>main_developer</td>
			<td>status</td>
			<td>released_to_test</td>
			<td>complexity</td>
			<td>version</td>
			<td>estimated_time</td>
			<td>url</td>
			<td>note</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$key = $obj->concat(array("mandt","projid","featid"),":");
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("projid"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("featid"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("sequence"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("name"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("created_at"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("created_by"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("main_developer"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("status"))?></td>
				<td><?=TextFormatter::format("boolean",$obj->get("released_to_test"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("complexity"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("version"))?></td>
				<td><?=TextFormatter::format("double",$obj->get("estimated_time"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("url"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("note"))?></td>
				<td>
					<a class="view" href="/zion/rest/proj/Feature/<?=$key?>/readonly" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/rest/proj/Feature/<?=$key?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>