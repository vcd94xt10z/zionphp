<?php
namespace zion\mod\sslgen\controller;

use zion\utils\SSL;
use zion\core\Page;
use zion\core\AbstractController;
use zion\orm\ObjectVO;

/**
 * @author Vinicius Cesar Dias
 * @since 11/05/2019
 */
class SSLGenController extends AbstractController {
    public function __construct(){
        parent::__construct(get_class($this));
    }
    
    public function actionExec(){
        // input
        $obj = new ObjectVO($_POST);
        
        // process
        $data = SSL::gen($obj);
        
        // output
        header("Content-Type: application/json");
        echo json_encode($data);
    }
    
    public function actionHome(){
        Page::setTitle("Gerador de Certificados");
        $this->view("home");
    }
}
?>