<?php

class Default_Model_User extends Default_Model_Abstract {
	protected $_id;
	protected $_username;
	protected $_firstname;
	protected $_lastname;
	
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