<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("post","Page");
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
			<td alt="<?=$t->tip("pageid")?>" title="<?=$t->tip("pageid")?>">
				<?=$t->field("pageid")?>
			</td>
			<td alt="<?=$t->tip("rewrite")?>" title="<?=$t->tip("rewrite")?>">
				<?=$t->field("rewrite")?>
			</td>
			<td alt="<?=$t->tip("title")?>" title="<?=$t->tip("title")?>">
				<?=$t->field("title")?>
			</td>
			<td alt="<?=$t->tip("categoryid")?>" title="<?=$t->tip("categoryid")?>">
				<?=$t->field("categoryid")?>
			</td>
			<td alt="<?=$t->tip("content_html")?>" title="<?=$t->tip("content_html")?>">
				<?=$t->field("content_html")?>
			</td>
			<td alt="<?=$t->tip("created_at")?>" title="<?=$t->tip("created_at")?>">
				<?=$t->field("created_at")?>
			</td>
			<td alt="<?=$t->tip("created_by")?>" title="<?=$t->tip("created_by")?>">
				<?=$t->field("created_by")?>
			</td>
			<td alt="<?=$t->tip("updated_at")?>" title="<?=$t->tip("updated_at")?>">
				<?=$t->field("updated_at")?>
			</td>
			<td alt="<?=$t->tip("updated_by")?>" title="<?=$t->tip("updated_by")?>">
				<?=$t->field("updated_by")?>
			</td>
			<td alt="<?=$t->tip("meta_description")?>" title="<?=$t->tip("meta_description")?>">
				<?=$t->field("meta_description")?>
			</td>
			<td alt="<?=$t->tip("meta_keywords")?>" title="<?=$t->tip("meta_keywords")?>">
				<?=$t->field("meta_keywords")?>
			</td>
			<td alt="<?=$t->tip("http_status")?>" title="<?=$t->tip("http_status")?>">
				<?=$t->field("http_status")?>
			</td>
			<td alt="<?=$t->tip("cache_maxage")?>" title="<?=$t->tip("cache_maxage")?>">
				<?=$t->field("cache_maxage")?>
			</td>
			<td alt="<?=$t->tip("cache_smaxage")?>" title="<?=$t->tip("cache_smaxage")?>">
				<?=$t->field("cache_smaxage")?>
			</td>
			<td alt="<?=$t->tip("use_template")?>" title="<?=$t->tip("use_template")?>">
				<?=$t->field("use_template")?>
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
				<td><?=TextFormatter::format("integer",$obj->get("http_status"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("cache_maxage"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("cache_smaxage"))?></td>
				<td><?=TextFormatter::format("boolean",$obj->get("use_template"))?></td>
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