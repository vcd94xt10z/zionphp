<?php
namespace zion\marketplace\skyhub;

/**
 * Classe feita com base na documentação
 * https://skyhub.gelato.io/docs/versions/1.0/
 *
 * @author Vinicius Cesar Dias
 */
class Category {
    public $code;
    public $name;
    
    public function __construct($code="",$name=""){
        $this->code = $code;
        $this->name = $name;
    }
    
    public function toArray(){
        $output = array(
            "code" => $this->code,
            "name" => $this->name
        );
        return $output;
    }
}
?>