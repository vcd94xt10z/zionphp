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
	
	public function isURLOnline($url,array &$info=array()){
	    $info["response"]       = "";
	    $info["http_status"]    = "";
	    $info["execution_time"] = 0;
	    $info["category"]       = "";
	    
	    $starttime = round(microtime(true) * 1000);
	    $endtime   = 0;
	    
	    try {
	        $method = "GET";
	        $data = null;
	        $options = array(
	            CURLOPT_TIMEOUT        => 10,
	            CURLOPT_CONNECTTIMEOUT => 10,
	            CURLOPT_USERAGENT      => "ZionPHP Client"
	        );
	        
	        $curlInfo = array();
	        $responseBody = HTTPUtils::curl($url, $method, $data, $options, $curlInfo);
	        $endtime = round(microtime(true) * 1000);
	        $info["execution_time"] = $endtime - $starttime;
	        
	        if($curlInfo === false){
	            $info["category"] = "error";
	            $info["response"] = "Connection error";
	            return false;
	        }
	        
	        // cortando respostas grandes
	        if(strlen($responseBody) > 1024){
	            $responseBody = substr($responseBody,0,1024);
	        }
	        $info["response"] = $responseBody;
	        
	        $info["http_status"] = intval($curlInfo["http_code"]);
	        if($info["http_status"] >= 200 AND $info["http_status"] <= 299){
	            return true;
	        }else{
	            $info["category"] = "error";
	        }
	    }catch(Exception $e){
	        $endtime = round(microtime(true) * 1000);
	        $info["response"]       = $e->getMessage();
	        $info["http_status"]    = "";
	        $info["execution_time"] = $endtime - $starttime;
	        
	        if($e->getCode() == 28){
	            $info["category"] = "timeout";
	        }else{
                $info["category"] = "error";
	        }
	    }
	    
	    return false;
	}
	
	public function actionGetNotifications(){
	    try {
	        $db = System::getConnection();
	        $dao = System::getDAO($db,"monitor_notify");
	        
	        // notificação
	        $filter = new Filter();
	        $filter->eq("n.type","tts");
	        $filter->eq("n.status","A");
	        $filter->addSort("n.created","DESC");
	        
	        $sql = "SELECT o.objectid, o.type, o.url, o.interval, o.status, o.last_check, 
                           o.notify_by_email, o.notify_by_sms, o.notify_by_tts, o.notify_email, 
                           o.notify_phone, o.sound_enabled, o.enabled,
                           n.notifyid, n.category, n.tts_text
                      FROM monitor_notify AS n
                INNER JOIN monitor_object AS o ON n.objectid = o.objectid";
	        $notifications = $dao->queryAndFetch($db,$sql,$filter,"array");
	        
	        // atualizando status direto para concluído
	        foreach($notifications AS $notify){
    	        $up = new ObjectVO();
    	        $up->set("objectid",$notify["objectid"]);
    	        $up->set("notifyid",$notify["notifyid"]);
    	        $up->set("status","C");
    	        $up->set("sended",new DateTime());
    	        $dao->update($db,$up);
	        }
	        
	        // objetos
	        $sql = "SELECT * FROM monitor_object WHERE `enabled` = 1";
	        $objectList = $dao->queryAndFetch($db, $sql, null, "array");
	        
	        // output
	        header("Content-Type: application/json");
	        echo json_encode(array(
	            "objectList" => $objectList,
	            "ttsList"    => $notifications
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
	        $queueDAO = System::getDAO($db,"monitor_notify");
	        
	        $sql = "SELECT * 
                      FROM `monitor_object` 
                     WHERE `enabled` = 1
                       AND ( `last_check` IS NULL 
                           OR (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(`last_check`)) > `interval` 
                       )";
	        $list = $dao->queryAndFetch($db, $sql);
	        
	        foreach($list AS $obj){
	            $info = array();
	            
	            if($obj->get("type") == "http"){
	                $isOnline = $this->isURLOnline($obj->get("url"),$info);
	                if($isOnline){
	                    $obj->set("status","on");
	                }else{
	                    $obj->set("status","off");
	                }
	                
	                $obj->set("last_check",new DateTime());
	                $dao->update($db,$obj);
	            }
	            
	            // contadores
	            $field = "counter_error";
	            if($obj->get("status") == "on"){
	                $field = "counter_success";
	            }elseif($info["category"] == "timeout"){
	                $field = "counter_timeout";
	            }
	            $sql = "UPDATE `monitor_object` 
                           SET `".$field."` = `".$field."` + 1
                         WHERE `objectid` = '".$obj->get("objectid")."'";
	            $db->exec($sql);
	            
	            if($obj->get("status") == "off"){
	                // ignorando notificações sonoras do mesmo tipo para não ficar
	                // falando a mesma coisa várias vezes
	                $sql = "UPDATE `monitor_notify`
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
    	            $queue->set("http_status",$info["http_status"]);
    	            $queue->set("response",$info["response"]);
    	            $queue->set("execution_time",$info["execution_time"]);
    	            $queue->set("sended",null);
    	            $queue->set("category",$info["category"]);
    	            
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
    	            
    	            if($obj->get("notify_by_tts") == 1){
    	                $queue->set("notifyid",date("YmdHis")."-".rand(1000,9999));
    	                $queue->set("type","tts");
    	                
    	                if(intval($info["http_status"]) > 0){
    	                    $queue->set("tts_text","Status ".intval($info["http_status"])." no ".$obj->get("name"));
    	                }elseif($info["category"] == "timeout"){
    	                    $queue->set("tts_text","Timeout no ".$obj->get("name"));
    	                }else{
    	                    $queue->set("tts_text","Erro no ".$obj->get("name"));
    	                }
    	                
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
	    Page::js("/zion/lib/artyom.js-master/build/artyom.window.min.js");
	    $this->view("monitor");
	}
}
?>