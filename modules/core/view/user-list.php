<?php 
use zion\core\System;

$result = System::get("result");
$result = is_array($result)?$result:[];
?>
<div class="center-content">
    <div class="container-fluid">
    
    	<div>
    		Filtro
    	</div>
    	
    	<div>
    		<table>
    		<thead>
    			<tr>
    				<td>#</td>
    				<td>login</td>
    			</tr>
    		</thead>
    		<tbody>
    		<?foreach($result AS $obj){?>
    			<tr>
    				<td><?=(++$i)?></td>
    				<td><?=$obj->get("login")?></td>
    			</tr>
    		<?}?>
    		</tbody>
    		</table>
    	</div>
    	
    </div>
</div>