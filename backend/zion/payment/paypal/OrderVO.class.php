<?php
namespace zion\payment\paypal;

/**
 * @author Vinicius Cesar Dias
 */
class OrderVO {
    public $id;
    public $totalItems;
    public $totalFreight;
    public $address;
    public $itemList = array();
}
?>