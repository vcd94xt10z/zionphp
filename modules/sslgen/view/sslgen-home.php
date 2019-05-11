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
              	<h3>Dados da CA</h3>
            	<div class="form-group row">
                	<label for="ca_name" class="col-4 col-form-label">[CA] Nome</label> 
                	<div class="col-8">
                  		<input id="ca_name" name="ca_name" type="text" class="form-control" required="required" value="localCA">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="ca_password" class="col-4 col-form-label">[CA] Senha do Certificado</label> 
                	<div class="col-8">
                  		<input id="ca_password" name="ca_password" type="text" class="form-control" required="required" value="@localca<?=date("Y")?>">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="ca_country" class="col-4 col-form-label">[CA] País</label> 
                	<div class="col-8">
                  		<input id="ca_country" name="ca_country" type="text" class="form-control" required="required" value="BR">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="ca_state" class="col-4 col-form-label">[CA] Estado</label> 
                	<div class="col-8">
                  		<input id="ca_state" name="ca_state" type="text" class="form-control" required="required" value="PR">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="ca_city" class="col-4 col-form-label">[CA] Cidade</label> 
                	<div class="col-8">
                  		<input id="ca_city" name="ca_city" type="text" class="form-control" required="required" value="Londrina">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="ca_org" class="col-4 col-form-label">[CA] Organização</label> 
                	<div class="col-8">
                  		<input id="ca_org" name="ca_org" type="text" class="form-control" required="required" value="LocalCA">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="ca_domain" class="col-4 col-form-label">[CA] Domain</label> 
                	<div class="col-8">
                  		<input id="ca_domain" name="ca_domain" type="text" class="form-control" required="required" value="ca.localhost">
                	</div>
              	</div>
              	<h3>Dados do Site</h3>
              	<div class="form-group row">
                	<label for="site_name" class="col-4 col-form-label">[Site] Nome</label> 
                	<div class="col-8">
                  		<input id="site_name" name="site_name" type="text" class="form-control" required="required" value="localhost">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="site_country" class="col-4 col-form-label">[Site] País</label> 
                	<div class="col-8">
                  		<input id="site_country" name="site_country" type="text" class="form-control" required="required" value="BR">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="site_state" class="col-4 col-form-label">[Site] Estado</label> 
                	<div class="col-8">
                  		<input id="site_state" name="site_state" type="text" class="form-control" required="required" value="PR">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="site_city" class="col-4 col-form-label">[Site] Cidade</label> 
                	<div class="col-8">
                  		<input id="site_city" name="site_city" type="text" class="form-control" required="required" value="Londrina">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="site_org" class="col-4 col-form-label">[Site] Organização</label> 
                	<div class="col-8">
                  		<input id="site_org" name="site_org" type="text" class="form-control" required="required" value="Dev">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="site_domain" class="col-4 col-form-label">[Site] Domain</label> 
                	<div class="col-8">
                  		<input id="site_domain" name="site_domain" type="text" class="form-control" required="required" value="localhost">
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="site_alt_dns" class="col-4 col-form-label">[Site] Alt DNS</label> 
                	<div class="col-8">
                		<?php
                		$lines   = array();
                		$lines[] = "*.dev";
                		$lines[] = "*.des";
                		$lines[] = "*.qas";
                		$lines[] = "*.prd";
                		?>
                  		<textarea id="site_alt_dns" name="site_alt_dns" class="form-control" rows="4"><?=implode("\n",$lines)?></textarea>
                	</div>
              	</div>
              	<div class="form-group row">
                	<label for="site_alt_ip" class="col-4 col-form-label">[Site] Alt IP</label> 
                	<div class="col-8">
                		<?php
                		$lines   = array();
                		$lines[] = "127.0.0.1";
                		$lines[] = "::1";
                		?>
                  		<textarea id="site_alt_ip" name="site_alt_ip" class="form-control" rows="4"><?=implode("\n",$lines)?></textarea>
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