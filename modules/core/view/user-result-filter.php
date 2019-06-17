<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("core","User");
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
			<td alt="<?=$t->tip("userid")?>" title="<?=$t->tip("userid")?>">
				<?=$t->field("userid")?>
			</td>
			<td alt="<?=$t->tip("login")?>" title="<?=$t->tip("login")?>">
				<?=$t->field("login")?>
			</td>
			<td alt="<?=$t->tip("password")?>" title="<?=$t->tip("password")?>">
				<?=$t->field("password")?>
			</td>
			<td alt="<?=$t->tip("perfil")?>" title="<?=$t->tip("perfil")?>">
				<?=$t->field("perfil")?>
			</td>
			<td alt="<?=$t->tip("force_new_password")?>" title="<?=$t->tip("force_new_password")?>">
				<?=$t->field("force_new_password")?>
			</td>
			<td alt="<?=$t->tip("redefine_password_hash")?>" title="<?=$t->tip("redefine_password_hash")?>">
				<?=$t->field("redefine_password_hash")?>
			</td>
			<td alt="<?=$t->tip("name")?>" title="<?=$t->tip("name")?>">
				<?=$t->field("name")?>
			</td>
			<td alt="<?=$t->tip("email")?>" title="<?=$t->tip("email")?>">
				<?=$t->field("email")?>
			</td>
			<td alt="<?=$t->tip("phone")?>" title="<?=$t->tip("phone")?>">
				<?=$t->field("phone")?>
			</td>
			<td alt="<?=$t->tip("docf")?>" title="<?=$t->tip("docf")?>">
				<?=$t->field("docf")?>
			</td>
			<td alt="<?=$t->tip("doce")?>" title="<?=$t->tip("doce")?>">
				<?=$t->field("doce")?>
			</td>
			<td alt="<?=$t->tip("docm")?>" title="<?=$t->tip("docm")?>">
				<?=$t->field("docm")?>
			</td>
			<td alt="<?=$t->tip("validity_begin")?>" title="<?=$t->tip("validity_begin")?>">
				<?=$t->field("validity_begin")?>
			</td>
			<td alt="<?=$t->tip("validity_end")?>" title="<?=$t->tip("validity_end")?>">
				<?=$t->field("validity_end")?>
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
				$keys = $obj->toQueryStringKeys(array("mandt","userid"));
				?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?=(++$n)?></td>
				<td><?=TextFormatter::format("integer",$obj->get("mandt"))?></td>
				<td><?=TextFormatter::format("integer",$obj->get("userid"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("login"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("password"))?></td>
				<td><?=TextFormatter::format("string",$obj->get("perfil"))?></td>
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
					<a class="view" href="/zion/mod/core/User/view/?<?=$keys?>" alt="Visualizar" title="Visualizar" target="_blank">
						<i class="fas fa-eye"></i>
					</a>
					<a class="edit" href="/zion/mod/core/User/edit/?<?=$keys?>" alt="Editar" title="Editar" target="_blank">
						<i class="fas fa-edit"></i>
					</a>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>