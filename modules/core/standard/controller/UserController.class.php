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
abstract class UserController extends AbstractEntityController {
	public function getFormBean() : ObjectVO {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "PUT"){
			$_POST = HTTPUtils::parsePost();
		}
		$obj = new ObjectVO();
		$obj->set("mandt",TextFormatter::parse("integer",$_POST["obj"]["mandt"],true));
		$obj->set("userid",TextFormatter::parse("integer",$_POST["obj"]["userid"],true));
		$obj->set("login",$_POST["obj"]["login"]);
		$obj->set("password",$_POST["obj"]["password"]);
		$obj->set("perfil",$_POST["obj"]["perfil"]);
		$obj->set("force_new_password",TextFormatter::parse("integer",$_POST["obj"]["force_new_password"]));
		$obj->set("redefine_password_hash",$_POST["obj"]["redefine_password_hash"]);
		$obj->set("name",$_POST["obj"]["name"]);
		$obj->set("email",$_POST["obj"]["email"]);
		$obj->set("phone",$_POST["obj"]["phone"]);
		$obj->set("docf",$_POST["obj"]["docf"]);
		$obj->set("doce",$_POST["obj"]["doce"]);
		$obj->set("docm",$_POST["obj"]["docm"]);
		$obj->set("validity_begin",TextFormatter::parse("datetime",$_POST["obj"]["validity_begin"]));
		$obj->set("validity_end",TextFormatter::parse("datetime",$_POST["obj"]["validity_end"]));
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
		$filter->addFilterField("userid","integer",$_POST["filter"]["userid"]);
		$filter->addFilterField("login","string",$_POST["filter"]["login"]);
		$filter->addFilterField("password","string",$_POST["filter"]["password"]);
		$filter->addFilterField("perfil","string",$_POST["filter"]["perfil"]);
		$filter->addFilterField("force_new_password","integer",$_POST["filter"]["force_new_password"]);
		$filter->addFilterField("redefine_password_hash","string",$_POST["filter"]["redefine_password_hash"]);
		$filter->addFilterField("name","string",$_POST["filter"]["name"]);
		$filter->addFilterField("email","string",$_POST["filter"]["email"]);
		$filter->addFilterField("phone","string",$_POST["filter"]["phone"]);
		$filter->addFilterField("docf","string",$_POST["filter"]["docf"]);
		$filter->addFilterField("doce","string",$_POST["filter"]["doce"]);
		$filter->addFilterField("docm","string",$_POST["filter"]["docm"]);
		$filter->addFilterField("validity_begin","datetime",$_POST["filter"]["validity_begin"]);
		$filter->addFilterField("validity_end","datetime",$_POST["filter"]["validity_end"]);
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
		$keys["userid"] = TextFormatter::parse("integer",$_GET["keys"]["userid"]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "mandt";
		$keys[] = "userid";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("login") === null){
			throw new Exception("Campo \"login\" vazio");
		}
		if($obj->get("password") === null){
			throw new Exception("Campo \"password\" vazio");
		}
		if($obj->get("perfil") === null){
			throw new Exception("Campo \"perfil\" vazio");
		}
		if($obj->get("name") === null){
			throw new Exception("Campo \"name\" vazio");
		}
		if($obj->get("status") === null){
			throw new Exception("Campo \"status\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
		$dao = System::getDAO();
		if($obj->get("mandt") === null){
			$obj->set("mandt",$dao->getNextId($db,"User-mandt"));
		}
		if($obj->get("userid") === null){
			$obj->set("userid",$dao->getNextId($db,"User-userid"));
		}
	}
}
?>