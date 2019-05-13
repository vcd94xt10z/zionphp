<?php 
namespace zion\utils;

use zion\orm\ObjectVO;

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
        $folder = $obj->get("folder");
        
        // dados
        $linesScript = array();
        $linesExt    = array();
        $linesVhosts = array();
        
        $linesScript[] = "run.sh";
        $linesScript[] = "#!/bin/bash";
        $linesScript[] = "";
        $linesScript[] = "rm -rf ".$folder;
        $linesScript[] = "mkdir ".$folder;
        $linesScript[] = "chmod -Rf 777 ".$folder;
        $linesScript[] = "cd ".$folder;
        
        // chave privada da CA
        $linesScript[] = "openssl genrsa -des3 -passout pass:{$obj->get("ca_password")} -out {$obj->get("ca_name")}.key 2048";
        
        // certificado root da CA
        $line  = "openssl req -x509 -new -nodes -key {$obj->get("ca_name")}.key -sha256 -days 36500 ";
        $line .= "-passin pass:{$obj->get("ca_password")} -subj \"/C={$obj->get("ca_country")}/ST={$obj->get("ca_state")}/L={$obj->get("ca_city")}/O={$obj->get("ca_org")}/CN={$obj->get("ca_domain")}\" ";
        $line .= "-out {$obj->get("ca_name")}.pem";
        $linesScript[] = $line;
        
        // convertendo para crt para ser instalado no windows
        $linesScript[] = "openssl x509 -outform der -in {$obj->get("ca_name")}.pem -out {$obj->get("ca_name")}.crt";
        
        // chave privada do site
        $linesScript[] = "openssl genrsa -out {$obj->get("site_domain")}.key 2048";
        
        // certificado do site
        $line  = "openssl req -new -key {$obj->get("site_domain")}.key ";
        $line .= "-subj \"/C={$obj->get("site_country")}/ST={$obj->get("site_state")}/L={$obj->get("site_city")}/O={$obj->get("site_org")}/CN={$obj->get("site_domain")}\" ";
        $line .= "-out {$obj->get("site_domain")}.csr";
        $linesScript[] = $line;
        
        // arquivo de configuração
        $altDNS = explode("\n",$obj->get("site_alt_dns"));
        $altIP  = explode("\n",$obj->get("site_alt_ip"));
        
        $linesExt[] = "{$obj->get("site_domain")}.ext";
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
        $linesExt[] = "";
        
        // gerando certificado do site emitido pela CA
        $line  = "openssl x509 -req -in {$obj->get("site_domain")}.csr -CA {$obj->get("ca_name")}.pem ";
        $line .= "-CAkey {$obj->get("ca_name")}.key -CAcreateserial -out {$obj->get("site_domain")}.crt -days 36500 ";
        $line .= "-passin pass:{$obj->get("ca_password")} -sha256 -extfile {$obj->get("site_domain")}.ext";
        $linesScript[] = $line;
        
        $linesVhosts[] = "{$obj->get("site_domain")}.conf";
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
        
        return array(
            "script" => implode("\n",$linesScript),
            "ext"    => implode("\n",$linesExt),
            "vhost"  => implode("\n",$linesVhosts)
        );
    }
}
?>