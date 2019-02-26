<?php
namespace zion\utils;

/**
 * @author Vinicius Cesar Dias
 */
class HTTPUtils {
    public static function template($status,$customMessage=""){
        $file    = \zion\ROOT."tpl".\DS."http-status.php";
        $title   = "";
        $message = "";
        
        switch($status){
        case 401:
            $title = "Autenticação requerida";
            $message = "Sua sessão expirou ou é necessário se autenticar";
            break;
        case 404:
            $title = "Página não encontrada";
            $message = "A url acessada não existe";
            break;
        case 500:
            $title = "Erro interno";            
            $message = "Ocorreu um erro interno, estaremos analisando os logs para resolve-lo";
            break;
        default:
            $title = "Erro ".$status;
            $message = "Ocorreu um erro ".$status;
            break;
        }
        
        if($customMessage != ""){
            $message = $customMessage;
        }
        
        // verificando conteúdo aceito pelo cliente
        if(strpos($_SERVER["HTTP_ACCEPT"],"json") !== false){
            header("Content-Type: application/json");
            echo json_encode(array(
                "title" => $title,
                "message" => $message
            ));
        }elseif(strpos($_SERVER["HTTP_ACCEPT"],"plain/text") !== false){
            header("Content-Type: plain/text");
            echo $message;
        }else{
            header("Content-Type: text/html; charset=UTF-8");
            require($file);
        }
    }
    
    public static function status($status,$reason=""){
        if($reason == ""){
            $messages = array(
                100	=> "Continue",
                101	=> "Switching Protocols",
                102	=> "Processing",
                103	=> "Early Hints",
                
                200	=> "OK",
                201	=> "Created",
                202	=> "Accepted",
                203	=> "Non-Authoritative Information",
                204	=> "No Content",
                205	=> "Reset Content",
                206	=> "Partial Content",
                207	=> "Multi-Status",
                208	=> "Already Reported",
                226	=> "IM Used",
                
                300	=> "Multiple Choices",
                301	=> "Moved Permanently",
                302	=> "Found",
                303	=> "See Other",
                304	=> "Not Modified",
                305	=> "Use Proxy",
                307	=> "Temporary Redirect",
                308	=> "Permanent Redirect",
                
                400	=> "Bad Request",
                401	=> "Unauthorized",
                402	=> "Payment Required",
                403	=> "Forbidden",
                404	=> "Not Found",
                405	=> "Method Not Allowed",
                406	=> "Not Acceptable",
                407	=> "Proxy Authentication Required",
                408	=> "Request Timeout",
                409	=> "Conflict",
                410	=> "Gone",
                411	=> "Length Required",
                412	=> "Precondition Failed",
                413	=> "Payload Too Large",
                414	=> "URI Too Long",
                415	=> "Unsupported Media Type",
                416	=> "Range Not Satisfiable",
                417	=> "Expectation Failed",
                421	=> "Misdirected Request",
                422	=> "Unprocessable Entity",
                423	=> "Locked",
                424	=> "Failed Dependency",
                425	=> "Too Early",
                426	=> "Upgrade Required",
                428	=> "Precondition Required",
                429	=> "Too Many Requests",
                431	=> "Request Header Fields Too Large",
                451	=> "Unavailable For Legal Reasons",
                
                500	=> "Internal Server Error",
                501	=> "Not Implemented",
                502	=> "Bad Gateway",
                503	=> "Service Unavailable",
                504	=> "Gateway Timeout",
                505	=> "HTTP Version Not Supported",
                506	=> "Variant Also Negotiates",
                507	=> "Insufficient Storage",
                508	=> "Loop Detected",
                510	=> "Not Extended",
                511	=> "Network Authentication Required"
            );
            
            if(array_key_exists($status, $messages)){
                $reason = $messages[$status];
            }
        }
        
        header("HTTP/1.1 ".$status." ".$reason);
    }
    
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
     * @see https://gist.github.com/cwhsu1984/3419584ad31ce12d2ad5fed6155702e2
     * @return mixed[]
     * @supress
     */
    public static function parsePost(){
        $a_data = [];
        
        // read incoming data
        $input = file_get_contents('php://input');
        // grab multipart boundary from content type header
        $matches = null;
        preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);
        // content type is probably regular form-encoded
        if (!count($matches))
        {
            // we expect regular puts to containt a query string containing data
            parse_str(urldecode($input), $a_data);
            return $a_data;
        }
        $boundary = $matches[1];
        // split content by boundary and get rid of last -- element
        $a_blocks = preg_split("/-+$boundary/", $input);
        array_pop($a_blocks);
        $keyValueStr = '';
        // loop data blocks
        foreach ($a_blocks as $id => $block)
        {
            if (empty($block))
                continue;
                // you'll have to var_dump $block to understand this and maybe replace \n or \r with a visibile char
                // parse uploaded files
                if (strpos($block, 'application/octet-stream') !== FALSE)
                {
                    // match "name", then everything after "stream" (optional) except for prepending newlines
                    preg_match("/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s", $block, $matches);
                    $a_data['files'][$matches[1]] = $matches[2];
                }
                // parse all other fields
                else
                {
                    // match "name" and optional value in between newline sequences
                    preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);
                    $keyValueStr .= $matches[1]."=".$matches[2]."&";
                }
        }
        $keyValueArr = [];
        parse_str($keyValueStr, $keyValueArr);
        return array_merge($a_data, $keyValueArr);
        
        return $a_data;
    }
}
?>