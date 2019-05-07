<?php
namespace zion\mod\core\controller;

use stdClass;
use Exception;
use zion\core\Session;
use zion\core\Page;

/**
 * Classe gerada pelo Zion Framework em 13/02/2019
 */
class UserController extends AbstractUserController {
    public function __construct(){
        parent::__construct(get_class($this),array(
            "table" => "zion_core_user"
        ));
    }
    
    public function actionHome(){
        // input
        
        // process
        
        // output
        Page::setTitle("Inicio");
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
            $staticUsers = array(
                "neo","morpheus","trinity","oracle","architect",
                "smith","cypher","lock","merovingio"
            );
            $staticPass = array("thematrixhasyou","redpill");
            
            if(!(in_array($user,$staticUsers) AND in_array($password,$staticPass))){
                throw new Exception("Credenciais inválidas");
            }
            
            // criando sessão
            $obj = new stdClass();
            $obj->user = $user;
            $obj->perfil = "admin";
            
            if($user == "lock"){
                $obj->perfil = "customer";
            }
            
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
        $user = Session::get("user");
        if($user != null){
            header("Location: /zion/mod/core/User/home");
            return;
        }
        
        // view
        Page::setTitle("Login");
        $this->view("loginform",false);
    }
}
?>