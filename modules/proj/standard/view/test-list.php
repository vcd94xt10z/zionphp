<?php
use zion\orm\Filter;
use zion\core\System;
use zion\mod\builder\model\Text;
$t = Text::getEntityTexts("proj","Test");
$fields = array("mandt","projid","featid","version","testid","test_at","test_by","result","device","browser","note");
sort($fields);
?>
<div class="center-content filter-page">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/proj/"><?=$t->module()?></a></li>
			<li class="breadcrumb-item active" aria-current="page">Consulta de <?=$t->entity()?></li>
		</ol>
	</nav>
<h3>Consulta de <?=$t->entity()?></h3>
	<form class="form-inline hide-advanced-fields ajaxform" action="/zion/rest/proj/Test/" method="POST" data-callback="defaultFilterCallback">
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
						<label for="filter[projid][low]" alt="<?=$t->tip("projid")?>" title="<?=$t->tip("projid")?>">
							<?=$t->field("projid")?>
						</label>
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
						<label for="filter[featid][low]" alt="<?=$t->tip("featid")?>" title="<?=$t->tip("featid")?>">
							<?=$t->field("featid")?>
						</label>
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
						<label for="filter[version][low]" alt="<?=$t->tip("version")?>" title="<?=$t->tip("version")?>">
							<?=$t->field("version")?>
						</label>
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
						<label for="filter[testid][low]" alt="<?=$t->tip("testid")?>" title="<?=$t->tip("testid")?>">
							<?=$t->field("testid")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[testid][operator]" name="filter[testid][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-integer" id="filter[testid][low]" name="filter[testid][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-integer" id="filter[testid][high]" name="filter[testid][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[test_at][low]" alt="<?=$t->tip("test_at")?>" title="<?=$t->tip("test_at")?>">
							<?=$t->field("test_at")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[test_at][operator]" name="filter[test_at][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-datetime" id="filter[test_at][low]" name="filter[test_at][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-datetime" id="filter[test_at][high]" name="filter[test_at][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[test_by][low]" alt="<?=$t->tip("test_by")?>" title="<?=$t->tip("test_by")?>">
							<?=$t->field("test_by")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[test_by][operator]" name="filter[test_by][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[test_by][low]" name="filter[test_by][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[test_by][high]" name="filter[test_by][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[result][low]" alt="<?=$t->tip("result")?>" title="<?=$t->tip("result")?>">
							<?=$t->field("result")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[result][operator]" name="filter[result][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[result][low]" name="filter[result][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[result][high]" name="filter[result][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[device][low]" alt="<?=$t->tip("device")?>" title="<?=$t->tip("device")?>">
							<?=$t->field("device")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[device][operator]" name="filter[device][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[device][low]" name="filter[device][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[device][high]" name="filter[device][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[browser][low]" alt="<?=$t->tip("browser")?>" title="<?=$t->tip("browser")?>">
							<?=$t->field("browser")?>
						</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control filter-operator" id="filter[browser][operator]" name="filter[browser][operator]">
							<option value=""></option>
							<?foreach(Filter::getOperators() AS $key => $text){?>
							<option value="<?=$key?>"><?=$text?></option>
							<?}?>
						</select>
						
						<textarea class="form-control filter-low type-string" id="filter[browser][low]" name="filter[browser][low]" rows="1"></textarea>
						<textarea class="form-control filter-high type-string" id="filter[browser][high]" name="filter[browser][high]" rows="1"></textarea>
					</div>
				</div>
				<div class="row row-filter-advanced">
					<div class="col-sm-3">
						<label for="filter[note][low]" alt="<?=$t->tip("note")?>" title="<?=$t->tip("note")?>">
							<?=$t->field("note")?>
						</label>
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
				<a id="button-new" class="btn btn-outline-info" href="/zion/mod/proj/Test/new" target="_blank">Novo</a>
			</div>
		</div>
	</form>

	<div id="filter-result">
		<div class="container-fluid">Execute o filtro</div>
	</div>
</div></div>