<?php 
namespace zion\mod\builder\model;

use Exception;
use zion\core\System;
use zion\orm\ObjectVO;

/**
 * Gerenciador de textos da entidade
 * @author Vinicius
 */
class Text {
    private $moduleid = "";
    private $entityid = "";
    
    private $module = null;
    private $entity = null;
    private $field = array();
    
    private static $data = array();
    
    public function __construct($moduleid,$entityid){
        $this->moduleid = $moduleid;
        $this->entityid = $entityid;
    }
    
    public function setModule(ObjectVO $obj){
        $this->module = $obj;
    }
    
    public function setEntity(ObjectVO $obj){
        $this->entity = $obj;
    }
    
    public function setField(ObjectVO $obj){
        $this->field[$obj->get("field")] = $obj;
    }
    
    public function module($size="full"){
        if(is_string($this->module)){
            return $this->module;
        }
        
        if($this->module instanceof ObjectVO){
            $text = $this->findText($size,$this->module);
            if($text != ""){
                return $text;
            }
        }
        
        return $this->moduleid;
    }
    
    public function entity($size="full"){
        if(is_string($this->entity)){
            return $this->entity;
        }
        
        if($this->entity instanceof ObjectVO){
            $text = $this->findText($size,$this->entity);
            if($text != ""){
                return $text;
            }
        }
        
        return $this->entityid;
    }
    
    public function field($id,$size="full"){
        if(!array_key_exists($id, $this->field)){
            return $id;
        }
        
        if($this->field[$id] instanceof ObjectVO){
            $text = $this->findText($size,$this->field[$id]);
            if($text != ""){
                return $text;
            }
        }
        
        return $id;
    }
    
    /**
     * Retorna a dica do campo
     * @param string $id
     * @return string
     */
    public function tip($id){
        if(!array_key_exists($id, $this->field)){
            return "";
        }
        
        if($this->field[$id] instanceof ObjectVO){
            return $this->field[$id]->get("tip");
        }
        
        return "";
    }
    
    /**
     * Procura o texto no objeto com base em uma lista de prioridades
     * @param string $main
     * @param ObjectVO $obj
     * @return string
     */
    private function findText($main,ObjectVO $obj){
        $sizes = array($main."_text","short_text","medium_text","full_text");
        foreach($sizes AS $size){
            $text = $obj->get($size);
            if($text != ""){
                return $text;
            }
        }
        return "";
    }
    
    /**
     * Retorna os textos usados pela entidade como módulo, entidade e campos
     * @param string $moduleid
     * @param string $entityid
     * @return \zion\mod\builder\model\Text|mixed
     */
    public static function getEntityTexts($moduleid,$entityid){
        $lang = "pt-BR";
        $obj = self::$data[$lang][$moduleid][$entityid];
        if($obj == null){
            $obj = new Text($moduleid,$entityid);
        }
        return $obj;
    }
    
    /**
     * Retorna os textos da entidade no idioma atual
     * @param string $moduleid
     * @param string $entityid
     * @param string $lang
     * @return \zion\mod\builder\model\Text
     */
    public static function loadTexts($moduleid,$lang=null){
        if($lang == null){
            $lang = "pt-BR";
        }
        
        // obtendo dados
        try {
            $db = System::getConnection();
            $dao = System::getDAO($db,"zion_builder_text");
            $keys = array(
                "mandt"    => 0,
                "lang"     => $lang,
                "moduleid" => $moduleid
            );
            $texts = $dao->getArray($db,$keys);
            $db = null;
            $dao = null;
            
            // organizando dados
            $moduleObj  = null;
            $entityList = array();
            $fieldList  = array();
            
            foreach($texts AS $obj){
                $entityid = $obj->get("entityid");
                
                // modulo
                if($entityid == ""){
                    $moduleObj = $obj;
                    continue;
                }
                
                // entidade
                if($obj->get("field") == ""){
                    $entityList[$entityid] = $obj;
                    continue;
                }
                
                // campo
                $fieldList[$entityid][$obj->get("field")] = $obj;
            }
            
            // armazenando dados
            foreach($entityList AS $entityid => $entity){
                $t = new Text($moduleid, $entityid);
                $t->setModule($moduleObj);
                $t->setEntity($entity);
                
                foreach($fieldList[$entityid] AS $field){
                    $t->setField($field);
                }
                
                self::$data[$lang][$moduleid][$entityid] = $t;
            }
        }catch(Exception $e){
        }
    }
}
?>