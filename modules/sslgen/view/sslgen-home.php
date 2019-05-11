<div class="center-content">
<div class="container-fluid">

	<br>
	<div class="row">
		<div class="col-12">
		
			<form class="ajaxform" method="POST" action="/zion/mod/sslgen/SSLGen/exec" data-callback="callbackForm">
				<div class="form-group row">
                	<label for="folder" class="col-4 col-form-label">Diretório Base</label> 
                	<div class="col-8">
                  		<input id="folder" name="folder" type="text" class="form-control" required="required" value="/ssl/">
                	</div>
              	</div>
            	<div class="form-group row">
                	<label for="ca_name" class="col-4 col-form-label">[CA] Nome</label> 
                	<div class="col-8">
                  		<input id="ca_name" name="ca_name" type="text" class="form-control" required="required" value="localCA">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="ca_name" class="col-4 col-form-label">[CA] Senha do Certificado</label> 
                	<div class="col-8">
                  		<input id="ca_password" name="ca_password" type="text" class="form-control" required="required" value="123456">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="ca_name" class="col-4 col-form-label">[CA] País</label> 
                	<div class="col-8">
                  		<input id="ca_country" name="ca_country" type="text" class="form-control" required="required" value="BR">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="ca_name" class="col-4 col-form-label">[CA] Estado</label> 
                	<div class="col-8">
                  		<input id="ca_state" name="ca_state" type="text" class="form-control" required="required" value="PR">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="ca_name" class="col-4 col-form-label">[CA] Cidade</label> 
                	<div class="col-8">
                  		<input id="ca_city" name="ca_city" type="text" class="form-control" required="required" value="Londrina">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="ca_name" class="col-4 col-form-label">[CA] Organização</label> 
                	<div class="col-8">
                  		<input id="ca_org" name="ca_org" type="text" class="form-control" required="required" value="LocalCA">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="ca_name" class="col-4 col-form-label">[CA] Domain</label> 
                	<div class="col-8">
                  		<input id="ca_domain" name="ca_domain" type="text" class="form-control" required="required" value="ca.localhost">
                	</div>
              	</div>
              	<div class="form-group row">
                    <div class="offset-4 col-8">
                      <button name="submit" type="submit" class="btn btn-primary">Gerar</button>
                    </div>
                  </div>
            </form>
            
		</div>
		<div class="col-12">
		
			<div id="code"></div>
		
		</div>
	</div>
	
</div>
</div>