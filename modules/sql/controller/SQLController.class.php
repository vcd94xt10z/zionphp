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
	
	public function actionStatement(){
	    $type = preg_replace("/[^a-zA-Z0-9\_]/","",$_GET["type"]);
	    $cmd  = preg_replace("/[^a-zA-Z0-9\_]/","",$_GET["cmd"]);
	    $name = preg_replace("/[^a-zA-Z0-9\_]/","",$_GET["name"]);
	    
	    try {
	        $output = "";
	        
	        $db  = System::getConnection();
	        $dao = System::getDAO();
	        
	        if($type == "table"){
	            // obtendo dao com metadados
	            $dao = System::getDAO($db,$name);
	            
	            switch($cmd){
	            case "SELECT":
	                $output = "SELECT * \nFROM `".$name."` \nLIMIT 10"; 
	                break;
	            case "INSERT":
                    $output  = $dao->getInsertTemplate();
	                break;
	            case "UPDATE":
	                $output  = $dao->getUpdateTemplate();
	                break;
	            case "DELETE":
	                $output = "DELETE FROM `".$name."`";
	                break;
	            case "CREATE":
	                $sql = "SHOW CREATE TABLE `".$name."`";
	                $output = $dao->queryAndFetchObject($db, $sql);
	                $output = $output->get("Create Table");
	                break;
	            case "DROP":
	                $output = "DROP TABLE `".$name."`";
	                break;
	            case "TRUNCATE":
	                $output = "TRUNCATE TABLE `".$name."`";
	                break;
	            }
	        }
	        
	        if($type == "function"){
	            switch($cmd){
	            case "CALL":
	               $output = "SELECT ".$name."()";
	               break;
	            case "CREATE":
	                $sql = "SHOW CREATE FUNCTION `".$name."`";
	                $output = $dao->queryAndFetchObject($db, $sql);
	                $output = $output->get("Create Function");
	                break;
	            case "DROP":
	                $output = "DROP FUNCTION `".$name."`";
	                break;
    	        }
	        }
	        
	        if($type == "procedure"){
	            switch($cmd){
                case "CALL":
                    $output = "CALL ".$name."()";
                    break;
                case "CREATE":
                    $sql = "SHOW CREATE PROCEDURE `".$name."`";
                    $output = $dao->queryAndFetchObject($db, $sql);
                    $output = $output->get("Create Procedure");
                    break;
                case "DROP":
                    $output = "DROP PROCEDURE `".$name."`";
                    break;
	            }
	        }
	        
	        if($type == "trigger"){
	            switch($cmd){
                case "CREATE":
                    $sql = "SHOW CREATE TRIGGER `".$name."`";
                    $output = $dao->queryAndFetchObject($db, $sql);
                    $output = $output->get("SQL Original Statement");
                    break;
                case "DROP":
                    $output = "DROP TRIGGER `".$name."`";
                    break;
	            }
	        }
	        
	        if($type == "event"){
	            switch($cmd){
                case "CREATE":
                    $sql = "SHOW CREATE EVENT `".$name."`";
                    $output = $dao->queryAndFetchObject($db, $sql);
                    $output = $output->get("Create Event");
                    break;
                case "DROP":
                    $output = "DROP EVENT `".$name."`";
                    break;
	            }
	        }
	        
	        HTTPUtils::status(200);
	        header("Content-Type: application/sql");
	        echo $output;
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
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
	        
	        // tabelas e views
	        $sql = "SELECT `table_type` AS `type`, `table_name` AS `name` 
                      FROM `information_schema`.`tables`
                     WHERE `table_schema` = database()
                       AND `table_type`  IN ('BASE TABLE','VIEW')";
	        if($name != ""){
	            $sql .= " AND `table_name` LIKE '%".$name."%'";
	        }
	        $tableList = $dao->queryAndFetch($db, $sql);
	        
	        // procedimentos
	        $sql = "SELECT `routine_type` AS `type`, `routine_name` AS `name`
                      FROM `information_schema`.`routines`
					 WHERE `routine_schema` = database()";
            if($name != ""){
                $sql .= " AND `routine_name` LIKE '%".$name."%'";
            }
	        $procList = $dao->queryAndFetch($db, $sql);
	        
	        // triggers
	        $sql = "SELECT trigger_name AS name
                      FROM information_schema.triggers
                     WHERE `trigger_schema` = database()";
	        if($name != ""){
	            $sql .= " AND `trigger_name` LIKE '%".$name."%'";
	        }
	        $triggerList = $dao->queryAndFetch($db, $sql);
	        
	        // event
	        $sql = "SELECT event_name AS name
                      FROM information_schema.events
                     WHERE `event_schema` = database()";
	        if($name != ""){
	            $sql .= " AND `event_name` LIKE '%".$name."%'";
	        }
	        $eventList = $dao->queryAndFetch($db, $sql);
	        
	        $db = null;
	        
	        // output
	        $data = array(
	            "table"     => array(),
	            "view"      => array(),
	            "function"  => array(),
	            "procedure" => array(),
	            "trigger"   => array(),
	            "event"     => array(),
	        );
	        foreach($tableList AS $obj){
	            if($obj->get("type") == "BASE TABLE"){
	                $data["table"][] = $obj->toArray();
	            }else{
	                $data["view"][] = $obj->toArray();
	            }
	        }
	        
	        foreach($procList AS $obj){
	            switch($obj->get("type")){
	            case "FUNCTION":
	                $data["function"][] = $obj->toArray();
	                break;
	            case "PROCEDURE":
	                $data["procedure"][] = $obj->toArray();
	                break;
	            }
	        }
	        
	        foreach($triggerList AS $obj){
	            $data["trigger"][] = $obj->toArray();
	        }
	        
	        foreach($eventList AS $obj){
	            $data["event"][] = $obj->toArray();
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