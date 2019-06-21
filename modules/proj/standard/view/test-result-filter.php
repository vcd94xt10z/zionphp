<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("proj","Test");
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
			<td alt="<?=$t->tip("version")?>" title="<?=$t->tip("version")?>">
				<?=$t->field("version")?>
			</td>
			<td alt="<?=$t->tip("testid")?>" title="<?=$t->tip("testid")?>">
				<?=$t->field("testid")?>
			</td>
			<td alt="<?=$t->tip("test_at")?>" title="<?=$t->tip("test_at")?>">
				<?=$t->field("test_at")?>
			</td>
			<td alt="<?=$t->tip("test_by")?>" title="<?=$t->tip("test_by")?>">
				<?=$t->field("test_by")?>
			</td>
			<td alt="<?=$t->tip("result")?>" title="<?=$t->tip("result")?>">
				<?=$t->field("result")?>
			</td>
			<td alt="<?=$t->tip("device")?>" title="<?=$t->tip("device")?>">
				<?=$t->field("device")?>
			</td>
			<td alt="<?=$t->tip("browser")?>" title="<?=$t->tip("browser")?>">
				<?=$t->field("browser")?>
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
				<td><?=TextFormatter::format("integer",$obj->get("version"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("testid"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("test_at"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("test_by"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("result"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("device"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("browser"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("note"))?></td>
				<td>
					<a class="view" href="/zion/mod/proj/Test/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/proj/Test/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>