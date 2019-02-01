<?php
namespace zion\util;

/**
 * @author Vinicius Cesar Dias
 */
class HTTPUtils {
    public static function addRandomParam($url) : string {
        if(strpos($url,"?") === false){
            $url .= "?r=".date("YmdHis");
        }else{
            $url .= "&r=".date("YmdHis");
        }
        return $url;
    }
    
    /**
     * Tenta Obter o IP real do cliente
     * @return string
     * @see http://rubsphp.blogspot.com.br/2010/12/obter-o-ip-do-cliente.html
     */
    public static function getClientIP()
    {
        if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
            $ip = trim($_SERVER['HTTP_CLIENT_IP']);
            if (self::validateIP($ip)) {
                return $ip;
            }
        }
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $ip = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
            if (self::validateIP($ip)) {
                return $ip;
            } elseif (mb_strpos($ip, ',') !== false) {
                $ips = explode(',', $ip);
                foreach ($ips as $ip) {
                    $ip = trim($ip);
                    if (self::validateIP($ip)) {
                        return $ip;
                    }
                }
            } elseif (mb_strpos($ip, ';') !== false) {
                $ips = explode(';', $ip);
                foreach ($ips as $ip) {
                    $ip = trim($ip);
                    if (self::validateIP($ip)) {
                        return $ip;
                    }
                }
            }
        }
        if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
            $ip = trim($_SERVER['REMOTE_ADDR']);
            if (self::validateIP($ip)) {
                return $ip;
            }
        }
        
        return '0.0.0.0';
    }
}
?>