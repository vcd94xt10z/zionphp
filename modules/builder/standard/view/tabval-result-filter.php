<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("builder","Tabval");
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
			<td alt="<?=$t->tip("name")?>" title="<?=$t->tip("name")?>">
				<?=$t->field("name")?>
			</td>
			<td alt="<?=$t->tip("key")?>" title="<?=$t->tip("key")?>">
				<?=$t->field("key")?>
			</td>
			<td alt="<?=$t->tip("value")?>" title="<?=$t->tip("value")?>">
				<?=$t->field("value")?>
			</td>
			<td alt="<?=$t->tip("sequence")?>" title="<?=$t->tip("sequence")?>">
				<?=$t->field("sequence")?>
			</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$keys = $obj->toQueryStringKeys(array("mandt","name","key"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("name"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("key"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("value"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("sequence"))?></td>
				<td>
					<a class="view" href="/zion/mod/builder/Tabval/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/builder/Tabval/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>