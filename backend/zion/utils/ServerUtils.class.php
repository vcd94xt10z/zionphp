<?php
namespace zion\utils;

/**
 * @author Vinicius Cesar Dias
 */
class ServerUtils {
    /**
     * Retorna o sistema operacional atual 
     * @return string
     */
	public static function getSOName(){
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			return "Windows";
		}
		return "Linux";
	}
	
	/**
	 * Retorna informações do servidor
	 * @return string[]
	 */
	public static function getServerInfo(){
		$so = self::getSOName();
		
		$info = array();
		$info["name"] = php_uname("s");
		$info["hostname"] = php_uname("n");
		$info["version"] = php_uname("r");
		$info["build"] = php_uname("v");
		$info["arch"] = php_uname("m");
		$info["so"] = $so;
		return $info;	
	}
	
	/**
	 * Obtem informações de memória RAM
	 * Referência http://www.linuxatemyram.com/
	 */
	public static function getMemoryInfo(){
	    $data = explode("\n", file_get_contents("/proc/meminfo"));
	    $meminfo = array();
	    foreach ($data as $line) {
	        list($key, $val) = explode(":", $line);
	        $meminfo[$key] = trim($val);
	    }
	    
	    $data = [];
	    
	    $unitFactor = 1;
	    $sample = strtolower($meminfo["MemTotal"]);
	    if(strpos($sample,"kb") !== false){
	        $unitFactor = 1024;
	    }
	    if(strpos($sample,"mb") !== false){
	        $unitFactor = 1024 * 1024;
	    }
	    if(strpos($sample,"gb") !== false){
	        $unitFactor = 1024 * 1024 * 1024;
	    }
	    
	    $data["total"] = intval(preg_replace("[^0-9]","",$meminfo["MemTotal"]));
	    $data["free"]  = intval(preg_replace("[^0-9]","",$meminfo["MemFree"]));
	    $data["avial"] = intval(preg_replace("[^0-9]","",$meminfo["MemAvailable"]));
	    $data["used"]  = $data["total"] - $data["free"];
	    $data["usep"]  = ($data["used"] * 100) / $data["total"];
	    
	    // convertendo para a escala
	    $data["total"] *= $unitFactor;
	    $data["free"] *= $unitFactor;
	    $data["avial"] *= $unitFactor;
	    $data["used"] *= $unitFactor;
	    
	    // convertendo para megabytes
	    $data["total"] /= 1024 * 1024;
	    $data["free"]  /= 1024 * 1024;
	    $data["avial"] /= 1024 * 1024;
	    $data["used"]  /= 1024 * 1024;
	    
	    return $data;
	}
	
	public static function getDiskInfo(){
	    $commandLine = "df -kP | awk ' {print $1 \",\" $2 \",\" $3 \",\" $4 \",\" $5 \",\" $6} '";
	    $output = shell_exec($commandLine);
	    $lineArray = explode("\n",$output);
	    
	    $info = array();
	    for($i=0;$i<sizeof($lineArray);$i++){
	        if($i == 0){
	            continue;
	        }
	        $line = trim($lineArray[$i]);
	        
	        if($line == ""){
	            continue;
	        }
	        
	        $fieldList = explode(",",$line);
	        
	        // convertendo para megabytes
	        $data = [];
	        $data["path"]  = $fieldList[0];
	        $data["total"] = round(intval($fieldList[1])/1024,2);
	        $data["used"]  = round(intval($fieldList[2])/1024,2);
	        $data["avail"] = round(intval($fieldList[3])/1024,2);
	        $data["usep"]  = round(($data["used"] * 100) / $data["total"],2);
	        
	        // indexando por destino do compartilhamento para não duplicar
	        $info[$data["path"]] = $data;
	    }
	    
	    $info = array_values($info);
	    
	    return $info;
	}
	
	/**
	 * Retorna informações de CPUs
	 * @return array
	 */
	public static function getCPUInfo(){
		$soname = self::getSOName();
		if($soname == "Windows"){
			$data = array();
			$data['core']  = array();
			$wmi           = new \COM("winmgmts:\\");
			$cpu_cores     = $wmi->execquery("SELECT PercentProcessorTime FROM Win32_PerfFormattedData_PerfOS_Processor");
			
			foreach ($cpu_cores as $core) {
				$data['core'][] = array(
					"usage" => $core->PercentProcessorTime
				);
			}
			return $data;
		}
		
		if($soname == "Linux"){
			$output = shell_exec("cat /proc/cpuinfo | grep -iE \"model name|cpu MHz|processor\"");
			$output = explode("\n",$output);
			
			$cpuList = array();
			$coreId = 0;
			
			foreach($output AS $line){
				$tmp = explode(":",$line);
				$field = strtolower(trim($tmp[0]));
				$value = trim($tmp[1]);
				
				if($field == "processor"){
					$coreId = intval($value);
					continue;
				}
				
				// pulando informações em branco
				if($field == ""){
					continue;
				}
				
				// trocando nomes
				switch($field){
					case "model name":
						$field = "Modelo";
						break;
					case "cpu mhz":
						$field = "Clock";
						break;
				}
				
				$cpuList[$coreId][$field] = $value;
			}
			
			return $cpuList;
		}
	}
}
?>