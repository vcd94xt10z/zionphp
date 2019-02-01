<?php
namespace zion\mail;

require_once(\zion\ROOT.'vendor/PHPMailer/src/Exception.php');
require_once(\zion\ROOT.'vendor/PHPMailer/src/PHPMailer.php');
require_once(\zion\ROOT.'vendor/PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;

use Exception;

/**
 * @author Vinicius Cesar Dias
 */
class MailManager {
	private $phpMailer = null;
	private $charset = "UTF-8";

	public function __construct($data){
    	$this->phpMailer = new PHPMailer(true);
		$this->phpMailer->CharSet = $this->charset;
		$this->phpMailer->IsSMTP();
		//$this->phpMailer->SMTPDebug = 1;
		if(array_key_exists("debug",$data) && $data["debug"] > 0){
			$this->phpMailer->SMTPDebug = $data["debug"];
		}
		$this->phpMailer->Host 	   = $data["host"];
		$this->phpMailer->SMTPAuth = $data["auth"];
		$this->phpMailer->Username = $data["user"];
		$this->phpMailer->Password = $data["password"];
		$this->phpMailer->Port     = $data["port"];
		$this->phpMailer->SMTPSecure = $data["secure"];
		$this->phpMailer->WordWrap = 100;
		//$this->phpMailer->SetLanguage("br");
		//$this->phpMailer->SMTPSecure = "tls";
		$this->phpMailer->IsHTML(true);

		$options = array();
		$options["ssl"] = array (
			"verify_peer" => false,
			"verify_peer_name" => false,
			"allow_self_signed" => true
		);
		$this->phpMailer->SMTPOptions = $options;
    }

	public function sendPHPMail(MailAddress $from, array $recipients, $subject, $body,
			$bodyContentType = "text/html",$attachmentFileList = array(),$embeddedImageList=array()){
		// colocando remetente como resposta
		$reply = new MailAddress();
		$reply->setEmail($from->getEmail());
		$reply->setType("RPL");
		if($from->getEmail() == ""){
			$reply->setEmail(APP_EMAIL);
		}
		$recipients[] = $reply;
		$this->phpMailer->From = $this->phpMailer->Username;
		$this->phpMailer->FromName = $from->getName();
		$this->phpMailer->Subject = stripslashes($subject);

		$toCounter = 0;
		$recipientsStringArray = array();
		foreach($recipients AS $emailAddress){
			if($emailAddress == null || !($emailAddress instanceof MailAddress)
				|| $emailAddress->getEmail() == "" || $emailAddress->getEmail() == "sem@email"){
				continue;
			}
			switch($emailAddress->getType()){
			case "TO": // destinatário
			default:
				$this->phpMailer->AddAddress($emailAddress->getEmail(),$emailAddress->getName());
				$toCounter++;
				break;
			case "CC": // cópia
				$this->phpMailer->AddCC($emailAddress->getEmail(),$emailAddress->getName());
				break;
			case "BCC": // cópia oculta
				$this->phpMailer->AddBCC($emailAddress->getEmail(),$emailAddress->getName());
				break;
			case "RPL": // email de resposta
				$this->phpMailer->AddReplyTo($emailAddress->getEmail(),$emailAddress->getName());
				break;
			case "CNF": // confirmação de leitura
				$this->ConfirmReadingTo = $emailAddress->getEmail();
				break;
			}

			$recipientsStringArray[] = "[".$emailAddress->getType()."] ".$emailAddress->getEmail();
		}

		// verificando se o email tem ao menos um destinatário
		if($toCounter == 0){
			throw new Exception("Nenhum destinatário informado.");
		}

		// anexos
		foreach($attachmentFileList AS $attachment){
			if($attachment instanceof MailAttachment){
				$this->phpMailer->AddAttachment($attachment->getPath(), $attachment->getName(),
						"base64", $attachment->getContentType());
			}else{
				$this->phpMailer->AddAttachment($attachment);
			}
		}

		// imagens incorporadas
		foreach($embeddedImageList AS $emb){
			$this->phpMailer->AddEmbeddedImage($emb["file"],$emb["cid"]);
		}

		$this->phpMailer->ContentType = $bodyContentType;
		if($bodyContentType == "text/html"){
			$this->phpMailer->IsHTML(true);
		}else{
			$this->phpMailer->IsHTML(false);
		}

		$this->phpMailer->Body = $body;

		// enviando
		if(!$this->phpMailer->Send()){
			$errorMessage = $this->phpMailer->ErrorInfo;
			try {
				$this->phpMailer->SmtpClose();
			}catch(Exception $e){
			}
			throw new Exception($errorMessage);
		}
		$this->phpMailer->SmtpClose();
	}
}
?>
