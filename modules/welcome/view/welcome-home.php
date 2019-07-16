<?php
use zion\core\Page;
?>
<!doctype html>
<html lang="pt">
<head>
    <title>Zion - Bem vindo</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="icon" href="/zion/lib/zion/favicon.png">
    <!-- STYLES -->
    <?=implode("\n\t",Page::cssTags())?>
    <!-- STYLES -->
    <style>
    .text1 {
        min-height: 48px;
    }
    </style>
</head>
<body>

	<div class="container-fluid">
		<main role="main">
            <!-- Main jumbotron for a primary marketing message or call to action -->
          	<div class="jumbotron">
            	<div class="container">
              		<h1>Zion Framework</h1>
              		<p>Aqui você encontra a documentação de como começar, realizar a configuração e testes básicos.</p>
                    <!--  <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p> -->
            	</div>
          	</div>
          	
          	<div class="container">
                <!-- Example row of columns -->
            	<div class="row">
              		<div class="col-md-4">
                		<h3>Instalação / Atualização</h3>
                		<p class="text1">Siga as instruções para configurar o sistema</p>
                		<p>
                			<a class="btn btn-secondary" href="/zion/mod/welcome/Welcome/config" role="button">
                				Detalhes &raquo;
                			</a>
                		</p>
              		</div>
              		<div class="col-md-4">
                		<h3>Segurança</h3>
                		<p class="text1">Verifique se seu servidor esta configurado de forma correta e segura</p>
                		<p>
                			<a class="btn btn-secondary" href="/zion/mod/waf/WAF/checkServerConfig" role="button">
                				Acessar &raquo;
                			</a>
                		</p>
              		</div>
              		<div class="col-md-4">
                		<h3>Administração</h3>
                		<p class="text1">Acesse aqui os módulos embutidos no framework</p>
                		<p>
                			<a class="btn btn-secondary" href="/zion/mod/core/User/loginForm" role="button">
                				Acessar &raquo;
                			</a>
                		</p>
              		</div>
            	</div>
            	<hr>
			</div> <!-- /container -->
    	</main>
    	
        <footer class="container">
          <p>&copy; Zion 2017-<?=date("Y")?></p>
        </footer>
	</div>
	
	<!-- SCRIPTS -->
	<?=implode("\n\t",Page::jsTags())?>
	<!-- SCRIPTS -->
</body>
</html>