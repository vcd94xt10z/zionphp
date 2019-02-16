<?php
namespace zion\utils;

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
    
    /**
     * @see https://stackoverflow.com/questions/5483851/manually-parse-raw-multipart-form-data-data-with-php
     * @return mixed[]
     */
    public static function parsePost(){
        $a_data = [];
        
        // read incoming data
        $input = file_get_contents('php://input');
        
        // grab multipart boundary from content type header
        $matches = [];
        preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);
        $boundary = $matches[1];
        
        // split content by boundary and get rid of last -- element
        $a_blocks = preg_split("/-+$boundary/", $input);
        array_pop($a_blocks);
        
        // loop data blocks
        foreach ($a_blocks as $id => $block){
            if (empty($block))
                continue;
                
            // you'll have to var_dump $block to understand this and maybe replace \n or \r with a visibile char
            
            // parse uploaded files
            if (strpos($block, 'application/octet-stream') !== FALSE)
            {
                // match "name", then everything after "stream" (optional) except for prepending newlines
                preg_match("/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s", $block, $matches);
            }
            // parse all other fields
            else
            {
                // match "name" and optional value in between newline sequences
                preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);
            }
            $a_data[$matches[1]] = $matches[2];
        }
        
        return $a_data;
    }
}
?>