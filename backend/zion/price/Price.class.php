<?php
namespace zion\price;

use Exception;
use zion\core\System;
use zion\orm\ObjectVO;

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
    protected $tables = array(
        "condition"    => "condition",
        "condition_vk" => "condition_vk"
    );
    
    /**
     * Namespace que o sistema vai procurar as classes das condições
     * @var string
     */
    protected $namespaceConditions = "";
    
    /**
     * Lista de itens com todos os valores preenchidos
     * @var array
     */
    protected $itemList = array();
    
    /**
     * Combinações das condições
     * @var array
     */
    protected $combinations = array();
    
    /**
     * Lista de condições dos itens
     * @var array
     */
    protected $itemConditionList = array();
    
    /**
     * Condições ativas no site
     * @var array
     */
    protected $activeConditionList = array();
    
    /**
     * Valores das condições
     * @var array
     */
    protected $conditionVKList = array();
    
    /**
     * Condições ignoradas
     * @var array
     */
    protected $ignoreConditions = array();
    
    /**
     * Total por valor no agrupamento
     * @var array
     */
    public $totalValueKONDM = array();
    
    /**
     * Total por quantidade no agrupamento
     * @var array
     */
    public $totalQuantityKONDM = array();
    
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
    
    public function ignoreConditions(array $list){
        $this->ignoreConditions = $list;
    }
    
    /**
     * Retorna o valor de uma condição, sempre é array porque
     * pode ter escala
     * @param string $keyPrefix
     * @return array
     */
    public function getConditionVK(string $keyPrefix) : array {
        foreach($this->conditionVKList AS $k => $v){
            if(strpos($k,$keyPrefix) === 0){
                return $v;
            }
        }
        return array();
    }
    
    public function getItemConditionList($posnr = null) : array {
        if($posnr == null){
            return $this->itemConditionList;
        }
        
        $result = array();
        foreach($this->itemConditionList AS $cond){
            if($cond->get("posnr") == $posnr){
                $result[] = $cond;
            }
        }
        return $result;
    }
    
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
            $class = $this->namespaceConditions.$name;
            if(class_exists($class)){
                return new $class;
            }
        }catch(Exception $e){
        }
        return null;
    }
    
    /**
     * Carrega as condições do item
     * @param ObjectVO $item
     */
    public function loadConditionsItem(ObjectVO $header, ObjectVO $item){
        // trocando variaveis
        $keys = $this->combinations;
        for($i=0;$i<sizeof($keys);$i++){
            // cabeçalho
            $keys[$i] = str_replace("{VKORG}",$header->get("vkorg"),$keys[$i]);
            $keys[$i] = str_replace("{WERKS}",$header->get("werks"),$keys[$i]);
            $keys[$i] = str_replace("{VTWEG}",$header->get("vtweg"),$keys[$i]);
            $keys[$i] = str_replace("{KONDA}",$header->get("konda"),$keys[$i]);
            $keys[$i] = str_replace("{KUNNR}",$header->get("kunnr"),$keys[$i]);
            
            // item
            $keys[$i] = str_replace("{MATNR}",$item->get("matnr"),$keys[$i]);
            $keys[$i] = str_replace("{KONDM}",$item->get("kondm"),$keys[$i]);
        }
        
        $this->conditionVKList = array();
        if(sizeof($keys) <= 0){
            return;
        }
        
        // consultando banco de dados
        $sql = "SELECT *
                  FROM `{$this->tables["condition_vk"]}`
                 WHERE `key` IN (\"".implode("\",\"",$keys)."\")
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
     * Calcula a price de um item, sem considerar agrupamentos! Já
     * adiciona a price do item na price global
     * @param ObjectVO $item
     * @return array
     */
    public function addPriceItem(ObjectVO $header, ObjectVO &$item){
        $this->loadActiveConditions();
        $this->loadConditionsItem($header, $item);
        
        $this->step1($header,$item);
        $this->step2($header,$item);
        $this->step3($header,$item);
    }
    
    /**
     * Etapa 1 - Calcular a price de cada item, condições de agrupamento não serão
     * aplicadas nessa etapa pois precisam considerar o valor de outros itens somente
     * após a price de todos os itens estiverem calculadas
     * 
     * @param ObjectVO $header
     * @param ObjectVO $item
     */
    public function step1(ObjectVO $header, ObjectVO &$item){
        $saldo = 0;
        $itemConditionList = array();
        foreach($this->activeConditionList AS $activeCond){
            // ignorando condições informadas pelo usuário
            if(in_array($activeCond->get("kschl"),$this->ignoreConditions)){
                continue;
            }
            
            $cond = new ObjectVO();
            $cond->set("posnr",$item->get("posnr"));
            $cond->set("kschl",$activeCond->get("kschl"));
            $cond->set("konwa",$activeCond->get("konwa"));
            $cond->set("montante",0);
            $cond->set("level",$activeCond->get("level"));
            $cond->set("saldo",$saldo);
            
            $logic = $this->getInstanceCondition($activeCond->get("kschl"));
            if($logic != null){
                $logic->calc1($this,$header,$item,$cond);
                $itemConditionList[] = $cond;
                $saldo = $cond->get("saldo");
            }
        }
        
        $item->set("value_unitary",$saldo);
        $item->set("value_total",$item->get("quantity") * $item->get("value_unitary"));
        
        // juntando as condições do novo item
        $this->itemConditionList = array_merge($this->itemConditionList,$itemConditionList);
    }
    
    /**
     * Etapa 2 - Nessa etapa deve ser atualizado somente o campo montante das condições de agrupamento
     * 
     * @param ObjectVO $header
     * @param ObjectVO $item
     */
    public function step2(ObjectVO $header, ObjectVO &$item){
        for($i=0;$i<sizeof($this->itemConditionList);$i++){
            $logic = $this->getInstanceCondition($this->itemConditionList[$i]->get("kschl"));
            if($logic != null){
                $logic->calc2($this,$header,$item,$this->itemConditionList[$i]);
            }
        }
    }
    
    /**
     * Etapa 3 - Nesta etapa só deve-se verificar o montante da condição e verificar se o saldo
     * 
     * precisa ser atualizado
     * @param ObjectVO $header
     * @param ObjectVO $item
     */
    public function step3(ObjectVO $header, ObjectVO &$item){
        // indexando por posnr
        $conditionByItem = array();
        foreach($this->itemConditionList AS $cond){
            $conditionByItem[$cond->get("posnr")][] = $cond;
        }
        
        // modificando o saldo
        foreach($conditionByItem AS $i => $v){
            $saldo = 0;
            for($j=0;$j<sizeof($conditionByItem[$i]);$j++){
                $logic = $this->getInstanceCondition($conditionByItem[$i][$j]->get("kschl"));
                if($logic != null){
                    $conditionByItem[$i][$j]->set("saldo",$saldo);
                    $logic->calc3($this,$header,$item,$conditionByItem[$i][$j]);
                    $saldo = $conditionByItem[$i][$j]->get("saldo");
                }
            }
        }
        
        // sobreescrevendo condições
        $this->itemConditionList = array();
        foreach($conditionByItem AS $k => $v){
            $this->itemConditionList = array_merge($this->itemConditionList,$v);
        }
    }
}
?>