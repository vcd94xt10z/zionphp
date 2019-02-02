<?php 
namespace zion\mod\welcome\controller;

use zion\core\System;

class WelcomeController {
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