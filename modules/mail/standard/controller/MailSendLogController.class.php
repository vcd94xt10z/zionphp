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
abstract class MailSendLogController extends AbstractEntityController {
	public function getFormBean() : ObjectVO {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "PUT"){
			$_POST = HTTPUtils::parsePost();
		}
		$obj = new ObjectVO();
		$obj->set("mandt",TextFormatter::parse("integer",$_POST["obj"]["mandt"]),true);
		$obj->set("logid",TextFormatter::parse("string",$_POST["obj"]["logid"]),true);
		$obj->set("created",TextFormatter::parse("datetime",$_POST["obj"]["created"]));
		$obj->set("server",$_POST["obj"]["server"]);
		$obj->set("user",$_POST["obj"]["user"]);
		$obj->set("from",$_POST["obj"]["from"]);
		$obj->set("to",$_POST["obj"]["to"]);
		$obj->set("subject",$_POST["obj"]["subject"]);
		$obj->set("content_type",$_POST["obj"]["content_type"]);
		$obj->set("content_body_size",TextFormatter::parse("integer",$_POST["obj"]["content_body_size"]));
		$obj->set("attachment_count",TextFormatter::parse("integer",$_POST["obj"]["attachment_count"]));
		$obj->set("result",$_POST["obj"]["result"]);
		$obj->set("result_message",$_POST["obj"]["result_message"]);
		return $obj;
	}

	public function getFilterBean() : Filter {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "FILTER"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$filter = new Filter();
		$filter->addFilterField("mandt","integer",$_POST["filter"]["mandt"]);
		$filter->addFilterField("logid","string",$_POST["filter"]["logid"]);
		$filter->addFilterField("created","datetime",$_POST["filter"]["created"]);
		$filter->addFilterField("server","string",$_POST["filter"]["server"]);
		$filter->addFilterField("user","string",$_POST["filter"]["user"]);
		$filter->addFilterField("from","string",$_POST["filter"]["from"]);
		$filter->addFilterField("to","string",$_POST["filter"]["to"]);
		$filter->addFilterField("subject","string",$_POST["filter"]["subject"]);
		$filter->addFilterField("content_type","string",$_POST["filter"]["content_type"]);
		$filter->addFilterField("content_body_size","integer",$_POST["filter"]["content_body_size"]);
		$filter->addFilterField("attachment_count","integer",$_POST["filter"]["attachment_count"]);
		$filter->addFilterField("result","string",$_POST["filter"]["result"]);
		$filter->addFilterField("result_message","string",$_POST["filter"]["result_message"]);
		
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
		$keys["logid"] = TextFormatter::parse("string",$parts[1]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "mandt";
		$keys[] = "logid";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("created") === null){
			throw new Exception("Campo \"created\" vazio");
		}
		if($obj->get("server") === null){
			throw new Exception("Campo \"server\" vazio");
		}
		if($obj->get("user") === null){
			throw new Exception("Campo \"user\" vazio");
		}
		if($obj->get("result") === null){
			throw new Exception("Campo \"result\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
		$dao = System::getDAO();
		if($obj->get("mandt") === null){
			$obj->set("mandt",$dao->getNextId($db,"MailSendLog-mandt"));
		}
		if($obj->get("logid") === null){
			$obj->set("logid",$dao->getNextId($db,"MailSendLog-logid"));
		}
	}
}
?>