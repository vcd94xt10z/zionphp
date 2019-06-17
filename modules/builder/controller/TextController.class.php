<?php
namespace zion\mod\builder\controller;

use zion\mod\builder\standard\controller\TextController AS StandardTextController;
use zion\orm\ObjectVO;

/**
 * Classe gerada pelo Zion Framework em 15/06/2019
 */
class TextController extends StandardTextController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_builder_text"
		));
	}
	
	public function getFormBean() : ObjectVO {
	    $obj = parent::getFormBean();
	    if($obj->get("medium_text") == ""){
	        $obj->set("medium_text",$obj->get("short_text"));
	    }
	    if($obj->get("full_text") == ""){
	        $obj->set("full_text",$obj->get("short_text"));
	    }
	    return $obj;
	}
}
?>