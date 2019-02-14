<?php
use zion\orm\Filter;
?>
<div class="center-content filter-page">
<div class="container-fluid">

	<br>
	<form class="form-inline hide-advanced-fields ajaxform" action="/zion/mod/core/User/filter" method="POST" data-callback="defaultFilterCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Filtro
			</div>
			<div class="card-body">
				<div class="form-group">
					<div class="col-sm-3">
						<label for="filter[userid][low]" class="text-left">userid</label>
					</div>
					
					<select class="form-control filter-operator" id="filter[userid][operator]" name="filter[userid][operator]">
						<option value=""></option>
						<?foreach(Filter::getOperators() AS $key => $text){?>
						<option value="<?=$key?>"><?=$text?></option>
						<?}?>
					</select>
					
					<textarea class="form-control filter-low type-integer" id="filter[userid][low]" name="filter[userid][low]" rows="1"></textarea>
					<textarea class="form-control filter-high type-integer" id="filter[userid][high]" name="filter[userid][high]" rows="1"></textarea>
				</div>
				<div class="form-group">
					<label for="filter[login][low]" class="col-sm-3">login</label>
					
					<select class="form-control filter-operator" id="filter[login][operator]" name="filter[login][operator]">
						<option value=""></option>
						<?foreach(Filter::getOperators() AS $key => $text){?>
						<option value="<?=$key?>"><?=$text?></option>
						<?}?>
					</select>
					
					<textarea class="form-control filter-low type-string" id="filter[login][low]" name="filter[login][low]" rows="1"></textarea>
					<textarea class="form-control filter-high type-string" id="filter[login][high]" name="filter[login][high]" rows="1"></textarea>
				</div>
				<div class="form-group">
					<label for="filter[password][low]" class="col-sm-3">password</label>
					
					<select class="form-control filter-operator" id="filter[password][operator]" name="filter[password][operator]">
						<option value=""></option>
						<?foreach(Filter::getOperators() AS $key => $text){?>
						<option value="<?=$key?>"><?=$text?></option>
						<?}?>
					</select>
					
					<textarea class="form-control filter-low type-string" id="filter[password][low]" name="filter[password][low]" rows="1"></textarea>
					<textarea class="form-control filter-high type-string" id="filter[password][high]" name="filter[password][high]" rows="1"></textarea>
				</div>
				<div class="form-group">
					<label for="filter[force_new_password][low]"  class="col-sm-3">force_new_password</label>
					
					<select class="form-control filter-operator" id="filter[force_new_password][operator]" name="filter[force_new_password][operator]">
						<option value=""></option>
						<?foreach(Filter::getOperators() AS $key => $text){?>
						<option value="<?=$key?>"><?=$text?></option>
						<?}?>
					</select>
					
					<textarea class="form-control filter-low type-integer" id="filter[force_new_password][low]" name="filter[force_new_password][low]" rows="1"></textarea>
					<textarea class="form-control filter-high type-integer" id="filter[force_new_password][high]" name="filter[force_new_password][high]" rows="1"></textarea>
				</div>
				<div class="form-group">
					<label for="filter[redefine_password_hash][low]"  class="col-sm-3">redefine_password_hash</label>
					
					<select class="form-control filter-operator" id="filter[redefine_password_hash][operator]" name="filter[redefine_password_hash][operator]">
						<option value=""></option>
						<?foreach(Filter::getOperators() AS $key => $text){?>
						<option value="<?=$key?>"><?=$text?></option>
						<?}?>
					</select>
					
					<textarea class="form-control filter-low type-string" id="filter[redefine_password_hash][low]" name="filter[redefine_password_hash][low]" rows="1"></textarea>
					<textarea class="form-control filter-high type-string" id="filter[redefine_password_hash][high]" name="filter[redefine_password_hash][high]" rows="1"></textarea>
				</div>
				<div class="form-group">
					<label for="filter[name][low]"  class="col-sm-3">name</label>
					
					<select class="form-control filter-operator" id="filter[name][operator]" name="filter[name][operator]">
						<option value=""></option>
						<?foreach(Filter::getOperators() AS $key => $text){?>
						<option value="<?=$key?>"><?=$text?></option>
						<?}?>
					</select>
					
					<textarea class="form-control filter-low type-string" id="filter[name][low]" name="filter[name][low]" rows="1"></textarea>
					<textarea class="form-control filter-high type-string" id="filter[name][high]" name="filter[name][high]" rows="1"></textarea>
				</div>
				<div class="form-group">
					<label for="filter[email][low]"  class="col-sm-3">email</label>
					
					<select class="form-control filter-operator" id="filter[email][operator]" name="filter[email][operator]">
						<option value=""></option>
						<?foreach(Filter::getOperators() AS $key => $text){?>
						<option value="<?=$key?>"><?=$text?></option>
						<?}?>
					</select>
					
					<textarea class="form-control filter-low type-string" id="filter[email][low]" name="filter[email][low]" rows="1"></textarea>
					<textarea class="form-control filter-high type-string" id="filter[email][high]" name="filter[email][high]" rows="1"></textarea>
				</div>
				<div class="form-group">
					<label for="filter[phone][low]"  class="col-sm-3">phone</label>
					
					<select class="form-control filter-operator" id="filter[phone][operator]" name="filter[phone][operator]">
						<option value=""></option>
						<?foreach(Filter::getOperators() AS $key => $text){?>
						<option value="<?=$key?>"><?=$text?></option>
						<?}?>
					</select>
					
					<textarea class="form-control filter-low type-string" id="filter[phone][low]" name="filter[phone][low]" rows="1"></textarea>
					<textarea class="form-control filter-high type-string" id="filter[phone][high]" name="filter[phone][high]" rows="1"></textarea>
				</div>
				<div class="form-group">
					<label for="filter[docf][low]"  class="col-sm-3">docf</label>
					
					<select class="form-control filter-operator" id="filter[docf][operator]" name="filter[docf][operator]">
						<option value=""></option>
						<?foreach(Filter::getOperators() AS $key => $text){?>
						<option value="<?=$key?>"><?=$text?></option>
						<?}?>
					</select>
					
					<textarea class="form-control filter-low type-string" id="filter[docf][low]" name="filter[docf][low]" rows="1"></textarea>
					<textarea class="form-control filter-high type-string" id="filter[docf][high]" name="filter[docf][high]" rows="1"></textarea>
				</div>
				<div class="form-group">
					<label for="filter[doce][low]"  class="col-sm-3">doce</label>
					
					<select class="form-control filter-operator" id="filter[doce][operator]" name="filter[doce][operator]">
						<option value=""></option>
						<?foreach(Filter::getOperators() AS $key => $text){?>
						<option value="<?=$key?>"><?=$text?></option>
						<?}?>
					</select>
					
					<textarea class="form-control filter-low type-string" id="filter[doce][low]" name="filter[doce][low]" rows="1"></textarea>
					<textarea class="form-control filter-high type-string" id="filter[doce][high]" name="filter[doce][high]" rows="1"></textarea>
				</div>
				<div class="form-group">
					<label for="filter[docm][low]"  class="col-sm-3">docm</label>
					
					<select class="form-control filter-operator" id="filter[docm][operator]" name="filter[docm][operator]">
						<option value=""></option>
						<?foreach(Filter::getOperators() AS $key => $text){?>
						<option value="<?=$key?>"><?=$text?></option>
						<?}?>
					</select>
					
					<textarea class="form-control filter-low type-string" id="filter[docm][low]" name="filter[docm][low]" rows="1"></textarea>
					<textarea class="form-control filter-high type-string" id="filter[docm][high]" name="filter[docm][high]" rows="1"></textarea>
				</div>
				<div class="form-group">
					<label for="filter[validity_begin][low]"  class="col-sm-3">validity_begin</label>
					
					<select class="form-control filter-operator" id="filter[validity_begin][operator]" name="filter[validity_begin][operator]">
						<option value=""></option>
						<?foreach(Filter::getOperators() AS $key => $text){?>
						<option value="<?=$key?>"><?=$text?></option>
						<?}?>
					</select>
					
					<textarea class="form-control filter-low type-datetime" id="filter[validity_begin][low]" name="filter[validity_begin][low]" rows="1"></textarea>
					<textarea class="form-control filter-high type-datetime" id="filter[validity_begin][high]" name="filter[validity_begin][high]" rows="1"></textarea>
				</div>
				<div class="form-group">
					<label for="filter[validity_end][low]"  class="col-sm-3">validity_end</label>
					
					<select class="form-control filter-operator" id="filter[validity_end][operator]" name="filter[validity_end][operator]">
						<option value=""></option>
						<?foreach(Filter::getOperators() AS $key => $text){?>
						<option value="<?=$key?>"><?=$text?></option>
						<?}?>
					</select>
					
					<textarea class="form-control filter-low type-datetime" id="filter[validity_end][low]" name="filter[validity_end][low]" rows="1"></textarea>
					<textarea class="form-control filter-high type-datetime" id="filter[validity_end][high]" name="filter[validity_end][high]" rows="1"></textarea>
				</div>
				<div class="form-group">
					<label for="filter[status][low]"  class="col-sm-3">status</label>
					
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
			<div class="card-footer">
				<button type="submit" id="filter-button" class="btn btn-primary">Filtrar</button>
    			<button type="button" id="button-toggleFilterMode" class="btn btn-secondary" data-mode="simple">Alternar Modo</button>
    			<a id="button-new" class="btn btn-secondary" href="/zion/mod/core/User/new" target="_blank">Novo</a>
    		</div>
		</div>
		
	</form>
	<br>

	<div id="filter-result"></div>
	<br>
</div>
</div>