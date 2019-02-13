<?php
namespace zion\mod\builder\model;

use Exception;
use zion\core\System;

/**
 * @author Vinicius Cesar Dias
 */
class Builder {
    private $moduleid;
    private $entityid;
    private $table;
    private $destiny;
    private $metadata;
    private $moduleRoot;
    private $nsPrefix;
    
    public function __construct($moduleid,$entityid,$table,$destiny){
        $this->moduleid = $moduleid;
        $this->entityid = $entityid;
        $this->table    = $table;
        $this->destiny  = $destiny;
        
        $this->moduleRoot = \zion\APP_ROOT."modules".\DS;
        $this->nsPrefix   = "";
        if($destiny == "zion"){
            $this->moduleRoot = \zion\ROOT."modules".\DS;
            $this->nsPrefix   = "zion\\";
        }
        
        $db = System::getConnection();
        $dao = System::getDAO($db,$table);
        $db = null;
        
        $this->metadata = $dao->getMetadata();
        if($this->metadata == null){
            throw new Exception(
                "Nenhum metadado encontrado para a tabela ".$table.". 
                Verifique se ela existe e tente novamente");
        }
    }
    
    public function buildAbstractController(){
        $className = "Abstract".$this->entityid."Controller";
        
        $code  = "<?php\n";
        $code .= "namespace ".$this->nsPrefix."mod\\".$this->moduleid."\\controller;\n";
        $code .= "\n";
        $code .= "use Exception;\n";
        $code .= "use zion\core\AbstractEntityController;\n";
        $code .= "use zion\orm\PDO;\n";
        $code .= "use zion\orm\Filter;\n";
        $code .= "use zion\orm\ObjectVO;\n";
        $code .= "use zion\core\System;\n";
        $code .= "use zion\utils\TextFormatter;\n";
        
        $code .= "\n";
        $code .= "/**\n";
        $code .= " * Classe gerada pelo Zion Framework em ".date("d/m/Y")."\n";
        $code .= " * Não edite esta classe\n";
        $code .= " */\n";
        $code .= "abstract class ".$className." extends AbstractEntityController {\n";
        
        // getFormBean
        $code .= "\tpublic function getFormBean() : ObjectVO {\n";
        $code .= "\t\t\$obj = new ObjectVO();\n";
        foreach($this->metadata AS $name => $md){
            if($md->nativeType == "string"){
                $code .= "\t\t\$obj->set(\"".$name."\",\$_POST[\"obj\"][\"".$name."\"]);\n";
            }else{
                $code .= "\t\t\$obj->set(\"".$name."\",TextFormatter::parse(\"".$md->nativeType."\",\$_POST[\"obj\"][\"".$name."\"]));\n";
            }
        }
        $code .= "\t\treturn \$obj;\n";
        $code .= "\t}\n";
        
        // getFilterBean
        $code .= "\n";
        $code .= "\tpublic function getFilterBean() : Filter {\n";
        $code .= "\t\t\$filter = new Filter();\n";
        foreach($this->metadata AS $name => $md){
            $code .= "\t\t\$filter->addFilterField(\"".$name."\",\"".$md->nativeType."\",\$_POST[\"filter\"][\"".$name."\"]);\n";
        }
        $code .= "\t\treturn \$filter;\n";
        $code .= "\t}\n";
        
        // getKeysBean
        $code .= "\n";
        $code .= "\tpublic function getKeysBean(): array {\n";
        $code .= "\t\t\$uri = explode(\"/\",\$_SERVER[\"REQUEST_URI\"]);\n";
        $code .= "\t\t\$keys = array();\n";
        foreach($this->metadata AS $name => $md){
            if($md->isPK){
                $code .= "\t\t\$keys[\"".$name."\"] = TextFormatter::parse(\"".$md->nativeType."\",\$uri[5]);\n";
            }
        }
        $code .= "\t\t\$this->cleanEmptyKeys(\$keys);\n";
        $code .= "\t\treturn \$keys;\n";
        $code .= "\t}\n";
        
        // getEntityKeys
        $code .= "\n";
        $code .= "\tpublic function getEntityKeys(): array {\n";
        $code .= "\t\t\$keys = array();\n";
        foreach($this->metadata AS $name => $md){
            if($md->isPK){
                $code .= "\t\t\$keys[] = \"".$name."\";\n";
            }
        }
        $code .= "\t\treturn \$keys;\n";
        $code .= "\t}\n";
        
        // validate
        $code .= "\n";
        $code .= "\tpublic function validate(ObjectVO \$obj){\n";
        foreach($this->metadata AS $name => $md){
            if($md->isRequired){
                $code .= "\t\tif(\$obj->get(\"".$name."\") === null){\n";
                $code .= "\t\t\tthrow new Exception(\"Campo \\\"".$name."\\\" vazio\");\n";
                $code .= "\t\t}\n";
            }
        }
        $code .= "\t}\n";
        
        // setAutoIncrement
        $code .= "\n";
        $code .= "\tpublic function setAutoIncrement(PDO \$db,ObjectVO &\$obj){\n";
        $code .= "\t\t\$dao = System::getDAO();\n";
        foreach($this->metadata AS $name => $md){
            if($md->isPK){
                $code .= "\t\tif(\$obj->get(\"".$name."\") === 0){\n";
                $code .= "\t\t\t\$obj->set(\"".$name."\",\$dao->getNextId(\$db,\"".$this->entityid."-".$name."\"));\n";
                $code .= "\t\t}\n";
            }
        }
        $code .= "\t}\n";
        
        // fechando classe
        $code .= "}\n";
        $code .= "?>";
        
        // gravando no disco
        $file = $this->moduleRoot.$this->moduleid.\DS."controller".\DS.$className.".class.php";
        $this->writeFile($file,$code);
    }
    
    public function buildController(){
        $className = $this->entityid."Controller";
        
        $code  = "<?php\n";
        $code .= "namespace ".$this->nsPrefix."mod\\".$this->moduleid."\\controller;\n";
        
        $code .= "\n";
        $code .= "/**\n";
        $code .= " * Classe gerada pelo Zion Framework em ".date("d/m/Y")."\n";
        $code .= " */\n";
        $code .= "class ".$className." extends Abstract".$className." {\n";
        
        $code .= "\tpublic function __construct(){\n";
        $code .= "\t\tparent::__construct(get_class(\$this),array(\n";
        $code .= "\t\t\t\"table\" => \"".$this->table."\"\n";
        $code .= "\t\t));\n";
        $code .= "\t}\n";
        
        $code .= "}\n";
        $code .= "?>";
        
        // gravando no disco
        $file = $this->moduleRoot.$this->moduleid.\DS."controller".\DS.$className.".class.php";
        $this->writeFile($file,$code);
    }
    
    public function buildListView(){
        $action = "/modules/".$this->moduleid."/".$this->entityid."/filter";
        if($this->destiny == "zion"){
            $action = "/zion/mod/".$this->moduleid."/".$this->entityid."/filter";
        }
     
        $code  = "<?php\n";
        $code .= "use zion\orm\Filter;\n";
        $code .= "?>\n";
        
        $code .= "<div class=\"body-content-limit container-fluid filter-page\">\n";
        $code .= "\n";
        $code .= "\t<form class=\"form-inline hide-advanced-fields ajaxform\" action=\"".$action."\" method=\"POST\" data-callback=\"defaultFilterCallback\">\n";
        $code .= "\t\t<br>\n";
        $code .= "\t\t<div class=\"panel panel-default\">\n";
        
        $code .= "\t\t\t<div class=\"panel-heading\">\n";
        $code .= "\t\t\t\tFiltro\n";
        $code .= "\t\t\t</div>\n";
        
        $code .= "\t\t\t<div class=\"panel-body\">\n";
        
        foreach($this->metadata AS $name => $md){
            $code .= "\t\t\t\t<div class=\"form-group w-100\">\n";
            $code .= "\t\t\t\t\t<label for=\"filter[".$name."][low]\"  class=\"col-sm-3\">".$name."</label>\n";
            $code .= "\t\t\t\t\t\n";
            $code .= "\t\t\t\t\t<select class=\"form-control filter-operator\" id=\"filter[".$name."][operator]\" name=\"filter[".$name."][operator]\">\n";
            $code .= "\t\t\t\t\t\t<option value=\"\"></option>\n";
            $code .= "\t\t\t\t\t\t<?foreach(Filter::getOperators() AS \$key => \$text){?>\n";
            $code .= "\t\t\t\t\t\t<option value=\"<?=\$key?>\"><?=\$text?></option>\n";
            $code .= "\t\t\t\t\t\t<?}?>\n";
            $code .= "\t\t\t\t\t</select>\n";
            $code .= "\t\t\t\t\t\n";
            $code .= "\t\t\t\t\t<textarea class=\"form-control filter-low type-".$md->nativeType."\" id=\"filter[".$name."][low]\" name=\"filter[".$name."][low]\" rows=\"1\"></textarea>\n";
            $code .= "\t\t\t\t\t<textarea class=\"form-control filter-high type-".$md->nativeType."\" id=\"filter[".$name."][high]\" name=\"filter[".$name."][high]\" rows=\"1\"></textarea>\n";
            $code .= "\t\t\t\t</div>\n";
        }
        
        $code .= "\t\t\t</div>\n";
        
        $code .= "\t\t\t<div class=\"panel-footer\">\n";
        $code .= "\t\t\t\t<button type=\"submit\" id=\"filter-button\" class=\"btn btn-primary\">Filtrar</button>\n";
        $code .= "\t\t\t\t<button type=\"button\" id=\"button-toggleFilterMode\" class=\"btn btn-default\" data-mode=\"simple\">Alternar Modo</button>\n";
        $code .= "\t\t\t\t<a id=\"button-new\" class=\"btn btn-default\" href=\"/modules/".$this->moduleid."/".$this->entityid."/new\" target=\"_blank\">Novo</a>\n";
        $code .= "\t\t\t</div>\n";
        
        $code .= "\t\t</div>\n";
        $code .= "\t</form>\n";
        
        $code .= "\n";
        $code .= "\t<div id=\"filter-result\"></div>\n";
        
        $code .= "</div>";
        
        // gravando no disco
        $file = $this->moduleRoot.$this->moduleid.\DS."view".\DS.strtolower($this->entityid)."-list.php";
        $this->writeFile($file,$code);
    }
    
    public function buildResultFilterView(){
        $code  = "<?php\n";
        $code .= "use zion\utils\TextFormatter;\n";
        $code .= "?>\n";
        
        $code .= "<div class=\"table-responsive\">\n";
        $code .= "\t<table class=\"table table-striped table-hover table-bordered table-condensed\">\n";
        
        // cabeçalho da tabela
        $code .= "\t\t<thead>\n";
        $code .= "\t\t<tr>\n";
        
        foreach($this->metadata AS $name => $md){
            $code .= "\t\t\t<td>".$name."</td>\n";
        }
        $code .= "\t\t\t<td>Opções</td>\n";
        $code .= "\t\t</tr>\n";
        $code .= "\t\t</thead>\n";
        
        // dados da tabela
        $code .= "\t\t<tbody>\n";
        $code .= "\t\t\t<?foreach(\$objList AS \$obj){?>\n";
        $code .= "\t\t\t<tr>\n";
        foreach($this->metadata AS $name => $md){
            $code .= "\t\t\t\t<td><?=TextFormatter::format(\"".$md->nativeType."\",\$obj->get(\"".$name."\"))?></td>\n";
        }
        
        // inicio celula opções
        $code .= "\t\t\t\t<td>\n";
        
        $uriMod = "/modules/";
        if($this->destiny == "zion"){
            $uriMod = "/zion/mod/";
        }
        
        $uriView = $uriMod.$this->moduleid."/".$this->entityid."/view";
        $uriEdit = $uriMod.$this->moduleid."/".$this->entityid."/edit";
        foreach($this->metadata AS $name => $md){
            if($md->isPK){
                $uriView .= "/<?=\$obj->get(\"".$name."\")?>";
                $uriEdit .= "/<?=\$obj->get(\"".$name."\")?>";
            }
        }
        $uriView .= "/";
        $uriEdit .= "/";
        
        $code .= "\t\t\t\t\t<a class=\"view\" href=\"".$uriView."\" alt=\"Visualizar\" title=\"Visualizar\" target=\"_blank\">\n";
        $code .= "\t\t\t\t\t\t<span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span>\n";
        $code .= "\t\t\t\t\t</a>\n";
        
        $code .= "\t\t\t\t\t<a class=\"view\" href=\"".$uriEdit."\" alt=\"Editar\" title=\"Editar\" target=\"_blank\">\n";
        $code .= "\t\t\t\t\t\t<span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span>\n";
        $code .= "\t\t\t\t\t</a>\n";
        
        $code .= "\t\t\t\t</td>\n";
        // fim celula opções
        
        $code .= "\t\t\t</tr>\n";
        $code .= "\t\t\t<?}?>\n";
        $code .= "\t\t</tbody>\n";
        
        $code .= "\t</table>\n";
        $code .= "</div>";
        
        // gravando no disco
        $file = $this->moduleRoot.$this->moduleid.\DS."view".\DS.strtolower($this->entityid)."-result-filter.php";
        $this->writeFile($file,$code);
    }
    
    public function buildFormView(){
        $actionSave = "/modules/".$this->moduleid."/".$this->entityid."/save";
        if($this->destiny == "zion"){
            $actionSave = "/zion/mod/".$this->moduleid."/".$this->entityid."/save";
        }
        
        $code  = "<?php\n";
        $code .= "use zion\core\System;\n";
        $code .= "use zion\utils\TextFormatter;\n";
        $code .= "\$obj = System::get(\"obj\");\n";
        $code .= "\$action = System::get(\"action\");\n";
        $code .= "?>\n";
        
        $code .= "<div class=\"body-content-limit container-fluid\">\n";
        $code .= "\n";
        $code .= "\t<form class=\"form-horizontal ajaxform form-<?=\$action?>\" action=\"".$actionSave."\" method=\"POST\" data-callback=\"defaultRegisterCallback\">\n";
        $code .= "\t\t<br>\n";
        $code .= "\t\t<div class=\"panel panel-default\">\n";
        
        $code .= "\t\t\t<div class=\"panel-heading\">\n";
        $code .= "\t\t\t\t<h3 class=\"panel-title\">Formulário</h3>\n";
        $code .= "\t\t\t</div>\n";
        
        $code .= "\t\t\t<div class=\"panel-body\">\n";
        
        foreach($this->metadata AS $name => $md){
            $code .= "\t\t\t\t<div class=\"form-group\">\n";
            $code .= "\t\t\t\t\t<label class=\"col-md-4 control-label\" for=\"obj[".$name."]\">".$name."</label>\n";
            $code .= "\t\t\t\t\t<div class=\"col-md-4\">\n";
            
            if($md->nativeType == "boolean"){
                $code .= "\t\t\t\t\t\t<label class=\"radio-inline\" for=\"obj[".$name."]-1\">\n";
                $code .= "\t\t\t\t\t\t\t<input type=\"radio\" name=\"obj[".$name."]\" id=\"obj[".$name."]-1\" value=\"true\">\n";
                $code .= "\t\t\t\t\t\t\tSim\n";
                $code .= "\t\t\t\t\t\t</label>\n";
                
                $code .= "\t\t\t\t\t\t<label class=\"radio-inline\" for=\"obj[".$name."]-0\">\n";
                $code .= "\t\t\t\t\t\t\t<input type=\"radio\" name=\"obj[".$name."]\" id=\"obj[".$name."]-0\" value=\"false\">\n";
                $code .= "\t\t\t\t\t\t\tNão\n";
                $code .= "\t\t\t\t\t\t</label>\n";
            }else{
                $code .= "\t\t\t\t\t\t<input id=\"obj[".$name."]\" name=\"obj[".$name."]\" type=\"text\" class=\"form-control input-md type-".$md->nativeType."\" value=\"<?=TextFormatter::format(\"".$md->nativeType."\",\$obj->get(\"".$name."\"))?>\">\n";
            }
            $code .= "\t\t\t\t\t</div>\n";
            $code .= "\t\t\t\t</div>\n";
        }
        
        $code .= "\t\t\t</div>\n";
        
        $code .= "\t\t\t<div class=\"panel-footer\">\n";
        $code .= "\t\t\t\t<?if(in_array(\$action,array(\"new\",\"edit\"))){?>\n";
        $code .= "\t\t\t\t<button type=\"submit\" id=\"register-button\" class=\"btn btn-primary\">Salvar</button>\n";
        $code .= "\t\t\t\t<?}?>\n";
        $code .= "\t\t\t\t<button type=\"button\" class=\"btn btn-default button-close\">Fechar</button>\n";
        $code .= "\t\t\t</div>\n";
        
        $code .= "\t\t</div>\n";
        $code .= "\t</form>\n";
        $code .= "\n";
        $code .= "</div>";
        
        // gravando no disco
        $file = $this->moduleRoot.$this->moduleid.\DS."view".\DS.strtolower($this->entityid)."-form.php";
        $this->writeFile($file,$code);
    }
    
    /**
     * Grava o conteúdo no arquivo e seta as permissões necessárias,
     * fazendo todos os tratamentos
     * @param string $file
     * @param string $content
     * @throws Exception
     */
    public function writeFile($file,$content){
        if(!is_writable(dirname($file))){
            throw new Exception("O diretório ".dirname($file)." não é gravável");
        }
        
        $f = fopen($file,"w");
        if($f === false){
            throw new Exception("Erro em gravar aquivo ".$file);
        }
        fwrite($f,$content);
        fclose($f);
        
        chmod($file, 0755);
    }
}
?>