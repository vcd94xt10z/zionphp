<?php 
use zion\core\System;
$modules = System::getZionModules();
?>
<style>
.card {
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>
<div class="container-fluid">
    <div class="center-content">
    	
    	<br>
    	<h2>Modulos disponíveis (<?=sizeof($modules)?>)</h2>
    	<br>
    	
    	<div class="row">
    		<?foreach($modules AS $module){?>
    		<div class="col-sm-3">
    			<div class="card" style="width: 18rem;">
                	<div class="card-body">
                    	<h5 class="card-title"><?=$module?></h5>
                    	<h6 class="card-subtitle mb-2 text-muted"><?=$module?></h6>
                    	<p class="card-text">
                    		Descrição do módulo <?=$module?>
                    	</p>
                    	<a href="/zion/mod/<?=$module?>/" target="_blank" class="card-link">
                    		Acessar
                    	</a>
                  	</div>
                </div>
    		</div>
            <?}?>
    	</div>
    	
    </div>
</div>