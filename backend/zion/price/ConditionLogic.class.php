<?php 
namespace zion\price;

use zion\orm\ObjectVO;

/**
 * Cada condição deve extender dessa classe
 * @author Vinicius
 */
abstract class ConditionLogic {
    /*
     * Inicialize as combinações (se houver) no construtor
     */
    protected $keys = [];
    
    /**
     * Inicializa a condição. Caso precise carregar dados adicionais, faça neste método
     * @param Price $price
     */
    public function __construct(Price &$price){
    }
    
    /**
     * Retorna as combinações possíveis para essa condição. 
     * Os valores serão substituidos posteriormente
     * Se a condição não for da VK/TK, provavalmente esse método não será usado
     * 
     * Exemplo:
     * A500-Z000-{WERKS}-{KONDA}-{MATNR}
     * A501-Z001-{WERKS}-{KONDA}-{KUNNR}
     * A502-Z002-{WERKS}-{KONDA}
     */
    public function getCombinations() : array {
        return $this->keys;
    }
    
    /**
     * Modifica a condição que pode ser simples ou complexa,
     * ter escalas etc, nesse método deve ser implementado toda a logica para procurar 
     * se a condição é válida e modificar o campo montante e saldo
     * 
     * @param Price $price
     * @param ObjectVO $header
     * @param ObjectVO $item
     * @param ObjectVO $cond
     */
    abstract public function calc1(Price &$price, ObjectVO &$header, ObjectVO &$item, ObjectVO &$cond);
    
    /**
     * Este método é especifico para condições de agrupamento, que precisam ser verificada após a 
     * price dos itens estiverem completas. Se a condição não é de agrupamento, não precisa sobreescrever
     * este método
     * 
     * @param Price $price
     * @param ObjectVO $header
     * @param ObjectVO $item
     * @param ObjectVO $cond
     */
    public function calc2(Price &$price, ObjectVO &$header, ObjectVO &$item, ObjectVO &$cond){
        return null;
    }
    
    /**
     * Esse método serve para analisar o montante e recalcular o saldo, por causa das condições de agrupamento
     * executadas no calc2. Condições informativas (que não afetam o saldo) não precisam sobreescrever este método
     *  
     * @param Price $price
     * @param ObjectVO $header
     * @param ObjectVO $item
     * @param ObjectVO $cond
     */
    public function calc3(Price &$price, ObjectVO &$header, ObjectVO &$item, ObjectVO &$cond){
        return null;
    }
}
?>