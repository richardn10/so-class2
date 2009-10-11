<?php

class Default_Model_User extends Default_Model_Abstract {
	protected $_id;
	protected $_username;
	protected $_firstname;
	protected $_lastname;
	
	protected $_transactionBalance = null;
	
	protected $_mapperClass = 'Default_Model_UserMapper';

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
    
    public function getTransactionHistory() {
    	return $this->getMapper()->getTransactionHistory($this);
    }
    
    public function fetchEnrolmentCourses() {
    	return $this->getMapper()->fetchEnrolmentCourses($this);
    }
    
    public function fetchUnEnrolledCourses() {
    	return $this->getMapper()->fetchUnEnrolledCourses($this);
    }
    
    public function fetchEnrolments($courseid) {
    	return $this->getMapper()->fetchEnrolments($this, $courseid);
    }
}