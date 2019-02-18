<?php
namespace zion\mod\error\controller;

/**
 * Classe gerada pelo Zion Framework em 18/02/2019
 */
class ErrorLogController extends AbstractErrorLogController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "error_log"
		));
	}
}
?>