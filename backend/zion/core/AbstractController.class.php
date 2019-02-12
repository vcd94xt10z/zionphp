<?php
namespace zion\core;

use Exception;

/**
 * @author Vinicius Cesar Dias
 */
abstract class AbstractController {
    protected $namespace  = "";
	protected $moduleid   = "";
	protected $entityid   = "";
	protected $moduleRoot = "";
	
	/**
	 * Identifica os metadados do controle
	 * @param string $className
	 * @throws Exception
	 */
    public function __construct($className){
        $this->namespace = $className;
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
    
    /**
     * Carrega a view
     * 
     * Caso o controle tiver o prefixo de namespace do framework, procura os 
     * arquivos na pasta do framework, senão procura no diretório do aplicativo
     * 
     * Se a view for independente, não é necessário o template. Caso deseje que
     * seja incluído um cabeçalho e rodapé automaticamente, habilite o uso do template
     * 
     * Atenção! Caso precise passar alguma variável para view, use os métodos set e get
     * da System
     * 
     * @param string $name
     * @param boolean $useTemplate
     */
    public function view($name,$useTemplate=true){
        $pg = System::get("pageConfig");
        $entityid = strtolower($this->entityid);
        $isZion = (strpos($this->namespace,"zion\\") === 0);
        
        $uriPrefix = "/zion/mod/";
        $filePrefix = \zion\ROOT."modules/";
        if(!$isZion){
            $uriPrefix  = "/mod/";
            $filePrefix = \zion\APP_ROOT."modules/";
        }
        
        // css e js da página
        $uri  = $uriPrefix.$this->moduleid."/view/css/".$entityid."-".$name.".css";
        $file = $filePrefix.$this->moduleid."/view/css/".$entityid."-".$name.".css";
        if(file_exists($file)){
            System::add("view-css", $uri);
        }
        
        $uri  = $uriPrefix.$this->moduleid."/view/js/".$entityid."-".$name.".js";
        $file = $filePrefix.$this->moduleid."/view/js/".$entityid."-".$name.".js";
        if(file_exists($file)){
            System::add("view-js", $uri);
        }
        
        if($useTemplate){
            if($isZion){
                System::add("view-css","/zion/lib/zion/default-erp.css");
                System::add("view-js","/zion/lib/zion/default-erp.js");
            }
            
            // pagina
            $pg["include"] = $this->moduleRoot."view".\DS.$entityid."-".$name.".php";
            System::set("pageConfig",$pg);
            
            // template
            require(dirname($filePrefix).\DS."tpl".\DS."default.php");
        }else{
            // pagina
            require($this->moduleRoot."view".\DS.$entityid."-".$name.".php");
        }
    }
}
?>