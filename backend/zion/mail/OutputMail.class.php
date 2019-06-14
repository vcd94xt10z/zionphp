<?php 
namespace zion\mail;

/**
 * Dados de um e-mail para ser enviado
 * @author Vinicius
 */
class OutputMail {
    public $from;
    public $recipients = [];
    public $subject; 
    public $body;
    public $bodyContentType = "text/html";
    public $attachmentFileList = [];
    public $embeddedImageList = [];
    
    public function getRecipientsString(){
        $list = array();
        foreach($this->recipients AS $rec){
            if($rec->getName() != ""){
                $list[] = $rec->getName()." ".$rec->getEmail();
            }else{
                $list[] = $rec->getEmail();
            }
        }
        return implode(", ",$list);
    }
    
    public function addRecipient($obj){
        $this->recipients[] = $obj;
    }
    
    public function addAttachment($attachment){
        $this->attachmentFileList[] = $attachment;
    }
    
    public function addEmbeddedImageList($image){
        $this->embeddedImageList[] = $image;
    }
}
?>