<?php
use zion\core\System;
use zion\utils\HTTPUtils;

$pg = System::get("pageConfig");
?>
<!DOCTYPE html>
<html lang="<?=System::get("lang")?>">
<head>
    <title><?= $pg["title"] ?></title>
    <meta charset="<?=\zion\CHARSET ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="index">
    <?foreach(System::get("view-css") AS $uri){?><link rel="stylesheet" href="<?=HTTPUtils::addRandomParam($uri)?>"><?}?>
</head>
<body>
	<?require(\zion\APP_ROOT."tpl".\DS."header.php");?>
    <div id="content"><?require($pg["include"]);?></div>
	<div class="clearfix"></div>
    <?require(\zion\APP_ROOT."tpl".\DS."footer.php");?>
	<?foreach(System::get("view-js") AS $uri){?><script src="<?=HTTPUtils::addRandomParam($uri)?>"></script><?}?>
</body>
</html>
