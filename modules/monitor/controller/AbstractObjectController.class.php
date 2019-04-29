<?php
namespace zion\mod\monitor\controller;

use Exception;
use zion\core\AbstractEntityController;
use zion\orm\PDO;
use zion\orm\Filter;
use zion\orm\ObjectVO;
use zion\core\System;
use zion\utils\TextFormatter;
use zion\utils\HTTPUtils;

/**
 * Classe gerada pelo Zion Framework em 29/04/2019
 * Não edite esta classe
 */
abstract class AbstractObjectController extends AbstractEntityController {
	public function getFormBean() : ObjectVO {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "PUT"){
			$_POST = HTTPUtils::parsePost();
		}
		$obj = new ObjectVO();
		$obj->set("objectid",$_POST["obj"]["objectid"]);
		$obj->set("created",TextFormatter::parse("datetime",$_POST["obj"]["created"]));
		$obj->set("type",$_POST["obj"]["type"]);
		$obj->set("url",$_POST["obj"]["url"]);
		$obj->set("interval",TextFormatter::parse("integer",$_POST["obj"]["interval"]));
		$obj->set("status",$_POST["obj"]["status"]);
		$obj->set("last_check",TextFormatter::parse("datetime",$_POST["obj"]["last_check"]));
		$obj->set("notify_by_email",TextFormatter::parse("boolean",$_POST["obj"]["notify_by_email"]));
		$obj->set("notify_by_sms",TextFormatter::parse("boolean",$_POST["obj"]["notify_by_sms"]));
		$obj->set("notify_by_sound",TextFormatter::parse("boolean",$_POST["obj"]["notify_by_sound"]));
		$obj->set("notify_email",$_POST["obj"]["notify_email"]);
		$obj->set("notify_phone",$_POST["obj"]["notify_phone"]);
		$obj->set("notify_sound",$_POST["obj"]["notify_sound"]);
		$obj->set("sound_enabled",TextFormatter::parse("boolean",$_POST["obj"]["sound_enabled"]));
		$obj->set("enabled",TextFormatter::parse("boolean",$_POST["obj"]["enabled"]));
		return $obj;
	}

	public function getFilterBean() : Filter {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "FILTER"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$filter = new Filter();
		$filter->addFilterField("objectid","string",$_POST["filter"]["objectid"]);
		$filter->addFilterField("created","datetime",$_POST["filter"]["created"]);
		$filter->addFilterField("type","string",$_POST["filter"]["type"]);
		$filter->addFilterField("url","string",$_POST["filter"]["url"]);
		$filter->addFilterField("interval","integer",$_POST["filter"]["interval"]);
		$filter->addFilterField("status","string",$_POST["filter"]["status"]);
		$filter->addFilterField("last_check","datetime",$_POST["filter"]["last_check"]);
		$filter->addFilterField("notify_by_email","boolean",$_POST["filter"]["notify_by_email"]);
		$filter->addFilterField("notify_by_sms","boolean",$_POST["filter"]["notify_by_sms"]);
		$filter->addFilterField("notify_by_sound","boolean",$_POST["filter"]["notify_by_sound"]);
		$filter->addFilterField("notify_email","string",$_POST["filter"]["notify_email"]);
		$filter->addFilterField("notify_phone","string",$_POST["filter"]["notify_phone"]);
		$filter->addFilterField("notify_sound","string",$_POST["filter"]["notify_sound"]);
		$filter->addFilterField("sound_enabled","boolean",$_POST["filter"]["sound_enabled"]);
		$filter->addFilterField("enabled","boolean",$_POST["filter"]["enabled"]);
		
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
		$keys["objectid"] = TextFormatter::parse("string",$parts[0]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "objectid";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("objectid") === null){
			throw new Exception("Campo \"objectid\" vazio");
		}
		if($obj->get("created") === null){
			throw new Exception("Campo \"created\" vazio");
		}
		if($obj->get("type") === null){
			throw new Exception("Campo \"type\" vazio");
		}
		if($obj->get("url") === null){
			throw new Exception("Campo \"url\" vazio");
		}
		if($obj->get("interval") === null){
			throw new Exception("Campo \"interval\" vazio");
		}
		if($obj->get("status") === null){
			throw new Exception("Campo \"status\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
		$dao = System::getDAO();
		if($obj->get("objectid") === null){
			$obj->set("objectid",$dao->getNextId($db,"Object-objectid"));
		}
	}
}
?>