<?php
namespace zion\util;

use Exception;
use zion\orm\ObjectVO;
use zion\mail\MailAddress;
use zion\mail\MailManager;
use zion\core\System;

/**
 * @author Vinicius Cesar Dias
 */
class MailUtils {
	/**
	 * Envia um e-mail de forma simples
	 * @param ObjectVO $obj
	 * @throws Exception
	 */
	public static function sendMail(ObjectVO $obj){
	    // remetente  
	    $from = new MailAddress($obj->get("fromAddress"),$obj->get("fromName"));
	    
	    // e-mails envolvidos
		$recipients = array();
		if($obj->has("recipients")){
		    $recipients = $obj->get("recipients");
		}else{
		    $recipients[] = new MailAddress($obj->get("toAddress"),$obj->get("toName"));
		}
		
		$subject = $obj->get("subject");
		$body = $obj->get("body");
		$bodyContentType = $obj->get("bodyContentType");
		
		if($bodyContentType == ""){
			$bodyContentType = "text/html"; // text/plain
		}
		
		// enviando
		$data = System::get("smtp");
		$mail = new MailManager($data);
		$result = 0;
		
		if($from->getEmail() == ""){
		    $from->setEmail($data["user"]);
        }
        
		try {
			$mail->sendPHPMail($from, $recipients, $subject, $body, $bodyContentType);
			$result = 1;
		}catch(Exception $e){
			$result = 0;
		}
		return $result;
	}
}
?>