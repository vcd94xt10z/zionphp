<?php
namespace zion\marketplace\skyhub;

/**
 * Classe feita com base na documentação
 * https://skyhub.gelato.io/docs/versions/1.0/
 *
 * @author Vinicius Cesar Dias
 */
class Variation {
    public $sku;
    public $qty;
    public $ean;
    public $images = array();
    public $specifications = array();
    
    public function toArray(){
        $output = array(
            "sku" => $this->sku,
            "qty" => $this->qty,
            "ean" => $this->ean,
            "images" => $this->images,
            "specifications" => array()
        );
        
        foreach($this->specifications AS $item){
            $output["specifications"][] = $item->toArray();
        }
        
        return $output;
    }
}
?>