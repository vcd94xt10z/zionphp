<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("mail","SendLog");
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
			<td alt="<?=$t->tip("logid")?>" title="<?=$t->tip("logid")?>">
				<?=$t->field("logid")?>
			</td>
			<td alt="<?=$t->tip("created")?>" title="<?=$t->tip("created")?>">
				<?=$t->field("created")?>
			</td>
			<td alt="<?=$t->tip("server")?>" title="<?=$t->tip("server")?>">
				<?=$t->field("server")?>
			</td>
			<td alt="<?=$t->tip("user")?>" title="<?=$t->tip("user")?>">
				<?=$t->field("user")?>
			</td>
			<td alt="<?=$t->tip("from")?>" title="<?=$t->tip("from")?>">
				<?=$t->field("from")?>
			</td>
			<td alt="<?=$t->tip("to")?>" title="<?=$t->tip("to")?>">
				<?=$t->field("to")?>
			</td>
			<td alt="<?=$t->tip("subject")?>" title="<?=$t->tip("subject")?>">
				<?=$t->field("subject")?>
			</td>
			<td alt="<?=$t->tip("content_type")?>" title="<?=$t->tip("content_type")?>">
				<?=$t->field("content_type")?>
			</td>
			<td alt="<?=$t->tip("content_body_size")?>" title="<?=$t->tip("content_body_size")?>">
				<?=$t->field("content_body_size")?>
			</td>
			<td alt="<?=$t->tip("attachment_count")?>" title="<?=$t->tip("attachment_count")?>">
				<?=$t->field("attachment_count")?>
			</td>
			<td alt="<?=$t->tip("result")?>" title="<?=$t->tip("result")?>">
				<?=$t->field("result")?>
			</td>
			<td alt="<?=$t->tip("result_message")?>" title="<?=$t->tip("result_message")?>">
				<?=$t->field("result_message")?>
			</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$keys = $obj->toQueryStringKeys(array("mandt","logid"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("logid"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("created"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("server"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("user"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("from"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("to"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("subject"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("content_type"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("content_body_size"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("attachment_count"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("result"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("result_message"))?></td>
				<td>
					<a class="view" href="/zion/mod/mail/SendLog/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/mail/SendLog/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>