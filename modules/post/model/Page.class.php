<?php 
namespace zion\mod\post\model;

use zion\core\System;
use zion\utils\HTTPUtils;

/**
 * @author Vinicius
 */
class Page {
    public static function loadByRewrite(){
        // input
        $uri = explode("?",$_SERVER["REQUEST_URI"]);
        $uri = trim($uri[0],"/");
        
        // process
        $db = System::getConnection();
        $dao = System::getDAO($db,"zion_post_page");
        
        $keys = array(
            "mandt"   => 0,
            "rewrite" => $uri,
            "status"  => "A"
        );
        $obj = $dao->getObject($db, $keys);
        if($obj == null){
            return;
        }
        
        // output
        HTTPUtils::status($obj->get("http_status"));
        header('Content-Type: text/html; charset=utf-8');
        header("Cache-Control: max-age=".$obj->get("cache_maxage").", s-maxage=".$obj->get("cache_smaxage"));
        
        if($obj->get("use_template") == 1){
            echo $obj->get("content_html");
        }else{
            echo $obj->get("content_html");
        }
        exit();
    }
}
?>