<?php
namespace zion\net;

use Exception;

/**
 * SSH
 * Classe teste para realizar conexões via SSH
 */
class SSH {
	private $host;
	private $port;
	private $user;
	private $password;
	private $connection;
	private $SFTPConnection;
	
	public function __construct($host="",$user="",$password="",$port=22){	
		$this->setHost($host);
		$this->setUser($user);
		$this->setPassword($password);
		$this->setPort($port);
	}
	
	public function setHost($host){
		$this->host = $host;
	}
	
	public function getHost(){
		return $this->host;
	}
	
	public function setPort($port){
		$this->port = $port;
	}
	
	public function getPort(){
		return $this->port;
	}
	
	public function setUser($user){
		$this->user = $user;
	}
	
	public function getUser(){
		return $this->user;
	}
	
	public function setPassword($password){
		$this->password = $password;
	}
	
	public function getPassword(){
		return $this->password;
	}
	
	public function getConnection(){
		return $this->connection;
	}
	
	public function getSFTPConnection(){
		if($this->getConnection() == null){
			throw new Exception('Conexão SSH inválida.');
		}
		if($this->SFTPConnection != null){
			return $this->SFTPConnection;
		}
		if (!$this->SFTPConnection = ssh2_sftp($this->getConnection())) {
		    throw new Exception("Falha em criar conexão SSH/SFTP.");
		}
		return $this->SFTPConnection;
	}
	
	public function listSFTPFiles($remoteDir){
		$sftp = $this->getSFTPConnection();
		
		if($remoteDir==""){
			$remoteDir = "/";
		}
		
		/**
		  * Now that we have our SFTP resource, we can open a directory resource
		  * to get us a list of files. Here we will use the $sftp resource in
		  * our address string as I previously mentioned since our ssh2:// 
		  * protocol allows it.
		  */
		$files = array();
		$dirHandle = opendir("ssh2.sftp://$sftp".$remoteDir);
		
		while (false !== ($file = readdir($dirHandle))) {
		    if ($file != '.' && $file != '..') {
		        $files[] = $file;
		    }
		}
		return $files;
	}
	
	public function connect(){
		if($this->getHost() == ""){
			throw new Exception("Host inválido");
		}
		if($this->getUser() == ""){
			throw new Exception("Usuário inválido");
		}
		if($this->getPassword() == ""){
			throw new Exception("Senha inválida");
		}
		
		if(!function_exists("ssh2_connect")){
			throw new Exception("Função ssh2_connect indisponível");
		}
		if(!function_exists("ssh2_auth_password")){
			throw new Exception("Função ssh2_auth_password indisponível");
		}
		
		$this->connection = @ssh2_connect($this->getHost(), $this->getPort());
		if($this->connection===false){
			throw new Exception("Erro em estabelecer conexão com o host ".$this->getHost().":".$this->getPort());
		}
		if(@ssh2_auth_password($this->connection, $this->getUser(), $this->getPassword())==false){
			throw new Exception("Dados de conexão estão incorretos. Verifique o usuário e senha e tente novamente.");
		}
	}
	
	public function getIdent(){
		return $this->getUser().'@'.$this->getHost().':~#'; 
	}
	
	public function send($command){
		$command = trim($command);
		if($command  == ""){
			throw new Exception("Comando inválido");
		}
		if($this->connection == null || $this->connection === false){
			throw new Exception("Conexão inválida");
		}
		
		$stream = ssh2_exec($this->connection, $command);
		stream_set_blocking($stream, true);
		$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
		$result = stream_get_contents($stream_out);
		fclose( $stream );
		return $result;
	}
	
	public function rawExec($command){
	    $stream = ssh2_exec( $this->connection, $command );
	    $error_stream = ssh2_fetch_stream( $stream, SSH2_STREAM_STDERR );
	    stream_set_blocking( $stream, TRUE );
	    stream_set_blocking( $error_stream, TRUE );
	    $output = stream_get_contents( $stream );
	    $error_output = stream_get_contents( $error_stream );
	    fclose( $stream );
	    fclose( $error_stream );
	    return array( $output, $error_output );
	}
	
	public function disconnect(){
		//$this->send("exit");
		//$this->connection = null;
	}
}
?>