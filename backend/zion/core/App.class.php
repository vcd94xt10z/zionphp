<?php
namespace zion\core;

use zion\utils\FileUtils;
use zion\utils\HTTPUtils;

/**
 * @author Vinicius Cesar Dias
 */
class App {
    public static function getModuleRoot(){
        $folder = \zion\APP_ROOT."public".\DS."modules".\DS;
        if(!file_exists($folder)){
            $folder = \zion\APP_ROOT."public_html".\DS."modules".\DS;
        }
        return $folder;
    }
    
    /**
     * Mapea as rotas padrões para os módulos
     */
    public static function route(){
        $uri = explode("/",$_SERVER["REQUEST_URI"]);
        
        if(strpos($_SERVER["REQUEST_URI"],"/mod/") === 0){
            if($uri[3] == "view"){
                $file = \zion\APP_ROOT."public".str_replace("/mod/","/modules/",$_SERVER["REQUEST_URI"]);
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
            
            $module     = preg_replace("[^a-zA-Z0-9]", "", $uri[2]);
            $controller = preg_replace("[^a-zA-Z0-9]", "", $uri[3]);
            $action     = explode("?", $uri[4]);
            $action     = preg_replace("[^a-zA-Z0-9]", "", $action[0]);
            
            $className   = $controller."Controller";
            $classNameNS = "\\mod\\".$module."\\controller\\".$controller."Controller";
            $classFile   = $_SERVER["DOCUMENT_ROOT"]."/modules/".$module."/controller/".$className.".class.php";
            
            if(file_exists($classFile)) {
                require($classFile);
                $ctrl = new $classNameNS();
                
                $methodName = "action".ucfirst($action);
                if(method_exists($ctrl, $methodName)){
                    $ctrl->$methodName();
                    exit();
                }
            }
        }
        
        if(strpos($_SERVER["REQUEST_URI"],"/rest/") === 0){
            $uri = explode("/", $_SERVER["REQUEST_URI"]);
            if(sizeof($uri) < 5){
                HTTPUtils::status(400);
                HTTPUtils::sendHeadersNoCache();
                echo "Padrão de URI Rest inválido";
                exit();
            }
            
            if(!in_array($_SERVER["REQUEST_METHOD"],array("GET","POST","PUT","DELETE","FILTER"))){
                HTTPUtils::status(400);
                HTTPUtils::sendHeadersNoCache();
                echo "Método Rest inválido";
                exit();
            }
            
            // controle
            $module     = preg_replace("[^a-z0-9\_]", "", strtolower($uri[2]));
            $controller = preg_replace("[^a-zA-Z0-9]", "", $uri[3]);
            
            $className   = $controller."Controller";
            $classNameNS = "\\mod\\".$module."\\controller\\".$controller."Controller";
            $classFile   = \zion\APP_ROOT."public/modules/".$module."/controller/".$className.".class.php";
            
            if(file_exists($classFile)) {
                require($classFile);
                $ctrl = new $classNameNS();
                
                $methodName = "rest";
                if(method_exists($ctrl, $methodName)){
                    $ctrl->$methodName();
                    exit();
                }
            }
            
            HTTPUtils::status(404);
            HTTPUtils::sendHeadersNoCache();
            exit();
        }
    }
    
    /**
     * Autoload preparado para funcionar com classes no padrão
     *
     * Referência
     * $obj = new \mod\module1\controller\UserController()
     *
     * Diretório
     * /modules/module1/controller/UserController.class.php
     * @param string $className
     */
    public static function autoload($className){
        if(strpos($className, "lib\\") === 0){
            $folder = rtrim(dirname($_SERVER["DOCUMENT_ROOT"]))."/lib/";
            $file = str_replace("lib\\",$folder,$className).".class.php";
            if(file_exists($file)){
                require($file);
            }
            return;
        }
        
        if(strpos($className, "mod\\") === 0){
            $parts = explode("\\", $className);
            $parts[0] = "modules";
            
            $file = rtrim($_SERVER["DOCUMENT_ROOT"])."/".implode("/", $parts).".class.php";
            if(file_exists($file)){
                require($file);
            }
            return;
        }
    }
}
?>