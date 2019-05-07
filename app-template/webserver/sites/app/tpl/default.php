<?php
use zion\core\System;
use zion\core\Page;
?>
<!DOCTYPE html>
<html lang="<?=System::get("lang")?>">
<head>
    <title><?=Page::getTitle()?></title>
    <meta charset="<?=\zion\CHARSET ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="<?=Page::getMeta("robots")?>">
    <?foreach(Page::css() AS $uri){?><link rel="stylesheet" href="<?=$uri?>"><?}?>
</head>
<body>
	<?require(\zion\APP_ROOT."tpl".\DS."header.php");?>
    <div id="content"><?require(Page::getInclude());?></div>
	<div class="clearfix"></div>
    <?require(\zion\APP_ROOT."tpl".\DS."footer.php");?>
	<?foreach(Page::js() AS $uri){?><script src="<?=$uri?>"></script><?}?>
</body>
</html>
