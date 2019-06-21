<?php
namespace zion\marketplace\skyhub;

use Exception;
use stdClass;
use zion\core\System;
use zion\orm\ObjectVO;

/**
 * Classe para comunicação com a SkyHub, feita com base na documentação
 * https://skyhub.gelato.io/docs/versions/1.0/
 * 
 * @author Vinicius Cesar Dias
 */
class SkyHub {
    const DEFAULT_TIMEOUT = 300; 
    private $apiKey = "";
    private $userEmail = "";
    private $accountManagerKey = "";
    
    public function __construct($apiKey,$userEmail,$accountManagerKey){
        $this->apiKey = $apiKey;
        $this->userEmail = $userEmail;
        $this->accountManagerKey = $accountManagerKey;
    }
    
    public function shipmentException(string $mkpOrderId){
        $curl = curl_init();
        
        $data = array(
            "shipment_exception" => array(
                "occurrence_date" => date("Y-m-d")."T".date("H:i:s").System::get("timezone"),
                "observation"     => "Região não atendida"
            )
        );
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.skyhub.com.br/orders/".$mkpOrderId."/shipment_exception",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        $response = curl_exec($curl);
        //$err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);
        
        // verificando se há uma mensagem personalizada
        if($response != ""){
            $json = json_decode($response);
            if($json != null){
                if($json->error != ""){
                    throw new Exception("(Skyhub)".$json->error);
                }
            }
        }
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            throw new Exception("[".$curlInfo["http_status"]."] Erro");
        }
    }
    
    public function getSyncCategoriesErrors() : array {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.skyhub.com.br/sync_errors/categories",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        $response = curl_exec($curl);
        //$err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            throw new Exception("[".$curlInfo["http_status"]."] Erro");
        }
        
        if($response != ""){
            $json = json_decode($response);
            return $json;
        }
        return array();
    }
    
    /**
     * Remove uma ordem da fila
     * Obs.: Não retorna body!
     * @throws Exception
     */
    public function deleteOrderQueue(string $mkpOrderId){
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.skyhub.com.br/queues/orders/".$mkpOrderId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        curl_exec($curl);
        //$err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            throw new Exception("[".$curlInfo["http_status"]."] Erro");
        }
    }
    
    /**
     * Retorna uma ordem da fila
     * @throws Exception
     * @return mixed|string
     */
    public function getOrderQueue() {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.skyhub.com.br/queues/orders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        $response = curl_exec($curl);
        //$err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            throw new Exception("[".$curlInfo["http_status"]."] Erro");
        }
        
        // só terá conteúdo retornado se tiver ordens na fila!
        if($response != ""){
            $json = json_decode($response);
            return $json;
        }
        return "";
    }
    
    /**
     * Retorna um objeto de teste para simular uma chamada da Skyhub
     * @return array
     */
    public function getFreightObjectForTest() : array {
        $data = array(
            "destinationZip" => "86031800",
            "volumes" => array()
        );
        
        $data["volumes"][] = array(
            "sku" => "70",
            "quantity" => rand(1,10),
            "price" => floatval(rand(1,20).".".rand(1,99)),
            "height" => 0.55,
            "length" => 0.63,
            "width" => 0.21,
            "weight" => 1.00
        );
        
        $data["volumes"][] = array(
            "sku" => "100",
            "quantity" => rand(1,10),
            "price" => floatval(rand(1,20).".".rand(1,99)),
            "height" => 0.55,
            "length" => 0.63,
            "width" => 0.21,
            "weight" => 1.00
        );
        
        return $data;
    }
    
    /**
     * Retorna as URLs dos produtos nos marketplaces
     * @throws Exception
     * @return stdClass
     */
    public function getProductsURLs() : stdClass {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.skyhub.com.br/products/urls",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        $response = curl_exec($curl);
        //$err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        
        curl_close($curl);
        
        if($response == ""){
            throw new Exception("Resposta vazia");
        }
        
        $json = json_decode($response);
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            throw new Exception("[".$curlInfo["http_status"]."] Erro");
        }
        
        return $json;
    }
    
    public function getProduct($sku){
        $sku = preg_replace("/[^0-9]/","",$sku);
        $curl = curl_init();
        
        $url = "https://api.skyhub.com.br/products/".$sku;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => self::DEFAULT_TIMEOUT,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        $response = curl_exec($curl);
        //$err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        
        curl_close($curl);
        
        if($response == ""){
            throw new Exception("Resposta vazia");
        }
        
        $product = json_decode($response);
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            throw new Exception("[".$curlInfo["http_status"]."] ".$product->message);
        }
        
        return $product;
    }
    
    public function listProducts(array $filters,int $page=1,int $perPage=30) : array {
        $filters["productIdList"]  = $filters["productIdList"]??array();
        $filters["statusList"] = $filters["statusList"]??array();
        
        if (!empty($filters["productIdList"])) {
            $output = array();
            foreach($filters["productIdList"] AS $productId){
                try {
                    $output[] = $this->getProduct($productId);
                }catch(Exception $e){
                }
            }
            return $output;
        }
        
        // validações
        if($page <= 0){
            $page = 1;
        }
        if($perPage <= 0){
            $perPage = 30;
        }
        if($perPage > 250){
            $perPage = 250;
        }
        
        $curl = curl_init();
        
        // filtros disponíveis
        $args = array();
        foreach($filters["statusList"] AS $status){
            $args[] = "filters[status]=".$status;
        }
        
        if($filters["name"] != ""){
            $args[] = "filters[name]=".$filters["name"];
        }
        
        $args[] = "filters[qty_from]=".$filters["qty_from"];
        
        if($filters["qty_to"] > 0){
            $args[] = "filters[qty_to]=".$filters["qty_to"];
        }
        
        $args[] = "page=".$page;
        $args[] = "per_page=".$perPage;
        $args = "?".implode("&",$args);
        $url = "https://api.skyhub.com.br/products".$args;
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => self::DEFAULT_TIMEOUT,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: foo",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);
        
        if($err){
            throw new Exception($err);
        }
        
        if($response == ""){
            throw new Exception("Resposta vazia");
        }
        
        $list = json_decode($response);
        if(is_array($list->products)){
            return $list->products;
        }
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            if($list->message){
                throw new Exception("[".$curlInfo["http_code"]."] ".$list->message);
            }else{
                throw new Exception("[".$curlInfo["http_code"]."] Resposta inválida");
            }
        }
        
        throw new Exception("Resposta inválida");
    }
    
    public function deleteAllProducts(){
        $filters = array();
        while(true){
            $productList = $this->listProducts($filters,1,60);
            sleep(1);
            
            // acabou!
            if (empty($productList)) {
                return;
            }
            
            foreach($productList AS $product){
                $this->deleteProduct($product->sku);
            }
        }
    }
    
    public function deleteProduct($sku) : string {
        if($sku == ""){
            throw new Exception("SKU não informado");
        }
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.skyhub.com.br/products/".$sku,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => self::DEFAULT_TIMEOUT,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: foo",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        $response = curl_exec($curl);
        $curlInfo = curl_getinfo($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            if($err){
                throw new Exception("[".$curlInfo["http_code"]."] ".$err);
            }else{
                throw new Exception("[".$curlInfo["http_code"]."] Resposta inválida");
            }
        }
        
        return $response;
    }
    
    public function convertProduct(ObjectVO $product)
    {
        $description = "";
        foreach ($product->get("features") AS $feature) {
            if ($feature->get("featkey") == "desc") {
                $description = $feature->get("featval");
            }
        }
        
        $obj = new Product;
        $obj->sku = $product->get("matnr");
        $obj->name = $product->get("title");
        $obj->description = $description;
        $obj->status = ($product->get("status") == "A")?"enabled":"disabled";
        $obj->qty = $product->getStock();
        $obj->price = $product->get("ZPCA");
        $obj->weight = $product->get("weight");
        $obj->height = $product->get("height");
        $obj->width = $product->get("width");
        $obj->length = $product->get("length");
        $obj->brand = $product->get("brand");
        $obj->ean = $product->get("ean11");
        $obj->nbm = $product->get("ncm");
        
        // categorias
        $obj->categories = [];
        $category = new Category;
        $category->code = $product->get("categoryid3");
        $category->name = $product->get("categoryname1").">".$product->get("categoryname2").">".$product->get("categoryname3");
        $obj->categories[] = $category;
        
        // imagens
        $obj->images = [];
        if (empty($product->get("image_count"))) {
            throw new \Exception("Produto sem imagem");
        }
        
        for ($i=0;$i<sizeof($product->get("image_count"));$i++) {
            $obj->images[] = "https://teste.com/produtos/".$product->get("productid")."/550/".($i+1).".jpg";
        }
        
        // caracteristicas
        $obj->specifications = [];
        foreach ($product->get("features") AS $feature) {
            $spec = new KeyPair();
            $spec->key = $feature->get("featnam");
            $spec->value = $feature->get("featval");
            $obj->specifications[] = $spec;
        }
        
        // variações
        $obj->variations = [];
        $obj->variation_attributes = [];
        
        return $obj;
    }
    
    /**
     * Atualiza um campo de um produto
     * @param string $sku
     * @param string $fieldName
     * @param $fieldValue
     * @throws Exception
     */
    public function updateProductField(string $sku,string $fieldName,$fieldValue){
        $url = "https://api.skyhub.com.br/products/".$sku;
        $method = "PUT";
        
        $curl = curl_init();
        
        if(is_string($fieldValue)){
            $fieldValue = "\"".$fieldValue."\"";
        }
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => self::DEFAULT_TIMEOUT,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => "{\"product\":{\"".$fieldName."\":".$fieldValue."}}",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            $json = json_decode($response);
            throw new Exception($json->error,$curlInfo["http_code"]);
        }
        
        if($err){
            throw new Exception($err);
        }
    }
    
    /**
     * @param Product $product
     * @return string
     */
    public function insertProduct(Product $product) : string {
        return $this->saveProduct($product, "insert");
    }
    
    /**
     * Teste OK em 26/12/2017
     * @param Product $product
     * @return string
     */
    public function updateProduct(Product $product) : string {
        return $this->saveProduct($product, "update");
    }
    
    private function saveProduct(Product $product,$type) : string {
        $url = "https://api.skyhub.com.br/products";
        $method = "POST";
        $json = json_encode(array("product" => $product->toArray()));
        
        if($type == "update"){
            $url = "https://api.skyhub.com.br/products/".$product->sku;
            $method = "PUT";
        }
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => self::DEFAULT_TIMEOUT,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            $json = json_decode($response);
            throw new Exception($json->error,$curlInfo["http_code"]);
        }
        
        if($err){
            throw new Exception($err);
        }
        return $response;
    }
    
    public function getOrderForTest(){
        // dados ficticios
        //$matnrList = array("70","100","6415");
        $matnrList = array("6415");
        $names1 = array("Marcos","João","José","Francisco","Maria","Ana","Luiza","Bruna");
        $names2 = array("da Silva","Aparecido","Dias","de Andrade","Almeida","Souza","Costa","Santos","Oliveira","Pereira");
        $UFList = array("PR");
        $channelList = array('Lojas Americanas', 'Submarino', 'Shoptime');
        
        $obj = new Order();
        $obj->channel = $channelList[rand(0,sizeof($channelList)-1)];
        
        // endereço de entrega
        $addr = new Address();
        $addr->street = "Rua Teste";
        $addr->number = "123";
        $addr->detail = "foo";
        $addr->neighborhood = "Vila Teste";
        $addr->city = "Londrina";
        $addr->region = "PR";
        $addr->country = "BR";
        $addr->postcode = "86031810";
        
        // itens
        $valorTotal = 0;
        //$totalItens = rand(1,5);
        $totalItens = 1;
        for($i=0;$i<$totalItens;$i++){
            $index = array_rand($matnrList,1);
            $matnr = $matnrList[$index];
            
            $item = new OrderItem();
            $item->id = $matnr;
            $item->qty = rand(1,5);
            //$item->original_price = rand(5,25);
            $item->original_price = 20.9;
            $item->special_price = 0.0;
            $obj->items[] = $item;
            
            $valorTotal += $item->qty * $item->original_price;
        }
        
        // cliente
        $idx1 = array_rand($names1,2);
        $idx2 = array_rand($names2,2);
        $obj->customer = new Customer();
        $obj->customer->name = $names1[$idx1[0]]." ".$names2[$idx2[1]];
        $obj->customer->vat_number = "62864239582"; // CPF
        $obj->customer->email = "cliente_".$obj->customer->vat_number."@skyhub.com.br";
        $obj->customer->date_of_birth = "1998-01-25";
        $obj->customer->gender = "male";
        $obj->customer->phones = array(
            "21 3722-3902",
            "21 3722-3902"
        );
        $obj->billing_address = $addr;
        $obj->shipping_address = $addr;
        
        // pagamento
        $payment1 = new Payment();
        $payment1->method = "skyhub_payment";
        $payment1->description = "Skyhub";
        $payment1->parcels = 1;
        //$payment1->value = $valorTotal;
        $payment1->value = 0;
        $obj->payments[] = $payment1;
        
        $obj->shipping_method = "Correios PAC";
        $obj->estimated_delivery = "2018-02-11";
        $obj->shipping_cost = 0;
        $obj->interest = 0;
        $obj->discount = 0;
        return $obj;
    }
    
    /**
     * Só é usado para teste no DEV!
     */
    public function createTestOrder(Order $obj){
        $url = "https://api.skyhub.com.br/orders/";
        $method = "POST";
        $json = json_encode(array("order" => $obj->toArray()));
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => self::DEFAULT_TIMEOUT,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        
        curl_close($curl);
        
        if($err){
            throw new Exception($err);
        }
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            $json = json_decode($response);
            throw new Exception($json->error,$curlInfo["http_code"]);
        }
        
        return $response;
    }
    
    public function approveOrder(string $orderId){
        $this->changeStatus($orderId,"payment_received");
    }
    
    public function cancelOrder(string $orderId){
        $this->changeStatus($orderId,"order_canceled");
    }
    
    public function confirmDeliveryOrder(string $orderId){
        $this->changeStatus($orderId,"complete");
    }
    
    public function changeStatus(string $orderId,string $status){
        // entrada
        $orderId = preg_replace("/[^0-9a-zA-Z\-\_\s ]/","",$orderId);
        
        // validação
        $validStatus = array("payment_received","order_canceled","complete");
        $uriPartList = array(
            "payment_received" => "approval",
            "order_canceled" => "cancel",
            "complete" => "delivery"
        );
        if(!in_array($status,$validStatus)){
            throw new Exception("Status ".$status." inválido");
        }
        
        // requisição
        $curl = curl_init();
        
        $url = "https://api.skyhub.com.br/orders/".$orderId."/".$uriPartList[$status];
        $requestMethod = "POST";
        $requestBody = "{\"status\":\"".$status."\"}";
        
        System::set("skyhub_last_http_request_url",$url);
        System::set("skyhub_last_http_request_method",$requestMethod);
        System::get("skyhub_last_http_request_body",$requestBody);
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $requestMethod,
            CURLOPT_POSTFIELDS => $requestBody,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            )
        ));
        
        $response = curl_exec($curl);
        //$err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);
        
        System::set("skyhub_last_http_response_status",$curlInfo["http_code"]);
        System::set("skyhub_last_http_response_body",$response);
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            $json = json_decode($response);
            throw new Exception($json->error,$curlInfo["http_code"]);
        }
    }
    
    /**
     * Fatura um pedido
     * @param string $orderId
     * @param string $nfkey
     * @throws Exception
     */
    public function invoiceOrder(string $orderId,string $nfkey="99999999999999999999999999999999999999999999"){
        $orderId = preg_replace("/[^0-9a-zA-Z\-\_\s ]/","",$orderId);
        $curl = curl_init();
        
        $url = "https://api.skyhub.com.br/orders/".$orderId."/invoice";
        $requestMethod = "POST";
        $requestBody = "{\"status\":\"payment_received\",\"invoice\":{\"key\":\"".$nfkey."\"}}";
        
        System::set("skyhub_last_http_request_url",$url);
        System::set("skyhub_last_http_request_method",$requestMethod);
        System::set("skyhub_last_http_request_body",$requestBody);
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $requestMethod,
            CURLOPT_POSTFIELDS => $requestBody,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            )
        ));
        
        $response = curl_exec($curl);
        //$err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);
        
        System::set("skyhub_last_http_response_status",$curlInfo["http_code"]);
        System::set("skyhub_last_http_response_body",$response);
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            $json = json_decode($response);
            throw new Exception($json->error,$curlInfo["http_code"]);
        }
    }
    
    /**
     * Atualiza informações de frete
     * @param string $orderId
     * @param OrderShipment $obj
     * @throws Exception
     */
    public function sendShipmentData(string $orderId,OrderShipment $obj){
        $orderId = preg_replace("/[^0-9a-zA-Z\-\s ]/","",$orderId);
        $curl = curl_init();
        
        $url = "https://api.skyhub.com.br/orders/".$orderId."/shipments";
        $requestMethod = "POST";
        $requestBody = json_encode($obj->toArray());
        
        System::set("skyhub_last_http_request_url",$url);
        System::set("skyhub_last_http_request_method",$requestMethod);
        System::get("skyhub_last_http_request_body",$requestBody);
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $requestMethod,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_POSTFIELDS => $requestBody,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        $response = curl_exec($curl);
        //$err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);
        
        System::set("skyhub_last_http_response_status",$curlInfo["http_code"]);
        System::set("skyhub_last_http_response_body",$response);
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            $json = json_decode($response);
            throw new Exception($json->error,$curlInfo["http_code"]);
        }
    }
    
    public function getOrder($orderId){
        $orderId = preg_replace("/[^0-9a-zA-Z\-\_\s ]/","",$orderId);
        $curl = curl_init();
        
        if($orderId == ""){
            throw new Exception("Nenhum pedido informado para buscar na Skyhub");
        }
        
        $url = "https://api.skyhub.com.br/orders/".$orderId;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => self::DEFAULT_TIMEOUT,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        $response = curl_exec($curl);
        //$err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            $json = json_decode($response);
            
            if($json === null || $json->error == ""){
                $json = new \stdClass();
                $json->error = "Erro status ".$curlInfo["http_code"];
            }
            
            throw new Exception($json->error,$curlInfo["http_code"]);
        }
        
        $json = json_decode($response);
        
        return $json;
    }
    
    public function listOrders(array $orderIdList = array(),array $statusList=array(),int $page=1,int $perPage=30) : array {
        if (!empty($orderIdList)) {
            $output = array();
            foreach($orderIdList AS $orderId){
                // fazendo um try catch para cada ordem, caso uma dê pau,
                // continua consultando o restante
                try {
                    $output[] = $this->getOrder($orderId);
                }catch(Exception $e){
                }
            }
            return $output;
        }
        
        // validações
        if($page <= 0){
            $page = 1;
        }
        if($perPage <= 0){
            $perPage = 30;
        }
        if($perPage > 250){
            $perPage = 250;
        }
        
        // filtros disponíveis
        $args = array();
        $args[] = "filters[sale_system]=Marketplace";
        foreach($statusList AS $status){
            $args[] = "filters[statuses][]=".$status;
        }
        $args[] = "page=".$page;
        $args[] = "per_page=".$perPage;
        $args = "?".implode("&",$args);
        $url = "https://api.skyhub.com.br/orders".$args;
        
        $method = "GET";
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => self::DEFAULT_TIMEOUT,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "x-accountmanager-key: ".$this->accountManagerKey,
                "x-api-key: ".$this->apiKey,
                "x-user-email: ".$this->userEmail
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $curlInfo = curl_getinfo($curl);
        
        curl_close($curl);
        
        if($err){
            throw new Exception($err);
        }
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){ // 2xx
            $json = json_decode($response);
            throw new Exception($json->error,$curlInfo["http_code"]);
        }
        
        $json = json_decode($response);
        return $json->orders;
    }
    
    public function getProductForTest(){
        $product = new Product();
        $product->sku = "123456";
        $product->name = "Pilha";
        $product->description = "Pilha boa demais";
        $product->status = "enabled";
        $product->qtde = 1;
        $product->price = 1.99;
        $product->promotional_price = 0.99;
        $product->cost = 0;
        $product->weight = 0;
        $product->height = 0;
        $product->width = 0;
        $product->length = 0;
        $product->brand = "Philips";
        $product->ean = "123456";
        $product->nbm = "";
        $product->categories = array(new Category("a","b"));
        
        $product->images = array();
        $product->images[] = "https://teste.com/produtos/123456/550/1.jpg";
        $product->images[] = "https://teste.com/produtos/123456/550/2.jpg";
        
        $product->specifications = array(new KeyPair("a","b"));
        $product->variations = array();
        
        //$variation1 = new Variation();
        //$variation1->sku = "";
        //$product->variations[] = $variation1;
        
        $product->variation_attributes = array("a","b","c");
        return $product;
    }
}
?>