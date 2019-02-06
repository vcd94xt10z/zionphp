<?php
namespace zion\core;

use Exception;

/**
 * @author Vinicius Cesar Dias
 */
abstract class AbstractController {
	protected $moduleid   = "";
	protected $entityid   = "";
	protected $moduleRoot = "";
	
    public function __construct($className){
        if(!is_string($className)){
            throw new Exception("AbstractController->__construct(): Nome da classe inválido");
        }
        
        // identificando pelo namespace
        $ns = explode("\\",$className);
        if($ns[0] == "zion"){
            $this->moduleid = $ns[2];
            $this->entityid = str_replace("Controller","",$ns[4]);
            $this->moduleRoot = \zion\ROOT."modules".\DS.$this->moduleid.\DS;
        }elseif($ns[0] == "mod"){
            $this->moduleid = $ns[1];
            $this->entityid = str_replace("Controller","",$ns[3]);
            $this->moduleRoot = $_SERVER["DOCUMENT_ROOT"]."modules".\DS.$this->moduleid.\DS;
        }else{
            throw new Exception("AbstractController->__construct(): Namespace inválido");
        }
    }
    
    public function loadDefaultView(string $name){
    }
    
    public function loadModuleView(string $name){
    }
    
    /**
     * 
     * @param string $name
     * @param string $template
     */
    public function loadZionDefaultView(string $name){
        $pg = System::get("pageConfig");
        
        $entityid = strtolower($this->entityid);
        
        // css e js da página
        $cssFile = "/zion/mod/".$this->moduleid."/view/css/".$entityid."-".$name.".css";
        if(file_exists(\zion\ROOT.$cssFile)){
            System::add("view-css", $cssFile);
        }
        
        $jsFile  = "/zion/mod/".$this->moduleid."/view/js/".$entityid."-".$name.".js";
        if(file_exists(\zion\ROOT.$jsFile)){
            System::add("view-js", $jsFile);
        }
        
        System::add("view-css","/zion/lib/zion/default-erp.css");
        System::add("view-js","/zion/lib/zion/default-erp.js");
        
        // pagina
        $pg["include"] = $this->moduleRoot."view".\DS.$entityid."-".$name.".php";
        System::set("pageConfig",$pg);
        
       // template
        require(\zion\ROOT."tpl".\DS."default.php");
    }
    
    public function loadZionView($name){
        $entityid = strtolower($this->entityid);
        
        // css e js da página
        System::add("view-css", "/zion/mod/".$this->moduleid."/view/css/".$entityid."-".$name.".css");
        System::add("view-js", "/zion/mod/".$this->moduleid."/view/js/".$entityid."-".$name.".js");
        
        // pagina
        require($this->moduleRoot."view".\DS.$entityid."-".$name.".php");
    }
}
?>