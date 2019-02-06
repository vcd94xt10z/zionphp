<?php 
namespace zion\mod\welcome\controller;

use zion\core\System;

class WelcomeController {
    public function actionConfig(){
        System::add("view-css","/zion/mod/welcome/view/css/welcome-config.css");
        System::add("view-js","/zion/mod/welcome/view/js/welcome-config.js");
        require(\zion\ROOT."modules/welcome/view/welcome-config.php");
    }
    
    public function actionHome(){
        // input
        
        // process
        
        // view
        System::add("view-css","/zion/mod/welcome/view/css/welcome-home.css");
        System::add("view-js","/zion/mod/welcome/view/js/welcome-home.js");
        require(\zion\ROOT."modules/welcome/view/welcome-home.php");
    }
}
?>