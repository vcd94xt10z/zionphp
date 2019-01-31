<?php
namespace zion\utils;

/**
 * Utilidades do sistema
 * @author Vinicius Cesar Dias
 * @since 31/01/2019
 */
class SystemUtils {
    public static function setTimezone($timezone) {
        // timezone formato +00:00
        $signal = mb_substr($timezone, 0, 1);
        $hour = intval(mb_substr($timezone, 1, 2));
        $minute = intval(mb_substr($timezone, 4, 2));
        
        // validando adicional
        if (($signal == "+" || $signal == "-") && ($hour >= -14 && $hour <= 14) && ($minute >= 0 && $minute < 60)) {
            // atenção! O PHP inverte o sinal
            $signal = ($signal == "+") ? "-" : "+";
            $timezonePHP = "Etc/GMT".$signal.$hour;
            date_default_timezone_set($timezonePHP);
        }
    }
    
    public static function configure(){
        // constantes
        define("DS",DIRECTORY_SEPARATOR);
        define("zion\CHARSET","UTF-8");
        
        // configurações
        ini_set("default_charset",zion\CHARSET);
        mb_internal_encoding(zion\CHARSET);
        
        self::setTimezone("-03:00");
        
        // detectando ambiente
        $env = "PRD";
        if(strpos($_SERVER["SERVER_NAME"],".des") !== false OR strpos($_SERVER["SERVER_NAME"],".dev") !== false){
            $env = "DEV";
        }else if(strpos($_SERVER["SERVER_NAME"],".qas") !== false){
            $env = "QAS";
        }
        define("zion\ENV",$env);
    }
    
    /**
     * Chamar esse método caso utilize arquivos de frontend de modulos
     */
    public static function route(){
        if(strpos($_SERVER["REQUEST_URI"],"/zion/mod/") !== 0){
            return;
        }
        
        $uri = explode("/", $_SERVER["REQUEST_URI"]);
        if(sizeof($uri) < 6) {
            return;
        }
        
        $module = preg_replace("[^a-z0-9\_]", "", strtolower($uri[3]));
        
        // padrão de view
        if($uri[4] == "view"){
            $file = \zion\ROOT.str_replace("/zion/mod/","/modules/",$_SERVER["REQUEST_URI"]);
            $filename = basename($file);
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            
            if(file_exists($file)){
                if(in_array($ext,["jpg","jpeg","png","gif","webp","bmp","ico"])){
                    header("Content-Type: image/".$ext);
                }else{
                    $map = [
                        "js"  => "text/javascript",
                        "css" => "text/css"
                    ];
                    if(array_key_exists($ext,$map)){
                        header("Content-Type: ".$map[$ext]);
                    }
                }
                readfile($file);
            }
            exit();
        }
        
        // padrão de controle
        $controller = preg_replace("[^a-zA-Z0-9]", "", $uri[4]);
        $action     = explode("?", $uri[5]);
        $action     = preg_replace("[^a-zA-Z0-9]", "", $action[0]);
        
        $className   = $controller."Controller";
        $classNameNS = "\\zion\\mod\\".$module."\\controller\\".$controller."Controller";
        $classFile   = \zion\ROOT."modules/".$module."/controller/".$className.".class.php";
        
        if(file_exists($classFile)) {
            require($classFile);
            $ctrl = new $classNameNS();
            
            $methodName = "action".ucfirst($action);
            if(method_exists($ctrl, $methodName)) {
                $ctrl->$methodName();
                exit();
            }
        }
    }
}
?>