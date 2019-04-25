<?php
use zion\orm\Filter;
$fields = array("objectid","created","type","url","interval","status","last_check","notify_by_email","notify_by_sms","notify_by_sound","notify_email","notify_phone","notify_sound");
sort($fields);
?>
<div class="center-content filter-page">
<div class="container-fluid">

	<form class="form-inline hide-advanced-fields ajaxform" action="/zion/rest/monitor/Object/" method="POST" data-callback="defaultFilterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Filtro
			</div>
			<div class="card-body">
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[objectid][low]">objectid</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[objectid][operator]" name="filter[objectid][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[objectid][low]" name="filter[objectid][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[objectid][high]" name="filter[objectid][high]" rows="1"></textarea>
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
						<label for="filter[interval][low]">interval</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[interval][operator]" name="filter[interval][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[interval][low]" name="filter[interval][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[interval][high]" name="filter[interval][high]" rows="1"></textarea>
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
						<label for="filter[last_check][low]">last_check</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[last_check][operator]" name="filter[last_check][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-datetime" id="filter[last_check][low]" name="filter[last_check][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-datetime" id="filter[last_check][high]" name="filter[last_check][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[notify_by_email][low]">notify_by_email</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[notify_by_email][operator]" name="filter[notify_by_email][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-boolean" id="filter[notify_by_email][low]" name="filter[notify_by_email][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-boolean" id="filter[notify_by_email][high]" name="filter[notify_by_email][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[notify_by_sms][low]">notify_by_sms</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[notify_by_sms][operator]" name="filter[notify_by_sms][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-boolean" id="filter[notify_by_sms][low]" name="filter[notify_by_sms][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-boolean" id="filter[notify_by_sms][high]" name="filter[notify_by_sms][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[notify_by_sound][low]">notify_by_sound</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[notify_by_sound][operator]" name="filter[notify_by_sound][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-boolean" id="filter[notify_by_sound][low]" name="filter[notify_by_sound][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-boolean" id="filter[notify_by_sound][high]" name="filter[notify_by_sound][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[notify_email][low]">notify_email</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[notify_email][operator]" name="filter[notify_email][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[notify_email][low]" name="filter[notify_email][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[notify_email][high]" name="filter[notify_email][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[notify_phone][low]">notify_phone</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[notify_phone][operator]" name="filter[notify_phone][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[notify_phone][low]" name="filter[notify_phone][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[notify_phone][high]" name="filter[notify_phone][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[notify_sound][low]">notify_sound</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[notify_sound][operator]" name="filter[notify_sound][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[notify_sound][low]" name="filter[notify_sound][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[notify_sound][high]" name="filter[notify_sound][high]" rows="1"></textarea>
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
				<a id="button-new" class="btn btn-outline-info" href="/zion/mod/monitor/Object/new" target="_blank">Novo</a>
			</div>
		</div>
	</form>

	<div id="filter-result">
		<div class="container-fluid">Execute o filtro</div>
	</div>
</div></div>