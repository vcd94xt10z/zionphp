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
		$obj->set("mandt",TextFormatter::parse("integer",$_POST["obj"]["mandt"],true));
		$obj->set("env",TextFormatter::parse("string",$_POST["obj"]["env"],true));
		$obj->set("key",TextFormatter::parse("string",$_POST["obj"]["key"],true));
		$obj->set("name",TextFormatter::parse("string",$_POST["obj"]["name"],true));
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
		$parts = $this->getPrimaryKeyFromURI();
		$keys = array();
		$keys["mandt"] = TextFormatter::parse("integer",$parts[0]);
		$keys["env"] = TextFormatter::parse("string",$parts[1]);
		$keys["key"] = TextFormatter::parse("string",$parts[2]);
		$keys["name"] = TextFormatter::parse("string",$parts[3]);
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
		if($obj->get("created") === null){
			throw new Exception("Campo \"created\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
		$dao = System::getDAO();
		if($obj->get("mandt") === null){
			$obj->set("mandt",$dao->getNextId($db,"Config-mandt"));
		}
		if($obj->get("env") === null){
			$obj->set("env",$dao->getNextId($db,"Config-env"));
		}
		if($obj->get("key") === null){
			$obj->set("key",$dao->getNextId($db,"Config-key"));
		}
		if($obj->get("name") === null){
			$obj->set("name",$dao->getNextId($db,"Config-name"));
		}
	}
}
?>