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
        $line  = "openssl req -x509 -new -nodes -key {$obj->get("ca_name")}.key -sha256 -days 36500 ";
        $line .= "-passin pass:{$obj->get("ca_password")} -subj \"/C={$obj->get("ca_country")}/ST={$obj->get("ca_state")}/L={$obj->get("ca_city")}/O={$obj->get("ca_org")}/CN={$obj->get("ca_domain")}\" ";
        $line .= "-out {$obj->get("ca_name")}.pem";
        $cmd[] = $line;
        
        // convertendo para crt para ser instalado no windows
        $cmd[] = "openssl x509 -outform der -in {$obj->get("ca_name")}.pem -out {$obj->get("ca_name")}.crt";
        
        // chave privada do site
        $cmd[] = "openssl genrsa -out {$obj->get("site_domain")}.key 2048";
        
        // certificado do site
        $line  = "openssl req -new -key {$obj->get("site_domain")}.key ";
        $line .= "-subj \"/C={$obj->get("site_country")}/ST={$obj->get("site_state")}/L={$obj->get("site_city")}/O={$obj->get("site_org")}/CN={$obj->get("site_domain")}\" ";
        $line .= "-out {$obj->get("site_domain")}.csr";
        $cmd[] = $line;
        
        // arquivo de configuração
        $altDNS = explode("\n",$obj->get("site_alt_dns"));
        $altIP  = explode("\n",$obj->get("site_alt_ip"));
        $cmd[] = "";
        $cmd[] = "---- {$obj->get("site_domain")}.ext ----";
        $cmd[] = "authorityKeyIdentifier=keyid,issuer";
        $cmd[] = "basicConstraints=CA:FALSE";
        $cmd[] = "keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment";
        $cmd[] = "subjectAltName = @alt_names";
        $cmd[] = "";
        $cmd[] = "[alt_names]";
        $i=1;
        foreach($altDNS AS $alt){
            if(trim($alt) == ""){
                continue;
            }
            $cmd[] = "DNS.{$i} = {$alt}";
            $i++;
        }
        $i=1;
        foreach($altIP AS $alt){
            if(trim($alt) == ""){
                continue;
            }
            $cmd[] = "IP.{$i} = {$alt}";
            $i++;
        }
        $cmd[] = "";
        
        // gerando certificado do site emitido pela CA
        $line  = "openssl x509 -req -in {$obj->get("site_domain")}.csr -CA {$obj->get("ca_name")}.pem ";
        $line .= "-CAkey {$obj->get("ca_name")}.key -CAcreateserial -out {$obj->get("site_domain")}.crt -days 36500 ";
        $line .= "-passin pass:{$obj->get("ca_password")} -sha256 -extfile {$obj->get("site_domain")}.ext";
        $cmd[] = $line;
        
        $cmd[] = "";
        $cmd[] = "---- {$obj->get("site_domain")}.conf ----";
        $cmd[] = "&lt;VirtualHost *:443&gt;";
        $cmd[] = "  ServerName {$obj->get("site_domain")}";
        
        foreach($altDNS AS $alt){
            if(trim($alt) == ""){
                continue;
            }
            $cmd[] = "  ServerAlias {$alt}";
        }
        foreach($altIP AS $alt){
            if(trim($alt) == ""){
                continue;
            }
            $cmd[] = "  ServerAlias {$alt}";
        }
        
        $cmd[] = "  DocumentRoot \"/webserver/sites/{$obj->get("site_domain")}/public\"";
        $cmd[] = "";
        $cmd[] = "  SetEnv HTTPS on";
        $cmd[] = "  SSLEngine on";
        $cmd[] = "  SSLCertificateFile /webserver/ssl/{$obj->get("site_domain")}/localhost.crt";
        $cmd[] = "  SSLCertificateKeyFile /webserver/ssl/{$obj->get("site_domain")}/localhost.key";
        $cmd[] = "  SSLCACertificateFile /webserver/ssl/{$obj->get("site_domain")}/localCA.pem";
        $cmd[] = "";
        $cmd[] = "  &lt;Directory \"/webserver/sites/{$obj->get("site_domain")}/public\"&gt;";
        $cmd[] = "    Require all granted";
        $cmd[] = "    AllowOverride All";
        $cmd[] = "    Order allow,deny";
        $cmd[] = "    Allow from all";
        $cmd[] = "  &lt;/Directory&gt;";
        $cmd[] = "&lt;/VirtualHost&gt;";
        
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