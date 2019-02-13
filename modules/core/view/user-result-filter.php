<?php
use zion\core\System;
use zion\utils\TextFormatter;
$objList = System::get("objList");
?>
<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered table-condensed">
		<thead>
		<tr>
			<td>userid</td>
			<td>login</td>
			<td>password</td>
			<td>force_new_password</td>
			<td>redefine_password_hash</td>
			<td>name</td>
			<td>email</td>
			<td>phone</td>
			<td>docf</td>
			<td>doce</td>
			<td>docm</td>
			<td>validity_begin</td>
			<td>validity_end</td>
			<td>status</td>
			<td>Opções</td>
		</tr>
		</thead>
		<tbody>
			<?foreach($objList AS $obj){?>
			<tr>
				<td><?=TextFormatter::format("integer",$obj->get("userid"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("login"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("password"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("force_new_password"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("redefine_password_hash"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("name"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("email"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("phone"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("docf"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("doce"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("docm"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("validity_begin"))?></td>
				<td><?=TextFormatter::format("datetime",$obj->get("validity_end"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("status"))?></td>
				<td>
					<a class="view" href="/zion/mod/core/User/view/<?=$obj->get("userid")?>/" alt="Visualizar" title="Visualizar" target="_blank">
						<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
					</a>
					<a class="view" href="/zion/mod/core/User/edit/<?=$obj->get("userid")?>/" alt="Editar" title="Editar" target="_blank">
						<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>