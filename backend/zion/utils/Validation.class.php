<?php
namespace zion\utils;

/**
 * @author Vinicius Cesar Dias
 */
class Validation {
    /**
     * Valida um IP v4
     * @param string $ip: IP a ser validado
     * @return bool
     * @see http://rubsphp.blogspot.com.br/2010/12/obter-o-ip-do-cliente.html
     */
    public static function isIPv4($ip) : bool {
        // IPv4
        $vetor = explode('.', $ip);
        if (count($vetor) != 4) {
            return false;
        }
        foreach ($vetor as $i) {
            if (!is_numeric($i) || $i < 0 || $i > 255) {
                return false;
            }
        }
        return true;
    }
}
?>