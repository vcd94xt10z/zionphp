<?php 
namespace zion\mod\user\controller;

class UserController {
    public function actionLoginForm(){
        require(\zion\ROOT."modules/user/view/user-loginform.php");
    }
}
?>