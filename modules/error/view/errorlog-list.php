<?php
use zion\orm\Filter;
?>
<div class="center-content filter-page">
<div class="container-fluid">

	<form class="form-inline hide-advanced-fields ajaxform" action="/zion/rest/error/ErrorLog/" method="POST" data-callback="defaultFilterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Filtro
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[errorid][low]">errorid</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[errorid][operator]" name="filter[errorid][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[errorid][low]" name="filter[errorid][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[errorid][high]" name="filter[errorid][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[type][low]">type</label>
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
				<div class="row">
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
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[duration][low]">duration</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[duration][operator]" name="filter[duration][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[duration][low]" name="filter[duration][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[duration][high]" name="filter[duration][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[http_ipaddr][low]">http_ipaddr</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[http_ipaddr][operator]" name="filter[http_ipaddr][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[http_ipaddr][low]" name="filter[http_ipaddr][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[http_ipaddr][high]" name="filter[http_ipaddr][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[http_method][low]">http_method</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[http_method][operator]" name="filter[http_method][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[http_method][low]" name="filter[http_method][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[http_method][high]" name="filter[http_method][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[http_uri][low]">http_uri</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[http_uri][operator]" name="filter[http_uri][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[http_uri][low]" name="filter[http_uri][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[http_uri][high]" name="filter[http_uri][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[level][low]">level</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[level][operator]" name="filter[level][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[level][low]" name="filter[level][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[level][high]" name="filter[level][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[code][low]">code</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[code][operator]" name="filter[code][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[code][low]" name="filter[code][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[code][high]" name="filter[code][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[message][low]">message</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[message][operator]" name="filter[message][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[message][low]" name="filter[message][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[message][high]" name="filter[message][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[stack][low]">stack</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[stack][operator]" name="filter[stack][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[stack][low]" name="filter[stack][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[stack][high]" name="filter[stack][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[input][low]">input</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[input][operator]" name="filter[input][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[input][low]" name="filter[input][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[input][high]" name="filter[input][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[file][low]">file</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[file][operator]" name="filter[file][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[file][low]" name="filter[file][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[file][high]" name="filter[file][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[line][low]">line</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[line][operator]" name="filter[line][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[line][low]" name="filter[line][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[line][high]" name="filter[line][high]" rows="1"></textarea>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" id="filter-button" class="btn btn-primary">Filtrar</button>
				<button type="button" id="button-toggleFilterMode" class="btn btn-outline-secondary" data-mode="simple">Alternar Modo</button>
				<a id="button-new" class="btn btn-outline-info" href="/zion/mod/error/ErrorLog/new" target="_blank">Novo</a>
			</div>
		</div>
	</form>

	<div id="filter-result">
		<div class="container-fluid">Execute o filtro</div>
	</div>
</div></div>