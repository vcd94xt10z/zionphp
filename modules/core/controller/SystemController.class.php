<?php
namespace zion\mod\core\controller;

use zion\core\ErrorHandler;

class SystemController {
    public function __construct(){
    }
    
    public function actionJob(){
        ErrorHandler::importLogToDatabase();
        echo "Logs de erro importados";
    }
}
?>