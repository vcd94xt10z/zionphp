<?php
use zion\core\System;
?>
<!doctype html>
<html lang="pt">
<head>
    <title>Zion - Bem vindo</title>
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

	<div class="container-fluid">
		<main role="main">
            <!-- Main jumbotron for a primary marketing message or call to action -->
          	<div class="jumbotron">
            	<div class="container">
              		<h1 class="display-3">Documentação</h1>
              		<p>Aqui você encontra a documentação.</p>
                    <!--  <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p> -->
            	</div>
          	</div>
          	
          	<div class="container">
                <!-- Example row of columns -->
            	<div class="row">
              		<div class="col-md-4">
                		<h2>Instalação nova</h2>
                		<p>Siga as instruções para configurar o sistema</p>
                		<p>
                			<a class="btn btn-secondary" href="/zion/mod/welcome/Welcome/config" role="button">
                				Detalhes &raquo;
                			</a>
                		</p>
              		</div>
              		<div class="col-md-4">
                		<h2>Administração</h2>
                		<p>Acesse aqui os módulos embutidos no framework</p>
                		<p>
                			<a class="btn btn-secondary" href="/zion/mod/core/User/loginForm" role="button">
                				Acessar &raquo;
                			</a>
                		</p>
              		</div>
              		<div class="col-md-4">
                		<h2>Segurança</h2>
                		<p>Verifique se seu servidor esta configurado de forma correta e segura</p>
                		<p>
                			<a class="btn btn-secondary" href="/zion/mod/waf/WAF/checkServerConfig" role="button">
                				Acessar &raquo;
                			</a>
                		</p>
              		</div>
            	</div>
            	<hr>
			</div> <!-- /container -->
    	</main>
    	
        <footer class="container">
          <p>&copy; Zion 2017-2018</p>
        </footer>
	</div>
	
	<!-- scripts -->
	<?foreach(System::get("view-js") AS $uri){?>
	<script src="<?=$uri?>"></script>
    <?}?>
	<!-- scripts -->
</body>
</html>