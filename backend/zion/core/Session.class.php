<?php
namespace zion\core;

use DateTime;
use Exception;
use zion\utils\DateTimeUtils;
use zion\utils\FileUtils;
use zion\utils\StringUtils;

/**
 *
 * @author Vinicius Cesar Dias
 *
 * Faz o gerenciamento de sessão sem problemas com cabeçalhos, salva (e serializa) e carrega automaticamente os dados.
 * Cria uma camada de segurança validando o ip e o navegador do usuário que criou a sessão
 * 
 * Para usar basta chamar os métodos: set,get,add,getAll etc. O restante dos métodos é para uso interno
 * A classe carrega e gravar dados toda vez que uma informação precisa ser atualizada e sempre carrega a sessão
 * novamente quando precisa ler uma informação
 * 
 * Para limpar sessões antigas, é necessário chamar o método cleanFilesSession periodicamente, crie um job
 * 
 * Atenção! em caso de scripts assincronos, uma sessão pode sobre escrever a outra, considere isso
 */
class Session {
    public static $sessionKey = "ZSESSIONID";
    
	/**
	 * Tempo para expirar a sessão em segundos
	 * 3600 segundos = 1 hora
	 * 86400 segundos = 1 dia
	 * @var integer
	 */
    private static $expireTime = 3600; 
	
	private static $id = "";
	private static $data = array();
	private static $info = array();
	private static $initialized = false;
	private static $folder = "";
	
	public static function getId(){
	    return self::$id;
	}
	
	public static function set($key,$value){
	    self::init();
	    self::$data[$key] = $value;
	    self::write();
	}
	
	public static function get($key){
	    self::init();
		if(!array_key_exists($key, self::$data)){
			return null;
		}
		return self::$data[$key];
	}
	
	public static function getAll(){
	    self::init();
		return self::$data;
	}
	
	public static function add($key,$value){
	    self::init();
		if(!array_key_exists($key, self::$data)){
			self::$data[$key]= array();
		}
		self::$data[$key][] = $value;
		self::write();
	}
	
	public static function init(){
	    // não cria cookie para algumas extensões, se não o sistema cria
	    // uma sessão para cada request gerando sessões descontroladamente sem necessidade
	    if(StringUtils::endsWith($_SERVER["REQUEST_URI"],".js.php") OR StringUtils::endsWith($_SERVER["REQUEST_URI"],".css.php")){
	        return;
	    }
	    
	    if(self::$initialized){
	        return;
	    }
	    self::$folder = \zion\ROOT."tmp".\DS."session".DS;
	    if(!array_key_exists(self::$sessionKey,$_COOKIE) OR $_COOKIE[self::$sessionKey] == ""){
	        self::createSession();
	    }else{
	        // carregando sessão
	        self::$id = $_COOKIE[self::$sessionKey];
	        self::load();
	    }
	    
	    self::$initialized = true;
	}
	
	private static function getFile($id=null){
	    if($id !== null){
	        return self::$folder.$id.".session";
	    }
	    return self::$folder.self::$id.".session";
	}
	
	/**
	 * A chamada desse método na criação da sessão é obrigatório!
	 */
	private static function createSession($id = null){
		// criando sessão
	    if($id == null){
	       $id = md5(uniqid("server1"));
	    }
	    setcookie(self::$sessionKey,$id,time()+self::$expireTime,"/");
		self::$id = $id;
		self::$info = self::createInfo();
    }
    
    private static function createInfo(){
        $created = new DateTime();
        $expire  = new DateTime();
        $expire->modify("+".self::$expireTime." seconds");
        
        return array(
            "ipv4"      => $_SERVER["REMOTE_ADDR"],
            "userAgent" => $_SERVER["HTTP_USER_AGENT"],
            "expireTime" => self::$expireTime,
            "created"   => $created,
            "expire"    => $expire
        );
    }
    
    public static function getInfo(){
        return self::$info;
    }
	
	private static function load(){
		$file = self::getFile();
		if(file_exists($file)){
			$content = unserialize(file_get_contents($file));
			if(is_array($content)){
				self::$data = $content["data"];
				self::$info = $content["info"];
				$content = null;
				
				// verificações de segurança
				// apaga os dados de sessão se o IP mudou ou o navegador
				if(self::$info["ipv4"] != $_SERVER["REMOTE_ADDR"] || self::$info["userAgent"] != $_SERVER["HTTP_USER_AGENT"]){
				    self::log("Sessão inválida, IP (".self::$info["ipv4"]." <> ".$_SERVER["REMOTE_ADDR"].") 
                        ou navegador mudou (".self::$info["userAgent"]." <> ".$_SERVER["HTTP_USER_AGENT"].")!");
					self::createSession();
				}
			}else{
				// o arquivo existe mas seu conteúdo é inválido, deletando-o
				if(FileUtils::canDelete($file)){
					unlink($file);
				}
				self::createSession();
			}
			$content = null;
		}else{
			// o cookie existe mas o arquivo não. Nesse caso o info precisa ser inicializado!
		    self::$info = self::createInfo();
		}
		
		// verifica se a sessão expirou
		if(self::$info["expire"] < new DateTime()){
		    self::createSession();
		    self::$data = array();
		}
	}
	
	public static function renew(){
	    self::init();
	    self::createSession(self::$id);
	    self::write();
	}
	
	private static function log($message){
	    $f = fopen(\zion\ROOT."log".\DS."session.log","a+");
	    fwrite($f,date("d/m/Y H:i:s").": ".$message."\n");
	    fclose($f);
	}
	
	private static function write(){
	    $content = array(
			"data" => self::$data,
			"info" => self::$info
		);
		
		// verifica se há dados na sessão, se não tiver, não há necessidade de gravar um arquivo
		if(sizeof($content["data"]) <= 0){
			return;
		}
		
		if(sizeof($content["info"]) <= 0){
			throw new Exception("Erro ao gravar sessão, há data mas não info");
		}
		
		$file = self::getFile();
		$f = @fopen($file,"w");
		if($f !== false){
			fwrite($f,serialize($content));
			fclose($f);
		}
	}
	
	private static function clean(){
	    self::init();
		self::$data = array();
	}
	
	public static function destroy($id = null){
	    self::init();
	    
	    // apagando dados do disco
	    $file = self::getFile($id);
	    if(file_exists($file) AND FileUtils::canDelete($file)){
	        @unlink($file);
	    }
	    
	    if($id === null){
	        // apagando dados em memória (somente se a sessão for do próprio usuário)
	        self::$data = array();
	    }
	    
		// já chama a rotina para limpar sessões antigas
		self::cleanFilesSession();
	}
	
	public static function cleanFilesSession(){
    	$folder = \zion\ROOT."tmp".DS."session".DS;
    	$files = scandir($folder);
    	foreach($files AS $filename){
    		if($filename == "." || $filename == ".."){
    			continue;
    		}
    		
    		if(strpos($filename,".session") === false){
    		    continue;
    		}
    		
    		$file = $folder.$filename;
    		if (!file_exists($file)) {
    		    self::log("Sessão não encontrada ".$filename);
    		}
    		
    		$dateFile = new DateTime(date("Y-m-d H:i:s",filemtime($file)));
    		$secs = DateTimeUtils::getSecondsDiff(new DateTime(),$dateFile);
    		if($secs >= self::$expireTime){
    			// deleta sessões antigas
    		    self::log("Sessão expirada ".$filename);
    			unlink($file);
    		}
    	}
    }
}
?>