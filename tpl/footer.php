<?php 
use zion\core\Session;
use zion\utils\DateTimeUtils;

$info = Session::getInfo();
$user = Session::get("user");
if($user == null){
    $user = new stdClass();
}

$diff   = DateTimeUtils::getSecondsDiff(new DateTime(), $info["expire"]);
$remain = DateTimeUtils::formatDiff($diff);
?>
<footer>
	<div class="center-content">
		<div class="container-fluid">
    		<div class="row">
    			<div class="col-12 col-md-3">
    				<h6>Usuário</h6>
    				Login: <?=$user->login?><br>
    				Perfil: <?=$user->perfil?><br>
    			</div>
    			<div class="col-12 col-md-6">
    				<h6>Sessão</h6>
    				Duração: <?=DateTimeUtils::formatTimeBySeconds($info["expireTime"],"text","h")?><br>
    				Expira em: <?=$info["expire"]->format("d/m/Y H:i:s")?><br>
    				<?=$remain?> <a class="btn btn-outline-info btn-sm" href="/zion/mod/core/User/renewSession">Renovar</a>
    			</div>
    		</div>
    		
    		<div>zionphp - <?=\zion\ENV?></div>
    		<br>
    	</div>
	</div>
</footer>