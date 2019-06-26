<?php 
$url = "http://{$_SERVER["SERVER_NAME"]}/zion/diff/";
?>
<style>
#form1 .row {
    margin-bottom: 10px;
}
</style>
<div class="container-fluid">
    <div class="center-content">
    	<br>
    	<h3>Diferença entre Ambientes</h3>
    	
    	<form id="form1" class="form-horizontal" action="/zion/mod/diff/Main/diff" method="POST">
		<br>
		<div class="card">
			<div class="card-header">
				Formulário
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="source">
							URL Origem
						</label>
					</div>
					<div class="col-sm-9">
						<input id="source" name="source" type="text" class="form-control" value="<?=$url?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label" for="target">
							URL Destino
						</label>
					</div>
					<div class="col-sm-9">
						<input id="target" name="target" type="text" class="form-control" value="<?=$url?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
					</div>
					<div class="col-sm-9">
						<button class="btn btn-outline-info" type="submit">Comparar</button>
					</div>
				</div>
			</div>
		</div>
		</form>
    </div>
</div>