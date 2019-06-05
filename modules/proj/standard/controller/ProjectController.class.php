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
abstract class ProjectController extends AbstractEntityController {
	public function getFormBean() : ObjectVO {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "PUT"){
			$_POST = HTTPUtils::parsePost();
		}
		$obj = new ObjectVO();
		$obj->set("mandt",TextFormatter::parse("integer",$_POST["obj"]["mandt"]));
		$obj->set("projid",TextFormatter::parse("integer",$_POST["obj"]["projid"]));
		$obj->set("created_at",TextFormatter::parse("datetime",$_POST["obj"]["created_at"]));
		$obj->set("created_by",$_POST["obj"]["created_by"]);
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
		$filter->addFilterField("created_at","datetime",$_POST["filter"]["created_at"]);
		$filter->addFilterField("created_by","string",$_POST["filter"]["created_by"]);
		
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
		$keys["projid"] = TextFormatter::parse("integer",$parts[1]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "mandt";
		$keys[] = "projid";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("mandt") === null){
			throw new Exception("Campo \"mandt\" vazio");
		}
		if($obj->get("projid") === null){
			throw new Exception("Campo \"projid\" vazio");
		}
		if($obj->get("created_at") === null){
			throw new Exception("Campo \"created_at\" vazio");
		}
		if($obj->get("created_by") === null){
			throw new Exception("Campo \"created_by\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
		$dao = System::getDAO();
		if($obj->get("mandt") === null){
			$obj->set("mandt",$dao->getNextId($db,"Project-mandt"));
		}
		if($obj->get("projid") === null){
			$obj->set("projid",$dao->getNextId($db,"Project-projid"));
		}
	}
}
?>