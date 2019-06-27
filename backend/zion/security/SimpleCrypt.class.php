<?php
namespace zion\security;

/**
 * Classe para criptografar e descriptografar uma string de forma simples
 * https://gist.github.com/joashp/a1ae9cb30fa533f4ad94
 */
class SimpleCrypt {
    /**
     * Criptografa uma string
     * @param string $key
     * @param string $string
     * @return string
     */
    public static function encrypt($key,$string){
        return self::encrypt_decrypt("encrypt", $key, $string);
    }
    
    /**
     * Descriptografa uma string
     * @param string $key
     * @param string $string
     * @return string
     */
    public static function decrypt($key,$string){
        return self::encrypt_decrypt("decrypt", $key, $string);
    }
    
    /**
     * Testa para certificar que as operações de criptografia realmente estão funcionando
     * @param string $key
     * @param string $string
     * @return boolean
     */
    public static function test($key,$string){
        $enc = self::encrypt($key, $string);
        $dec = self::decrypt($key, $enc);
        return ($dec == $string);
    }
    
    /**
     * simple method to encrypt or decrypt a plain text string
     * initialization vector(IV) has to be the same when encrypting and decrypting
     *
     * @param string $action: can be 'encrypt' or 'decrypt'
     * @param string $string: string to encrypt or decrypt
     *
     * @return string
     */
    private static function encrypt_decrypt($action, $inputKey, $string) {
        $output = false;
        
        $encrypt_method = "AES-256-CBC";
        $secret_key = $inputKey;
        $secret_iv = $inputKey;
        
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        
        return $output;
    }
}
?>