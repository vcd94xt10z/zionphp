<?php
namespace zion\mod\proj\controller;

use zion\mod\proj\standard\controller\FeatureController AS StandardFeatureController;

/**
 * Classe gerada pelo Zion Framework em 05/06/2019
 */
class FeatureController extends StandardFeatureController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "proj_feature"
		));
	}
}
?>