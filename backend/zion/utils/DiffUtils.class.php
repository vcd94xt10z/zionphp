<?php
namespace zion\utils;

use Exception;
use StdClass;
use zion\core\System;

/**
 * @author Vinicius
 */
class DiffUtils {
    /**
     * Envia os objetos do servidor atual para o cliente
     */
    public static function sendObjectList(){
        try {
            // input
            $type = $_GET["type"];
            $objectList = array();
            
            // process
            switch($type){
            case "file":
                DiffUtils::getFileList($objectList);
                break;
            case "db":
                DiffUtils::getDBObjectList($objectList);
                break;
            default:
                throw new Exception("Tipo inválido");
                break;
            }
            
            // output
            HTTPUtils::status(200);
            HTTPUtils::sendCacheHeaders(0, 0);
            header("Content-Type: text/plain");
            header('Content-Disposition: inline; filename="'.$_SERVER["SERVER_NAME"].'.txt"');
            
            foreach($objectList AS $obj){
                echo $obj["type"].";".$obj["md5"].";".$obj["modification"].";".$obj["name"].";".$obj["size"]."\n";
            }
        }catch(Exception $e){
            HTTPUtils::status(500);
            HTTPUtils::sendCacheHeaders(0, 0);
            echo $e->getMessage();
        }
        exit();
    }
    
    /**
     * Compara objetos de duas URLs diferentes
     * @param string $link1
     * @param string $link2
     * @throws Exception
     * @return array[]|number[]|mixed
     */
    public static function compare($link1,$link2){
        $linkList = array($link1,$link2);
        
        $db = System::getConnection();
        $tables = array();
        $TEMPORARY = " TEMPORARY";
        //$TEMPORARY = "";
        
        for($i=0;$i<sizeof($linkList);$i++){
            $link = $linkList[$i];
            $table = "diff_compare_obj".($i+1)."_".date("YmdHis")."_".rand(1000,9999);
            $tables[$i] = $table;
            
            // criando tabela
            $sql = "CREATE{$TEMPORARY} TABLE `".$table."` (
                      `type` varchar(20) NOT NULL,
					  `md5` varchar(32) NOT NULL,
					  `name` varchar(400) NOT NULL,
					  `size` int(11) unsigned DEFAULT NULL,
					  `modification` datetime DEFAULT NULL,
					  PRIMARY KEY (`md5`,`name`) USING BTREE,
					  KEY `Index_".$i."` (`name`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
            $db->exec($sql);
            
            // download do arquivo
            $curlInfo = null;
            $files = HTTPUtils::curl($link,null,null,null,$curlInfo);
            if($curlInfo["http_code"] != 200){
                throw new Exception("GET ".$link." ".$curlInfo["http_code"]);
            }
            
            if($files == ""){
                throw new Exception("Nenhum arquivo encontrado no link ".$link);
            }
            
            $files = explode("\n",$files);
            if(empty($files)){
                throw new Exception("Nenhuma linha encontrada no link ".$link);
            }
            
            // inserindo conteúdo do arquivo
            foreach($files AS $file){
                if($file == ""){
                    continue;
                }
                
                $part = explode(";",$file);
                $ftype = $part[0];
                $fmd5 = substr($part[1],0,32);
                $fmodification = substr($part[2],0,19);
                $fname = substr($part[3],0,400);
                $fsize = $part[4];
                
                if($fmd5 == "" || $fname == ""){
                    continue;
                }
                
                $format = "Y-m-d H:i:s";
                $fmodification = DateTimeUtils::parseDate($fmodification, $format);
                if($fmodification == null){
                    $fmodification = "null";
                }else{
                    $fmodification = "'".$fmodification->format($format)."'";
                }
                
                $sql = "INSERT INTO `".$table."`
					   (`type`,`md5`,`name`,`size`,`modification`)
					   VALUES
					   ('".addslashes($ftype)."','".addslashes($fmd5)."','".addslashes($fname)."',".intval($fsize).",".$fmodification.");";
                $db->exec($sql);
            }
            
            // liberando recursos
            $files = null;
        }
        
        // comparando arquivos
        $output = array();
        $env1Table = $tables[0];
        $env2Table = $tables[1];
        
        // consultando arquivos que tem no env1 e não tem no env2
        $sql = "SELECT * FROM `".$env1Table."` AS env1
				WHERE env1.name
				NOT IN (
				   SELECT env2.name
				   FROM `".$env2Table."` AS env2
				)
				ORDER BY env1.name ASC";
        $query = $db->query($sql);
        $output["env1_only"] = array();
        while($raw = $query->fetchObject()){
            $output["env1_only"][] = $raw;
        }
        
        // consultando arquivos que tem no env1 e no env1, mas são diferentes
        $sql = "SELECT env1.md5 AS md5_env1,env2.md5 AS md5_env2, env1.type, env1.name
				FROM ".$env1Table." AS env1
				INNER JOIN ".$env2Table." AS env2 ON env2.name = env1.name AND env1.md5 <> env2.md5
				ORDER BY env1.name ASC";
        $query = $db->query($sql);
        $output["diff"] = array();
        while($raw = $query->fetchObject()){
            $output["diff"][] = $raw;
        }
        
        // consultando arquivos que tem no env2, mas não tem no env1
        $sql = "SELECT * FROM ".$env2Table." AS env2
				WHERE env2.name
				NOT IN (
				   SELECT env1.name
				   FROM ".$env1Table." AS env1
				)
				ORDER BY env2.name ASC";
        $query = $db->query($sql);
        $output["env2_only"] = array();
        while($raw = $query->fetchObject()){
            $output["env2_only"][] = $raw;
        }
        
        // consultando total de arquivos de cada ambiente
        $sql = "SELECT
				(SELECT count(*) FROM ".$env2Table.") AS env2,
				(SELECT count(*) FROM ".$env1Table.") AS env1";
        $query = $db->query($sql);
        $total = new StdClass();
        $total->env1 = 0;
        $total->env2 = 0;
        if($raw = $query->fetchObject()){
            $total->env1 = $raw->env1;
            $total->env2 = $raw->env2;
        }
        
        // verificando percentual de diferença entre os ambientes
        if($total->env2 != 0){
            $output["sync"] = round(floor(($total->env1*100)/$total->env2),2);
        }
        $db = null;
        
        return $output;
    }
    
    /**
     * Retorna uma lista de arquivos e diretórios
     * @param array $objectList
     */
    public static function getFileList(array &$objectList){
        $rootFolder = \zion\APP_ROOT;
        $allFiles = [];
        $ignoreFiles = [
            ".svn"
        ];
        $ignoreFilesAbs = [
            $rootFolder.".git",
            $rootFolder.".svn",
            $rootFolder.".settings",
            $rootFolder.".buildpath",
            $rootFolder.".project",
            $rootFolder."artifacts",
            $rootFolder."log",
            $rootFolder."tmp",
            $rootFolder."id_rsa.pub",
            $rootFolder."id_rsa.pub.pub"
        ];
        FileUtils::listFilesRecursively($rootFolder,$allFiles,$ignoreFiles,$ignoreFilesAbs);
        
        // saída
        foreach ($allFiles AS $file) {
            $file2 = str_replace($rootFolder,"/",$file);
            $file2 = str_replace(\DS,"/",$file2);
            
            $md5 = "00000000000000000000000000000000";
            if (is_file($file) AND is_readable($file)) {
                $md5 = @md5_file($file);
            }
            
            $modification = date("Y-m-d H:i:s", filectime($file));
            $objectList[] = [
                "type" => "file",
                "md5"  => $md5,
                "modification" => $modification,
                "name" => $file2,
                "size" => filesize($file)
            ];
        }
    }
    
    /**
     * Retorna uma lista de objetos do banco
     * @param array $objectList
     */
    public static function getDBObjectList(array &$objectList){
        $db = System::getConnection();
        $objectList2 = array();
        $obj = null;
        
        // tabelas
        $sql = "SHOW TABLES";
        $query = $db->query($sql);
        while($raw = $query->fetch(\PDO::FETCH_NUM)){
            $objectList2[] = array(
                "type" => "db_table",
                "md5"  => "",
                "modification" => "",
                "name" => $raw[0],
                "size" => 0
            );
        }
        
        unset($obj);
        foreach($objectList2 AS &$obj){
            if($obj["type"] == "db_table"){
                $data = "";
                
                // dados gerais da tabela
                $sql = "show table status LIKE '".$obj["name"]."'";
                $query = $db->query($sql);
                if($raw = $query->fetchObject()){
                    $data .= $raw->Engine;
                }
                
                // colunas da tabela
                $sql = "show columns from `".$obj["name"]."`";
                $query = $db->query($sql);
                while($raw = $query->fetchObject()){
                    $data .= $raw->Field."-".$raw->Type."-".$raw->Null."-".$raw->Default."-".$raw->Extra."-";
                }
                
                $obj["md5"] = md5($data);
            }
        }
        unset($obj);
        $db = null;
        
        $objectList = array_merge($objectList,$objectList2);
    }
}
?>