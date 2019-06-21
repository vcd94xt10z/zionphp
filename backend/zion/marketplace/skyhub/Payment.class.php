<?php
namespace zion\marketplace\skyhub;

class Payment {
    public $method; // skyhub_payment
    public $description;  // Skyhub
    public $parcels = 1;
    public $value = 0;
    
    public function toArray(){
        $output = array(
            "method" => $this->method,
            "description" => $this->description,
            "parcels" => $this->parcels,
            "value" => $this->value
        );
        return $output;
    }
}
?>