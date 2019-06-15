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
abstract class ModuleController extends AbstractEntityController {
	public function getFormBean() : ObjectVO {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "PUT"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$obj = new ObjectVO();
		if($_SERVER["REQUEST_METHOD"] == "GET"){
			// valores default
			$obj->set("created",new \DateTime());
			return $obj;
		}
		
		$obj->set("moduleid",TextFormatter::parse("string",$_POST["obj"]["moduleid"]));
		$obj->set("name",$_POST["obj"]["name"]);
		$obj->set("category",$_POST["obj"]["category"]);
		$obj->set("description",$_POST["obj"]["description"]);
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
		$filter->addFilterField("moduleid","string",$_POST["filter"]["moduleid"]);
		$filter->addFilterField("name","string",$_POST["filter"]["name"]);
		$filter->addFilterField("category","string",$_POST["filter"]["category"]);
		$filter->addFilterField("description","string",$_POST["filter"]["description"]);
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
		$keys = array();
		$keys["moduleid"] = TextFormatter::parse("string",$_GET["keys"]["moduleid"]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "moduleid";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("moduleid") === null){
			throw new Exception("Campo \"moduleid\" vazio");
		}
		if($obj->get("name") === null){
			throw new Exception("Campo \"name\" vazio");
		}
		if($obj->get("category") === null){
			throw new Exception("Campo \"category\" vazio");
		}
		if($obj->get("created") === null){
			throw new Exception("Campo \"created\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
	}
}
?>