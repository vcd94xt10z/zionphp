<?php
namespace zion\mod\mail\controller;

use Exception;
use zion\mail\MailAddress;
use zion\mail\MailManager;
use zion\mod\mail\standard\controller\UserController AS StandardUserController;
use zion\core\Page;
use zion\core\System;
use zion\utils\HTTPUtils;

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
    	    $db        = System::getConnection();
    	    $serverDAO = System::getDAO($db,"zion_mail_server");
    	    $userDAO   = System::getDAO($db,"zion_mail_user");
    	    
    	    $serverObj = $serverDAO->getObject($db,array("server" => $server));
    	    if($serverObj == null){
    	        throw new Exception("Servidor {$server} não encontrado");
    	    }
    	    $userObj = $userDAO->getObject($db,array("user" => $user));
    	    if($userObj == null){
    	        throw new Exception("Usuário {$user} não encontrado");
    	    }
    	    
    	    // assunto
    	    $subject = "Teste de Envio";
    	    
    	    // remetente
    	    $from = new MailAddress();
    	    $from->setName("Não Responda");
    	    $from->setEmail($user);
    	    
    	    // destinatários
    	    $recipients = array();
    	    $recipients[] = new MailAddress($to,"Destino 1",MailAddress::TYPE_TO);
    	    
    	    // mensagem
    	    $file = \zion\ROOT."tpl/email-test.html";
    	    $body = file_get_contents($file);
    	    $bodyContentType = "text/html";
    	    
    	    // anexos
    	    $attachmentFileList = [];
    	    
    	    // imagens embutidas
    	    $embeddedImageList = [];
    	    
    	    $data = array(
    	        "host"     => $serverObj->get("smtp_host"),
    	        "auth"     => ($serverObj->get("smtp_auth") == 1),
    	        "user"     => $userObj->get("user"),
    	        "password" => $userObj->get("password"),
    	        "port"     => $serverObj->get("smtp_port"),
    	        "secure"   => $serverObj->get("smtp_secure")
    	    );
    	    
    	    // tentando enviar
    	    $mm = new MailManager($data);
	        $mm->send($from, $recipients, $subject, $body, $bodyContentType, 
	            $attachmentFileList, $embeddedImageList);
	        
	        HTTPUtils::status(200);
	        echo "E-mail enviado";
	    }catch(Exception $e){
	        HTTPUtils::status(500);
	        echo $e->getMessage();
	    }
	}
}
?>