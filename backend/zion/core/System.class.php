<?php
namespace zion\core;

use Exception;
use PDOException;
use zion\orm\PDO;
use zion\orm\MySQLDAO;
use zion\orm\MSSQLDAO;
use zion\utils\FileUtils;
use zion\mod\welcome\controller\WelcomeController;

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
	    
	    self::loadConfigFile();
	    
	    // view
	    self::set("view-js",array(
	        "/zion/lib/jquery/jquery-3.3.1.min.js",
	        "/zion/lib/jquery.mask.min.js",
	        "/zion/lib/sweetalert.min.js",
	        "/zion/lib/notifyjs/notify.min.js",
	        "/zion/lib/bootstrap-4.2.1-dist/js/bootstrap.min.js",
	        "/zion/lib/zion/default.js"
	    ));
	    
	    self::set("view-css",array(
	        "/zion/lib/bootstrap-4.2.1-dist/css/bootstrap.min.css",
	        "/zion/lib/zion/default.css"
	    ));
	    
	    spl_autoload_register("\zion\core\System::autoloadApp");
	}
	
	/**
	 * Autoload preparado para funcionar com classes no padrão
	 * 
	 * Referência
	 * $obj = new \mod\module1\controller\UserController()
	 * 
	 * Diretório
	 * /modules/module1/controller/UserController.class.php
	 * @param string $className
	 */
	public static function autoloadApp($className){
	    if(strpos($className, "mod\\") === 0) {
	        $parts = explode("\\", $className);
	        $parts[0] = "modules";
	        
	        $file = $_SERVER["DOCUMENT_ROOT"].implode("/", $parts).".class.php";
	        if(file_exists($file)){
	            require($file);
	        }
	        return;
	    }
	}
	
	/**
	 * Mapea as rotas padrões para os módulos
	 */
	public static function routeApp(){
	    $uri = explode("/",$_SERVER["REQUEST_URI"]);
	    
	    if(sizeof($uri) < 5){
	        header("HTTP/1.0 404 Not Found");
	        echo "Página não encontrada";
	        exit();
	    }
	    
	    if(strpos($_SERVER["REQUEST_URI"],"/modules/") === 0){
	        $module     = preg_replace("[^a-zA-Z0-9]", "", $uri[2]);
	        $controller = preg_replace("[^a-zA-Z0-9]", "", $uri[3]);
	        $action     = explode("?", $uri[4]);
	        $action     = preg_replace("[^a-zA-Z0-9]", "", $action[0]);
	        
	        $className   = $controller."Controller";
	        $classNameNS = "\\mod\\".$module."\\controller\\".$controller."Controller";
	        $classFile   = $_SERVER["DOCUMENT_ROOT"]."/modules/".$module."/controller/".$className.".class.php";
	        
	        if(file_exists($classFile)) {
	            require($classFile);
	            $ctrl = new $classNameNS();
	            
	            $methodName = "action".ucfirst($action);
	            if(method_exists($ctrl, $methodName)){
	                $ctrl->$methodName();
	                exit();
	            }
	        }
	    }
	    
	    header("HTTP/1.0 404 Not Found");
	    echo "Página não encontrada";
	    exit();
	}
	
	/**
	 * Chamar esse método caso utilize arquivos de frontend de modulos
	 */
	public static function route(){
	    if(strpos($_SERVER["REQUEST_URI"],"/zion/") !== 0){
	        return;
	    }
	    
	    if($_SERVER["REQUEST_URI"] == "/zion/"){
	        $ctrl = new WelcomeController();
	        $ctrl->actionHome();
	        exit();
	    }
	    
	    // framework / bibliotecas frontend
	    if(strpos($_SERVER["REQUEST_URI"],"/zion/lib/") === 0){
	        $file = \zion\ROOT."frontend".str_replace("/zion/lib/","/",$_SERVER["REQUEST_URI"]);
	        if(file_exists($file)){
	            FileUtils::inline($file);
	        }else{
	            header("HTTP/1.0 404 Not Found");
	        }
	        exit();
	    }
	    
	    if(strpos($_SERVER["REQUEST_URI"],"/zion/mod/") === 0){
    	    $uri = explode("/", $_SERVER["REQUEST_URI"]);
    	    if(sizeof($uri) < 6) {
    	        header("HTTP/1.0 404 Not Found");
    	        header("x-track: 1");
    	        exit();
    	    }
    	    
    	    $module = preg_replace("[^a-z0-9\_]", "", strtolower($uri[3]));
    	    
    	    // padrão de view
    	    if($uri[4] == "view"){
    	        $file = \zion\ROOT.str_replace("/zion/mod/","/modules/",$_SERVER["REQUEST_URI"]);
    	        if(file_exists($file)){
    	            FileUtils::inline($file);
    	            exit();
    	        }
    	        
    	        header("HTTP/1.0 404 Not Found");
    	        header("x-track: 3");
    	        exit();
    	    }
	    }
	    
	    // padrão de controle
	    $controller = preg_replace("[^a-zA-Z0-9]", "", $uri[4]);
	    $action     = explode("?", $uri[5]);
	    $action     = preg_replace("[^a-zA-Z0-9]", "", $action[0]);
	    
	    $className   = $controller."Controller";
	    $classNameNS = "\\zion\\mod\\".$module."\\controller\\".$controller."Controller";
	    $classFile   = \zion\ROOT."modules/".$module."/controller/".$className.".class.php";
	    
	    if(file_exists($classFile)) {
	        require($classFile);
	        $ctrl = new $classNameNS();
	        
	        $methodName = "action".ucfirst($action);
	        if(method_exists($ctrl, $methodName)){
	            $ctrl->$methodName();
	            exit();
	        }
	    }
	    
	    header("HTTP/1.0 404 Not Found");
	    header("x-track: 4");
	    exit();
	}
	
	/**
	 * Carrega as configurações da aplicação automaticamente, procurando
	 * em um nível acima do DOCUMENT_ROOT, no arquivo config.json
	 * 
	 * Atenção! Só carrega a configuração do ambiente atual
	 */
	public static function loadConfigFile(){
	    $file = dirname($_SERVER["DOCUMENT_ROOT"])."/config.json";
	    if(!file_exists($file)){
	        return;
	    }
	    
	    $json = json_decode(file_get_contents($file),true);
	    if(!is_array($json)){
	        return;
	    }
	    
	    if(!array_key_exists(\zion\ENV,$json)){
	        return;
	    }
	    
	    $config = $json[\zion\ENV];
	    if(!is_array($config)){
	        return;
	    }
	    
	    foreach($config AS $key => $value){
	        self::set($key,$value);
	    }
	}
	
	public static function genUID($prefix="100000000"){
		// gera um id de 32 caracteres com o prefixo '100000000'
		return uniqid($prefix,true);
	}
	
	/**
	 * Para tudo e retorna um status de erro com mensagem
	 * @param string $message
	 * @param int $status
	 */
	public static function exitWithError(string $message,int $status=500){
	    header("HTTP/1.1 ".$status);
	    echo $message;
	    exit();
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
	public static function get($key){
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

	public static function getDAO(PDO $db = null,$tableName=""){
		$config = System::get("database");
		
		// obtendo DAO de acordo com o SGBD
		switch(strtolower($config["DBMS"])){
		case "mysql":
			$dao = new MySQLDAO($db,$tableName);
			break;
		case "mssql":
		    $dao = new MSSQLDAO($db,$tableName);
		    break;
		default:
			throw new Exception("DAO indisponível para o DBMS");
			break;
		}
		
		return $dao;
	}
}
?>