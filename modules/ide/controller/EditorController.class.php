<?php
namespace zion\mod\ide\controller;

use Exception;
use zion\core\AbstractController;
use zion\core\Page;
use zion\utils\HTTPUtils;
use zion\utils\TextFormatter;

/**
 * @author Vinicius Cesar Dias
 */
class EditorController extends AbstractController {
	public function __construct(){
	    parent::__construct(get_class($this));
	}
	
	public function actionLoadTree(){
	    $folder = rtrim($_GET["folder"]).\DS;
	    if($_GET["folder"] == ""){
	        $folder = dirname(\zion\ROOT).\DS;
	    }
	    
	    $allFiles = array();
	    
	    $files = scandir($folder);
	    foreach($files AS $filename){
	        if(in_array($filename,array(".","..",".git"))){
	            continue;
	        }
	        
	        $file = $folder.$filename;
	        $allFiles[] = array(
	            "name" => $filename,
	            "file" => $file,
	            "isFile" => !is_dir($file)
	        );
	    }
	    
	    usort($allFiles, function($a, $b) {
	        return strcmp($b['isFile'],$a['isFile']);
	    });
	    
	    header("Content-Type: application/json");
	    echo json_encode($allFiles);
	}
	
	public function actionSave(){
	    // input
	    $file = $_GET["file"];
	    $code = file_get_contents("php://input");
	    
	    $baseFolder = dirname(\zion\ROOT).\DS;
	    try {
	        if(strpos($file,$baseFolder) !== 0){
	            throw new Exception("Arquivo inválido");
	        }
	        
	        if(file_exists($file)){
	            if(!is_writable($file)){
	                throw new Exception("O arquivo não tem permissão de escrita");
	            }
	        }else{
	            if(!is_writable(dirname($file))){
	               throw new Exception("O diretório pai não tem permissão de escrita");
	            }
	        }
	        
    	    $f = fopen($file,"w");
    	    if(!$f){
    	        throw new Exception("Erro em abrir arquivo");
    	    }
    	    fwrite($f,$code);
    	    fclose($f);
    	    
    	    HTTPUtils::status(200);
    	    echo "Arquivo salvo em ".TextFormatter::format("datetime",new \DateTime());
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function actionLoad(){
	    // input
	    $file = $_GET["file"];
	    
	    $baseFolder = dirname(\zion\ROOT).\DS;
	    try {
	        if(strpos($file,$baseFolder) !== 0){
	            throw new Exception("Arquivo inválido");
	        }
	        
	        if(!file_exists($file)){
	            throw new Exception("O arquivo não existe");
	        }
	        
	        $filesize     = filesize($file);
	        $maxSizeMB    = 1;
	        $maxSizeBytes = 1024 * 1024 * $maxSizeMB;
	        
	        if($filesize > $maxSizeBytes){
	            throw new Exception("O arquivo tem mais de ".$maxSizeMB."MB");
	        }
	        
	        HTTPUtils::status(200);
	        echo file_get_contents($file);
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function actionMain(){
	    Page::setTitle("Zion IDE");
	    Page::css("/zion/lib/codemirror-5.44.0/lib/codemirror.css");
	    Page::css("/zion/lib/codemirror-5.44.0/addon/hint/show-hint.css");
	    
	    Page::js("/zion/lib/codemirror-5.44.0/lib/codemirror.js");
	    Page::js("/zion/lib/codemirror-5.44.0/addon/hint/anyword-hint.js");
	    Page::js("/zion/lib/codemirror-5.44.0/addon/hint/show-hint.js");
	    Page::js("/zion/lib/codemirror-5.44.0/mode/clike/clike.js");
	    Page::js("/zion/lib/codemirror-5.44.0/mode/php/php.js");
	    $this->view("main");
	}
}
?>