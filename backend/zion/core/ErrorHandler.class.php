<?php
namespace zion\core;

use Exception;
use zion\orm\ObjectVO;
use zion\utils\TextFormatter;
use zion\utils\HTTPUtils;

/**
 * @author Vinicius
 */
class ErrorHandler {
    /**
     * Todas as exceções serão redirecionadas para este método
     * @param Exception $e
     */
    public static function handleException($e){
        self::logException($e);
        HTTPUtils::status(500);
        HTTPUtils::sendHeadersNoCache();
        $message = "";
        
        if (\zion\ENV == "PRD") {
            $message .= "Sistema indisponível no momento, já registramos o problema e estaremos corrigindo assim que possível.\n"; 
            $message .= "Você pode atualizar a página ou tentar mais tarde.\n";
            $message .= "Se o problema persistir, contate o administrador.\n";
        }else{
            $message = $e->getFile()." on ".$e->getLine()." [".get_class($e)."]: ".$e->getMessage();
        }
        
        HTTPUtils::template(500,$message);
        exit();
    }
    
	/**
	 * Todos os erros serão redirecionados para este método
	 */
	public static function handleError($errno, $errstr, $errfile, $errline){
		$type_str = "";
		switch($errno){
			case 1: $type_str = 'ERROR'; break;
			case 2: $type_str = 'WARNING'; break;
			case 4: $type_str = 'PARSE'; break;
			case 8: $type_str = 'NOTICE'; break;
			case 16: $type_str = 'CORE_ERROR'; break;
			case 32: $type_str = 'CORE_WARNING'; break;
			case 64: $type_str = 'COMPILE_ERROR'; break;
			case 128: $type_str = 'COMPILE_WARNING'; break;
			case 256: $type_str = 'USER_ERROR'; break;
			case 512: $type_str = 'USER_WARNING'; break;
			case 1024: $type_str = 'USER_NOTICE'; break;
			case 2048: $type_str = 'STRICT'; break;
			case 4096: $type_str = 'RECOVERABLE_ERROR'; break;
			case 8192: $type_str = 'DEPRECATED'; break;
			case 16384: $type_str = 'USER_DEPRECATED'; break;
		}

		// se for NOTICE, nem faz log e nem exibe mensagem para o usuário
		if($type_str == "NOTICE"){
			return true;
		}
		
		$begin = floatval($_SERVER["REQUEST_TIME"]);
		$end   = microtime(true);
		
		$data = array();
		$data["type"]        = "php-error";
		$data["created"]     = new \DateTime();
		$data["duration"]    = round($end - $begin,2);
		$data["http_ipaddr"] = $_SERVER["REMOTE_ADDR"];
		$data["http_method"] = $_SERVER["REQUEST_METHOD"];
		$data["http_uri"]    = $_SERVER["REQUEST_URI"];
		$data["level"]       = $type_str;
		$data["code"]        = $errno;
		$data["message"]     = $errstr;
		$data["file"]        = $errfile;
		$data["line"]        = $errline;
		$data["stack"]       = "";
		$data["input"]       = "";
		self::sendToLog($data);
		
		// warning só vai para o log, a execução deve continuar normalmente
		if($type_str == "WARNING"){
			//return true; // desativado
		}
		
		HTTPUtils::status(500);
		HTTPUtils::sendHeadersNoCache();
		HTTPUtils::template(500,$errstr);
		
		// colocando exit porque senão o php pode continuar executando a página
		// depois do erro (tipo um warning) e passando novamente neste método
		// replicando a página de erro para o usuário.
		exit();

		// http://php.net/manual/pt_BR/function.set-error-handler.php
		/* Don't execute PHP internal error handler */
		return true;
	}

	/**
	 * Exibe uma exceção de uma forma amigável
	 * @param Exception $e
	 */
	public static function showErrorException(\Throwable $e){
	    $code = file($e->getFile(),FILE_IGNORE_NEW_LINES);
	    $buffer = "";
	    $i=1;

	    $beginLine = max($e->getLine()-4,0);
	    $finalLine = min($e->getLine()+4,sizeof($code));

	    foreach($code AS $line){
	        if($i >= $beginLine AND $i <= $finalLine){
	            $number = str_pad($i, 2,"0",STR_PAD_LEFT);

	            if($e->getLine() == $i){
	                $buffer .= $number." <span style='color: #f00'>".$line."</span>\n";
	            }else{
	                $buffer .= $number." ".$line."\n";
	            }
	        }
	        $i++;
	    }

	    echo "<h1 style='font-family: Arial !important;'>".$e->getMessage()."</h1>";
	    echo "<hr>";
	    echo "<pre style='font-family: Arial !important;font-size:12px !important'><code>".$buffer."</code></pre>";
	    echo "<hr>";
	    echo "<div>".$e->getFile()." [".$e->getLine()."]</div>";
	}

	public static function importLogToDatabase(){
	    $folder = \zion\ROOT."log".\DS;
	    $files = scandir($folder);
	    
	    foreach($files AS $filename){
	        if(strpos($filename,"error_log") !== 0){
	            continue;
	        }
	        
	        $file = $folder.$filename;
	        $f = fopen($file, "r");
	        if($f === false){
	            continue;
	        }
	        
	        $db = System::getConnection();
	        $dao = System::getDAO($db,"zion_error_log");
	        
	        while (true){
	            $row = fgetcsv($f, 1000, ",");
	            if($row === null OR $row === false){
	                break;
	            }
	            
                $obj = new ObjectVO();
                $obj->set("errorid",$dao->getNextId($db, "error_log"));
                $obj->set("type",$row[0]);
                $obj->set("created",TextFormatter::parseDate($row[1]));
                $obj->set("duration",$row[2]);
                $obj->set("http_ipaddr",$row[3]);
                $obj->set("http_method",$row[4]);
                $obj->set("http_uri",$row[5]);
                $obj->set("level",substr($row[6],0,5));
                $obj->set("code",$row[7]);
                $obj->set("message",$row[8]);
                $obj->set("stack",$row[9]);
                $obj->set("input",$row[10]);
                $obj->set("file",$row[11]);
                $obj->set("line",$row[12]);
                $obj->set("status","P");
                
                try {
                    $dao->insert($db, $obj);
                }catch(Exception $e){
                    echo $e->getMessage();
                }
            }
            fclose($f);
            
            @unlink($file);
            
            $db = null;
	    }
	    
	    $db = null;
	}
	
	public static function sendToLog(array $data){
	    $fields = explode(",","type,created,duration,http_ipaddr,http_method,http_uri,level,code,message,stack,input,file,line");
	    
	    $csv = array();
	    foreach($fields AS $field){
	        $value = $data[$field];
	        
	        if($field == "created"){
	            $value = TextFormatter::format("datetime", $value);
	        }
	        
	        if(in_array($field,array("duration","line"))){
	            $csv[] = intval($value);
	        }else{
	            $csv[] = "\"".addslashes($value)."\"";
	        }
	    }
	    
	    // log
	    $file = \zion\ROOT."log".\DS."error_log-".date("Ymd-H").".csv";
	    $f = fopen($file,"a+");
	    if($f !== false){
	        fwrite($f,implode(",",$csv)."\n");
	        fclose($f);
	    }
	}
	
	/**
	 * Grava log de erro
	 * @param $e
	 */
	public static function logException($e){
	    $begin = floatval($_SERVER["REQUEST_TIME"]);
	    $end   = microtime(true);
	    
	    $data = array();
	    $data["type"]        = "php-exception";
	    $data["created"]     = new \DateTime();
	    $data["duration"]    = round($end - $begin,2);
	    $data["http_ipaddr"] = $_SERVER["REMOTE_ADDR"];
	    $data["http_method"] = $_SERVER["REQUEST_METHOD"];
	    $data["http_uri"]    = $_SERVER["REQUEST_URI"];
	    $data["level"]       = "";
	    $data["code"]        = "";
	    $data["message"]     = "";
	    $data["file"]        = "";
	    $data["line"]        = "";
	    $data["stack"]       = "";
	    $data["input"]       = "";
	    
	    if($e != null){
	        $data["code"]    = $e->getCode();
	        $data["message"] = $e->getMessage();
	        $data["file"]    = $e->getFile();
	        $data["line"]    = $e->getLine();
	        $data["stack"]   = $e->getTraceAsString();
	    }
	    
	    if($e instanceof \PDOException){
	        $data["type"] = "pdo";
	        $data["input"] = System::get("pdo-lastsql");
	    }
	    
	    self::sendToLog($data);
	}
}
?>