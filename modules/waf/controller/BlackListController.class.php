<?php
namespace zion\mod\waf\controller;

use zion\mod\waf\standard\controller\BlackListController AS StandardBlackListController;

/**
 * Classe gerada pelo Zion Framework em 26/06/2019
 */
class BlackListController extends StandardBlackListController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_waf_blacklist"
		));
	}
}
?>