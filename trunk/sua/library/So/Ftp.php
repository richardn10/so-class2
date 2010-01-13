<?php

class So_Ftp 
{
	private $_host;
	private $_port;
	private $_username;
	private $_password;
	
	private $_path;
	
	private $_connection;
	
	private $_connected = false;

	protected $_targeturl;
	
	public function setTargeturl($url) {
		$this->_targeturl = $url;
	}
	
	public function getTargeturl() {
		return $this->_targeturl;
	}
	
	
	public function __construct($params) {
		$this->_host = $params['host'];
		$this->_port = $params['port'];
		$this->_username = $params['username'];
		$this->_password = $params['password'];
		
		$this->_path = $params['path'];
	}
	
	
	public function connect() {
		if(false === $this->_connection = ftp_connect($this->_host, $this->_port)) throw new Exception("FTP couldn't connect") ;
		if(false === ftp_login($this->_connection, $this->_username, $this->_password)) throw new Exception("FTP login details wrong") ;
		
	}
	
	public function close() {
		ftp_close($this->_connection);
	}

	public function upload($sourceDir, $filename) {
		if(!$this->_connected) $this->connect();
		
		ftp_chdir($this->_connection, $this->_path);
		ftp_pasv($this->_connection, true);
		ftp_put($this->_connection, $filename, $sourceDir.'/'.$filename, FTP_BINARY);
	}
}