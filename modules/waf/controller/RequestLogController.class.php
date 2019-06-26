<?php
namespace zion\mod\waf\controller;

use zion\mod\waf\standard\controller\RequestLogController AS StandardRequestLogController;

/**
 * Classe gerada pelo Zion Framework em 26/06/2019
 */
class RequestLogController extends StandardRequestLogController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_waf_request_log"
		));
	}
}
?>