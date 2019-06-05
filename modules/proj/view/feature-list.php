<?php
use zion\orm\Filter;
$fields = array("mandt","projid","featid","sequence","name","created_at","created_by","main_developer","status","released_to_test","complexity","version","estimated_time","note");
sort($fields);
?>
<div class="center-content filter-page">
<div class="container-fluid">

	<form class="form-inline hide-advanced-fields ajaxform" action="/zion/rest/proj/Feature/" method="POST" data-callback="defaultFilterCallback">
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
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[featid][low]">featid</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[featid][operator]" name="filter[featid][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[featid][low]" name="filter[featid][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[featid][high]" name="filter[featid][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[sequence][low]">sequence</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[sequence][operator]" name="filter[sequence][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[sequence][low]" name="filter[sequence][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[sequence][high]" name="filter[sequence][high]" rows="1"></textarea>
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
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[main_developer][low]">main_developer</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[main_developer][operator]" name="filter[main_developer][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[main_developer][low]" name="filter[main_developer][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[main_developer][high]" name="filter[main_developer][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[status][low]">status</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[status][operator]" name="filter[status][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[status][low]" name="filter[status][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[status][high]" name="filter[status][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[released_to_test][low]">released_to_test</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[released_to_test][operator]" name="filter[released_to_test][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-boolean" id="filter[released_to_test][low]" name="filter[released_to_test][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-boolean" id="filter[released_to_test][high]" name="filter[released_to_test][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[complexity][low]">complexity</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[complexity][operator]" name="filter[complexity][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[complexity][low]" name="filter[complexity][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[complexity][high]" name="filter[complexity][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[version][low]">version</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[version][operator]" name="filter[version][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[version][low]" name="filter[version][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[version][high]" name="filter[version][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[estimated_time][low]">estimated_time</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[estimated_time][operator]" name="filter[estimated_time][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-double" id="filter[estimated_time][low]" name="filter[estimated_time][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-double" id="filter[estimated_time][high]" name="filter[estimated_time][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[note][low]">note</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[note][operator]" name="filter[note][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[note][low]" name="filter[note][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[note][high]" name="filter[note][high]" rows="1"></textarea>
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
				<a id="button-new" class="btn btn-outline-info" href="/zion/mod/proj/Feature/new" target="_blank">Novo</a>
			</div>
		</div>
	</form>

	<div id="filter-result">
		<div class="container-fluid">Execute o filtro</div>
	</div>
</div></div>