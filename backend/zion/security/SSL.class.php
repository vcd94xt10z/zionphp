<?php 
namespace zion\security;

use Exception;
use zion\orm\ObjectVO;
use zion\core\System;

/**
 * @author Vinicius Cesar Dias
 */
class SSL {
    public static function script(ObjectVO $obj){
        $codeExt   = self::createExt($obj);
        $codeCerts = self::createCertsSite($obj,false);
        $codeVhost = self::createVhost($obj);
        
        // verificando se a CA foi informada
        if($obj->get("ca_name") == null){
            throw new Exception("Falta parâmetro ca_nome");
        }
        if($obj->get("ca_password") == null){
            throw new Exception("Falta parâmetro ca_password");
        }
        if($obj->get("ca_domain") == null){
            throw new Exception("Falta parâmetro ca_domain");
        }
        
        $folder   = "/webserver/ca/";
        $folderCA = $folder.$obj->get("ca_domain")."/";
        
        if(!file_exists($folder)){
            throw new Exception("O diretório ".$folder." não existe");
        }
        if(!file_exists($folderCA)){
            throw new Exception("O diretório ".$folderCA." não existe");
        }
        
        $code = array();
        $code[]= "#!/bin/bash";
        $code[]= "";
        
        $code[]= "# arquivo gerado em ".date("d/m/Y H:i:s")." ".System::get("timezone");
        
        $code[]= "";
        $code[]= "clear";
        
        $code[]= "";
        $code[]= "# diretório de trabalho";
        $code[]= "cd /webserver/ca/";
        
        $code[]= "";
        $code[]= "# variáveis";
        $code[] = "CA_NAME=\"".$obj->get("ca_name")."\"";
        $code[] = "CA_PASSWORD=\"".$obj->get("ca_password")."\"";
        $code[] = "CA_DOMAIN=".$obj->get("ca_domain");
        $code[] = "SITE_NAME=\"".$obj->get("site_name")."\"";
        $code[] = "SITE_DOMAIN=".$obj->get("site_domain");
        $code[] = "SITE_COUNTRY=\"".$obj->get("site_country")."\"";
        $code[] = "SITE_STATE=\"".$obj->get("site_state")."\"";
        $code[] = "SITE_CITY=\"".$obj->get("site_city")."\"";
        $code[] = "SITE_ORG=\"".$obj->get("site_org")."\"";
        
        $code[]= "";
        $code[]= "# gerando diretórios";
        $code[]= "mkdir {$obj->get("site_domain")}";
        
        $code[]= "";
        $code[]= "# arquivo de configuração para gerar o certificado";
        $code[]= "echo '".$codeExt."' >{$obj->get("site_domain")}/site.ext";
        
        $code[]= "";
        $code[]= "# gerar vhost apache";
        $code[]= "echo '".$codeVhost."' >{$obj->get("site_domain")}/site.conf";
        
        $code[]= "";
        $code[]= "# gerar certificados";
        $code[]= $codeCerts;
        
        $code[]= "";
        $code[]= "# permissões";
        $code[]= "chmod -Rf 777 *";
        
        return implode("\n",$code);
    }
    
    public static function createCertsCA(ObjectVO $obj,$putVars=false){
        $script = array();
        
        if($putVars){
            $script[] = "";
            $script[] = "CA_PASSWORD=\"".$obj->get("ca_password")."\"";
            $script[] = "CA_NAME=\"".$obj->get("ca_name")."\"";
            
            $script[] = "CA_COUNTRY=\"".$obj->get("ca_country")."\"";
            $script[] = "CA_STATE=\"".$obj->get("ca_state")."\"";
            $script[] = "CA_CITY=\"".$obj->get("ca_city")."\"";
            $script[] = "CA_ORG=\"".$obj->get("ca_org")."\"";
            $script[] = "CA_DOMAIN=".$obj->get("ca_domain");
        }
        
        // chave privada da CA
        $script[] = "";
        $script[] = "echo -- Gerando ca.key";
        $script[] = "openssl genrsa -des3 -passout pass:\$CA_PASSWORD -out \$CA_DOMAIN/ca.key 2048";
        
        // certificado root da CA
        $script[] = "";
        $script[] = "echo -- Gerando ca.pem";
        $line  = "openssl req -x509 -new -nodes -key \$CA_DOMAIN/ca.key -sha256 -days 36500 ";
        $line .= "-passin pass:\$CA_PASSWORD -subj \"/C=\$CA_COUNTRY/ST=\$CA_STATE/L=\$CA_CITY/O=\$CA_ORG/CN=\$CA_DOMAIN/CN=\$CA_NAME\" ";
        $line .= "-out \$CA_DOMAIN/ca.pem";
        $script[] = $line;
        
        // convertendo para crt para ser instalado no windows
        $script[] = "";
        $script[] = "echo -- Gerando ca.crt";
        $script[] = "openssl x509 -outform der -in \$CA_DOMAIN/ca.pem -out \$CA_DOMAIN/ca.crt";
        
        return implode("\n",$script);
    }
    
    public static function createCertsSite(ObjectVO $obj,$putVars=false){
        $script = array();
        
        if($putVars){
            $script[] = "CA_PASSWORD=\"".$obj->get("ca_password")."\"";
            $script[] = "CA_DOMAIN=".$obj->get("ca_domain");
            
            $script[] = "SITE_NAME=\"".$obj->get("site_name")."\"";
            $script[] = "SITE_DOMAIN=".$obj->get("site_domain");
            $script[] = "SITE_COUNTRY=\"".$obj->get("site_country")."\"";
            $script[] = "SITE_STATE=\"".$obj->get("site_state")."\"";
            $script[] = "SITE_CITY=\"".$obj->get("site_city")."\"";
            $script[] = "SITE_ORG=\"".$obj->get("site_org")."\"";
        }
        
        // chave privada do site
        $script[] = "";
        $script[] = "echo -- Gerando site.key";
        $script[] = "openssl genrsa -out \$SITE_DOMAIN/site.key 2048";
        
        // certificado do site
        $script[] = "";
        $script[] = "echo -- Gerando site.csr";
        $line  = "openssl req -new -key \$SITE_DOMAIN/site.key ";
        $line .= "-subj \"/C=\$SITE_COUNTRY/ST=\$SITE_STATE/L=\$SITE_CITY/O=\$SITE_ORG/CN=\$SITE_DOMAIN/CN=\$SITE_NAME\" ";
        $line .= "-out \$SITE_DOMAIN/site.csr";
        $script[] = $line;
        
        // gerando certificado do site emitido pela CA
        $script[] = "";
        $script[] = "echo -- Gerando site.crt";
        $line  = "openssl x509 -req -in \$SITE_DOMAIN/site.csr -CA \$CA_DOMAIN/ca.pem ";
        $line .= "-CAkey \$CA_DOMAIN/ca.key -CAcreateserial -out \$SITE_DOMAIN/site.crt -days 36500 ";
        $line .= "-passin pass:\$CA_PASSWORD -sha256 -extfile \$SITE_DOMAIN/site.ext";
        $script[] = $line;
        
        return implode("\n",$script);
    }
    
    public static function createExt(ObjectVO $obj){
        $lines = array();
        
        // arquivo de configuração
        $altDNS = explode("\n",$obj->get("site_alt_dns"));
        $altIP  = explode("\n",$obj->get("site_alt_ip"));
        
        $lines[] = "authorityKeyIdentifier=keyid,issuer";
        $lines[] = "basicConstraints=CA:FALSE";
        $lines[] = "keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment";
        $lines[] = "subjectAltName = @alt_names";
        $lines[] = "";
        $lines[] = "[alt_names]";
        $i=1;
        foreach($altDNS AS $alt){
            if(trim($alt) == ""){
                continue;
            }
            $lines[] = "DNS.{$i} = {$alt}";
            $i++;
        }
        $i=1;
        foreach($altIP AS $alt){
            if(trim($alt) == ""){
                continue;
            }
            $lines[] = "IP.{$i} = {$alt}";
            $i++;
        }
        
        return implode("\n",$lines);
    }
    
    public static function createVhost(ObjectVO $obj){
        $lines = array();
        
        // arquivo de configuração
        $altDNS = explode("\n",$obj->get("site_alt_dns"));
        $altIP  = explode("\n",$obj->get("site_alt_ip"));
        
        $lines[] = "<VirtualHost *:443>";
        $lines[] = "  ServerName {$obj->get("site_domain")}";
        
        foreach($altDNS AS $alt){
            if(trim($alt) == ""){
                continue;
            }
            $lines[] = "  ServerAlias {$alt}";
        }
        foreach($altIP AS $alt){
            if(trim($alt) == ""){
                continue;
            }
            $lines[] = "  ServerAlias {$alt}";
        }
        
        $lines[] = "  DocumentRoot \"/webserver/sites/{$obj->get("site_domain")}/public\"";
        $lines[] = "";
        $lines[] = "  SetEnv HTTPS on";
        $lines[] = "  SSLEngine on";
        $lines[] = "  SSLCertificateFile /webserver/ssl/{$obj->get("site_domain")}/localhost.crt";
        $lines[] = "  SSLCertificateKeyFile /webserver/ssl/{$obj->get("site_domain")}/localhost.key";
        $lines[] = "  SSLCACertificateFile /webserver/ssl/{$obj->get("site_domain")}/localCA.pem";
        $lines[] = "";
        $lines[] = "  <Directory \"/webserver/sites/{$obj->get("site_domain")}/public\">";
        $lines[] = "    Require all granted";
        $lines[] = "    AllowOverride All";
        $lines[] = "    Order allow,deny";
        $lines[] = "    Allow from all";
        $lines[] = "  </Directory>";
        $lines[] = "</VirtualHost>";
        
        return implode("\n",$lines);
    }
    
    public static function createInfo(ObjectVO $obj){
        $lines = array();
        $lines[] = "created ".date("d/m/Y H:i:s")." ".System::get("timezone");
        $lines[] = "ca password = ".$obj->get("ca_password");
        return implode("\n",$lines);
    }
}
?>