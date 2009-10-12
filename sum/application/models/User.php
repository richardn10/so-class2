<?php

class Default_Model_User extends Default_Model_Abstract {
	protected $_id;
	protected $_username;
	protected $_firstname;
	protected $_lastname;
	
	protected $_transactionBalance = null;
	protected $_activeReservations = null;
	
	protected $_mapperClass = 'Default_Model_Mapper_User';

    public function setId($id) {
        $this->_id = (int) $id;
        return $this;
    }
    
    public function getId() {
    	return $this->_id;
    }
	
	public function setUsername($text)
    {
        $this->_username = (string) $text;
        return $this;
    }

    public function getUsername()
    {
        return $this->_username;
    }
    
	public function setFirstname($text)
    {
        $this->_firstname = (string) $text;
        return $this;
    }

    public function getFirstname()
    {
        return $this->_firstname;
    }
    
	public function setLastname($text)
    {
        $this->_lastname = (string) $text;
        return $this;
    }

    public function getLastname()
    {
        return $this->_lastname;
    }
    
    public function getFullName()
    {
    	return $this->_firstname . " " . $this->_lastname;
    }
    
    public function getTransactionBalance()
    {
    	if(null === $this->_transactionBalance) {
    		$this->setTransactionBalance($this->getMapper()->getTransactionBalance($this));
    	}
    	return $this->_transactionBalance;
    }
    
    public function setTransactionBalance($balance)
    {
    	$this->_transactionBalance = (int) $balance;
    	return $this;
    }
    
    public function setActiveReservations(array $reservations) {
    	$this->_activeReservations = $reservations;
    	return $this;
    }
    
    public function getActiveReservations() {
    	if(null === $this->_activeReservations) {
    		$this->setActiveReservations($this->getMapper()->getActiveReservations($this));
    	}
    	return $this->_activeReservations;
    }
    
    public function getTransactionHistory() {
    	return $this->getMapper()->getTransactionHistory($this);
    }
    
    public function fetchNotFinishedEnrolmentCourses() {
    	return $this->getMapper()->fetchEnrolmentCourses($this, false);
    
    }
    
    public function fetchFinishedEnrolmentCourses() {
    	return $this->getMapper()->fetchEnrolmentCourses($this, true);
    }
    
    public function fetchUnEnrolledCourses() {
    	return $this->getMapper()->fetchUnEnrolledCourses($this);
    }
    
    public function fetchEnrolments($courseid) {
    	return $this->getMapper()->fetchEnrolments($this, $courseid);
    }
    
    
    public function save()
    {
    	// username generation procedure
    	if(null === $this->getId()) {
    		$this->setUserName("temp".rand(10000, 99999));
    		$this->getMapper()->save($this);
    		$this->setUserName("a".sprintf("%05d", $this->getId()));
    		$this->save();
    	}
        $this->getMapper()->save($this);
    }
}