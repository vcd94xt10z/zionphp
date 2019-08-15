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
 * Isso será útil caso queira executar comandos sql em sistemas que não tem um driver de conexão
 */
class WebSQL {
    /**
     * Lista de IPs que podem utilizar este serviço
     * @var array
     */
    private static $allowedIPList = array();
    
    /**
     * Lista de Tokens que podem utilizar este serviço
     * @var array
     */
    private static $allowedTokenList = array();
    
    /**
     * Tamanho máximo aceito dos comandos
     * @var integer
     */
    private static $maxLength = 5242880; // 5 megabytes
    
    public static function setAllowedIPList(array $list){
        self::$allowedIPList = $list;
    }
    
    public static function setTokenList(array $list){
        self::$allowedTokenList = $list;
    }
    
    public static function setMaxLength($length){
        self::$maxLength = $length;
    }
    
    /**
     * Configure uma rota para chamar este método
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
        set_time_limit(300); // 5 minutos
        
        // input
        $input = file_get_contents("php://input");
        
        // validações
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            throw new Exception("Método HTTP inválido",405);
        }
        
        if(strlen($input) > self::$maxLength){
            throw new Exception("O comando é muito grande, máximo permitido ".self::$maxLength."!",400);
        }
        
        if($input == ""){
            throw new Exception("O comando esta vazio",400);
        }
        
        // verificando se alguma configuração foi feita
        if(sizeof(self::$allowedIPList) <= 0 AND sizeof(self::$allowedTokenList) <= 0){
            throw new Exception("Configuração de permissão ausente, contate o administrador!",503);
        }
        
        // verificando permissões
        $authOk = false;
        
        if(sizeof(self::$allowedIPList) > 0){
            if(in_array($_SERVER["REMOTE_ADDR"],self::$allowedIPList)){
                $authOk = true;
            }
        }
        
        if(sizeof(self::$allowedTokenList) > 0){
            if(in_array($_SERVER["HTTP_X_TOKEN"],self::$allowedTokenList)){
                $authOk = true;
            }
        }
        
        if(!$authOk){
            throw new Exception("Você não tem autorização para utilizar este serviço (".$_SERVER["REMOTE_ADDR"].")",401);
        }
        
        // convertendo para UTF-8
        $input = utf8_encode($input);
        
        // debug
        if($_SERVER["HTTP_X_DEBUG"] == "1"){
            $file = \zion\APP_ROOT."tmp/websql.log";
            $f = fopen($file,"a+");
            fwrite($f,$input);
            fclose($f);
        }
        
        // executando
        $db = System::getConnection();
        
        if(strpos(strtoupper($input),"SELECT") === 0){
            $query = $db->query($input);
            
            $dataList = array();
            while($raw = $query->fetch(PDO::FETCH_ASSOC)){
                $dataList[] = $raw;
            }
            
            // resposta
            HTTPUtils::status(200);
            header("Content-Type: application/json");
            echo json_encode($dataList);
        }else{
            $affectedRows = $db->exec($input);
            
            // resposta
            HTTPUtils::status(200);
            echo $affectedRows;
        }
    }
}
?>