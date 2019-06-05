<?php 
use zion\core\System;
use zion\utils\TextFormatter;

$projectList = System::get("projectList");
?>
<div class="center-content form-page">
<div class="container-fluid">
	
	<br>
	<h1 class="h1">Projetos</h1>
	<br>
	<div class="card-group">
	<?foreach($projectList AS $project){?>
	<div class="card">
        <div class="card-body">
          <h5 class="card-title"><?=$project->get("name")?></h5>
          <p class="card-text"><?=$project->get("description")?></p>
          <p class="card-text">
          	Tempo estimado: <?=$project->get("estimated_time")?>h<br>
          	Tempo efetivo: <?=$project->get("work_time")?>h
          </p>
          <a href="/zion/mod/proj/Project/resume/<?=$project->get("projid")?>" class="btn btn-primary">Entrar</a>
        </div>
        <div class="card-footer">
          <small class="text-muted">Criado em <?=TextFormatter::format("datetime",$project->get("created_at"))?></small>
        </div>
      </div>
		
	<?}?>
	</div>
	
</div>
</div>