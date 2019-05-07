<?php
namespace zion\mod\core\controller;

/**
 * Classe gerada pelo Zion Framework em 07/05/2019
 */
class ConfigController extends AbstractConfigController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_core_config"
		));
	}
}
?>