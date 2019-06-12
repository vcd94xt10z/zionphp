<?php
namespace zion\mod\mail\controller;

use zion\mod\mail\standard\controller\MailUserController AS StandardMailUserController;

/**
 * Classe gerada pelo Zion Framework em 12/06/2019
 */
class MailUserController extends StandardMailUserController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "mail_user"
		));
	}
}
?>