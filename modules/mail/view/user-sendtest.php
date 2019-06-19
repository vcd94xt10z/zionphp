<?php
use zion\core\System;

$userList = System::get("userList");
?>
<div class="center-content">
<div class="container-fluid">

	<br>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/zion/mod/core/User/home">Início</a></li>
			<li class="breadcrumb-item"><a href="/zion/mod/mail/">mail</a></li>
			<li class="breadcrumb-item active" aria-current="page">Consulta de User</li>
		</ol>
	</nav>
	
	<h3>Teste de Envio</h3>
	<form class="form-inline ajaxform form-default" action="/zion/mod/mail/User/sendTest" method="POST" data-callback="testCallback">
		<br>
		<div class="card">
			<div class="card-header">
				Parâmetros
			</div>
			<div class="card-body">
			
				<div class="row">
					<div class="col-sm-2">
						<label for="user">Remetente</label>
					</div>
					<div class="col-sm-10">
						<select class="form-control" id="user" name="user">
							<option value=""></option>
							<?foreach($userList AS $user){?>
							<option value="<?=$user->get("user")?>"><?=$user->get("user")?></option>
							<?}?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<label for="to">Destinatário</label>
					</div>
					<div class="col-sm-10">
						<input type="email" class="form-control" id="to" name="to" value="">
					</div>
				</div>
				
			</div>
			<div class="card-footer">
				<button type="submit" id="filter-button" class="btn btn-primary">Testar</button>
			</div>
		</div>
	</form>

	<div id="result"></div>
	
</div>
</div>