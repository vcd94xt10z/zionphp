<?php
namespace zion\mod\builder\controller;

use zion\mod\builder\standard\controller\TextController AS StandardTextController;

/**
 * Classe gerada pelo Zion Framework em 15/06/2019
 */
class TextController extends StandardTextController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_builder_text"
		));
	}
}
?>