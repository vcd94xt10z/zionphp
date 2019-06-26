<?php 
use zion\core\System;

$result = System::get("result");
?>
<div class="container-fluid">
<div class="center-content">

	<div class="row">
    	<div class="col-12">
    		<?php 
    		$statusList = array(
    		    "env1_only" => array(
    		        "label" => "Novo",
    		        "color" => "#00cc00"
    		    ),
    		    "env2_only" => array(
    		        "label" => "Deletado",
    		        "color" => "#cc3300"
    		    ),
    		    "diff" => array(
    		        "label" => "Modificado",
    		        "color" => "#0066ff"
    		    )
    		);
    		?>
    		<br>
    		<h1>Diferenças entre ambientes</h1>
    		<br>
    		
    		<div><?=$_POST["source"]?></div>
    		<div><?=$_POST["target"]?></div>
    		<br>
    		
    		<div class="panel panel-info">
    			<div class="panel-heading">Diferença entre Ambientes</div>
    		 	<div class="panel-body">
    		 	
    		 		<h2>Arquivos e Diretórios</h2>
    		 		<div class="table-responsive">
    		 		
                        <table class="table table-sm table-striped table-hover table-bordered table-condensed">
                        <thead>
                        	<tr>
                        		<td style="width:26px"><input type="checkbox" value=""></td>
                        		<td style="width:120px">Status</td>
                        		<td style="width:240px">MD5</td>
                        		<td>Nome</td>
                        		<td style="width:80px">Tamanho</td>
                        		<td style="width:160px">Modificação</td>
                        	</tr>
                        </thead>
                        <tbody>
        		 		<?
        		 		foreach($result["file"] AS $key => $itemList){
        		 		   $status = $statusList[$key];
        		 		   $itemList = is_array($itemList)?$itemList:array();
        		 		   foreach($itemList AS $item){
        		 		       $md5 = "";
        		 		       $size = "";
        		 		       $modification = "";
        		 		       
            		 		   if($key == "diff"){
            		 		       $md5 = $item->md5_env1;
            		 		       $size = "-";
        		 		           $modification = "-";
            		 		   }else{
            		 		       $md5 = $item->md5;
            		 		       $size = $item->size;
        		 		           $modification = $item->modification;
            		 		   }
        		 		       ?>
                                <tr>
                            		<td><input type="checkbox" value=""></td>
                            		<td style="color:<?=$status["color"]?>"><?=$status["label"]?></td>
                            		<td><?=$md5?></td>
                            		<td><?=$item->name?></td>
                            		<td><?=$size?></td>
                            		<td><?=$modification?></td>
                            	</tr>
                        	<?}?>
        		 		<?}?>
                        </tbody>
                        </table>
                        
                        <h2>Objetos do Banco de Dados</h2>
    		 			<table class="table table-sm table-striped table-hover table-bordered table-condensed">
                        <thead>
                        	<tr>
                        		<td style="width:26px"><input type="checkbox" value=""></td>
                        		<td style="width:120px">Status</td>
                        		<td style="width:240px">MD5</td>
                        		<td>Nome</td>
                        		<td style="width:80px">Tamanho</td>
                        		<td style="width:160px">Modificação</td>
                        	</tr>
                        </thead>
                        <tbody>
        		 		<?
        		 		foreach($result["db"] AS $key => $itemList){
        		 		   $status = $statusList[$key];
        		 		   $itemList = is_array($itemList)?$itemList:array();
        		 		   foreach($itemList AS $item){
        		 		       $md5 = "";
        		 		       $size = "";
        		 		       $modification = "";
        		 		       
            		 		   if($key == "diff"){
            		 		       $md5 = $item->md5_env1." <br> ".$item->md5_env2;
            		 		       $size = "-";
        		 		           $modification = "-";
            		 		   }else{
            		 		       $md5 = $item->md5;
            		 		       $size = $item->size;
        		 		           $modification = $item->modification;
            		 		   }
        		 		       ?>
                                <tr>
                            		<td><input type="checkbox" value=""></td>
                            		<td style="color:<?=$status["color"]?>"><?=$status["label"]?></td>
                            		<td><?=$md5?></td>
                            		<td><?=$item->name?></td>
                            		<td><?=$size?></td>
                            		<td><?=$modification?></td>
                            	</tr>
                        	<?}?>
        		 		<?}?>
                        </tbody>
                        </table>
                        
                    </div>
                    
    		 	</div>
    		</div>
		</div>
	</div>
</div>
</div>