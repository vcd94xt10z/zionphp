<?php
namespace zion\mod\mail\model;

use Exception;
use DateTime;
use zion\core\System;
use zion\mail\OutputMail;
use zion\mail\MailManager;
use zion\orm\ObjectVO;

/**
 * Envia e-mail considerando as cotas
 * @author Vinicius
 */
class Sender {
    public static function send($user, OutputMail $mail){
        $db        = System::getConnection();
        $serverDAO = System::getDAO($db,"zion_mail_server");
        $userDAO   = System::getDAO($db,"zion_mail_user");
        $quotaDAO  = System::getDAO($db,"zion_mail_quota");
        
        // usuário
        $userObj = $userDAO->getObject($db,array("user" => $user));
        if($userObj == null){
            throw new Exception("Usuário {$user} não encontrado");
        }
        
        // servidor
        $serverObj = $serverDAO->getObject($db,array("server" => $userObj->get("server")));
        if($serverObj == null){
            throw new Exception("Servidor {$userObj->get("server")} não encontrado");
        }
        
        // cotas
        $keys = array(
            "user" => $userObj->get("user"),
            "date" => new DateTime(),
            "hour" => intval(date("H"))
        );
        $quotaObj = $quotaDAO->getObject($db,$keys);
        
        if($quotaObj != null){
            if($quotaObj->get("total") > $userObj->get("hourly_quota")){
                throw new Exception("Quota excedida");
            }
        }
        
        // enviando e-mail
        $data = array(
            "host"     => $serverObj->get("smtp_host"),
            "auth"     => ($serverObj->get("smtp_auth") == 1),
            "user"     => $userObj->get("user"),
            "password" => $userObj->get("password"),
            "port"     => $serverObj->get("smtp_port"),
            "secure"   => $serverObj->get("smtp_secure")
        );
        
        $resultCode = "";
        $resultMessage = "";
        try {
            $mm = new MailManager($data);
            $mm->send($mail);
            $resultCode = "S";
        }catch(Exception $e){
            $resultCode = "E";
            $resultMessage = $e->getMessage();
        }
        
        // contabilizando cota
        if($quotaObj == null){
            $quotaObj = new ObjectVO();
            $quotaObj->set("mandt",0);
            $quotaObj->set("user",$userObj->get("user"));
            $quotaObj->set("server",$userObj->get("server"));
            $quotaObj->set("date",new DateTime());
            $quotaObj->set("hour",intval(date("H")));
            $quotaObj->set("updated_at",null);
            $quotaObj->set("total",1);
            $quotaDAO->insert($db, $quotaObj);
        }else{
            $quotaObj->inc("total",1);
            $quotaObj->set("updated_at",new DateTime());
            $quotaDAO->update($db, $quotaObj);
        }
        
        // log
        $logDAO  = System::getDAO($db,"zion_mail_send_log");
        
        $log = new ObjectVO();
        $log->set("mandt",0);
        $log->set("logid",$logDAO->getNextId($db, "mail-logid"));
        $log->set("created",new DateTime());
        $log->set("server",$serverObj->get("server"));
        $log->set("user",$userObj->get("user"));
        $log->set("from",$mail->getFrom()->getEmail());
        $log->set("to",$mail->getRecipientsString());
        $log->set("subject",$mail->getSubject());
        $log->set("content_type",$mail->bodyContentType);
        $log->set("content_body_size",strlen($mail->body));
        $log->set("attachment_count",sizeof($mail->attachmentFileList));
        $log->set("result",$resultCode);
        $log->set("result_message",$resultMessage);
        $logDAO->insert($db,$log);
        
        if($resultCode == "E"){
            throw new Exception($resultMessage);
        }
    }
}
?>