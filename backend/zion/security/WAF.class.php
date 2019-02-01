<?php
namespace zion\security;

use PDO;
use stdClass;

/**
 * Web Application Firewall
 * @author Vinicius Cesar Dias
 * @since 31/01/2019
 */
class WAF {
    public static $ipstackAPIKey     = "";
    
    private static $conn             = null;
    private static $freeURIList      = [];
    private static $countryWhitelist = [];
    
    /**
     * Configura as regras do WAF
     * @param array $config
     */
    public static function init($conn, array $config = []){
        self::$conn = $conn;
        self::$conn->exec("SET NAMES UTF8");
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if(array_key_exists("ipstackAPIKey",$config)){
            self::$ipstackAPIKey = $config["ipstackAPIKey"];
        }
        
        if(array_key_exists("freeURIList",$config)){
            self::$freeURIList = $config["freeURIList"];
        }
        
        if(array_key_exists("countryWhitelist",$config)){
            self::$countryWhitelist = $config["countryWhitelist"];
        }
        
        //$dao = new WAFDAO();
        //$dao->createTables($conn);
    }
    
    /**
     * Trabalha com blacklist, ou seja, detecta o ataque
     * e coloca na blacklist. Na próxima vez, já é barrado no inicio da execução
     */
    public static function lightMode(){
        // log da requisição
        self::log();
        
        // libera urls especificas
        if(self::isFreeURI($_SERVER["REQUEST_URI"])) {
            return;
        }
        
        // verifica se já esta bloqueado
        self::checkBlacklist();
        
        // verifica todos os tipos de ataques
        self::checkAll();
    }
    
    /**
     * Trabalha com whitelist, ou seja, bloqueio tudo, exceto quem estiver na whitelist
     */
    public static function hardMode(){
        // log da requisição
        self::log();
        
        // libera urls especificas
        if(self::isFreeURI($_SERVER["REQUEST_URI"])) {
            return;
        }
        
        // verifica todos os tipos de ataques
        self::checkAll();
        
        // verifica se esta na whitelist
        self::checkWhitelist();
    }
    
    /**
     * Adiciona o usuário na blacklist e para a execução
     */
    public static function addToBlacklist($policy,array $params = []){
        $dao = new WAFDAO();
        $dao->addToBlacklist(self::$conn, $policy, $params);
        $dao = null;
        self::sendError();
    }
    
    /**
     * Verifica se o usuário esta na blacklist
     */
    public static function checkBlacklist(){
        $dao = new WAFDAO();
        if($dao->inBlacklist(self::$conn)){
            self::sendError();
        }
    }
    
    /**
     * Verifica se o país de acesso esta liberado
     */
    public static function checkCountryAccess(){
        if(sizeof(self::$countryWhitelist) > 0){
            $info = self::getClientLocation($_SERVER["REMOTE_ADDR"]);
            if(!in_array($info->countryCode,self::$countryWhitelist)){
                self::addToBlacklist("country");
            }
        }
    }
    
    /**
     * Verifica se as configurações do servidor 
     */
    public static function checkServerConfig(){
        // php.ini mal configurado etc
        
        // apache mal configurado etc
        
        // apache como root
        
        // verifica diretórios com permisão 777 etc
    }
    
    /**
     * Verifica todas as politicas de segurança e realiza o bloqueio se necessário
     */
    public static function checkAll(){
        // Metodos HTTP permitidos
        if(!in_array($_SERVER["REQUEST_METHOD"],["GET","POST","HEAD","PUT","DELETE"])){
            self::addToBlacklist("httpMethod");
        }
        
        // SQL Injection
        
        // XSS (Cross-site scripting)
        
        // Path Traversal ou Directory Traversal
        
        // Remote File Inclusions (RFI)
        
        // Double Encode, Evading Tricks
        
        // File Upload
        
        // baduri - Padrão de ataques conhecidos
        $URIs = ["wp-config.php","wp-login.php","phpmyadmin","eval(",".cgi"];
        foreach($URIs AS $uri){
            if(strpos($_SERVER["REQUEST_URI"],$uri) !== false){
                self::addToBlacklist("badURI");
            }
        }
        
        // user agent fora do padrão
    }
    
    /**
     * Verifica se esta na whitelist, se não estiver 
     * bloqueia e coloca na whitelist
     */
    public static function checkWhitelist() {
        // acesso locais permitidos
        if(self::isPrivateIP($_SERVER["REMOTE_ADDR"])) {
            return;
        }
        
        $dao = new WAFDAO();
        if(!$dao->inWhitelist(self::$conn)){
            self::addToBlacklist("not-in-whitelist");
        }
    }
    
    /**
     * Verifica se a URI é livre de verificação de IP
     * @param string $requestURI
     * @return boolean
     */
    public static function isFreeURI($requestURI) {
        foreach(self::$freeURIList AS $freeURI) {
            if(mb_strpos($requestURI, $freeURI) === 0) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Faz log da requisição
     */
    public static function log(){
        $dao = new WAFDAO();
        $dao->log(self::$conn);
        $dao = null;
    }
    
    /**
     * Retorna informações da localização do usuário com base no IP
     * @param string $ip
     * @return stdClass
     */
    public static function getClientLocation($ip) {
        $dao = new WAFDAO();
        
        // verificando cache
        $obj = $dao->getClientLocation(self::$conn,$ip);
        if($obj != null) {
            return $obj;
        }
        
        $apiKey = self::$ipstackAPIKey;
        $url = "http://api.ipstack.com/".$ip."?access_key=".$apiKey."&format=1";
        $response = file_get_contents($url);
        $json = json_decode($response);
        
        $obj = new StdClass();
        $obj->ipaddr = trim($json->ip);
        $obj->type = $json->type;
        $obj->continent_code = $json->continent_code;
        $obj->continent_name = $json->continent_name;
        $obj->country_code = $json->country_code;
        $obj->country_name = $json->country_name;
        $obj->region_code = $json->region_code;
        $obj->region_name = $json->region_name;
        $obj->city = $json->city;
        $obj->mode = "online";
        if($obj->country_code == null) {
            $obj->country_code = "BR";
        }
        
        // gravando no cache
        if($obj->ipaddr != "") {
            $dao->putClientLocation(self::$conn,$obj);
        }
        
        return $obj;
    }
    
    public static function isPrivateIP($ip) {
        if($ip == "localhost" || strpos($ip, "127.0.0.") === 0) {
            return true;
        }
        
        $ip = ip2long($ip);
        $net_a = ip2long('10.255.255.255') >> 24;
        $net_b = ip2long('172.31.255.255') >> 20;
        $net_c = ip2long('192.168.255.255') >> 16;
        
        return $ip >> 24 === $net_a || $ip >> 20 === $net_b || $ip >> 16 === $net_c;
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
    
    public static function sendError(){
        header('HTTP/1.0 403 Forbidden');
        echo "Access Denied";
        exit();
    }
}
?>