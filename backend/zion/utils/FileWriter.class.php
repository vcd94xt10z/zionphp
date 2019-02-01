<?php
namespace zion\utils;

use Exception;

/**
 * FileWriter
 * Classe para gerenciar a gravação de arquivos com buffer e validações que lançam exceções
 * @author Vinicius Cesar Dias
 */
class FileWriter {
	private $file;
	private $handler;
	private $buffer;
	private $bufferSizeBytes = 0;
	private $bufferMaxSizeBytes = 1048576; // 1 mega byte
	
    public function __construct($file,$mode="a+"){
    	$this->file = $file;
    	$this->handler = @fopen($file,$mode);
    	if($this->handler === false){
    		throw new Exception("O arquivo ".$file." não pode ser criado");
    	}
    }
    
    public function setBufferMaxSize($bufferSize){
    	$this->bufferMaxSizeBytes = intval($bufferSize);
    	if($this->bufferMaxSizeBytes < 1024){
    		$this->bufferMaxSizeBytes = 1024;
    	}
    }
    
    public function write($content){
    	$this->buffer .= $content;
    	$this->bufferSizeBytes += mb_strlen($content);
    	
    	// verifique se o tamanho do buffer foi atingido para o flush
    	if($this->bufferSizeBytes > $this->bufferMaxSizeBytes){
    		$this->flush();
    	}
    }
    
    public function flush(){
    	// não há dados no buffer
    	if($this->bufferSizeBytes <= 0){
    		return;
    	}
    	
    	$writed = fwrite($this->handler,$this->buffer);
	    if($writed === false){
	    	throw new Exception("Não foi possível gravar no arquivo ".$this->file);
	    }
	    
	    // limpando buffer
	    $this->bufferSizeBytes = 0;
	    $this->buffer = "";
    }
    
    public function close(){
    	if(is_resource($this->handler)){
    		$this->flush();
	    	fclose($this->handler);
	    	$this->handler = null;
    	}
    }
    
    public function __destruct(){
    	$this->close();
    }
}
?>