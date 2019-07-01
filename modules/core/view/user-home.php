<?php 
use zion\core\System;
use zion\utils\ServerUtils;

$moduleList = System::get("moduleList");
$dataChart = System::get("dataChart");
?>
<div class="container-fluid">
    <div class="center-content">
    	<br>
    	<div class="row">
    		<div class="col-4">
    			<h3>Sistema</h3>
    			
    			<div style="font-size:14px">
        			<?
        			$info = ServerUtils::getServerInfo();
        			$cpuList = ServerUtils::getCPUInfo();
        			?>
        			Servidor <?=$info["name"]?><br>
        			Hostname <?=$info["hostname"]?><br>
        			Versão <?=$info["version"]?><br>
        			Build <?=$info["build"]?><br>
        			Arquitetura <?=$info["arch"]?><br>
        			<br>
        			
        			<h6>Processadores</h6>
        			<?foreach($cpuList AS $fields){
        			    echo implode(" ",array_values($fields))."<br>";
        			}?>
        			
        			<br>
        			<h6>Discos</h6>
    			
    			</div>
    		</div>
    		<div class="col-8">
    			<h3>Modulos disponíveis (<?=sizeof($moduleList)?>)</h3>
    			
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
    	
    	<h3>Gráficos Diários</h3>
    	<div class="row" id="zcharts"></div>
    	
    </div>
</div>
<script>
	var dataChart = []; 
	<?
	foreach($dataChart AS $obj){
    	$labels = array();
    	$values = array();
    	foreach($obj["data"] AS $item){
    	    $labels[] = $item->get("date")->format("d/m/Y");
    	    $values[] = $item->get("value");
    	}
    	?>
    	dataChart.push({
        	title: '<?=$obj["title"]?>',
        	label: '<?=$obj["label"]?>',
    		labels: ['<?=implode("','",array_reverse($labels))?>'],
    		values: ['<?=implode("','",array_reverse($values))?>'],
        });
    <?}?>
</script>