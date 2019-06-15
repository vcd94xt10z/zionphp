<?php
namespace zion\mod\core\standard\controller;

use Exception;
use zion\core\AbstractEntityController;
use zion\orm\PDO;
use zion\orm\Filter;
use zion\orm\ObjectVO;
use zion\core\System;
use zion\utils\TextFormatter;
use zion\utils\HTTPUtils;

/**
 * Classe gerada pelo Zion Framework
 * Não edite esta classe
 */
abstract class ConfigController extends AbstractEntityController {
	public function getFormBean() : ObjectVO {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "PUT"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$obj = new ObjectVO();
		if($_SERVER["REQUEST_METHOD"] == "GET"){
			// valores default
			$obj->set("mandt",0);
			$obj->set("env","ALL");
			$obj->set("created",new \DateTime());
			$obj->set("sequence","0");
			return $obj;
		}
		
		$obj->set("mandt",abs(intval($_POST["obj"]["mandt"])));
		$obj->set("env",TextFormatter::parse("string",$_POST["obj"]["env"]));
		$obj->set("key",TextFormatter::parse("string",$_POST["obj"]["key"]));
		$obj->set("name",TextFormatter::parse("string",$_POST["obj"]["name"]));
		$obj->set("value",$_POST["obj"]["value"]);
		$obj->set("created",TextFormatter::parse("datetime",$_POST["obj"]["created"]));
		$obj->set("updated",TextFormatter::parse("datetime",$_POST["obj"]["updated"]));
		$obj->set("sequence",TextFormatter::parse("integer",$_POST["obj"]["sequence"]));
		return $obj;
	}

	public function getFilterBean() : Filter {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "FILTER"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$filter = new Filter();
		$filter->addFilterField("mandt","integer",$_POST["filter"]["mandt"]);
		$filter->addFilterField("env","string",$_POST["filter"]["env"]);
		$filter->addFilterField("key","string",$_POST["filter"]["key"]);
		$filter->addFilterField("name","string",$_POST["filter"]["name"]);
		$filter->addFilterField("value","string",$_POST["filter"]["value"]);
		$filter->addFilterField("created","datetime",$_POST["filter"]["created"]);
		$filter->addFilterField("updated","datetime",$_POST["filter"]["updated"]);
		$filter->addFilterField("sequence","integer",$_POST["filter"]["sequence"]);
		
		// ordenação
		$filter->addSort($_POST["order"]["field"],$_POST["order"]["type"]);
		
		// limite
		$filter->setLimit(intval($_POST["limit"]));
		
		// offset
		$filter->setOffset(intval($_POST["offset"]));
		
		return $filter;
	}

	public function getKeysBean(): array {
		$keys = array();
		$keys["mandt"] = TextFormatter::parse("integer",$_GET["keys"]["mandt"]);
		$keys["env"] = TextFormatter::parse("string",$_GET["keys"]["env"]);
		$keys["key"] = TextFormatter::parse("string",$_GET["keys"]["key"]);
		$keys["name"] = TextFormatter::parse("string",$_GET["keys"]["name"]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "mandt";
		$keys[] = "env";
		$keys[] = "key";
		$keys[] = "name";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("env") === null){
			throw new Exception("Campo \"env\" vazio");
		}
		if($obj->get("key") === null){
			throw new Exception("Campo \"key\" vazio");
		}
		if($obj->get("name") === null){
			throw new Exception("Campo \"name\" vazio");
		}
		if($obj->get("created") === null){
			throw new Exception("Campo \"created\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
	}
}
?>