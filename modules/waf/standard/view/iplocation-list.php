<?php
use zion\orm\Filter;
use zion\core\System;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("waf","IpLocation");
$fields = array("ipaddr","type","continent_code","continent_name","country_code","country_name","region_code","region_name","city","updated");
sort($fields);
?>
<div class="center-content filter-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/waf/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Consulta de <?=$t->entity()?></li>
		</ol>
	</nav>
<h3>Consulta de <?=$t->entity()?></h3>
	<form class="form-inline hide-advanced-fields ajaxform" action="/zion/rest/waf/IpLocation/" method="POST" data-callback="defaultFilterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Filtro
			</div>
			<div class="card-body">
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[ipaddr][low]" alt="<?=$t->tip("ipaddr")?>" title="<?=$t->tip("ipaddr")?>">
							<?=$t->field("ipaddr")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[ipaddr][operator]" name="filter[ipaddr][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[ipaddr][low]" name="filter[ipaddr][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[ipaddr][high]" name="filter[ipaddr][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[type][low]" alt="<?=$t->tip("type")?>" title="<?=$t->tip("type")?>">
							<?=$t->field("type")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[type][operator]" name="filter[type][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[type][low]" name="filter[type][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[type][high]" name="filter[type][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[continent_code][low]" alt="<?=$t->tip("continent_code")?>" title="<?=$t->tip("continent_code")?>">
							<?=$t->field("continent_code")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[continent_code][operator]" name="filter[continent_code][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[continent_code][low]" name="filter[continent_code][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[continent_code][high]" name="filter[continent_code][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[continent_name][low]" alt="<?=$t->tip("continent_name")?>" title="<?=$t->tip("continent_name")?>">
							<?=$t->field("continent_name")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[continent_name][operator]" name="filter[continent_name][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[continent_name][low]" name="filter[continent_name][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[continent_name][high]" name="filter[continent_name][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[country_code][low]" alt="<?=$t->tip("country_code")?>" title="<?=$t->tip("country_code")?>">
							<?=$t->field("country_code")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[country_code][operator]" name="filter[country_code][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[country_code][low]" name="filter[country_code][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[country_code][high]" name="filter[country_code][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[country_name][low]" alt="<?=$t->tip("country_name")?>" title="<?=$t->tip("country_name")?>">
							<?=$t->field("country_name")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[country_name][operator]" name="filter[country_name][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[country_name][low]" name="filter[country_name][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[country_name][high]" name="filter[country_name][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[region_code][low]" alt="<?=$t->tip("region_code")?>" title="<?=$t->tip("region_code")?>">
							<?=$t->field("region_code")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[region_code][operator]" name="filter[region_code][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[region_code][low]" name="filter[region_code][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[region_code][high]" name="filter[region_code][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[region_name][low]" alt="<?=$t->tip("region_name")?>" title="<?=$t->tip("region_name")?>">
							<?=$t->field("region_name")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[region_name][operator]" name="filter[region_name][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[region_name][low]" name="filter[region_name][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[region_name][high]" name="filter[region_name][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[city][low]" alt="<?=$t->tip("city")?>" title="<?=$t->tip("city")?>">
							<?=$t->field("city")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[city][operator]" name="filter[city][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[city][low]" name="filter[city][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[city][high]" name="filter[city][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[updated][low]" alt="<?=$t->tip("updated")?>" title="<?=$t->tip("updated")?>">
							<?=$t->field("updated")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[updated][operator]" name="filter[updated][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-datetime" id="filter[updated][low]" name="filter[updated][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-datetime" id="filter[updated][high]" name="filter[updated][high]" rows="1"></textarea>
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
				<a id="button-new" class="btn btn-outline-info" href="/zion/mod/waf/IpLocation/new" target="_blank">Novo</a>
			</div>
		</div>
	</form>

	<div id="filter-result">
		<div class="container-fluid">Execute o filtro</div>
	</div>
</div></div>