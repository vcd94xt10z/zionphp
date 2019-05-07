<?php
namespace zion\mod\core\controller;

use Exception;
use zion\core\AbstractEntityController;
use zion\orm\PDO;
use zion\orm\Filter;
use zion\orm\ObjectVO;
use zion\core\System;
use zion\utils\TextFormatter;
use zion\utils\HTTPUtils;

/**
 * Classe gerada pelo Zion Framework em 07/05/2019
 * Não edite esta classe
 */
abstract class AbstractConfigController extends AbstractEntityController {
	public function getFormBean() : ObjectVO {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "PUT"){
			$_POST = HTTPUtils::parsePost();
		}
		$obj = new ObjectVO();
		$obj->set("mandt",TextFormatter::parse("integer",$_POST["obj"]["mandt"]));
		$obj->set("env",$_POST["obj"]["env"]);
		$obj->set("category",$_POST["obj"]["category"]);
		$obj->set("group",$_POST["obj"]["group"]);
		$obj->set("name",$_POST["obj"]["name"]);
		$obj->set("value",$_POST["obj"]["value"]);
		$obj->set("created",TextFormatter::parse("datetime",$_POST["obj"]["created"]));
		$obj->set("updated",TextFormatter::parse("datetime",$_POST["obj"]["updated"]));
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
		$filter->addFilterField("category","string",$_POST["filter"]["category"]);
		$filter->addFilterField("group","string",$_POST["filter"]["group"]);
		$filter->addFilterField("name","string",$_POST["filter"]["name"]);
		$filter->addFilterField("value","string",$_POST["filter"]["value"]);
		$filter->addFilterField("created","datetime",$_POST["filter"]["created"]);
		$filter->addFilterField("updated","datetime",$_POST["filter"]["updated"]);
		
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
		$parts = explode(":",$param);
		$keys = array();
		$keys["mandt"] = TextFormatter::parse("integer",$parts[0]);
		$keys["env"] = TextFormatter::parse("string",$parts[1]);
		$keys["category"] = TextFormatter::parse("string",$parts[2]);
		$keys["group"] = TextFormatter::parse("string",$parts[3]);
		$keys["name"] = TextFormatter::parse("string",$parts[4]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "mandt";
		$keys[] = "env";
		$keys[] = "category";
		$keys[] = "group";
		$keys[] = "name";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("mandt") === null){
			throw new Exception("Campo \"mandt\" vazio");
		}
		if($obj->get("env") === null){
			throw new Exception("Campo \"env\" vazio");
		}
		if($obj->get("category") === null){
			throw new Exception("Campo \"category\" vazio");
		}
		if($obj->get("group") === null){
			throw new Exception("Campo \"group\" vazio");
		}
		if($obj->get("name") === null){
			throw new Exception("Campo \"name\" vazio");
		}
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
		if($obj->get("category") === null){
			$obj->set("category",$dao->getNextId($db,"Config-category"));
		}
		if($obj->get("group") === null){
			$obj->set("group",$dao->getNextId($db,"Config-group"));
		}
		if($obj->get("name") === null){
			$obj->set("name",$dao->getNextId($db,"Config-name"));
		}
	}
}
?>