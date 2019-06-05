<?php 
namespace zion\mod\proj\model;

class ProjectUtils {
    public static $featureStatus = [
        "E" => array("label" => "Em execução", "color" => "#000"),
        "P" => array("label" => "Parado", "color" => "#ff6600"),
        "C" => array("label" => "Concluído", "color" => "#0a0"),
        "X" => array("label" => "Cancelado", "color" => "#a00")
    ];
    
    public static $featureComplexity = [
        "B" => array("label" => "Baixa", "color" => "#0a0"),
        "M" => array("label" => "Média", "color" => "#00a"),
        "A" => array("label" => "Alta", "color" => "#a00")
    ];
    
    public static function getFeatureStatus($status){
        return self::$featureStatus[$status];
    }
    
    public static function getFeatureComplexity($status){
        return self::$featureComplexity[$status];
    }
    
    public static function booleanAnswer($bool){
        if($bool){
            return "Sim";
        }else{
            return "Não";
        }
    }
    
    public static function getBooleanStatus($bool){
        if($bool){
            return array("label" => "Sim", "color" => "#0a0");
        }else{
            return array("label" => "Não", "color" => "#a00");
        }
    }
}
?>