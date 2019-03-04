<?php
namespace zion\orm;

use zion\utils\TextFormatter;

/**
 * @author Vinicius Cesar Dias
 */
class Filter {
    public static $optionsOP = [
        // operadores de 1 campo
        "="       => "igual",
        "<>"      => "diferente",
        ">"       => "maior que",
        ">="      => "maior ou igual a",
        "<"       => "menor que",
        "<="      => "menor ou igual a",
        "NULL"    => "vazio",
        "NNULL"   => "preenchido",
        "IN"      => "na lista",
        "NI"      => "não na lista",
        "%LIKE%"  => "contém",
        "%NLIKE%" => "não contém",
        "LIKE%"   => "começa com",
        "NLIKE%"  => "não começa com",
        "%LIKE"   => "termina com",
        "%NLIKE"  => "não termina com",
        "REGEXP"  => "expressão regular",
        
        // operadores de 2 campos
        "BT"      => "entre",
        "NBT"     => "não entre"
    ];
    
    protected $filterList = [];
    protected $sortList = [];
    protected $offset = 0;
    protected $limit = 0;
    protected $groupMap = "";
    protected $groupByList = [];
    
    public function __construct(array $keys = array()) {
        foreach($keys AS $key => $value){
            $this->eq($key,$value);
        }
    }
    
    public static function getOperators() : array {
        return self::$optionsOP;
    }

    /**
     * Define um mapa de grupo nas condições WHERE
     * Exemplo: (:g1: AND :g2:) OR (:g3: OR :g4:) ...
     */
    public function setGroupMap($map) {
        $this->groupMap = $map;
    }

    public function getGroupMap() {
        return $this->groupMap;
    }

    public function getGroupList() {
        return array_keys($this->filterList);
    }

    public function setGroupByList($groupByList) {
        $this->groupByList = $groupByList;
    }

    public function getGroupByList() {
        return $this->groupByList;
    }

    public function addGroupBy($groupBy) {
        $this->groupByList[] = $groupBy;
    }

    /**
     * Adiciona um filtro (WHERE)
     * @param group agrupa as condições de filtro
     */
    public function addFilter(string $name, string $operator, $value1 = null, $value2 = null, $group = "default", $oplogic = "AND") {
        $this->filterList[$group][] = [
            "name" => $name,
            "operator" => $operator,
            "value1" => $value1,
            "value2" => $value2,
            "oplogic" => $oplogic
        ];
    }
    
    public function addFilterField(string $name,string $type,array $field,string $group = "default", string $oplogic = "AND"){
        // se o operador não for informado e nenhum valor for informado, então não filtra nada
        if($field["operator"] == "" AND $field["low"] == ""){
            return;
        }
        
        // quando não informado, o padrão é %like%
        if($field["operator"] == ""){
            $field["operator"] = "%LIKE%";
        }
        
        $this->filterList[$group][] = [
            "name" => $name,
            "operator" => $field["operator"],
            "value1" => TextFormatter::parse($type, $field["low"]),
            "value2" => TextFormatter::parse($type, $field["high"]),
            "oplogic" => $oplogic
        ];
    }

    public function getFilterList() {
        return $this->filterList;
    }

    public function addSort(string $name, string $direction) {
        if($name == ""){
            return;
        }
        
        $direction = strtoupper($direction);
        if(!in_array($direction,array("ASC","DESC"))){
            $direction = "ASC";
        }
        
        $this->sortList[] = [
            "name" => $name,
            "order" => $direction
        ];
    }

    public function getSortList() {
        return $this->sortList;
    }

    public function setLimit($limit) {
        $this->limit = $limit;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setOffset($offset) {
        $this->offset = $offset;
    }

    public function getOffset() {
        return $this->offset;
    }

    public function eq($name, $value, $group = "default", $oplogic = "AND") {
        $this->addFilter($name, "=", $value, null, $group, $oplogic);
    }

    public function le($name, $value, $group = "default", $oplogic = "AND") {
        $this->addFilter($name, "<=", $value, null, $group, $oplogic);
    }

    public function ge($name, $value, $group = "default", $oplogic = "AND") {
        $this->addFilter($name, ">=", $value, null, $group, $oplogic);
    }

    public function gt($name, $value, $group = "default", $oplogic = "AND") {
        $this->addFilter($name, ">", $value, null, $group, $oplogic);
    }
    
    public function ne($name, $value, $group = "default", $oplogic = "AND") {
        $this->addFilter($name, "<>", $value, null, $group, $oplogic);
    }

    public function isNull($name, $group = "default", $oplogic = "AND") {
        $this->addFilter($name, "NULL", null, null, $group, $oplogic);
    }

    public function isNotNull($name, $group = "default", $oplogic = "AND") {
        $this->addFilter($name, "NNULL", null, null, $group, $oplogic);
    }

    public function in($name, $list, $group = "default", $oplogic = "AND") {
        if (is_array($list)) {
            $list = implode(",", $list);
        }
        $this->addFilter($name, "IN", $list, null, $group, $oplogic);
    }

    public function ni($name, $list, $group = "default", $oplogic = "AND") {
        if (is_array($list)) {
            $list = implode(",", $list);
        }
        $this->addFilter($name, "NI", $list, null, $group, $oplogic);
    }
    
    public function regexp($name, $list, $group = "default", $oplogic = "AND") {
        if (is_array($list)) {
            $list = implode("|", $list);
        }
        $this->addFilter($name, "RGXP", $list, null, $group, $oplogic);
    }
    
    public function starts($name,$value,$group = "default", $oplogic = "AND"){
        $this->addFilter($name,"LIKE",$value."%",null,$group,$oplogic);
    }
    
    public function ends($name,$value,$group = "default", $oplogic = "AND"){
        $this->addFilter($name,"LIKE","%".$value,null,$group,$oplogic);
    }
    
    public function contains($name,$value,$group = "default", $oplogic = "AND"){
        $this->addFilter($name,"LIKE","%".$value."%",null,$group,$oplogic);
    }

    public function clear() {
        $this->filterList = array();
        $this->tsortList = array();
        $this->toffset = 0;
        $this->tlimit = 0;
        $this->tgroupMap = "";
        $this->groupByList = array();
    }
}
?>