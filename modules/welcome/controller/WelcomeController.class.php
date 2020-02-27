<?php 
namespace zion\mod\welcome\controller;

use Exception;
use zion\core\System;
use zion\core\Page;
use zion\utils\HTTPUtils;
use zion\utils\DataUtils;

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
            
            HTTPUtils::status(200);
            Page::sendCacheControl();
        }catch(Exception $e){
            HTTPUtils::status(500);
            Page::sendCacheControl();
            echo $e->getMessage();
        }
    }
    
    public function checkConfigFile(){
        $all = zion_get_config_all();
        if(sizeof($all) <= 0) {
            throw new Exception("O arquivo de configuração não existe");
        }
        
        // verificar se o banco esta conectando com a configuração do arquivo
        try {
            $db = System::getConnection();
            $db->exec("SET NAMES UTF8");
            $db->query("SHOW VARIABLES");
        }catch(Exception $e){
            throw new Exception("Erro na comunicação com o banco de dados: ".$e->getMessage());
        }
    }
    
    public function importDatabase(){
        $folder = \zion\ROOT."artifacts".\DS."dump".\DS;
        
        try {
            $db = System::getConnection();
            $db->exec("SET NAMES UTF8");
            
            $files = scandir($folder);
            foreach($files AS $filename){
                if(strpos($filename,".sql") === false){
                    continue;
                }
                
                $file = $folder.$filename;
                if(!file_exists($file)){
                    continue;
                }
                
                // importar pelo client sql
                if(strpos($filename,"functions.sql") !== false){
                    DataUtils::importFile($file,false);
                    
                    $sql = "SELECT count(*) AS total
                              FROM information_schema.routines
                             WHERE routine_name = 'zion_nextval'
                               AND routine_schema = database()";
                    $query = $db->query($sql);
                    if($raw = $query->fetchObject()){
                        if($raw->total == 0){
                            throw new Exception("Erro em importar funções via client mysql, execute manualmente");
                        }
                    }
                }else{
                    $sql = file_get_contents($file);
                    if($sql != ""){
                        // ignorando se a tabela já existir
                        $cmd1 = "CREATE TABLE IF NOT EXISTS ";
                        $cmd2 = "CREATE TABLE ";
                        
                        $sql = str_replace($cmd1,$cmd2,$sql);
                        $sql = str_replace($cmd2,$cmd1,$sql);
                        
                        $db->exec($sql);
                    }
                }
            }
        }catch(Exception $e){
            throw new Exception("Erro na comunicação com o banco de dados: ".$e->getMessage());
        }
    }
    
    public function testConfig(){
        // verificando permissão de diretórios
        $folders = [
            \zion\ROOT."log".\DS,
            \zion\ROOT."tmp".\DS,
            \zion\ROOT."tmp".\DS."lock".\DS,
            \zion\ROOT."tmp".\DS."session".\DS,
        ];
        foreach($folders AS $folder){
            if(!file_exists($folder)){
                throw new Exception("O diretório ".$folder." não existe");
            }
            
            if(!is_writable($folder)){
                throw new Exception("O diretório ".$folder." não tem permissão de gravação");
            }
        }
        
        // verificando configuração do php
        if(in_array(strtolower(ini_get('short_open_tags')),["0","off"])){
            throw new Exception("Habilite a configuração short_open_tags no php.ini");
        }
        
        // verificando configuração do banco
        $db = System::getConnection();
        $query = $db->query("SHOW VARIABLES");
        $dbconfig = [];
        while($raw = $query->fetchObject()){
            $dbconfig[$raw->Variable_name] = $raw->Value;
        }
        
        // charset
        $list = [
            "character_set_client","character_set_connection","character_set_database","character_set_results",
            "character_set_system",
            //"character_set_server"
        ];
        foreach($list AS $item){
            if(!array_key_exists($item, $dbconfig)){
                throw new Exception("Variável de banco ".$item." não encontrada!");
            }
            if($dbconfig[$item] != "utf8"){
                throw new Exception("Variável de banco ".$item." deve ser utf8 e não ".$dbconfig[$item]."!");
            }
        }
        
        if(in_array(strtolower($dbconfig["general_log"]),["on","1"])){
            throw new Exception("A configuração general_log esta ativa, isso pode causar problemas de performance");
        }
        
        // verificando configuração do apache
    }
    
    public function actionConfig(){
        Page::css("/zion/mod/welcome/view/css/welcome-config.css");
        Page::js("/zion/mod/welcome/view/js/welcome-config.js");
        Page::sendCacheControl();
        require(\zion\ROOT."modules/welcome/view/welcome-config.php");
    }
    
    public function actionHome(){
        // input
        
        // process
        
        // output
        Page::sendCacheControl();
        Page::js("/zion/mod/welcome/view/js/welcome-home.js");
        require(\zion\ROOT."modules/welcome/view/welcome-home.php");
    }
}
?>