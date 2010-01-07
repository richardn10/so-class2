<?php
require_once 'So/Youtube.php';

class So_Resource_Youtube extends Zend_Application_Resource_ResourceAbstract {
	
	private $_httpClientParams;
	
	private $_devKey;
	private $_appId;
	private $_clientId;
	
	public function setHttpClient($httpClientParams) {
		$this->_httpClientParams = $httpClientParams;
	}
	
	public function setDeveloperKey($devKey) {
		$this->_devKey = $devKey;
	}
	
	public function setApplicationId($appId) {
		$this->_appId = $appId;
	}
	
	public function setClientId($clientId) {
		$this->_clientId = $clientId;	
	}
	
	public function init() {
		return new So_Youtube(
			$this->_httpClientParams, 
			$this->_devKey, 
			$this->_appId, 
			$this->_clientId
		);
	}
}