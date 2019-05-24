<?php 
use zion\core\System;

$moduleList = System::get("moduleList");
?>
<div class="container-fluid">
    <div class="center-content">
    	<br>
    	<h3>Modulos disponíveis (<?=sizeof($moduleList)?>)</h3>
    	<div class="row">
    		<div class="col-12">
        		<div class="table-responsive">
                	<table class="table table-striped table-hover table-bordered table-sm">
                		<thead>
                		<tr>
                			<td style="width: 30px">#</td>
                			<td style="width: 80px">Modulo</td>
                			<td style="width: 80px">Categoria</td>
                			<td>Descrição</td>
                			<td style="width: 100px">Acessar</td>
                		</tr>
                		</thead>
                		<tbody>
        				<?
        				$i = 0;
        				foreach($moduleList AS $obj){
        				?>
        				<tr>
                			<td><?=(++$i)?></td>
                			<td><?=$obj->get("moduleid")?></td>
                			<td><?=$obj->get("category")?></td>
                			<td><?=$obj->get("description")?></td>
                			<td>
                				<a href="/zion/mod/<?=$obj->get("moduleid")?>/" target="_blank">
                            		Link
                            	</a>
                			</td>
                		</tr>
                		<?}?>
                		</tbody>
    				</table>
        		</div>
        	</div>
    	</div>
    </div>
</div>