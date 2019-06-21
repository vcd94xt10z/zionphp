<?php
namespace zion\marketplace\skyhub;

/**
 * Classe feita com base na documentação
 * https://skyhub.gelato.io/docs/versions/1.0/
 *
 * @author Vinicius Cesar Dias
 */
class KeyPair {
    public $key;
    public $value;
    
    public function __construct($key=null,$value=null){
        $this->key = $key;
        $this->value = $value;
    }
    
    public function toArray(){
        $output = array(
            "key" => $this->key,
            "value" => $this->value
        );
        return $output;
    }
}