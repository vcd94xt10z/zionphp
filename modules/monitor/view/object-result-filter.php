<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("monitor","Object");
$objList = System::get("objList");
?>
<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered table-sm">
		<thead>
		<tr>
			<td><input type="checkbox"></td>
			<td>#</td>
			<td alt="<?=$t->tip("objectid")?>" title="<?=$t->tip("objectid")?>">
				<?=$t->field("objectid")?>
			</td>
			<td alt="<?=$t->tip("name")?>" title="<?=$t->tip("name")?>">
				<?=$t->field("name")?>
			</td>
			<td alt="<?=$t->tip("created")?>" title="<?=$t->tip("created")?>">
				<?=$t->field("created")?>
			</td>
			<td alt="<?=$t->tip("type")?>" title="<?=$t->tip("type")?>">
				<?=$t->field("type")?>
			</td>
			<td alt="<?=$t->tip("url")?>" title="<?=$t->tip("url")?>">
				<?=$t->field("url")?>
			</td>
			<td alt="<?=$t->tip("interval")?>" title="<?=$t->tip("interval")?>">
				<?=$t->field("interval")?>
			</td>
			<td alt="<?=$t->tip("status")?>" title="<?=$t->tip("status")?>">
				<?=$t->field("status")?>
			</td>
			<td alt="<?=$t->tip("last_check")?>" title="<?=$t->tip("last_check")?>">
				<?=$t->field("last_check")?>
			</td>
			<td alt="<?=$t->tip("notify_by_email")?>" title="<?=$t->tip("notify_by_email")?>">
				<?=$t->field("notify_by_email")?>
			</td>
			<td alt="<?=$t->tip("notify_by_sms")?>" title="<?=$t->tip("notify_by_sms")?>">
				<?=$t->field("notify_by_sms")?>
			</td>
			<td alt="<?=$t->tip("notify_by_tts")?>" title="<?=$t->tip("notify_by_tts")?>">
				<?=$t->field("notify_by_tts")?>
			</td>
			<td alt="<?=$t->tip("notify_email")?>" title="<?=$t->tip("notify_email")?>">
				<?=$t->field("notify_email")?>
			</td>
			<td alt="<?=$t->tip("notify_phone")?>" title="<?=$t->tip("notify_phone")?>">
				<?=$t->field("notify_phone")?>
			</td>
			<td alt="<?=$t->tip("sound_enabled")?>" title="<?=$t->tip("sound_enabled")?>">
				<?=$t->field("sound_enabled")?>
			</td>
			<td alt="<?=$t->tip("enabled")?>" title="<?=$t->tip("enabled")?>">
				<?=$t->field("enabled")?>
			</td>
			<td alt="<?=$t->tip("counter_success")?>" title="<?=$t->tip("counter_success")?>">
				<?=$t->field("counter_success")?>
			</td>
			<td alt="<?=$t->tip("counter_error")?>" title="<?=$t->tip("counter_error")?>">
				<?=$t->field("counter_error")?>
			</td>
			<td alt="<?=$t->tip("counter_timeout")?>" title="<?=$t->tip("counter_timeout")?>">
				<?=$t->field("counter_timeout")?>
			</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$keys = $obj->toQueryStringKeys(array("objectid"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("string",$obj->get("objectid"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("name"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("created"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("type"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("url"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("interval"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("status"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("last_check"))?></td>
				<td><?=TextFormatter::format("boolean",$obj->get("notify_by_email"))?></td>
				<td><?=TextFormatter::format("boolean",$obj->get("notify_by_sms"))?></td>
				<td><?=TextFormatter::format("boolean",$obj->get("notify_by_tts"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("notify_email"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("notify_phone"))?></td>
				<td><?=TextFormatter::format("boolean",$obj->get("sound_enabled"))?></td>
				<td><?=TextFormatter::format("boolean",$obj->get("enabled"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("counter_success"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("counter_error"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("counter_timeout"))?></td>
				<td>
					<a class="view" href="/zion/mod/monitor/Object/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/monitor/Object/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>