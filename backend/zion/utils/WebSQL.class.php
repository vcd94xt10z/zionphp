<?php
namespace zion\utils;

use Exception;
use PDO;
use zion\core\System;

/**
 * @author Vinicius Cesar Dias
 * @since 15/08/2019
 * 
 * O objetivo dessa classe é permitir que comandos SQL sejam executados via requisição http.
 * Isso será útil caso queira executar comandos sql em sistemas que não tem um driver de conexão.
 * 
 * A parte de gerenciar quem poderá utilizar esse serviço deve ser feito pelo sistema que utilizará a classe.
 * 
 * Para armazenar os comandos em um buffer e posteriormente executar tudo de uma vez, informe o cabeçalho "x-buffer"
 * com o nome do buffer, e quando quiser executar efetivamente, envie o comando "COMMIT BUFFER". Para limpar o buffer,
 * "CLEAN BUFFER". Ao executar um buffer, o client mysql é usado ao invés da PDO
 */
class WebSQL {
    /**
     * Configurações
     * @var integer
     */
    private static $config = array(
        "inputMaxLength" => 5242880, // 5 megabytes
        "timeout"        => 300 // 5 minutos
    );
    
    /**
     * Altera uma configuração
     * @param string $key
     * @param string $value
     */
    public static function configure(string $key,string $value){
        self::$config[$key] = $value;
    }
    
    /**
     * Configure uma rota para chamar este método
     * 
     * Atenção! Antes de chamar este método, verifique se o cliente tem
     * permissão para usar este serviço, você pode verificar o IP do cliente
     * ou usar algum sistema de token etc
     */
    public static function handle(){
        try {
            self::run();
        }catch(Exception $e){
            $status = $e->getCode();
            if($status < 400 || $status >= 599){
                $status = 500;
            }
            HTTPUtils::status($status);
            echo $e->getMessage();
        }
    }
    
    /**
     * Executa o comando informado e retorna a resposta para o cliente
     * @throws Exception
     */
    private static function run(){
        set_time_limit(self::$config["timeout"]);
        
        // input
        $input = trim(file_get_contents("php://input"));
        
        // validações
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            throw new Exception("Método HTTP inválido",405);
        }
        
        if(strlen($input) > self::$config["inputMaxLength"]){
            throw new Exception("O comando é muito grande, máximo permitido ".self::$config["inputMaxLength"]."!",400);
        }
        
        if($input == ""){
            throw new Exception("O comando esta vazio",400);
        }
        
        // convertendo para UTF-8
        //$input = utf8_encode($input);
        
        // debug
        if($_SERVER["HTTP_X_DEBUG"] == "1"){
            $file = \zion\APP_ROOT."tmp/websql.log";
            $f = fopen($file,"a+");
            fwrite($f,rtrim($input,"\n")."\n");
            fclose($f);
        }
        
        $client = strtolower($_SERVER["HTTP_X_CLIENT"]);
        
        // buffer de comandos
        if($_SERVER["HTTP_X_BUFFER"] != ""){
            // comandos especiais
            switch($input){
            case "COMMIT BUFFER":
                self::commitBuffer($_SERVER["HTTP_X_BUFFER"]);
                break;
            case "CLEAN BUFFER":
                self::cleanBuffer($_SERVER["HTTP_X_BUFFER"]);
                break;
            default:
                self::sendToBuffer($_SERVER["HTTP_X_BUFFER"],$input);
                break;
            }
            
            // resposta
            HTTPUtils::status(200);
            return;
        }
        
        // executando
        if(strpos(strtoupper($input),"SELECT") === 0){
            $dataList = array();
            
            $db = System::getConnection();
            $query = $db->query($input);
            while($raw = $query->fetch(PDO::FETCH_ASSOC)){
                $dataList[] = $raw;
            }
            $db = null;
            
            // resposta
            HTTPUtils::status(200);
            header("Content-Type: application/json");
            echo json_encode($dataList);
        }else{
            $affectedRows = 0;
            if($client == "pdo"){
                $db = System::getConnection();
                $affectedRows = $db->exec($input);
                $db = null;
            }else{
                self::nativeClient($input);
            }
            
            // resposta
            HTTPUtils::status(200);
            echo $affectedRows;
        }
    }
    
    /**
     * Retorna o caminho absoluto do arquivo de buffer
     * @param string $id
     * @return string
     */
    public static function getBufferFile($id){
        $id = preg_replace("/[^0-9a-zA-Z\_-]/","_",$id);
        $folder = \zion\APP_ROOT."tmp/";
        $filename = "websql-buffer-".$id.".sql";
        return $folder.$filename;
    }
    
    /**
     * Envia os comandos para um buffer para ser executado posteriormente
     * @param string $buffer
     * @param string $input
     */
    public static function sendToBuffer($id,string $input){
        // ajustando final do comando para garantir que termine com ";"
        $input = rtrim($input,"\r\n");
        $input = rtrim($input,"\n");
        $input = rtrim($input,";");
        $input = $input.";";
        
        $file = self::getBufferFile($id);
        $f = fopen($file,"a+");
        if($f === false){
            throw new Exception("Erro em abrir arquivo ".$file);
        }
        fwrite($f,$input."\n");
        fclose($f);
    }
    
    /**
     * Envia todos os comandos do buffer para o banco de dados
     * @param string $id
     */
    public static function commitBuffer(string $id){
        $file = self::getBufferFile($id);
        $config = System::get("database");
        
        // importando o buffer usando o client do mysql do servidor
        $cmd = "mysql -u {$config["user"]} -p{$config["password"]} -h {$config["host"]} --default-character-set=utf8 {$config["schema"]} < {$file}";
        exec($cmd." >/dev/null 2>&1");
        
        // após importar, remove o arquivo de buffer
        unlink($file);
    }
    
    /**
     * Executa um comando usando o cliente nativo do mysql
     * @param string $sql
     * @throws Exception
     */
    public static function nativeClient(string $sql){
        // arquivo temporário
        $file = \zion\APP_ROOT."tmp/websql-".date("YmdHis")."-".rand(1000,9999)."-".md5($sql).".sql";
        
        // gravando conteúdo no arquivo
        $f = fopen($file,"a+");
        if($f === false){
            throw new Exception("Erro em abrir arquivo ".$file);
        }
        fwrite($f,$sql);
        fclose($f);
        
        // executando usando o client do mysql
        $config = System::get("database");
        $cmd = "mysql -u {$config["user"]} -p{$config["password"]} -h {$config["host"]} --default-character-set=utf8 {$config["schema"]} < {$file}";
        exec($cmd." >/dev/null 2>&1");
        
        // removendo arquivo
        unlink($file);
    }
    
    /**
     * Limpa o buffer
     * @param string $id
     */
    public static function cleanBuffer(string $id){
        $file = self::getBufferFile($id);
        if(file_exists($file)){
            unlink($file);
        }
    }
}
?>
