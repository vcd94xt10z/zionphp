<?php
namespace zion\mod\mail\controller;

use zion\mod\mail\standard\controller\SendLogController AS StandardSendLogController;

/**
 * Classe gerada pelo Zion Framework em 12/06/2019
 */
class SendLogController extends StandardSendLogController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_mail_send_log"
		));
	}
}
?>