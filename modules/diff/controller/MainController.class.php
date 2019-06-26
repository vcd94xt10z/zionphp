<?php
namespace zion\mod\diff\controller;

use Exception;
use zion\core\AbstractController;
use zion\core\System;
use zion\utils\DiffUtils;
use zion\utils\HTTPUtils;

class MainController extends AbstractController {
    public function __construct(){
        parent::__construct(get_class($this));
    }
    
    public function actionHome(){
        $this->view("home");
    }
    
    public function actionObjectList(){
        DiffUtils::sendObjectList();
    }
    
    public function actionDiff(){
        try {
            // input
            $link1 = $_POST["source"];
            $link2 = $_POST["target"];
            
            // process
            $sufix = "?file=1";
            $result1 = DiffUtils::compare($link1.$sufix,$link2.$sufix);
            
            $sufix = "?db=1";
            $result2 = DiffUtils::compare($link1.$sufix,$link2.$sufix);
            
            $result = array(
                "file" => $result1,
                "db"   => $result2
            );
            
            // output
            System::set("result",$result);
            $this->view("result");
        }catch(Exception $e){
            HTTPUtils::status(500);
            echo $e->getMessage();
        }
    }
}
?>