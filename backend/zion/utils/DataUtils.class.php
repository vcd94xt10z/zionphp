<?php
namespace zion\utils;

use Exception;
use zion\core\Lock;
use zion\core\System;

/**
 * Classe para gerenciar importação de cargas de forma segura, controlada e 
 * sem picos de CPU, Memória RAM, disco e rede
 * 
 * @author Vinicius
 * @since 04/06/2019
 */
class DataUtils {
    private static $initialized = false;
    
    public static $data = array(
        "folder" => "/webserver/tmp/data/"
    );
    
    public static function init(){
        if(self::$initialized){
            return;
        }
        self::$initialized = true;
        self::$data["folder"] = \zion\APP_ROOT."tmp/data/";
    }
    
    /**
     * Configura a classe
     * @param array $data
     */
    public static function configure(array $data){
        self::init();
        self::$data = $data;
    }
    
    /**
     * Coloca a carga de dados na fila e importa
     */
    public static function run(){
        try {
            self::handle();
            self::job();
            self::clean();
            
            HTTPUtils::status(200);
            echo "Processado (run)".PHP_EOL;
        }catch(Exception $e){
            HTTPUtils::status($e->getCode());
            echo $e->getMessage();
        }
    }
    
    /**
     * Limpa arquivos antigos
     */
    public static function clean(){
    }
    
    public static function actionHandle(){
        try {
            self::handle();
            HTTPUtils::status(200);
            echo "Processado (handle)".PHP_EOL;
        }catch(Exception $e){
            HTTPUtils::status($e->getCode());
            echo $e->getMessage();
        }
    }
    
    /**
     * Coloca a carga de dados na fila
     * @throws Exception
     */
    public static function handle(){
        self::init();
        
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
        $tablename = $_SERVER["HTTP_X_TABLENAME"];
        $parts = array(
            date("YmdHis"),
            microtime(),
            rand(1000,9999)
        );
        if($tablename != ""){
            $parts[] = $tablename;
        }
        
        $file = $folder.implode("_",$parts).".sql";
        $f = fopen($file,"a+");
        if($f === false){
            throw new Exception("Erro em abrir o arquivo ".$file." para gravação",500);
        }
        
        if(!fwrite($f,$data)){
            fclose($f);
            throw new Exception("Erro em gravar no arquivo ".$file,500);
        }
        
        fclose($f);
    }
    
    public static function actionJob(){
        try {
            self::job();
            HTTPUtils::status(200);
            echo "Processado (job).PHP_EOL";
        }catch(Exception $e){
            HTTPUtils::status($e->getCode());
            echo $e->getMessage();
        }
    }
    
    /**
     * Verifica a fila e importa as cargas até esvaziar o diretório
     * @throws Exception
     */
    public static function job(){
        self::init();
        
        // não permitindo jobs paralelos
        $lock = new Lock("job-data");
        if(!$lock->lock()){
            throw new Exception("Já existe outro processo rodando",500);
        }
        
        self::processNextFile();
    }
    
    /**
     * Processa o próximo arquivo de carga da fila
     */
    private static function processNextFile(){
        // procurando o primeiro arquivo da fila
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
        
        // importando os dados
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
        
        // movendo o arquivo executado para o diretório adequado
        rename($sourceFile,$targetFile);
        
        self::processNextFile();
    }
}
?>