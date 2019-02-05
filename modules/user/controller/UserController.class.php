<?php 
namespace zion\mod\user\controller;

use Exception;
use zion\core\AbstractController;
use zion\core\Session;

class UserController extends AbstractController {
    public function __construct(){
        parent::__construct(get_class($this));
    }
    
    public function actionHome(){
        // input
        
        // process
        
        // output
        $this->loadZionDefaultView("home");
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
            $obj = new \stdClass();
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
        $this->loadZionView("loginform");
    }
}
?>