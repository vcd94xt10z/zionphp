<?php 
namespace zion\net;

use Exception;

class SFTP {
	private $host;
	private $port;
	private $user;
	private $password;
	private $connection;
	private $sftp;
	
	public function __construct($host="", $user="", $password="", $port=22){
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->port = $port;
	}
	
	/**
	 * Conecta com o servidor
	 */
	public function connect(){
	    if ($this->host == "") {
	        throw new Exception("Host inválido");
	    }
	    
		if ($this->user == "") {
		    throw new Exception("Usuário inválido");
		}
		
		if ($this->password == "") {
		    throw new Exception("Senha inválida");
		}
		
		if (!function_exists("ssh2_connect")) {
		    throw new Exception("Função ssh2_connect indisponível");
		}
		
		if (!function_exists("ssh2_auth_password")) {
		    throw new Exception("Função ssh2_auth_password indisponível");
		}
		
		$this->connection = @ssh2_connect($this->host, $this->port);
		if ($this->connection === false) {
		    throw new Exception("Erro em estabelecer conexão com o host ".$this->host.":".$this->port);
		}
		
		if (@ssh2_auth_password($this->connection, $this->user, $this->password) == false) {
			throw new Exception("Dados de conexão estão incorretos. Verifique o usuário e senha e tente novamente.");
		}
		
		$this->sftp = @ssh2_sftp($this->connection);
		if (!$this->sftp) {
		    throw new Exception("Falha em criar conexão SFTP.");
		}
	}
	
	/**
	 * Cria um novo diretório no servidor
	 */
	private function mkdir($directory){
		$sftp = $this->sftp;
		if (!@mkdir("ssh2.sftp://$sftp$directory")) {
		    throw new Exception("Não foi possível criar o novo diretório '".$directory."' no servidor.");
		}
	}
	
	/**
	 * Utilizado por padrão na criação de diretórios: chama o método padrão de criar diretórios
	 */
	public function createDirectory($directory){
		if (is_array($directory)) {
			foreach ($directory AS $dir) {
				$this->mkdir($dir);
			}
		} else {
			$this->mkdir($directory);
		}
	}
	
	/**
	 * Lista arquivos de um diretorio no servidor
	 */
	public function listDirectory($directory){
		$sftp = $this->sftp;
		if ($directory == "") $directory = "/";
		
		$files = array();
		$dirHandle = opendir("ssh2.sftp://$sftp".$directory);
		
		while (false !== ($file = readdir($dirHandle))) {
			if ($file != '.' && $file != '..') {
				$files[] = $file;
			}
		}
		closedir($dirHandle);
		return $files;
	}
	
	/**
	 * Scaneia diretorio no servidor
	 */
	public function scanFilesystem($remote_file) {
		$sftp = $this->sftp;
		$dir = "ssh2.sftp://$sftp$remote_file";
		$fileList = array();
		
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					$filetype = filetype($dir . $file);
					if ($filetype == "dir") {
						$tmp = $this->scanFilesystem($remote_file . $file . "/");
						foreach ($tmp AS $t) {
							$fileList[] = $file . "/" . $t;
						}
					} else {
						$fileList[] = $file;
					}
				}
				closedir($dh);
			}
		}
		return $fileList;
	}
	
	/**
	 * Insere um arquivo no servidor
	 */
	public function upload($file, $destiny){
		$sftp = $this->sftp;
		$stream = @fopen("ssh2.sftp://$sftp$destiny", 'w');
		if (!$stream) {
		    throw new Exception("Não foi possível abrir o arquivo: $destiny");
		}
		
		$data_to_send = @file_get_contents($file);
		if ($data_to_send === false) {
		    throw new Exception("Não foi possível abrir o arquivo local: $file.");
		}
		if (@fwrite($stream, $data_to_send) === false) {
		    throw new Exception("Não foi possível enviar os dados do arquivo local: $file.");
		}
		@fclose($stream);
	}
	
	/**
	 * Retorna tamanho do arquivo no servidor
	 */
	public function getFileSize($file){
		$sftp = $this->sftp;
		return @filesize("ssh2.sftp://$sftp$file");
	}
	
	/**
	 * Delete um arquivo ou diretorio no servidor
	 */
	public function delete($path){
		$sftp = $this->sftp;
		if (!@ssh2_sftp_unlink($sftp, $path)) {
		    throw new Exception("Não foi possível remover o arquivo do SFTP!");
		}
	}
	
	/**
	 * Altera permissão de diretório ou arquivo no servidor
	 */
	public function setPermission($dir, $chmod=0777){
		$sftp = $this->sftp;
		if (!@ssh2_sftp_chmod($sftp, $dir, $chmod)) {
		    throw new Exception("Não foi possível alterar a permissão do arquivo!");
		}
	}
	
	/**
	 * Baixa um arquivo do servidor
	 */
	public function download($localFile, $remoteFile){
		$sftp = $this->sftp;
		$stream = @fopen("ssh2.sftp://$sftp$remoteFile", "r");
		if (!$stream) {
		    throw new Exception("Não foi possível abrir o arquivo: $remoteFile");
		}
		$contents = @stream_get_contents($stream);
		if (!@file_put_contents($localFile, $contents)) {
		    throw new Exception("Não foi possível realizar o download do arquivo: $localFile.");
		}
		@fclose($stream);
	}
	
	/**
	 * Renomeia um arquivo antigo no diretório apontado no servidor
	 */
	public function rename($oldName, $newName){
		$sftp = $this->sftp;
		if (!@ssh2_sftp_rename($sftp, $oldName, $newName)) {
		    throw new Exception("Não foi possível renomear o arquivo no servidor SFTP.");
		}
	}
	
	/**
	 * Remove um diretório especificado no servidor
	 */
	public function rmdir($directory){
		$sftp = $this->sftp;
		if (!@ssh2_sftp_rmdir($sftp, $directory)) {
		    throw new Exception("Erro em remover diretório do servidor SFTP.");
		}
	}
	
	/**
	 * Muda o ponteiro do diretório para o diretório especificado
	 */
	public function changeDirectory($directory){
		$sftp = $this->sftp;
		if (!@ssh2_sftp_realpath($sftp, $directory)) {
		    throw new Exception("Não foi possível acessar o diretório SFTP requisitado!");
		}
	}
	
	/**
	 * Verifica se existe um diretório
	 */
	public function directoryExists($directory){
		try {
			$this->changeDirectory($directory);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * Verifica se arquivo existe
	 */
	public function fileExists($directory){
		try {
			return ($this->getFilesize($directory) > 0);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * Encerra uma conexão
	 */
	public function disconnect(){
		$this->sftp = null;
		$this->connection = null;
	}
	
	public function __destruct(){
		try {
			$this->disconnect();
		} catch (Exception $e) {
		}
	}
}
?>