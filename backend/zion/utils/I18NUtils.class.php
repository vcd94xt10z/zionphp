<?php 
namespace zion\utils;

/**
 * Autor Vinicius
 */
class I18NUtils {
    public static function getCountry($ipaddr){
		$s = file_get_contents('http://ip2c.org/'.$ipaddr);
        switch($s[0]){
          case '0':
            return null;
            break;
          case '1':
            $reply = explode(';',$s);
            return $reply;
            break;
          case '2':
            return null;
            break;
        }
      	return null;
    }
}
?>