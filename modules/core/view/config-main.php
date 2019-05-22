<?php 
$envList = array("DEV","QAS","PRD");
?>
<div class="center-content">
<div class="container-fluid">
	<br>
	<h3>Gerenciador de Configuração</h3>
	<br>
	
	<form class="form-page form-inline ajaxform" action="/zion/mod/core/Config/query" method="POST" data-callback="filterCallback">
    	<div class="card" style="width: 100%">
        	<div class="card-header">
        		Filtro
        	</div>
        	<div class="card-body">
        	
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[mandt]">Mandante</label>
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="filter[mandt]" name="filter[mandt]" value="0">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[env]">Ambiente</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control" id="filter[env]" name="filter[env]">
							<option value=""></option>
							<?
        					foreach($envList AS $key => $text){
        					   $SELECTED = "";
        					   if($key == \zion\ENV){
        					       $SELECTED = " SELECTED";
        					   }
        					?>
							<option value="<?=$text?>"<?=$SELECTED?>><?=$text?></option>
							<?}?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label for="filter[key]">Chave</label>
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="filter[key]" name="filter[key]" value="">
					</div>
				</div>
				
        	</div>
        	<div class="card-footer">
				<button type="submit" id="filter-button" class="btn btn-primary">Filtrar</button>
				<button type="button" id="filter-add" class="btn btn-outline-primary">Adicionar Item</button>
				<button type="button" id="filter-save" class="btn btn-success">Salvar</button>
			</div>
        </div>
    </form>
    
    <br>
    <div class="card">
    	<div class="card-header">
    		Resultado
    	</div>
    	<div class="card-body">
    	
    		<div class="table-responsive">
            	<table id="tb1" class="table table-striped table-hover table-bordered table-sm">
            		<thead>
            		<tr>
            			<td>Nome</td>
            			<td>Valor</td>
            			<td>Opções</td>
            		</tr>
            		</thead>
            		<tbody></tbody>
            	</table>
            </div>
        	
    	</div>
    </div>
    
</div>
</div>