<?php
namespace zion\mod\builder\standard\controller;

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
abstract class TextController extends AbstractEntityController {
	public function getFormBean() : ObjectVO {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "PUT"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$obj = new ObjectVO();
		if($_SERVER["REQUEST_METHOD"] == "GET"){
			// valores default
			$obj->set("mandt",0);
			$obj->set("lang","pt-BR");
			return $obj;
		}
		
		$obj->set("mandt",abs(intval($_POST["obj"]["mandt"])));
		$obj->set("lang",TextFormatter::parse("string",$_POST["obj"]["lang"]));
		$obj->set("moduleid",TextFormatter::parse("string",$_POST["obj"]["moduleid"]));
		$obj->set("entityid",TextFormatter::parse("string",$_POST["obj"]["entityid"]));
		$obj->set("field",TextFormatter::parse("string",$_POST["obj"]["field"]));
		$obj->set("text",$_POST["obj"]["text"]);
		return $obj;
	}

	public function getFilterBean() : Filter {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "FILTER"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$filter = new Filter();
		$filter->addFilterField("mandt","integer",$_POST["filter"]["mandt"]);
		$filter->addFilterField("lang","string",$_POST["filter"]["lang"]);
		$filter->addFilterField("moduleid","string",$_POST["filter"]["moduleid"]);
		$filter->addFilterField("entityid","string",$_POST["filter"]["entityid"]);
		$filter->addFilterField("field","string",$_POST["filter"]["field"]);
		$filter->addFilterField("text","string",$_POST["filter"]["text"]);
		
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
		$keys["lang"] = TextFormatter::parse("string",$_GET["keys"]["lang"]);
		$keys["moduleid"] = TextFormatter::parse("string",$_GET["keys"]["moduleid"]);
		$keys["entityid"] = TextFormatter::parse("string",$_GET["keys"]["entityid"]);
		$keys["field"] = TextFormatter::parse("string",$_GET["keys"]["field"]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "mandt";
		$keys[] = "lang";
		$keys[] = "moduleid";
		$keys[] = "entityid";
		$keys[] = "field";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("lang") === null){
			throw new Exception("Campo \"lang\" vazio");
		}
		if($obj->get("moduleid") === null){
			throw new Exception("Campo \"moduleid\" vazio");
		}
		if($obj->get("entityid") === null){
			throw new Exception("Campo \"entityid\" vazio");
		}
		if($obj->get("field") === null){
			throw new Exception("Campo \"field\" vazio");
		}
		if($obj->get("text") === null){
			throw new Exception("Campo \"text\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
	}
}
?>