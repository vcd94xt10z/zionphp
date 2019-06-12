<?php
use zion\orm\Filter;
$fields = array("mandt","projid","name","description","url","created_at","created_by");
sort($fields);
?>
<div class="center-content filter-page">
<div class="container-fluid">

<br>
<h3>Consulta de Project</h3>
	<form class="form-inline hide-advanced-fields ajaxform" action="/zion/rest/proj/Project/" method="POST" data-callback="defaultFilterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Filtro
			</div>
			<div class="card-body">
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[mandt][low]">mandt</label>
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
						<label for="filter[projid][low]">projid</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[projid][operator]" name="filter[projid][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[projid][low]" name="filter[projid][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[projid][high]" name="filter[projid][high]" rows="1"></textarea>
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
						<label for="filter[url][low]">url</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[url][operator]" name="filter[url][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[url][low]" name="filter[url][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[url][high]" name="filter[url][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[created_at][low]">created_at</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[created_at][operator]" name="filter[created_at][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-datetime" id="filter[created_at][low]" name="filter[created_at][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-datetime" id="filter[created_at][high]" name="filter[created_at][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[created_by][low]">created_by</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[created_by][operator]" name="filter[created_by][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[created_by][low]" name="filter[created_by][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[created_by][high]" name="filter[created_by][high]" rows="1"></textarea>
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
				<a id="button-new" class="btn btn-outline-info" href="/zion/mod/proj/Project/new" target="_blank">Novo</a>
			</div>
		</div>
	</form>

	<div id="filter-result">
		<div class="container-fluid">Execute o filtro</div>
	</div>
</div></div>