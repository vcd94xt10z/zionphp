<?php
namespace zion\mod\proj\standard\controller;

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
abstract class FeatureController extends AbstractEntityController {
	public function __construct($className, array $args){
		parent::__construct($className, $args);
		
		// carregando tabela de valores
		$names = array();
		$this->loadTabval($names);
	}

	public function getFormBean() : ObjectVO {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "PUT"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$obj = new ObjectVO();
		if($_SERVER["REQUEST_METHOD"] == "GET"){
			// valores default
			$obj->set("mandt",0);
			$obj->set("sequence","0");
			$obj->set("created_at",new \DateTime());
			$obj->set("status","P");
			$obj->set("released_to_test","0");
			$obj->set("complexity","B");
			$obj->set("version","1");
			return $obj;
		}
		
		$obj->set("mandt",abs(intval($_POST["obj"]["mandt"])));
		$obj->set("projid",TextFormatter::parse("integer",$_POST["obj"]["projid"],true));
		$obj->set("featid",TextFormatter::parse("integer",$_POST["obj"]["featid"],true));
		$obj->set("sequence",TextFormatter::parse("integer",$_POST["obj"]["sequence"]));
		$obj->set("name",$_POST["obj"]["name"]);
		$obj->set("created_at",TextFormatter::parse("datetime",$_POST["obj"]["created_at"]));
		$obj->set("created_by",$_POST["obj"]["created_by"]);
		$obj->set("main_developer",$_POST["obj"]["main_developer"]);
		$obj->set("status",$_POST["obj"]["status"]);
		$obj->set("released_to_test",TextFormatter::parse("boolean",$_POST["obj"]["released_to_test"]));
		$obj->set("complexity",$_POST["obj"]["complexity"]);
		$obj->set("version",TextFormatter::parse("integer",$_POST["obj"]["version"]));
		$obj->set("estimated_time",TextFormatter::parse("double",$_POST["obj"]["estimated_time"]));
		$obj->set("url",$_POST["obj"]["url"]);
		$obj->set("note",$_POST["obj"]["note"]);
		return $obj;
	}

	public function getFilterBean() : Filter {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "FILTER"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$filter = new Filter();
		$filter->addFilterField("mandt","integer",$_POST["filter"]["mandt"]);
		$filter->addFilterField("projid","integer",$_POST["filter"]["projid"]);
		$filter->addFilterField("featid","integer",$_POST["filter"]["featid"]);
		$filter->addFilterField("sequence","integer",$_POST["filter"]["sequence"]);
		$filter->addFilterField("name","string",$_POST["filter"]["name"]);
		$filter->addFilterField("created_at","datetime",$_POST["filter"]["created_at"]);
		$filter->addFilterField("created_by","string",$_POST["filter"]["created_by"]);
		$filter->addFilterField("main_developer","string",$_POST["filter"]["main_developer"]);
		$filter->addFilterField("status","string",$_POST["filter"]["status"]);
		$filter->addFilterField("released_to_test","boolean",$_POST["filter"]["released_to_test"]);
		$filter->addFilterField("complexity","string",$_POST["filter"]["complexity"]);
		$filter->addFilterField("version","integer",$_POST["filter"]["version"]);
		$filter->addFilterField("estimated_time","double",$_POST["filter"]["estimated_time"]);
		$filter->addFilterField("url","string",$_POST["filter"]["url"]);
		$filter->addFilterField("note","string",$_POST["filter"]["note"]);
		
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
		$keys["projid"] = TextFormatter::parse("integer",$_GET["keys"]["projid"]);
		$keys["featid"] = TextFormatter::parse("integer",$_GET["keys"]["featid"]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "mandt";
		$keys[] = "projid";
		$keys[] = "featid";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("sequence") === null){
			throw new Exception("Campo \"sequence\" vazio");
		}
		if($obj->get("name") === null){
			throw new Exception("Campo \"name\" vazio");
		}
		if($obj->get("created_at") === null){
			throw new Exception("Campo \"created_at\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
		$dao = System::getDAO();
		if($obj->get("projid") === null){
			$obj->set("projid",$dao->getNextId($db,"Feature-projid"));
		}
		if($obj->get("featid") === null){
			$obj->set("featid",$dao->getNextId($db,"Feature-featid"));
		}
	}
}
?>