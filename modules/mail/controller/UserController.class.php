<?php
namespace zion\mod\mail\controller;

use zion\mod\mail\standard\controller\UserController AS StandardUserController;

/**
 * Classe gerada pelo Zion Framework em 12/06/2019
 */
class UserController extends StandardUserController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_mail_user"
		));
	}
}
?>