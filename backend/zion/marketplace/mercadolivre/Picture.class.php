<?php
namespace zion\marketplace\mercadolivre;

/**
 * @author Vinicius Cesar Dias
 */
class Picture {
    public $source;
    
    public function __construct($source=""){
        $this->source = $source;
    }
    
    public function toArray(){
        return array(
            "source" => $this->source
        );
    }
}
?>