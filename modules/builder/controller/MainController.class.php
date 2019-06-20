<?php
namespace zion\mod\builder\controller;

use Exception;
use DateTime;
use zion\orm\Filter;
use zion\core\AbstractController;
use zion\core\App;
use zion\core\Page;
use zion\mod\builder\model\Builder;
use zion\utils\HTTPUtils;
use zion\core\System;
use zion\orm\ObjectVO;

/**
 * @author Vinicius Cesar Dias
 */
class MainController extends AbstractController {
    public function __construct(){
        parent::__construct(get_class($this));
    }
    
    public function actionRebuild(){
        $db = System::getConnection();
        $dao = System::getDAO($db,"zion_builder_history");
        $resultList = array();
        
        $filter = new Filter();
        $filter->sort("update_count","DESC");
        $objList = $dao->getArray($db,$filter);
        foreach($objList AS $obj){
            $moduleid = $obj->get("module");
            $entityid = $obj->get("entity");
            $table    = $obj->get("table");
            $destiny  = $obj->get("destiny");
            try {
                $this->createCRUD($moduleid,$entityid,$table,$destiny);
                $obj->set("result","OK");
            }catch(Exception $e){
                $obj->set("result","ERR");
                $obj->set("message",$e->getMessage());
            }
            $resultList[] = $obj;
        }
        System::set("resultList",$resultList);
        
        // output
        Page::setTitle("Resultado do Rebuild");
        $this->view("rebuild-result");
    }
    
    public function actionCreateCRUD(){
        // input
        $uri      = explode("/",$_SERVER["REQUEST_URI"]);
        $moduleid = preg_replace("/[^a-z0-9\_]/","",strtolower($uri[6]));
        $entityid = preg_replace("/[^a-zA-Z0-9\_]/","",$uri[7]);
        $table    = preg_replace("/[^a-zA-Z0-9\_]/","",$uri[8]);
        $destiny  = preg_replace("/[^a-zA-Z0-9\_]/","",$uri[9]);
        
        // process
        try {
            $this->createCRUD($moduleid,$entityid,$table,$destiny);
            echo "CRUD criado";
        }catch(Exception $e){
            HTTPUtils::status(500);
            HTTPUtils::template(500,$e->getMessage());
        }
    }
    
    public function createCRUD(string $moduleid,string $entityid,string $table, $destiny){
        if($moduleid == ""){
            throw new Exception("Modulo vazio");
        }
        if($entityid == ""){
            throw new Exception("Entidade vazia");
        }
        if($table == ""){
            throw new Exception("Tabela vazia");
        }
        if($destiny == ""){
            throw new Exception("Destino vazio");
        }
        
        $blackList = array("builder","welcome");
        
        if(in_array($moduleid,$blackList)){
            //throw new Exception("O modulo ".$moduleid." é reservado!");
        }
        
        if($destiny == "app"){
            $file = \zion\APP_ROOT."tpl".\DS;
            if(!file_exists($file)){
                throw new Exception("O diretório de template ".$file." não existe");
            }
        }
        
        $this->createModule($moduleid,$destiny);
        
        $builder = new Builder($moduleid, $entityid, $table, $destiny);
        $builder->buildStandardController();
        $builder->buildController();
        $builder->buildListView();
        $builder->buildResultFilterView();
        $builder->buildFormView();
        
        // histórico
        $obj = new ObjectVO();
        $obj->set("mandt",0);
        $obj->set("module",$moduleid);
        $obj->set("entity",$entityid);
        $obj->set("table",$table);
        $obj->set("destiny",$destiny);
        
        $db = System::getConnection();
        $dao = System::getDAO($db,"zion_builder_history");
        $objDB = $dao->getObject($db, $obj);
        if($objDB == null){
            $obj->set("update_count",1);
            $obj->set("created_at",new DateTime());
            $dao->insert($db,$obj);
        }else{
            $obj->set("update_count",$objDB->get("update_count") + 1);
            $obj->set("updated_at",new DateTime());
            $dao->update($db,$obj);
        }
    }
    
    public function createModule($moduleid,$destiny){
        $blackList = array("builder","welcome");
        
        if(in_array($moduleid,$blackList)){
            //throw new Exception("O modulo ".$moduleid." é reservado!");
        }
        
        $folder = \zion\ROOT."modules".\DS.$moduleid.\DS;
        if($destiny <> "zion"){
            $folder = App::getModuleRoot().$moduleid.\DS;
        }
        
        $folders = array(
            $folder,
            $folder."standard",
            $folder."standard".\DS."controller",
            $folder."standard".\DS."view",
            $folder."controller",
            $folder."view",
            $folder."view".\DS."css",
            $folder."view".\DS."js",
            $folder."view".\DS."img"
        );
        
        foreach($folders AS $path){
            if(!file_exists($path)){
                @mkdir($path,0777);
                if(!file_exists($path)){
                    throw new Exception("O diretório ".$path." não foi criado");
                }
            }
        }
    }
    
    public function actionHome(){
        Page::setTitle("Gerador de CRUD");
        $this->view("home");
    }
}
?>