<?php
use zion\core\System;
use zion\core\Page;
?>
<!doctype html>
<html lang="pt">
<head>
    <title>Zion - Configuração</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="icon" href="/zion/lib/zion/favicon.png">
    <!-- styles -->
    <?foreach(Page::css() AS $uri){?>
    <link rel="stylesheet" type="text/css" href="<?=$uri?>">
    <?}?>
	<!-- styles -->
</head>
<body>
	
	<div class="container-fluid center-content">
		
		<div class="row">
			<div class="col-12">
				<br>
				<h1>Assistente de Configuração</h1>
				<br>
				
				<div id="error-message" class="alert alert-danger" role="alert"></div>
				
				<table>
				<thead>
					<tr>
						
						<td>
							<h2>1) Arquivo de configuração</h2>
                			<p>Copie o arquivo sample-config.json para config.json e siga o padrão, informando os dados
                			do banco</p>
						</td>
						<td valign="top">
							<img id="img-step1" src="/zion/lib/zion/img/status-warning.png">
						</td>
						<td valign="top">
							<button type="button" class="button-check" data-step="1">Verificar</button>
						</td>
					</tr>
					<tr>
						
						<td>
							<h2>2) Importe o dump do banco</h2>
                			<p>Para utilizar todos as funcionalidades dos módulos, importe o dump do banco de dados</p>
						</td>
						<td valign="top">
							<img id="img-step2" src="/zion/lib/zion/img/status-warning.png">
						</td>
						<td valign="top">
							<button type="button" class="button-check" data-step="2">Verificar</button>
						</td>
					</tr>
					<tr>
						<td>
							<h2>3) Teste a configuração</h2>
    						<p>Verifique se o servidor e o ambiente estão corretamente configurados</p>
						</td>
						<td valign="top">
							<img id="img-step3" src="/zion/lib/zion/img/status-warning.png">
						</td>
						<td valign="top">
							<button type="button" class="button-check" data-step="3">Verificar</button>
						</td>
					</tr>
				</thead>
				</table>
				
				<div>
					<a href="/zion/">Voltar</a>
				</div>
				
    		</div>
		</div>
    	
	</div>
	
	<!-- scripts -->
	<?foreach(Page::js() AS $uri){?>
	<script src="<?=$uri?>"></script>
    <?}?>
	<!-- scripts -->
</body>
</html>