<?php
require(dirname(dirname(dirname(__FILE__)))."/zionphp/autoload.php");
\zion\core\App::route();
echo "Hello world";
?>