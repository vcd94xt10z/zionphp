<?php 
namespace zion\mod\waf\controller;

use zion\core\System;
use zion\utils\FileUtils;

class WAFController {
    public function actionCheckServerConfig(){
        // php.ini mal configurado etc
        System::set("phpiniRisk",$this->getPHPIniRisk());
                
        // apache mal configurado etc
        System::set("apacheRisk",$this->getApacheRisk());
        
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
        require(\zion\ROOT."modules/waf/view/waf-serverconfig.php");
    }
    
    public function getApacheRisk(){
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
    
    public function getPHPIniRisk(){
        $phpini = ini_get_all();
        
        $highRiskIfActive = ["allow_url_fopen","allow_url_include","expose_php"];
        $lowRiskIfActive = ["short_open_tags"];
        $phpiniRisk = [];
        
        foreach($highRiskIfActive AS $param){
            if(array_key_exists($param,$phpini)){
                $phpiniRisk[$param] = "none";
                
                $globalValue = strtolower($phpini[$param]["global_value"]);
                $localValue = strtolower($phpini[$param]["local_value"]);
                if(in_array($globalValue,array("1","on")) OR in_array($localValue,array("1","on"))){
                    $phpiniRisk[$param] = "high";
                }
            }
        }
        
        foreach($lowRiskIfActive AS $param){
            if(array_key_exists($param,$phpini)){
                $phpiniRisk[$param] = "none";
                
                $globalValue = strtolower($phpini[$param]["global_value"]);
                $localValue = strtolower($phpini[$param]["local_value"]);
                if(in_array($globalValue,array("1","on")) OR in_array($localValue,array("1","on"))){
                    $phpiniRisk[$param] = "low";
                }
            }
        }
        
        return $phpiniRisk;
    }
}
?>