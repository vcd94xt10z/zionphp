<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("waf","IpLocation");
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
			<td alt="<?=$t->tip("type")?>" title="<?=$t->tip("type")?>">
				<?=$t->field("type")?>
			</td>
			<td alt="<?=$t->tip("continent_code")?>" title="<?=$t->tip("continent_code")?>">
				<?=$t->field("continent_code")?>
			</td>
			<td alt="<?=$t->tip("continent_name")?>" title="<?=$t->tip("continent_name")?>">
				<?=$t->field("continent_name")?>
			</td>
			<td alt="<?=$t->tip("country_code")?>" title="<?=$t->tip("country_code")?>">
				<?=$t->field("country_code")?>
			</td>
			<td alt="<?=$t->tip("country_name")?>" title="<?=$t->tip("country_name")?>">
				<?=$t->field("country_name")?>
			</td>
			<td alt="<?=$t->tip("region_code")?>" title="<?=$t->tip("region_code")?>">
				<?=$t->field("region_code")?>
			</td>
			<td alt="<?=$t->tip("region_name")?>" title="<?=$t->tip("region_name")?>">
				<?=$t->field("region_name")?>
			</td>
			<td alt="<?=$t->tip("city")?>" title="<?=$t->tip("city")?>">
				<?=$t->field("city")?>
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
				<td><?=TextFormatter::format("string",$obj->get("type"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("continent_code"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("continent_name"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("country_code"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("country_name"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("region_code"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("region_name"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("city"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("updated"))?></td>
				<td>
					<a class="view" href="/zion/mod/waf/IpLocation/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/waf/IpLocation/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>