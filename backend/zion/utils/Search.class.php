<?php 
namespace zion\utils;

/**
 * Classe experimental, ainda em testes, não utilizar!
 * @author Vinicius
 */
class Search {
    public static function search2(string $initialTerm,array $objList,$field){
        $resultList = [];
        
        foreach($objList AS $obj){
            $maxPercentual = 0;
            
            $terms = explode(" ",$initialTerm);
            foreach($terms AS $term){
                $percent = 0;
                $text = $obj->get($field);
                $count = similar_text(strtolower($text),strtolower($term),$percent);
                
                if($percent > $maxPercentual){
                    $maxPercentual = $percent;
                }
            }
            
            if($maxPercentual > 0){
                $resultList[] = array(
                    "text"    => $text,
                    "percent" => $maxPercentual,
                    "count"   => $count
                );
            }
        }
        
        $sortCriteria = array('percent' => array(SORT_DESC, SORT_REGULAR),'count' => array(SORT_DESC, SORT_NUMERIC));
        $resultList = ArrayUtils::multiSort($resultList, $sortCriteria);
        
        return $resultList;
    }
    
    /**
     * Busca por relevancia
     * @param string $term
     * @param array $objList
     */
    public static function search(string $initialTerm,array $objList,$field){
        $initialTerm = strtolower($initialTerm);
        $terms = explode(" ",$initialTerm);
        $resultList = [];
        
        // [1/2] filtro
        foreach($terms AS $term){
            $found = false;
            
            foreach($objList AS $obj){
                if($found){
                    break;
                }
                
                $words = explode(" ",strtolower($obj->get($field)));
                
                foreach($words AS $word){
                    // palavra exata
                    if($word == $term){
                        $resultList[] = array(
                            "title"   => $obj->get($field),
                            "count"   => strlen($word),
                            "percent" => 100
                        );
                        $found = true;
                        break;
                    }
                    
                    // palavras não exatas
                    $percent = 0;
                    $wordCount = similar_text($term,$word,$percent);
                    //$termCount = strlen($term);
                    
                    $data = array(
                        "title"   => $obj->get($field),
                        "count"   => $wordCount,
                        "percent" => $percent
                    );
                    
                    $minPercent = 70;
                    switch($wordCount){
                    case 3:
                        $minPercent = 60;
                        break;
                    case 4:
                        $minPercent = 75;
                        break;
                    case 5:
                        $minPercent = 80;
                        break;
                    }
                    
                    $minPercent = 1;
                    
                    if($percent >= $minPercent){
                        $resultList[] = $data;
                        $found = true;
                        break;
                    }
                }
            }
        }
        
        var_dump($resultList);exit();
        
        // [2/2] ordenação
        foreach($resultList AS &$result){
            $relevance0 = strpos($result[$field],$initialTerm);
            if($relevance0 === false){
                $relevance0 = 999999;
            }
            $result["relevance0"] = $relevance0;
        }
        
        return $resultList;
    }
}
?>