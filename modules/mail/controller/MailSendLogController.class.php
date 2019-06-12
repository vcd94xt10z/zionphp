<?php
namespace zion\mod\mail\controller;

use zion\mod\mail\standard\controller\MailSendLogController AS StandardMailSendLogController;

/**
 * Classe gerada pelo Zion Framework em 12/06/2019
 */
class MailSendLogController extends StandardMailSendLogController {
	public function __construct(){
		parent::__construct(get_class($this),array(
		    "table" => "zion_mail_send_log"
		));
	}
}
?>