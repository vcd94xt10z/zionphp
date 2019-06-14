<?php
namespace zion\mod\mail\controller;

use Exception;
use zion\mail\MailAddress;
use zion\mod\mail\standard\controller\UserController AS StandardUserController;
use zion\core\Page;
use zion\core\System;
use zion\utils\HTTPUtils;
use zion\mail\OutputMail;
use zion\mod\mail\model\Sender;

/**
 * Classe gerada pelo Zion Framework em 12/06/2019
 */
class UserController extends StandardUserController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_mail_user"
		));
	}
	
	public function actionSendTestForm(){
	    try {
	        // input
	        
	        // process
    	    $db        = System::getConnection();
    	    $serverDAO = System::getDAO($db,"zion_mail_server");
    	    $userDAO   = System::getDAO($db,"zion_mail_user");
    	    
    	    $serverList = $serverDAO->getArray($db);
    	    $userList = $userDAO->getArray($db);
    	    
    	    System::set("serverList",$serverList);
    	    System::set("userList",$userList);
    	    
    	    // output
    	    Page::setTitle("Teste de envio");
    	    $this->view("sendtest");
	    }catch(Exception $e){
	        echo $e->getMessage();
	    }
	}
	
	public function actionSendTest(){
	    // input
	    $server = $_REQUEST["server"];
	    $user   = $_REQUEST["user"];
	    $to     = $_REQUEST["to"];
	    
	    try {
	        // pré validação
	        if($server == ""){
	            throw new Exception("Servidor vazio");
	        }
	        if($user == ""){
	            throw new Exception("Usuário vazio");
	        }
	        if($to == ""){
	            throw new Exception("Destinatário vazio");
	        }
	        
    	    // dados do smtp
    	    $mail = new OutputMail();
    	    
    	    // assunto
    	    $mail->setSubject("Teste de Envio");
    	    
    	    // remetente
    	    $from = new MailAddress();
    	    $from->setName("Não Responda");
    	    $from->setEmail($user);
    	    $mail->setFrom($from);
    	    
    	    // destinatários
    	    $mail->addRecipient(new MailAddress($to,"Destino 1",MailAddress::TYPE_TO));
    	    
    	    // mensagem
    	    $file = \zion\ROOT."tpl/email-test.html";
    	    $mail->body = file_get_contents($file);
    	    $mail->bodyContentType = "text/html";
    	    
    	    // tentando enviar
    	    Sender::send($user, $mail);
	        
	        HTTPUtils::status(200);
	        echo "E-mail enviado";
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
}
?>