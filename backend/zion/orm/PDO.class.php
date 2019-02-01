<?php
namespace zion\orm;

use zion\core\Session;
use zion\core\System;
use zion\utils\TimeCounter;

/**
 * @author Vinicius Cesar Dias
 */
class PDO extends \PDO {
    public static $enableSQLHistory = false;
    public static $enableSQLLog = false;
    public static $sqlHistory = array();
    
	public function query($sql){
		$e = null;
		$errorMessage = "";
		$result = false;
		
		if(self::$enableSQLHistory){
		    System::add("pdo-query",$sql);
		}
		
		TimeCounter::start("query");
		try {
		    if(self::$enableSQLHistory){
		        self::$sqlHistory[] = $sql;
		    }
		    
		    if(self::$enableSQLLog){
		        $this->sendToLog(null, $sql);
		    }
		    
			$result = parent::query($sql);
		}catch(\Exception $e){
		    $this->sendToLog($e,$sql);
		    $errorMessage = $e->getMessage();
		}
		TimeCounter::stop("query");
		
		if(Session::get("trace") == 1){
			Session::add("traceSQL",array(
				"sql"       => $sql,
				"errorMessage" => $errorMessage,
				"type"      => "query",
				"result"    => ($result !== false)?1:0,
				"created"   => TimeCounter::begin("query"),
				"duration"  => TimeCounter::duration("query")
			));
		}

		if($e != null){
			throw $e;
		}

		return $result;
	}

	public function exec($sql){
		$e = null;
		$errorMessage = "";
		$result = false;
		
		if(self::$enableSQLHistory){
		    System::add("pdo-exec",$sql);
		}
		
		TimeCounter::start("exec");
		try {
		    if(self::$enableSQLHistory){
		        self::$sqlHistory[] = $sql;
		    }
		    
		    if(self::$enableSQLLog){
		        $this->sendToLog(null, $sql);
		    }
		    
			$result = parent::exec($sql);
		}catch(\Exception $e){
			$errorMessage = $e->getMessage();
		}
		TimeCounter::stop("exec");

		if(Session::get("trace") == 1){
			Session::add("traceSQL",array(
				"sql"       => $sql,
				"errorMessage" => $errorMessage,
				"type"      => "update",
				"result"    => ($result !== false)?1:0,
				"created"   => TimeCounter::begin("exec"),
				"duration"  => TimeCounter::duration("exec")
			));
		}

		if($e != null){
			throw $e;
		}

		return $result;
	}
	
	public function commit(){
		$this->exec("COMMIT");
	}
	
	public function rollback(){
		$this->exec("ROLLBACK");		
	}
	
	public function startTransaction(){
		$this->exec("BEGIN");
	}
	
	public function sendToLog($e,string $sql){
	    $begin = floatval($_SERVER["REQUEST_TIME"]);
	    $end = microtime(true);
	    $durationSec = round($end - $begin,2)."s";
	    
	    $content  = "Date: ".date("d/m/Y H:i:s")." ".System::get("timezone")."\n";
	    $content .= "URI: ".$_SERVER["REQUEST_URI"]."\n";
	    if(array_key_exists("HTTP_REFERER",$_SERVER) && $_SERVER["HTTP_REFERER"] != ""){
	        $content .= "Referer: ".$_SERVER["HTTP_REFERER"]."\n";
	    }
	    $content .= "UserAgent: ".$_SERVER["HTTP_USER_AGENT"]."\n";
	    $content .= "Client: ".$_SERVER["REMOTE_ADDR"].":".$_SERVER["REMOTE_PORT"]."\n";
	    $content .= "Server: ".$_SERVER["SERVER_NAME"]." (".$_SERVER["SERVER_ADDR"].":".$_SERVER["SERVER_PORT"].")\n";
	    $content .= "Duration: ".$durationSec."\n";
	    $content .= "SQL: ".$sql."\n";
	    
	    if($e != null){
	        $content .= "Exception: ".$e->getMessage()." | Code ".$e->getCode()."\n";
	        $content .= "File: ".$e->getFile()." on line ".$e->getLine()."\n";
	        $content .= "Trace\n";
	        $content .= $e->getTraceAsString()."\n";
	    }
	    
	    // arquivo
	    $file = \zion\ROOT."log".\DS."pdo-error.log";
	    $f = fopen($file,"a+");
	    if($f === false){
	        return;
	    }
	    fwrite($f,$content);
	    fclose($f);
	}
}
?>