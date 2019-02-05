<?php
use zion\core\System;
?>
<!doctype html>
<html lang="pt">
<head>
    <title>Login</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="icon" href="/zion/lib/favicon.png">
    <!-- styles -->
    <?foreach(System::get("view-css") AS $uri){?>
    <link rel="stylesheet" type="text/css" href="<?=$uri?>">
    <?}?>
	<!-- styles -->
</head>
<body>

    <form class="ajaxform" action="/zion/mod/user/User/login" method="POST" data-callback="loginCallback">	
    <div id="zlogin" class="center-content">
    	<div class="container-fluid">
    		<div class="row">
    			<div class="col-12">
    				<div>
    					<label for="user-login" class="user-label">Usuário</label>
    				</div>
    			</div>
    			<div class="col-12">
    				<div>
    					<input id="user-login" name="user-login" class="user-input" type="text" size="20">
    				</div>
    			</div>
    			<div class="col-12">
    				<div>
    					<label for="user-password" class="user-label">Senha</label>
    				</div>
    			</div>
    			<div class="col-12">
    				<div>
    					<input id="user-password" name="user-password" class="user-input" type="password" size="20">
    				</div>
    			</div>
    			<div class="col-12">
    				<div>
    					<button type="submit" id="button-login" class="user-button">Entrar</button>
    				</div>
    			</div>
    			<div class="col-12">
    				<div>
    					<a href="#" class="recoverMyPassword">Esqueci minha senha</a>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    </form>
    
    <!-- scripts -->
	<?foreach(System::get("view-js") AS $uri){?>
	<script src="<?=$uri?>"></script>
    <?}?>
	<!-- scripts -->
</body>
</html>