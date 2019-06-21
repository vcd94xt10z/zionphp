<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("post","Category");
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
			<td alt="<?=$t->tip("categoryid")?>" title="<?=$t->tip("categoryid")?>">
				<?=$t->field("categoryid")?>
			</td>
			<td alt="<?=$t->tip("parentid")?>" title="<?=$t->tip("parentid")?>">
				<?=$t->field("parentid")?>
			</td>
			<td alt="<?=$t->tip("name")?>" title="<?=$t->tip("name")?>">
				<?=$t->field("name")?>
			</td>
			<td alt="<?=$t->tip("created_at")?>" title="<?=$t->tip("created_at")?>">
				<?=$t->field("created_at")?>
			</td>
			<td alt="<?=$t->tip("updated_at")?>" title="<?=$t->tip("updated_at")?>">
				<?=$t->field("updated_at")?>
			</td>
			<td alt="<?=$t->tip("status")?>" title="<?=$t->tip("status")?>">
				<?=$t->field("status")?>
			</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$keys = $obj->toQueryStringKeys(array("mandt","categoryid"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("categoryid"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("parentid"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("name"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("created_at"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("updated_at"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("status"))?></td>
				<td>
					<a class="view" href="/zion/mod/post/Category/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/post/Category/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>