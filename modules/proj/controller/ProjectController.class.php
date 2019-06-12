<?php
namespace zion\mod\proj\controller;

use Exception;
use DateTime;
use zion\mod\proj\standard\controller\ProjectController AS StandardProjectController;
use zion\core\System;
use zion\orm\Filter;
use zion\utils\HTTPUtils;
use zion\core\Page;
use zion\utils\DateTimeUtils;

/**
 * Classe gerada pelo Zion Framework em 05/06/2019
 */
class ProjectController extends StandardProjectController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_proj_project"
		));
	}
	
	public function actionResume(){
	    try {
	        // input
	        $uri    = HTTPUtils::parseURI();
	        $projid = intval($uri["parts"][6]);
	        
	        // process
            $keys = array(
                "mandt"  => 0,
                "projid" => $projid
            );
            $obj = $this->loadProject($keys);
            if($obj == null){
                throw new Exception("Projeto {$projid} não encontrado",404);
            }
            System::set("project",$obj);
            
	        // output
            Page::setTitle("Projeto ".$obj->get("name"));
	        $this->view("resume");
	    }catch(Exception $e){
	        HTTPUtils::status($e->getCode());
	        echo $e->getMessage();
	    }
	}
	
	public function actionMain(){
	    try {
	        // input
	        
	        // process
	        $projectList = array();
	        $db = System::getConnection();
	        $dao = System::getDAO($db,"zion_proj_project");
	        $objList = $dao->getArray($db);
	        foreach($objList AS $obj){
	            $keys = array(
	                "mandt"  => $obj->get("mandt"),
	                "projid" => $obj->get("projid")
	            );
	            $projectList[] = $this->loadProject($keys);
	        }
	        System::set("projectList",$projectList);
	        
	        // output
	        Page::setTitle("Projetos");
	        $this->view("main");
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
	
	public function loadProject(array $keys){
	    // process
	    $db         = System::getConnection();
	    $projectDAO = System::getDAO($db,"zion_proj_project");
	    $featureDAO = System::getDAO($db,"zion_proj_feature");
	    $testDAO    = System::getDAO($db,"zion_proj_test");
	    $timeDAO    = System::getDAO($db,"zion_proj_feature_time");
	    
	    $proj = $projectDAO->getObject($db,$keys);
	    if($proj === null){
	        return null;
	    }
	    
        // funcionalidades
        $filter = new Filter();
        $filter->eq("mandt",$proj->get("mandt"));
        $filter->eq("projid",$proj->get("projid"));
        $filter->sort("sequence","ASC");
        $featureList = $featureDAO->getArray($db,$filter);
        $proj->set("featureCount",sizeof($featureList));
        
        // tempo total estimado
        $total = 0;
        foreach($featureList AS $feature){
            $total += $feature->get("estimated_time");
        }
        $proj->set("estimated_time",$total);
        
        // testes
        $filter = new Filter();
        $filter->eq("mandt",$proj->get("mandt"));
        $filter->eq("projid",$proj->get("projid"));
        $testList = $testDAO->getArray($db,$filter);
        $proj->set("testCount",sizeof($testList));
        
        // tempo
        $filter = new Filter();
        $filter->eq("mandt",$proj->get("mandt"));
        $filter->eq("projid",$proj->get("projid"));
        $timeList = $timeDAO->getArray($db,$filter);
        
        // tempo total
        $total = 0;
        foreach($timeList AS $time){
            $end = $time->get("end");
            $begin = $time->get("begin");
            if($end == null){
                $end = new DateTime();
            }
            $total += round(DateTimeUtils::getSecondsDiff($end,$begin) / 60 / 60,2);
        }
        $proj->set("work_time",$total);
        
        // features
        foreach($featureList AS &$feat){
            // tempo
            $timeCount = 0;
            foreach($timeList AS $time){
                if($time->get("featid") <> $feat->get("featid")){
                    continue;
                }
                
                $end = $time->get("end");
                $begin = $time->get("begin");
                if($end == null){
                    $end = new DateTime();
                }
                $timeCount += round(DateTimeUtils::getSecondsDiff($end,$begin) / 60 / 60,2);
            }
            $feat->set("work_time",$timeCount);
            
            // testes
            $testCount = 0;
            foreach($testList AS $test){
                if($feat->get("featid") <> $test->get("featid")){
                    continue;
                }
                $testCount += 1;
            }
            $feat->set("test_count",$testCount);
        }
        
        // juntando tudo
        $proj->set("featureList",$featureList);
        $proj->set("testList",$testList);
        $proj->set("timeList",$timeList);
        
        return $proj;
	}
}
?>