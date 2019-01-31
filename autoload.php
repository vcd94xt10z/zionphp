<?php
/*
 * Incluir esse arquivo no projeto que utilizará o framework
 */
define("ZIONPHP_ROOT",dirname(__FILE__)."/");

// autoload
function zionphp_autoload($className) {
    if(strpos($className, "zion\\") === 0) {
        $className2 = str_replace("zion\\","lib\\",$className);
        $file = ZIONPHP_ROOT.str_replace("\\","/",$className2).".class.php";
        if(file_exists($file)) {
            require($file);
        }
        return;
    }
}
spl_autoload_register("zionphp_autoload");
?>