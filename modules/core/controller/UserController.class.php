<?php
namespace zion\mod\core\controller;

use zion\core\Session;
use stdClass;
use Exception;

/**
 * Classe gerada pelo Zion Framework em 13/02/2019
 */
class UserController extends AbstractUserController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "core_user"
		));
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
	    $user = Session::get("user");
	    if($user != null){
	        header("Location: /zion/mod/core/User/home");
	        return;
	    }
	    
	    // view
	    $this->view("loginform",false);
	}
}
?>