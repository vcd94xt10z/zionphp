<?php
use zion\utils\HTTPUtils;

require(dirname(dirname(dirname(__FILE__)))."/zionphp/autoload.php");

\zion\core\App::route();

// teste
HTTPUtils::status(200);
echo "Hello world";

if(!headers_sent()){
    HTTPUtils::status(404);
    HTTPUtils::template(404);
}
?>