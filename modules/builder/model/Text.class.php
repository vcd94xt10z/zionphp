<?php 
namespace zion\mod\builder\model;

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
    
    public function __construct($moduleid,$entityid){
        $this->moduleid = $moduleid;
        $this->entityid = $entityid;
    }
    
    public function setModule($obj){
        $this->module = $obj;
    }
    
    public function setEntity($obj){
        $this->entity = $obj;
    }
    
    public function setField($obj){
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
    
    public function tip($id){
        if(!array_key_exists($id, $this->field)){
            return "";
        }
        
        if($this->field[$id] instanceof ObjectVO){
            return $this->field[$id]->get("tip");
        }
        
        return "";
    }
    
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
}
?>