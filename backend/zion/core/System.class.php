<?php
namespace zion\core;

use Exception;
use PDOException;
use zion\orm\PDO;
use zion\orm\MySQLDAO;
use zion\orm\MSSQLDAO;
use zion\utils\HTTPUtils;

/**
 * @author Vinicius Cesar Dias
 */
class System {
	// armazena variáveis globais no sistema
	public static $data = array();
	
	public static function configure(){
	    // constantes
	    if(!defined("DS")){
	        define("DS",DIRECTORY_SEPARATOR);
	    }
	    
	    define("zion\CHARSET","UTF-8");
	    
	    define("zion\HASH_PASSWORD_PREFIX","#198@Az9fF0%*");
	    
	    // diretórios
	    define("zion\TEMP",\zion\ROOT."tmp".\DS);
	    
	    // configurações
	    ini_set("default_charset",\zion\CHARSET);
	    mb_internal_encoding(\zion\CHARSET);
	    
	    self::setTimezone("-03:00");
	    
	    // detectando ambiente
	    $env = "PRD";
	    if(strpos($_SERVER["SERVER_NAME"],".des") !== false OR strpos($_SERVER["SERVER_NAME"],".dev") !== false){
	        $env = "DEV";
	    }else if(strpos($_SERVER["SERVER_NAME"],".qas") !== false){
	        $env = "QAS";
	    }
	    define("zion\ENV",$env);
	    
	    // erros
	    if(\zion\ENV != "PRD"){
	        error_reporting(E_ALL ^ E_NOTICE);
	        ini_set('display_errors', 1);
	    }
	    
	    set_error_handler("zion\core\ErrorHandler::handleError",E_ALL);
	    set_exception_handler("zion\core\ErrorHandler::handleException");
	    
	    // configurações do sistema
	    System::set("timezone", "-03:00");
	    System::set("dateFormat", "d/m/Y");
	    System::set("timeFormat", "H:i:s");
	    System::set("dateTimeFormat", "d/m/Y H:i:s");
	    System::set("dateTime2Format", "d/m/Y H:i");
	    System::set("country", "br");
	    System::set("lang", "pt");
	    System::set("langDir", "ltr");
	    System::set("currency", "BRL");
	    System::set("currencySymbol", "R\$");
	    System::set("currencyDecimalPlaces", 2);
	    System::set("currencyDecimalSep", ",");
	    System::set("currencyThousandSep", ".");
	    System::setTimezone(System::get("timezone"));
	    
	    // valida o espaço disponível
	    self::checkStorage();
	    
	    // configurações do aplicativo
	    self::loadConfigFile("config.json",true);
	    self::loadConfigFile(\zion\ENV.".json",false);
	    
	    // verificando se o aplicativo esta ativo
	    self::checkStatus();
	    
	    // verificando se o WAF esta ativo
	    $app = System::get("app");
	    if($app["waf"] == "light"){
	        \zion\security\WAF::lightMode();
	    }elseif($app["waf"] == "hard"){
	        \zion\security\WAF::hardMode();
	    }
	    
	    // view
	    Page::jsBulk(array(
	        "/zion/lib/zion/native.js",
	        "/zion/lib/jquery.mask.min.js",
	        "/zion/lib/sweetalert.min.js",
	        "/zion/lib/notifyjs/notify.min.js",
	        "/zion/lib/zion/default.js",
	        "/zion/lib/cssmenumaker/script.js"
	    ));
	    
	    Page::cssBulk(array(
	        "/zion/lib/zion/default.css",
	        "/zion/lib/cssmenumaker/styles.css"
	    ));
	    
	    spl_autoload_register("\zion\core\App::autoload");
	}
	
	/**
	 * Retorna o mandante do domínio se houver
	 * @param string $domain
	 * @return int
	 */
	public static function getDomainInfo($domain=null){
	    $info = array(
	        "mandt"  => 0,
	        "system" => ""
	    );
	    
	    try {
	        if($domain == null){
	            $domain = $_SERVER["SERVER_NAME"];
	        }
	        $domain = preg_replace("[^a-zA-Z0-9\.\_]","",$domain);
	        
	        $db = System::getConnection();
	        $dao = System::getDAO($db,"zion_core_domain");
	        $obj = $dao->getObject($db, array("domain" => $domain));
	        if($obj != null){
	            $info["mandt"]  = intval($obj->get("mandt"));
	            $info["system"] = $obj->get("system");
	        }
	    }catch(Exception $e){
	    }
	    
	    if(array_key_exists("mandt",$_COOKIE)){
	        $info["mandt"] = intval($_COOKIE["mandt"]);
	    }
	    
	    return $info;
	}
	
	/**
	 * Mapea uma URI para um método de um controle
	 */
	public static function routeToController(){
	    try {
            $uri = explode("?",$_SERVER["REQUEST_URI"]);
            $uri = trim($uri[0],"/");
	        
	        $db = System::getConnection();
	        $dao = System::getDAO($db,"zion_core_route");
	        $keys = array(
	            "mandt" => \MANDT,
	            "uri" => $uri
	        );
	        $obj = $dao->getObject($db, $keys);
	        if($obj == null){
	            return;
	        }
	        
	        $className = $obj->get("controller");
	        $methodName = $obj->get("action");
	        
	        if(!class_exists($className)){
	            return;
	        }
	        
	        $ctrl = new $className();
	        if(!method_exists($ctrl,$methodName)){
	            return;
	        }
	        
	        $ctrl->$methodName();
	        exit();
        }catch(Exception $e){
	    }
	}
	
	/**
	 * Retorna informações de espaço de um diretório
	 */
	public static function getDiskInfo($folder="/"){
	    $free        = disk_free_space($folder);
	    $total       = disk_total_space($folder);
	    $freePercent = ($free * 100)/$total;
	    
	    return array(
	        "free"        => $free,
	        "total"       => $total,
	        "freePercent" => $freePercent
	    );
	}
	
	/**
	 * Verifica se há um espaço minimo para o servidor funcionar
	 */
	public static function checkStorage(){
	    // arquivos estaticos não precisam parar a execução por falta de espaço
	    // pois não gravam nada no disco e também são usados em páginas de erro
	    if(self::isStaticURI()){
	        return;
	    }
	    
	    $minFreePercent = 10;
	    
	    // raiz
	    $folder = "/";
	    $info = System::getDiskInfo($folder);
	    
	    if($info["freePercent"] < $minFreePercent){
	        $message = "Não há espaço suficiente em ".$folder.", é necessário pelo menos "
	                   .$minFreePercent."%, contate o administrador";
	        
	        HTTPUtils::status(507);
	        HTTPUtils::template(507,$message);
	        exit();
	    }
	    
	    // pasta do aplicativo
	    $folder = $_SERVER["DOCUMENT_ROOT"];
	    $info = System::getDiskInfo($folder);
	    
	    if($info["freePercent"] < $minFreePercent){
	        $message = "Não há espaço suficiente em ".$folder.", é necessário pelo menos "
	            .$minFreePercent."%, contate o administrador";
	        
	        HTTPUtils::status(507);
	        HTTPUtils::template(507,$message);
	        exit();
	    }
	}
	
	public static function isStaticURI(){
	    $uri = explode("?",$_SERVER["REQUEST_URI"]);
	    $uri = $uri[0];
	    $ext = explode(".",$uri);
	    $ext = $ext[sizeof($ext)-1];
	    
	    if(in_array($ext,array("css","js"))){
	        return true;
	    }
	    return false;
	}
	
	/**
	 * Verifica se há um espaço minimo para o servidor funcionar
	 */
	public static function checkStatus(){
	    if(self::isStaticURI()){
	        return;
	    }
	    
	    $app = System::get("app");
	    if($app != null AND array_key_exists("online",$app) AND $app["online"] == "0"){
	        HTTPUtils::status(503);
	        header("Retry-After: 600");
	        HTTPUtils::template(503,"Sistema em manutenção");
	        exit();
	    }
	}
	
	/**
	 * Carrega as configurações, procurando
	 * em um nível acima do DOCUMENT_ROOT
	 */
	public static function loadConfigFile($filename,$stopOnError=true){
	    $file = dirname($_SERVER["DOCUMENT_ROOT"])."/".$filename;
	    if(!file_exists($file)){
	        if(!$stopOnError){
	            return;
	        }
	        
	        HTTPUtils::status(500);
	        echo "Arquivo de configuração {$filename} não encontrado";
	        exit();
	    }
	    
	    $json = json_decode(file_get_contents($file),true);
	    if(!is_array($json)){
	        return;
	    }
	    
	    foreach($json AS $key => $value){
	        System::set($key,$value);
	    }
	}
	
	public static function genUID($prefix="100000000"){
		// gera um id de 32 caracteres com o prefixo '100000000'
		return uniqid($prefix,true);
	}
	
	/**
	 * Seta uma variável
	 * Há duas assinaturas:
	 * - set(nome,valor) Seta apenas uma variável
	 * - set(array) Faz o mesmo efeito da primeira, só que em massa
	 */
	public static function set($arg1,$arg2=null){
		if(is_array($arg1)){
			foreach($arg1 AS $key => $value){
				self::$data[$key] = $value;
			}
		}else{
			self::$data[$arg1] = $arg2;
		}
	}

	public static function set2($key1,$key2,$value){
	    self::$data[$key1][$key2] = $value;
	}
	
	public static function set3($key1,$key2,$key3,$value){
	    self::$data[$key1][$key2][$key3] = $value;
	}
	
	/**
	 * Adiciona um valor a um array
	 */
	public static function add($key,$value){
		if(!array_key_exists($key,self::$data)){
			self::$data[$key] = array();
		}

		// se value for array, distribui os valores como se estivesse chamando vários add()
		// Atenção: neste método não é possível adicionar um array dentro do array, faça direto no atributo data!
		if(is_array($value)){
			self::$data[$key] = array_merge(self::$data[$key],$value);
		}else{
			self::$data[$key][] = $value;
		}
	}

	/**
	 * Retorna um valor
	 */
	public static function get($key,$key2=null,$key3=null){
	    if($key3 != null){
	        return self::$data[$key][$key2][$key3];
	    }
	    if($key2 != null){
	        return self::$data[$key][$key2];
	    }
		return self::$data[$key];
	}

	public static function getAll(){
		return self::$data;
	}

	/**
	 * Define o timezone do sistema
	 */
	public static function setTimezone($timezone){
		// timezone formato +00:00
		$signal = mb_substr($timezone,0,1);
		$hour = intval(mb_substr($timezone,1,2));
		$minute = intval(mb_substr($timezone,4,2));

		// validando adicional
		if(($signal == "+" || $signal == "-") && ($hour >= -14 && $hour <= 14) && ($minute >= 0 && $minute < 60)){
			// atenção! O PHP inverte o sinal
			$signal = ($signal == "+")?"-":"+";
			$timezonePHP = "Etc/GMT".$signal.$hour;
			date_default_timezone_set($timezonePHP);
		}
	}
	
	/**
	 * Retorna uma nova conexão com o banco de dados
	 * @param string $exclusive
	 * @throws \Exception
	 */
	public static function getConnection(string $configKey = 'database'){
		$config = System::get($configKey);

		$driverOptions = array(
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_TIMEOUT => 10, // 300
			//\PDO::ATTR_PERSISTENT => true
		);
		$strConnection = "";

		// configurações pré
		switch(strtolower($config["DBMS"])){
		case "mysql":
			$strConnection = "mysql:host=".$config["host"].";port=".$config["port"].";dbname=".$config["schema"].";charset=utf8";
			$driverOptions[\PDO::MYSQL_ATTR_LOCAL_INFILE] = true;
			break;
		case "mssql":
		case "sqlserver":
			$strConnection = "dblib:host=".$config["host"].":".$config["port"].";dbname=".$config["schema"];
			break;
		case "oracle":
			$strConnection = "OCI:dbname=".$config["schema"].";charset=UTF-8";
			break;
		}

		if($strConnection == ""){
			throw new \Exception("Nenhum driver encontrado para o DBMS '".$config["DBMS"]."'");
		}

		$pdo = null;
		try {
			$pdo = new PDO($strConnection,$config["user"],$config["password"],$driverOptions);
		}catch(PDOException $e){
		    switch(strtolower($config["DBMS"])){
            case "mysql":
                break;
            case "mssql":
            case "sqlserver":
                if($e->getCode() == 20009){
                    throw new Exception("Erro em conectar no banco, verifique se ele esta rodando e acessível");
                }
                break;
		    }
		    throw new Exception("Erro em conectar no banco de dados: ".$e->getMessage());
		}

		// configurações pós
		switch(strtolower($config["DBMS"])){
		case "mysql":
			// configurações obrigatórias, a não ser que você configure direto no banco
		    $pdo->query("SET @@time_zone = '-3:00'");
		    
		    // tudo é em UTF8 para não ter problemas com qualquer tipo de caracter
		    //$pdo->query("SET NAMES 'utf8'");
			break;
		case "mssql":
		case "sqlserver":
		    $pdo->query("SET DATEFORMAT ymd");
		    break;
		}
		
		return $pdo;
	}

	public static function getDAO(PDO $db = null,$tableName="",$className=""){
	    $DBMS = "";
	    
	    // detectando DBMS
	    if($db == null){
	        $config = System::get("database");
	        $DBMS = strtolower($config["DBMS"]);
	    }else{
	        $dsn = strtolower($db->dsn);
	        if(strpos($dsn,"mysql") !== false){
	            $DBMS = "mysql";
	        }elseif(strpos($dsn,"dblib") !== false){
	            $DBMS = "mssql";
	        }
	        
	        if($dsn == ""){
	            throw new Exception("DSN vazio");
	        }
	    }
	    
	    if($DBMS == ""){
	        throw new Exception("DBMS não encontrado");
	    }
	    
		// obtendo DAO de acordo com o DBMS
	    if($DBMS == "mysql"){
	        $dao = new MySQLDAO($db,$tableName,$className);
	    }elseif($DBMS == "mssql"){
	        $dao = new MSSQLDAO($db,$tableName,$className);
	    }else{
	        throw new Exception("DAO indisponível para o DBMS (".$dsn.")");
		}
		
		return $dao;
	}
}
?>