<?php
namespace zion\mod\core\controller;

use DateTime;
use zion\mod\core\standard\controller\ModuleController AS StandardModuleController;
use zion\orm\ObjectVO;

/**
 * Classe gerada pelo Zion Framework em 24/05/2019
 */
class ModuleController extends StandardModuleController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_core_module"
		));
	}
	
	public function getFormBean() : ObjectVO {
	    $obj = parent::getFormBean();
	    if($obj->get("created") === null){
	        $obj->set("created",new DateTime());
	    }
	    if($obj->get("updated") === null){
	        $obj->set("updated",new DateTime());
	    }
	    return $obj;
	}
}
?>