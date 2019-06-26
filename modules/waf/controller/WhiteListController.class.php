<?php
namespace zion\mod\waf\controller;

use zion\mod\waf\standard\controller\WhiteListController AS StandardWhiteListController;

/**
 * Classe gerada pelo Zion Framework em 26/06/2019
 */
class WhiteListController extends StandardWhiteListController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_waf_whitelist"
		));
	}
}
?>