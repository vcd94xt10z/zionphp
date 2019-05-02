<?php
namespace zion\mod\error\controller;

use zion\core\Page;
use zion\core\System;
use zion\orm\Filter;
use zion\utils\HTTPUtils;
use zion\orm\ObjectVO;

/**
 * Classe gerada pelo Zion Framework em 18/02/2019
 */
class ErrorLogController extends AbstractErrorLogController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_error_log"
		));
	}
	
	public function actionResolved(){
	    $uri     = explode("/",$_SERVER["REQUEST_URI"]);
	    $errorid = intval($uri[6]);
	    
	    try {
	        $db = System::getConnection();
	        $sql = "UPDATE `zion_error_log`
                       SET `status` = 'R'
                     WHERE `errorid` = ".$errorid;
	        $db->exec($sql);
	        
	        header("Location: /zion/mod/error/ErrorLog/showNextError");
	    }catch(\Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function actionShowNextError(){
	    // input
	    $uri    = explode("/",$_SERVER["REQUEST_URI"]);
	    $offset = intval($uri[6]);
	    
	    // process
	    if($offset < 0){
	        $offset = 0;
	    }
	    
	    $db = System::getConnection();
	    $dao = System::getDAO();
	    
	    $filter = new Filter();
	    $filter->eq("status","P");
	    $filter->addSort("created", "DESC");
	    $filter->setLimit(1);
	    $filter->setOffset($offset);
	    
	    $sql = "SELECT * FROM `zion_error_log`";
	    $obj = $dao->queryAndFetchObject($db, $sql, $filter);
	    
	    $recorrencia = 0;
	    if($obj != null){
	        // verificando se o erro é recorrente
	        $sql = "SELECT COUNT(*) AS total
                      FROM zion_error_log
                     WHERE file = '".$obj->get("file")."'
                       AND line = '".$obj->get("line")."'
                       AND DATE(created) = date(now())
                       AND errorid <> ".$obj->get("errorid");
	        $obj2 = $dao->queryAndFetchObject($db, $sql);
	        $recorrencia = $obj2->get("total");
	    }
	    
	    System::set("recorrencia",$recorrencia);
	    System::set("error",$obj);
	    System::set("offset",$offset);
	    
	    // output
	    Page::css("/zion/lib/codemirror-5.44.0/lib/codemirror.css");
	    Page::css("/zion/lib/codemirror-5.44.0/addon/hint/show-hint.css");
	    
	    Page::js("/zion/lib/codemirror-5.44.0/lib/codemirror.js");
	    Page::js("/zion/lib/codemirror-5.44.0/addon/hint/anyword-hint.js");
	    Page::js("/zion/lib/codemirror-5.44.0/addon/hint/show-hint.js");
	    Page::js("/zion/lib/codemirror-5.44.0/mode/clike/clike.js");
	    Page::js("/zion/lib/codemirror-5.44.0/mode/php/php.js");
	    
	    Page::setTitle("Monitor");
	    Page::showHeader(false);
	    Page::showFooter(false);
	    $this->view("nexterror");
	}
	
	public function actionMonitor(){
	    // input
	    
	    // process
	    $db = System::getConnection();
	    $dao = System::getDAO();
	    
	    $types = array("php","php-error","php-exception","mysql","apache");
	    $resultList = array();
	    
	    foreach($types AS $type){
    	    $obj = new ObjectVO();
    	    $obj->set("type",$type);
    	    $obj->set("created",null);
    	    $obj->set("total",0);
    	    $resultList[$type] = $obj;
	    }
	    
	    $sql = "SELECT `type`, count(*) AS `total`, MAX(`created`) AS `created`
                  FROM `zion_error_log`
                 WHERE `status` = 'P'
              GROUP BY `type`";
	    
	    $resultList2 = $dao->queryAndFetch($db, $sql);
	    foreach($resultList2 AS $result2){
	        $type = $result2->get("type");
	        if(array_key_exists($type,$resultList)){
	            $resultList[$type]->set("total",$result2->get("total"));
	            $resultList[$type]->set("created",$result2->get("created"));
	        }
	    }
	    
	    System::set("dataList",$resultList);
	    
	    // output
	    Page::setTitle("Monitor");
	    Page::showHeader(false);
	    Page::showFooter(false);
	    Page::js("/zion/lib/zion/utils/TextFormatter.class.js");
	    $this->view("monitor");
	}
}
?>