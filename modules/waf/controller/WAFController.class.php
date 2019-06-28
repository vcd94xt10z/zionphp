<?php 
namespace zion\mod\waf\controller;

use zion\core\System;
use zion\core\Page;
use zion\utils\FileUtils;

/**
 * @author Vinicius
 */
class WAFController {
    public function actionCheckServerConfig(){
        // php.ini mal configurado etc
        System::set("phpiniAnalysis",$this->getPHPIniAnalysis());
                
        // apache mal configurado etc
        System::set("apacheAnalysis",$this->getApacheAnalysis());
        
        // apache como root
        $processUser = posix_getpwuid(posix_geteuid());
        System::set("apacheRoot",false);
        if($processUser["name"] == "root"){
            System::set("apacheRoot",true);
        }
        
        // verifica arquivos e diretórios com permisão 777
        $writableFiles = [];
        $files = [];
        FileUtils::buildFileListRecursively($_SERVER["DOCUMENT_ROOT"],$files);
        foreach($files AS $file){
            if(is_writable($file)){
                $writableFiles[] = $file;
            }
        }
        System::set("writableFolders",$writableFiles);
        
        // view
        Page::setTitle("Configuração do Servidor");
        require(\zion\ROOT."modules/waf/view/waf-serverconfig.php");
    }
    
    public function getApacheAnalysis(){
        $list = [];
        
        if(!function_exists("apache_get_modules")){
           return $list;
        }
        
        $modules = apache_get_modules();
        
        $list["mod_security"] = "none";
        if(!in_array("mod_security",$modules)){
            $list["mod_security"] = "medium";
        }
        
        return $list;
    }
    
    public function getPHPIniAnalysis(){
        $phpini = ini_get_all();
        
        $params = [
            "allow_url_fopen","allow_url_include","expose_php","memory_limit","default_charset",
            "display_errors","display_startup_errors","enable_dl","max_execution_time",
            "max_file_uploads","max_input_time","max_input_vars","memory_limit",
            "post_max_size","upload_max_filesize","short_open_tag"
        ];
        $phpiniAnalysis = [];
        
        $highIfEnable = array("allow_url_fopen","allow_url_include");
        
        foreach($params AS $param){
            if(!array_key_exists($param,$phpini)){
                continue;
            }
            
            $propose = "";
            $status = "success";
            $globalValue = strtolower($phpini[$param]["global_value"]);
            $localValue = strtolower($phpini[$param]["local_value"]);
            $isEnabled = false;
            
            if(in_array($globalValue,array("1","on")) OR in_array($localValue,array("1","on"))){
                $isEnabled = true;
            }
            
            if(in_array($param,$highIfEnable) AND $isEnabled){
                $status = "error";
            }
            
            switch($param){
            case "memory_limit":
                $localValue = intval(preg_replace("[^0-9]","",$localValue));
                if($localValue > 128){
                    $propose = "128M";
                    $status = "error";
                }
                break;
            case "default_charset":
                if($localValue != "utf-8"){
                    $status = "error";
                    $propose = "UTF-8";
                }
                break;
            }
            
            $phpiniAnalysis[$param] = array(
                "param" => $param,
                "localValue" => $phpini[$param]["local_value"],
                "globalValue" => $phpini[$param]["global_value"],
                "status" => $status,
                "propose" => $propose
            );
        }
        
        return $phpiniAnalysis;
    }
}
?>