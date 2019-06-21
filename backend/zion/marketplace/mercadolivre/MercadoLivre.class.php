<?php
namespace zion\marketplace\mercadolivre;

use DateTime;
use Exception;
use stdClass;
use mercadolivre\Meli;
use zion\orm\ObjectVO;
use zion\utils\HTTPUtils;

/**
 * Autor Vinicius Cesar Dias
 */
class MercadoLivre {
    // (M)ercado (L)ivre (B)rasil
    const SITE_ID = "MLB";
    
    const LISTING_TYPE_ID = "gold_special";
    
    public static $categoryIndexed = array();
    public $config = array();
    public $meli = null;
    
    public function __construct(array $config){
        $this->config = $config;
        $this->meli = new Meli($config["client_id"], $config["client_secret"],
            $config["access_token"],$config["refresh_token"]);
    }
    
    public static function getTags() : array {
        $tags = array(
            "not_delivered" => "Not Delivered",
            "paid" => "Order Paid",
            "delivered" => "Delivered",
            "not_paid" => "Order Not Paid",
            "claim_closed" => "Claim Closed",
            "claim_opened" => "Claim Opened",
            "not_processed" => "Not processed order",
            "processed" => "Processed order",
            "returned" => "Returned order",
            "pack_order" => "Cart Order",
            "reservation" => "Reservation Order",
            "mshops" => "Order from Mercado Shops"
        );
        return $tags;
    }
    
    public static function getShippingSubstatusList() : array {
        $shippingSubstatusList = array(
            "cost_exceeded" => "Cost exceeded",
            "under_review" => "Under review (e.g. fraud)",
            "reviewed" => "Reviewed",
            "fraudulent" => "Cancelled Fraudulent",
            "waiting_for_payment" => "Waiting for shipping payment to be accredited",
            "shipment_paid" => "Shipping cost has been paid",
            "regenerating" => "Regenerating",
            "waiting_for_label_generation" => "Waiting for label generation",
            "invoice_pending" => "Invoice pending",
            "waiting_for_return_confirmation" => "Waiting for return confirmation",
            "return_confirmed" => "Return Confirmed",
            "manufacturing" => "Manufacturing",
            "ready_to_print" => "Ready to print",
            "printed" => "Printed",
            "in_pickup_list" => "In pikcup list",
            "ready_for_pkl_creation" => "Ready for pkl creation",
            "ready_for_pickup" => "Ready for pickup",
            "ready_for_dropoff" => "Ready for drop off",
            "picked_up" => "Picked up",
            "stale" => "Stale shipped",
            "dropped_off" => "Dropped off in Melipoint",
            "in_hub" => "In hub",
            "measures_ready" => "Measures and weight ready",
            "waiting_for_carrier_authorization" => "Waiting for carrier authorization",
            "authorized_by_carrier" => "Authorized by carrier",
            "in_packing_list" => "In packing list",
            "in_plp" => "In PLP",
            "in_warehouse" => "In Warehouse",
            "ready_to_pack" => "Ready to Pack",
            "delayed" => "Delayed",
            "waiting_for_withdrawal" => "Waiting for withdrawal",
            "contact_with_carrier_required" => "Contact with carrier required",
            "receiver_absent" => "Receiver absent",
            "reclaimed" => "Reclaimed",
            "not_localized" => "Not localized",
            "forwarded_to_third" => "Forwarded to third party",
            "soon_deliver" => "Soon deliver",
            "refused_delivery" => "Delivery refused",
            "bad_address" => "Bad address",
            "negative_feedback" => "Stale shipped forced to not delivered due to negative feedback by buyer",
            "need_review" => "Need to review carrier status to understand what happened",
            "operator_intervention" => "Need operator intervention",
            "claimed_me" => "Not delivered that was claimed by the receiver",
            "retained" => "Retained",
            "damaged" => "Package damaged in hub",
            "fulfilled_feedback" => "Fulfilled by buyer feedback",
            "no_action_taken" => "No action taken by buyer",
            "double_refund" => "Double Refund",
            "returning_to_sender" => "Returning to sender",
            "stolen" => "Stolen",
            "returned" => "Returned",
            "confiscated" => "confiscated",
            "to_review" => "Closed shipment",
            "destroyed" => "Destroyed",
            "lost" => "Package lost",
            "cancelled_measurement_exceeded" => "Shipment cancelled for measurement exceeded",
            "returned_to_hub" => "Returned to hub",
            "returned_to_agency" => "Returned to agency",
            "picked_up_for_return" => "Picked up for return",
            "returning_to_warehouse" => "Returning to Warehouse",
            "returned_to_warehouse" => "Returned to Warehouse",
            "recovered" => "Recovered",
            "label_expired" => "Label Expired",
            "cancelled_manually" => "Cancelled Manually",
            "return_expired" => "Return expired",
            "return_session_expired" => "Return session expired",
            "unfulfillable" => "Unfulfillable"
        );
        return $shippingSubstatusList;
    }
    
    public static function getShippingServiceIdList() : array {
        $shippingServiceIdList = array(
            21  => "PAC",
            23  => "eSedex",
            22  => "Sedex",
            261 => "Cougar Normal",
            262 => "Cougar Expresso",
            821 => "DHL",
            691 => "Total Medio Rodo",
            293 => "Fulfillment Express",
            841 => "Loggi a domicilio",
            641 => "Cross Border Trade",
            741 => "Cross Border Trade",
            291 => "Fulfillment Normal",
            292 => "Fulfillment Express",
            293 => "Jadlog Normal",
            264 => "Jadlog Expresso",
            11  => "Otros",
            101 => "Coleta Normal",
            102 => "Coleta Express",
            103 => "Coleta Express",
            282 => "CBT",
            761 => "SuperExpress",
            161 => "CBT",
            991 => "Mercadoenvios Next Day",
            104 => "DGT Normal",
            105 => "Total Normal",
            106 => "Transfolha Normal",
            107 => "Directlog Normal",
            108 => "Directlog Express",
            109 => "Transfolha Express",
            110 => "Total Express",
            751 => "Cross Border Trade",
            30  => "DGT Expresso",
            871 => "Loggi Express a domicilio",
            891 => "Estandar"
        );
        return $shippingServiceIdList;
    }
    
    public static function getRatingList() : array {
        $ratingList = array(
            "negative" => "Negativo",
            "neutral" => "Neutro",
            "positive" => "Positivo"
        );
        return $ratingList;
    }
    
    public static function getOrderStatusList() : array {
        $orderStatusList = array(
            "paid" => "Pedido Pago",
            "confirmed" => "Pedido Confirmado",
            "payment_in_process" => "Pagamento em Progresso",
            "payment_required" => "Pagamento Requirido",
            "cancelled" => "Pedido Cancelado",
            "invalid" => "Pedido Inválido",
        );
        return $orderStatusList;
    }
    
    public static function getShippingStatusList() : array {
        $shippingStatusList = array(
            "pending" => "Pendente",
            "to_be_agreed" => "A ser acordado",
            "handling" => "Em manipulação",
            "ready_to_ship" => "Pronto para ser Enviado",
            "shipped" => "Enviado",
            "delivered" => "Entregue",
            "not_delivered" => "Não entregue",
            "cancelled" => "Cancelado",
            "closed" => "Fechado",
            "error" => "Erro",
            "active" => "Ativado",
            "not_specified" => "Não especificado",
            "stale_ready_to_ship" => "Stale ready to ship",
            "stale_shipped" => "Stale shipped"
        );
        return $shippingStatusList;
    }
    
    public function getCurrentUserInfo(){
        $accessToken = $this->getAccessToken();
        
        $curlInfo = array();
        $url = "https://api.mercadolibre.com/users/me?access_token=".$accessToken;
        $response = HTTPUtils::curl2($url,"GET",array(),array(),$curlInfo);
        $this->defaultResponseRawValidator($response, $curlInfo);
        
        return json_decode($response);
    }
    
    public function getFreeShippingByProductList(array $skuList)
    {
        $url = "https://api.mercadolibre.com/items/shipping_options/free?ids=".implode(",",$skuList);
        
        $options = [
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"]
        ];
        $curlInfo = [];
        $response = HTTPUtils::curl2($url,"GET",[],$options,$curlInfo);
        $this->defaultResponseRawValidator($response,$curlInfo);
        return json_decode($response);
    }
    
    /**
     * Retorna informações detalhadas da entrega
     * @param string $shipmentid
     * @return mixed
     */
    public function getShipmentInfo(string $shipmentid){
        $accessToken = $this->getAccessToken();
        $url = "https://api.mercadolibre.com/shipments/".$shipmentid."?access_token=".$accessToken;
        
        // requisição
        $options = array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json')
        );
        $curlInfo = array();
        $response = HTTPUtils::curl2($url,"GET",array(),$options,$curlInfo);
        $this->defaultResponseRawValidator($response, $curlInfo);
        return json_decode($response);
    }
    
    public function getOrder(string $orderid, $recursive = true) : stdClass {
        $accessToken = $this->getAccessToken();
        $url = "https://api.mercadolibre.com/orders/".$orderid."?access_token=".$accessToken;
        
        // requisição
        $options = array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json')
        );
        $curlInfo = array();
        $response = HTTPUtils::curl2($url,"GET",array(),$options,$curlInfo);
        $this->defaultResponseRawValidator($response, $curlInfo);
        
        $order = json_decode($response);
        
        if($order != null){
            // objeto detalhado com informações de entrega
            $order->shippingObject = null;
            if($order->shipping->id != null){
                $order->shippingObject = $this->getShipmentInfo($order->shipping->id);
            }
            
            // muito importante!
            if(!$recursive){
                return $order;
            }
            
            // verificando se o pedido é de carrinho
            $index = array_search("pack_order",$order->tags);
            if($index !== false AND $order->pack_id != null){
                $this->agruparOrdem($order);
            }
        }
        
        return $order;
    }
    
    /**
     * 
     * @param stdClass $order
     * @throws Exception
     */
    public function agruparOrdem(stdClass &$order){
        // procurando os outros pedidos porque o mercadolivre separa em vários pedidos
        $from = new DateTime($order->date_created);
        $from->modify("-1 days");
        $to = new DateTime($order->date_created);
        $to->modify("+1 days");
        
        $filter = array(
            "createFrom" => $from->format("Y-m-d"),
            "createTo"   => $to->format("Y-m-d")
        );
        
        $orderList = $this->getOrderList($filter);
        
        $order->total_amount = 0;
        $order->paid_amount = 0;
        
        // coletando pedidos
        $orderPackList = array();
        $itemList = array();
        foreach($orderList AS $orderLoop){
            // carregando a ordem completa, com o objeto shipping
            $otherOrder = $this->getOrder($orderLoop->id,false);
            
            // campos usados para juntar os pedidos
            $docf1 = $order->buyer->billing_info->doc_number;
            $docf2 = $otherOrder->buyer->billing_info->doc_number;
            
            $date1 = new DateTime($order->date_created);
            $date2 = new DateTime($otherOrder->date_created);
            $diffInSeconds = abs($date1->getTimestamp() - $date2->getTimestamp());
            
            // se for o mesmo cliente e a diferença entre um pedido e outro é de menor que 60 segundos
            if($docf1 == $docf2 AND $diffInSeconds < 60){
                $orderPackList[$otherOrder->id] = $otherOrder;
                
                $order->total_amount += $otherOrder->total_amount;
                $order->paid_amount  += $otherOrder->paid_amount;
                
                // coletando itens
                foreach($otherOrder->order_items AS $item){
                    $item->originalOrderId = $otherOrder->id;
                    $itemList[] = $item;
                }
            }
        }
        
        // ordenando lista pela chave
        ksort($orderPackList);
        $orderPackKeys = array_keys($orderPackList);
        
        if (empty($itemList)) {
            throw new Exception("Nenhum item encontrado no pack ".$order->pack_id." / 
                shipping ".$order->shipping->id." do mercadolivre, 
                ordens analisadas: ".implode(", ",$orderPackKeys));
        }
        
        // atualizando o pedido somente se tiver mais de 1 item para manter o id original
        if(sizeof($itemList) > 1){
            $order->id          = "C".$orderPackKeys[0]."-".sizeof($orderPackKeys);
            $order->order_items = $itemList;
        }
        
        // o sistema só cria o pedido se o pack_id estiver vazio
        $order->pack_id = "";
    }
    
    public function getOrderList(array $filter) {
        $accessToken = $this->getAccessToken();
        
        if (!empty($filter["orderid"])) {
            $output = array();
            foreach($filter["orderid"] AS $orderId){
                // fazendo um try catch para cada ordem, caso uma dê pau,
                // continua consultando o restante
                try {
                    $output[] = $this->getOrder($orderId);
                }catch(Exception $e){
                }
            }
            return $output;
        }
        
        // montando url
        $args = array();
        $args[] = "seller=".$this->config["user_id"];
        
        // data de criação
        if(strlen($filter["createFrom"]) == 10){
            $filter["createFrom"] = explode("/",$filter["createFrom"]);
            $filter["createFrom"] = array_reverse($filter["createFrom"]);
            $filter["createFrom"] = implode("-",$filter["createFrom"]);
            $args[] = "order.date_created.from=".$filter["createFrom"]."T00:00:00.000-00:00";
        }
        if(strlen($filter["createTo"]) == 10){
            $filter["createTo"] = explode("/",$filter["createTo"]);
            $filter["createTo"] = array_reverse($filter["createTo"]);
            $filter["createTo"] = implode("-",$filter["createTo"]);
            $args[] = "order.date_created.to=".$filter["createTo"]."T23:59:59.000-00:00";
        }
        
        // status da ordem
        if($filter["orderStatus"] != ""){
            $args[] = "order.status=".$filter["orderStatus"];
        }
        
        // status da entrega
        if($filter["shippingStatus"] != ""){
            $args[] = "shipping.status=".$filter["shippingStatus"];
        }
        
        // shippingSubstatus
        if($filter["shippingSubstatus"] != ""){
            $args[] = "shipping.substatus=".$filter["shippingSubstatus"];
        }
        
        // avaliação do usuário
        if($filter["feedbackSaleRating"] != ""){
            $args[] = "feedback.sale.rating=".$filter["feedbackSaleRating"];
        }
        
        // shippingServiceId
        if($filter["shippingServiceId"] != ""){
            $args[] = "shipping.service_id=".$filter["shippingServiceId"];
        }
        
        // tags
        if($filter["tags"] != ""){
            $args[] = "tags=".$filter["tags"];
        }
        
        // paginação
        $filter["limit"] = intval($filter["limit"]);
        if($filter["limit"] <= 0 || $filter["limit"] > 50){
            $filter["limit"] = 50;
        }
        $args[] = "limit=".$filter["limit"];
        
        if($filter["page"] != ""){
            $args[] = "offset=".(intval($filter["page"])-1) * $filter["limit"];
        }
        
        // ordenação
        if($filter["sort"] != ""){
            $args[] = "sort=".$filter["sort"];
        }
        
        // accessToken
        $args[] = "access_token=".$accessToken;
        
        $server = "api.mercadolibre.com";
        $path   = "/orders/search";
        $url = "https://".$server.$path."?".implode("&",$args);
        
        // requisição
        $options = array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json')
        );
        $curlInfo = array();
        $response = HTTPUtils::curl2($url,"GET",array(),$options,$curlInfo);
        $this->defaultResponseRawValidator($response, $curlInfo);
        $json = json_decode($response);
        
        return $json->results;
    }
    
    /**
     * Retorna uma lista de produtos
     * @throws Exception
     * @return array
     */
    public function getProductList(array $filter, &$metadataQuery=null) : array {
        $accessToken = $this->getAccessToken();
        
        if (!empty($filter["matnrList"])) {
            $output = array();
            foreach($filter["matnrList"] AS $matnr){
                try {
                    $itemIdList = $this->getProductIdListBySKU($matnr);
                    foreach($itemIdList AS $itemId){
                        $output[] = $this->getProduct($itemId);
                    }
                }catch(Exception $e){
                }
            }
            return $output;
        }
        
        if (!empty($filter["skuList"])) {
            $output = [];
            foreach ($filter["skuList"] as $sku) {
                try {
                    $output[] = $this->getProduct("MLB".$sku);
                } catch (Exception $e) {}
            }
            return $output;
        }
        
        // status
        $args = array();
        
        if($filter["status"] != ""){
            $args[] = "status=".$filter["status"];
        }
        
        // substatus
        if($filter["subStatus"] != ""){
            $args[] = "sub_status=".$filter["subStatus"];
        }
        
        // id do tipo de listagem
        if($filter["listingTypeId"] != ""){
            $args[] = "listing_type_id=".$filter["listingTypeId"];
        }
        
        // label
        if($filter["label"] != ""){
            $args[] = "label=".$filter["label"];
        }
        
        // sort
        if($filter["sort"] != ""){
            $args[] = "order=".$filter["sort"];
        }
        
        // limite
        if($filter["limit"] > 0){
            $args[] = "limit=".$filter["limit"];
        }
        
        // offset
        if($filter["offset"] > 0){
            $args[] = "offset=".$filter["offset"];
        }
        
        
        $args[] = "access_token=".$accessToken;
        
        // montando url
        $url = "https://api.mercadolibre.com/users/".$this->config["user_id"]."/items/search?".implode("&",$args);
        $options = array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json')
        );
        $curlInfo = array();
        $response = HTTPUtils::curl($url,array(),$options,$curlInfo);
        
        $this->defaultResponseRawValidator($response, $curlInfo);
        $json = json_decode($response);
        
        // para cada id, consulta individualmente
        $output = array();
        foreach($json->results AS $itemId){
            $output[] = $this->getProduct($itemId);
        }
        
        $metadataQuery = $json->paging;
        
        return $output;
    }
    
    /**
     * Retorna o código do produto do mercado livre a partir do nosso código
     * @param int $userId
     * @param string $sku
     * @param string $accessToken
     * @throws Exception
     * @return string
     */
    public function getProductIdBySKU(string $sku): string {
        $accessToken = $this->getAccessToken();
        $args = array();
        $args[] = "sku=".$sku;
        $args[] = "access_token=".$accessToken;
        $url = "https://api.mercadolibre.com/users/".$this->config["user_id"]."/items/search?".implode("&",$args);
        $options = array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json')
        );
        $curlInfo = null;
        $response = HTTPUtils::curl2($url,"GET",null,$options,$curlInfo);
        $this->defaultResponseRawValidator($response, $curlInfo);
        $json = json_decode($response);
        
        if($json->error != ""){
            throw new Exception("(getProductBySKU) ".$json->message);
        }
        
        if (empty($json->results)) {
            return "";
        }
        return $json->results[0];
    }
    
    public function getProductIdListBySKU(string $sku): array {
        $accessToken = $this->getAccessToken();
        $args = array();
        $args[] = "sku=".$sku;
        $args[] = "access_token=".$accessToken;
        $url = "https://api.mercadolibre.com/users/".$this->config["user_id"]."/items/search?".implode("&",$args);
        $options = array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json')
        );
        $curlInfo = null;
        $response = HTTPUtils::curl2($url,"GET",null,$options,$curlInfo);
        $this->defaultResponseRawValidator($response, $curlInfo);
        $json = json_decode($response);
        
        if($json->error != ""){
            throw new Exception("(getProductBySKU) ".$json->message);
        }
        
        if (empty($json->results)) {
            return array();
        }
        return $json->results;
    }
    
    public function getProductBySKU($sku){
        $productIdML = $this->getProductIdBySKU($sku);
        if($productIdML == ""){
            throw new Exception("Nenhum produto encontrado com código ".$sku,404);
        }
        $product = $this->getProduct($productIdML);
        if($product != null){
            $product->seller_custom_field = $sku;
        }
        
        return $product;
    }
    
    /**
     * Retorna um produto do MercadoLivre
     * @param string $itemId
     * @throws Exception
     * @return mixed
     */
    public function getProduct(string $itemId){
        if($itemId == ""){
            throw new Exception("(getProduct) Código do produto do MercadoLivre vazio");
        }
        
        $accessToken = $this->getAccessToken();
        
        $url = "https://api.mercadolibre.com/items/".$itemId."/?access_token=".$accessToken;
        $options = array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json')
        );
        $curlInfo = null;
        $response = HTTPUtils::curl2($url,"GET",null,$options,$curlInfo);
        $this->defaultResponseRawValidator($response, $curlInfo);
        $product = json_decode($response);
        
        // carregando categoria
        $product->category = $this->getCategoryInfo($product->category_id);
        
        return $product;
    }
    
    /**
     * Prediz a categoria pelo título do produto
     * @param $title
     * @return mixed
     */
    public function getCategoryByTitle(string $title){
        $url = "https://api.mercadolibre.com/sites/".self::SITE_ID."/category_predictor/predict?title=".urlencode($title);
        $curlInfo = array();
        $data = null;
        $options = array();
        $response = HTTPUtils::curl2($url,"GET",$data,$options,$curlInfo);
        $this->defaultResponseRawValidator($response, $curlInfo);
        $json = json_decode($response);
        return $json;
    }
    
    /**
     * Retorna uma lista de categorias
     */
    public function getCategoryList(){
        //$url = "https://api.mercadolibre.com/sites/".self::SITE_ID."/categories";
    }
    
    /**
     * Retorna informações de uma categoria do MercadoLivre
     * @param string $categoryId
     * @return mixed
     */
    public function getCategoryInfo(string $categoryId){
        if(array_key_exists($categoryId,self::$categoryIndexed)){
            return self::$categoryIndexed[$categoryId];
        }
        
        $url = "https://api.mercadolibre.com/categories/".$categoryId;
        $curlInfo = array();
        $response = HTTPUtils::curl($url,array(),array(),$curlInfo);
        $this->defaultResponseRawValidator($response, $curlInfo);
        $json = json_decode($response);
        
        self::$categoryIndexed[$categoryId] = $json;
        
        return $json;
    }
    
    /**
     * Insere um produto
     * @param Product $productML
     * @throws Exception
     * @return mixed
     */
    public function insertProduct(Product $productML){
        // validações
        if($productML->available_quantity <= 0){
            throw new Exception("O MercadoLivre só insere produtos com estoque maior que zero");
        }
        return $this->saveProduct($productML);
    }
    
    public function updateProductFieldsML(string $productIdML, array $data){
        if($productIdML == ""){
            throw new Exception("O produto não existe no mercadolivre");
        }
        
        $accessToken = $this->getAccessToken();
        $response = $this->meli->put("/items/".$productIdML, $data, array('access_token' => $accessToken));
        $this->defaultResponseValidator($response);
        return $response["body"];
    }
    
    public function updateProductFields(string $matnr, array $data){
        $productIdML = $this->getProductIdBySKU($matnr);
        if($productIdML == ""){
            throw new Exception("O produto ".$matnr." não existe no mercadolivre");
        }
        
        $this->updateProductFieldsML($productIdML, $data);
    }
    
    /**
     * Atualiza um produto
     * @param Product $productML
     * @throws Exception
     * @return mixed
     */
    public function updateProduct(Product $productML,$productIdML){
        // descomentar se quiser confirmar se esta atualizando
        //$productML->description["plain_text"] .= "\n\n Atualizado em ".date("d/m/Y H:i:s");
        
        return $this->saveProduct($productML,$productIdML);
    }
    
    /**
     * Insere ou atualiza um produto
     * @param Product $productML
     */
    public function saveProduct(Product $productML,$productIdML=""){
        $accessToken = $this->getAccessToken();
        $response = array();
        
        if($productIdML != ""){
            $productArray = $productML->toArray("update");
            $response = $this->meli->put("/items/".$productIdML, $productArray, array('access_token' => $accessToken));
        }else{
            $response = $this->meli->post("/items", $productML->toArray(), array('access_token' => $accessToken));
        }
        
        $this->defaultResponseValidator($response);
        
        // a descrição não é atualizada na atualização, deve chamar um método separado
        if($productIdML != ""){
            $data = array(
                "plain_text" => $productML->description["plain_text"]
            );
            $this->meli->put("/items/".$productIdML."/description", 
                $data, array('access_token' => $accessToken));
        }
        
        return $response["body"];
    }
    
    /**
     * Deleta um produto
     * @param string $matnr
     * @throws Exception
     */
    public function deleteProduct(string $matnr){
        // obtendo código do mercadolivre
        $productIdML = $this->getProductBySKU($matnr);
        if($productIdML == ""){
            throw new Exception("O produto ".$matnr." não foi encontrado no MercadoLivre");
        }
        
        $this->deleteProductML($productIdML);
    }
    
    public function deleteProductML(string $productIdML){
        // finalizando anuncio
        $data = array(
            "status"  => "closed"
        );
        try {
            $this->updateProductFieldsML($productIdML, $data);
        }catch(Exception $e){
        }
        
        // excluindo anuncio
        // tem que ser um após o outro senão da erro
        $data = array(
            "deleted" => "true"
        );
        $this->updateProductFieldsML($productIdML, $data);
    }
    
    public function validateProduct(Product $productML){
        $accessToken = $this->getAccessToken();
        $response = $this->meli->post("/items/validate", $productML->toArray(), array('access_token' => $accessToken));
        $this->defaultResponseValidator($response);
    }
    
    /**
     * Converte um produto do site em um produto do mercadolivre
     * @param ObjectVO $obj
     * @return \zion\marketplace\mercadolivre\Product
     */
    public function convertProduct(ObjectVO $obj) : Product
    {
        $featureList = $obj->get("features");
        $video = "";
        $description = "";
        $model = "";
        
        foreach ($featureList AS $feat) {
            if ($feat->get("featkey") == "desc") {
                $description = $feat->get("featval");
            } elseif ($feat->get("featkey") == "video") {
                $video = $feat->get("featval");
            } elseif ($feat->get("featkey") == "modelo") {
                $model = $feat->get("featval");
            }
        }
        
        $obj2 = new Product;
        $obj2->title = $obj->get("title");
        
        // detectando categoria automaticamente
        $category = $this->getCategoryByTitle($obj2->title);
        $obj2->category_id = $category->id;
        
        if ($obj2->category_id == "") {
            throw new \Exception("Não foi possível determinar categoria automaticamente");
        }
        
        $obj2->price = floatval($obj->get("price"));
        $obj2->currency_id = "BRL";
        $obj2->available_quantity = $obj->get("stock");
        $obj2->buying_mode = "buy_it_now";
        $obj2->listing_type_id = self::LISTING_TYPE_ID;
        $obj2->condition = "new";
        $obj2->description = [
            // trocando quebras HTML por quebras de texto
            "plain_text" => preg_replace('/<br\s?\/?>/i', "\r\n", $description)
        ];
        $obj2->video_id = $video;
        
        // texto de garantia
        $obj2->warranty = intval($obj->get("warranty"));
        
        if ($obj2->warranty == 1) {
            $obj2->warranty = $obj2->warranty." mês";
        } elseif ($obj2->warranty > 1) {
            $obj2->warranty = $obj2->warranty." meses";
        }

        $obj2->warranty = "** ".$obj2->warranty." de Garantia contra Defeitos de Fabricação
                     - Produto Novo e Original - Pronta Entrega - Acompanha Nota Fiscal 
                     - Rastreamento da Mercadoria **";
        
        $obj2->seller_custom_field = (string)$obj->get("productid");
        
        // imagens
        for ($i=0;$i<$obj->get("photo_count");$i++) {
            $obj2->pictures[] = new Picture("https://teste.com/produtos/".$obj->get("productid")."/550/".($i+1).".jpg");
        }
        
        // tags
        $obj2->tags = [
            "immediate_payment"
        ];
        
        // entrega
        $obj2->shipping = [
            "mode" => "me2",
            "local_pick_up" => false,
            "free_shipping" => false,
            "free_methods" => []
        ];
        
        // atributos
        // não tem problema enviar atributos que o produto não tem,
        // ele não vai aparecer se não for aplicável
        $obj2->attributes[] = [
            "id"         => "BRAND",
            "value_name" => $obj->get("brand")
        ];
        
        $obj2->attributes[] = [
            "id"         => "MODEL",
            "value_name" => $model
        ];
        
        $obj2->attributes[] = [
            "id"         => "EAN",
            "value_name" => $obj->get("ean")
        ];
        
        $obj2->attributes[] = [
            "id"         => "SELLER_SKU",
            "value_name" => $obj->get("productid")
        ];
        
        $obj2->attributes[] = [
            "id"         => "WEIGHT",
            "value_name" => $obj->get("weight")
        ];
        
        /*
        $obj2->attributes[] = array(
            "id"         => "AMOUNT_OF_KEYS",
            "value_name" => 114
        );
        */
        
        // status
        if ($obj->get("status") == "A") {
            $obj2->status = "active";
        } else {
            $obj2->status = "paused";
        }
        
        return $obj2;
    }
    
    /**
     * Retorna um produto do MercadoLivre preenchido para fins de teste
     * @return \zion\marketplace\mercadolivre\Product
     */
    public function getTestProduct() : Product
    {
        $obj = new Product;
        $obj->title = "Item De Teste - Por Favor, Não Ofertar! --kc:off";
        $obj->category_id = "MLB257111";
        $obj->price = 99997;
        $obj->currency_id = "BRL";
        $obj->available_quantity = 1;
        $obj->buying_mode = "buy_it_now";
        $obj->listing_type_id = "bronze";
        $obj->condition = "new";
        $obj->description = "Item de Teste. Mercado Livre's PHP SDK.";
        $obj->video_id = "Q6dsRpVyyWs";
        $obj->warranty = "12 month";
        $obj->pictures[] = new Picture("https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/IPhone_7_Plus_Jet_Black.svg/440px-IPhone_7_Plus_Jet_Black.svg.png");
        $obj->pictures[] = new Picture("https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/IPhone7.jpg/440px-IPhone7.jpg");
        $obj->seller_custom_field = "70";
        
        $obj->attributes[] = array(
            "id"         => "EAN",
            "value_name" => "5055377831530"
        );
        
        $obj->attributes[] = array(
            "id"               => "MYSKU",
            "name"             => "Código Interno",
            "value_type"       => "string",
            "value_max_length" => 18
        );
        
        return $obj;
    }
    
    /**
     * Obtem um token (access_token) para usar recursos privados no WebService do MercadoLivre
     * @throws Exception
     * @return string
     */
    public function getAccessToken()
    {
        return $this->config["access_token"];
    }
    
    /**
     * Renova o access token usado pelo sistema. 
     * Este método deve ser chamado periodicamente, porque o mercadolivre define uma validade para o token.
     * Atualmente o token dura 6 horas, então um job deve chamar este métedo a cada 5 horas para garantir 
     * que o token sempre estará válido
     * 
     * @throws Exception
     */
    public function renewAccessToken()
    {
        $redirect_uri = "https://".$_SERVER["SERVER_NAME"]."/mod/marketplace/mercadolivre/updateCode/";
        $user = $this->meli->authorize($this->config["code"], $redirect_uri);
        
        // se retornou 200, significa que o code informado é válido e o mercadolivre vai retornar várias informações, dentre elas
        // o access_token, refresh_token etc
        
        // Atenção! O 'code' pode ser usado somente uma vez, se chamar mais de uma vez o MercadoLivre vai retornar que esta 
        // expirado e com o status 400. Portanto, ao autorizar a primeira vez, salve os dados em um banco por exemplo, para ser usado 
        // futuramente
        if($user["httpCode"] == 200 AND $user['body']->access_token != "" AND $user['body']->refresh_token != "" AND $user['body']->user_id != ""){
            $data = array(
                'access_token'  => $user['body']->access_token,
                'token_type'    => $user['body']->token_type,
                'expires_in'    => $user['body']->expires_in,
                'scope'         => $user['body']->scope,
                'user_id'       => $user['body']->user_id,
                'refresh_token' => $user['body']->refresh_token
            );
            
            // atualizando token da instância
            $this->config = $data;
            return;
        }
        
        // Error validating grant. Your authorization code or refresh token may be expired or it was already used.
        // Code expirado ou já usado, usando o refresh_token para obter um novo access token
        if($user["httpCode"] == 400 AND $user["body"]->error == "invalid_grant"){
            $user = $this->meli->refreshAccessToken();
            if($user["httpCode"] == 200 AND $user['body']->access_token != "" AND $user['body']->refresh_token != "" AND $user['body']->user_id != ""){
                $data = array(
                    'access_token'  => $user['body']->access_token,
                    'token_type'    => $user['body']->token_type,
                    'expires_in'    => $user['body']->expires_in,
                    'scope'         => $user['body']->scope,
                    'user_id'       => $user['body']->user_id,
                    'refresh_token' => $user['body']->refresh_token
                );
                
                // atualizando token da instância
                $this->config = $data;
                return;
            }
        }
        
        throw new Exception("(MercadoLivre::getAccessToken) Não foi possível gerar accessToken");
    }
    
    /**
     * Cria um usuário de teste necessário para realizar todos os testes no ambiente de produção.
     * No mercadolivre, não há um ambiente de teste separado, tudo é feito no produção com uma conta de teste
     * Atenção! Não use a conta de produção para testes, use o usuário de testes! Isso pode causar diversos problemas
     * como prejudicar a reputação no mercadolivre, um cliente comprar um item de teste etc
     */
    public function createTestUser(string $accessToken) : stdClass {
        // o token para criar usuários de testes deve ser do produção! 
        // Não há como criar usuário de testes com uma conta de testes
        $url = "https://api.mercadolibre.com/users/test_user?access_token=".$accessToken;
        $data = json_encode(array("site_id" => self::SITE_ID));
        
        $options = array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json')
        );
        
        $curlInfo = array();
        $response = HTTPUtils::curl($url,$data,$options,$curlInfo);
        $this->defaultResponseRawValidator($response, $curlInfo);
        $json = json_decode($response);
        return $json;
    }
    
    /**
     * Retorna a url de autenticação
     * @return string
     */
    public function getAuthURL() : string {
        $redirect_uri = "https://".$_SERVER["SERVER_NAME"]."/mod/marketplace/mercadolivre/updateCode/";
        return $this->meli->getAuthUrl($redirect_uri, Meli::$AUTH_URL[self::SITE_ID]);
    }
    
    public static function getStatusList(){
        $list = array(
            "pending" => "Inactive items for debt or MercadoLibre policy violation",
            "not_yet_active" => "Items newly created or pending activation",
            "programmed" => "Items scheduled for future activation",
            "active" => "Active items",
            "paused" => "Paused Items",
            "closed" => "Closed Items"
        );
        return $list;
    }
    
    public static function getSubStatusList(){
        $list = array(
            "deleted"   => "Deleted substatus",
            "forbidden" => "Forbidden substatus",
            "freezed"   => "Freezed substatus",
            "held"      => "Held substatus",
            "suspended" => "Suspended substatus",
            "waiting_for_patch" => "Waiting for patch substatus",
            "warning" => "Warning items with MercadoLibre policy violation"
        );
        return $list;
    }
    
    public static function getListingTypeIdList(){
        $list = array(
            "gold_pro"     => "Gold proffesional",
            "gold_special" => "Gold special",
            "gold_premium" => "Gold premium",
            "gold"         => "Gold",
            "silver"       => "Silver",
            "bronze"       => "Bronze",
            "free"         => "Free"
        );
        return $list;
    }
    
    public static function getLabelList(){
        $list = array(
            "few_available" => "Items with few availables",
            "with_bids" => "Items with bids",
            "without_bids" => "Items whithout bids",
            "accepts_mercadopago" => "Items with MercadoPago",
            "ending_soon" => "Items ending in 20 days or less",
            "with_mercadolibre_envios" => "Items with MercadoLibre Envíos",
            "without_mercadolibre_envios" => "Items without MercadoLibre Envíos",
            "with_low_quality_image" => "Items with low quality image",
            "with_free_shipping" => "Items with free shipping",
            "without_free_shipping" => "Items with free shipping",
            "with_automatic_relist" => "Items with automatic relist",
            "waiting_for_payment" => "Items waiting for payment",
            "suspended" => "Suspended items",
            "cancelled" => "Items cancelled that can not be recovered",
            "being_reviewed" => "Items under review",
            "fix_required" => "Items waiting for user fix",
            "waiting_for_documentation" => "Items waiting for user documentation",
            "without_stock" => "Paused items that are out of stock"
        );
        return $list;
    }
    
    public static function getAvailableSort(){
        $sortList = array();
        $sortList[] = array(
            "id"   => "stop_time_asc",
            "name" => "Order by stop time ascending"
        );
        $sortList[] = array(
            "id"   => "stop_time_desc",
            "name" => "Order by stop time descending"
        );
        $sortList[] = array(
            "id"   => "start_time_asc",
            "name" => "Order by start time ascending"
        );
        $sortList[] = array(
            "id"   => "start_time_desc",
            "name" => "Order by start time descending"
        );
        $sortList[] = array(
            "id"   => "available_quantity_asc",
            "name" => "Order by available quantity ascending"
        );
        $sortList[] = array(
            "id"   => "available_quantity_desc",
            "name" => "Order by available quantity descending"
        );
        $sortList[] = array(
            "id"   => "sold_quantity_asc",
            "name" => "Order by sold quantity ascending"
        );
        $sortList[] = array(
            "id"   => "sold_quantity_desc",
            "name" => "Order by sold quantity descending"
        );
        $sortList[] = array(
            "id"   => "price_asc",
            "name" => "Order by price ascending"
        );
        $sortList[] = array(
            "id"   => "price_desc",
            "name" => "Order by price descending"
        );
        $sortList[] = array(
            "id"   => "last_updated_desc",
            "name" => "Order by lastUpdated descending"
        );
        $sortList[] = array(
            "id"   => "last_updated_asc",
            "name" => "Order by last updated ascending"
        );
        $sortList[] = array(
            "id"   => "total_sold_quantity_asc",
            "name" => "Order by total sold quantity ascending"
        );
        $sortList[] = array(
            "id"      => "total_sold_quantity_desc",
            "field"   => "sold_quantity",
            "missing" => "_last",
            "order"   => "desc",
            "name"    => "Order by total sold quantity descending"
        );
        $sortList[] = array(
            "id"      => "inventory_id_asc",
            "field"   => "inventory_id",
            "missing" => "_last",
            "order"   => "asc",
            "name"    => "Order by inventory id ascending"
        );
        return $sortList;
    }
    
    private function defaultResponseRawValidator($curlResponse,$curlInfo){
        if($curlResponse == ""){
            throw new Exception("(defaultResponseRawValidator) Resposta vazia",0);
        }
        
        $httpStatus = (string)$curlInfo["http_code"];
        if(strpos($httpStatus,"2") !== 0){
            throw new Exception("(defaultResponseRawValidator) Status ".$httpStatus." inválido (".$curlResponse.")",$httpStatus);
        }
        
        $json = json_decode($curlResponse);
        if($json === null){
            throw new Exception("(defaultResponseRawValidator) Resposta não é JSON",999);
        }
    }
    
    private function defaultResponseValidator($response){
        if($response == ""){
            throw new Exception("(defaultResponseValidator) Resposta vazia");
        }
        if(!is_array($response)){
            throw new Exception("(defaultResponseValidator) Resposta inválida");
        }
        
        if(strpos($response["httpCode"],"2") !== 0){
            if($response["httpCode"] == 404){
                throw new Exception("(defaultResponseValidator) Path não encontrado, verifique se a URL esta correta e se o método esta correto");
            }
            
            // verificando se tem a causa do problema
            if(!empty($response["body"]->cause)){
                throw new Exception("(defaultResponseValidator) ".$response["body"]->cause[0]->message);
            }
            throw new Exception("(defaultResponseValidator) ".$response["body"]->message);
        }
    }
}
?>