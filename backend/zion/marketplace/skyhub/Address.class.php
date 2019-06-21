<?php
namespace zion\marketplace\skyhub;

class Address {
    public $street;
    public $number;
    public $detail;
    public $neighborhood;
    public $city;
    public $region;
    public $country;
    public $postcode;
    
    public function toArray(){
        $output = array(
            "street" => $this->street,
            "number" => $this->number,
            "detail" => $this->detail,
            "neighborhood" => $this->neighborhood,
            "city" => $this->city,
            "region" => $this->region,
            "country" => $this->country,
            "postcode" => $this->postcode
        );
        return $output;
    }
}
?>