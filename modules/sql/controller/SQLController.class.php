<?php
namespace zion\mod\sql\controller;

use DateTime;
use Exception;
use zion\core\AbstractController;
use zion\core\Page;
use zion\core\System;
use zion\utils\HTTPUtils;
use zion\utils\TextFormatter;

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
	    
	    try {
    	    // process
    	    $db = System::getConnection();
    	    $dao = System::getDAO();
    	    $result = $dao->queryAndFetch($db, $query);
    	    $db = null;
    	    
    	    // output
    	    $data = array();
    	    foreach($result AS $obj){
    	        $all = $obj->getAll();
    	        $row = array();
    	        foreach($all AS $name => $value){
    	            if($value instanceof DateTime){
                        $row[$name] = TextFormatter::format("datetime",$value);
    	            }else{
    	                $row[$name] = $value;
    	            }
    	        }
    	        $data[] = $row;
    	    }
    	    
    	    HTTPUtils::status(200);
    	    header("Content-Type: application/json");
    	    echo json_encode($data);
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function actionObjectList(){
	    // input
	    $name = preg_replace("[^a-zA-Z0-9\_]","",$_GET["name"]);
	    
	    try {
	        // process
	        $db = System::getConnection();
	        $dao = System::getDAO();
	        
	        $sql = "SELECT `table_name` 
                      FROM `information_schema`.`tables`
                     WHERE `table_schema` = database()";
	        if($name != ""){
	            $sql .= " AND `table_name` LIKE '%".$name."%'";
	        }
	        
	        $result = $dao->queryAndFetch($db, $sql);
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
	    Page::css("/zion/lib/codemirror-5.44.0/lib/codemirror.css");
	    Page::js("/zion/lib/codemirror-5.44.0/lib/codemirror.js");
	    Page::js("/zion/lib/codemirror-5.44.0/mode/sql/sql.js");
	    $this->view("editor");
	}
}
?>