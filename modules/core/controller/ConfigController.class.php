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
	
	public function actionUpdateItens(){
	    $objList = array();
	    foreach($_POST["config"] AS $v){
	        $obj = new ObjectVO();
	        $obj->set("mandt",$_POST["mandt"]);
	        $obj->set("env",$_POST["env"]);
	        $obj->set("key",$_POST["key"]);
	        $obj->set("name",$v["name"]);
	        $obj->set("value",$v["value"]);
	        $objList[] = $obj;
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