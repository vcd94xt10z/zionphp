<?php 
namespace zion\payment;

/**
 * @author Vinicius
 * @since 26/03/2019
 */
class PagSeguro {
    /**
     * Token necessário para se comunicar
     * @var string
     */
    public $config = array();
    
    /**
     * URLs de comunicação
     * @var array
     */
    public $url = array(
        "main" => "",
        "ws"   => "",
        "stc"  => ""
    );
    
    public $credentials;
    
    public function __construct($env,array $config){
        spl_autoload_register("\zion\payment\PagSeguro::autoload");
        
        if($env == "PRD"){
            $this->url["main"] = "https://pagseguro.uol.com.br";
            $this->url["ws"]   = "https://ws.pagseguro.uol.com.br";
            $this->url["stc"]  = "https://stc.pagseguro.uol.com.br";
        }else{
            $this->url["main"] = "https://sandbox.pagseguro.uol.com.br";
            $this->url["ws"]   = "https://ws.sandbox.pagseguro.uol.com.br";
            $this->url["stc"]  = "https://stc.sandbox.pagseguro.uol.com.br";
        }
        
        $this->config = $config;
        
        \PagSeguro\Library::initialize();
        
        $cmsVersion    = "1.0.0";
        $cmsRelease    = "26/03/2019";
        $moduleVersion = "1.0.0";
        $moduleRelease = "26/03/2019";
        $environment   = "sandbox"; //production or sandbox
        $accountEmail  = $this->config["email"];
        $accountToken  = $this->config["token"];
        $charset       = "UTF-8";
        $logPath       = \zion\ROOT."log/pagseguro.log";
        
        if($env == "PRD"){
            $environment = "production";
        }
        
        \PagSeguro\Library::cmsVersion()->setName($cmsVersion)->setRelease($cmsRelease);
        \PagSeguro\Library::moduleVersion()->setName($moduleVersion)->setRelease($moduleRelease);
        \PagSeguro\Configuration\Configure::setEnvironment($environment);
        \PagSeguro\Configuration\Configure::setAccountCredentials($accountEmail,$accountToken);
        \PagSeguro\Configuration\Configure::setCharset($charset);
        \PagSeguro\Configuration\Configure::setLog(true, $logPath);
        
        $this->credentials = \PagSeguro\Configuration\Configure::getAccountCredentials();
        \PagSeguro\Services\Session::create($this->credentials);
    }
    
    public function queryTransaction($type,$code){
        if($type == "reference"){
            $options = [
                'initial_date' => null,
                'final_date' => null,
                'page' => 1,
                'max_per_page' => 10,
            ];
            $response = \PagSeguro\Services\Transactions\Search\Reference::search(
                $this->credentials,
                $code,
                $options
            );
        }
        
        if($type == "transaction"){
            $response = \PagSeguro\Services\Transactions\Search\Code::search(
                $this->credentials,
                $code
            );
        }
        
        return $response;
    }
    
    public function checkout(array $order, array $customer){
        $senderName  = $customer["name"];
        $senderEmail = $customer["email"];
        
        $ddd = substr($customer["phone_cell"],0,2);
        $phoneNumber = substr($customer["phone_cell"],2);
        
        $phone = new \PagSeguro\Domains\Phone($ddd,$phoneNumber);
        $document = new \PagSeguro\Domains\Document("CPF",$customer["docf"]);
        $address = new \PagSeguro\Domains\Address(
            $order["address"]["street"],
            $order["address"]["number"],
            $order["address"]["complement"],
            "",
            $order["address"]["zipcode"],
            $order["address"]["city"],
            $order["address"]["region"],
            "BR"
        );
        $shippingCost = new \PagSeguro\Domains\ShippingCost();
        $shippingCost->setCost($order["freight_value"]);
        
        $shippingType = new \PagSeguro\Domains\ShippingType();
        $shippingType->setType(3); // Não especificado
        
        $currency        = "BRL";
        $extraAmount     = 0.00;
        $reference       = $order["soid"];
        $redirectUrl     = "http://".$_SERVER["SERVER_NAME"]."/mod/eco/SOCheckout/pagSeguro/retorno";
        $notificationUrl = "http://".$_SERVER["SERVER_NAME"]."/mod/eco/SOCheckout/pagSeguro/notificacao";
        
        $credential = new \PagSeguro\Domains\AccountCredentials($this->config["email"],$this->config["token"]);
        
        $payment = new \PagSeguro\Domains\Requests\Payment();
        $payment->setSender()->setName($senderName);
        $payment->setSender()->setEmail($senderEmail);
        $payment->setSender()->setPhone()->instance($phone);
        $payment->setSender()->setDocument()->instance($document);
        $payment->setShipping()->setAddress()->instance($address);
        $payment->setShipping()->setCost()->instance($shippingCost);
        $payment->setShipping()->setType()->instance($shippingType);
        
        // itens
        $items = array();
        $index = 1;
        foreach($order["itemList"] AS $itemArray){
            $item = new \PagSeguro\Domains\Item();
            $item->setAmount($itemArray["value_unitary"]);
            $item->setDescription($itemArray["title"]);
            $item->setId($itemArray["productid"]);
            $item->setQuantity($itemArray["quantity"]);
            $item->setShippingCost(0.00);
            $item->setWeight($itemArray["weight_unitary"]);
            $items[] = $item;
            
            $amount = number_format((float)$itemArray["value_unitary"], 2, '.', '');
            
            $payment->addParameter()->withParameters('itemId', (string)$itemArray["productid"])->index($index);
            $payment->addParameter()->withParameters('itemDescription', (string)$itemArray["title"])->index($index);
            $payment->addParameter()->withParameters('itemQuantity', (string)$itemArray["quantity"])->index($index);
            $payment->addParameter()->withParameters('itemAmount', $amount)->index($index);
            $index++;
        }
        $payment->setItems($items);
        
        $payment->setCurrency($currency);
        $payment->setExtraAmount($extraAmount);
        $payment->setReference($reference);
        $payment->setRedirectUrl($redirectUrl);
        $payment->setNotificationUrl($notificationUrl);
         
        $payment->addPaymentMethod()->withParameters(
            \PagSeguro\Enum\PaymentMethod\Group::CREDIT_CARD,
            \PagSeguro\Enum\PaymentMethod\Config\Keys::DISCOUNT_PERCENT,
            10.00
        );
        
        $payment->addPaymentMethod()->withParameters(
            \PagSeguro\Enum\PaymentMethod\Group::CREDIT_CARD,
            \PagSeguro\Enum\PaymentMethod\Config\Keys::MAX_INSTALLMENTS_NO_INTEREST,
            2
        );
         
        $payment->addPaymentMethod()->withParameters(
            \PagSeguro\Enum\PaymentMethod\Group::CREDIT_CARD,
            \PagSeguro\Enum\PaymentMethod\Config\Keys::MAX_INSTALLMENTS_LIMIT,
            6
        );
         
        $payment->acceptPaymentMethod()->groups(
            \PagSeguro\Enum\PaymentMethod\Group::CREDIT_CARD,
            \PagSeguro\Enum\PaymentMethod\Group::BALANCE
        );
         
        $payment->acceptPaymentMethod()->name(\PagSeguro\Enum\PaymentMethod\Name::DEBITO_ITAU);
         
        $payment->excludePaymentMethod()->group(\PagSeguro\Enum\PaymentMethod\Group::BOLETO);
         
        $obj  = $payment->register($credential,true);
        $code = $obj->getCode();
        $url  = $this->url["main"]."/v2/checkout/payment.html?code=".$code;
        
        return array(
            "code" => $code,
            "url"  => $url
        );
    }
    
    public static function autoload($className){
        if(strpos($className, "PagSeguro\\") !== 0) {
            return;
        }
        
        $className = str_replace("PagSeguro\\","",$className);
        $file = \zion\ROOT."backend/pagseguro/source/".str_replace("\\","/",$className).".php";
        if(file_exists($file)) {
            require_once($file);
        }
    }
}
?>