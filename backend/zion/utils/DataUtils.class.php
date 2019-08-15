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
        
        set_time_limit(300); // 5 minutos
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
        $interval = strtotime('-24 hours');
        $files = scandir(self::$data["folder"]);
        foreach ($files AS $filename){
            if(in_array($filename,array(".",".."))){
                continue;
            }
            
            $file = self::$data["folder"].$filename;
            
            if(is_dir($file)){
                continue;
            }
            
            if(!file_exists($file)){
                continue;
            }
            
            if (filemtime($file) <= $interval){
                unlink($file);
            }
        }
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
        
        // tamanho máximo do conteúdo a ser recebido na requisição
        $maxSizeMB    = 64;
        $maxSizeBytes = $maxSizeMB * 1024 * 1024;
        
        // pré validações
        $xContentEncoding = $_SERVER["HTTP_X_CONTENT_ENCODING"];
        $contentType      = $_SERVER["CONTENT_TYPE"];
        $contentTypeList  = array(
            "text/sql" => "sql"
            
        );
        $contentTypeKeys = array_keys($contentTypeList);
        
        if(!in_array($contentType,$contentTypeKeys)){
            throw new Exception("Cabeçalho Content-Type ".$contentType." inválido, valores válidos: ".implode(", ",$contentTypeKeys),400);
        }
        $contentTypeExtension = $contentTypeList[$contentType];
        
        $size = (int) $_SERVER['CONTENT_LENGTH'];
        if($size > $maxSizeBytes){
            throw new Exception("A requisição ultrapassa o tamanho máximo permitido
                    (Max. {$maxSizeMB}MB)",400);
        }
        
        $folder = self::$data["folder"]."queue/";
        if(!file_exists($folder)){
            throw new Exception("O diretório ".$folder." não existe",500);
        }
        
        if(!is_writable($folder)){
            throw new Exception("O diretório ".$folder." não é gravável",500);
        }
        
        // debug?
        if($_SERVER["HTTP_X_DEBUG"] == "1"){
            $f = fopen($folder."debug.log","a+");
            fwrite($f,print_r($_SERVER,true));
            fclose($f);
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
        
        // montando nome do arquivo
        $filenameBase = implode("_",$parts);
        $filenameBase = preg_replace("/[^0-9a-zA-Z\_\.]/","_",$filenameBase);
        $filename     = $filenameBase.".".$contentTypeExtension;
        
        // ponteiro de gravação
        $file = $folder.$filename;
        $writer = fopen($file,"a+");
        if($writer === false){
            throw new Exception("Erro em abrir o arquivo ".$file." para gravação",500);
        }
        
        // ponteiro de leitura
        $reader = fopen("php://input","r");
        if($reader === false){
            throw new Exception("Erro na leitura dos dados da requisição",400);
        }
        
        // transferindo dados do request body para um arquivo usando stream
        $bytesTotal = 0;
        while(true){
            $buffer = fread($reader,1024);
            
            // ocorreu erro na leitura?
            if($buffer === false){
                fclose($writer);
                fclose($reader);
                throw new Exception("Erro em ler dados da requisição",400);
            }
            
            // não há mais dados no buffer
            if($buffer == null){
                break;
            }
            
            // verificando se o limite máximo foi atingido
            $bytesTotal += strlen($buffer);
            if($bytesTotal > $maxSizeBytes){
                fclose($writer);
                fclose($reader);
                throw new Exception("Os dados da requisição ultrapassam o tamanho máximo permitido
                    (Max. {$maxSizeMB}MB)",400);
            }
            
            // gravando no arquivo
            $result = fwrite($writer, $buffer);
            if($result === false){
                throw new Exception("Erro em gravar buffer no arquivo",500);
            }
        }
        
        // fechando ponteiros
        fclose($writer);
        fclose($reader);
        
        // verificando se o conteúdo do arquivo esta vazio
        if($bytesTotal == 0){
            unlink($file);
            throw new Exception("Nenhum conteúdo foi informado!",400);
        }
        
        // Como varios problemas podem ocorrer com encoding dos dados de entrada, por exemplo
        // https://stackoverflow.com/questions/13031968/compressing-http-post-data-sent-from-browser
        // decidi enviar o conteúdo comprimido (não via Content-Encoding) e descompactar na aplicação
        if($xContentEncoding == "zip"){
            $encFile = $file.".".$xContentEncoding;
            
            // renomeando para zip
            rename($file,$encFile);
            
            // descompactando
            FileUtils::unzipFile($encFile, $folder);
            
            // removendo zip
            if($_SERVER["HTTP_X_DEBUG"] != "1"){
                unlink($encFile);
            }
        }
        
        if($xContentEncoding == "gzip"){
            $encFile = $file.".".$xContentEncoding;
            
            // renomeando para zip
            rename($file,$encFile);
            
            // descompactando
            GZip::unzipFile($encFile, $file);
            
            // removendo zip
            if($_SERVER["HTTP_X_DEBUG"] != "1"){
                unlink($encFile);
            }
        }
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
    
    public static function importFile($file,$log=true){
        if($log){
            $logfile = self::$data["folder"]."log.txt";
            $content = "\n\n".date("d/m/Y H:i:s")." ".basename($file)."\n";
            $f = fopen($logfile,"a+");
            fwrite($f,$content);
            fclose($f);
        }
        
        $config = System::get("database");
        $cmd = "mysql -u {$config["user"]} -p{$config["password"]} -h {$config["host"]} {$config["schema"]} < {$file}";
        
        if($log){
            exec($cmd." >> {$logfile}");
        }else{
            exec($cmd." >/dev/null 2>&1");
        }
    }
}
?>