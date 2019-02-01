<?php
namespace zion\mail;

/**
 * @author Vinicius Cesar Dias
 */
class Mail {
	private $headers;
	private $subject;
	private $date;
	private $from;
	private $recipients;
	private $parts;
	private $eml;
	
	public function __construct(){
		$this->headers = array();
		$this->recipients = array();
		$this->parts = array();
		$this->from = new MailAddress();
	}
	
	public function setHeaders(array $headers){
		$this->headers = $headers;
	}

	public function getHeaders(){
		return $this->headers;
	}
	
	public function addHeader($key,$value){
		$this->headers[$key] = $value;
	}

	public function setSubject($subject){
		$this->subject = $subject;
	}

	public function getSubject(){
		return $this->subject;
	}

	public function setDate($date){
		$this->date = $date;
	}

	public function getDate(){
		return $this->date;
	}

	public function setRecipients(array $recipients){
		$this->recipients = $recipients;
	}

	public function getRecipients($type=""){
		if($type == ""){
			return $this->recipients;
		}
		$output = array();
		foreach($this->recipients AS $obj){
			if($obj->getType() == $type){
				$output[] = $obj;
			}
		}
		return $output;
	}
	
	public function getRecipientsString($type=""){
		$output = $this->getRecipients($type);
		$output2 = array();
		foreach($output AS $obj){
			$output2[] = $obj->toString();
		}
		return implode(";",$output2);
	}
	
	public function addRecipient(MailAddress $obj){
		$this->recipients[] = $obj;
	}

	public function setFrom(MailAddress $obj){
		$this->from = $obj;
	}
	
	public function getFrom(){
		return $this->from;
	}
	
	public function setParts(array $parts){
		$this->parts = $parts;
	}

	public function getParts(){
		return $this->parts;
	}
	
	public function addPart(MailPart $obj){
		$this->parts[] = $obj;
	}
	
	public function getEML(){
		return $this->eml;
	}
	public function setEML($eml){
		$this->eml = $eml;
	}
	
	public function getAttachments(){
		$output = array();
		foreach($this->parts AS $part){
			if(mb_strlen($part->getName()) > 0){
				$output[] = EMLParser::createAttachmentByPart($part);
			}
		}
		return $output;
	}
	
	public function getAttachmentByMD5($md5){
		foreach($this->parts AS $part){
			if(md5($part->getContent()) == $md5){
				return EMLParser::createAttachmentByPart($part);
			}
		}
		return null;
	}
	
	public function getBody($contentType="text/html"){
		foreach($this->parts AS $part){
			if($part->getContentType() == $contentType){
				return $part->getContent();
			}
		}
		return "";
	}
	
	/**
	 * Procura o corpo principal do e-mail
	 */
	public function getMainBody(){
		$bodyHTML = $this->getBodyHTML();
		$bodyText = $this->getBodyText();
		
		if(mb_strlen($bodyHTML) > 0){
			return $bodyHTML;
		}
		if(mb_strlen($bodyText) > 0){
			return $bodyText;
		}
		return "";
	}
	
	public function getBodyHTML(){
		return $this->getBody("text/html");
	}
	
	public function getBodyText(){
		$content = $this->getBody("plain/text");
		if($content == ""){
			return $this->getBody("text/plain");
		}
		return "";
	}
}
?>