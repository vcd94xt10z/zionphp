<?php
namespace zion\mod\sslgen\controller;

use zion\core\Page;
use zion\core\AbstractController;
use zion\orm\ObjectVO;

/**
 * @author Vinicius Cesar Dias
 * @since 11/05/2019
 */
class SSLGenController extends AbstractController {
    public function __construct(){
        parent::__construct(get_class($this));
    }
    
    public function actionExec(){
        $obj = new ObjectVO($_POST);
        
        $folder = rtrim($obj->get("folder"),"/")."/";
        
        // dados da CA
        $cmd = array();
        
        $cmd[] = "rm -rf ".$folder;
        $cmd[] = "mkdir ".$folder;
        $cmd[] = "chmod -Rf 777 ".$folder;
        $cmd[] = "cd ".$folder;
        
        // chave privada da CA
        $cmd[] = "openssl genrsa -des3 -passout pass:{$obj->get("ca_password")} -out {$obj->get("ca_name")}.key 2048";
        
        // certificado root da CA
        $line  = "openssl req -x509 -new -nodes -key {$obj->get("ca_name")}.key -sha256 -days 1825 ";
        $line .= "-passin pass:{$obj->get("ca_password")} -subj \"/C={$obj->get("ca_country")}/ST={$obj->get("ca_state")}/L={$obj->get("ca_city")}/O={$obj->get("ca_org")}/CN={$obj->get("ca_domain")}\" ";
        $line .= "-out {$obj->get("ca_name")}.pem";
        $cmd[] = $line;
        
        // convertendo para crt para ser instalado no windows
        $cmd[] = "openssl x509 -outform der -in {$obj->get("ca_name")}.pem -out {$obj->get("ca_name")}.crt";
        
        // retornando
        header("Content-Type: plain/text");
        echo implode("\n",$cmd);
    }
    
    public function actionHome(){
        Page::setTitle("Gerador de Certificados");
        $this->view("home");
    }
}
?>