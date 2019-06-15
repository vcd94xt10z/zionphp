<?php
namespace zion\mod\post\controller;

use zion\mod\post\standard\controller\CategoryController AS StandardCategoryController;

/**
 * Classe gerada pelo Zion Framework em 15/06/2019
 */
class CategoryController extends StandardCategoryController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_post_category"
		));
	}
}
?>