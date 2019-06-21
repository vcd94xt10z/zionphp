<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("mail","Quota");
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
			<td alt="<?=$t->tip("user")?>" title="<?=$t->tip("user")?>">
				<?=$t->field("user")?>
			</td>
			<td alt="<?=$t->tip("server")?>" title="<?=$t->tip("server")?>">
				<?=$t->field("server")?>
			</td>
			<td alt="<?=$t->tip("date")?>" title="<?=$t->tip("date")?>">
				<?=$t->field("date")?>
			</td>
			<td alt="<?=$t->tip("hour")?>" title="<?=$t->tip("hour")?>">
				<?=$t->field("hour")?>
			</td>
			<td alt="<?=$t->tip("total")?>" title="<?=$t->tip("total")?>">
				<?=$t->field("total")?>
			</td>
			<td alt="<?=$t->tip("updated_at")?>" title="<?=$t->tip("updated_at")?>">
				<?=$t->field("updated_at")?>
			</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$keys = $obj->toQueryStringKeys(array("mandt","user","server","date","hour"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("user"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("server"))?></td>
				<td><?=TextFormatter::format("date",$obj->get("date"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("hour"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("total"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("updated_at"))?></td>
				<td>
					<a class="view" href="/zion/mod/mail/Quota/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/mail/Quota/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>