<?php
namespace zion\mod\error\controller;

use Exception;
use zion\core\AbstractEntityController;
use zion\orm\PDO;
use zion\orm\Filter;
use zion\orm\ObjectVO;
use zion\core\System;
use zion\utils\TextFormatter;
use zion\utils\HTTPUtils;

/**
 * Classe gerada pelo Zion Framework em 22/02/2019
 * Não edite esta classe
 */
abstract class AbstractErrorLogController extends AbstractEntityController {
	public function getFormBean() : ObjectVO {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "PUT"){
			$_POST = HTTPUtils::parsePost();
		}
		$obj = new ObjectVO();
		$obj->set("errorid",$_POST["obj"]["errorid"]);
		$obj->set("type",$_POST["obj"]["type"]);
		$obj->set("created",TextFormatter::parse("datetime",$_POST["obj"]["created"]));
		$obj->set("duration",TextFormatter::parse("integer",$_POST["obj"]["duration"]));
		$obj->set("http_ipaddr",$_POST["obj"]["http_ipaddr"]);
		$obj->set("http_method",$_POST["obj"]["http_method"]);
		$obj->set("http_uri",$_POST["obj"]["http_uri"]);
		$obj->set("level",$_POST["obj"]["level"]);
		$obj->set("code",$_POST["obj"]["code"]);
		$obj->set("message",$_POST["obj"]["message"]);
		$obj->set("stack",$_POST["obj"]["stack"]);
		$obj->set("input",$_POST["obj"]["input"]);
		$obj->set("file",$_POST["obj"]["file"]);
		$obj->set("line",TextFormatter::parse("integer",$_POST["obj"]["line"]));
		return $obj;
	}

	public function getFilterBean() : Filter {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "FILTER"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$filter = new Filter();
		$filter->addFilterField("errorid","string",$_POST["filter"]["errorid"]);
		$filter->addFilterField("type","string",$_POST["filter"]["type"]);
		$filter->addFilterField("created","datetime",$_POST["filter"]["created"]);
		$filter->addFilterField("duration","integer",$_POST["filter"]["duration"]);
		$filter->addFilterField("http_ipaddr","string",$_POST["filter"]["http_ipaddr"]);
		$filter->addFilterField("http_method","string",$_POST["filter"]["http_method"]);
		$filter->addFilterField("http_uri","string",$_POST["filter"]["http_uri"]);
		$filter->addFilterField("level","string",$_POST["filter"]["level"]);
		$filter->addFilterField("code","string",$_POST["filter"]["code"]);
		$filter->addFilterField("message","string",$_POST["filter"]["message"]);
		$filter->addFilterField("stack","string",$_POST["filter"]["stack"]);
		$filter->addFilterField("input","string",$_POST["filter"]["input"]);
		$filter->addFilterField("file","string",$_POST["filter"]["file"]);
		$filter->addFilterField("line","integer",$_POST["filter"]["line"]);
		
		// ordenação
		$filter->addSort($_POST["order"]["field"],$_POST["order"]["type"]);
		
		// limite
		$filter->setLimit(intval($_POST["limit"]));
		
		// offset
		$filter->setOffset(intval($_POST["offset"]));
		
		return $filter;
	}

	public function getKeysBean(): array {
		$param = $this->getURIParam(1);
		$parts = explode("|",$param);
		$keys = array();
		$keys["errorid"] = TextFormatter::parse("string",$parts[0]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "errorid";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("errorid") === null){
			throw new Exception("Campo \"errorid\" vazio");
		}
		if($obj->get("type") === null){
			throw new Exception("Campo \"type\" vazio");
		}
		if($obj->get("created") === null){
			throw new Exception("Campo \"created\" vazio");
		}
		if($obj->get("duration") === null){
			throw new Exception("Campo \"duration\" vazio");
		}
		if($obj->get("http_ipaddr") === null){
			throw new Exception("Campo \"http_ipaddr\" vazio");
		}
		if($obj->get("http_method") === null){
			throw new Exception("Campo \"http_method\" vazio");
		}
		if($obj->get("http_uri") === null){
			throw new Exception("Campo \"http_uri\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
		$dao = System::getDAO();
		if($obj->get("errorid") === 0){
			$obj->set("errorid",$dao->getNextId($db,"ErrorLog-errorid"));
		}
	}
}
?>