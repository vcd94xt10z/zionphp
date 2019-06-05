<?php
namespace zion\mod\proj\controller;

use zion\mod\proj\standard\controller\TestController AS StandardTestController;

/**
 * Classe gerada pelo Zion Framework em 05/06/2019
 */
class TestController extends StandardTestController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "proj_test"
		));
	}
}
?>