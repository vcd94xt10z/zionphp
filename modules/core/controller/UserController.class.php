<?php
namespace zion\mod\core\controller;

use stdClass;
use Exception;
use DateTime;
use zion\core\Session;
use zion\core\Page;
use zion\core\System;
use zion\mod\core\standard\controller\UserController AS StandardUserController;
use zion\utils\HTTPUtils;
use zion\orm\ObjectVO;

/**
 * Classe gerada pelo Zion Framework em 13/02/2019
 */
class UserController extends StandardUserController {
    public function __construct(){
        parent::__construct(get_class($this),array(
            "table" => "zion_core_user"
        ));
    }
    
    public function actionCollectHistdata(){
        try {
            $db = System::getConnection();
            $dao = System::getDAO();
            $dao1 = System::getDAO($db,"zion_histdata_value");
            
            // tamanho do banco de dados
            $sql = "SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS megabytes
                      FROM information_schema.tables";
            $obj = $dao->queryAndFetchObject($db, $sql);
            $size = $obj->get("megabytes");
            
            $obj1 = new ObjectVO();
            $obj1->set("mandt",0);
            $obj1->set("name","db-size");
            $obj1->set("date",new DateTime());
            $obj1->set("value",$size);
            $dao1->insert($db,$obj1);
            
            // qtde de conexões
            $sql = "show status like 'Connections'";
            $obj = $dao->queryAndFetchObject($db, $sql);
            $value = $obj->get("Value");
            
            $obj1 = new ObjectVO();
            $obj1->set("mandt",0);
            $obj1->set("name","db-conn");
            $obj1->set("date",new DateTime());
            $obj1->set("value",$value);
            $dao1->insert($db,$obj1);
            
            // disco do servidor
            $value = disk_free_space("/") / 1024 / 1024;
            
            $obj1 = new ObjectVO();
            $obj1->set("mandt",0);
            $obj1->set("name","server-disk");
            $obj1->set("date",new DateTime());
            $obj1->set("value",$value);
            $dao1->insert($db,$obj1);
            
            // errors do servidor
            $sql = "SELECT COUNT(*) AS Value FROM zion_error_log";
            $obj = $dao->queryAndFetchObject($db, $sql);
            $value = $obj->get("Value");
            
            $obj1 = new ObjectVO();
            $obj1->set("mandt",0);
            $obj1->set("name","server-error");
            $obj1->set("date",new DateTime());
            $obj1->set("value",$value);
            $dao1->insert($db,$obj1);
            
            HTTPUtils::status(200);
        }catch(Exception $e){
            HTTPUtils::status(500);
            echo $e->getMessage();
        }
    }
    
    public function beforeSendToForm(ObjectVO &$obj){
        if($_SERVER["REQUEST_METHOD"] == "GET"){
            $obj->set("password","");
        }
        
        $values = array(
            "A" => "Ativo",
            "I" => "Inativo",
            "B" => "Bloqueado"
        );
        System::set2("valueList","status",$values);
    }
    
    public function getFormBean() : ObjectVO {
        $obj = parent::getFormBean();
        
        // não apagando a senha
        if($obj->get("password") == ""){
            $obj->unset("password");
        }
        
        // se a senha for informada, gera o hash
        if($obj->get("password") != ""){
            $passwordEnc = md5(\zion\HASH_PASSWORD_PREFIX.$obj->get("password"));
            $obj->set("password",$passwordEnc);
        }
        
        return $obj;
    }
    
    public function actionChangePassword(){
        try {
            // input
            $mandt = intval(Session::get("mandt"));
            $user = Session::get("user");
            
            $password1 = preg_replace("[^0-9a-zA-Z\_\-]","",$_POST["password1"]);
            $password2 = preg_replace("[^0-9a-zA-Z\_\-]","",$_POST["password2"]);
            $password3 = preg_replace("[^0-9a-zA-Z\_\-]","",$_POST["password3"]);
            
            // process
            if($password1 == ""){
                throw new Exception("A senha atual esta em branco");
            }
            
            if($password2 == ""){
                throw new Exception("A senha nova esta em branco");
            }
            
            if($password3 == ""){
                throw new Exception("A senha de confirmação esta em branco");
            }
            
            if($password2 != $password3){
                throw new Exception("As senhas são diferentes");
            }
            
            $password1Enc = md5(\zion\HASH_PASSWORD_PREFIX.$password1);
            $password2Enc = md5(\zion\HASH_PASSWORD_PREFIX.$password2);
            
            $db = System::getConnection();
            $dao = System::getDAO($db,"zion_core_user");
            $keys = array(
                "mandt" => $mandt,
                "userid" => $user->userid
            );
            $objDB = $dao->getObject($db, $keys);
            
            if($objDB == null){
                throw new Exception("Erro na alteração da senha");
            }
            
            if($objDB->get("password") != $password1Enc){
                throw new Exception("A senha atual não coincide");
            }
            
            $obj = new ObjectVO();
            $obj->set("mandt",$mandt);
            $obj->set("userid",$user->userid);
            $obj->set("password",$password2Enc);
            $dao->update($db,$obj);
            
            // output
            HTTPUtils::status(204);
        }catch(Exception $e){
            HTTPUtils::status(500);
            echo $e->getMessage();
        }
    }
    
    public function actionMyData(){
        // input
        
        // process
        
        // output
        Page::setTitle("Meus Dados");
        Page::sendCacheControl();
        $this->view("mydata");
    }
    
    public function actionHome(){
        try {
            // input
            
            // process
            $moduleList = array();
            $dataChart = array();
            
            $db = System::getConnection();
            $dao = System::getDAO();
            
            $dao1 = System::getDAO($db,"zion_core_module");
            $moduleList = $dao1->getArray($db);
            
            $sql = "SELECT mandt, name, title, value_label
                      FROM `zion_histdata_object`";
            $objList = $dao->queryAndFetch($db,$sql);
            
            foreach($objList AS $obj){
                $sql = "SELECT DATE(`date`) AS `date`, MAX(`value`) AS `value`
                          FROM `zion_histdata_value` AS v
                         WHERE v.`mandt` = ".$obj->get("mandt")."
                           AND v.`name` = '".$obj->get("name")."'
                      GROUP BY DATE(`date`)
                      ORDER BY DATE(`date`) DESC
                         LIMIT 7";
                $dataChart[] = array(
                    "title" => $obj->get("title"),
                    "label" => $obj->get("value_label"),
                    "data"  => $dao->queryAndFetch($db,$sql)
                );
            }
            
            System::set("moduleList",$moduleList);
            System::set("dataChart",$dataChart);
            
            // output
            Page::js("/zion/lib/Chart.js/Chart.min.js");
            
            Page::setTitle("Inicio");
            Page::sendCacheControl();
            $this->view("home");
        }catch(Exception $e){
            HTTPUtils::status(500);
            echo $e->getMessage();
        }
    }
    
    public function actionRenewSession(){
        Session::renew();
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
    
    public function actionLogout(){
        Session::set("user",null);
        Session::destroy();
        header("Location: /zion/mod/core/User/loginForm");
    }
    
    public function actionLogin(){
        // input
        $mandt    = intval(preg_replace("[^0-9]","",$_POST["mandt"]));
        $user     = preg_replace("[^0-9a-zA-Z\_]","",$_POST["user-login"]);
        $password = preg_replace("[^0-9a-zA-Z\_\-]","",$_POST["user-password"]);
        
        // process
        try {
            $passwordEnc = md5(\zion\HASH_PASSWORD_PREFIX.$password);
            
            $db = System::getConnection();
            $dao = System::getDAO($db,"zion_core_user");
            
            $keys = array(
                "mandt" => 0,
                "login" => $user
            );
            $userObj = $dao->getObject($db, $keys);
            if($userObj == null){
                throw new Exception("Usuário ou senha inválidos [1]");
            }
            if($userObj->get("password") != $passwordEnc){
                throw new Exception("Usuário ou senha inválidos [2]");
            }
            
            // criando sessão
            $obj = new stdClass();
            $obj->mandt  = $mandt;
            $obj->userid = $userObj->get("userid");
            $obj->login  = $userObj->get("login");
            $obj->perfil = $userObj->get("perfil");
            $obj->name   = $userObj->get("name");
            $obj->email  = $userObj->get("email");
            $obj->status = $userObj->get("status");
            
            if($obj->status == "I"){
                throw new Exception("O usuário esta inativo");
            }
            
            if($obj->status == "B"){
                throw new Exception("O usuário esta bloqueado");
            }
            
            if($obj->status != "A"){
                throw new Exception("O usuário não esta ativo");
            }
            
            Session::set("mandt", $mandt);
            Session::set("user", $obj);
            
            echo "OK";
        }catch(Exception $e){
            header('HTTP/1.0 403 Forbidden');
            echo $e->getMessage();
        }
    }
    
    public function actionLoginForm(){
        // input
        
        // process
        $user = Session::get("user");
        if($user != null){
            header("Location: /zion/mod/core/User/home");
            return;
        }
        
        // view
        Page::setTitle("Zion - Login");
        Page::sendCacheControl();
        $this->view("loginform",false);
    }
    
    public function actionCreateAdminUser(){
        try {
            // input
            
            // process
            $errorMessage = "";
            $password = "";
            
            $db = System::getConnection();
            $dao = System::getDAO($db,"zion_core_user");
            
            $keys = array(
                "mandt" => 0,
                "login" => "admin"
            );
            $obj = $dao->getObject($db, $keys);
            if($obj != null){
                $errorMessage = "O usuário admin já existe! Delete do banco de dados e atualize esta página para recriar";
            }else{
                // gerando senha aleatória
                $password    = date("YmdHis").rand(1000,9999);
                $passwordEnc = md5(\zion\HASH_PASSWORD_PREFIX.$password);
                
                $obj = new ObjectVO();
                $obj->set("mandt",0);
                $obj->set("userid",$dao->getNextId($db, "User-userid"));
                $obj->set("login","admin");
                $obj->set("password",$passwordEnc);
                $obj->set("perfil","admin");
                $obj->set("force_new_password",1);
                $obj->set("name","Admin");
                $obj->set("email","admin@localhost");
                $obj->set("perfil","admin");
                $obj->set("status","A");
                $dao->insert($db, $obj);
                $obj = null;
            }
            
            // output
            System::set("errorMessage",$errorMessage);
            System::set("password",$password);
            
            Page::setTitle("Zion - Dados Administrativos");
            Page::sendCacheControl();
            $this->view("admin-data",false);
        }catch(Exception $e){
            HTTPUtils::status(500);
            echo $e->getMessage();
            exit();
        }
    }
}
?>