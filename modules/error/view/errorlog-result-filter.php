<?php
use zion\core\System;
use zion\utils\TextFormatter;
$objList = System::get("objList");
?>
<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered table-sm">
		<thead>
		<tr>
			<td>errorid</td>
			<td>type</td>
			<td>created</td>
			<td>duration</td>
			<td>http_ipaddr</td>
			<td>Requisição</td>
			<td>level</td>
			<td>code</td>
			<td>Message</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?foreach($objList AS $obj){?>
			<tr>
				<td><?=TextFormatter::format("string",$obj->get("errorid"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("type"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("created"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("duration"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("http_ipaddr"))?></td>
				<td>
					<?=TextFormatter::format("string",$obj->get("http_method"))?>
					<?=TextFormatter::format("string",$obj->get("http_uri"))?>
				</td>
				<td><?=TextFormatter::format("string",$obj->get("level"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("code"))?></td>
				<td>
					<?if($obj->get("input") != ""){?>
					<div><?=TextFormatter::format("string",$obj->get("input"))?></div>
					<br>
					<?}?>
					
					<div><?=TextFormatter::format("string",$obj->get("message"))?></div>
					<pre><?=TextFormatter::format("string",$obj->get("stack"))?></pre>
					
					<div>
						File <?=TextFormatter::format("string",$obj->get("file"))?> on 
						<?=TextFormatter::format("integer",$obj->get("line"))?>
					</div>
				</td>
				<td>
					<a class="table-link" href="/zion/rest/error/ErrorLog/readonly/<?=$obj->get("errorid")?>/" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="table-link" href="/zion/rest/error/ErrorLog//<?=$obj->get("errorid")?>/" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>