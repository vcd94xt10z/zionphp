<?php
use zion\orm\Filter;
use zion\core\System;
$t = System::get("entityTexts");
$fields = array("mandt","lang","moduleid","entityid","field","short_text","medium_text","full_text","tip");
sort($fields);
?>
<div class="center-content filter-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/builder/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Consulta de <?=$t->entity()?></li>
		</ol>
	</nav>
<h3>Consulta de <?=$t->entity()?></h3>
	<form class="form-inline hide-advanced-fields ajaxform" action="/zion/rest/builder/Text/" method="POST" data-callback="defaultFilterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Filtro
			</div>
			<div class="card-body">
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[mandt][low]" alt="<?=$t->tip("mandt")?>" title="<?=$t->tip("mandt")?>">
							<?=$t->field("mandt")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[mandt][operator]" name="filter[mandt][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[mandt][low]" name="filter[mandt][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[mandt][high]" name="filter[mandt][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[lang][low]" alt="<?=$t->tip("lang")?>" title="<?=$t->tip("lang")?>">
							<?=$t->field("lang")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[lang][operator]" name="filter[lang][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[lang][low]" name="filter[lang][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[lang][high]" name="filter[lang][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[moduleid][low]" alt="<?=$t->tip("moduleid")?>" title="<?=$t->tip("moduleid")?>">
							<?=$t->field("moduleid")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[moduleid][operator]" name="filter[moduleid][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[moduleid][low]" name="filter[moduleid][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[moduleid][high]" name="filter[moduleid][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[entityid][low]" alt="<?=$t->tip("entityid")?>" title="<?=$t->tip("entityid")?>">
							<?=$t->field("entityid")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[entityid][operator]" name="filter[entityid][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[entityid][low]" name="filter[entityid][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[entityid][high]" name="filter[entityid][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[field][low]" alt="<?=$t->tip("field")?>" title="<?=$t->tip("field")?>">
							<?=$t->field("field")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[field][operator]" name="filter[field][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[field][low]" name="filter[field][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[field][high]" name="filter[field][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[short_text][low]" alt="<?=$t->tip("short_text")?>" title="<?=$t->tip("short_text")?>">
							<?=$t->field("short_text")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[short_text][operator]" name="filter[short_text][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[short_text][low]" name="filter[short_text][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[short_text][high]" name="filter[short_text][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[medium_text][low]" alt="<?=$t->tip("medium_text")?>" title="<?=$t->tip("medium_text")?>">
							<?=$t->field("medium_text")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[medium_text][operator]" name="filter[medium_text][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[medium_text][low]" name="filter[medium_text][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[medium_text][high]" name="filter[medium_text][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[full_text][low]" alt="<?=$t->tip("full_text")?>" title="<?=$t->tip("full_text")?>">
							<?=$t->field("full_text")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[full_text][operator]" name="filter[full_text][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[full_text][low]" name="filter[full_text][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[full_text][high]" name="filter[full_text][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[tip][low]" alt="<?=$t->tip("tip")?>" title="<?=$t->tip("tip")?>">
							<?=$t->field("tip")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[tip][operator]" name="filter[tip][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[tip][low]" name="filter[tip][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[tip][high]" name="filter[tip][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="order[field]">Ordenação</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control" id="order[field]" name="order[field]">
							<option value=""></option>
							<?foreach($fields AS $key){?>
							<option value="<?=$key?>"><?=$key?></option>
							<?}?>
						</select>
						
						<select class="form-control" id="order[type]" name="order[type]">
							<option value=""></option>
							<option value="ASC">ASC</option>
							<option value="DESC">DESC</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="limit">Limite</label>
					</div>
					<div class="col-sm-9">
						<input class="form-control type-integer" id="limit" name="limit" value="100">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="offset">Ignorar</label>
					</div>
					<div class="col-sm-9">
						<input class="form-control type-integer" id="offset" name="offset" value="0">
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" id="filter-button" class="btn btn-primary">Filtrar</button>
				<button type="button" id="button-filter-basic" class="btn btn-outline-secondary">Basico</button>
				<button type="button" id="button-filter-advanced" class="btn btn-outline-secondary">Avançado</button>
				<a id="button-new" class="btn btn-outline-info" href="/zion/mod/builder/Text/new" target="_blank">Novo</a>
			</div>
		</div>
	</form>

	<div id="filter-result">
		<div class="container-fluid">Execute o filtro</div>
	</div>
</div></div>