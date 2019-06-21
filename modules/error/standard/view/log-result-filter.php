<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("error","Log");
$objList = System::get("objList");
?>
<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered table-sm">
		<thead>
		<tr>
			<td><input type="checkbox"></td>
			<td>#</td>
			<td alt="<?=$t->tip("errorid")?>" title="<?=$t->tip("errorid")?>">
				<?=$t->field("errorid")?>
			</td>
			<td alt="<?=$t->tip("type")?>" title="<?=$t->tip("type")?>">
				<?=$t->field("type")?>
			</td>
			<td alt="<?=$t->tip("created")?>" title="<?=$t->tip("created")?>">
				<?=$t->field("created")?>
			</td>
			<td alt="<?=$t->tip("duration")?>" title="<?=$t->tip("duration")?>">
				<?=$t->field("duration")?>
			</td>
			<td alt="<?=$t->tip("http_ipaddr")?>" title="<?=$t->tip("http_ipaddr")?>">
				<?=$t->field("http_ipaddr")?>
			</td>
			<td alt="<?=$t->tip("http_method")?>" title="<?=$t->tip("http_method")?>">
				<?=$t->field("http_method")?>
			</td>
			<td alt="<?=$t->tip("http_uri")?>" title="<?=$t->tip("http_uri")?>">
				<?=$t->field("http_uri")?>
			</td>
			<td alt="<?=$t->tip("level")?>" title="<?=$t->tip("level")?>">
				<?=$t->field("level")?>
			</td>
			<td alt="<?=$t->tip("code")?>" title="<?=$t->tip("code")?>">
				<?=$t->field("code")?>
			</td>
			<td alt="<?=$t->tip("message")?>" title="<?=$t->tip("message")?>">
				<?=$t->field("message")?>
			</td>
			<td alt="<?=$t->tip("stack")?>" title="<?=$t->tip("stack")?>">
				<?=$t->field("stack")?>
			</td>
			<td alt="<?=$t->tip("input")?>" title="<?=$t->tip("input")?>">
				<?=$t->field("input")?>
			</td>
			<td alt="<?=$t->tip("file")?>" title="<?=$t->tip("file")?>">
				<?=$t->field("file")?>
			</td>
			<td alt="<?=$t->tip("line")?>" title="<?=$t->tip("line")?>">
				<?=$t->field("line")?>
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
				$keys = $obj->toQueryStringKeys(array("errorid"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("string",$obj->get("errorid"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("type"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("created"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("duration"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("http_ipaddr"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("http_method"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("http_uri"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("level"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("code"))?></td>
				<td>
					Texto
					[<a href="#" class="viewFullText" data-text="<?=$obj->get("message")?>">Ver</a>]
				</td>
				<td>
					Texto
					[<a href="#" class="viewFullText" data-text="<?=$obj->get("stack")?>">Ver</a>]
				</td>
				<td>
					Texto
					[<a href="#" class="viewFullText" data-text="<?=$obj->get("input")?>">Ver</a>]
				</td>
				<td><?=TextFormatter::format("string",$obj->get("file"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("line"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("status"))?></td>
				<td>
					<a class="view" href="/zion/mod/error/Log/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/error/Log/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>