<?php
namespace zion\mod\sql\controller;

use Exception;
use zion\core\AbstractController;
use zion\core\Page;
use zion\core\System;
use zion\utils\HTTPUtils;

/**
 * @author Vinicius Cesar Dias
 */
class SQLController extends AbstractController {
	public function __construct(){
	    parent::__construct(get_class($this));
	}
	
	public function actionRun(){
	    // input
	    $query = trim($_GET["query"]);
	    $query = str_replace('\r\n'," ",$query);
	    $query = str_replace('\n'," ",$query);
	    $query = str_replace('<br>'," ",$query);
	    
	    try {
    	    // process
    	    $db = System::getConnection();
    	    $dao = System::getDAO();
    	    $result = $dao->queryAndFetch($db, $query);
    	    $db = null;
    	    
    	    // output
    	    $data = array();
    	    foreach($result AS $obj){
    	        $data[] = $obj->toArray();
    	    }
    	    
    	    HTTPUtils::status(200);
    	    header("Content-Type: application/json");
    	    echo json_encode($data);
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function actionEditor(){
	    Page::setTitle("SQLEditor");
	    $this->view("editor");
	}
}
?>