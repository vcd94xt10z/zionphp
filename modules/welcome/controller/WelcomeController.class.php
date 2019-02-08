<?php 
namespace zion\mod\welcome\controller;

use Exception;
use zion\core\System;

class WelcomeController {
    public function actionStep(){
        // input
        $step = intval($_GET["step"]);
        
        // process
        try {
            switch($step){
            case 1:
                $this->checkConfigFile();
                break;
            case 2:
                $this->importDatabase();
                break;
            case 3:
                $this->testConfig();
                break;
            }
        }catch(Exception $e){
            header("HTTP/1.0 500 Error");
            echo $e->getMessage();
        }
    }
    
    public function checkConfigFile(){
        $file = dirname($_SERVER["DOCUMENT_ROOT"])."/config.json";
        if(!file_exists($file)){
            throw new Exception("O arquivo de configuração não existe");
        }
        
        // verificar se o banco esta conectando com a configuração do arquivo
        try {
            $db = System::getConnection();
            $db->exec("SET NAMES UTF8");
            $db->query("SHOW VARIABLES");
        }catch(Exception $e){
            throw new Exception("Erro na comunicação com o banco de dados");
        }
    }
    
    public function importDatabase(){
        try {
            $db = System::getConnection();
            $db->exec("SET NAMES UTF8");
            
            $query = $db->query("SHOW VARIABLES");
            $dbvars = [];
            while($raw = $query->fetchObject()){
                $dbvars[] = $raw;
            }
        }catch(Exception $e){
            throw new Exception("Erro na comunicação com o banco de dados");
        }
    }
    
    public function testConfig(){
        throw new Exception("Não implementado!");
    }
    
    public function actionConfig(){
        System::add("view-css","/zion/mod/welcome/view/css/welcome-config.css");
        System::add("view-js","/zion/mod/welcome/view/js/welcome-config.js");
        require(\zion\ROOT."modules/welcome/view/welcome-config.php");
    }
    
    public function actionHome(){
        // input
        
        // process
        
        // output
        System::add("view-css","/zion/mod/welcome/view/css/welcome-home.css");
        System::add("view-js","/zion/mod/welcome/view/js/welcome-home.js");
        require(\zion\ROOT."modules/welcome/view/welcome-home.php");
    }
}
?>