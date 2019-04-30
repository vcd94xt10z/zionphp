<?php
namespace zion\core;

use zion\utils\FileUtils;
use zion\mod\welcome\controller\WelcomeController;
use zion\utils\HTTPUtils;

/**
 * @author Vinicius Cesar Dias
 */
class Zion {
    public static function getModules(){
        $modules = array();
        $files = scandir(\zion\ROOT."modules".\DS);
        foreach($files AS $filename){
            if(in_array($filename,array(".",".."))){
                continue;
            }
            $modules[] = $filename;
        }
        sort($modules);
        return $modules;
    }
    
    /**
     * Chamar esse método caso utilize arquivos de frontend de modulos
     */
    public static function route(){
        if(strpos($_SERVER["REQUEST_URI"],"/zion/") !== 0){
            return;
        }
        
        if($_SERVER["REQUEST_URI"] == "/zion/"){
            $ctrl = new WelcomeController();
            $ctrl->actionHome();
            exit();
        }
        
        // framework / bibliotecas frontend
        if(strpos($_SERVER["REQUEST_URI"],"/zion/lib/") === 0){
            $file = \zion\ROOT."frontend".str_replace("/zion/lib/","/",$_SERVER["REQUEST_URI"]);
            $file = explode("?",$file);
            $file = $file[0];
            
            if(file_exists($file)){
                FileUtils::inline($file);
            }else{
                header("HTTP/1.0 404 Not Found");
            }
            exit();
        }
        
        if(strpos($_SERVER["REQUEST_URI"],"/zion/rest/") === 0){
            $uri = explode("/", $_SERVER["REQUEST_URI"]);
            if(sizeof($uri) < 6){
                header("HTTP/1.0 400 Error");
                echo "Padrão de URI Rest inválido";
                exit();
            }
            
            if(!in_array($_SERVER["REQUEST_METHOD"],array("GET","POST","PUT","DELETE","FILTER"))){
                header("HTTP/1.0 400 Error");
                echo "Método Rest inválido";
                exit();
            }
            
            // controle
            $module     = preg_replace("[^a-z0-9\_]", "", strtolower($uri[3]));
            $controller = preg_replace("[^a-zA-Z0-9]", "", $uri[4]);
            
            $className   = $controller."Controller";
            $classNameNS = "\\zion\\mod\\".$module."\\controller\\".$controller."Controller";
            $classFile   = \zion\ROOT."modules/".$module."/controller/".$className.".class.php";
            
            if(file_exists($classFile)) {
                require($classFile);
                $ctrl = new $classNameNS();
                
                $methodName = "rest";
                if(method_exists($ctrl, $methodName)){
                    self::checkSession();
                    $ctrl->$methodName();
                    exit();
                }
            }
            
            header("HTTP/1.0 404 Not Found");
            exit();
        }
        
        if(strpos($_SERVER["REQUEST_URI"],"/zion/mod/") === 0){
            $uri = explode("/", $_SERVER["REQUEST_URI"]);
            
            if(sizeof($uri) == 5 AND $uri[4] == "") {
                $module = preg_replace("[^a-z0-9\_]", "", strtolower($uri[3]));
                $file = \zion\ROOT."modules/".$module."/index.php";
                if(file_exists($file)){
                    require($file);
                    exit();
                }
            }
            
            if(sizeof($uri) < 6) {
                HTTPUtils::status(404);
                HTTPUtils::template(404);
                exit();
            }
            
            $module = preg_replace("[^a-z0-9\_]", "", strtolower($uri[3]));
            
            // padrão de view
            if($uri[4] == "view"){
                $file = \zion\ROOT.str_replace("/zion/mod/","/modules/",$_SERVER["REQUEST_URI"]);
                $file = explode("?",$file);
                $file = $file[0];
                
                if(file_exists($file)){
                    FileUtils::inline($file);
                    exit();
                }
                
                HTTPUtils::status(404);
                HTTPUtils::template(404);
                exit();
            }
        }
        
        // padrão de controle
        $controller = preg_replace("[^a-zA-Z0-9]", "", $uri[4]);
        $action     = explode("?", $uri[5]);
        $action     = preg_replace("[^a-zA-Z0-9]", "", $action[0]);
        
        $className   = $controller."Controller";
        $classNameNS = "\\zion\\mod\\".$module."\\controller\\".$controller."Controller";
        $classFile   = \zion\ROOT."modules/".$module."/controller/".$className.".class.php";
        
        if(file_exists($classFile)){
            require($classFile);
            $ctrl = new $classNameNS();
            
            $methodName = "action".ucfirst($action);
            if(method_exists($ctrl, $methodName)){
                self::checkSession();
                $ctrl->$methodName();
                exit();
            }
        }
        
        HTTPUtils::status(404);
        HTTPUtils::template(404);
        exit();
    }
    
    public static function checkSession(){
        // verificando se o usuário esta logado
        if(!self::isFreeURI()){
            $user = Session::get("user");
            if($user == null){
                HTTPUtils::status(401);
                HTTPUtils::template(401);
                exit();
            }
        }
    }
    
    public static function isFreeURI(){
        $freeURIs = array(
            "/zion/mod/core/User/loginform",
            "/zion/mod/core/User/login",
            "/zion/mod/core/User/logout",
            "/zion/mod/welcome/",
            "/zion/mod/monitor/Object/monitor",
            "/zion/mod/monitor/Object/crontab",
            "/zion/mod/monitor/Object/changeSound",
            "/zion/mod/monitor/Object/getNotifications",
        );
        
        foreach($freeURIs AS $uri){
            if(strpos($_SERVER["REQUEST_URI"],$uri) === 0){
                return true;
            }
        }
        return false;
    }
}