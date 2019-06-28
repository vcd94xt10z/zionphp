<?php
use zion\core\System;
use zion\core\Page;

$phpiniAnalysis  = System::get("phpiniAnalysis");
$apacheAnalysis  = System::get("apacheAnalysis");
$writableFolders = System::get("writableFolders");
?>
<!doctype html>
<html lang="pt">
<head>
    <title><?=Page::getTitle()?></title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="icon" href="/zion/lib/favicon.png">
    <!-- STYLES -->
    <?=implode("\n\t",Page::cssTags())?>
    <!-- STYLES -->
    <style>
    .zcolnum {
        width: 40px;
        text-align: center;
    }
    
    .statusIcon {
        width:20px;
        padding:1px;
    }
    </style>
</head>
<body>
	
    <div class="center-content">
	<div class="container-fluid">
		
		<br>
		<h1>Configurações que podem deixar seu servidor vunerável a ataques</h1>
		<div class="alert alert-warning" role="alert">
            Verifique as configurações e faça os ajustes necessários e atualize esta página até que 
            todos os itens mencionados sejam ajustados
        </div>
        
		<br>
	    <h2>php.ini (<?=sizeof($phpiniAnalysis)?>)</h2>
		<?if(sizeof($phpiniAnalysis) == 0){?>
        <div class="alert alert-success" role="alert">
        	Nenhum problema encontrado, parabêns!
        </div>
        <?}else{?>
	    <div class="table-responsive">
	    <table class="table table-striped table-hover table-bordered table-sm">
        <thead>
            <tr>
                <th class="zcolnum">#</th>
          		<th>Configuração</th>
          		<th style="width: 150px; text-align: center">Valor Local</th>
          		<th style="width: 150px; text-align: center">Valor Global</th>
          		<th style="width: 150px; text-align: center">Status</th>
          		<th style="width: 150px; text-align: center">Proposta</th>
        	</tr>
        </thead>
        <tbody>
          	<?
          	$i = 0;
          	foreach($phpiniAnalysis AS $data){
          	    $statusIcon = '/zion/lib/zion/img/status-ok.png';
          	    if($data["status"] == "error"){
          	        $statusIcon = '/zion/lib/zion/img/status-error.png';
          	    }
          	?>
            <tr>
            	<th class="zcolnum"><?=(++$i)?></th>
                <td><?=$data["param"]?></td>
                <td class="text-center"><?=$data["localValue"]?></td>
                <td class="text-center"><?=$data["globalValue"]?></td>
                <td class="text-center"><img src="<?=$statusIcon?>" class="statusIcon"></td>
                <td class="text-center"><?=$data["propose"]?></td>
            </tr>
            <?}?>
        </tbody>
        </table>
        </div>
        <?}?>
        
        <br>
        <h2>Apache (<?=sizeof($apacheAnalysis)?>)</h2>
        <?if(sizeof($apacheAnalysis) == 0){?>
        <div class="alert alert-success" role="alert">
            Nenhum problema encontrado, parabêns!
        </div>
        <?}else{?>
	    <div class="table-responsive">
	    <table class="table table-striped table-hover table-bordered table-sm">
        <thead>
            <tr>
                <th class="zcolnum">#</th>
          	    <th>Configuração</th>
          	    <th>Risco</th>
            </tr>
        </thead>
        <tbody>
            <?
            $i = 0;
            foreach($apacheAnalysis AS $key => $value){?>
            <tr>
                <th class="zcolnum"><?=(++$i)?></th>
                <td><?=$key?></td>
                <td><?=$value?></td>
            </tr>
            <?}?>
        </tbody>
        </table>
        </div>
        <?}?>
       
        <br>
        <h2>Arquivos e diretórios graváveis (<?=sizeof($writableFolders)?>)</h2>
	    <?if(sizeof($writableFolders) == 0){?>
        <div class="alert alert-success" role="alert">
            Nenhum problema encontrado, parabêns!
        </div>
        <?}else{?>
	    <div class="table-responsive">
	    <table class="table table-striped table-hover table-bordered table-sm">
        <thead>
            <tr>
                <th class="zcolnum">#</th>
          	    <th class="text-center">Tipo</th>
          	    <th class="text-center">Dono</th>
          	    <th class="text-center">Grupo</th>
          	    <th class="text-center" style="width:60px">Perm.</th>
          	    <th>Caminho</th>
          	    <th class="text-center">Modificação</th>
            </tr>
        </thead>
        <tbody>
            <?
            $i = 0;
            $format = "d/m/Y H:i";
            foreach($writableFolders AS $file){
                $stat = fileowner($file);
                $processUser = posix_getpwuid($stat);
                $owner = $processUser['name'];
                
                $stat = filegroup($file);
                $processUser = posix_getpwuid($stat);
                $group = $processUser['name'];
            ?>
            <tr>
                <th class="zcolnum"><?=(++$i)?></th>
                <td class="text-center"><?=filetype($file)?></td>
                <td class="text-center"><?=$owner?></td>
                <td class="text-center"><?=$group?></td>
                <td class="text-center"><?=substr(sprintf('%o', fileperms($file)), -4)?></td>
                <td><?=$file?></td>
                <td class="text-center"><?=date ($format, filemtime($file))?></td>
            </tr>
            <?}?>
        </tbody>
        </table>
        </div>
        <?}?>
        <br>
        
    </div>
    </div>
    
	<!-- SCRIPTS -->
	<?=implode("\n\t",Page::jsTags())?>
	<!-- SCRIPTS -->
</body>
</html>