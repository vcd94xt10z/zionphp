<?php
namespace zion\mod\waf\standard\controller;

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
abstract class IpLocationController extends AbstractEntityController {
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
			return $obj;
		}
		
		$obj->set("ipaddr",TextFormatter::parse("string",$_POST["obj"]["ipaddr"]));
		$obj->set("type",$_POST["obj"]["type"]);
		$obj->set("continent_code",$_POST["obj"]["continent_code"]);
		$obj->set("continent_name",$_POST["obj"]["continent_name"]);
		$obj->set("country_code",$_POST["obj"]["country_code"]);
		$obj->set("country_name",$_POST["obj"]["country_name"]);
		$obj->set("region_code",$_POST["obj"]["region_code"]);
		$obj->set("region_name",$_POST["obj"]["region_name"]);
		$obj->set("city",$_POST["obj"]["city"]);
		$obj->set("updated",TextFormatter::parse("datetime",$_POST["obj"]["updated"]));
		return $obj;
	}

	public function getFilterBean() : Filter {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "FILTER"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$filter = new Filter();
		$filter->addFilterField("ipaddr","string",$_POST["filter"]["ipaddr"]);
		$filter->addFilterField("type","string",$_POST["filter"]["type"]);
		$filter->addFilterField("continent_code","string",$_POST["filter"]["continent_code"]);
		$filter->addFilterField("continent_name","string",$_POST["filter"]["continent_name"]);
		$filter->addFilterField("country_code","string",$_POST["filter"]["country_code"]);
		$filter->addFilterField("country_name","string",$_POST["filter"]["country_name"]);
		$filter->addFilterField("region_code","string",$_POST["filter"]["region_code"]);
		$filter->addFilterField("region_name","string",$_POST["filter"]["region_name"]);
		$filter->addFilterField("city","string",$_POST["filter"]["city"]);
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
		$keys["ipaddr"] = TextFormatter::parse("string",$_GET["keys"]["ipaddr"]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "ipaddr";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("ipaddr") === null){
			throw new Exception("Campo \"ipaddr\" vazio");
		}
		if($obj->get("country_code") === null){
			throw new Exception("Campo \"country_code\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
	}
}
?>