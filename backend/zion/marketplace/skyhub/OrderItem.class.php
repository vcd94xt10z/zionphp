<?php
namespace zion\marketplace\skyhub;

class OrderItem {
    public $id; // Prod-006-A
    public $qty = 1;
    public $original_price = 0.0;
    public $special_price = 0.0;
    
    public function toArray(){
        $output = array(
            "id" => $this->id,
            "qty" => $this->qty,
            "original_price" => $this->original_price,
            "special_price" => $this->special_price
        );
        return $output;
    }
}
?>