<?php 
use zion\core\Session;

$obj = Session::get("user");
?>
<div class="center-content">
	<?php
	var_dump($obj);
	?>
</div>