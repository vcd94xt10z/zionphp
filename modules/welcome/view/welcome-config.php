<?php
use zion\core\System;
?>
<!doctype html>
<html lang="pt">
<head>
    <title>Zion - Configuração</title>
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
	
	<div class="container-fluid center-content">
		<div class="row">
			<div class="col-12 col-sm-4">
				asdfadf
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-sm-4">
    			<ol>
    				<li>Inicio</li>
    				<li>Configuração</li>
    				<li>Importação do Banco</li>
    				<li>Concluído</li>
    			</ol>
    		</div>
    		<div class="col-12 col-sm-8 bloco" id="bloco-inicio">
    			
    			Bem vindo ao assistente de configuração, clique em iniciar
    			
    		</div>
    		<div class="col-12 col-sm-8 bloco" id="bloco-configuracao">
    			
    			<table>
    				
    			</table>
    			
    		</div>
		</div>
    	
	</div>
	
	<!-- scripts -->
	<?foreach(System::get("view-js") AS $uri){?>
	<script src="<?=$uri?>"></script>
    <?}?>
	<!-- scripts -->
</body>
</html>