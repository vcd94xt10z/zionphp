<?php
namespace zion\mod\phpdoc\controller;

use Exception;
use zion\phpdoc\ClassTokenParser;
use zion\core\AbstractController;
use zion\core\Page;
use zion\utils\AppDocUtils;
use zion\utils\HTTPUtils;

class PHPDocController extends AbstractController {
    public function __construct(){
        parent::__construct(get_class($this));
    }
    
    public function actionHome(){
        try {
            // input
            $prefix = $_GET["prefix"];
            if($prefix == "/" || $prefix == "."){
                $prefix = "";
            }
            
            // process
            $prefix = trim($prefix,'/');
            $folder = \zion\ROOT.$prefix;
            
            $isRoot = ($prefix=="");
            
            $package = trim($prefix,'.');
            $packageList = array();
            $c = null;
            
            $viewMessage = "";
            if(is_file($folder)){
                $package = dirname(trim($prefix,'.'));
                $fileInfo = AppDocUtils::getFileInfo($folder);
                
                try {
                    // pegando apenas a primeira classe pois cada arquivo tem uma classe
                    $cp = new ClassTokenParser();
                    $cp->parse($folder);
                    $c = $cp->getClassList(0);
                }catch(Exception $e){
                    $viewMessage = $e->getMessage();
                }
                
                $packageList = AppDocUtils::scanPackages(dirname($folder)."/",$isRoot);
            }else{
                $packageList = AppDocUtils::scanPackages($folder."/",$isRoot);
            }
            
            // output
            Page::css("/zion/mod/phpdoc/view/css/main-home.css");
            Page::js("/zion/mod/phpdoc/view/js/main-home.js");
            
            require($this->moduleRoot."view/main-home.php");
        }catch(Exception $e){
            HTTPUtils::status(500);
            HTTPUtils::template(500,$e->getMessage());
        }
    }
}
?>