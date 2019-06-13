<?php
namespace zion\mod\mail\controller;

use Exception;
use zion\mail\MailAddress;
use zion\mail\MailManager;
use zion\mod\mail\standard\controller\UserController AS StandardUserController;
use zion\core\System;

/**
 * Classe gerada pelo Zion Framework em 12/06/2019
 */
class UserController extends StandardUserController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_mail_user"
		));
	}
	
	public function actionSendTest(){
	    // input
	    $server = $_GET["server"];
	    $user   = $_GET["user"];
	    $to     = $_GET["to"];
	    
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
    	    $subject = "Teste de e-mail";
    	    
    	    // remetente
    	    $from = new MailAddress();
    	    $from->setName("Não Responda");
    	    $from->setEmail($user);
    	    
    	    // destinatários
    	    $recipients = array();
    	    $recipients[] = new MailAddress($to,"Destino 1",MailAddress::TYPE_TO);
    	    
    	    // mensagem
    	    $body = "adf<strong>Teste</strong>sdf";
    	    $bodyContentType = "text/html";
    	    
    	    // anexos
    	    $attachmentFileList = [];
    	    
    	    // imagens embutidas
    	    $embeddedImageList = [];
    	    
    	    $data = array(
    	        "host"     => $server->get("smtp_host"),
    	        "auth"     => ($server->get("smtp_auth") == 1),
    	        "user"     => $user->get("user"),
    	        "password" => $user->get("password"),
    	        "port"     => $server->get("smtp_port"),
    	        "secure"   => $server->get("smtp_secure")
    	    );
    	    
    	    // tentando enviar
    	    $mm = new MailManager($data);
	        $mm->send($from, $recipients, $subject, $body, $bodyContentType, 
	            $attachmentFileList, $embeddedImageList);
	        
	        echo "E-mail enviado";
	    }catch(Exception $e){
	        echo $e->getMessage();
	    }
	}
}
?>