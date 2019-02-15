<?php
use zion\core\Session;

$user = Session::get("user");
if($user == null){
    $user = new stdClass();
}

$modules = array();

$files = scandir(\zion\ROOT."modules".\DS);
foreach($files AS $filename){
    if(in_array($filename,array(".",".."))){
        continue;
    }
    $modules[] = $filename;
}

sort($modules);
?>
<header class="<?=\zion\ENV?>-bgcolor fixed-header">
	<div class="center-content">
    	<div class="container-fluid">
    		
    		<div class="row">
    			<div class="col-sm-6">
    				<div id="zion-text" class="float-left">
    					zionphp
    				</div>
    				<select class="float-left" id="module-selector">
            			<option value=""></option>
            			<?foreach($modules AS $module){?>
            			<option value="<?=$module?>"><?=$module?></option>
            			<?}?>
            		</select>
    			</div>
    			<div class="col-sm-6">
    				<div class="float-right">
    					<span class="user-name"><?=$user->user?></span>
    					
    					<a class="btn btn-outline-light btn-sm" href="/zion/mod/core/User/myData">Meus Dados</a>
        				<a class="btn btn-outline-light btn-sm" href="/zion/mod/core/User/logout">Sair</a>
        			</div>
    			</div>
    		</div>
    		<div class="clearfix"></div>
    		
    	</div>
	</div>
</header>