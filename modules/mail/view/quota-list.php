<?php
use zion\orm\Filter;
$fields = array("mandt","user","server","date","hour","total","updated_at");
sort($fields);
?>
<div class="center-content filter-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/mail/">mail</a></li>
			<li class="breadcrumb-item active" aria-current="page">Consulta de Quota</li>
		</ol>
	</nav>
<h3>Consulta de Quota</h3>
	<form class="form-inline hide-advanced-fields ajaxform" action="/zion/rest/mail/Quota/" method="POST" data-callback="defaultFilterCallback">
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
						<label for="filter[user][low]">user</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[user][operator]" name="filter[user][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[user][low]" name="filter[user][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[user][high]" name="filter[user][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[server][low]">server</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[server][operator]" name="filter[server][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[server][low]" name="filter[server][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[server][high]" name="filter[server][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[date][low]">date</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[date][operator]" name="filter[date][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-date" id="filter[date][low]" name="filter[date][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-date" id="filter[date][high]" name="filter[date][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-normal">
					<div class="col-sm-3">
						<label for="filter[hour][low]">hour</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[hour][operator]" name="filter[hour][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[hour][low]" name="filter[hour][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[hour][high]" name="filter[hour][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[total][low]">total</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[total][operator]" name="filter[total][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[total][low]" name="filter[total][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[total][high]" name="filter[total][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[updated_at][low]">updated_at</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[updated_at][operator]" name="filter[updated_at][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-datetime" id="filter[updated_at][low]" name="filter[updated_at][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-datetime" id="filter[updated_at][high]" name="filter[updated_at][high]" rows="1"></textarea>
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
				<a id="button-new" class="btn btn-outline-info" href="/zion/mod/mail/Quota/new" target="_blank">Novo</a>
			</div>
		</div>
	</form>

	<div id="filter-result">
		<div class="container-fluid">Execute o filtro</div>
	</div>
</div></div>