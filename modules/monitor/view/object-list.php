<?php
use zion\orm\Filter;
use zion\core\System;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("monitor","Object");
$fields = array("objectid","name","created","type","url","interval","status","last_check","notify_by_email","notify_by_sms","notify_by_tts","notify_email","notify_phone","sound_enabled","enabled","counter_success","counter_error","counter_timeout");
sort($fields);
?>
<div class="center-content filter-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/monitor/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Consulta de <?=$t->entity()?></li>
		</ol>
	</nav>
<h3>Consulta de <?=$t->entity()?></h3>
	<form class="form-inline hide-advanced-fields ajaxform" action="/zion/rest/monitor/Object/" method="POST" data-callback="defaultFilterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Filtro
			</div>
			<div class="card-body">
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[objectid][low]" alt="<?=$t->tip("objectid")?>" title="<?=$t->tip("objectid")?>">
							<?=$t->field("objectid")?>
						</label>
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
						<label for="filter[name][low]" alt="<?=$t->tip("name")?>" title="<?=$t->tip("name")?>">
							<?=$t->field("name")?>
						</label>
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
						<label for="filter[created][low]" alt="<?=$t->tip("created")?>" title="<?=$t->tip("created")?>">
							<?=$t->field("created")?>
						</label>
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
						<label for="filter[url][low]" alt="<?=$t->tip("url")?>" title="<?=$t->tip("url")?>">
							<?=$t->field("url")?>
						</label>
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
						<label for="filter[interval][low]" alt="<?=$t->tip("interval")?>" title="<?=$t->tip("interval")?>">
							<?=$t->field("interval")?>
						</label>
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
						<label for="filter[status][low]" alt="<?=$t->tip("status")?>" title="<?=$t->tip("status")?>">
							<?=$t->field("status")?>
						</label>
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
						<label for="filter[last_check][low]" alt="<?=$t->tip("last_check")?>" title="<?=$t->tip("last_check")?>">
							<?=$t->field("last_check")?>
						</label>
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
						<label for="filter[notify_by_email][low]" alt="<?=$t->tip("notify_by_email")?>" title="<?=$t->tip("notify_by_email")?>">
							<?=$t->field("notify_by_email")?>
						</label>
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
						<label for="filter[notify_by_sms][low]" alt="<?=$t->tip("notify_by_sms")?>" title="<?=$t->tip("notify_by_sms")?>">
							<?=$t->field("notify_by_sms")?>
						</label>
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
						<label for="filter[notify_by_tts][low]" alt="<?=$t->tip("notify_by_tts")?>" title="<?=$t->tip("notify_by_tts")?>">
							<?=$t->field("notify_by_tts")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[notify_by_tts][operator]" name="filter[notify_by_tts][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-boolean" id="filter[notify_by_tts][low]" name="filter[notify_by_tts][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-boolean" id="filter[notify_by_tts][high]" name="filter[notify_by_tts][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[notify_email][low]" alt="<?=$t->tip("notify_email")?>" title="<?=$t->tip("notify_email")?>">
							<?=$t->field("notify_email")?>
						</label>
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
						<label for="filter[notify_phone][low]" alt="<?=$t->tip("notify_phone")?>" title="<?=$t->tip("notify_phone")?>">
							<?=$t->field("notify_phone")?>
						</label>
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
						<label for="filter[sound_enabled][low]" alt="<?=$t->tip("sound_enabled")?>" title="<?=$t->tip("sound_enabled")?>">
							<?=$t->field("sound_enabled")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[sound_enabled][operator]" name="filter[sound_enabled][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-boolean" id="filter[sound_enabled][low]" name="filter[sound_enabled][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-boolean" id="filter[sound_enabled][high]" name="filter[sound_enabled][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[enabled][low]" alt="<?=$t->tip("enabled")?>" title="<?=$t->tip("enabled")?>">
							<?=$t->field("enabled")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[enabled][operator]" name="filter[enabled][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-boolean" id="filter[enabled][low]" name="filter[enabled][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-boolean" id="filter[enabled][high]" name="filter[enabled][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[counter_success][low]" alt="<?=$t->tip("counter_success")?>" title="<?=$t->tip("counter_success")?>">
							<?=$t->field("counter_success")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[counter_success][operator]" name="filter[counter_success][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[counter_success][low]" name="filter[counter_success][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[counter_success][high]" name="filter[counter_success][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[counter_error][low]" alt="<?=$t->tip("counter_error")?>" title="<?=$t->tip("counter_error")?>">
							<?=$t->field("counter_error")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[counter_error][operator]" name="filter[counter_error][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[counter_error][low]" name="filter[counter_error][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[counter_error][high]" name="filter[counter_error][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[counter_timeout][low]" alt="<?=$t->tip("counter_timeout")?>" title="<?=$t->tip("counter_timeout")?>">
							<?=$t->field("counter_timeout")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[counter_timeout][operator]" name="filter[counter_timeout][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[counter_timeout][low]" name="filter[counter_timeout][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[counter_timeout][high]" name="filter[counter_timeout][high]" rows="1"></textarea>
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