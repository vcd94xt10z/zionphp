<div class="container-fluid">
	<br>
	
	<div class="row">
		<div class="col-12 col-sm-4 col-md-2">
		
			<div>
				<input id="sql-search" type="text" class="w-100" placeholder="Tabelas, views, func..">
				
				<div id="sql-objects"></div>
			</div>
			
		</div>
		<div class="col-12 col-sm-8 col-md-10">
			
			<div class="card">
        		<div class="card-header">
        			Query (Run Ctrl + Enter)
        		</div>
        		<div class="card-body">
        			<div class="row">
        				<div class="col-12">
        					<textarea class="w-100" id="sql-query" rows="6">SELECT * 
FROM user 
LIMIT 10</textarea>
        				</div>
        			</div>
        		</div>
        	</div>
        	
        	<br>
        	
        	<div class="card">
        		<div class="card-header">
        			Resultado
        		</div>
        		<div class="card-body">
        			<div class="row">
        				<div class="col-12">
        					
        					<div id="sql-message" class="alert alert-danger" role="alert"></div>
        					
        					<div class="table-responsive">
    							<table id="sql-result" class="table table-striped table-hover table-bordered table-sm">
    							</table>
        					</div>
        				</div>
        			</div>
        		</div>
		
			</div>
		</div>
	</div>
	
</div>
<div class="zcontextmenu" data-type="table">
	
	<div class="list-group">
		<a href="#" class="list-group-item list-group-item-action disabled">DML</a>
      	<a href="#" class="list-group-item list-group-item-action">SELECT</a>
      	<a href="#" class="list-group-item list-group-item-action">INSERT</a>
      	<a href="#" class="list-group-item list-group-item-action">UPDATE</a>
      	<a href="#" class="list-group-item list-group-item-action">DELETE</a>
      
      	<a href="#" class="list-group-item list-group-item-action disabled">DDL</a>
      	<a href="#" class="list-group-item list-group-item-action">CREATE</a>
      	<a href="#" class="list-group-item list-group-item-action">DROP</a>
      	<a href="#" class="list-group-item list-group-item-action">TRUNCATE</a>
    </div>
	
</div>
<div class="zcontextmenu" data-type="view">
	
	<div class="list-group">
		<a href="#" class="list-group-item list-group-item-action disabled">DML</a>
      	<a href="#" class="list-group-item list-group-item-action">SELECT</a>
      	
      	<a href="#" class="list-group-item list-group-item-action disabled">DDL</a>
      	<a href="#" class="list-group-item list-group-item-action">CREATE</a>
      	<a href="#" class="list-group-item list-group-item-action">DROP</a>
    </div>
	
</div>
<div class="zcontextmenu" data-type="function">
	
	<div class="list-group">
		<a href="#" class="list-group-item list-group-item-action">CALL</a>
		<a href="#" class="list-group-item list-group-item-action">CREATE</a>
		<a href="#" class="list-group-item list-group-item-action">DROP</a>
    </div>
	
</div>
<div class="zcontextmenu" data-type="procedure">
	
	<div class="list-group">
		<a href="#" class="list-group-item list-group-item-action">CALL</a>
		<a href="#" class="list-group-item list-group-item-action">CREATE</a>
		<a href="#" class="list-group-item list-group-item-action">DROP</a>
    </div>
	
</div>
<div class="zcontextmenu" data-type="trigger">
	
	<div class="list-group">
		<a href="#" class="list-group-item list-group-item-action">CALL</a>
		<a href="#" class="list-group-item list-group-item-action">CREATE</a>
		<a href="#" class="list-group-item list-group-item-action">DROP</a>
    </div>
	
</div>
<div class="zcontextmenu" data-type="event">
	
	<div class="list-group">
		<a href="#" class="list-group-item list-group-item-action">CALL</a>
		<a href="#" class="list-group-item list-group-item-action">CREATE</a>
		<a href="#" class="list-group-item list-group-item-action">DROP</a>
    </div>
	
</div>