<?php 
namespace zion\utils;

class GoogleUtils {
    public static function recaptcha($secretKey,$captcha) : array {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array('secret' => $secretKey, 'response' => $captcha);
        
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $responseKeys = json_decode($response,true);
        
        if($responseKeys["success"]) {
            return [];
        } else {
            return $responseKeys["error-codes"];
        }
    }
}
?>