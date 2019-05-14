<?php 
namespace zion\utils;

use zion\orm\ObjectVO;
use zion\core\System;

/**
 * @author Vinicius Cesar Dias
 */
class SSL {
    public static function script(ObjectVO $obj){
        $data  = self::gen($obj);
        
        $code  = array();
        $code[]= "#!/bin/bash";
        $code[]= "";
        
        $code[]= "# arquivo gerado em ".date("d/m/Y H:i:s")." ".System::get("timezone");
        
        $code[]= "";
        $code[]= "# gerando diretório do certificado";
        $code[]= "mkdir {$obj->get("site_domain")}";
        
        $code[]= "";
        $code[]= "# arquivo de configuração para gerar o certificado";
        $code[]= "echo '".$data["ext"]."' >{$obj->get("site_domain")}/site.ext";
        
        $code[]= "";
        $code[]= "# gerar vhost apache";
        $code[]= "echo '".$data["vhost"]."' >{$obj->get("site_domain")}/site.conf";
        
        $code[]= "";
        $code[]= "func_gerar_cert_ca(){";
        $code[]= $data["scriptCA"];
        $code[]= "}";
        
        $code[]= "";
        $code[]= "func_gerar_cert_site(){";
        $code[]= $data["scriptSite"];
        $code[]= "}";
        
        $code[]= "";
        $code[]= "# gerar cert ca";
        $code[]= "func_gerar_cert_ca";
        
        $code[]= "";
        $code[]= "# gerar cert site";
        $code[]= "func_gerar_cert_site";
        
        $code[]= "";
        $code[]= "# permissões";
        $code[]= "chmod -Rf 777 *";
        
        return implode("\n",$code);
    }
    
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
        $linesScriptCA[] = "CA_PASSWORD=".$obj->get("ca_password");
        $linesScriptCA[] = "CA_NAME=".$obj->get("ca_name");
        
        $linesScriptCA[] = "CA_COUNTRY=".$obj->get("ca_country");
        $linesScriptCA[] = "CA_STATE=".$obj->get("ca_state");
        $linesScriptCA[] = "CA_CITY=".$obj->get("ca_city");
        $linesScriptCA[] = "CA_ORG=".$obj->get("ca_org");
        $linesScriptCA[] = "CA_DOMAIN=".$obj->get("ca_domain");
        $linesScriptCA[] = "openssl genrsa -des3 -passout pass:\$CA_PASSWORD -out \$CA_NAME.key 2048";
        
        // certificado root da CA
        $line  = "openssl req -x509 -new -nodes -key \$CA_NAME.key -sha256 -days 36500 ";
        $line .= "-passin pass:\$CA_PASSWORD -subj \"/C=\$CA_COUNTRY/ST=\$CA_STATE/L=\$CA_CITY/O=\$CA_ORG/CN=\$CA_DOMAIN\" ";
        $line .= "-out \$CA_NAME.pem";
        $linesScriptCA[] = $line;
        
        // convertendo para crt para ser instalado no windows
        $linesScriptCA[] = "openssl x509 -outform der -in \$CA_NAME.pem -out \$CA_NAME.crt";
        
        // chave privada do site
        $linesScriptSite[] = "CA_PASSWORD=".$obj->get("ca_password");
        $linesScriptSite[] = "CA_NAME=".$obj->get("ca_name");
        
        $linesScriptSite[] = "SITE_DOMAIN=".$obj->get("site_domain");
        $linesScriptSite[] = "SITE_COUNTRY=".$obj->get("site_country");
        $linesScriptSite[] = "SITE_STATE=".$obj->get("site_state");
        $linesScriptSite[] = "SITE_CITY=".$obj->get("site_city");
        $linesScriptSite[] = "SITE_ORG=".$obj->get("site_org");
        
        $linesScriptSite[] = "openssl genrsa -out \$SITE_DOMAIN/site.key 2048";
        
        // certificado do site
        $line  = "openssl req -new -key \$SITE_DOMAIN/site.key ";
        $line .= "-subj \"/C=\$SITE_COUNTRY/ST=\$SITE_STATE/L=\$SITE_CITY/O=\$SITE_ORG/CN=\$SITE_DOMAIN\" ";
        $line .= "-out \$SITE_DOMAIN/site.csr";
        $linesScriptSite[] = $line;
        
        // gerando certificado do site emitido pela CA
        $line  = "openssl x509 -req -in \$SITE_DOMAIN/site.csr -CA \$CA_NAME.pem ";
        $line .= "-CAkey \$CA_NAME.key -CAcreateserial -out \$SITE_DOMAIN/site.crt -days 36500 ";
        $line .= "-passin pass:\$CA_PASSWORD -sha256 -extfile \$SITE_DOMAIN/site.ext";
        $linesScriptSite[] = $line;
        
        $linesVhosts[] = "<VirtualHost *:443>";
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
        $linesVhosts[] = "  <Directory \"/webserver/sites/{$obj->get("site_domain")}/public\">";
        $linesVhosts[] = "    Require all granted";
        $linesVhosts[] = "    AllowOverride All";
        $linesVhosts[] = "    Order allow,deny";
        $linesVhosts[] = "    Allow from all";
        $linesVhosts[] = "  </Directory>";
        $linesVhosts[] = "</VirtualHost>";
        
        // arquivo de informações
        $linesInfo[] = "created ".date("d/m/Y H:i:s")." ".System::get("timezone");
        $linesInfo[] = "ca password = ".$obj->get("ca_password");
        
        $output = array(
            "scriptCA"   => implode("\n",$linesScriptCA),
            "scriptSite" => implode("\n",$linesScriptSite),
            "ext"        => implode("\n",$linesExt),
            "vhost"      => implode("\n",$linesVhosts),
            "info"       => implode("\n",$linesInfo)
        );
        return $output;
    }
}
?>