<?php
use zion\utils\HTTPUtils;

require(dirname(dirname(dirname(__FILE__)))."/zionphp/autoload.php");

\zion\core\App::route();

// exemplo de URL amigável
if(strpos($_SERVER["REQUEST_URI"],"/minha-url-amigavel") === 0){
    //$ctrl = new \mod\core\controller\UserController();
    //$ctrl->actionTest();
    exit();
}

// index
if($_SERVER["REQUEST_URI"] == "/"){
    HTTPUtils::status(200);
    echo "Hello world";
    exit();
}

// se chegou até aqui, nenhuma URL encontrada
if(!headers_sent()){
    HTTPUtils::status(404);
    HTTPUtils::template(404);
}
?>