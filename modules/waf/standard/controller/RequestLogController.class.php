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
abstract class RequestLogController extends AbstractEntityController {
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
		
		$obj->set("requestid",TextFormatter::parse("integer",$_POST["obj"]["requestid"],true));
		$obj->set("USER",$_POST["obj"]["USER"]);
		$obj->set("HOME",$_POST["obj"]["HOME"]);
		$obj->set("SCRIPT_NAME",$_POST["obj"]["SCRIPT_NAME"]);
		$obj->set("REQUEST_URI",$_POST["obj"]["REQUEST_URI"]);
		$obj->set("QUERY_STRING",$_POST["obj"]["QUERY_STRING"]);
		$obj->set("REQUEST_METHOD",$_POST["obj"]["REQUEST_METHOD"]);
		$obj->set("SERVER_PROTOCOL",$_POST["obj"]["SERVER_PROTOCOL"]);
		$obj->set("GATEWAY_INTERFACE",$_POST["obj"]["GATEWAY_INTERFACE"]);
		$obj->set("REDIRECT_URL",$_POST["obj"]["REDIRECT_URL"]);
		$obj->set("REMOTE_PORT",$_POST["obj"]["REMOTE_PORT"]);
		$obj->set("SCRIPT_FILENAME",$_POST["obj"]["SCRIPT_FILENAME"]);
		$obj->set("SERVER_ADMIN",$_POST["obj"]["SERVER_ADMIN"]);
		$obj->set("CONTEXT_DOCUMENT_ROOT",$_POST["obj"]["CONTEXT_DOCUMENT_ROOT"]);
		$obj->set("CONTEXT_PREFIX",$_POST["obj"]["CONTEXT_PREFIX"]);
		$obj->set("REQUEST_SCHEME",$_POST["obj"]["REQUEST_SCHEME"]);
		$obj->set("DOCUMENT_ROOT",$_POST["obj"]["DOCUMENT_ROOT"]);
		$obj->set("REMOTE_ADDR",$_POST["obj"]["REMOTE_ADDR"]);
		$obj->set("SERVER_PORT",$_POST["obj"]["SERVER_PORT"]);
		$obj->set("SERVER_ADDR",$_POST["obj"]["SERVER_ADDR"]);
		$obj->set("SERVER_NAME",$_POST["obj"]["SERVER_NAME"]);
		$obj->set("SERVER_SOFTWARE",$_POST["obj"]["SERVER_SOFTWARE"]);
		$obj->set("SERVER_SIGNATURE",$_POST["obj"]["SERVER_SIGNATURE"]);
		$obj->set("PATH",$_POST["obj"]["PATH"]);
		$obj->set("HTTP_PRAGMA",$_POST["obj"]["HTTP_PRAGMA"]);
		$obj->set("HTTP_COOKIE",$_POST["obj"]["HTTP_COOKIE"]);
		$obj->set("HTTP_ACCEPT_LANGUAGE",$_POST["obj"]["HTTP_ACCEPT_LANGUAGE"]);
		$obj->set("HTTP_ACCEPT_ENCODING",$_POST["obj"]["HTTP_ACCEPT_ENCODING"]);
		$obj->set("HTTP_ACCEPT",$_POST["obj"]["HTTP_ACCEPT"]);
		$obj->set("HTTP_DNT",$_POST["obj"]["HTTP_DNT"]);
		$obj->set("HTTP_USER_AGENT",$_POST["obj"]["HTTP_USER_AGENT"]);
		$obj->set("HTTP_UPGRADE_INSECURE_REQUESTS",$_POST["obj"]["HTTP_UPGRADE_INSECURE_REQUESTS"]);
		$obj->set("HTTP_CONNECTION",$_POST["obj"]["HTTP_CONNECTION"]);
		$obj->set("HTTP_HOST",$_POST["obj"]["HTTP_HOST"]);
		$obj->set("UNIQUE_ID",$_POST["obj"]["UNIQUE_ID"]);
		$obj->set("REDIRECT_STATUS",$_POST["obj"]["REDIRECT_STATUS"]);
		$obj->set("REDIRECT_UNIQUE_ID",$_POST["obj"]["REDIRECT_UNIQUE_ID"]);
		$obj->set("FCGI_ROLE",$_POST["obj"]["FCGI_ROLE"]);
		$obj->set("PHP_SELF",$_POST["obj"]["PHP_SELF"]);
		$obj->set("REQUEST_TIME_FLOAT",$_POST["obj"]["REQUEST_TIME_FLOAT"]);
		$obj->set("REQUEST_TIME",TextFormatter::parse("datetime",$_POST["obj"]["REQUEST_TIME"]));
		$obj->set("HTTP_REFERER",$_POST["obj"]["HTTP_REFERER"]);
		$obj->set("REQUEST_BODY",$_POST["obj"]["REQUEST_BODY"]);
		return $obj;
	}

	public function getFilterBean() : Filter {
		// Deixando os dados na superglobal _POST
		if($_SERVER["REQUEST_METHOD"] == "FILTER"){
			$_POST = HTTPUtils::parsePost();
		}
		
		$filter = new Filter();
		$filter->addFilterField("requestid","integer",$_POST["filter"]["requestid"]);
		$filter->addFilterField("USER","string",$_POST["filter"]["USER"]);
		$filter->addFilterField("HOME","string",$_POST["filter"]["HOME"]);
		$filter->addFilterField("SCRIPT_NAME","string",$_POST["filter"]["SCRIPT_NAME"]);
		$filter->addFilterField("REQUEST_URI","string",$_POST["filter"]["REQUEST_URI"]);
		$filter->addFilterField("QUERY_STRING","string",$_POST["filter"]["QUERY_STRING"]);
		$filter->addFilterField("REQUEST_METHOD","string",$_POST["filter"]["REQUEST_METHOD"]);
		$filter->addFilterField("SERVER_PROTOCOL","string",$_POST["filter"]["SERVER_PROTOCOL"]);
		$filter->addFilterField("GATEWAY_INTERFACE","string",$_POST["filter"]["GATEWAY_INTERFACE"]);
		$filter->addFilterField("REDIRECT_URL","string",$_POST["filter"]["REDIRECT_URL"]);
		$filter->addFilterField("REMOTE_PORT","string",$_POST["filter"]["REMOTE_PORT"]);
		$filter->addFilterField("SCRIPT_FILENAME","string",$_POST["filter"]["SCRIPT_FILENAME"]);
		$filter->addFilterField("SERVER_ADMIN","string",$_POST["filter"]["SERVER_ADMIN"]);
		$filter->addFilterField("CONTEXT_DOCUMENT_ROOT","string",$_POST["filter"]["CONTEXT_DOCUMENT_ROOT"]);
		$filter->addFilterField("CONTEXT_PREFIX","string",$_POST["filter"]["CONTEXT_PREFIX"]);
		$filter->addFilterField("REQUEST_SCHEME","string",$_POST["filter"]["REQUEST_SCHEME"]);
		$filter->addFilterField("DOCUMENT_ROOT","string",$_POST["filter"]["DOCUMENT_ROOT"]);
		$filter->addFilterField("REMOTE_ADDR","string",$_POST["filter"]["REMOTE_ADDR"]);
		$filter->addFilterField("SERVER_PORT","string",$_POST["filter"]["SERVER_PORT"]);
		$filter->addFilterField("SERVER_ADDR","string",$_POST["filter"]["SERVER_ADDR"]);
		$filter->addFilterField("SERVER_NAME","string",$_POST["filter"]["SERVER_NAME"]);
		$filter->addFilterField("SERVER_SOFTWARE","string",$_POST["filter"]["SERVER_SOFTWARE"]);
		$filter->addFilterField("SERVER_SIGNATURE","string",$_POST["filter"]["SERVER_SIGNATURE"]);
		$filter->addFilterField("PATH","string",$_POST["filter"]["PATH"]);
		$filter->addFilterField("HTTP_PRAGMA","string",$_POST["filter"]["HTTP_PRAGMA"]);
		$filter->addFilterField("HTTP_COOKIE","string",$_POST["filter"]["HTTP_COOKIE"]);
		$filter->addFilterField("HTTP_ACCEPT_LANGUAGE","string",$_POST["filter"]["HTTP_ACCEPT_LANGUAGE"]);
		$filter->addFilterField("HTTP_ACCEPT_ENCODING","string",$_POST["filter"]["HTTP_ACCEPT_ENCODING"]);
		$filter->addFilterField("HTTP_ACCEPT","string",$_POST["filter"]["HTTP_ACCEPT"]);
		$filter->addFilterField("HTTP_DNT","string",$_POST["filter"]["HTTP_DNT"]);
		$filter->addFilterField("HTTP_USER_AGENT","string",$_POST["filter"]["HTTP_USER_AGENT"]);
		$filter->addFilterField("HTTP_UPGRADE_INSECURE_REQUESTS","string",$_POST["filter"]["HTTP_UPGRADE_INSECURE_REQUESTS"]);
		$filter->addFilterField("HTTP_CONNECTION","string",$_POST["filter"]["HTTP_CONNECTION"]);
		$filter->addFilterField("HTTP_HOST","string",$_POST["filter"]["HTTP_HOST"]);
		$filter->addFilterField("UNIQUE_ID","string",$_POST["filter"]["UNIQUE_ID"]);
		$filter->addFilterField("REDIRECT_STATUS","string",$_POST["filter"]["REDIRECT_STATUS"]);
		$filter->addFilterField("REDIRECT_UNIQUE_ID","string",$_POST["filter"]["REDIRECT_UNIQUE_ID"]);
		$filter->addFilterField("FCGI_ROLE","string",$_POST["filter"]["FCGI_ROLE"]);
		$filter->addFilterField("PHP_SELF","string",$_POST["filter"]["PHP_SELF"]);
		$filter->addFilterField("REQUEST_TIME_FLOAT","string",$_POST["filter"]["REQUEST_TIME_FLOAT"]);
		$filter->addFilterField("REQUEST_TIME","datetime",$_POST["filter"]["REQUEST_TIME"]);
		$filter->addFilterField("HTTP_REFERER","string",$_POST["filter"]["HTTP_REFERER"]);
		$filter->addFilterField("REQUEST_BODY","string",$_POST["filter"]["REQUEST_BODY"]);
		
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
		$keys["requestid"] = TextFormatter::parse("integer",$_GET["keys"]["requestid"]);
		$this->cleanEmptyKeys($keys);
		return $keys;
	}

	public function getEntityKeys(): array {
		$keys = array();
		$keys[] = "requestid";
		return $keys;
	}

	public function validate(ObjectVO $obj){
	}

	public function setAutoIncrement(PDO $db,ObjectVO &$obj){
		$dao = System::getDAO();
		if($obj->get("requestid") === null){
			$obj->set("requestid",$dao->getNextId($db,"RequestLog-requestid"));
		}
	}
}
?>