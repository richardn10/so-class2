<?php

class Default_Model_Transaction extends Default_Model_Abstract {
	protected $_id;
	protected $_userId;
	protected $_amount;
	protected $_date;
	
	protected $_type;
	
	
	protected $_mapperClass = 'Default_Model_Mapper_Transaction';
	
	public function setId($id) {
        $this->_id = (int) $id;
        return $this;
    }
    
    public function getId() {
    	return $this->_id;
    }
    
	public function setUserId($id) {
        $this->_userId = (int) $id;
        return $this;
    }
    
    public function getUserId() {
    	return $this->_userId;
    }
    
	public function setAmount($amount) {
        $this->_amount = (int) $amount;
        return $this;
    }
    
    public function getAmount() {
    	return $this->_amount;
    }
    
    public function setDate(Zend_Date $date) {
    	$this->_date = $date;
        return $this;
    }
    
    public function getDate() {
    	return $this->_date;
    }
    
    public function setType($type) {
    	$this->_type = $type;
        return $this;
    }
    
    public function getType() {
    	return $this->_type;
    }
    
}