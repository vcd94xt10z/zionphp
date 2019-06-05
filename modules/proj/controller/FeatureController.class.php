<?php
namespace zion\mod\proj\controller;

use Exception;
use DateTime;
use zion\mod\proj\standard\controller\FeatureController AS StandardFeatureController;
use zion\core\System;
use zion\orm\ObjectVO;
use zion\utils\HTTPUtils;

/**
 * Classe gerada pelo Zion Framework em 05/06/2019
 */
class FeatureController extends StandardFeatureController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "proj_feature"
		));
	}
	
	public function actionPlay(){
	    try {
	        // input
	        $uri    = HTTPUtils::parseURI();
	        $keys   = explode(":",$uri["parts"][6]);
	        $mandt  = intval($keys[0]);
	        $projid = intval($keys[1]);
	        $featid = intval($keys[2]);
	        
	        // process
	        $db  = System::getConnection();
	        $timeDAO = System::getDAO($db,"proj_feature_time");
	        
	        // pausando todos os outros
	        $sql = "UPDATE proj_feature
                       SET status = 'P'
                     WHERE mandt = {$mandt}
                       AND projid = {$projid} 
                       AND status = 'E'";
	        $db->exec($sql);
	        
	        $sql = "UPDATE proj_feature_time
                       SET end = NOW()
                     WHERE mandt = {$mandt}
                       AND projid = {$projid}
                       AND end IS NULL";
	        $db->exec($sql);
	        
	        // iniciando o novo
	        $sql = "UPDATE proj_feature
                       SET status = 'E'
                     WHERE mandt = {$mandt}
                       AND projid = {$projid}
                       AND featid = {$featid}";
	        $db->exec($sql);
	        
	        $time = new ObjectVO();
	        $time->set("mandt",$mandt);
	        $time->set("projid",$projid);
	        $time->set("featid",$featid);
	        $time->set("begin",new DateTime());
	        $time->set("end",null);
	        $timeDAO->insert($db, $time);
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function actionPause(){
	    try {
	        // input
	        $uri    = HTTPUtils::parseURI();
	        $keys   = explode(":",$uri["parts"][6]);
	        $mandt  = intval($keys[0]);
	        $projid = intval($keys[1]);
	        $featid = intval($keys[2]);
	        
	        // process
	        $db  = System::getConnection();
	        
	        // pausando todos os outros
	        $sql = "UPDATE proj_feature
                       SET status = 'P'
                     WHERE mandt = {$mandt}
                       AND projid = {$projid}
                       AND featid = {$featid}";
	        $db->exec($sql);
	        
	        $sql = "UPDATE proj_feature_time
                       SET end = NOW()
                     WHERE mandt = {$mandt}
                       AND projid = {$projid}
                       AND end = NOW()";
	        $db->exec($sql);
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
}
?>