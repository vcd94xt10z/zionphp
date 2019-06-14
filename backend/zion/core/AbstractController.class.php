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
	protected $moduleURI  = ""; // verificar se realmente esta sendo usado e se é necessário
	protected $restURI    = ""; // verificar se realmente esta sendo usado e se é necessário
	
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
            $this->moduleURI = "/zion/mod/";
            $this->restURI = "/zion/rest/";
        }elseif($ns[0] == "mod"){
            $this->moduleid = $ns[1];
            $this->entityid = str_replace("Controller","",$ns[3]);
            $this->moduleRoot = rtrim($_SERVER["DOCUMENT_ROOT"]).\DS."modules".\DS.$this->moduleid.\DS;
            $this->moduleURI = "/mod/";
            $this->restURI = "/rest/";
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
        $entityid = strtolower($this->entityid);
        $isZion = (strpos($this->namespace,"zion\\") === 0);
        
        $uriPrefix = "/zion/mod/";
        $moduleRoot = \zion\ROOT."modules/";
        $projectRoot = \zion\ROOT;
        if(!$isZion){
            $uriPrefix  = "/mod/";
            $moduleRoot = App::getModuleRoot();
            $projectRoot = \zion\APP_ROOT;
        }
        
        // css e js da página
        $uri  = $uriPrefix.$this->moduleid."/view/css/".$entityid."-".$name.".css";
        $file = $moduleRoot.$this->moduleid."/view/css/".$entityid."-".$name.".css";
        if(file_exists($file)){
            Page::css($uri);
        }
        
        $uri  = $uriPrefix.$this->moduleid."/view/js/".$entityid."-".$name.".js";
        $file = $moduleRoot.$this->moduleid."/view/js/".$entityid."-".$name.".js";
        if(file_exists($file)){
            Page::js($uri);
        }
        
        // titulo automatico
        if(Page::getTitle() == "" OR Page::getTitle() == "Sem titulo"){
            if(strpos($name,"form") !== false){
                Page::setTitle("Formulário");
            }elseif(strpos($name,"list") !== false){
                Page::setTitle("Consulta");
            }
        }
        
        if($useTemplate){
            Page::css("/zion/lib/zion/default-erp.css");
            Page::js("/zion/lib/zion/default-erp.js");
            
            // pagina
            Page::setInclude($this->moduleRoot."view".\DS.$entityid."-".$name.".php");
            
            // template
            require($projectRoot.\DS."tpl".\DS."default.php");
        }else{
            // pagina
            require($this->moduleRoot."view".\DS.$entityid."-".$name.".php");
        }
    }
    
    /**
     * Retorna uma parte da URI
     * @param int $index [1..99] Indice começando do 1
     * @return mixed
     */
    public function getURIPart($index){
        if($index < 0){
            $index = 0;
        }
        
        $uri = explode("?",$_SERVER["REQUEST_URI"]);
        $uri = explode("/",$uri[0]);
        return $uri[$index];
    }
}
?>