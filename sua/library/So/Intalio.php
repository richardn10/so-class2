<?php

class So_Intalio
{
	private $_endpoint;
	private $_key;
	private $_keyTimeout;
	
	const INCOMING_STRING = "INTALIOTOSUA";
	const OUTGOING_STRING = "SUATOINTALIO";
	
	public function __construct($key, $endpoint, $keyTimeout = 900) {
		$this->_key = $key;
		$this->_endpoint = $endpoint;
		$this->_keyTimeout = $keyTimeout;
	}

	public function validateIncomingToken($token, $attachmentId, $timestamp) 
	{
		return ($token == $this->getIncomingToken($attachmentId, $timestamp)) 
					&& (abs(time()-$timestamp) < $this->_keyTimeout);
	}
	
	public function getIncomingToken($attachmentId, $timestamp) {
		return hash('sha256', $this->_key . $attachmentId . $timestamp . self::INCOMING_STRING);
	}
	
	private function getOutgoingToken($attachmentId, $timestamp) {
		return hash('sha256', $this->_key . $attachmentId . $timestamp . OUTGOING_STRING);
	}
	
	public function sendUploadConfirmation($attachmentId, $fileType, $fileService, $fileId) {
		$timestamp = time();
		$token = $this->getOutgoingToken($attachmentId, $timestamp);
	}
	
	public function getRandomString(
			$length = 8, 
//			$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789' // Do not use this on Windows!
			$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'
		) {
		$string = "";
		for($i = 0; $i < $length; ++$i) {
			$string .= $characters[rand(0,strlen($characters)-1)];
		}
		return $string;
	}
}
