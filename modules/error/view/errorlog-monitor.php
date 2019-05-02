<?php 
use zion\core\System;
use zion\utils\DateTimeUtils;

$resultList = System::get("dataList");
?>
<style>
.big-number {
    font-size: 32px;
}
</style>
<div class="container-fluid">
    <div class="center-content">
    	
    	<div class="row">
    		<div class="col-12">
    			<h1>Monitor de Erros</h1>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-12">
    			<a class="btn btn-outline-primary btn-sm" href="/zion/mod/error/ErrorLog/list">Gerenciamento</a>
    			
    			<br>
    		</div>
    		<div class="col-12">
    			<br>
    			
    			<div class="card-group">
					<?foreach($resultList AS $obj){?>
                	<div class="card">
                    	<div class="card-body">
                      		<h5 class="card-title"><?=$obj->get("type")?></h5>
                      		<p class="card-text big-number">
                      			<?=$obj->get("total")?>
                      		</p>
                      		<p class="card-text">
                      			<small class="text-muted">
                      				<?
                      				if($obj->get("created") != null){
                          				$diff = DateTimeUtils::getSecondsDiff(new DateTime(), $obj->get("created"));
                          				$text = DateTimeUtils::formatTimeBySeconds($diff,"short");
                          				echo $text." atrás";
                      				}
                      				?>
                      			</small>
                      		</p>
                    	</div>
                 	</div>
                 <?}?>
                 </div>
                 
                 <div>
                 	<br>
                 	<a href="/zion/mod/error/ErrorLog/showNextError" class="btn btn-outline-primary btn-lg btn-block" target="_blank">
                 		Resolver
                 	</a>
                 </div>
    		</div>
    	
    	</div>
    	
    </div>
</div>