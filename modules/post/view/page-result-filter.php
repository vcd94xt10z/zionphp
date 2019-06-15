<?php
use zion\core\System;
use zion\utils\TextFormatter;
$objList = System::get("objList");
?>
<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered table-sm">
		<thead>
		<tr>
			<td><input type="checkbox"></td>
			<td>#</td>
			<td>mandt</td>
			<td>pageid</td>
			<td>rewrite</td>
			<td>title</td>
			<td>categoryid</td>
			<td>content_html</td>
			<td>created_at</td>
			<td>created_by</td>
			<td>updated_at</td>
			<td>updated_by</td>
			<td>meta_description</td>
			<td>meta_keywords</td>
			<td>status</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?
			foreach($objList AS $obj){
				$keys = $obj->toQueryStringKeys(array("mandt","pageid"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("pageid"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("rewrite"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("title"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("categoryid"))?></td>
				<td>
					Texto
					[<a href="#" class="viewFullText" data-text="<?=$obj->get("content_html")?>">Ver</a>]
				</td>
				<td><?=TextFormatter::format("datetime",$obj->get("created_at"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("created_by"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("updated_at"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("updated_by"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("meta_description"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("meta_keywords"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("status"))?></td>
				<td>
					<a class="view" href="/zion/mod/post/Page/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/post/Page/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>