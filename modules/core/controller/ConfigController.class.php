<?php
namespace zion\mod\core\controller;

use DateTime;
use zion\core\Page;
use zion\core\System;
use zion\orm\Filter;
use zion\orm\ObjectVO;

/**
 * Classe gerada pelo Zion Framework em 07/05/2019
 */
class ConfigController extends AbstractConfigController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_core_config"
		));
	}
	
	public static function loadConfig(array $keys){
	    $db = System::getConnection();
	    $dao = System::getDAO($db,"zion_core_config");
	    
	    $filter = new Filter($keys);
	    $filter->sort("`sequence`","ASC");
	    $objList = $dao->getArray($db, $filter);
	    $output = array();
	    foreach($objList AS $obj){
	        $output[$obj->get("name")] = $obj->get("value");
	    }
	    return $output;
	}
	
	public function actionUpdateItens(){
	    $objList = array();
	    
	    $_POST["config"] = is_array($_POST["config"])?$_POST["config"]:array();
	    foreach($_POST["config"] AS $v){
	        $obj = new ObjectVO();
	        $obj->set("mandt",$v["mandt"]);
	        $obj->set("env",$v["env"]);
	        $obj->set("key",$v["key"]);
	        $obj->set("name",$v["name"]);
	        $obj->set("value",$v["value"]);
	        
	        if($obj->isAnyNull(array("mandt","env","key","name"))){
	            continue;
	        }
	        
	        $objList[] = $obj;
	    }
	    
	    if(sizeof($objList) <= 0){
	        return;
	    }
	    
	    $db = System::getConnection();
	    $dao = System::getDAO($db,"zion_core_config");
	    
	    $i=0;
	    foreach($objList AS $obj){
	        $keys = array(
	            "mandt" => $obj->get("mandt"),
	            "env"   => $obj->get("env"),
	            "key"   => $obj->get("key"),
	            "name"  => $obj->get("name")
	        );
	        $obj->set("sequence",$i);
	        
	        if($dao->exists($db, $keys)){
	            $obj->set("updated",new DateTime());
	            $dao->update($db,$obj);
	        }else{
	            $obj->set("created",new DateTime());
	            $obj->set("updated",null);
	            $dao->insert($db,$obj);
	        }
	        
	        $i++;
	    }
	}
	
	public function actionDeleteItem(){
	    $keys = array(
	        "mandt" => intval($_GET["mandt"]),
	        "env"   => preg_replace("[^A-Z]","",$_GET["env"]),
	        "key"   => preg_replace("[^A-Z0-9a-z\.\_]","",$_GET["key"]),
	        "name"  => preg_replace("[^A-Z0-9a-z\.\_]","",$_GET["name"])
	    );
	    $db = System::getConnection();
	    $dao = System::getDAO($db,"zion_core_config");
	    $dao->delete($db, $keys);
	}
	
	public function actionMain(){
	    Page::setTitle("Gerenciador de Configuração");
	    $this->view("main");
	}
	
	public function actionQuery(){
	    // input
	    $filter = new Filter();
	    $filter->eq("mandt",intval($_POST["filter"]["mandt"]));
	    $filter->eq("env",preg_replace("[^A-Z]","",$_POST["filter"]["env"]));
	    $filter->starts("key",preg_replace("[^A-Z0-9a-z\.\_]","",$_POST["filter"]["key"]));
	    $filter->sort("`mandt`","ASC");
	    $filter->sort("`env`","ASC");
	    $filter->sort("`key`","ASC");
	    $filter->sort("`sequence`","ASC");
	    
	    // process
	    $db = System::getConnection();
	    $dao = System::getDAO($db,"zion_core_config");
	    $objList = $dao->getArray($db,$filter);
	    
	    $resultList = array();
	    foreach($objList AS $obj){
	        $resultList[] = $obj->toArray();
	    }
	    
	    // output
	    header("Content-Type: application/json");
	    echo json_encode($resultList);
	}
}
?>