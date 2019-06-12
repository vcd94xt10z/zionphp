<?php
namespace zion\mod\mail\controller;

use zion\mod\mail\standard\controller\MailServerController AS StandardMailServerController;

/**
 * Classe gerada pelo Zion Framework em 12/06/2019
 */
class MailServerController extends StandardMailServerController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "mail_server"
		));
	}
}
?>