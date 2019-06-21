<?php
namespace zion\marketplace\skyhub;

class Customer {
    public $name;
    public $email;
    public $date_of_birth;
    public $gender; // male|female
    public $vat_number;
    public $phones = array(); // array de numeros com DDD
    
    public function toArray(){
        $output = array(
            "name" => $this->name,
            "email" => $this->email,
            "date_of_birth" => $this->date_of_birth,
            "gender" => $this->gender,
            "vat_number" => $this->vat_number,
            "phones" => $this->phones
        );
        return $output;
    }
}