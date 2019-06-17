<?php
use zion\core\Page;
use zion\core\System;

$errorMessage = System::get("errorMessage");
$password = System::get("password");
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
<body>

	<div class="center-content filter-page">
	<div class="container-fluid">
    
    	<br>
    	<div class="card">
			<div class="card-header">
				Dados Administrativos
			</div>
			<div class="card-body">
				
				<?if($errorMessage != ""){?>
				<div class="alert alert-danger" role="alert"><?=$errorMessage?></div>
				<?}else{?>
				<div class="alert alert-success" role="alert">
					<h6>Usuário admin criado, senha <?=$password?></h6>
				</div>
				<?}?>
				
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