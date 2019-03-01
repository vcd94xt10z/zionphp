<?php
namespace zion\mod\ide\controller;

use Exception;
use zion\core\AbstractController;
use zion\core\Page;
use zion\utils\HTTPUtils;

/**
 * @author Vinicius Cesar Dias
 */
class EditorController extends AbstractController {
	public function __construct(){
	    parent::__construct(get_class($this));
	}
	
	public function actionSave(){
	    // input
	    $file = $_GET["file"];
	    $code = file_get_contents("php://input");
	    
	    try {
	        if(strpos($file,\zion\ROOT) !== 0){
	            throw new Exception("Arquivo inválido");
	        }
	        
    	    $f = fopen($file,"w");
    	    if(!$f){
    	        throw new Exception("Erro em abrir arquivo");
    	    }
    	    fwrite($f,$code);
    	    fclose($f);
    	    
    	    HTTPUtils::status(200);
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function actionLoad(){
	    // input
	    $file = $_GET["file"];
	    
	    try {
	        if(strpos($file,\zion\ROOT) !== 0){
	            throw new Exception("Arquivo inválido");
	        }
	        
	        if(!file_exists($file)){
	            throw new Exception("O arquivo não existe");
	        }
	        
	        HTTPUtils::status(200);
	        echo file_get_contents($file);
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function actionMain(){
	    Page::setTitle("PHPEditor");
	    Page::css("/zion/lib/codemirror-5.44.0/lib/codemirror.css");
	    Page::js("/zion/lib/codemirror-5.44.0/lib/codemirror.js");
	    Page::js("/zion/lib/codemirror-5.44.0/mode/clike/clike.js");
	    Page::js("/zion/lib/codemirror-5.44.0/mode/php/php.js");
	    $this->view("main");
	}
}
?>