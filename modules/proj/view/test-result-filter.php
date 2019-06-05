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
			<td>version</td>
			<td>testid</td>
			<td>test_at</td>
			<td>test_by</td>
			<td>result</td>
			<td>device</td>
			<td>browser</td>
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
				<td><?=TextFormatter::format("integer",$obj->get("version"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("testid"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("test_at"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("test_by"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("result"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("device"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("browser"))?></td>
				<td>
					<a class="view" href="/zion/rest/proj/Test/<?=$key?>/readonly" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/rest/proj/Test/<?=$key?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>