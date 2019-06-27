<?php
use zion\core\Page;
use zion\utils\TextFormatter;
use zion\utils\DateTimeUtils;
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<title>Documentação de Classes e Pacotes (Runtime)</title>
	<meta charset="<?=zion\CHARSET?>">
	<meta name=viewport content="width=device-width, initial-scale=1">
	<!-- STYLES -->
    <?=implode("\n\t",Page::cssTags())?>
    <!-- STYLES -->
	<style>
	#tree {
		width: 300px;
		float: left;
	}
	
	#tree > div{
		clear:both;
		float:left;
	}
	
	#classdoc {
		width: 690px;
		min-height:500px;
		float: left;
		padding-left:10px;
		border-left: 1px solid #aaa;
		margin-bottom: 20px;
	}
	
	#classdoc table {
		width: 100%;
	}
	
	#backLink {
		border: 1px solid #aaa;
		padding: 8px;
		float: left;
		clear:both;
		margin-bottom: 10px;
	}
	
	.annotations label {
		font-weight: bold;
	}
	.annotations span {		
	}
	</style>
</head>
<body>

	<div id="content">
		
		<div id="tree">
			<h1>Pacotes e Classes</h1>
			<div>Pacote Atual: <?=$package?></div>
			<div>
				<?
				$prefix = dirname($prefix);
				if($prefix == "."){
					$prefix = "";
				}
				if($c != null){
					$prefix = dirname($prefix);
				}
				$backLink = "?prefix=".$prefix;
				?>
				<a id="backLink" href="<?=$backLink?>">Voltar</a>
			</div>
			<div>
				<?
				foreach($packageList AS $item){
					$link = "?prefix=".$_GET["prefix"]."/".$item["name"];
					if($c != null){
						$link = "?prefix=".dirname($_GET["prefix"])."/".$item["name"];
					}
				?>
					<div>
						<img src="/zion/mod/phpdoc/view/img/<?=$item["type"]?>.png">
						<a href="<?=$link?>">
							<?=TextFormatter::shortText($item["name"],40)?>
						</a>
						<?if($item["type"] == "package"){?>
							[<?=$item["classCounter"]?> classes]
							[<?=$item["packageCounter"]?> packages]
						<?}?>
					</div>
				<?}?>
			</div>
		</div>
		<div id="classdoc">
			<?if($viewMessage != ""){?>
				<div>Erro ao tentar interpretar arquivo: <?=$viewMessage?></div>
			<?}?>
			<?if($c != null){?>
				<div class="annotations">
					<label>Pacote</label> <span><?=dirname($package)?></span>
				</div>
				<div class="annotations">
					<label>Nome</label> <span><?=$fileInfo["name"]?></span>
				</div>
				<div class="annotations">
					<label>Tamanho</label> <span><?=$fileInfo["size"]?> bytes</span>
				</div>
				<div class="annotations">
					<label>Ultima Modificação</label>
					<span><?=TextFormatter::format("datetime",$fileInfo["updated"])?></span>
				</div>
				<div class="annotations">
					<label>Diferença de tempo</label>
					<span><?=DateTimeUtils::formatTimeBySeconds(DateTimeUtils::getSecondsDiff(new DateTime(),$fileInfo["updated"]),"text")?> atrás</span>
				</div>
				<div class="annotations">
					<label>Linhas</label> <span><?=$fileInfo["lines"]?></span>
				</div>
				<div class="annotations">
					<label>Caracteres</label> <span><?=$fileInfo["chars"]?></span>
				</div>
								
				<h1><?=ucfirst($c["type"])?> <?=$c["name"]?></h1>
				<div>
					<?
					$buffer = array();
					if($c["accessMod"] != ""){
						$buffer[] = $c["accessMod"];
					}					
					$buffer[] = $c["type"];
					$buffer[] = "<b>".$c["name"]."</b>";
					
					if($c["extends"] != ""){
						$buffer[] = "extends <b>".$c["extends"]."</b>";
					}		
					if(sizeof($c["implements"]) > 0){
						$buffer[] = "<br>&nbsp;&nbsp;&nbsp;&nbsp;implements <b>".implode(", ",$c["implements"])."</b>";
					}
					echo implode(" ",$buffer);
					?>
				</div>
				
				<div style="margin: 10px"><?=nl2br($c["doc"]["fullText"])?></div>
				<h3>Anotações (<?=sizeof($c["doc"]["annotations"])?>)</h3>
				<?if(sizeof($c["doc"]["annotations"]) > 0){?>
					<?foreach($c["doc"]["annotations"] AS $k => $v){?>
					<div class="annotations">
						<label><?=$k?></label>
						<span><?=$v?></span>
					</div>
					<?}?>
				<?}else{?>
					<div>Nenhuma anotação definida</div>
				<?}?>
				
				<h2>Constantes (<?=sizeof($c["constants"])?>)</h2>
				<?if(sizeof($c["constants"]) > 0){?>
				<table>
				<thead>
					<tr>
						<td style="width:200px">Nome</td>
						<td style="width:100px">Valor</td>
						<td>Documentação</td>
					</tr>
				</thead>
				<tbody>
				<?foreach($c["constants"] AS $item){?>
					<tr>
						<td><?=$item["name"]?></td>
						<td><?=$item["value"]?></td>
						<td><?=$item["doc"]["shortText"]?></td>
					</tr>
				<?}?>
				</tbody>
				</table>
				<?}else{?>
				<div>Nenhuma constante definida</div>
				<?}?>
				
				<h2>Atributos (<?=sizeof($c["attributes"])?>)</h2>
				<?if(sizeof($c["attributes"]) > 0){?>
				<table>
				<thead>
					<tr>
						<td style="width:100px">Modificadores</td>
						<td style="width:130px">Nome</td>
						<td style="width:130px">Valor padrão</td>
						<td>Documentação</td>
					</tr>
				</thead>
				<tbody>
				<?foreach($c["attributes"] AS $attr){?>
					<tr>
						<td><?=$attr["accessMod"]?> <?=$attr["staticMod"]?></td>
						<td><?=$attr["name"]?></td>
						<td><?=$attr["defaultValue"]?></td>
						<td><?=$attr["doc"]["shortText"]?></td>
					</tr>
				<?}?>
				</tbody>
				</table>
				<?}else{?>
				<div>Nenhum atributo definido</div>
				<?}?>
				
				<h2>Construtor</h2>
				<?if($c["construct"] != null){?>
					<?=$c["construct"]["sign"]?><br>
					<?=$c["construct"]["doc"]["fullText"]?><br>
					<br>
					<?foreach($c["construct"]["doc"]["annotations"] AS $k => $v){?>
						<div class="annotations">
							<label>@<?=$k?></label>
							<span><?=$v?></span>
						</div>
					<?}?>
				<?}else{?>
					<div>Nenhum construtor definido</div>
				<?}?>
				
				<hr>
				
				<h2>Destrutor</h2>
				<?if($c["destruct"] != null){?>
					<?=$c["destruct"]["sign"]?><br>
					<?=$c["destruct"]["doc"]["fullText"]?><br>
					<br>
					<?foreach($c["destruct"]["doc"]["annotations"] AS $k => $v){?>
						<div class="annotations">
							<label>@<?=$k?></label>
							<span><?=$v?></span>
						</div>
					<?}?>
				<?}else{?>
					<div>Nenhum destrutor definido</div>
				<?}?>
				
				<hr>
				
				<h2>Métodos (<?=sizeof($c["functions"])?>)</h2>
				<?if(sizeof($c["functions"]) > 0){?>
				<table>
				<thead>
					<tr>
						<td style="width:120px">Modificadores</td>
						<td>Nome e descrição</td>
					</tr>
				</thead>
				<tbody>
					<?foreach($c["functions"] AS $mi => $m){?>
					<tr>
						<td style="text-align:left" valign="top">
							<?=$m["inheritanceMod"]." ".$m["accessMod"]." ".$m["staticMod"]?>
						</td>
						<td>
							<?=$m["sign"]?><br>
							<?if($m["doc"]["shortText"] != ""){?>							
							<?=nl2br($m["doc"]["shortText"])?>
							<?}?>
						</td>
					</tr>
					<?}?>
				</tbody>
				</table>
				<?}else{?>
				<div>Nenhum método definido</div>
				<?}?>
			<?}else{?>
				<h1>Documentação de Classes e Pacotes (Runtime)</h1>
				<p>Selecione uma classe na parte esquerda da página para carregar sua documentação</p>
			<?}?>
		</div>
		
	</div>
	
	<!-- SCRIPTS -->
	<?=implode("\n\t",Page::jsTags())?>
	<!-- SCRIPTS -->
</body>
</html>