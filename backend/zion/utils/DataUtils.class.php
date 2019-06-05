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
        
        $filename = implode("_",$parts).".sql";
        $filename = preg_replace("/[^0-9a-zA-Z\_\.]/","_",$filename);
        
        $file = $folder.$filename;
        $f = fopen($file,"a+");
        if($f === false){
            throw new Exception("Erro em abrir o arquivo ".$file." para gravação",500);
        }
        
        if(fwrite($f,$data) === false){
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
        try {
            self::importFile($nextFile);
        }catch(Exception $e){
        }
        
        // removendo o arquivo da fila
        $sourceFile = $nextFile;
        $targetFile = self::$data["folder"]."processed/".basename($sourceFile);
        rename($sourceFile,$targetFile);
        
        self::processNextFile();
    }
    
    private static function importFile($file){
        $logfile = self::$data["folder"]."log.txt";
        $content = "\n\n".date("d/m/Y H:i:s")." ".basename($file)."\n";
        $f = fopen($logfile,"a+");
        fwrite($f,$content);
        fclose($f);
        
        $config = System::get("database");
        $cmd = "mysql -u {$config["user"]} -p{$config["password"]} -h {$config["host"]} {$config["schema"]} < {$file}";
        exec($cmd." >> {$logfile}");
    }
}
?>