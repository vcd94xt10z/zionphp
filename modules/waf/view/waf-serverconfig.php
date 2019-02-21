<?php
use zion\core\System;
use zion\core\Page;
?>
<!doctype html>
<html lang="pt">
<head>
    <title>Login</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="icon" href="/zion/lib/favicon.png">
    <!-- styles -->
    <?foreach(Page::css() AS $uri){?>
    <link rel="stylesheet" type="text/css" href="<?=$uri?>">
    <?}?>
	<!-- styles -->
</head>
<body>
	<?php
	$phpiniRisk      = System::get("phpiniRisk");
	$apacheRisk      = System::get("apacheRisk");
	$writableFolders = System::get("writableFolders");
	?>
	<div class="center-content">
		
        <div class="container-fluid">
        	<h2>php.ini</h2>
    		<table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
              		<th scope="col">Configuração</th>
              		<th scope="col">Risco</th>
            	</tr>
            </thead>
            <tbody>
          	<?foreach($phpiniRisk AS $key => $value){?>
            <tr>
              <th scope="row"><?=(++$i)?></th>
              <td><?=$key?></td>
              <td><?=$value?></td>
            </tr>
            <?}?>
           </tbody>
           </table>
           
           <h2>Apache</h2>
    	   <table class="table">
           <thead class="thead-dark">
               <tr>
                   <th scope="col">#</th>
              	   <th scope="col">Configuração</th>
              	   <th scope="col">Risco</th>
               </tr>
           </thead>
           <tbody>
           <?foreach($apacheRisk AS $key => $value){?>
           <tr>
               <th scope="row"><?=(++$i)?></th>
               <td><?=$key?></td>
               <td><?=$value?></td>
           </tr>
           <?}?>
           </tbody>
           </table>
           
           <h2>Arquivos e diretórios graváveis dentro do diretório publico</h2>
    	   <table class="table">
           <thead class="thead-dark">
               <tr>
                   <th scope="col">#</th>
              	   <th scope="col">Caminho</th>
               </tr>
           </thead>
           <tbody>
           <?foreach($writableFolders AS $file){?>
           <tr>
               <th scope="row"><?=(++$i)?></th>
               <td><?=$file?></td>
           </tr>
           <?}?>
           </tbody>
           </table>
           
        </div>
    </div>
	
	<!-- scripts -->
	<?foreach(Page::js() AS $uri){?>
	<script src="<?=$uri?>"></script>
    <?}?>
	<!-- scripts -->
</body>
</html>