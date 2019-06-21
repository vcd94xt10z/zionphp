<?php
namespace zion\payment\paypal;

use DateTime;
use Exception;
use zion\core\System;
use zion\orm\ObjectVO;
use zion\utils\HTTPUtils;

/**
 * @author Vinicius Cesar Dias
 */
class PayPalAPI {
    private $user;
    private $password;
    private $signature;
    private $url;
    private $checkoutUrl;
    private $returnURL;
    private $cancelURL;
    
    public function __construct($auth){
        $this->user        = $auth["user"];
        $this->password    = $auth["password"];
        $this->signature   = $auth["signature"];
        $this->url         = $auth["url"];
        $this->checkoutUrl = $auth["checkoutUrl"];
    }
    
    public function DoExpressCheckout(ObjectVO $so) : array {
        $paymentList = $so->get("paymentList");        
        $token = $paymentList[0]->get("token");
        
        $nvpGEC = $this->GetExpressCheckout(array(
            "soid"  => $paymentList[0]->get("soid"),
            "token" => $token
        ));
        
        if($nvpGEC["PAYERID"] == ""){
            throw new Exception("Erro em confirmar pagamento no PayPal: 
                PayerID não foi retornado, verifique os dados e tente novamente");
        }
        
        $data = array(
            'USER'       => $this->user,
            'PWD'        => $this->password,
            'SIGNATURE'  => $this->signature,
            'METHOD'     => 'DoExpressCheckoutPayment',
            'VERSION'    => '98',
            'LOCALECODE' => 'pt_BR',
            'TOKEN'      => $token,
            'PAYERID'    => $nvpGEC["PAYERID"],
        
            'PAYMENTREQUEST_0_CUSTOM' => $so->get("soid"),
            'PAYMENTREQUEST_0_AMT' => number_format(($so->get("total_items") + $so->get("freight_value")),2,".",""),
            'PAYMENTREQUEST_0_CURRENCYCODE' => 'BRL',
            'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
            'PAYMENTREQUEST_0_ITEMAMT' => number_format($so->get("total_items"),2,".",""),
            'PAYMENTREQUEST_0_SHIPPINGAMT' => number_format($so->get("freight_value"),2,".","")
        );
        
        $itemList = $so->get("itemList");
        $i = 0;
        foreach($itemList AS $item){
            if (!in_array($item->get("itemtype"),["B","G"])) {
                $data['L_PAYMENTREQUEST_0_NAME'.$i]         = utf8_encode($item->get("title"));
                $data['L_PAYMENTREQUEST_0_QTY'.$i]          = $item->get("quantity");
                $data['L_PAYMENTREQUEST_0_AMT'.$i]          = number_format($item->get("value_unitary"),2,".","");
                $data['L_PAYMENTREQUEST_0_NUMBER'.$i]       = $item->get("matnr");
                $data['L_PAYMENTREQUEST_0_ITEMCATEGORY'.$i] = 'Physical';
                $i++;
            }
        }
        
        // executando chamada
        $options = array();
        $curlInfo = array();
        $response = HTTPUtils::curl($this->url,$data,$options,$curlInfo);
        
        // log
        $curlHttp = System::get("curlHttp");
        
        $httplog = new ObjectVO();
        $httplog->set("category","payment");
        $httplog->set("objectid",$so->get("soid")."-DEC");
        $httplog->set("created",new DateTime());
        $httplog->set("url",$curlHttp["requestUrl"]);
        $httplog->set("request_method",$curlHttp["requestMethod"]);
        $httplog->set("request_body",$curlHttp["requestBody"]);
        $httplog->set("response_status",$curlHttp["responseStatus"]);
        $httplog->set("response_body",$curlHttp["responseBody"]);
        
        $db = System::getConnection();
        $dao = System::getDAO($db, "zion_paypal_httplog");
        $dao->insertOrUpdate($db, $httplog);
        $db = null;
        
        // analizando resposta
        $nvp = array();
        $matches = null;
        if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
            foreach ($matches['name'] as $offset => $name) {
                $nvp[$name] = urldecode($matches['value'][$offset]);
            }
        }
        
        $result = array(
            "confirmed" => false,
            "nvp"       => $nvp
        );
        if(($nvp["ACK"] == "Success" OR $nvp["PAYMENTINFO_0_ACK"] == "Success") AND 
            $nvp["PAYMENTINFO_0_PAYMENTSTATUS"] == "Completed"){
            $result["confirmed"] = true;
        }
        return $result;
    }
    
    public function GetExpressCheckout(array $info) {
        $data = array(
            'USER' => $this->user,
            'PWD' => $this->password,
            'SIGNATURE' => $this->signature,
            'METHOD' => 'GetExpressCheckoutDetails',
            'VERSION' => '98',
            'LOCALECODE' => 'pt_BR',
            'TOKEN' => $info["token"]
        );
        
        $options = array();
        $curlInfo = array();
        $response = HTTPUtils::curl($this->url,$data,$options,$curlInfo);
        
        // log
        $curlHttp = System::get("curlHttp");
        
        $httplog = new ObjectVO();
        $httplog->set("category","payment");
        $httplog->set("objectid",$info["soid"]."-GEC");
        $httplog->set("created",new DateTime());
        $httplog->set("url",$curlHttp["requestUrl"]);
        $httplog->set("request_method",$curlHttp["requestMethod"]);
        $httplog->set("request_body",$curlHttp["requestBody"]);
        $httplog->set("response_status",$curlHttp["responseStatus"]);
        $httplog->set("response_body",$curlHttp["responseBody"]);
        
        $db = System::getConnection();
        $dao = System::getDAO($db, "zion_paypal_httplog");
        $dao->insertOrUpdate($db, $httplog);
        $db = null;
        
        $nvp = array();
        $matches = null;
        if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
            foreach ($matches['name'] as $offset => $name) {
                $nvp[$name] = urldecode($matches['value'][$offset]);
            }
        }
        
        return $nvp;
    }
    
    public function SetExpressCheckout(OrderVO $obj){
        // validações básicas
        if($this->url == ""){
            throw new Exception("URL do PayPal esta vazia");
        }
        
        $data = array(
            'USER' => $this->user,
            'PWD' => $this->password,
            'SIGNATURE' => $this->signature,
            'METHOD' => 'SetExpressCheckout',
            'VERSION' => '98',
            'LOCALECODE' => 'pt_BR',
            'ADDROVERRIDE' => 1,
            'PAYMENTREQUEST_0_CUSTOM' => $obj->id,
            'PAYMENTREQUEST_0_AMT' => number_format(($obj->totalItems + $obj->totalFreight),2,".",""),
            'PAYMENTREQUEST_0_CURRENCYCODE' => 'BRL',
            'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
            'PAYMENTREQUEST_0_ITEMAMT' => number_format($obj->totalItems,2,".",""),
            'PAYMENTREQUEST_0_SHIPPINGAMT' => number_format($obj->totalFreight,2,".",""),
            'CANCELURL' => $this->cancelURL,
            'RETURNURL' => $this->returnURL
        );
        
        if($obj->address != null){
            $address = $obj->address;
            $data['PAYMENTREQUEST_0_SHIPTOSTREET'] = $address->street . ', ' . $address->number . ', ' . $address->complement;
            $data['PAYMENTREQUEST_0_SHIPTOSTREET2'] = $address->neighborhood;
            $data['PAYMENTREQUEST_0_SHIPTOCITY'] = $address->city;
            $data['PAYMENTREQUEST_0_SHIPTOSTATE'] = $address->state;
            $data['PAYMENTREQUEST_0_SHIPTOZIP'] = $address->zipcode;
            $data['PAYMENTREQUEST_0_SHIPTOCOUNTRY'] = 'BR';
        }
        
        // itens
        $i=0;
        foreach($obj->itemList AS $item){
            if (!in_array($item->type,["B","G"])) {
                $data['L_PAYMENTREQUEST_0_NAME'.$i] = $item->name;
                $data['L_PAYMENTREQUEST_0_QTY'.$i] = $item->quantity;
                $data['L_PAYMENTREQUEST_0_AMT'.$i] = number_format($item->amount,2,".","");
                $data['L_PAYMENTREQUEST_0_NUMBER'.$i] = $item->id;
                $data['L_PAYMENTREQUEST_0_ITEMCATEGORY'.$i] = "Physical";
                $i++;
            }
        }
        
        $options = array();
        $curlInfo = array();
        $response = HTTPUtils::curl($this->url,$data,$options,$curlInfo);
        
        // log
        $curlHttp = System::get("curlHttp");
        $httplog = new ObjectVO();
        $httplog->set("category","payment");
        $httplog->set("objectid",$obj->id."-SEC");
        $httplog->set("created",new DateTime());
        $httplog->set("url",$curlHttp["requestUrl"]);
        $httplog->set("request_method",$curlHttp["requestMethod"]);
        $httplog->set("request_body",$curlHttp["requestBody"]);
        $httplog->set("response_status",$curlHttp["responseStatus"]);
        $httplog->set("response_body",$curlHttp["responseBody"]);
        
        $db = System::getConnection();
        $dao = System::getDAO($db, "zion_paypal_httplog");
        $dao->insertOrUpdate($db, $httplog);
        $db = null;
        
        $nvp = array();
        $matches = null;
        if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
            foreach ($matches['name'] as $offset => $name) {
                $nvp[$name] = urldecode($matches['value'][$offset]);
            }
        }
        
        $output = array(
            "result"   => 0,
            "message"  => "",
            "provider" => "system",
            "token"    => "",
            "url"      => ""
        );
        
        if($nvp["ACK"] != "Success" && $nvp["PAYMENTINFO_0_ACK"] != "Success"){
            $output = array(
                "result"   => 0,
                "code"     => $nvp["L_ERRORCODE0"],
                "message"  => $nvp["L_LONGMESSAGE0"],
                "provider" => "paypal",
                "token"    => "",
                "url"      => ""
            );
        }else{
            $output = array(
                "result"   => 1,
                "code"     => "pending",
                "message"  => "Aguardando cliente efetuar operação no PayPal",
                "provider" => "paypal",
                "token"    => $nvp["TOKEN"],
                "url"      => $this->checkoutUrl.$nvp["TOKEN"]
            );
        }
        
        return $output;
    }
}
?>