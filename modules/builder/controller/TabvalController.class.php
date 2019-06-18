<?php
namespace zion\mod\builder\controller;

use zion\mod\builder\standard\controller\TabvalController AS StandardTabvalController;

/**
 * Classe gerada pelo Zion Framework em 18/06/2019
 */
class TabvalController extends StandardTabvalController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_builder_tabval"
		));
	}
}
?>