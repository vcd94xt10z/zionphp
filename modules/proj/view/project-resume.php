<?php 
use zion\core\System;
use zion\utils\TextFormatter;
use zion\mod\proj\model\ProjectUtils;

$obj = System::get("project");
$featureList = $obj->get("featureList");
?>
<div class="center-content form-page">
<div class="container-fluid">
	
	<br>
	<h1 class="h1">Projeto <?=$obj->get("name")?></h1>
	<br>
	
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
    			foreach($featureList AS $feat){
    				$key = $obj->concat(array("mandt","projid","featid"),":");
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
    					<a class="view" href="/" alt="Visualizar" title="Visualizar" target="_blank">
    						<i class="fas fa-eye"></i>
    					</a>
    					<a class="edit" href="/" alt="Editar" title="Editar" target="_blank">
    						<i class="fas fa-edit"></i>
    					</a>
    					<a class="edit" href="/" alt="Iniciar" title="Editar" target="_blank">
    						<i class="fas fa-play"></i>
    					</a>
    				</td>
    			</tr>
    			<?}?>
    		</tbody>
    	</table>
    </div>
	
</div>
</div>