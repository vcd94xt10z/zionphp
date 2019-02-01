<?php
namespace zion\utils;

/**
 * @author Vinicius Cesar Dias
 */
class StringUtils
{
    public static function randomString($length)
    {
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $string = "";
        
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters))];
        }
        
        return $string;
    }

    public static function convertTextAreaLinesToArray(string $content, $type = "string") {
        if ($content != "") {
            $content = explode("\n", $content);
        } else {
            $content = array();
        }

        $output = array();
        foreach ($content AS $value) {
            if ($type == "int") {
                $value2 = intval(preg_replace("/[^0-9]/", "", $value));
                if($value2 > 0){
                    $output[] = $value2;
                }
            }elseif ($type == "numeric") {
                $value2 = preg_replace("/[^0-9]/", "", $value);
                if($value2 != ""){
                    $output[] = $value2;
                }
            } else {
                $value2 = preg_replace("/[^0-9a-zA-Z\#\-\_\s ]/", "", trim($value));
                if($value2 != ""){
                    $output[] = $value2;
                }
            }
        }
        return $output;
    }

    public static function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public static function endsWith($haystack, $needle) {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }
        return (substr($haystack, -$length) === $needle);
    }

    public static function acentRemove(string $string): string {

        $table = array(
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
            'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
            'Ç' => 'C',
            'Ñ' => 'N',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u',
            'ç' => 'c',
            'ñ' => 'n'
        );

        return strtr($string, $table);
    }

}
