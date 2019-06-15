<?php
use zion\orm\Filter;
$fields = array("mandt","pageid","rewrite","title","categoryid","content_html","created_at","created_by","updated_at","updated_by","meta_description","meta_keywords","status");
sort($fields);
?>
<div class="center-content filter-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/post/">post</a></li>
			<li class="breadcrumb-item active" aria-current="page">Consulta de Page</li>
		</ol>
	</nav>
<h3>Consulta de Page</h3>
	<form class="form-inline hide-advanced-fields ajaxform" action="/zion/rest/post/Page/" method="POST" data-callback="defaultFilterCallback">
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
						<label for="filter[pageid][low]">pageid</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[pageid][operator]" name="filter[pageid][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[pageid][low]" name="filter[pageid][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[pageid][high]" name="filter[pageid][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[rewrite][low]">rewrite</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[rewrite][operator]" name="filter[rewrite][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[rewrite][low]" name="filter[rewrite][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[rewrite][high]" name="filter[rewrite][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[title][low]">title</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[title][operator]" name="filter[title][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[title][low]" name="filter[title][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[title][high]" name="filter[title][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[categoryid][low]">categoryid</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[categoryid][operator]" name="filter[categoryid][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[categoryid][low]" name="filter[categoryid][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[categoryid][high]" name="filter[categoryid][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[content_html][low]">content_html</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[content_html][operator]" name="filter[content_html][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[content_html][low]" name="filter[content_html][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[content_html][high]" name="filter[content_html][high]" rows="1"></textarea>
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
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[updated_by][low]">updated_by</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[updated_by][operator]" name="filter[updated_by][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[updated_by][low]" name="filter[updated_by][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[updated_by][high]" name="filter[updated_by][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[meta_description][low]">meta_description</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[meta_description][operator]" name="filter[meta_description][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[meta_description][low]" name="filter[meta_description][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[meta_description][high]" name="filter[meta_description][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[meta_keywords][low]">meta_keywords</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[meta_keywords][operator]" name="filter[meta_keywords][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[meta_keywords][low]" name="filter[meta_keywords][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[meta_keywords][high]" name="filter[meta_keywords][high]" rows="1"></textarea>
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
				<a id="button-new" class="btn btn-outline-info" href="/zion/mod/post/Page/new" target="_blank">Novo</a>
			</div>
		</div>
	</form>

	<div id="filter-result">
		<div class="container-fluid">Execute o filtro</div>
	</div>
</div></div>