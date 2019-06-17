<?php
use zion\core\Page;
?>
<!doctype html>
<html lang="pt">
<head>
    <title><?=Page::getTitle()?></title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <meta name="robots" content="<?=Page::getMeta("robots")?>">
    <link rel="icon" href="/zion/lib/favicon.png">
    <!-- styles -->
    <?foreach(Page::css() AS $uri){?>
    <link rel="stylesheet" type="text/css" href="<?=$uri?>">
    <?}?>
	<!-- styles -->
</head>
<body class="text-center">
    <form class="form-signin ajaxform" action="/zion/mod/core/User/login" method="POST" data-callback="loginCallback">
      <img class="mb-4" src="/zion/mod/core/view/img/login.png" alt="">
      <h1 class="h3 mb-3 font-weight-normal">Efetue seu login</h1>
      
      <label for="mandt" class="sr-only">Mandante</label>
      <input type="text" id="mandt" name="mandt" class="form-control" placeholder="Mandante" value="">
      
      <label for="user-login" class="sr-only">Login</label>
      <input type="text" id="user-login" name="user-login" class="form-control" placeholder="Login" required autofocus>
      
      <label for="user-password" class="sr-only">Password</label>
      <input type="password" id="user-password" name="user-password" class="form-control" placeholder="Password" required>
      
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Lembrar
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
      <div class="mb-3">
      	<a href="#" class="recoverMyPassword" target="_blank">Esqueci minha senha</a>
      </div>
      <div class="mb-3">
      	<a href="/zion/mod/core/User/createAdminUser" target="_blank">Criar usuário administrativo</a>
      </div>
      <p class="mt-5 mb-3 text-muted">&copy; 2019-<?=date("Y")?></p>
    </form>
    
    <!-- scripts -->
	<?foreach(Page::js() AS $uri){?>
	<script src="<?=$uri?>"></script>
    <?}?>
	<!-- scripts -->
</body>
</html>