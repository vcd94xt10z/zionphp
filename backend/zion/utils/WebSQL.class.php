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
        $input = file_get_contents("php://input");
        
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
        $input = utf8_encode($input);
        
        // debug
        if($_SERVER["HTTP_X_DEBUG"] == "1"){
            $file = \zion\APP_ROOT."tmp/websql.log";
            $f = fopen($file,"a+");
            fwrite($f,$input);
            fclose($f);
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
            $db = System::getConnection();
            $affectedRows = $db->exec($input);
            $db = null;
            
            // resposta
            HTTPUtils::status(200);
            echo $affectedRows;
        }
    }
}
?>