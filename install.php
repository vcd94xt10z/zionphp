<?php
$checkAll = ($_GET["checkAll"] == "1");

function validateAll(){
    $checkList = array();
    
    // short_open_tag
    $value = (string)strtolower(ini_get("short_open_tag"));
    if(!in_array($value,array("on","1"))){
        $checkList[] = array(
            "type"   => "danger",
            "reason" => "Parâmetro short_open_tag esta desativado",
            "fix"    => "Ative o parâmetro no php.ini mudando seu valor para 1"
        );
    }
    
    // modulos
    $mods = array(
        "mbstring","pdo","mysqlnd","json","xml","soap","zip",
        //"process","posix"
    );
    foreach($mods AS $mod){
        if(!extension_loaded($mod)){
            $checkList[] = array(
                "type"    => "danger",
                "reason"  => "A extensão {$mod} não esta instalada",
                "fix"     => "Instale a extensão {$mod}"
            );
        }
    }
    
    return $checkList;
}

$checkList = array();
if($checkAll){
    $checkList = validateAll();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <title>Zion Framework - Instalação e Configuração</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="noindex">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
	   @import url('https://fonts.googleapis.com/css?family=Montserrat');
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
			
				<br>
                <?php if(!$checkAll){?>
                
                <h1>Bem vindo</h1>
                <p>Esse script vai verificar os requisitos minimos para utilizar o framework.</p>
                
                <p>Você pode se adiantar e instalar as extensões abaixo, o comando pode variar de distribuição de Linux:</p>
                <code>yum install php-mbstring php-pdo php-mysqlnd php-json php-xml php-soap php-zip php-xdebug php-process php-posix</code><br>
                <br>
                
                <p>O gerenciador de dependencias <strong>composer</strong> deve estar instalado no sistema, acesse:</p>
                <code>https://getcomposer.org/</code><br>
                <br>
                
                <div>
                	<br>
                	<a class="btn btn-primary" href="/zion/install/?checkAll=1">
                		Iniciar verificação
                	</a>
                </div>
                <?php }else{
                    if(sizeof($checkList) == 0){
                    ?>
                    	<h1>Parabéns</h1>
                    	<p>Todos os parâmetros do sistema estão OK. Você já pode começar a usar o framework.</p>
                    	<p>Qualquer duvida, acesse o site do projeto e relate o problema para que possamos te ajudar.</p>
                    	<div>
                        	<a class="btn btn-outline-success" href='/zion/'>Continuar</a>
                        </div>
                    <?php
                    }else{
                        echo "<div>O sistema encontrou alguns problemas que precisam ser corrigidos</div>";
                        foreach($checkList AS $arr){
                        ?>
                        <div class="alert alert-<?php echo $arr["type"];?>" role="alert">
                          <div>Problema: <?php echo $arr["reason"];?></div>
                          <div>Solução: <?php echo $arr["fix"];?></div>
                          
                          <?php if($arr["command"] != ""){?>
                          <code><?php echo $arr["command"];?></code>
                          <?php }?>
                        </div>
                        <?php
                        }
                        
                        echo "<a href='/zion/install/?checkAll=1'>Testar novamente</a>";
                    }
                }?>
        	</div>
    	</div>
	</div>
</body>
</html>