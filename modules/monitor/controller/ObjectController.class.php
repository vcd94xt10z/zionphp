<?php
namespace zion\mod\monitor\controller;

use Exception;
use DateTime;
use zion\core\Page;
use zion\core\System;
use zion\utils\HTTPUtils;
use zion\orm\ObjectVO;
use zion\orm\Filter;

/**
 * Classe gerada pelo Zion Framework em 24/04/2019
 */
class ObjectController extends AbstractObjectController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "monitor_object"
		));
	}
	
	public function isURLOnline($url){
	    try {
	        $method = "GET";
	        $data = null;
	        $options = array(
	            CURLOPT_TIMEOUT        => 10,
	            CURLOPT_CONNECTTIMEOUT => 10,
	            CURLOPT_USERAGENT      => "ZionPHP Client"
	        );
	        $curlInfo = array();
	        
	        HTTPUtils::curl($url, $method, $data, $options, $curlInfo);
	        
	        $httpCode = intval($curlInfo["http_code"]);
	        if($httpCode >= 200 AND $httpCode <= 299){
	            return true;
	        }
	    }catch(Exception $e){
	    }
	    return false;
	}
	
	public function actionGetNextQueueSound(){
	    try {
	        $db = System::getConnection();
	        $dao = System::getDAO($db,"monitor_notify_queue");
	        
	        // notificação
	        $filter = new Filter();
	        $filter->eq("type","sound");
	        $filter->eq("status","A");
	        $filter->addSort("created","DESC");
	        $filter->setLimit(1);
	        
	        $sql = "SELECT * FROM monitor_notify_queue";
	        $notify = $dao->queryAndFetchObject($db, $sql,$filter,"array");
	        if($notify == null){
	            HTTPUtils::status(404);
	            return;
	        }
	        
	        // objeto de monitoramento
	        $filter = new Filter();
	        $filter->eq("objectid",$notify["objectid"]);
	        $sql = "SELECT * FROM monitor_object";
	        $obj = $dao->queryAndFetchObject($db,$sql,$filter,"array");
	        
	        // atualizando status direto para concluído
	        $up = new ObjectVO();
	        $up->set("objectid",$notify["objectid"]);
	        $up->set("notifyid",$notify["notifyid"]);
	        $up->set("status","C");
	        $up->set("sended",new DateTime());
	        $dao->update($db,$up);
	        
	        // output
	        header("Content-Type: application/json");
	        echo json_encode(array(
	            "object" => $obj,
	            "notify" => $notify
	        ));
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function actionCrontab(){
	    try {
	        $db       = System::getConnection();
	        $dao      = System::getDAO($db,"monitor_object");
	        $queueDAO = System::getDAO($db,"monitor_notify_queue");
	        
	        $sql = "SELECT * 
                      FROM `monitor_object` 
                     WHERE `enabled` = 1
                       AND ( `last_check` IS NULL 
                           OR (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(`last_check`)) > `interval` 
                       )";
	        $list = $dao->queryAndFetch($db, $sql);
	        
	        foreach($list AS $obj){
	            if($obj->get("type") == "http"){
	                $isOnline = $this->isURLOnline($obj->get("url"));
	                if($isOnline){
	                    $obj->set("status","on");
	                }else{
	                    $obj->set("status","off");
	                }
	                
	                $obj->set("last_check",new DateTime());
	                $dao->update($db,$obj);
	            }
	            
	            if($obj->get("status") == "off"){
	                // ignorando notificações sonoras do mesmo tipo para não ficar
	                // falando a mesma coisa várias vezes
	                $sql = "UPDATE `monitor_notify_queue`
                               SET `status` = 'I'
                             WHERE `objectid` = '".$obj->get("objectid")."'
                               AND `status` = 'A'";
	                $db->exec($sql);
	                
	                $queue = new ObjectVO();
    	            $queue->set("objectid",$obj->get("objectid"));
    	            $queue->set("notifyid",null);
    	            $queue->set("created",new DateTime());
    	            $queue->set("type",null);
    	            $queue->set("status","A");
    	            $queue->set("sended",null);
    	            
    	            if($obj->get("notify_by_email") == 1){
    	                $queue->set("notifyid",date("YmdHis")."-".rand(1000,9999));
    	                $queue->set("type","email");
    	                $queueDAO->insert($db, $queue);
    	            }
    	            
    	            if($obj->get("notify_by_sms") == 1){
    	                $queue->set("notifyid",date("YmdHis")."-".rand(1000,9999));
    	                $queue->set("type","sms");
    	                $queueDAO->insert($db, $queue);
    	            }
    	            
    	            if($obj->get("notify_by_sound") == 1){
    	                $queue->set("notifyid",date("YmdHis")."-".rand(1000,9999));
    	                $queue->set("type","sound");
    	                $queueDAO->insert($db, $queue);
    	            }
	            }
	        }
	        
	        // output
	        HTTPUtils::status(200);
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function actionGetData(){
	    // input
	    
	    // process
	    try {
            $db = System::getConnection();
    	    $dao = System::getDAO();
    	    
    	    $sql = "SELECT * FROM monitor_object WHERE enabled = 1";
    	    $result = $dao->queryAndFetch($db, $sql, null, "array");
    	    
    	    // output
    	    header("Content-Type: application/json");
	        echo json_encode($result);
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function actionChangeSound(){
	    // input
	    $uri = explode("?",$_SERVER["REQUEST_URI"]);
	    $uri = explode("/",$uri[0]);
	    
	    $objectid = preg_replace("/[^0-9a-zA-Z\-\_]/","",$uri[6]);
	    $flag     = intval($uri[7]);
	    
	    // process
	    try {
	        $db = System::getConnection();
	        $dao = System::getDAO($db,"monitor_object");
	        
	        $obj = new ObjectVO();
	        $obj->set("objectid",$objectid);
	        $obj->set("sound_enabled",$flag);
	        $dao->update($db,$obj);
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function actionMonitor(){
	    Page::setTitle("Monitor");
	    Page::showHeader(false);
	    Page::showFooter(false);
	    Page::js("/zion/lib/zion/utils/TextFormatter.class.js");
	    $this->view("monitor");
	}
}
?>