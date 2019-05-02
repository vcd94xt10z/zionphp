<?php 
use zion\core\System;
use zion\utils\TextFormatter;

$error = System::get("error");
?>
<style>
.big-number {
    font-size: 32px;
}
.errorHighlight {
    background: #FFEFEF;
}
</style>
<div class="container-fluid">
    <div class="center-content">
    	
    	<?if($error == null){?>
    		<div class="col-12">
    			
    			<div class="alert alert-success" role="alert">
                  Não há erros, parabéns!
                </div>
    			
    		</div>
    		<div class="col-12">
    			<button type="button" class="btn btn-outline-secondary btn-lg btn-block button-close">
                	Fechar
                </button>
    		</div>
    	
    	<?}else{?>
    	<div class="row">
    		<div class="col-12">
    			<div><strong><?=$error->get("message")?></strong></div>
    			<div>Id: <?=$error->get("errorid")?></div>
    			<div>Tipo: <?=$error->get("type")?></div>
    			<div>Data: <?=TextFormatter::format("datetime",$error->get("created"))?></div>
    			<div>Arquivo: <?=$error->get("file")?></div>
    			<div>Linha: <?=$error->get("line")?></div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-12">
    			
    			<?php
    			$offset = 10;
    			$lines = file($error->get("file"),FILE_IGNORE_NEW_LINES);
    			$start = $error->get("line") - $offset;
    			$end   = $error->get("line") + $offset;
    			
    			$source = array();
    			$curline = 1;
    			foreach($lines AS $line){
    			    if($curline >= $start AND $curline <= $end){
    			        $source[$curline] = $line;
    			    }
    			    $curline++;
    			}
    			$code = implode("\n",$source);
    			
    			$code = file_get_contents($error->get("file"));
    			?>
    			
    			<br>
    			<input type="hidden" id="focusline" value="<?=$error->get("line")?>">
    			<textarea class="w-100" id="code" rows="6"><?=$code?></textarea>
    			<br>
    			
    		</div>
    		<div class="col-6">
    			<a href="/zion/mod/error/ErrorLog/resolved/<?=$error->get("errorid")?>" class="btn btn-outline-primary btn-lg btn-block">
                	Resolvido
                </a>
    		</div>
    		<div class="col-6">
    			<button type="button" class="btn btn-outline-secondary btn-lg btn-block button-close">
                	Fechar
                </button>
    		</div>
    		
    	</div>
    	<?}?>
    	
    </div>
</div>