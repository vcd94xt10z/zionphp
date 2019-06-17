<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("proj","Feature");
$objList = System::get("objList");
?>
<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered table-sm">
		<thead>
		<tr>
			<td><input type="checkbox"></td>
			<td>#</td>
			<td alt="<?=$t->tip("mandt")?>" title="<?=$t->tip("mandt")?>">
				<?=$t->field("mandt")?>
			</td>
			<td alt="<?=$t->tip("projid")?>" title="<?=$t->tip("projid")?>">
				<?=$t->field("projid")?>
			</td>
			<td alt="<?=$t->tip("featid")?>" title="<?=$t->tip("featid")?>">
				<?=$t->field("featid")?>
			</td>
			<td alt="<?=$t->tip("sequence")?>" title="<?=$t->tip("sequence")?>">
				<?=$t->field("sequence")?>
			</td>
			<td alt="<?=$t->tip("name")?>" title="<?=$t->tip("name")?>">
				<?=$t->field("name")?>
			</td>
			<td alt="<?=$t->tip("created_at")?>" title="<?=$t->tip("created_at")?>">
				<?=$t->field("created_at")?>
			</td>
			<td alt="<?=$t->tip("created_by")?>" title="<?=$t->tip("created_by")?>">
				<?=$t->field("created_by")?>
			</td>
			<td alt="<?=$t->tip("main_developer")?>" title="<?=$t->tip("main_developer")?>">
				<?=$t->field("main_developer")?>
			</td>
			<td alt="<?=$t->tip("status")?>" title="<?=$t->tip("status")?>">
				<?=$t->field("status")?>
			</td>
			<td alt="<?=$t->tip("released_to_test")?>" title="<?=$t->tip("released_to_test")?>">
				<?=$t->field("released_to_test")?>
			</td>
			<td alt="<?=$t->tip("complexity")?>" title="<?=$t->tip("complexity")?>">
				<?=$t->field("complexity")?>
			</td>
			<td alt="<?=$t->tip("version")?>" title="<?=$t->tip("version")?>">
				<?=$t->field("version")?>
			</td>
			<td alt="<?=$t->tip("estimated_time")?>" title="<?=$t->tip("estimated_time")?>">
				<?=$t->field("estimated_time")?>
			</td>
			<td alt="<?=$t->tip("url")?>" title="<?=$t->tip("url")?>">
				<?=$t->field("url")?>
			</td>
			<td alt="<?=$t->tip("note")?>" title="<?=$t->tip("note")?>">
				<?=$t->field("note")?>
			</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$keys = $obj->toQueryStringKeys(array("mandt","projid","featid"));
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
					<a class="view" href="/zion/mod/proj/Feature/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/proj/Feature/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>