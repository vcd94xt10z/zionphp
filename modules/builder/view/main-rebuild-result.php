<?php 
use zion\core\System;
use zion\utils\TextFormatter;

$objList = System::get("resultList");
?>
<div class="container-fluid">
    <div class="center-content">
    	
    	<br>
    	<h3>Resultado</h3>
    	<div class="table-responsive">
    	<table class="table table-striped table-hover table-bordered table-sm">
    		<thead>
    		<tr>
    			<td style="width:30px; text-align:center">#</td>
    			<td style="width:60px">Destino</td>
    			<td style="width:80px">Modulo</td>
    			<td style="width:120px">Entidade</td>
    			<td style="width:30px; text-align:center">Resultado</td>
    			<td>Mensagem</td>
    		</tr>
    		</thead>
    		<tbody>
    			<?
    			$n = 0;
    			foreach($objList AS $obj){
    			    $color = "#000";
    			    if($obj->get("result") == "OK"){
    			        $color = "#0a0";
    			    }elseif($obj->get("result") == "ERR"){
    			        $color = "#a00";
    			    }
    			?>
    			<tr>
    				<td style="text-align:center"><?=(++$n)?></td>
    				<td><?=TextFormatter::format("string",$obj->get("destiny"))?></td>
    				<td><?=TextFormatter::format("string",$obj->get("module"))?></td>
    				<td><?=TextFormatter::format("string",$obj->get("entity"))?></td>
    				<td style="text-align:center;color: <?=$color?>">
    					<?=TextFormatter::format("string",$obj->get("result"))?>
    				</td>
    				<td><?=TextFormatter::format("string",$obj->get("message"))?></td>
    			</tr>
    			<?}?>
    		</tbody>
    		</table>
    	</div>
    	
	</div>
</div>