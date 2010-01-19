<?php

class So_Fileprocessor_Action_Ftp extends So_Fileprocessor_Action {
	
	protected function _doAction($work) {
		
		if(false === $connection = ftp_connect($this->_options['host'], $this->_options['port'])) 
			throw new Exception("FTP couldn't connect");
		
		if(!ftp_login($connection, $this->_options['username'], $this->_options['password'])) 
			throw new Exception("FTP login details wrong") ;

		if(!ftp_chdir($connection, $this->_options['target_path'])) 
			throw new Exception("FTP target directory does not exist") ;
		
		if(!ftp_pasv($connection, true))
			throw new Exception("FTP Passive mode not supported");
			
		if(!ftp_put($connection, $work->file_name, $this->_options['source_path'].'/'.$work->file_name, FTP_BINARY))
			throw new Exception("FTP Upload failed");
		else $this->_success = true;
		
		$this->_resultUrl = $this->_options['result_url'].$work->file_name;
	}
}