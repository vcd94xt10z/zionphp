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
<header class="<?=\zion\ENV?>-bgcolor">
	<div class="center-content">
		
		<div class="row">
			<div class="col-6 col-md-6">
				<div class="float-left">
					zionphp
				</div>
				<select class="float-left">
        			<option value=""></option>
        			<?foreach($modules AS $module){?>
        			<option value="<?=$module?>"><?=$module?></option>
        			<?}?>
        		</select>
			</div>
			<div class="col-6 col-md-6">
				<div class="float-right">
					<?=$user->user?>
    				[<a href="/zion/mod/user/User/logout">Sair</a>]
    			</div>
			</div>
		</div>
		<div class="clearfix"></div>
		
	</div>
</header>