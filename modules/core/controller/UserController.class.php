<?php 
namespace zion\mod\core\controller;

use Exception;
use stdClass;
use zion\core\AbstractController;
use zion\core\Session;
use zion\core\System;

class UserController extends AbstractController {
    public function __construct(){
        parent::__construct(get_class($this));
    }
    
    public function actionList(){
        // input
        
        // process
        try {
            $db = System::getConnection();
            $dao = System::getDAO($db,"user");
        }catch(Exception $e){
            
        }
        
        // output
        $this->view("list");
    }
    
    public function actionHome(){
        // input
        
        // process
        
        // output
        $this->view("home");
    }
    
    public function actionRenewSession(){
        Session::renew();
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
    
    public function actionLogout(){
        Session::set("user",null);
        Session::destroy();
        header("Location: /zion/mod/core/User/loginForm");
    }
    
    public function actionLogin(){
        // input
        $user     = preg_replace("[^0-9a-zA-Z\_]","",$_POST["user-login"]);
        $password = preg_replace("[^0-9a-zA-Z\_\-]","",$_POST["user-password"]);
        
        // process
        try {
            if(!($user == "admin" AND $password == "123456")){
                throw new Exception("Credenciais inválidas");
            }
            
            // criando sessão
            $obj = new stdClass();
            $obj->user = $user;
            Session::set("user", $obj);
            
            echo "OK";
        }catch(Exception $e){
            header('HTTP/1.0 403 Forbidden');
            echo $e->getMessage();
        }
    }
    
    public function actionLoginForm(){
        // input
        
        // process
        
        // view
        $this->view("loginform",false);
    }
}
?>