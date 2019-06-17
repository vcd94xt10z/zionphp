<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("core","Module");
$objList = System::get("objList");
?>
<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered table-sm">
		<thead>
		<tr>
			<td><input type="checkbox"></td>
			<td>#</td>
			<td alt="<?=$t->tip("moduleid")?>" title="<?=$t->tip("moduleid")?>">
				<?=$t->field("moduleid")?>
			</td>
			<td alt="<?=$t->tip("name")?>" title="<?=$t->tip("name")?>">
				<?=$t->field("name")?>
			</td>
			<td alt="<?=$t->tip("category")?>" title="<?=$t->tip("category")?>">
				<?=$t->field("category")?>
			</td>
			<td alt="<?=$t->tip("description")?>" title="<?=$t->tip("description")?>">
				<?=$t->field("description")?>
			</td>
			<td alt="<?=$t->tip("created")?>" title="<?=$t->tip("created")?>">
				<?=$t->field("created")?>
			</td>
			<td alt="<?=$t->tip("updated")?>" title="<?=$t->tip("updated")?>">
				<?=$t->field("updated")?>
			</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$keys = $obj->toQueryStringKeys(array("moduleid"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("string",$obj->get("moduleid"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("name"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("category"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("description"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("created"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("updated"))?></td>
				<td>
					<a class="view" href="/zion/mod/core/Module/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/core/Module/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>