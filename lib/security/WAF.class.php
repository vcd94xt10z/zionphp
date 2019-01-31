<?php
namespace zion\security;

use Exception;
use PDO;
use stdClass;

/**
 * Web Application Firewall
 * @author Vinicius Cesar Dias
 * @since 31/01/2019
 */
class WAF {
    private static $freeURIList = [];
    private static $countryWhitelist = [];
    private static $conn = null;
    
    /**
     * Configura as regras do WAF
     * @param array $config
     */
    public static function init($conn, array $config = []){
        self::$conn = $conn;
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    /**
     * Adiciona o usuário na blacklist e para a execução
     */
    public static function addToBlacklist($policy,array $params = []){
        $REMOTE_ADDR = $_SERVER["REMOTE_ADDR"];
        $HTTP_USER_AGENT = $_SERVER["HTTP_USER_AGENT"];
        $REQUEST_URI = $_SERVER["REQUEST_URI"];
        $SERVER_NAME = $_SERVER["SERVER_NAME"];
        if(sizeof($params) > 0) {
            $REMOTE_ADDR = $params["REMOTE_ADDR"];
            $HTTP_USER_AGENT = $params["HTTP_USER_AGENT"];
            $REQUEST_URI = $params["REQUEST_URI"];
            $SERVER_NAME = $params["SERVER_NAME"];
        }
        
        $sql = "INSERT INTO `waf_blacklist`
    			(`ipaddress`, `created`, `user_agent`, `request_uri`, `server_name`, `hits`, `policy`, `updated`)
    			VALUES
				(':ipaddress:', NOW(), ':user_agent:', ':request_uri:', ':server_name:', 1, ':policy:', NOW()) 
                ON DUPLICATE KEY UPDATE 
                `created` = NOW(), `request_uri` = ':request_uri:', `hits`= `hits`+1, `updated` = NOW()";
        $sql = str_replace(":ipaddress:", $REMOTE_ADDR, $sql);
        $sql = str_replace(":user_agent:", addslashes($HTTP_USER_AGENT), $sql);
        $sql = str_replace(":request_uri:", addslashes($REQUEST_URI), $sql);
        $sql = str_replace(":server_name:", addslashes($SERVER_NAME), $sql);
        $sql = str_replace(":policy:", addslashes($policy), $sql);
        
        try {
            self::$conn->exec($sql);
        }catch(Exception $e){
        }
        
        self::sendError();
    }
    
    /**
     * Verifica se o usuário esta na blacklist
     */
    public static function checkBlacklist(){
        $timeout = 3600;
        
        $sql = "SELECT * 
                  FROM `waf_blacklist`
                 WHERE `ipaddress` = '".$_SERVER["REMOTE_ADDR"]."'
                   AND TIMESTAMPDIFF(SECOND,`created`,NOW()) < ".$timeout;
        $query = self::$conn->query($sql);
        $raw = $query->fetchObject();
        if($raw !== false){
            self::sendError();
        }
    }
    
    /**
     * Verifica se o país de acesso esta liberado
     */
    public static function checkCountryAccess(){
        if(sizeof(self::$countryWhitelist) > 0){
            $info = self::getLocationInfoByIP($_SERVER["REMOTE_ADDR"]);
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
        // verifica se já esta bloqueado
        self::checkBlacklist();
        
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
    public static function getClientLocation($ip) {
        // verificando cache
        $obj = self::getClientLocationCache($ip);
        if($obj != null) {
            return $obj;
        }
        
        $apiKey = "123456";
        $url = "http://api.ipstack.com/".$ip."?access_key=".$apiKey."&format=1";
        $response = file_get_contents($url);
        $json = json_decode($response);
        
        $obj = new StdClass();
        $obj->ip = trim($json->ip);
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
        if($obj->ip != "") {
            self::putClientLocationCache($obj);
        }
        
        return $obj;
    }
    
    public static function getClientLocationCache($ip) {
        $sql = "SELECT * 
                  FROM waf_ip_location
                 WHERE ip = '".addslashes($ip)."'";
        $query = self::$conn->query($sql);
        if($raw = $query->fetchObject()) {
            return $raw;
        }
        return null;
    }
    
    public static function putClientLocationCache($obj) {
        $sql = "INSERT INTO `waf_ip_location`
			(`ip`,`type`,`continent_code`,`continent_name`,`country_code`,
			`country_name`,`region_code`,`region_name`,`city`,`updated`)
			VALUES
			(
			':ip:',
			':type:',
			':continent_code:',
			':continent_name:',
			':country_code:',
			':country_name:',
			':region_code:',
			':region_name:',
			':city:',
			NOW()
			)";
        
        $sql = str_replace(":ip:", addslashes($obj->ip), $sql);
        $sql = str_replace(":type:", addslashes($obj->type), $sql);
        $sql = str_replace(":continent_code:", addslashes($obj->continent_code), $sql);
        $sql = str_replace(":continent_name:", addslashes($obj->continent_name), $sql);
        $sql = str_replace(":country_code:", addslashes($obj->country_code), $sql);
        $sql = str_replace(":country_name:", addslashes($obj->country_name), $sql);
        $sql = str_replace(":region_code:", addslashes($obj->region_code), $sql);
        $sql = str_replace(":region_name:", addslashes($obj->region_name), $sql);
        $sql = str_replace(":city:", addslashes($obj->city), $sql);
        self::$conn->exec($sql);
    }
    
    public static function checkWhitelist() {
        // acesso locais permitidos
        if(self::isPrivateIP($_SERVER["REMOTE_ADDR"])) {
            return;
        }
        
        // libera urls especificas
        if(self::isFreeURI($_SERVER["REQUEST_URI"])) {
            return;
        }
        
        $timeout = "21600"; // 6 horas
        
        $sql = "SELECT * FROM `waf_ip_whitelist`
                 WHERE (`ipaddress` = '".$_SERVER["REMOTE_ADDR"]."' AND `type` = 'S')
                    OR (`ipaddress` = '".$_SERVER["REMOTE_ADDR"]."' AND TIMESTAMPDIFF(SECOND,`updated`,NOW()) < ".$timeout." AND `type` = 'D')";
        $query = self::$conn->query($sql);
        $raw = $query->fetchObject();
        if($raw === false OR $raw == null) {
            return;
        }
        
        self::addToBlacklist("not-in-whitelist");
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
     * Registra a requisição no log
     * @param PDO $db
     */
    public static function log(){
        $fields = array("USER", "HOME", "SCRIPT_NAME", "REQUEST_URI", "QUERY_STRING", "REQUEST_METHOD", "SERVER_PROTOCOL",
            "GATEWAY_INTERFACE", "REDIRECT_URL", "REMOTE_PORT", "SCRIPT_FILENAME", "SERVER_ADMIN", "CONTEXT_DOCUMENT_ROOT",
            "CONTEXT_PREFIX", "REQUEST_SCHEME", "DOCUMENT_ROOT", "REMOTE_ADDR", "SERVER_PORT", "SERVER_ADDR", "SERVER_NAME",
            "SERVER_SOFTWARE", "SERVER_SIGNATURE", "PATH", "HTTP_PRAGMA", "HTTP_COOKIE", "HTTP_ACCEPT_LANGUAGE", "HTTP_ACCEPT_ENCODING",
            "HTTP_ACCEPT", "HTTP_DNT", "HTTP_USER_AGENT", "HTTP_UPGRADE_INSECURE_REQUESTS", "HTTP_CONNECTION", "HTTP_HOST", "UNIQUE_ID",
            "REDIRECT_STATUS", "REDIRECT_UNIQUE_ID", "FCGI_ROLE", "PHP_SELF", "REQUEST_TIME_FLOAT", "REQUEST_TIME", "HTTP_REFERER", "REQUEST_BODY");
        
        $sql = "INSERT INTO waf_request_log
                (requestid, ".implode(", ",$fields).")
                VALUES
                (null, :".implode(":, :",$fields).":)";
        
        foreach($fields AS $field) {
            if($field == "REQUEST_TIME") {
                $sql = str_replace(":".$field.":", "NOW()", $sql);
            }else if($field == "REQUEST_BODY") {
                $sql = str_replace(":".$field.":", "'".addslashes(file_get_contents("php://input"))."'", $sql);
            }else{
                $sql = str_replace(":".$field.":", "'".addslashes($_SERVER[$field])."'", $sql);
            }
        }
        
        try {
            self::$conn->exec($sql);
        }catch(Exception $e){
        }
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
    
    public static function sendError(){
        header('HTTP/1.0 403 Forbidden');
        echo "Acesso negado";
        exit();
    }
    
    public static function createTables($db){
        $sqlList = array();
        
        $sqlList[] = "
        CREATE TABLE IF NOT EXISTS `waf_request_log` (
            `requestid` int(11) NOT NULL AUTO_INCREMENT,
            `USER` varchar(20) DEFAULT NULL,
            `HOME` varchar(45) DEFAULT NULL,
            `SCRIPT_NAME` varchar(300) DEFAULT NULL,
            `REQUEST_URI` varchar(1024) DEFAULT NULL,
            `QUERY_STRING` varchar(300) DEFAULT NULL,
            `REQUEST_METHOD` varchar(10) DEFAULT NULL,
            `SERVER_PROTOCOL` varchar(45) DEFAULT NULL,
            `GATEWAY_INTERFACE` varchar(45) DEFAULT NULL,
            `REDIRECT_URL` varchar(500) DEFAULT NULL,
            `REMOTE_PORT` varchar(10) DEFAULT NULL,
            `SCRIPT_FILENAME` varchar(1024) DEFAULT NULL,
            `SERVER_ADMIN` varchar(45) DEFAULT NULL,
            `CONTEXT_DOCUMENT_ROOT` varchar(1024) DEFAULT NULL,
            `CONTEXT_PREFIX` varchar(100) DEFAULT NULL,
            `REQUEST_SCHEME` varchar(45) DEFAULT NULL,
            `DOCUMENT_ROOT` varchar(500) DEFAULT NULL,
            `REMOTE_ADDR` varchar(20) DEFAULT NULL,
            `SERVER_PORT` varchar(10) DEFAULT NULL,
            `SERVER_ADDR` varchar(20) DEFAULT NULL,
            `SERVER_NAME` varchar(200) DEFAULT NULL,
            `SERVER_SOFTWARE` varchar(100) DEFAULT NULL,
            `SERVER_SIGNATURE` varchar(100) DEFAULT NULL,
            `PATH` varchar(1024) DEFAULT NULL,
            `HTTP_PRAGMA` varchar(45) DEFAULT NULL,
            `HTTP_COOKIE` varchar(1024) DEFAULT NULL,
            `HTTP_ACCEPT_LANGUAGE` varchar(200) DEFAULT NULL,
            `HTTP_ACCEPT_ENCODING` varchar(200) DEFAULT NULL,
            `HTTP_ACCEPT` varchar(1024) DEFAULT NULL,
            `HTTP_DNT` varchar(10) DEFAULT NULL,
            `HTTP_USER_AGENT` varchar(1024) DEFAULT NULL,
            `HTTP_UPGRADE_INSECURE_REQUESTS` varchar(45) DEFAULT NULL,
            `HTTP_CONNECTION` varchar(45) DEFAULT NULL,
            `HTTP_HOST` varchar(100) DEFAULT NULL,
            `UNIQUE_ID` varchar(45) DEFAULT NULL,
            `REDIRECT_STATUS` varchar(45) DEFAULT NULL,
            `REDIRECT_UNIQUE_ID` varchar(45) DEFAULT NULL,
            `FCGI_ROLE` varchar(45) DEFAULT NULL,
            `PHP_SELF` varchar(100) DEFAULT NULL,
            `REQUEST_TIME_FLOAT` varchar(45) DEFAULT NULL,
            `REQUEST_TIME` datetime DEFAULT NULL,
            `HTTP_REFERER` varchar(1024) DEFAULT NULL,
            `REQUEST_BODY` text DEFAULT NULL,
            PRIMARY KEY (`requestid`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        
        $sqlList[] = "
        CREATE TABLE IF NOT EXISTS `waf_whitelist` (
          `ipaddress` varchar(60) NOT NULL,
          `created` datetime NOT NULL,
          `type` varchar(1) NOT NULL COMMENT 'static - S\ndynamic - D',
          `name` varchar(300) NOT NULL,
          `hits` int(11) NOT NULL DEFAULT 1,
          `updated` datetime,
          PRIMARY KEY (`ipaddress`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        $sqlList[] = "
        CREATE TABLE IF NOT EXISTS `waf_blacklist` (
            `ipaddress` varchar(20) NOT NULL,
            `created` datetime DEFAULT NULL,
            `user_agent` varchar(2048) DEFAULT NULL,
            `request_uri` varchar(2048) DEFAULT NULL,
            `server_name` varchar(2048) DEFAULT NULL,
            `hits` int(11) NOT NULL DEFAULT 1,
            `policy` varchar(100) DEFAULT NULL,
            `updated` datetime,
            PRIMARY KEY (`ipaddress`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        $sqlList[] = "
        CREATE TABLE IF NOT EXISTS `waf_ip_location` (
          `ip` char(60) NOT NULL,
          `type` varchar(10) DEFAULT NULL,
          `continent_code` varchar(5) DEFAULT NULL,
          `continent_name` varchar(20) DEFAULT NULL,
          `country_code` varchar(5) NOT NULL,
          `country_name` varchar(20) DEFAULT NULL,
          `region_code` varchar(5) DEFAULT NULL,
          `region_name` varchar(20) DEFAULT NULL,
          `city` varchar(180) DEFAULT NULL,
          `updated` datetime DEFAULT NULL,
          PRIMARY KEY (`ip`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        foreach($sqlList AS $sql){
            try {
                self::$conn->exec($sql);
            }catch(Exception $e){
            }
        }
    }
}
?>