<?php
namespace zion\price;

use Exception;
use zion\core\System;
use zion\orm\ObjectVO;
use zion\utils\StringUtils;
use zion\utils\TimeCounter;

/**
 * Classe para calcular a price dos itens
 * Versão experimental, use por sua conta e risco
 * 
 * @author Vinicius
 * @since 05/09/2019
 */
class Price {
    /**
     * Tabelas usadas internamente
     * @var array
     */
    protected $tables = [
        "condition"    => "condition",
        "condition_vk" => "condition_vk"
    ];
    
    /**
     * Namespace que o sistema vai procurar as classes das condições
     * @var string
     */
    protected $namespaceConditions = "";
    
    /**
     * Cabeçalho do pedido
     * @var array
     */
    protected $header = [];
    
    /**
     * Lista de itens com todos os valores preenchidos
     * @var array
     */
    protected $itemList = [];
    
    /**
     * Instâncias das condições
     */
    protected $conditionInstance = [];
    
    /**
     * Combinações das condições
     * @var array
     */
    protected $combinations = [];
    
    /**
     * Condições ativas no site
     * @var array
     */
    protected $activeConditionList = [];
    
    /**
     * Valores das condições
     * @var array
     */
    protected $conditionVKList = [];
    
    /**
     * Condições ignoradas
     * @var array
     */
    protected $ignoreConditions = [];
    
    /**
     * Total por valor no agrupamento
     * @var array
     */
    protected $totalValueKONDM = [];
    
    /**
     * Total por quantidade no agrupamento
     * @var array
     */
    protected $totalQuantityKONDM = [];
    
    /**
     * É obrigatório informar qual namespace das condições onde o sistema vai
     * procurar a lógica de calculo. O sistema vai procurar no namespace uma
     * classe com o nome da condição, exemplo:
     * - Namespace: app\condition;
     * - Condição PRECO_BASE => Classe app\condition\PRECO_BASE.class.php
     * 
     * Cada condição deve extender da classe abstrata ConditionLogic
     * @param string $namespaceConditions
     */
    public function __construct(array $config){
        if(!array_key_exists("namespaceConditions",$config)){
            throw new Exception("A configuração namespaceConditions é obrigatória");
        }
        $this->namespaceConditions = rtrim($config["namespaceConditions"],"\\")."\\";
        
        if(array_key_exists("tables",$config)){
            $this->tables = $config["tables"];
        }
    }
    
    /**
     * Define o cabeçalho do pedido
     * @param ObjectVO $obj
     */
    public function setHeader(ObjectVO $obj){
        $this->header = $obj;
    }
    
    /**
     * Retorna o cabeçalho do pedido
     */
    public function getHeader(){
        return $this->header;
    }
    
    /**
     * Retorna a lista de itens
     * @return array
     */
    public function getItemList() : array {
        return $this->itemList;
    }
    
    /**
     * Retorna uma lista de itens indexados
     * @param string $field
     * @return array
     */
    public function getItemListIndexedBy(string $field) : array {
        $output = [];
        foreach($this->itemList AS $item){
            $output[$item->get($field)] = $item;
        }
        return $output;
    }
    
    /**
     * Retorna um item especifico
     * @param string $keyName
     * @param string $keyValue
     * @return array
     */
    public function getItem(string $keyName,string $keyValue){
        foreach($this->itemList AS $item){
            if($item->get($keyName) == $keyValue){
                return $item;
            }
        }
    }
    
    /**
     * Incrementa o valor total da condição de agrupamento
     */
    public function incTotalValueKONDM(string $kondm, float $val){
        $this->totalValueKONDM[$kondm] += $val;
    }
    
    /**
     * Incrementa a quantidade total da condição de agrupamento
     */
    public function incTotalQuantityKONDM(string $kondm, $val){
        $this->totalQuantityKONDM[$kondm] += $val;
    }
    
    /**
     * Retorna o valor total da condição de agrupamento
     * @param string $kondm
     * @return float
     */
    public function getTotalValueKONDM(string $kondm) : float {
        return $this->totalValueKONDM[$kondm];
    }
    
    /**
     * Retorna a quantidade total da condição de agrupamento
     * @param string $kondm
     * @return float
     */
    public function getTotalQuantityKONDM(string $kondm){
        return $this->totalQuantityKONDM[$kondm];
    }
    
    /**
     * Ignora determinadas condições, mesmo que elas estejam ativas
     * @param array $list
     */
    public function ignoreConditions(array $list){
        $this->ignoreConditions = $list;
    }
    
    /**
     * Troca os valores na combinação
     * @param string $key
     * @param ObjectVO $header
     * @param ObjectVO $item
     * @return string
     */
    public function replaceValuesVK(string $key, ObjectVO $header, ObjectVO $item) : string {
        $fields = StringUtils::extractFieldsFromPattern($key,"{","}");
        
        // primeiro procura o campo no item, se não existir, procura no cabeçalho
        foreach($fields AS $field){
            $field2 = strtolower($field);
            
            // item
            if($item->has($field2)){
                $key = str_replace("{".$field."}",$item->get($field2),$key);
            }
            
            // cabeçalho
            if($this->header->has($field2)){
                $key = str_replace("{".$field."}",$this->header->get($field2),$key);
            }
        }
        
        return $key;
    }
    
    /**
     * Retorna o valor de uma condição, sempre é array porque
     * pode ter escala
     * @param string $keyPrefix
     * @return array
     */
    public function getConditionVK(string $key, ObjectVO $header, ObjectVO $item) : array {
        $key = $this->replaceValuesVK($key, $header, $item);
        
        foreach($this->conditionVKList AS $k => $v){
            if($k == $key){
                return $v;
            }
        }
        return [];
    }
    
    /**
     * Retorna as condições da VK carregadas
     * @return array
     */
    public function getConditionVKList() : array {
        return $this->conditionVKList;
    }
    
    /**
     * Carrega as condições ativas no momento
     */
    public function loadActiveConditions(){
        // carregando dados
        $sql = "SELECT *
                  FROM `{$this->tables["condition"]}`
                 WHERE `status` = 'A'
              ORDER BY `level` ASC";
        
        $db  = System::getConnection();
        $dao = System::getDAO();
        $this->activeConditionList = $dao->queryAndFetch($db, $sql);
        $dao = null;
        $db = null;
        
        // carregando combinações
        $this->combinations = array();
        foreach($this->activeConditionList AS $c){
            $obj = $this->getInstanceCondition($c->get("kschl"));
            if($obj != null){
                $this->combinations = array_merge($this->combinations,$obj->getCombinations());
            }
        }  
    }
    
    /**
     * Retorna uma instância de uma condição
     * @param string $name
     * @return ConditionLogic
     */
    public function getInstanceCondition(string $name){
        try {
            if(array_key_exists($name,$this->conditionInstance)){
                return $this->conditionInstance[$name];
            }
            
            $class = $this->namespaceConditions.$name;
            if(class_exists($class)){
                $obj = new $class($this);
                $this->conditionInstance[$name] = $obj;
                return $obj;
            }
        }catch(Exception $e){
        }
        return null;
    }
    
    /**
     * Carrega as condições dos itens
     * @param ObjectVO $item
     */
    public function loadConditionsItemList(){
        $this->conditionVKList = [];
        $allKeys = [];
        
        foreach($this->itemList AS $item){
            // trocando variaveis
            $keys = $this->combinations;
            for($i=0;$i<sizeof($keys);$i++){
                $keys[$i] = $this->replaceValuesVK($keys[$i], $this->header, $item);
            }
            $allKeys = array_merge($allKeys,$keys);
        }
        
        if(sizeof($allKeys) <= 0){
            return;
        }
        
        // consultando banco de dados
        $sql = "SELECT *
                  FROM `{$this->tables["condition_vk"]}`
                 WHERE `key` IN (\"".implode("\",\"",$allKeys)."\")
                   AND DATE(NOW()) BETWEEN `datea` AND `datez`
                   AND `status` <> 'X'
              ORDER BY `key` ASC, `scale_amount` ASC";
        
        $db = System::getConnection();
        $dao = System::getDAO();
        $options = [
            "indexedByNUK" => "key"
        ];
        $this->conditionVKList = $dao->queryAndFetch($db, $sql, null, $options);
        $dao = null;
        $db = null;
    }
    
    /**
     * Adiciona um item para calcular o preço posteriormente
     * @param ObjectVO $item
     * @return array
     */
    public function addItem(ObjectVO $item){
        $this->itemList[] = $item; 
    }
    
    /**
     * Faz todas as consultas necessárias e calculos para gerar a price.
     * Só chame esse método após adicionar todos os itens que deseja calcular a price.
     * 
     * Lembrando que se deseja calcular o preço de vários itens que não estejam no mesmo
     * carrinho, é necessário suprimir condições de agrupamento!
     */
    public function execute(){
        TimeCounter::start("price");
        $this->loadActiveConditions();
        $this->loadConditionsItemList();
        
        $itemCount = sizeof($this->itemList);
        
        // etapa 1 de todos os itens
        for($i=0;$i<$itemCount;$i++){
            $this->step1($this->header,$this->itemList[$i]);
        }
        
        // etapa 2 de todos os itens
        for($i=0;$i<$itemCount;$i++){
            $this->step2($this->header,$this->itemList[$i]);
        }
        
        // etapa 3 de todos os itens
        for($i=0;$i<$itemCount;$i++){
            $this->step3($this->header,$this->itemList[$i]);
        }
        
        TimeCounter::stop("price");
        
        // coletando tempo
        $time = [
            "price" => TimeCounter::duration("price","sec")
        ];
        
        return $time;
    }
    
    /**
     * Objetivo: Calcular o montante, o saldo e acumular valores para agrupamento
     * 
     * Calcular a price de cada item, condições de agrupamento não serão
     * aplicadas nessa etapa pois precisam considerar o valor de outros itens somente
     * após a price de todos os itens estiverem calculadas
     * 
     * @param ObjectVO $header
     * @param ObjectVO $item
     */
    public function step1(ObjectVO &$header, ObjectVO &$item){
        $saldo = 0;
        $itemConditionList = array();
        foreach($this->activeConditionList AS $activeCond){
            $cond = new ObjectVO();
            $cond->set("posnr",$item->get("posnr"));
            $cond->set("matnr",$item->get("matnr"));
            $cond->set("kschl",$activeCond->get("kschl"));
            $cond->set("konwa",$activeCond->get("konwa"));
            $cond->set("montante",0);
            $cond->set("level",$activeCond->get("level"));
            $cond->set("saldo",$saldo);
            
            // ignorando condições informadas pelo usuário, mantendo no histórico
            if(in_array($activeCond->get("kschl"),$this->ignoreConditions)){
                $itemConditionList[] = $cond;
                continue;
            }
            
            $logic = $this->getInstanceCondition($activeCond->get("kschl"));
            if($logic != null){
                $logic->calc1($this,$header,$item,$cond);
                $itemConditionList[] = $cond;
                $saldo = $cond->get("saldo");
            }
        }
        
        $item->set("conditionList",$itemConditionList);
    }
    
    /**
     * Objetivo: Atualizar o montante da condição
     * 
     * Nessa etapa deve ser atualizado somente o campo montante das condições de agrupamento
     * 
     * @param ObjectVO $header
     * @param ObjectVO $item
     */
    public function step2(ObjectVO &$header, ObjectVO &$item){
        $conditionList = $item->get("conditionList");
        $count = sizeof($conditionList);
        
        for($i=0;$i<$count;$i++){
            $logic = $this->getInstanceCondition($conditionList[$i]->get("kschl"));
            if($logic != null){
                $logic->calc2($this,$header,$item,$conditionList[$i]);
            }
        }
        
        $item->set("conditionList",$conditionList);
    }
    
    /**
     * Objetivo: Atualizar o saldo da condição 
     * 
     * Nesta etapa só deve-se verificar o montante da condição e verificar se o saldo
     * precisa ser atualizado
     * 
     * @param ObjectVO $header
     * @param ObjectVO $item
     */
    public function step3(ObjectVO &$header, ObjectVO &$item){
        $conditionList = $item->get("conditionList");
        $count = sizeof($conditionList);
        
        // modificando o saldo
        $saldo = 0;
        for($i=0;$i<$count;$i++){
            $cond = &$conditionList[$i];
            
            $logic = $this->getInstanceCondition($cond->get("kschl"));
            if($logic != null){
                $cond->set("saldo",$saldo);
                $logic->calc3($this,$header,$item,$cond);
                $saldo = $cond->get("saldo");
            }
        }
        $item->set("conditionList",$conditionList);
        
        // deduções
        $item->set("value_unitary",$saldo);
        $item->set("value_total",$saldo * $item->get("quantity"));
    }
}
?>