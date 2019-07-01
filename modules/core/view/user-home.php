<?php 
use zion\core\System;
use zion\utils\ServerUtils;

$moduleList = System::get("moduleList");
$dataChart = System::get("dataChart");

$info = ServerUtils::getServerInfo();
$cpuList = ServerUtils::getCPUInfo();
$diskInfo = ServerUtils::getDiskInfo();
$memInfo = ServerUtils::getMemoryInfo();
?>
<div class="container-fluid">
    <div class="center-content">
    	<br>
    	<h3>Sistema</h3>
    	<div class="row">
    		<div class="col-lg-4">
    			
    			<div style="font-size:14px">
        			<h6>Servidor <?=$info["name"]?></h6>
        			Hostname <?=$info["hostname"]?><br>
        			Versão <?=$info["version"]?><br>
        			Build <?=$info["build"]?><br>
        			Arquitetura <?=$info["arch"]?><br>
        			<br>
        			
        			<h6>Processador (Núcleos)</h6>
        			<?foreach($cpuList AS $fields){
        			    echo implode(" ",array_values($fields))."<br>";
        			}?>
        			<br>
        			<h6>Memória RAM</h6>
        			<div>
        				<?=intval($memInfo["total"])?> MB<br>
        				
        				<div class="progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="<?=intval($memInfo["used"])?>" 
                            style="width: <?=intval($memInfo["usep"])?>%;" 
                          	aria-valuemin="0" aria-valuemax="<?=intval($memInfo["total"])?>"></div>
                        </div>
                        <br>
        			</div>
    			</div>
    			
    		</div>
    		<div class="col-lg-8">
    			<h6>Discos</h6>
    			<?foreach($diskInfo AS $data){?>
    			<div>
    				<?=$data["path"]?> (<?=intval($data["total"])?> MB)<br>
    				
    				<div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="<?=intval($data["used"])?>" 
                        style="width: <?=intval($data["usep"])?>%;" 
                      	aria-valuemin="0" aria-valuemax="<?=intval($data["total"])?>"></div>
                    </div>
                    <br>
    			</div>
    			<?}?>
    		</div>
    		<div class="col-lg-12">
    			<h3>Modulos disponíveis (<?=sizeof($moduleList)?>)</h3>
    			
        		<div class="table-responsive">
                	<table class="table table-hover table-sm">
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
    	
    	<br>
    	<h3>
    		Gráficos Diários
    		<button type="button" data-url="/zion/mod/core/User/collectHistdata" class="ajaxlink btn btn-outline-info btn-sm">
    			Coletar dados
    		</button>
    	</h3>
    	
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