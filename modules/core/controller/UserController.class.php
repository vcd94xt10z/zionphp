<?php
namespace zion\mod\core\controller;

use stdClass;
use Exception;
use zion\core\Session;
use zion\core\Page;
use zion\core\System;
use zion\mod\core\standard\controller\UserController AS StandardUserController;

/**
 * Classe gerada pelo Zion Framework em 13/02/2019
 */
class UserController extends StandardUserController {
    public function __construct(){
        parent::__construct(get_class($this),array(
            "table" => "zion_core_user"
        ));
    }
    
    public function actionHome(){
        // input
        
        // process
        $moduleList = array();
        try {
            $db = System::getConnection();
            $dao = System::getDAO($db,"zion_core_module");
            $moduleList = $dao->getArray($db);
        }catch(Exception $e){
        }
        System::set("moduleList",$moduleList);
        
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
        $mandt    = intval(preg_replace("[^0-9]","",$_POST["mandt"]));
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
            $obj->mandt  = $mandt;
            $obj->user   = $user;
            $obj->perfil = "admin";
            
            if($user == "lock"){
                $obj->perfil = "customer";
            }
            
            Session::set("mandt", $mandt);
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