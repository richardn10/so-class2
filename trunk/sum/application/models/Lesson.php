<?php


class Default_Model_Lesson extends Default_Model_Abstract {
	protected $_id;
	protected $_enrolmentId;
	protected $_cost;
	protected $_date;
	protected $_duration;
	protected $_debitTransactionId;
	protected $_creditTransactionId;
	
	protected $_debitTransaction;
	protected $_creditTransaction;
	
	protected $_mapperClass = 'Default_Model_Mapper_Lesson';
	
    public function setId($id) {
        $this->_id = (int) $id;
        return $this;
    }
    
    public function getId() {
    	return $this->_id;
    }
    
    public function setEnrolmentId($id) {
        $this->_enrolmentId = (int) $id;
        return $this;
    }
    
    public function getEnrolmentId() {
    	return $this->_enrolmentId;
    }
    
    public function setCost($cost) {
        $this->_cost = (int) $cost;
        return $this;
    }
    
    public function getCost() {
    	return $this->_cost;
    }
    
    public function setDate(Zend_Date $date) {
        $this->_date = $date;
        return $this;
    }
    
    public function getDate() {
    	return $this->_date;
    }
    
    public function setDuration($duration) {
        $this->_duration = (int) $duration;
        return $this;
    }
    
    public function getDuration() {
    	return $this->_duration;
    }
    
    public function setDebitTransactionId($id) {
    	$this->_debitTransactionId = (int) $id;
        return $this;
    }
	
    public function getDebitTransactionId() {
    	return $this->_debitTransactionId;
    }
    
    public function setCreditTransactionId($id) {
    	$this->_creditTransactionId = (int) $id;
        return $this;
    }
	
    public function getCreditTransactionId() {
    	return $this->_creditTransactionId;
    }
	
}