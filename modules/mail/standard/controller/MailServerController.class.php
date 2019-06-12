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
abstract class MailServerController extends AbstractEntityController {
	public function getFormBean() : ObjectVO {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "PUT"){
			$_POST = HTTPUtils::parsePost();
		}
		$obj = new ObjectVO();
		$obj->set("mandt",TextFormatter::parse("integer",$_POST["obj"]["mandt"]),true);
		$obj->set("server",TextFormatter::parse("string",$_POST["obj"]["server"]),true);
		$obj->set("smtp_host",$_POST["obj"]["smtp_host"]);
		$obj->set("smtp_port",TextFormatter::parse("integer",$_POST["obj"]["smtp_port"]));
		$obj->set("smtp_auth",TextFormatter::parse("boolean",$_POST["obj"]["smtp_auth"]));
		$obj->set("smtp_secure",$_POST["obj"]["smtp_secure"]);
		$obj->set("pop_host",$_POST["obj"]["pop_host"]);
		$obj->set("pop_port",TextFormatter::parse("integer",$_POST["obj"]["pop_port"]));
		$obj->set("pop_secure",$_POST["obj"]["pop_secure"]);
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
		$filter->addFilterField("server","string",$_POST["filter"]["server"]);
		$filter->addFilterField("smtp_host","string",$_POST["filter"]["smtp_host"]);
		$filter->addFilterField("smtp_port","integer",$_POST["filter"]["smtp_port"]);
		$filter->addFilterField("smtp_auth","boolean",$_POST["filter"]["smtp_auth"]);
		$filter->addFilterField("smtp_secure","string",$_POST["filter"]["smtp_secure"]);
		$filter->addFilterField("pop_host","string",$_POST["filter"]["pop_host"]);
		$filter->addFilterField("pop_port","integer",$_POST["filter"]["pop_port"]);
		$filter->addFilterField("pop_secure","string",$_POST["filter"]["pop_secure"]);
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
		$param = $this->getURIParam(1);
		$parts = explode(":",$param);
		$keys = array();
		$keys["mandt"] = TextFormatter::parse("integer",$parts[0]);
		$keys["server"] = TextFormatter::parse("string",$parts[1]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "mandt";
		$keys[] = "server";
		return $keys;
	}

	public function validate(ObjectVO $obj){
		if($obj->get("status") === null){
			throw new Exception("Campo \"status\" vazio");
		}
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
		$dao = System::getDAO();
		if($obj->get("mandt") === null){
			$obj->set("mandt",$dao->getNextId($db,"MailServer-mandt"));
		}
		if($obj->get("server") === null){
			$obj->set("server",$dao->getNextId($db,"MailServer-server"));
		}
	}
}
?>