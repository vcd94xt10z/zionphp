<?php
namespace zion\mod\core\controller;

use zion\core\Page;
use zion\core\System;
use zion\orm\Filter;

/**
 * Classe gerada pelo Zion Framework em 07/05/2019
 */
class ConfigController extends AbstractConfigController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_core_config"
		));
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