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
        
        $cmsVersion = "1.0.0";
        $cmsRelease = "26/03/2019";
        $moduleVersion = "1.0.0";
        $moduleRelease = "26/03/2019";
        $environment = "sandbox"; //production or sandbox
        $accountEmail = $this->config["email"];
        $accountToken = $this->config["token"];
        $charset = "UTF-8";
        $logPath = \zion\ROOT."log/pagseguro.log";
        
        \PagSeguro\Library::cmsVersion()->setName($cmsVersion)->setRelease($cmsRelease);
        \PagSeguro\Library::moduleVersion()->setName($moduleVersion)->setRelease($moduleRelease);
        \PagSeguro\Configuration\Configure::setEnvironment($environment);
        \PagSeguro\Configuration\Configure::setAccountCredentials($accountEmail,$accountToken);
        \PagSeguro\Configuration\Configure::setCharset($charset);
        \PagSeguro\Configuration\Configure::setLog(true, $logPath);
        
        $response = \PagSeguro\Services\Session::create(\PagSeguro\Configuration\Configure::getAccountCredentials());
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
    
    public function checkout(){
        $senderName = "Fulano da Silva";
        $senderEmail = "fulano@teste.com";
        $phone = new \PagSeguro\Domains\Phone("43","33333333");
        $document = new \PagSeguro\Domains\Document("CPF","806.781.540-23");
        $address = new \PagSeguro\Domains\Address(
            "Rua teste",
            "123",
            "casa",
            "",
            "86031000",
            "Londrina",
            "PR",
            "BR");
        $shippingCost = new \PagSeguro\Domains\ShippingCost();
        $shippingCost->setCost(1.00);
        
        $shippingType = new \PagSeguro\Domains\ShippingType();
        $shippingType->setType(1);
        
        $currency = "BRL";
        $extraAmount = 0.00;
        $reference = "Pedido 123";
        $redirectUrl = "http://shop1.des";
        $notificationUrl = "";
        
        $item = new \PagSeguro\Domains\Item();
        $item->setAmount(1);
        $item->setDescription("teste");
        $item->setId(1);
        $item->setQuantity(2);
        $item->setShippingCost(1.99);
        $item->setWeight(12.00);
        
        $credential = new \PagSeguro\Domains\AccountCredentials($this->config["email"],$this->config["token"]);
        
        $payment = new \PagSeguro\Domains\Requests\Payment();
        $payment->setSender()->setName($senderName);
        $payment->setSender()->setEmail($senderEmail);
        $payment->setSender()->setPhone()->instance($phone);
        $payment->setSender()->setDocument()->instance($document);
        $payment->setShipping()->setAddress()->instance($address);
        $payment->setShipping()->setCost()->instance($shippingCost);
        $payment->setShipping()->setType()->instance($shippingType);
        
        $items = [$item];
        $payment->setItems($items);
        
        $payment->setCurrency($currency);
        $payment->setExtraAmount($extraAmount);
        $payment->setReference($reference);
        $payment->setRedirectUrl($redirectUrl);
        $payment->setNotificationUrl($notificationUrl);
         
        $payment->addParameter()->withParameters('itemId', '0001')->index(1);
        $payment->addParameter()->withParameters('itemDescription', 'Notebook Amarelo')->index(1);
        $payment->addParameter()->withParameters('itemQuantity', '1')->index(1);
        $payment->addParameter()->withParameters('itemAmount', '200.00')->index(1);
         
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
         
        $response = $payment->register($credential);
        return $response;
    }
}
?>