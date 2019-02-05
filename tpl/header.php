<?php 
$modules = array();
/*
$files = scandir(\zion\ROOT."public".\DS."modules".\DS);
foreach($files AS $filename){
    if(in_array($filename,array(".","..","builder"))){
        continue;
    }
    $modules[] = $filename;
}
*/
sort($modules);
?>
<header class="<?=\zion\ENV?>-bgcolor">
	<div class="center-content container-fluid">
	
    	<nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/">Zion FW</a>
            </div>
            
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<form class="navbar-form navbar-left">
                	<div class="form-group">
                    	<input type="text" class="form-control" placeholder="Busca">
                    </div>
					<button type="submit" class="btn btn-default">OK</button>
              	</form>
            
              <ul class="nav navbar-nav">
              	<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	Modulos <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                  	<li><a href="/modules/builder/">builder</a></li>
                  	<li role="separator" class="divider"></li>
                  	<?foreach($modules AS $module){?>
                    <li><a href="/modules/<?=$module?>/"><?=$module?></a></li>
                    <?}?>
                  </ul>
                </li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Sair</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  	Opções <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Meus dados</a></li>
                    <li><a href="#">Trocar Senha</a></li>
                    <!-- <li role="separator" class="divider"></li> -->
                  </ul>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    
	</div>
</header>