<?php
namespace zion\mod\error\controller;

use Exception;
use zion\core\Page;
use zion\core\System;
use zion\orm\Filter;
use zion\utils\HTTPUtils;
use zion\orm\ObjectVO;

use zion\mod\error\standard\controller\ErrorLogController AS StandardErrorController;

/**
 * Classe gerada pelo Zion Framework em 18/02/2019
 */
class ErrorLogController extends StandardErrorController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_error_log"
		));
	}
	
	public function actionSolveAllSimilar(){
	    $uri     = explode("/",$_SERVER["REQUEST_URI"]);
	    $errorid = intval($uri[6]);
	    
	    try {
	        $db = System::getConnection();
	        $dao = System::getDAO($db,"zion_error_log");
	        
	        // carregando erro
	        $obj = $dao->getObject($db, array("errorid" => $errorid));
	        if($obj == null){
	            throw new Exception("O erro não existe");
	        }
	        
	        // marcando como resolvido todos os erros
	        $sql = "UPDATE `zion_error_log`
                       SET `status` = 'R'
                     WHERE `file` = '".$obj->get("file")."'
                       AND `line` = ".$obj->get("line")."
	                   AND `status` = 'P'";
	        $db->exec($sql);
	        
	        header("Location: /zion/mod/error/ErrorLog/showNextError");
	    }catch(\Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function actionSolve(){
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
	    
	    $db  = System::getConnection();
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
	    
	    // erros restantes
	    $sql = "SELECT COUNT(*) AS total
                  FROM zion_error_log
                 WHERE status = 'P'";
	    $obj2 = $dao->queryAndFetchObject($db, $sql);
	    System::set("remainErrors",$obj2->get("total"));
	    
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
	    $db  = System::getConnection();
	    $dao = System::getDAO();
	    
	    // carregando tipos
	    $sql = "SELECT `type`, count(*) AS `total`
	              FROM `zion_error_log`
	          GROUP BY `type`";
	    $objList = $dao->queryAndFetch($db, $sql);
	    
	    $resultList = array();
	    foreach($objList AS $obj){
	        $type = $obj->get("type");
	        
	        $obj2 = new ObjectVO();
	        $obj2->set("type",$type);
	        $obj2->set("created",null);
	        $obj2->set("total",0);
	        $resultList[$type] = $obj2;
	    }
	    
	    // carregando erros de cada tipo
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