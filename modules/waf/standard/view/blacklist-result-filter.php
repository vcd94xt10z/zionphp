<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("waf","BlackList");
$objList = System::get("objList");
?>
<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered table-sm">
		<thead>
		<tr>
			<td><input type="checkbox"></td>
			<td>#</td>
			<td alt="<?=$t->tip("ipaddr")?>" title="<?=$t->tip("ipaddr")?>">
				<?=$t->field("ipaddr")?>
			</td>
			<td alt="<?=$t->tip("created")?>" title="<?=$t->tip("created")?>">
				<?=$t->field("created")?>
			</td>
			<td alt="<?=$t->tip("user_agent")?>" title="<?=$t->tip("user_agent")?>">
				<?=$t->field("user_agent")?>
			</td>
			<td alt="<?=$t->tip("request_uri")?>" title="<?=$t->tip("request_uri")?>">
				<?=$t->field("request_uri")?>
			</td>
			<td alt="<?=$t->tip("server_name")?>" title="<?=$t->tip("server_name")?>">
				<?=$t->field("server_name")?>
			</td>
			<td alt="<?=$t->tip("hits")?>" title="<?=$t->tip("hits")?>">
				<?=$t->field("hits")?>
			</td>
			<td alt="<?=$t->tip("policy")?>" title="<?=$t->tip("policy")?>">
				<?=$t->field("policy")?>
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
				$keys = $obj->toQueryStringKeys(array("ipaddr"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("string",$obj->get("ipaddr"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("created"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("user_agent"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("request_uri"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("server_name"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("hits"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("policy"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("updated"))?></td>
				<td>
					<a class="view" href="/zion/mod/waf/BlackList/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/waf/BlackList/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>