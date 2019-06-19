<?php
namespace zion\mod\post\standard\controller;

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
abstract class CategoryController extends AbstractEntityController {
	public function __construct($className, array $args){
		parent::__construct($className, $args);
		
		// carregando tabela de valores
		$names = array();
		$names[] = "status";
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
			$obj->set("created_at",new \DateTime());
			$obj->set("status","A");
			return $obj;
		}
		
		$obj->set("mandt",abs(intval($_POST["obj"]["mandt"])));
		$obj->set("categoryid",TextFormatter::parse("integer",$_POST["obj"]["categoryid"],true));
		$obj->set("parentid",TextFormatter::parse("integer",$_POST["obj"]["parentid"]));
		$obj->set("name",$_POST["obj"]["name"]);
		$obj->set("created_at",TextFormatter::parse("datetime",$_POST["obj"]["created_at"]));
		$obj->set("updated_at",TextFormatter::parse("datetime",$_POST["obj"]["updated_at"]));
		$obj->set("status",$_POST["obj"]["status"]);
		return $obj;
	}

	public function getFilterBean() : Filter {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "FILTER"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$filter = new Filter();
		$filter->addFilterField("mandt","integer",$_POST["filter"]["mandt"]);
		$filter->addFilterField("categoryid","integer",$_POST["filter"]["categoryid"]);
		$filter->addFilterField("parentid","integer",$_POST["filter"]["parentid"]);
		$filter->addFilterField("name","string",$_POST["filter"]["name"]);
		$filter->addFilterField("created_at","datetime",$_POST["filter"]["created_at"]);
		$filter->addFilterField("updated_at","datetime",$_POST["filter"]["updated_at"]);
		$filter->addFilterField("status","string",$_POST["filter"]["status"]);
		
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
		$keys["categoryid"] = TextFormatter::parse("integer",$_GET["keys"]["categoryid"]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "mandt";
		$keys[] = "categoryid";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("name") === null){
			throw new Exception("Campo \"name\" vazio");
		}
		if($obj->get("created_at") === null){
			throw new Exception("Campo \"created_at\" vazio");
		}
		if($obj->get("status") === null){
			throw new Exception("Campo \"status\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
		$dao = System::getDAO();
		if($obj->get("categoryid") === null){
			$obj->set("categoryid",$dao->getNextId($db,"Category-categoryid"));
		}
	}
}
?>