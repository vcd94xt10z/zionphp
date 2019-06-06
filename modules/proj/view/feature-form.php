<?php
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\proj\model\ProjectUtils;
$obj = System::get("obj");
$action = System::get("action");
$method = ($action == "edit")?"PUT":"POST";

if($obj->get("created_at") == null){
    $obj->set("created_at",new DateTime());
}
?>
<div class="center-content form-page">
<div class="container-fluid">

	<form class="form-horizontal ajaxform form-<?=$action?>" action="/zion/rest/proj/Feature/" method="<?=$method?>" data-callback="defaultRegisterCallback">
		<input id="obj[mandt]" name="obj[mandt]" type="hidden" value="<?=$obj->get("mandt")?>">
		<input id="obj[projid]" name="obj[projid]" type="hidden" value="<?=$obj->get("projid")?>">
		
		<br>
		<div class="card">
			<div class="card-header">
				Formulário
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-3">
						<label class="pk required control-label" for="obj[featid]">Id</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[featid]" name="obj[featid]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("featid"))?>" required readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[name]">Nome</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[name]" name="obj[name]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("name"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[sequence]">Sequência</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[sequence]" name="obj[sequence]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("sequence"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="required control-label" for="obj[created_at]">Criado em</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[created_at]" name="obj[created_at]" type="text" class="form-control type-datetime" value="<?=TextFormatter::format("datetime",$obj->get("created_at"))?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[created_by]">Criado por</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[created_by]" name="obj[created_by]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("created_by"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[main_developer]">Desenvolvedor Principal</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[main_developer]" name="obj[main_developer]" type="text" class="form-control type-string" value="<?=TextFormatter::format("string",$obj->get("main_developer"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[status]">Status</label>
					</div>
					<div class="col-sm-5">
						<select id="obj[status]" name="obj[status]" class="form-control">
							<option value=""></option>
							<?
							foreach(ProjectUtils::$featureStatus AS $key => $value){
							    $SELECTED = "";
							    if($key == $obj->get("status")){
							        $SELECTED = " SELECTED";
							    }
							?>
							<option value="<?=$key?>"<?=$SELECTED?>><?=$value["label"]?></option>
							<?}?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[released_to_test]">Liberado para Testes?</label>
					</div>
					<div class="col-sm-5">
						<?php
						$checked1 = "";
						$checked0 = "";
						if($obj->get("released_to_test") === true){
							$checked1 = " CHECKED";
							$checked0 = "";
						}elseif($obj->get("released_to_test") === false){
							$checked1 = "";
							$checked0 = " CHECKED";
						}
						?>
						<label class="radio-inline" for="obj[released_to_test]-1">
							<input type="radio" name="obj[released_to_test]" id="obj[released_to_test]-1" value="true"<?=$checked1?>>
							Sim
						</label>
						<label class="radio-inline" for="obj[released_to_test]-0">
							<input type="radio" name="obj[released_to_test]" id="obj[released_to_test]-0" value="false"<?=$checked0?>>
							Não
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[complexity]">Complexidade</label>
					</div>
					<div class="col-sm-5">
						<select id="obj[complexity]" name="obj[complexity]" class="form-control">
							<option value=""></option>
							<?
							foreach(ProjectUtils::$featureComplexity AS $key => $value){
							    $SELECTED = "";
							    if($key == $obj->get("complexity")){
							        $SELECTED = " SELECTED";
							    }
							?>
							<option value="<?=$key?>"<?=$SELECTED?>><?=$value["label"]?></option>
							<?}?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[version]">Versão</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[version]" name="obj[version]" type="text" class="form-control type-integer" value="<?=TextFormatter::format("integer",$obj->get("version"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[estimated_time]">Tempo Estimado (h)</label>
					</div>
					<div class="col-sm-5">
						<input id="obj[estimated_time]" name="obj[estimated_time]" type="text" class="form-control type-double" value="<?=TextFormatter::format("double",$obj->get("estimated_time"))?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="obj[note]">Observação</label>
					</div>
					<div class="col-sm-5">
						<textarea id="obj[note]" name="obj[note]" class="form-control"><?=TextFormatter::format("string",$obj->get("note"))?></textarea>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<?if(in_array($action,array("new","edit"))){?>
				<button type="submit" class="btn btn-outline-primary" id="register-button">Salvar</button>
				<?}?>
				<?if(in_array($action,array("edit"))){?>
				<button type="button" class="btn btn-outline-danger button-delete">Remover</button>
				<?}?>
				<a class="btn btn-outline-info button-new" href="/zion/mod/proj/Feature/new">Novo</a>
				<button type="button" class="btn btn-outline-secondary button-close">Fechar</button>
			</div>
		</div>
	</form>

</div>
</div>