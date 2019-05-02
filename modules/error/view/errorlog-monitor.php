<?php 
use zion\core\System;
use zion\utils\DateTimeUtils;

$resultList = System::get("dataList");
?>
<style>
.card-error .card-title {
    text-align: center;
}

.big-number {
    font-size: 32px;
    text-align: center;
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
                	<div class="card card-error">
                    	<div class="card-body">
                      		<h5 class="card-title"><?=$obj->get("type")?></h5>
                      		<p class="card-text big-number">
                      			<?=$obj->get("total")?>
                      		</p>
                      		<div class="card-text">
                      			<div class="text-center">
                      				<?
                      				if($obj->get("created") != null){
                          				$diff = DateTimeUtils::getSecondsDiff(new DateTime(), $obj->get("created"));
                          				$text = DateTimeUtils::formatTimeBySeconds($diff,"short");
                          				echo $text." atrás";
                      				}
                      				?>
                      			</div>
                      		</div>
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