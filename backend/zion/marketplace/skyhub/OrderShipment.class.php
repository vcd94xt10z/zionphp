<?php
namespace zion\marketplace\skyhub;

class OrderShipment {
    public $status;
    public $shipmentCode;
    public $shipmentItems = array();
    public $trackCode = "";
    public $trackCarrier = "";
    public $trackMethod = "";
    public $trackUrl = "";
    
    public function addShipmentItem($sku,$qty){
        $this->shipmentItems[] = array(
            "sku" => $sku,
            "qty" => $qty
        );
    }
    
    public function toArray(){
        $output = array(
            "status" => $this->status,
        );
        
        $output["shipment"] = array(
            "code"  => $this->shipmentCode,
            "items" => $this->shipmentItems
        );
        
        $output["shipment"]["track"] = array(
            "code"    => $this->trackCode,
            "carrier" => $this->trackCarrier,
            "method"  => $this->trackMethod,
            "url"     => $this->trackUrl
        );
        
        return $output;
    }
}
?>