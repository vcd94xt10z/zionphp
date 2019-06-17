<?php
namespace zion\mod\builder\model;

use Exception;
use zion\core\App;
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
        
        $this->moduleRoot = \zion\ROOT."modules".\DS;
        $this->nsPrefix   = "zion\\";
        if($destiny != "zion"){
            $this->moduleRoot = App::getModuleRoot();
            $this->nsPrefix   = "";
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
    
    public function buildStandardController(){
        $className = $this->entityid."Controller";
        
        $code  = "<?php\n";
        $code .= "namespace ".$this->nsPrefix."mod\\".$this->moduleid."\\standard\\controller;\n";
        $code .= "\n";
        $code .= "use Exception;\n";
        $code .= "use zion\core\AbstractEntityController;\n";
        $code .= "use zion\orm\PDO;\n";
        $code .= "use zion\orm\Filter;\n";
        $code .= "use zion\orm\ObjectVO;\n";
        $code .= "use zion\core\System;\n";
        $code .= "use zion\utils\TextFormatter;\n";
        $code .= "use zion\utils\HTTPUtils;\n";
        
        $code .= "\n";
        $code .= "/**\n";
        $code .= " * Classe gerada pelo Zion Framework\n";
        $code .= " * Não edite esta classe\n";
        $code .= " */\n";
        $code .= "abstract class ".$className." extends AbstractEntityController {\n";
        
        // getFormBean
        $code .= "\tpublic function getFormBean() : ObjectVO {\n";
        
        $code .= "\t\t// Deixando os dados na superglobal _POST\n";
        $code .= "\t\tif(\$_SERVER[\"REQUEST_METHOD\"] == \"PUT\"){\n";
        $code .= "\t\t\t\$_POST = HTTPUtils::parsePost();\n";
        $code .= "\t\t}\n";
        
        $code .= "\t\t\n";
        
        $code .= "\t\t\$obj = new ObjectVO();\n";
        
        $code .= "\t\tif(\$_SERVER[\"REQUEST_METHOD\"] == \"GET\"){\n";
        $code .= "\t\t\t// valores default\n";
        foreach($this->metadata AS $name => $md){
            if($name == "mandt"){
                $code .= "\t\t\t\$obj->set(\"".$name."\",0);\n";
                continue;
            }
            
            if($name == "created" || $name == "created_at"){
                $code .= "\t\t\t\$obj->set(\"".$name."\",new \DateTime());\n";
                continue;
            }
            
            if($md->defaultValue == ""){
                continue;
            }
            
            switch($md->nativeType){
            default:
                $code .= "\t\t\t\$obj->set(\"".$name."\",\"".$md->defaultValue."\");\n";
                break;
            }
        }
        $code .= "\t\t\treturn \$obj;\n";
        $code .= "\t\t}\n";
        
        $code .= "\t\t\n";
        foreach($this->metadata AS $name => $md){
            if($name == "mandt" AND $md->isPK){
                $code .= "\t\t\$obj->set(\"".$name."\",abs(intval(\$_POST[\"obj\"][\"".$name."\"])));\n";
            }elseif($md->isAI()){
                $code .= "\t\t\$obj->set(\"".$name."\",TextFormatter::parse(\"".$md->nativeType."\",\$_POST[\"obj\"][\"".$name."\"],true));\n";
            }elseif($md->isPK){
                $code .= "\t\t\$obj->set(\"".$name."\",TextFormatter::parse(\"".$md->nativeType."\",\$_POST[\"obj\"][\"".$name."\"]));\n";
            }elseif($md->nativeType == "string"){
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
        
        $code .= "\t\t// Deixando os dados na superglobal _POST\n";
        $code .= "\t\tif(\$_SERVER[\"REQUEST_METHOD\"] == \"FILTER\"){\n";
        $code .= "\t\t\t\$_POST = HTTPUtils::parsePost();\n";
        $code .= "\t\t}\n";
        $code .= "\t\t\n";
        
        // filtros
        $code .= "\t\t\$filter = new Filter();\n";
        foreach($this->metadata AS $name => $md){
            $code .= "\t\t\$filter->addFilterField(\"".$name."\",\"".$md->nativeType."\",\$_POST[\"filter\"][\"".$name."\"]);\n";
        }
        $code .= "\t\t\n";
        
        // ordenação
        $code .= "\t\t// ordenação\n";
        $code .= "\t\t\$filter->addSort(\$_POST[\"order\"][\"field\"],\$_POST[\"order\"][\"type\"]);\n";
        $code .= "\t\t\n";
        
        // limite
        $code .= "\t\t// limite\n";
        $code .= "\t\t\$filter->setLimit(intval(\$_POST[\"limit\"]));\n";
        $code .= "\t\t\n";
        
        // offset
        $code .= "\t\t// offset\n";
        $code .= "\t\t\$filter->setOffset(intval(\$_POST[\"offset\"]));\n";
        $code .= "\t\t\n";
        
        $code .= "\t\treturn \$filter;\n";
        $code .= "\t}\n";
        
        // getKeysBean
        $code .= "\n";
        $code .= "\tpublic function getKeysBean(): array {\n";
        $code .= "\t\t\$keys = array();\n";
        $i=0;
        foreach($this->metadata AS $name => $md){
            if($md->isPK){
                $code .= "\t\t\$keys[\"".$name."\"] = TextFormatter::parse(\"".$md->nativeType."\",\$_GET[\"keys\"][\"".$name."\"]);\n";
                $i++;
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
            if($md->isRequired AND !$md->isAI()){
                $code .= "\t\tif(\$obj->get(\"".$name."\") === null){\n";
                $code .= "\t\t\tthrow new Exception(\"Campo \\\"".$name."\\\" vazio\");\n";
                $code .= "\t\t}\n";
            }
        }
        $code .= "\t}\n";
        
        // setAutoIncrement
        $fieldsAI = array();
        foreach($this->metadata AS $name => $md){
            if($name == "mandt"){
                continue;
            }
            if($md->isAI()){
                $fieldsAI[] = $name;
            }
        }
        
        $code .= "\n";
        $code .= "\tpublic function setAutoIncrement(PDO \$db,ObjectVO &\$obj){\n";
        
        if(sizeof($fieldsAI) > 0){
            $code .= "\t\t\$dao = System::getDAO();\n";
        }
        foreach($this->metadata AS $name => $md){
            if(in_array($name,$fieldsAI)){
                $code .= "\t\tif(\$obj->get(\"".$name."\") === null){\n";
                $code .= "\t\t\t\$obj->set(\"".$name."\",\$dao->getNextId(\$db,\"".$this->entityid."-".$name."\"));\n";
                $code .= "\t\t}\n";
            }
        }
        $code .= "\t}\n";
        
        // fechando classe
        $code .= "}\n";
        $code .= "?>";
        
        // gravando no disco
        $file = $this->moduleRoot.$this->moduleid.\DS."standard".\DS."controller".\DS.$className.".class.php";
        $this->writeFile($file,$code);
    }
    
    public function buildController(){
        $className = $this->entityid."Controller";
        
        $code  = "<?php\n";
        $code .= "namespace ".$this->nsPrefix."mod\\".$this->moduleid."\\controller;\n";
        
        $code .= "\n";
        $code .= "use ".$this->nsPrefix."mod\\".$this->moduleid."\\standard\\controller\\{$className} AS Standard{$className};\n";
        
        $code .= "\n";
        $code .= "/**\n";
        $code .= " * Classe gerada pelo Zion Framework em ".date("d/m/Y")."\n";
        $code .= " */\n";
        $code .= "class ".$className." extends Standard".$className." {\n";
        
        $code .= "\tpublic function __construct(){\n";
        $code .= "\t\tparent::__construct(get_class(\$this),array(\n";
        $code .= "\t\t\t\"table\" => \"".$this->table."\"\n";
        $code .= "\t\t));\n";
        $code .= "\t}\n";
        
        $code .= "}\n";
        $code .= "?>";
        
        // gravando no disco
        $file = $this->moduleRoot.$this->moduleid.\DS."controller".\DS.$className.".class.php";
        if(!file_exists($file)){
            $this->writeFile($file,$code);
        }
    }
    
    public function buildListView(){
        $modURI  = "/mod/";
        $restURI = "/rest/";
        if($this->destiny == "zion"){
            $modURI  = "/zion/mod/";
            $restURI = "/zion/rest/";
        }
        $action = $restURI.$this->moduleid."/".$this->entityid."/";
        
        $keys = array();
        foreach($this->metadata AS $name => $md){
            $keys[] = $name;
        }
        $keyArrStr = "array(\"".implode("\",\"",$keys)."\")";
        
        $code  = "<?php\n";
        $code .= "use zion\orm\Filter;\n";
        $code .= "use zion\core\System;\n";
        $code .= "\$t = System::get(\"entityTexts\");\n";
        $code .= "\$fields = ".$keyArrStr.";\n";
        $code .= "sort(\$fields);\n";
        $code .= "?>\n";
        
        $code .= "<div class=\"center-content filter-page\">\n";
        $code .= "<div class=\"container-fluid\">\n";
        $code .= "\n";
        
        $code .= "\t<br>\n";
        $code .= "\t<nav aria-label=\"breadcrumb\">\n";
        $code .= "\t\t<ol class=\"breadcrumb\">\n";
        $code .= "\t\t\t<li class=\"breadcrumb-item\"><a href=\"{$modURI}core/User/home\">Início</a></li>\n";
        $code .= "\t\t\t<li class=\"breadcrumb-item\"><a href=\"{$modURI}{$this->moduleid}/\"><?=\$t->module()?></a></li>\n";
        $code .= "\t\t\t<li class=\"breadcrumb-item active\" aria-current=\"page\">Consulta de <?=\$t->entity()?></li>\n";
        $code .= "\t\t</ol>\n";
        $code .= "\t</nav>\n";
        
        $code .= "<h3>Consulta de <?=\$t->entity()?></h3>\n";
        $code .= "\t<form class=\"form-inline hide-advanced-fields ajaxform\" action=\"".$action."\" method=\"POST\" data-callback=\"defaultFilterCallback\">\n";
        $code .= "\t\t<br>\n";
        $code .= "\t\t<div class=\"card\">\n";
        
        $code .= "\t\t\t<div class=\"card-header\">\n";
        $code .= "\t\t\t\tFiltro\n";
        $code .= "\t\t\t</div>\n";
        
        $code .= "\t\t\t<div class=\"card-body\">\n";
        
        foreach($this->metadata AS $name => $md){
            $class1 = "row-filter-advanced";
            if($md->isPK){
                $class1 = "row-filter-normal";
            }
            
            $code .= "\t\t\t\t<div class=\"row ".$class1."\">\n";
            $code .= "\t\t\t\t\t<div class=\"col-sm-3\">\n";
            
            $code .= "\t\t\t\t\t\t<label for=\"filter[".$name."][low]\" alt=\"<?=\$t->tip(\"{$name}\")?>\" title=\"<?=\$t->tip(\"{$name}\")?>\">\n";
            $code .= "\t\t\t\t\t\t\t<?=\$t->field(\"{$name}\")?>\n";
            $code .= "\t\t\t\t\t\t</label>\n";
            
            $code .= "\t\t\t\t\t</div>\n";
            $code .= "\t\t\t\t\t<div class=\"col-sm-9\">\n";
            $code .= "\t\t\t\t\t\t<select class=\"form-control filter-operator\" id=\"filter[".$name."][operator]\" name=\"filter[".$name."][operator]\">\n";
            $code .= "\t\t\t\t\t\t\t<option value=\"\"></option>\n";
            $code .= "\t\t\t\t\t\t\t<?foreach(Filter::getOperators() AS \$key => \$text){?>\n";
            $code .= "\t\t\t\t\t\t\t<option value=\"<?=\$key?>\"><?=\$text?></option>\n";
            $code .= "\t\t\t\t\t\t\t<?}?>\n";
            $code .= "\t\t\t\t\t\t</select>\n";
            $code .= "\t\t\t\t\t\t\n";
            $code .= "\t\t\t\t\t\t<textarea class=\"form-control filter-low type-".$md->nativeType."\" id=\"filter[".$name."][low]\" name=\"filter[".$name."][low]\" rows=\"1\"></textarea>\n";
            $code .= "\t\t\t\t\t\t<textarea class=\"form-control filter-high type-".$md->nativeType."\" id=\"filter[".$name."][high]\" name=\"filter[".$name."][high]\" rows=\"1\"></textarea>\n";
            $code .= "\t\t\t\t\t</div>\n";
            $code .= "\t\t\t\t</div>\n";
        }
        
        // ordenação
        $code .= "\t\t\t\t<div class=\"row\">\n";
        $code .= "\t\t\t\t\t<div class=\"col-sm-3\">\n";
        $code .= "\t\t\t\t\t\t<label for=\"order[field]\">Ordenação</label>\n";
        $code .= "\t\t\t\t\t</div>\n";
        $code .= "\t\t\t\t\t<div class=\"col-sm-9\">\n";
        $code .= "\t\t\t\t\t\t<select class=\"form-control\" id=\"order[field]\" name=\"order[field]\">\n";
        $code .= "\t\t\t\t\t\t\t<option value=\"\"></option>\n";
        $code .= "\t\t\t\t\t\t\t<?foreach(\$fields AS \$key){?>\n";
        $code .= "\t\t\t\t\t\t\t<option value=\"<?=\$key?>\"><?=\$key?></option>\n";
        $code .= "\t\t\t\t\t\t\t<?}?>\n";
        $code .= "\t\t\t\t\t\t</select>\n";
        $code .= "\t\t\t\t\t\t\n";
        
        $code .= "\t\t\t\t\t\t<select class=\"form-control\" id=\"order[type]\" name=\"order[type]\">\n";
        $code .= "\t\t\t\t\t\t\t<option value=\"\"></option>\n";
        $code .= "\t\t\t\t\t\t\t<option value=\"ASC\">ASC</option>\n";
        $code .= "\t\t\t\t\t\t\t<option value=\"DESC\">DESC</option>\n";
        $code .= "\t\t\t\t\t\t</select>\n";
        
        $code .= "\t\t\t\t\t</div>\n";
        $code .= "\t\t\t\t</div>\n";
        
        // limite
        $code .= "\t\t\t\t<div class=\"row\">\n";
        $code .= "\t\t\t\t\t<div class=\"col-sm-3\">\n";
        $code .= "\t\t\t\t\t\t<label for=\"limit\">Limite</label>\n";
        $code .= "\t\t\t\t\t</div>\n";
        $code .= "\t\t\t\t\t<div class=\"col-sm-9\">\n";
        $code .= "\t\t\t\t\t\t<input class=\"form-control type-integer\" id=\"limit\" name=\"limit\" value=\"100\">\n";
        $code .= "\t\t\t\t\t</div>\n";
        $code .= "\t\t\t\t</div>\n";
        
        // offset
        $code .= "\t\t\t\t<div class=\"row\">\n";
        $code .= "\t\t\t\t\t<div class=\"col-sm-3\">\n";
        $code .= "\t\t\t\t\t\t<label for=\"offset\">Ignorar</label>\n";
        $code .= "\t\t\t\t\t</div>\n";
        $code .= "\t\t\t\t\t<div class=\"col-sm-9\">\n";
        $code .= "\t\t\t\t\t\t<input class=\"form-control type-integer\" id=\"offset\" name=\"offset\" value=\"0\">\n";
        $code .= "\t\t\t\t\t</div>\n";
        $code .= "\t\t\t\t</div>\n";
        
        $code .= "\t\t\t</div>\n";
        
        $code .= "\t\t\t<div class=\"card-footer\">\n";
        $code .= "\t\t\t\t<button type=\"submit\" id=\"filter-button\" class=\"btn btn-primary\">Filtrar</button>\n";
        $code .= "\t\t\t\t<button type=\"button\" id=\"button-filter-basic\" class=\"btn btn-outline-secondary\">Basico</button>\n";
        $code .= "\t\t\t\t<button type=\"button\" id=\"button-filter-advanced\" class=\"btn btn-outline-secondary\">Avançado</button>\n";
        $code .= "\t\t\t\t<a id=\"button-new\" class=\"btn btn-outline-info\" href=\"".$modURI.$this->moduleid."/".$this->entityid."/new\" target=\"_blank\">Novo</a>\n";
        $code .= "\t\t\t</div>\n";
        
        $code .= "\t\t</div>\n";
        $code .= "\t</form>\n";
        
        $code .= "\n";
        $code .= "\t<div id=\"filter-result\">\n";
        $code .= "\t\t<div class=\"container-fluid\">Execute o filtro</div>\n";
        $code .= "\t</div>\n";
        
        $code .= "</div>";
        $code .= "</div>";
        
        // gravando no disco
        $file = $this->moduleRoot.$this->moduleid.\DS."view".\DS.strtolower($this->entityid)."-list.php";
        $this->writeFile($file,$code);
    }
    
    /**
     * @supress
     */
    public function buildResultFilterView(){
        $code  = "<?php\n";
        $code .= "use zion\core\System;\n";
        $code .= "use zion\utils\TextFormatter;\n";
        $code .= "\$t = System::get(\"entityTexts\");\n";
        $code .= "\$objList = System::get(\"objList\");\n";
        $code .= "?>\n";
        
        $code .= "<div class=\"table-responsive\">\n";
        $code .= "\t<table class=\"table table-striped table-hover table-bordered table-sm\">\n";
        
        // cabeçalho da tabela
        $code .= "\t\t<thead>\n";
        $code .= "\t\t<tr>\n";
        
        $code .= "\t\t\t<td><input type=\"checkbox\"></td>\n";
        $code .= "\t\t\t<td>#</td>\n";
        
        foreach($this->metadata AS $name => $md){
            $code .= "\t\t\t<td><?=\$t->field(\"{$name}\")?></td>\n";
        }
        $code .= "\t\t\t<td>Opções</td>\n";
        $code .= "\t\t</tr>\n";
        $code .= "\t\t</thead>\n";
        
        $pks = array();
        foreach($this->metadata AS $name => $md){
            if($md->isPK){
                $pks[] = $name;
            }
        }
        $pkstr = "\"".implode("\",\"",$pks)."\"";
        
        // dados da tabela
        $code .= "\t\t<tbody>\n";
        $code .= "\t\t\t<?\n";
        $code .= "\t\t\tforeach(\$objList AS \$obj){\n";
        $code .= "\t\t\t\t\$keys = \$obj->toQueryStringKeys(array(".$pkstr."));\n";
        $code .= "\t\t\t\t?>\n";
        $code .= "\t\t\t<tr>\n";
        
        $code .= "\t\t\t\t<td><input type=\"checkbox\"></td>\n";
        $code .= "\t\t\t\t<td><?=(++\$n)?></td>\n";
        
        foreach($this->metadata AS $name => $md){
            if($md->databaseType == "text"){
                $code .= "\t\t\t\t<td>\n";
                $code .= "\t\t\t\t\tTexto\n";
                $code .= "\t\t\t\t\t[<a href=\"#\" class=\"viewFullText\" data-text=\"<?=\$obj->get(\"".$name."\")?>\">Ver</a>]\n";
                $code .= "\t\t\t\t</td>\n";
            }else{
                $code .= "\t\t\t\t<td><?=TextFormatter::format(\"".$md->nativeType."\",\$obj->get(\"".$name."\"))?></td>\n";
            }
        }
        
        // inicio celula opções
        $code .= "\t\t\t\t<td>\n";
        
        $uriMod = "/mod/";
        if($this->destiny == "zion"){
            $uriMod = "/zion/mod/";
        }
        
        $uriView = $uriMod.$this->moduleid."/".$this->entityid."/view/?<?=\$keys?>";
        $uriEdit = $uriMod.$this->moduleid."/".$this->entityid."/edit/?<?=\$keys?>";
        
        $code .= "\t\t\t\t\t<a class=\"view\" href=\"".$uriView."\" alt=\"Visualizar\" title=\"Visualizar\" target=\"_blank\">\n";
        $code .= "\t\t\t\t\t\t<i class=\"fas fa-eye\"></i>\n";
        $code .= "\t\t\t\t\t</a>\n";
        
        $code .= "\t\t\t\t\t<a class=\"edit\" href=\"".$uriEdit."\" alt=\"Editar\" title=\"Editar\" target=\"_blank\">\n";
        $code .= "\t\t\t\t\t\t<i class=\"fas fa-edit\"></i>\n";
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
        $pks = array();
        foreach($this->metadata AS $name => $md){
            if($md->isPK){
                $pks[] = $name;
            }
        }
        $pkArrayStr = "array(\"".implode("\",\"",$pks)."\")";
        
        $modURI  = "/mod/";
        $restURI = "/rest/";
        if($this->destiny == "zion"){
            $modURI  = "/zion/mod/";
            $restURI = "/zion/rest/";
        }
        $actionRest = $restURI.$this->moduleid."/".$this->entityid."/";
        $actionNew  = $modURI.$this->moduleid."/".$this->entityid."/new";
        
        $code  = "<?php\n";
        $code .= "use zion\core\System;\n";
        $code .= "use zion\utils\TextFormatter;\n";
        $code .= "\$obj = System::get(\"obj\");\n";
        $code .= "\$action = System::get(\"action\");\n";
        $code .= "\$method = (\$action == \"edit\")?\"PUT\":\"POST\";\n";
        $code .= "\$keys = \$obj->toQueryStringKeys({$pkArrayStr});\n";
        $code .= "\$t = System::get(\"entityTexts\");\n";
        $code .= "?>\n";
        
        $code .= "<div class=\"center-content form-page\">\n";
        $code .= "<div class=\"container-fluid\">\n";
        $code .= "\n";
        
        $code .= "\t<br>\n";
        $code .= "\t<nav aria-label=\"breadcrumb\">\n";
        $code .= "\t\t<ol class=\"breadcrumb\">\n";
        $code .= "\t\t\t<li class=\"breadcrumb-item\"><a href=\"{$modURI}core/User/home\">Início</a></li>\n";
        $code .= "\t\t\t<li class=\"breadcrumb-item\"><a href=\"{$modURI}{$this->moduleid}/\"><?=\$t->module()?></a></li>\n";
        $code .= "\t\t\t<li class=\"breadcrumb-item\"><a href=\"{$modURI}{$this->moduleid}/{$this->entityid}/list\">Consulta de <?=\$t->entity()?></a></li>\n";
        $code .= "\t\t\t<li class=\"breadcrumb-item active\" aria-current=\"page\">Formulario de <?=\$t->entity()?></li>\n";
        $code .= "\t\t</ol>\n";
        $code .= "\t</nav>\n";
        
        $code .= "\t<h3>Formulário de <?=\$t->entity()?></h3>\n";
        
        $code .= "\t<form class=\"form-horizontal ajaxform form-<?=\$action?>\" action=\"".$actionRest."\" method=\"<?=\$method?>\" data-callback=\"defaultRegisterCallback\">\n";
        $code .= "\t\t<br>\n";
        $code .= "\t\t<div class=\"card\">\n";
        
        $code .= "\t\t\t<div class=\"card-header\">\n";
        $code .= "\t\t\t\tFormulário\n";
        $code .= "\t\t\t</div>\n";
        
        $code .= "\t\t\t<div class=\"card-body\">\n";
        
        foreach($this->metadata AS $name => $md){
            $required = "";
            $classList = array();
            
            if($md->isPK){
                $classList[] = "pk";
            }
            
            if($md->isRequired AND !$md->isAI()){
                $required = " required";
                $classList[] = "required";
            }
            
            $classList[] = "control-label";
            
            $code .= "\t\t\t\t<div class=\"row\">\n";
            $code .= "\t\t\t\t\t<div class=\"col-sm-3\">\n";
            
            $code .= "\t\t\t\t\t\t<label class=\"".implode(" ",$classList)."\" for=\"obj[".$name."]\" alt=\"<?=\$t->tip(\"{$name}\")?>\" title=\"<?=\$t->tip(\"{$name}\")?>\">\n";
            $code .= "\t\t\t\t\t\t\t<?=\$t->field(\"{$name}\")?>\n";
            $code .= "\t\t\t\t\t\t</label>\n";
            
            $code .= "\t\t\t\t\t</div>\n";
            $code .= "\t\t\t\t\t<div class=\"col-sm-5\">\n";
            
            if($md->nativeType == "boolean"){
                $code .= "\t\t\t\t\t\t<?php\n";
                $code .= "\t\t\t\t\t\t\$checked1 = \"\";\n";
                $code .= "\t\t\t\t\t\t\$checked0 = \"\";\n";
                $code .= "\t\t\t\t\t\tif(\$obj->get(\"".$name."\") === true){\n";
                $code .= "\t\t\t\t\t\t\t\$checked1 = \" CHECKED\";\n";
                $code .= "\t\t\t\t\t\t\t\$checked0 = \"\";\n";
                $code .= "\t\t\t\t\t\t}elseif(\$obj->get(\"".$name."\") === false){\n";
                $code .= "\t\t\t\t\t\t\t\$checked1 = \"\";\n";
                $code .= "\t\t\t\t\t\t\t\$checked0 = \" CHECKED\";\n";
                $code .= "\t\t\t\t\t\t}\n";
                $code .= "\t\t\t\t\t\t?>\n";
                
                $code .= "\t\t\t\t\t\t<label class=\"radio-inline\" for=\"obj[".$name."]-1\">\n";
                $code .= "\t\t\t\t\t\t\t<input type=\"radio\" name=\"obj[".$name."]\" id=\"obj[".$name."]-1\" value=\"true\"<?=\$checked1?>>\n";
                $code .= "\t\t\t\t\t\t\tSim\n";
                $code .= "\t\t\t\t\t\t</label>\n";
                
                $code .= "\t\t\t\t\t\t<label class=\"radio-inline\" for=\"obj[".$name."]-0\">\n";
                $code .= "\t\t\t\t\t\t\t<input type=\"radio\" name=\"obj[".$name."]\" id=\"obj[".$name."]-0\" value=\"false\"<?=\$checked0?>>\n";
                $code .= "\t\t\t\t\t\t\tNão\n";
                $code .= "\t\t\t\t\t\t</label>\n";
            }elseif($md->databaseType == "text"){
                $code .= "\t\t\t\t\t\t<textarea id=\"obj[".$name."]\" name=\"obj[".$name."]\" class=\"form-control type-".$md->nativeType."\"".$required."><?=TextFormatter::format(\"".$md->nativeType."\",\$obj->get(\"".$name."\"))?></textarea>\n";
            }else{
                $code .= "\t\t\t\t\t\t<input id=\"obj[".$name."]\" name=\"obj[".$name."]\" type=\"text\" class=\"form-control type-".$md->nativeType."\" value=\"<?=TextFormatter::format(\"".$md->nativeType."\",\$obj->get(\"".$name."\"))?>\"".$required.">\n";
            }
            $code .= "\t\t\t\t\t</div>\n";
            $code .= "\t\t\t\t</div>\n";
        }
        
        $code .= "\t\t\t</div>\n";
        
        $code .= "\t\t\t<div class=\"card-footer\">\n";
        $code .= "\t\t\t\t<?if(in_array(\$action,array(\"new\",\"edit\"))){?>\n";
        $code .= "\t\t\t\t<button type=\"submit\" class=\"btn btn-outline-primary\" id=\"register-button\">Salvar</button>\n";
        $code .= "\t\t\t\t<?}?>\n";
        $code .= "\t\t\t\t<?if(in_array(\$action,array(\"edit\"))){?>\n";
        $code .= "\t\t\t\t<button type=\"button\" class=\"btn btn-outline-danger button-delete\" data-url=\"{$actionRest}?<?=\$keys?>\">Remover</button>\n";
        $code .= "\t\t\t\t<?}?>\n";
        $code .= "\t\t\t\t<a class=\"btn btn-outline-info button-new\" href=\"".$actionNew."\">Novo</a>\n";
        $code .= "\t\t\t\t<button type=\"button\" class=\"btn btn-outline-secondary button-close\">Fechar</button>\n";
        $code .= "\t\t\t</div>\n";
        
        $code .= "\t\t</div>\n";
        $code .= "\t</form>\n";
        $code .= "\n";
        $code .= "</div>\n";
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
        
        //@chmod($file, 0777);
    }
}
?>