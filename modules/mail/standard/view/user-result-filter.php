<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("mail","User");
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
			<td alt="<?=$t->tip("password")?>" title="<?=$t->tip("password")?>">
				<?=$t->field("password")?>
			</td>
			<td alt="<?=$t->tip("server")?>" title="<?=$t->tip("server")?>">
				<?=$t->field("server")?>
			</td>
			<td alt="<?=$t->tip("status")?>" title="<?=$t->tip("status")?>">
				<?=$t->field("status")?>
			</td>
			<td alt="<?=$t->tip("hourly_quota")?>" title="<?=$t->tip("hourly_quota")?>">
				<?=$t->field("hourly_quota")?>
			</td>
			<td alt="<?=$t->tip("daily_quota")?>" title="<?=$t->tip("daily_quota")?>">
				<?=$t->field("daily_quota")?>
			</td>
			<td alt="<?=$t->tip("sent_success")?>" title="<?=$t->tip("sent_success")?>">
				<?=$t->field("sent_success")?>
			</td>
			<td alt="<?=$t->tip("sent_error")?>" title="<?=$t->tip("sent_error")?>">
				<?=$t->field("sent_error")?>
			</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$keys = $obj->toQueryStringKeys(array("mandt","user"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("user"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("password"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("server"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("status"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("hourly_quota"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("daily_quota"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("sent_success"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("sent_error"))?></td>
				<td>
					<a class="view" href="/zion/mod/mail/User/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/mail/User/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>