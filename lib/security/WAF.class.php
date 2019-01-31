<?php
namespace zion\security;

use stdClass;

/**
 * Web Application Firewall
 * @author Vinicius Cesar Dias
 * @since 31/01/2019
 */
class WAF {
    private $countryWhitelist = [];
    
    /**
     * Configura as regras do WAF
     * @param array $config
     */
    public static function configure(array $config){
    }
    
    /**
     * Adiciona o usuário na blacklist e para a execução
     */
    public static function addToBlacklist(){
        // inserir na tabela
        
        // retorna status adequado e para a execução
        header("HTTP/1.1 403 Forbidden");
        exit();
    }
    
    /**
     * Verifica se o usuário esta na blacklist
     */
    public static function checkBlacklist(){
        // ler tabela
        
        // verificar se já esta bloqueado 
        
        //header("HTTP/1.1 403 Forbidden");
        //exit();
    }
    
    /**
     * Verifica se o país de acesso esta liberado
     */
    public static function checkCountryAccess(){
        if(sizeof(self::$countryWhitelist) > 0){
            $info = self::getLocationInfoByIP($_SERVER["REMOTE_ADDR"]);
            if(!in_array($info->countryCode,self::$countryWhitelist)){
                self::addToBlacklist();
            }
        }
    }
    
    /**
     * Verifica se as configurações do servidor 
     */
    public static function checkServerConfig(){
        // php.ini mal configurado etc
        
        // apache mal configurado etc
        
        // verifica diretórios com permisão 777 etc
    }
    
    /**
     * Verifica todas as politicas de segurança e realiza o bloqueio se necessário
     */
    public static function checkAll(){
        // verifica se já esta bloqueado
        self::checkBlacklist();
        
        // Metodos HTTP permitidos
        if(!in_array($_SERVER["REQUEST_METHOD"],["GET","POST","HEAD","PUT","DELETE"])){
            self::addToBlacklist();
        }
        
        // SQL Injection
        
        // XSS (Cross-site scripting)
        
        // Path Traversal ou Directory Traversal
        
        // Remote File Inclusions (RFI)
        
        // Double Encode, Evading Tricks
        
        // File Upload
        
        // Padrão de ataques conhecidos
        $URIs = ["wp-config.php","wp-login.php","phpmyadmin","eval(",".cgi"];
        foreach($URIs AS $uri){
            if(strpos($uri,$_SERVER["REQUEST_URI"]) !== false){
                self::addToBlacklist();
            }
        }
        
        // user agent fora do padrão
    }
    
    /**
     * Ler log de erro do apache e bloquear acessos consecutivos de erros
     * Exemplos: 
     * - Mais de 60 erros HTTP na faixa de 400-599 em menos de 1 minuto
     */
    public static function analisePassiva(){
        // ler as ultimas 1000 access_log
        // ler error_log
    }
    
    /**
     * Retorna informações da localização do usuário com base no IP
     * @param string $ip
     * @return stdClass
     */
    public static function getLocationInfoByIP($ip) {
        return new stdClass();
    }
}
?>