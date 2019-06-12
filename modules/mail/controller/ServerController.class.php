<?php
namespace zion\mod\mail\controller;

use zion\mod\mail\standard\controller\ServerController AS StandardServerController;

/**
 * Classe gerada pelo Zion Framework em 12/06/2019
 */
class ServerController extends StandardServerController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_mail_server"
		));
	}
}
?>