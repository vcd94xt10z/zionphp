<?php 
namespace zion\utils;

use zion\orm\ObjectVO;
use zion\core\System;

/**
 * @author Vinicius Cesar Dias
 */
class SSL {
    /**
     * Gerando arquivos para gerar os certificados
     * @param ObjectVO $obj
     * @return string[]
     */
    public static function gen(ObjectVO $obj){
        // dados
        $linesScriptCA   = array();
        $linesScriptSite = array();
        $linesExt        = array();
        $linesVhosts     = array();
        $linesInfo       = array();
        
        $linesScriptCA[] = "#!/bin/bash";
        $linesScriptCA[] = "";
        
        // arquivo de configuração
        $altDNS = explode("\n",$obj->get("site_alt_dns"));
        $altIP  = explode("\n",$obj->get("site_alt_ip"));
        
        $linesExt[] = "authorityKeyIdentifier=keyid,issuer";
        $linesExt[] = "basicConstraints=CA:FALSE";
        $linesExt[] = "keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment";
        $linesExt[] = "subjectAltName = @alt_names";
        $linesExt[] = "";
        $linesExt[] = "[alt_names]";
        $i=1;
        foreach($altDNS AS $alt){
            if(trim($alt) == ""){
                continue;
            }
            $linesExt[] = "DNS.{$i} = {$alt}";
            $i++;
        }
        $i=1;
        foreach($altIP AS $alt){
            if(trim($alt) == ""){
                continue;
            }
            $linesExt[] = "IP.{$i} = {$alt}";
            $i++;
        }
        
        // chave privada da CA
        $linesScriptCA[] = "openssl genrsa -des3 -passout pass:{$obj->get("ca_password")} -out {$obj->get("ca_name")}.key 2048";
        
        // certificado root da CA
        $line  = "openssl req -x509 -new -nodes -key {$obj->get("ca_name")}.key -sha256 -days 36500 ";
        $line .= "-passin pass:{$obj->get("ca_password")} -subj \"/C={$obj->get("ca_country")}/ST={$obj->get("ca_state")}/L={$obj->get("ca_city")}/O={$obj->get("ca_org")}/CN={$obj->get("ca_domain")}\" ";
        $line .= "-out {$obj->get("ca_name")}.pem";
        $linesScriptCA[] = $line;
        
        // convertendo para crt para ser instalado no windows
        $linesScriptCA[] = "openssl x509 -outform der -in {$obj->get("ca_name")}.pem -out {$obj->get("ca_name")}.crt";
        
        // chave privada do site
        $linesScriptSite[] = "#!/bin/bash";
        $linesScriptSite[] = "";
        $linesScriptSite[] = "openssl genrsa -out {$obj->get("site_domain")}.key 2048";
        
        // certificado do site
        $line  = "openssl req -new -key {$obj->get("site_domain")}.key ";
        $line .= "-subj \"/C={$obj->get("site_country")}/ST={$obj->get("site_state")}/L={$obj->get("site_city")}/O={$obj->get("site_org")}/CN={$obj->get("site_domain")}\" ";
        $line .= "-out {$obj->get("site_domain")}.csr";
        $linesScriptSite[] = $line;
        
        // gerando certificado do site emitido pela CA
        $line  = "openssl x509 -req -in {$obj->get("site_domain")}.csr -CA {$obj->get("ca_name")}.pem ";
        $line .= "-CAkey {$obj->get("ca_name")}.key -CAcreateserial -out {$obj->get("site_domain")}.crt -days 36500 ";
        $line .= "-passin pass:{$obj->get("ca_password")} -sha256 -extfile {$obj->get("site_domain")}.ext";
        $linesScriptSite[] = $line;
        
        $linesVhosts[] = "&lt;VirtualHost *:443&gt;";
        $linesVhosts[] = "  ServerName {$obj->get("site_domain")}";
        
        foreach($altDNS AS $alt){
            if(trim($alt) == ""){
                continue;
            }
            $linesVhosts[] = "  ServerAlias {$alt}";
        }
        foreach($altIP AS $alt){
            if(trim($alt) == ""){
                continue;
            }
            $linesVhosts[] = "  ServerAlias {$alt}";
        }
        
        $linesVhosts[] = "  DocumentRoot \"/webserver/sites/{$obj->get("site_domain")}/public\"";
        $linesVhosts[] = "";
        $linesVhosts[] = "  SetEnv HTTPS on";
        $linesVhosts[] = "  SSLEngine on";
        $linesVhosts[] = "  SSLCertificateFile /webserver/ssl/{$obj->get("site_domain")}/localhost.crt";
        $linesVhosts[] = "  SSLCertificateKeyFile /webserver/ssl/{$obj->get("site_domain")}/localhost.key";
        $linesVhosts[] = "  SSLCACertificateFile /webserver/ssl/{$obj->get("site_domain")}/localCA.pem";
        $linesVhosts[] = "";
        $linesVhosts[] = "  &lt;Directory \"/webserver/sites/{$obj->get("site_domain")}/public\"&gt;";
        $linesVhosts[] = "    Require all granted";
        $linesVhosts[] = "    AllowOverride All";
        $linesVhosts[] = "    Order allow,deny";
        $linesVhosts[] = "    Allow from all";
        $linesVhosts[] = "  &lt;/Directory&gt;";
        $linesVhosts[] = "&lt;/VirtualHost&gt;";
        
        // arquivo de informações
        $linesInfo[] = "created ".date("d/m/Y H:i:s")." ".System::get("timezone");
        $linesInfo[] = "ca password = ".$obj->get("ca_password");
        
        $output = array();
        $output["scriptCA"] = array(
            "filename" => "certs_ca.sh",
            "content"  => implode("\n",$linesScriptCA)
        );
        $output["scriptSite"] = array(
            "filename" => "certs_site.sh",
            "content"  => implode("\n",$linesScriptSite)
        );
        $output["ext"] = array(
            "filename" => "{$obj->get("site_domain")}.ext",
            "content"  => implode("\n",$linesExt)
        );
        $output["vhost"] = array(
            "filename" => "{$obj->get("site_domain")}.conf",
            "content"  => implode("\n",$linesVhosts)
        );
        $output["info"] = array(
            "filename" => "info.txt",
            "content"  => implode("\n",$linesInfo)
        );
        
        return $output;
    }
}
?>