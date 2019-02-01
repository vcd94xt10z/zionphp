<?php 
namespace zion\mod\user\controller;

use zion\core\System;

class UserController {
    public function actionLogin(){
        header('HTTP/1.0 403 Forbidden');
        echo "Login inválido";
    }
    
    public function actionLoginForm(){
        // input
        
        // process
        
        // view
        System::add("view-css","/zion/mod/user/view/css/user-loginform.css");
        System::add("view-js","/zion/mod/user/view/js/user-loginform.js");
        require(\zion\ROOT."modules/user/view/user-loginform.php");
    }
}
?>