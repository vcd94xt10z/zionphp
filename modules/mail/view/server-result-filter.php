<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("mail","Server");
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
			<td alt="<?=$t->tip("server")?>" title="<?=$t->tip("server")?>">
				<?=$t->field("server")?>
			</td>
			<td alt="<?=$t->tip("smtp_host")?>" title="<?=$t->tip("smtp_host")?>">
				<?=$t->field("smtp_host")?>
			</td>
			<td alt="<?=$t->tip("smtp_port")?>" title="<?=$t->tip("smtp_port")?>">
				<?=$t->field("smtp_port")?>
			</td>
			<td alt="<?=$t->tip("smtp_auth")?>" title="<?=$t->tip("smtp_auth")?>">
				<?=$t->field("smtp_auth")?>
			</td>
			<td alt="<?=$t->tip("smtp_secure")?>" title="<?=$t->tip("smtp_secure")?>">
				<?=$t->field("smtp_secure")?>
			</td>
			<td alt="<?=$t->tip("pop_host")?>" title="<?=$t->tip("pop_host")?>">
				<?=$t->field("pop_host")?>
			</td>
			<td alt="<?=$t->tip("pop_port")?>" title="<?=$t->tip("pop_port")?>">
				<?=$t->field("pop_port")?>
			</td>
			<td alt="<?=$t->tip("pop_secure")?>" title="<?=$t->tip("pop_secure")?>">
				<?=$t->field("pop_secure")?>
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
				$keys = $obj->toQueryStringKeys(array("mandt","server"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("server"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("smtp_host"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("smtp_port"))?></td>
				<td><?=TextFormatter::format("boolean",$obj->get("smtp_auth"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("smtp_secure"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("pop_host"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("pop_port"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("pop_secure"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("status"))?></td>
				<td>
					<a class="view" href="/zion/mod/mail/Server/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/mail/Server/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>