<?php 
use zion\core\System;
use zion\utils\TextFormatter;
use zion\utils\DateTimeUtils;

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
    			
    			<?
    			$diff = DateTimeUtils::getSecondsDiff(new DateTime(), $error->get("created"));
    			$text = DateTimeUtils::formatTimeBySeconds($diff,"text");
    			?>
    			<div>Data: <?=TextFormatter::format("datetime",$error->get("created"))?> (<?=$text?> atrás)</div>
    			<div>Arquivo: <?=$error->get("file")?></div>
    			<div>Linha: <?=$error->get("line")?></div>
    			<div>Erros restantes: <?=System::get("remainErrors")?></div>
    		</div>
    	</div>
    	<div class="row">
    		
    		<?if(System::get("recorrencia") > 0){?>
    		<div class="col-12">
    			<br>
    			<div class="alert alert-warning" role="alert">
            		Atenção! Erro recorrente, já ocorreu <?=System::get("recorrencia")?> vez(es) hoje
            	</div>
            </div>
    		<?}?>
    		
    		<div class="col-12">
    			
    			<?php
    			if(file_exists($error->get("file"))){
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
        			<textarea class="w-100" id="code" rows="6"><?=htmlentities($code)?></textarea>
        			<br>
				<?}else{?>
				<div class="alert alert-warning" role="alert">
            		O arquivo <?=$error->get("file")?> não existe mais
            	</div>
				<?}?>
    			
    		</div>
    		<div class="col-12">
    		
    			<div class="btn-group">
                	<a href="/zion/mod/error/ErrorLog/solve/<?=$error->get("errorid")?>" class="btn btn-primary btn-lg">Resolvido</a>
                  	<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    	<span class="sr-only">Toggle Dropdown</span>
                  	</button>
                    <div class="dropdown-menu">
                    	<a class="dropdown-item" href="/zion/mod/error/ErrorLog/solve/<?=$error->get("errorid")?>">
                    		Resolver apenas este
                    	</a>
                    	<a class="dropdown-item" href="/zion/mod/error/ErrorLog/solveAllSimilar/<?=$error->get("errorid")?>">
                    		Resolver todos semelhantes
                    	</a>
                     </div>
                </div>
                
    		
    			<a href="/zion/mod/error/ErrorLog/showNextError/<?=(System::get("offset")-1)?>" class="btn btn-outline-primary btn-lg">
                	Anterior
                </a>
            
    			<a href="/zion/mod/error/ErrorLog/showNextError/<?=(System::get("offset")+1)?>" class="btn btn-outline-primary btn-lg">
                	Próximo
                </a>
    		
    			<button type="button" class="btn btn-outline-secondary btn-lg button-close" style="float: right">
                	Fechar
                </button>
    		</div>
    		
    	</div>
    	<?}?>
    	
    </div>
</div>