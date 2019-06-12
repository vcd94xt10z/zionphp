<?php
use zion\orm\Filter;
$fields = array("moduleid","name","category","description","created","updated");
sort($fields);
?>
<div class="center-content filter-page">
<div class="container-fluid">

<br>
<h3>Consulta de Module</h3>
	<form class="form-inline hide-advanced-fields ajaxform" action="/zion/rest/core/Module/" method="POST" data-callback="defaultFilterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Filtro
			</div>
			<div class="card-body">
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[moduleid][low]">moduleid</label>
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
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[name][low]">name</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[name][operator]" name="filter[name][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[name][low]" name="filter[name][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[name][high]" name="filter[name][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[category][low]">category</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[category][operator]" name="filter[category][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[category][low]" name="filter[category][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[category][high]" name="filter[category][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[description][low]">description</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[description][operator]" name="filter[description][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[description][low]" name="filter[description][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[description][high]" name="filter[description][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[created][low]">created</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[created][operator]" name="filter[created][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-datetime" id="filter[created][low]" name="filter[created][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-datetime" id="filter[created][high]" name="filter[created][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[updated][low]">updated</label>
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
				<a id="button-new" class="btn btn-outline-info" href="/zion/mod/core/Module/new" target="_blank">Novo</a>
			</div>
		</div>
	</form>

	<div id="filter-result">
		<div class="container-fluid">Execute o filtro</div>
	</div>
</div></div>