<?php 
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\proj\model\ProjectUtils;

$obj = System::get("project");
$featureList = $obj->get("featureList");
$testList = $obj->get("testList");
?>
<div class="center-content form-page">
<div class="container-fluid">
	
	<br>
	<h1 class="h1">Projeto <?=$obj->get("name")?></h1>
	
	<div>
		<a class="btn btn-outline-info" href="/zion/mod/proj/">Projetos</a>
		<button class="btn btn-outline-primary button-refresh" type="button">Atualizar</button>
		<a class="btn btn-outline-info" href="/zion/mod/proj/Feature/new/">Novo Requisito</a>
	</div>
	<br>
	
	<h2 class="h2">Requisitos</h2>
	<div class="table-responsive">
    	<table class="table table-striped table-hover table-bordered table-sm">
    		<thead>
    		<tr>
    			<td><input type="checkbox"></td>
    			<td>#</td>
    			<td>Nome</td>
    			<td>Criado em</td>
    			<td>Desenvolvedor</td>
    			<td>Status</td>
    			<td>Liberado para Teste?</td>
    			<td>Complexidade</td>
    			<td>Versão</td>
    			<td>Tempo Estimado</td>
    			<td>Tempo Trabalhado</td>
    			<td>Testes</td>
    			<td>Opções</td>
    		</tr>
    		</thead>
    		<tbody>
    			<?
    			$n = 0;
    			foreach($featureList AS $feat){
    			    $key = $feat->concat(array("mandt","projid","featid"),":");
    				$status = ProjectUtils::getFeatureStatus($feat->get("status"));
    				$complexity = ProjectUtils::getFeatureComplexity($feat->get("complexity"));
    				$releasedToTest = ProjectUtils::getBooleanStatus($feat->get("released_to_test"));
    			?>
    			<tr>
    				<td><input type="checkbox"></td>
    				<td><?=(++$n)?></td>
    				<td><?=$feat->get("name")?></td>
    				<td><?=TextFormatter::format("datetime",$feat->get("created_at"))?></td>
    				<td><?=$feat->get("main_developer")?></td>
    				<td style="color:<?=$status["color"]?>"><?=$status["label"]?></td>
    				<td style="color:<?=$releasedToTest["color"]?>"><?=$releasedToTest["label"]?></td>
    				<td style="color:<?=$complexity["color"]?>"><?=$complexity["label"]?></td>
    				<td><?=TextFormatter::format("integer",$feat->get("version"))?></td>
    				<td><?=TextFormatter::format("double",$feat->get("estimated_time"))?>h</td>
    				<td><?=TextFormatter::format("double",$feat->get("work_time"))?>h</td>
    				<td><?=$feat->get("test_count")?></td>
    				<td>
    					<a class="view" href="/zion/mod/proj/Feature/edit/<?=$key?>" alt="Visualizar" title="Visualizar" target="_blank">
    						<i class="fas fa-eye"></i>
    					</a>
    					<a class="edit" href="/zion/mod/proj/Feature/edit/<?=$key?>" alt="Editar" title="Editar" target="_blank">
    						<i class="fas fa-edit"></i>
    					</a>
    					
    					<?if($feat->get("status") == "E"){?>
    					<button type="button" class="button-pause btn btn-default btn-sm fas fa-pause" data-keys="<?=$key?>" alt="Pausar" title="Pausar"></button>
    					<?}else{?>
    					<button type="button" class="button-play btn btn-default btn-sm fas fa-play" data-keys="<?=$key?>" alt="Iniciar" title="Iniciar"></button>
    					<?}?>
    					
    					<?if($feat->get("released_to_test") == 1){?>
    					<a class="test" href="/zion/mod/proj/Test/new/<?=$key?>" alt="Registrar Teste" title="Registrar Teste" target="_blank">
    						<i class="fas fa-vials"></i>
    					</a>
    					<?}?>
    				</td>
    			</tr>
    			<?}?>
    		</tbody>
    	</table>
    </div>
    
    <br>
    <h2 class="h2">Ultimos testes realizados</h2>
    <div class="table-responsive">
    	<table class="table table-striped table-hover table-bordered table-sm">
    		<thead>
    		<tr>
    			<td>#</td>
    			<td>version</td>
    			<td>testid</td>
    			<td>test_at</td>
    			<td>test_by</td>
    			<td>result</td>
    			<td>device</td>
    			<td>browser</td>
    			<td>Observação</td>
    		</tr>
    		</thead>
    		<tbody>
    			<?
    			$n = 0;
    			foreach($testList AS $test){
    			    $key = $test->concat(array("mandt","projid","featid"),":");
    				?>
    			<tr>
    				<td><?=(++$n)?></td>
    				<td><?=TextFormatter::format("integer",$test->get("version"))?></td>
    				<td><?=TextFormatter::format("integer",$test->get("testid"))?></td>
    				<td><?=TextFormatter::format("datetime",$test->get("test_at"))?></td>
    				<td><?=TextFormatter::format("string",$test->get("test_by"))?></td>
    				<td><?=TextFormatter::format("string",$test->get("result"))?></td>
    				<td><?=TextFormatter::format("string",$test->get("device"))?></td>
    				<td><?=TextFormatter::format("string",$test->get("browser"))?></td>
    				<td><?=TextFormatter::format("string",$test->get("note"))?></td>
    			</tr>
    			<?}?>
    		</tbody>
    	</table>
    </div>
	
</div>
</div>