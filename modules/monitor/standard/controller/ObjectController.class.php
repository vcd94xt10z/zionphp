<?php
namespace zion\mod\monitor\standard\controller;

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
abstract class ObjectController extends AbstractEntityController {
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
			$obj->set("created",new \DateTime());
			$obj->set("notify_by_email","0");
			$obj->set("notify_by_sms","0");
			$obj->set("sound_enabled","1");
			$obj->set("enabled","1");
			$obj->set("counter_success","0");
			$obj->set("counter_error","0");
			$obj->set("counter_timeout","0");
			return $obj;
		}
		
		$obj->set("objectid",TextFormatter::parse("string",$_POST["obj"]["objectid"]));
		$obj->set("name",$_POST["obj"]["name"]);
		$obj->set("created",TextFormatter::parse("datetime",$_POST["obj"]["created"]));
		$obj->set("type",$_POST["obj"]["type"]);
		$obj->set("url",$_POST["obj"]["url"]);
		$obj->set("interval",TextFormatter::parse("integer",$_POST["obj"]["interval"]));
		$obj->set("status",$_POST["obj"]["status"]);
		$obj->set("last_check",TextFormatter::parse("datetime",$_POST["obj"]["last_check"]));
		$obj->set("notify_by_email",TextFormatter::parse("boolean",$_POST["obj"]["notify_by_email"]));
		$obj->set("notify_by_sms",TextFormatter::parse("boolean",$_POST["obj"]["notify_by_sms"]));
		$obj->set("notify_by_tts",TextFormatter::parse("boolean",$_POST["obj"]["notify_by_tts"]));
		$obj->set("notify_email",$_POST["obj"]["notify_email"]);
		$obj->set("notify_phone",$_POST["obj"]["notify_phone"]);
		$obj->set("sound_enabled",TextFormatter::parse("boolean",$_POST["obj"]["sound_enabled"]));
		$obj->set("enabled",TextFormatter::parse("boolean",$_POST["obj"]["enabled"]));
		$obj->set("counter_success",TextFormatter::parse("integer",$_POST["obj"]["counter_success"]));
		$obj->set("counter_error",TextFormatter::parse("integer",$_POST["obj"]["counter_error"]));
		$obj->set("counter_timeout",TextFormatter::parse("integer",$_POST["obj"]["counter_timeout"]));
		return $obj;
	}

	public function getFilterBean() : Filter {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "FILTER"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$filter = new Filter();
		$filter->addFilterField("objectid","string",$_POST["filter"]["objectid"]);
		$filter->addFilterField("name","string",$_POST["filter"]["name"]);
		$filter->addFilterField("created","datetime",$_POST["filter"]["created"]);
		$filter->addFilterField("type","string",$_POST["filter"]["type"]);
		$filter->addFilterField("url","string",$_POST["filter"]["url"]);
		$filter->addFilterField("interval","integer",$_POST["filter"]["interval"]);
		$filter->addFilterField("status","string",$_POST["filter"]["status"]);
		$filter->addFilterField("last_check","datetime",$_POST["filter"]["last_check"]);
		$filter->addFilterField("notify_by_email","boolean",$_POST["filter"]["notify_by_email"]);
		$filter->addFilterField("notify_by_sms","boolean",$_POST["filter"]["notify_by_sms"]);
		$filter->addFilterField("notify_by_tts","boolean",$_POST["filter"]["notify_by_tts"]);
		$filter->addFilterField("notify_email","string",$_POST["filter"]["notify_email"]);
		$filter->addFilterField("notify_phone","string",$_POST["filter"]["notify_phone"]);
		$filter->addFilterField("sound_enabled","boolean",$_POST["filter"]["sound_enabled"]);
		$filter->addFilterField("enabled","boolean",$_POST["filter"]["enabled"]);
		$filter->addFilterField("counter_success","integer",$_POST["filter"]["counter_success"]);
		$filter->addFilterField("counter_error","integer",$_POST["filter"]["counter_error"]);
		$filter->addFilterField("counter_timeout","integer",$_POST["filter"]["counter_timeout"]);
		
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
		$keys["objectid"] = TextFormatter::parse("string",$_GET["keys"]["objectid"]);
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
		if($obj->get("name") === null){
			throw new Exception("Campo \"name\" vazio");
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
	}
}
?>