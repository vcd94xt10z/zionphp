<?php
namespace zion\core;

use Exception;
use zion\orm\ObjectVO;
use zion\orm\Filter;
use zion\orm\PDO;
use zion\utils\TextFormatter;

/**
 * @author Vinicius Cesar Dias
 */
abstract class AbstractEntityController extends AbstractController {
    protected $table = "";
    
    public function __construct($className, array $args){
        parent::__construct($className);
        $this->table = $args["table"];
    }
    
    /**
     * Padrão de URL Rest
     */
    public function rest(){
        $uri = explode("/",$_SERVER["REQUEST_URI"]);
        $param = $uri[5];
        
        $method = $_SERVER["REQUEST_METHOD"];
        switch($method){
        case "GET":
            if($param == ""){
                $this->actionList();
            }else{
                $this->actionEdit();
            }
            break;
        case "VIEW":
            $this->actionView();
            break;
        case "FILTER":
            $this->actionFilter();
            break;
        case "POST":
            $this->actionSave();
            break;
        case "PUT":
            $this->actionSave();
            break;
        case "DELETE":
            $this->actionDelete();
            break;
        }
    }
    
    /**
     * Obtém os dados do formulário e converte para objeto
     * @return ObjectVO
     */
    abstract public function getFormBean() : ObjectVO;
    
    /**
     * Obtém o filtro do formulário e converte para objeto
     * @return Filter
     */
    abstract public function getFilterBean() : Filter;
    
    /**
     * Testa se um objeto é valido para ser cadastrado
     * @param ObjectVO $obj
     */
    abstract public function validate(ObjectVO $obj);
    
    /**
     * Retorna um array associativo com a chave primária do objeto
     * @return array
     */
    abstract public function getKeysBean() : array;
    
    /**
     * Retorna um array com as chaves da entidade
     * @return array
     */
    abstract public function getEntityKeys() : array;
    
    /**
     * Limpa chaves nulas
     * @param array $keys
     * @return array
     */
    public function cleanEmptyKeys(array &$keys){
        foreach($keys AS $k => $v){
            if($v === null){
                unset($keys[$k]);
            }
        }
    }
    
    /**
     * Carrega um objeto
     * @param PDO $db
     * @param array $keys
     * @return ObjectVO
     */
    public function load(PDO $db, array $keys){
        $dao = System::getDAO($db,$this->table);
        return $dao->getObject($db, $keys);
    }
    
    /**
     * Edição do objeto
     */
    public function actionEdit(string $action="edit"){
        // input
        $keys = $this->getKeysBean();
        
        // process
        $obj = null;
        try {
            if($action == "edit" AND sizeof($keys) <= 0){
                throw new Exception("Nenhuma chave informada para editar");
            }
            
            if($action != "new"){
                $db = System::getConnection();
                $obj = $this->load($db,$keys);
                $db = null;
            }
            
            if($obj === null){
                $obj = new ObjectVO();
            }
            System::set("obj",$obj);
            System::set("action",$action);
            
            // output
            $this->view("form");
        }catch(Exception $e){
            System::exitWithError($e->getMessage());
        }
    }
    
    /**
     * Salva um objeto
     */
    public function actionSave(){
        // input
        $obj = $this->getFormBean();
        
        // process
        $output = array();
        try {
            $this->validate($obj);
            
            $db = System::getConnection();
            $this->save($db,$obj);
            $db = null;
            
            // independente se os campos chaves foram atualizados ou não, sempre envia na resposta
            // para atualizar também a view
            $keys = $this->getEntityKeys();
            foreach($keys AS $key){
                $output[$key] = TextFormatter::format("autodetect", $obj->get($key));
            }
            
            // output
            header("Content-Type: application/json");
            echo json_encode($output);
        }catch(Exception $e){
            System::exitWithError($e->getMessage());
        }
    }
    
    /**
     * Seta um campo auto incrementado, se aplicável
     * @param PDO $db
     * @param ObjectVO $obj
     */
    abstract public function setAutoIncrement(PDO $db,ObjectVO &$obj);
    
    /**
     * Salva um objeto no banco de dados
     * @param PDO $db
     * @param ObjectVO $obj
     * @return int
     */
    public function save(PDO $db, ObjectVO $obj) : int {
        $dao = System::getDAO($db,$this->table);
        if ($dao->exists($db,$obj)) {
            return $dao->update($db, $obj);
        } else {
            $this->setAutoIncrement($db, $obj);
            return $dao->insert($db, $obj);
        }
    }
    
    /**
     * Entra na tela de filtro de objetos
     */
    public function actionList(){
        // input
        
        // process
        
        // output
        $this->view("list");
    }
    
    /**
     * Executa um filtro no banco de dados
     * @param PDO $db
     * @param Filter $filter
     * @return array
     */
    public function filter(PDO $db, Filter $filter) : array {
        $dao = System::getDAO($db,$this->table);
        return $dao->getArray($db, $filter);
    }
    
    /**
     * Filtra objetos
     */
    public function actionFilter(){
        // input
        $filter = $this->getFilterBean();
        
        // process
        $objList = array();
        try {
            $db = System::getConnection();
            $objList = $this->filter($db,$filter);
            $db = null;
            
            // output
            System::set("objList",$objList);
            $this->view("result-filter",false);
        }catch(Exception $e){
            System::exitWithError($e->getMessage());
        }
    }
    
    /**
     * Novo objeto
     */
    public function actionNew(){
        $this->actionEdit("new");
    }
    
    /**
     * Visualizar um objeto
     */
    public function actionView(){
        $this->actionEdit("view");
    }
    
    /**
     * Deleta um objeto
     * @param PDO $db
     * @param array $keys
     * @return array
     */
    public function delete(PDO $db, array $keys) : array {
        $dao = System::getDAO($db,$this->table);
        return $dao->delete($db, $keys);
    }
    
    /**
     * Deleta um objeto do banco de dados
     */
    public function actionDelete(){
        // input
        $keys = $this->getKeysBean();
        
        // process
        try {
            $db = System::getConnection();
            $this->delete($db,$keys);
            $db = null;
        }catch(Exception $e){
            System::exitWithError($e->getMessage());
        }
    }
}
?>