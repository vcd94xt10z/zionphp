<?php
namespace zion\mod\diff\controller;

use Exception;
use zion\core\AbstractController;
use zion\core\System;
use zion\utils\DiffUtils;
use zion\utils\HTTPUtils;
use zion\core\Page;

/**
 * @author Vinicius
 */
class MainController extends AbstractController {
    public function __construct(){
        parent::__construct(get_class($this));
    }
    
    public function actionHome(){
        Page::setTitle("Diferença entre ambientes");
        $this->view("home");
    }
    
    public function actionObjectList(){
        DiffUtils::sendObjectList();
    }
    
    public function actionDiff(){
        try {
            // input
            $source = $_POST["source"];
            $target = $_POST["target"];
            
            // process
            $source1 = $source."?type=file&ts=".date("YmdHis");
            $target1 = $target."?type=file&ts=".date("YmdHis");
            $result1 = DiffUtils::compare($source1,$target1);
            
            $source2 = $source."?type=db&ts=".date("YmdHis");
            $target2 = $target."?type=db&ts=".date("YmdHis");
            $result2 = DiffUtils::compare($source2,$target2);
            
            $result = array(
                "file" => $result1,
                "db"   => $result2
            );
            
            // output
            Page::setTitle("Resultado da diferença entre ambientes");
            Page::sendCacheControl();
            System::set("result",$result);
            $this->view("result");
        }catch(Exception $e){
            HTTPUtils::status(500);
            echo $e->getMessage();
        }
    }
}
?>