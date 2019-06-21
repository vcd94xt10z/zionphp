<?php
namespace zion\marketplace\skyhub;

/**
 * Classe feita com base na documentação
 * https://skyhub.gelato.io/docs/versions/1.0/
 *
 * @author Vinicius Cesar Dias
 */
class Product {
    public $sku;
    public $name;
    public $description;
    public $status = "enabled"; // enabled | disabled
    public $qty = 0;
    public $price = 0.0;
    public $promotional_price = 0.0;
    public $cost = 0.0;
    public $weight = 0.0;
    public $height = 0.0;
    public $width = 0.0;
    public $length = 0.0;
    public $brand;
    public $ean;
    public $nbm;
    public $categories = array();           // array Category
    public $images = array();
    public $specifications = array();       // array KeyPair
    public $variations = array();           // array Variantion
    public $variation_attributes = array(); // array KeyPair
    public $attributeChanges = array();
    
    public function __set($key,$val){
        $this->attributeChanges[$key] = $val; 
    }
    
    public function toArray(){
        $output = array(
            "sku" => $this->sku,
            "name" => substr($this->name,0,100), // a Skyhub não aceita mais de 100 caracteres
            "description" => $this->description,
            "status" => $this->status,
            "qty" => $this->qty,
            "price" => $this->price,
            "promotional_price" => $this->promotional_price,
            "cost" => $this->cost,
            "weight" => $this->weight,
            "height" => $this->height,
            "width" => $this->width,
            "length" => $this->length,
            "brand" => $this->brand,
            "ean" => $this->ean,
            "nbm" => $this->nbm,
            "categories" => array(),
            "images" => $this->images,
            "specifications" => array(),
            "variations" => array(),
            "variation_attributes" => $this->variation_attributes
        );
        
        foreach($this->categories AS $item){
            $output["categories"][] = $item->toArray();
        }
        
        foreach($this->specifications AS $item){
            $output["specifications"][] = $item->toArray();
        }
        
        foreach($this->variations AS $item){
            $output["variations"][] = $item->toArray();
        }
        
        return $output;
    }
}
?>