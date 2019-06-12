<?php 
namespace zion\utils;

use zion\core\System;

/**
 * Classe experimental, ainda em testes, não utilizar!
 * @author Vinicius
 */
class Search {
    public static function test(){
        $db = System::getConnection();
        $dao = System::getDAO();
        $objList = $dao->queryAndFetch($db, "SELECT id, title FROM product");
        $resultList = self::search("Teclado", $objList, "title", "id");
        return $resultList;
    }
    
    /**
     * Retorna true se uma das palavras dois dois arrays batem, considerando a margem
     * de erros de letras configuradas (wrongMax)
     * @param array $list1
     * @param array $list2
     * @param number $wrongMax
     * @return boolean
     */
    public static function wrongLetterFilter(array $list1,array $list2,$wrongMax=1){
        foreach($list1 AS $word1){
            foreach($list2 AS $word2){
                if(strlen($word1) != strlen($word2)){
                    continue;
                }
                
                $size   = strlen($word1);
                $words1 = str_split($word1);
                $words2 = str_split($word2);
                
                $wrongCount = 0;
                for($i=0;$i<$size;$i++){
                    if($words1[$i] != $words2[$i]){
                        $wrongCount++;
                    }
                }
                
                return ($wrongCount <= $wrongMax);
            }
        }
        return false;
    }
    
    /**
     * Busca por relevancia
     * @param string $term
     * @param array $objList
     */
    public static function search(string $initialTerm,array $objList,$fieldText,$fieldKey){
        $initialTerm = strtolower($initialTerm);
        $terms = explode(" ",$initialTerm);
        $resultList = [];
        
        // [1/3] filtro
        foreach($objList AS $obj){
            $key  = $obj->get($fieldKey);
            $text = strtolower($obj->get($fieldText));
            $words = explode(" ",$text);
            
            // verifica se qualquer uma das palavras é comum
            $result = array_intersect($words,$terms);
            if(sizeof($result) > 0){
                $resultList[] = array(
                    "key"  => $key,
                    "text" => $text
                );
                continue;
            }
            
            // verifica se qualquer uma das palavras é comum, com margem de erro
            if(self::wrongLetterFilter($words,$terms,1)){
                $resultList[] = array(
                    "key"  => $key,
                    "text" => $text
                );
                continue;
            }
        }
        
        // [2/3] preparando ordenação
        foreach($resultList AS &$result){
            $words     = explode(" ",$result["text"]);
            $firstWord = $words[0];
            
            // primeira palavra
            $relevance0 = strpos($initialTerm,$firstWord." ");
            if($relevance0 === false){
                $relevance0 = 999999;
            }
            
            // indice da primeira palavra no texto
            $relevance1 = strpos($initialTerm,$firstWord);
            if($relevance1 === false){
                $relevance1 = 999999;
            }
            
            // juntando tudo 
            $result["relevance0"] = $relevance0;
            $result["relevance1"] = $relevance1;
        }
        
        // [3/3] ordenação efetiva
        $sortCriteria = array(
            'relevance0' => array(SORT_ASC, SORT_NUMERIC),
            'relevance1' => array(SORT_ASC, SORT_NUMERIC)
        );
        $resultList = ArrayUtils::multiSort($resultList, $sortCriteria);
        
        return $resultList;
    }
}
?>