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
abstract class TestController extends AbstractEntityController {
	public function getFormBean() : ObjectVO {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "PUT"){
			$_POST = HTTPUtils::parsePost();
		}
		$obj = new ObjectVO();
		$obj->set("mandt",TextFormatter::parse("integer",$_POST["obj"]["mandt"]),true);
		$obj->set("projid",TextFormatter::parse("integer",$_POST["obj"]["projid"]),true);
		$obj->set("featid",TextFormatter::parse("integer",$_POST["obj"]["featid"]),true);
		$obj->set("version",TextFormatter::parse("integer",$_POST["obj"]["version"]));
		$obj->set("testid",TextFormatter::parse("integer",$_POST["obj"]["testid"]));
		$obj->set("test_at",TextFormatter::parse("datetime",$_POST["obj"]["test_at"]));
		$obj->set("test_by",$_POST["obj"]["test_by"]);
		$obj->set("result",$_POST["obj"]["result"]);
		$obj->set("device",$_POST["obj"]["device"]);
		$obj->set("browser",$_POST["obj"]["browser"]);
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
		$filter->addFilterField("version","integer",$_POST["filter"]["version"]);
		$filter->addFilterField("testid","integer",$_POST["filter"]["testid"]);
		$filter->addFilterField("test_at","datetime",$_POST["filter"]["test_at"]);
		$filter->addFilterField("test_by","string",$_POST["filter"]["test_by"]);
		$filter->addFilterField("result","string",$_POST["filter"]["result"]);
		$filter->addFilterField("device","string",$_POST["filter"]["device"]);
		$filter->addFilterField("browser","string",$_POST["filter"]["browser"]);
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
		$parts = $this->getPrimaryKeyFromURI();
		$keys = array();
		$keys["mandt"] = TextFormatter::parse("integer",$parts[0]);
		$keys["projid"] = TextFormatter::parse("integer",$parts[1]);
		$keys["featid"] = TextFormatter::parse("integer",$parts[2]);
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
		if($obj->get("version") === null){
			throw new Exception("Campo \"version\" vazio");
		}
		if($obj->get("testid") === null){
			throw new Exception("Campo \"testid\" vazio");
		}
		if($obj->get("test_at") === null){
			throw new Exception("Campo \"test_at\" vazio");
		}
		if($obj->get("test_by") === null){
			throw new Exception("Campo \"test_by\" vazio");
		}
		if($obj->get("result") === null){
			throw new Exception("Campo \"result\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
		$dao = System::getDAO();
		if($obj->get("mandt") === null){
			$obj->set("mandt",$dao->getNextId($db,"Test-mandt"));
		}
		if($obj->get("projid") === null){
			$obj->set("projid",$dao->getNextId($db,"Test-projid"));
		}
		if($obj->get("featid") === null){
			$obj->set("featid",$dao->getNextId($db,"Test-featid"));
		}
	}
}
?>