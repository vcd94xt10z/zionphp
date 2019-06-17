<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("builder","Text");
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
			<td alt="<?=$t->tip("lang")?>" title="<?=$t->tip("lang")?>">
				<?=$t->field("lang")?>
			</td>
			<td alt="<?=$t->tip("moduleid")?>" title="<?=$t->tip("moduleid")?>">
				<?=$t->field("moduleid")?>
			</td>
			<td alt="<?=$t->tip("entityid")?>" title="<?=$t->tip("entityid")?>">
				<?=$t->field("entityid")?>
			</td>
			<td alt="<?=$t->tip("field")?>" title="<?=$t->tip("field")?>">
				<?=$t->field("field")?>
			</td>
			<td alt="<?=$t->tip("short_text")?>" title="<?=$t->tip("short_text")?>">
				<?=$t->field("short_text")?>
			</td>
			<td alt="<?=$t->tip("medium_text")?>" title="<?=$t->tip("medium_text")?>">
				<?=$t->field("medium_text")?>
			</td>
			<td alt="<?=$t->tip("full_text")?>" title="<?=$t->tip("full_text")?>">
				<?=$t->field("full_text")?>
			</td>
			<td alt="<?=$t->tip("tip")?>" title="<?=$t->tip("tip")?>">
				<?=$t->field("tip")?>
			</td>
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