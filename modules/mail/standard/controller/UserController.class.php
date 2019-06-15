<?php
namespace zion\mod\mail\standard\controller;

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
		if($_SERVER["REQUEST_METHOD"] == "GET"){
			// valores default
			$obj->set("mandt",0);
			$obj->set("status","A");
			$obj->set("hourly_quota","0");
			$obj->set("daily_quota","0");
			$obj->set("sent_success","0");
			$obj->set("sent_error","0");
			return $obj;
		}
		
		$obj->set("mandt",abs(intval($_POST["obj"]["mandt"])));
		$obj->set("user",TextFormatter::parse("string",$_POST["obj"]["user"]));
		$obj->set("password",$_POST["obj"]["password"]);
		$obj->set("server",$_POST["obj"]["server"]);
		$obj->set("status",$_POST["obj"]["status"]);
		$obj->set("hourly_quota",TextFormatter::parse("integer",$_POST["obj"]["hourly_quota"]));
		$obj->set("daily_quota",TextFormatter::parse("integer",$_POST["obj"]["daily_quota"]));
		$obj->set("sent_success",TextFormatter::parse("integer",$_POST["obj"]["sent_success"]));
		$obj->set("sent_error",TextFormatter::parse("integer",$_POST["obj"]["sent_error"]));
		return $obj;
	}

	public function getFilterBean() : Filter {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "FILTER"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$filter = new Filter();
		$filter->addFilterField("mandt","integer",$_POST["filter"]["mandt"]);
		$filter->addFilterField("user","string",$_POST["filter"]["user"]);
		$filter->addFilterField("password","string",$_POST["filter"]["password"]);
		$filter->addFilterField("server","string",$_POST["filter"]["server"]);
		$filter->addFilterField("status","string",$_POST["filter"]["status"]);
		$filter->addFilterField("hourly_quota","integer",$_POST["filter"]["hourly_quota"]);
		$filter->addFilterField("daily_quota","integer",$_POST["filter"]["daily_quota"]);
		$filter->addFilterField("sent_success","integer",$_POST["filter"]["sent_success"]);
		$filter->addFilterField("sent_error","integer",$_POST["filter"]["sent_error"]);
		
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
		$keys["user"] = TextFormatter::parse("string",$_GET["keys"]["user"]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "mandt";
		$keys[] = "user";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("user") === null){
			throw new Exception("Campo \"user\" vazio");
		}
		if($obj->get("password") === null){
			throw new Exception("Campo \"password\" vazio");
		}
		if($obj->get("server") === null){
			throw new Exception("Campo \"server\" vazio");
		}
		if($obj->get("status") === null){
			throw new Exception("Campo \"status\" vazio");
		}
		if($obj->get("hourly_quota") === null){
			throw new Exception("Campo \"hourly_quota\" vazio");
		}
		if($obj->get("daily_quota") === null){
			throw new Exception("Campo \"daily_quota\" vazio");
		}
		if($obj->get("sent_success") === null){
			throw new Exception("Campo \"sent_success\" vazio");
		}
		if($obj->get("sent_error") === null){
			throw new Exception("Campo \"sent_error\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
	}
}
?>