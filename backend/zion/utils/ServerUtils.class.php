<?php
namespace zion\util;

/**
 * @author Vinicius Cesar Dias
 */
class ServerUtils {
	public static function getSOName(){
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			return "Windows";
		}
		return "Linux";
	}
	
	public static function getServerInfo(){
		$so = self::getSOName();
		
		$info = array();
		$info["name"] = php_uname("s");
		$info["hostname"] = php_uname("n");
		$info["version"] = php_uname("r");
		$info["build"] = php_uname("v");
		$info["arch"] = php_uname("m");
		return $info;	
	}
	
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
			$concat = false;
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