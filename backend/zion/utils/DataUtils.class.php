<?php
namespace zion\utils;

use Exception;
use zion\core\Lock;
use zion\core\System;

/**
 * Classe para gerenciar importação de cargas de forma segura, controlada e sem picos
 * @author Vinicius
 */
class DataUtils {
    public static $data = array(
        "folder" => "/webserver/sites/vinicius/app/tmp/data/"
    );
    
    public static function configure(array $data){
        self::$data = $data;
    }
    
    public static function handle(){
        try {
            // obtendo dados da requisição
            $data = file_get_contents("php://input");
            if($data === false){
                throw new Exception("Não há dados na requisição",400);
            }
            
            // validações
            $folder = self::$data["folder"]."queue/";
            if(!file_exists($folder)){
                throw new Exception("O diretório ".$folder." não existe",500);
            }
            
            if(!is_writable($folder)){
                throw new Exception("O diretório ".$folder." não é gravável",500);
            }
            
            // gravando arquivo
            $file = $folder.date("YmdHis")."_".rand(1000,9999).".sql";
            $f = fopen($file,"a+");
            if($f === false){
                throw new Exception("Erro em abrir o arquivo ".$file." para gravação",500);
            }
            
            if(!fwrite($f,$data)){
                throw new Exception("Erro em gravar no arquivo ".$file,500);
                fclose($f);
            }
            
            fclose($f);
            
            HTTPUtils::status(200);
            echo "Concluído";
        }catch(Exception $e){
            HTTPUtils::status($e->getCode());
            echo $e->getMessage();
        }
    }
    
    public static function job(){
        try {
            // não permitindo jobs paralelos
            $lock = new Lock("job-data");
            if(!$lock->lock()){
                throw new Exception("Já existe outro processo rodando",500);
            }
            
            self::processNextFile();
            
            HTTPUtils::status(200);
            echo "Concluído";
        }catch(Exception $e){
            HTTPUtils::status($e->getCode());
            echo $e->getMessage();
        }
    }
    
    public static function processNextFile(){
        // pegando o primeiro arquivo da fila
        $folder = self::$data["folder"]."queue/";
        $files = scandir($folder);
        $nextFile = null;
        foreach($files AS $filename){
            if(in_array($filename,array(".",".."))){
                continue;
            }
            
            if(strpos($filename,".sql") === false){
                continue;
            }
            
            $file = $folder.$filename;
            if(!is_file($file)){
                continue;
            }
            
            $nextFile = $file;
            break;
        }
        
        if($nextFile == null){
            return;
        }
        
        // importando
        $data = file_get_contents($nextFile);
        
        try {
            $db = System::getConnection();
            $db->exec($data);
            $db = null;
            
            $sourceFile = $nextFile;
            $targetFile = self::$data["folder"]."success/".basename($sourceFile);
        }catch(Exception $e){
            $sourceFile = $nextFile;
            $targetFile = self::$data["folder"]."error/".basename($sourceFile);
        }
        
        rename($sourceFile,$targetFile);
        
        self::processNextFile();
    }
}
?>