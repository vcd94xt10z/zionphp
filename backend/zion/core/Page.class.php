<?php 
namespace zion\core;

/**
 * @author Vinicius
 */
class Page {
    /**
     * Título da página
     * @var unknown
     */
    public static $title = "Sem titulo";
    
    /**
     * Metatag robots
     * @var string
     */
    public static $robots = "noindex";
    
    /**
     * Arquivo a ser incluído
     * @var string
     */
    public static $include = "";
    
    /**
     * Dados utilizados na view
     * @var array
     */
    public static $data = array();
    
    /**
     * Inclue e retorna as URIs css
     */
    public static function css($uri=null){
        if($uri === null){
            return self::$data["css"];
        }
        
        if(is_array($uri)){
            foreach($uri AS $item){
                self::$data["css"][] = $item;
            }
        }else{
            self::$data["css"][] = $uri;
        }
    }
    
    /**
     * Inclue e retorna as URIs js
     */
    public static function js($uri=null){
        if($uri === null){
            return self::$data["js"];
        }
        
        if(is_array($uri)){
            foreach($uri AS $item){
                self::$data["js"][] = $item;
            }
        }else{
            self::$data["js"][] = $uri;
        }
    }
}
?>