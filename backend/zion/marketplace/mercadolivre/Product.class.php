<?php
namespace zion\marketplace\mercadolivre;

/**
 * @author Vinicius Cesar Dias
 */
class Product {
    public $title; // Item de test - No Ofertar
    public $category_id; //  MLA3530
    public $price; // 10
    public $currency_id; // ARS
    public $available_quantity; // 1
    public $buying_mode; // buy_it_now
    public $listing_type_id; // gold_special
    public $condition; // new
    public $description; // Item de test - No Ofertar
    public $video_id; // YOUTUBE_ID_HERE
    public $warranty; // 12 months
    public $pictures = array(); // {"source":"http://mla-s2-p.mlstatic.com/968521-MLA20805195516_072016-O.jpg"}
    public $attributes = array();
    public $seller_custom_field = "";
    public $tags = array();
    public $shipping = array();
    public $status;
    
    public function toArray($format="all"){
        $output = array(
            "title"       => $this->title,
            "category_id" => $this->category_id,
            "price"       => $this->price,
            "currency_id" => $this->currency_id,
            "available_quantity" => $this->available_quantity,
            "buying_mode" => $this->buying_mode,
            "listing_type_id" => $this->listing_type_id,
            "condition"   => $this->condition,
            "description" => $this->description,
            "video_id"    => $this->video_id,
            "warranty"    => $this->warranty,
            "pictures"    => array(),
            "attributes"    => $this->attributes,
            "seller_custom_field" => $this->seller_custom_field,
            "tags"       => $this->tags,
            "shipping"   => $this->shipping,
            "status"     => $this->status
        );
        
        foreach($this->pictures AS $picture){
            $output["pictures"][] = $picture->toArray();
        }
        
        // campos que não podem ser enviados em operações de atualização
        if($format == "update"){
            unset($output["listing_type_id"]);
            unset($output["description"]);
        }
        
        return $output;
    }
}
?>