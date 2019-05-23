<?php 
use zion\core\Zion;
use zion\core\Session;
use zion\core\System;

$modules = Zion::getModules();

$user = Session::get("user");
if($user == null){
    $user = new stdClass();
}

$module = System::get("module");
$file = \zion\ROOT."modules/".$module."/menu.php";
$menuExists = false;
if(file_exists($file)){
    $menuExists = true;
    require($file);
}
?>
<style>
    #content {
	   margin-top: 60px;
    }
</style>
<header class="<?=\zion\ENV?>-bgcolor fixed-header">
	<div class="center-content">
    	<div class="container-fluid">
    		
    		<div class="row">
    			<div class="col-sm-12">
    				<div id="zion-text" class="float-left">
    					<a href="/zion/mod/core/User/home">zionphp</a>
    				</div>
    				<select class="float-left" id="module-selector">
            			<option value=""></option>
            			<?foreach($modules AS $module){?>
            			<option value="<?=$module?>"><?=$module?></option>
            			<?}?>
            		</select>
            		
            		<?if($menuExists){?>
            		<i class="fas fa-bars" id="zion-menu-button"></i>
            		<?}?>
            		
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