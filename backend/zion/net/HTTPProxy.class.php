<?php
namespace zion\net;

use Exception;

/**
 * Classe para encaminhar uma requisição para outro servidor
 * Atenção! Classe em versão alpha, tem várias validações e ajustes a serem feitos
 * 
 * @author Vinicius Cesar Dias
 */
class HTTPProxy {
    /**
     * Para encaminhar a requisição a outro servidor, envie o cabeçalho 
     * x-forward-to: http://localhost:80
     * e chame este método
     */
    public static function handle(){
        if($_SERVER["HTTP_X_FORWARD_TO"] != ""){
            self::forwardRequestsTo($_SERVER["HTTP_X_FORWARD_TO"]);
        }
    }
    
    /**
     * A variável server deve estar no formato http://localhost:80 (sem uri)
     * @param string $server
     * @throws Exception
     */
    private static function forwardRequestsTo(string $server){
        try {
            $url = $server.$_SERVER["REQUEST_URI"];
            $requestBody = file_get_contents("php://input");
            
            $ch = curl_init();
            if ($ch === false) {
                throw new Exception("Não foi possível initializar curl (curl_init)", -2);
            }
            
            // [1/3] Parâmetros
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 30);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            
            // ignora erros de ssl
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            
            // [2/3] Método e dados da requisição
            switch ($_SERVER["REQUEST_METHOD"]) {
            case "POST":
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));
                break;
            case "GET":
                curl_setopt($ch, CURLOPT_POSTFIELDS, null);
                curl_setopt($ch, CURLOPT_POST, false);
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
            case "HEAD":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "HEAD");
                curl_setopt($ch, CURLOPT_NOBODY, true);
                break;
            default:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $_SERVER["REQUEST_METHOD"]);
                if($requestBody != ""){
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                }
                break;
            }
            
            // [3/3] Resposta
            $responseBody = curl_exec($ch);
            
            if ($responseBody === false) {
                $errorCode = intval(curl_errno($ch));
                $errorList = array(
                    1 => "Protocolo desconhecido",
                    3 => "URL incorreta",
                    5 => "Host do proxy não encontrado",
                    6 => "Host não encontrado",
                    7 => "Erro em conectar no host ou proxy",
                    9 => "Acesso negado",
                    22 => "Erro na requisição",
                    26 => "Erro na leitura",
                    27 => "Falta de memória",
                    28 => "Timeout",
                    47 => "Limite de redirecionamento atingido",
                    55 => "Erro de rede no envio de dados",
                    56 => "Erro de rede na leitura de dados",
                );
                $errorMessage = $errorList[$errorCode];
                if (mb_strlen($errorMessage) <= 0) {
                    $errorMessage = "Erro desconhecido em executar curl, verifique se a URL " . $url . " esta acessível";
                }
                
                // concatenando informações adicionais
                $errorMessage = "[" . $errorCode . "][" . $url . "] " . $errorMessage;
                
                throw new Exception($errorMessage, $errorCode);
            }
            $curlInfo = curl_getinfo($ch);
            
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headersRaw = substr($responseBody, 0, $header_size);
            $responseBody = substr($responseBody, $header_size);
            
            curl_close($ch);
            
            // organizando
            $headers = array();
            $level1List = explode("\r\n\r\n",$headersRaw);
            foreach($level1List AS $level1Content){
                $request = array();
                if($level1Content == ""){
                    continue;
                }
                
                $lines = explode("\r\n",$level1Content);
                foreach($lines AS $line){
                    list ($key, $value) = explode(":",$line,2);
                    
                    $request[] = array(
                        "key" => trim($key),
                        "value" => trim($value)
                    );
                }
                
                $headers[] = $request;
            }
            
            // imprimindo resposta
            http_response_code($curlInfo["http_code"]);
            echo $responseBody;
        }catch(Exception $e){
            http_response_code(500);
            echo $e->getMessage();
        }
        
        exit();
    }
}
?>