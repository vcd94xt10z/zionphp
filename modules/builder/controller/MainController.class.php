<?php
namespace zion\mod\builder\controller;

use Exception;
use zion\core\AbstractController;
use zion\core\App;
use zion\core\System;
use zion\mod\builder\model\Builder;
use zion\utils\HTTPUtils;

/**
 * @author Vinicius Cesar Dias
 */
class MainController extends AbstractController {
    public function __construct(){
        parent::__construct(get_class($this));
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
            throw new Exception("O modulo ".$moduleid." é reservado!");
        }
        
        if($destiny == "app"){
            $file = \zion\APP_ROOT."tpl".\DS;
            if(!file_exists($file)){
                throw new Exception("O diretório de template ".$file." não existe");
            }
        }
        
        $this->createModule($moduleid,$destiny);
        
        $builder = new Builder($moduleid, $entityid, $table, $destiny);
        $builder->buildAbstractController();
        $builder->buildController();
        $builder->buildListView();
        $builder->buildResultFilterView();
        $builder->buildFormView();
    }
    
    public function createModule($moduleid,$destiny){
        $blackList = array("builder","welcome");
        
        if(in_array($moduleid,$blackList)){
            throw new Exception("O modulo ".$moduleid." é reservado!");
        }
        
        $folder = \zion\ROOT."modules".\DS.$moduleid.\DS;
        if($destiny <> "zion"){
            $folder = App::getModuleRoot().$moduleid.\DS;
        }
        
        $folders = array(
            $folder,
            $folder."controller",
            $folder."view"
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
        $this->view("home");
    }
}
?>