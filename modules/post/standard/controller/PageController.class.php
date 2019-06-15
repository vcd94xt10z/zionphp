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
abstract class PageController extends AbstractEntityController {
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
		$obj->set("pageid",TextFormatter::parse("integer",$_POST["obj"]["pageid"],true));
		$obj->set("rewrite",$_POST["obj"]["rewrite"]);
		$obj->set("title",$_POST["obj"]["title"]);
		$obj->set("categoryid",TextFormatter::parse("integer",$_POST["obj"]["categoryid"]));
		$obj->set("content_html",$_POST["obj"]["content_html"]);
		$obj->set("created_at",TextFormatter::parse("datetime",$_POST["obj"]["created_at"]));
		$obj->set("created_by",$_POST["obj"]["created_by"]);
		$obj->set("updated_at",TextFormatter::parse("datetime",$_POST["obj"]["updated_at"]));
		$obj->set("updated_by",$_POST["obj"]["updated_by"]);
		$obj->set("meta_description",$_POST["obj"]["meta_description"]);
		$obj->set("meta_keywords",$_POST["obj"]["meta_keywords"]);
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
		$filter->addFilterField("pageid","integer",$_POST["filter"]["pageid"]);
		$filter->addFilterField("rewrite","string",$_POST["filter"]["rewrite"]);
		$filter->addFilterField("title","string",$_POST["filter"]["title"]);
		$filter->addFilterField("categoryid","integer",$_POST["filter"]["categoryid"]);
		$filter->addFilterField("content_html","string",$_POST["filter"]["content_html"]);
		$filter->addFilterField("created_at","datetime",$_POST["filter"]["created_at"]);
		$filter->addFilterField("created_by","string",$_POST["filter"]["created_by"]);
		$filter->addFilterField("updated_at","datetime",$_POST["filter"]["updated_at"]);
		$filter->addFilterField("updated_by","string",$_POST["filter"]["updated_by"]);
		$filter->addFilterField("meta_description","string",$_POST["filter"]["meta_description"]);
		$filter->addFilterField("meta_keywords","string",$_POST["filter"]["meta_keywords"]);
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
		$keys["pageid"] = TextFormatter::parse("integer",$_GET["keys"]["pageid"]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "mandt";
		$keys[] = "pageid";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("rewrite") === null){
			throw new Exception("Campo \"rewrite\" vazio");
		}
		if($obj->get("title") === null){
			throw new Exception("Campo \"title\" vazio");
		}
		if($obj->get("content_html") === null){
			throw new Exception("Campo \"content_html\" vazio");
		}
		if($obj->get("created_at") === null){
			throw new Exception("Campo \"created_at\" vazio");
		}
		if($obj->get("created_by") === null){
			throw new Exception("Campo \"created_by\" vazio");
		}
		if($obj->get("meta_description") === null){
			throw new Exception("Campo \"meta_description\" vazio");
		}
		if($obj->get("meta_keywords") === null){
			throw new Exception("Campo \"meta_keywords\" vazio");
		}
		if($obj->get("status") === null){
			throw new Exception("Campo \"status\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
		$dao = System::getDAO();
		if($obj->get("pageid") === null){
			$obj->set("pageid",$dao->getNextId($db,"Page-pageid"));
		}
	}
}
?>