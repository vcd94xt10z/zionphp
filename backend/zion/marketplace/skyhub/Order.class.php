<?php
namespace zion\marketplace\skyhub;

class Order {
    public $channel = "Teste";
    public $items = array();
    public $customer = null;
    public $billing_address = null;
    public $shipping_address = null;
    public $payments = array();
    public $shipping_method; // Exemplo: Correios PAC
    public $estimated_delivery; // data d-m-y,
    public $shipping_cost;
    public $interest;
    public $discount;
    
    public function toArray(){
        $output = array(
            "channel" => $this->channel,
            "items" => array(),
            "customer" => $this->customer->toArray(),
            "billing_address" => $this->billing_address->toArray(),
            "shipping_address" => $this->shipping_address->toArray(),
            "payments" => array(),
            "shipping_method" => $this->shipping_method,
            "estimated_delivery" => $this->estimated_delivery,
            "shipping_cost" => $this->shipping_cost,
            "interest" => $this->interest,
            "discount" => $this->discount
        );

        foreach($this->items AS $item){
            $output["items"][] = $item->toArray();
        }

        foreach($this->payments AS $item){
            $output["payments"][] = $item->toArray();
        }
        
        return $output;
    }
}
?>