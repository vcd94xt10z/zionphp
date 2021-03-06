<?php
/*
 * Zion PHP - Framework
 * Autor Vinicius Cesar Dias
 * 
 * Instruções
 * 1) Incluir esse arquivo no projeto que utilizará o framework
 * 2) Linkar o diretório desse projeto no projeto que utilizará 
 * o framework para que a IDE reconheça as classes
 */
define("zion\ROOT",dirname(__FILE__)."/");
define("zion\APP_ROOT",dirname($_SERVER["DOCUMENT_ROOT"])."/");
define("DS",DIRECTORY_SEPARATOR);

// detectando ambiente
$env = "PRD";
if(strpos($_SERVER["SERVER_NAME"],".des") !== false OR
   strpos($_SERVER["SERVER_NAME"],".dev") !== false OR
   strpos($_SERVER["SERVER_NAME"],"des.") !== false OR
   strpos($_SERVER["SERVER_NAME"],"dev.") !== false){
   $env = "DEV";
}else if(strpos($_SERVER["SERVER_NAME"],".qas") !== false || strpos($_SERVER["SERVER_NAME"],"qas.") !== false){
   $env = "QAS";
}
define("zion\ENV",$env);

/*
 * Exibição de erros
 * No ambiente de produção não é interessante exibir erros na tela pois
 * usuários mal intencionados podem usar as informações para explorar
 * vunerabilidades no sistema. Todos os erros relevantes devem ir para o
 * log para que sejam analisados posteriormente e corrigidos
 */ 
error_reporting(E_ALL ^ E_NOTICE);
if(\zion\ENV == "PRD"){
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}else{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

// bibliotecas via composer
// Vinicius 27/10/2020 - Comentando o autoload do composer para não dar conflito o composer do projeto
// que esta incluindo o zion. O projeto fica responsável por baixar os arquivos necessários
/*
$file = \zion\ROOT."vendor/autoload.php";
if(!file_exists($file)){
    http_response_code(500);
    echo "Os arquivos do composer não foram encontrados, verifique se esta instalado e tente novamente";
    exit();
}
require_once($file);
*/

// funções
require(\zion\ROOT."functions.php");

// configuração do arquivo
$config = zion_get_config_all();

// registrando autoload do sistema
spl_autoload_register("zionphp_autoload");

// registrando autoload do usuário
$config["app"]["autoloads"] = is_array($config["app"]["autoloads"])?$config["app"]["autoloads"]:[];
foreach($config["app"]["autoloads"] AS $autoloadFunc){
    if(function_exists($autoloadFunc)){
        spl_autoload_register($autoloadFunc);
    }
}

// a partir desse ponto, a utilização de classes é permitida pois os requisitos básicos
// para carregar classes foi carregado como o autoload

// gerando um id de sessão exclusivo para o zion, 
// para não misturar o com id de sessão da aplicação
if(strpos($_SERVER["REQUEST_URI"],"/zion/") === 0) {
    \zion\core\Session::$sessionKey = "ZION_SESSIONID";
}

// inicialização
\zion\core\System::configure();

// iniciando a Sessão para forçar a criação do cookie e evitar possíveis problemas
\zion\core\Session::init();

// definindo mandante
$info = \zion\core\System::getDomainInfo();
define("MANDT",$info["mandt"]);

// modulos
\zion\core\Zion::route();
?>
