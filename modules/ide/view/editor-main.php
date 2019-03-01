<?php 
$file = \zion\ROOT; 
?>
<div class="container-fluid">
	
	<h1 class="display-4">
		Zion IDE
	</h1>
	
	<div class="row">
		<div class="col-12 col-sm-4 col-md-2">
		
			<div>
				Arquivos e Diretórios
			</div>
			<hr>
			<div id="ide-tree"></div>
			
		</div>
		<div class="col-12 col-sm-8 col-md-10">
			
			<div class="card">
        		<div class="card-header">
        			<div>
        				Arquivo
        			</div>
        			<div class="input-group mb-3">
                    	<input id="file" type="text" class="form-control" placeholder="Arquivo" aria-label="Arquivo" aria-describedby="basic-addon2" value="<?=$file?>">
                      	<div class="input-group-append">
                        	<button id="button-load" class="btn btn-outline-secondary" type="button">Carregar</button>
                      	</div>
                    </div>
        		</div>
        		<div class="card-body">
        			<div class="row">
        				<div class="col-12">
        					<textarea class="w-100" id="code" rows="6"></textarea>
        				</div>
        			</div>
        			<div class="row">
        				<div class="col-12">
        					<br>
        					<button type="button" id="button-save" class="btn btn-primary">Salvar</button>
        				</div>
        			</div>
        		</div>
        	</div>
        	
        </div>
        	
	</div>
	
</div>