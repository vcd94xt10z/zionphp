<?php
namespace zion\security;

use DateTime;
use zion\core\System;
use zion\orm\ObjectVO;
use zion\core\Session;
use zion\orm\Filter;

/**
 * @author Vinicius Cesar Dias
 */
class ACL {
    /**
     * Retorna o objeto de acesso
     */
    public static function getObject(){
        $user = Session::get("user");
        if($user === null){
            return null;
        }
        
        $uri = explode("?",$_SERVER["REQUEST_URI"]);
        $uri = $uri[0];
        
        $userFilter = new Filter();
        $userFilter->eq("method",$_SERVER["REQUEST_METHOD"]);
        $userFilter->eq("object_type","user");
        $userFilter->eq("object_id",$user->user);
        
        $perfilFilter = new Filter();
        $perfilFilter->eq("method",$_SERVER["REQUEST_METHOD"]);
        $perfilFilter->eq("object_type","admin");
        $perfilFilter->eq("object_id",$user->perfil);
        
        $db  = System::getConnection();
        $dao = System::getDAO($db,"zion_core_acl");
        
        $userACLs  = $dao->getArray($db, $userFilter);
        $adminACLs = $dao->getArray($db, $perfilFilter);
        
        foreach($userACLs AS $acl){
            if(strpos($uri,$acl->get("uri")) !== false){
                return $acl;
            }
        }
        
        foreach($adminACLs AS $acl){
            if(strpos($uri,$acl->get("uri")) !== false){
                return $acl;
            }
        }
        
        // se chegou até aqui, nenhuma regra foi encontrada
        // criando uma solicitação para o usuário
        $obj = new ObjectVO();
        $obj->set("uri",$uri);
        $obj->set("method",$_SERVER["REQUEST_METHOD"]);
        $obj->set("object_type","user");
        $obj->set("object_id",$user->user);
        $obj->set("status","SOL");
        $obj->set("created",new DateTime());
        $dao->insert($db,$obj);
        return $obj;
    }
}
?>