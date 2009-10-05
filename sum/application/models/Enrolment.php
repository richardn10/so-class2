<?php
class Default_Model_Enrolment extends Default_Model_Abstract {
	
	protected $_id;
	protected $_userid;
	protected $_courseid;
	protected $_enrolmentDate;
	protected $_finishDate = null;
	
	protected $_course = null;
	protected $_user = null;
	
	protected $_mapperClass = 'Default_Model_EnrolmentMapper';
	
    public function setId($id) {
        $this->_id = (int) $id;
        return $this;
    }
    
    public function getId() {
    	return $this->_id;
    }
	
	public function setUserid($text)
    {
        $this->_userid = (int) $text;
        return $this;
    }

    public function getUserid()
    {
        return $this->_userid;
    }
    
    public function setCourseid($text)
    {
        $this->_courseid = (int) $text;
        return $this;
    }

    public function getCourseid()
    {
        return $this->_courseid;
    }
    
    public function setEnrolmentDate($text)
    {
        $this->_enrolmentDate = (string) $text;
        return $this;
    }

    public function getEnrolmentDate()
    {
        return $this->_enrolmentDate;
    }
    
    public function setFinishDate($text)
    {
        $this->_finishDate = (string) $text;
        return $this;
    }

    public function getFinishDate()
    {
        return $this->_finishDate;
    }
    
    
	function getCourse()
	{
		if(null === $this->_course) {
			$course = new Default_Model_Course();
			$this->_course = $course->find($this->_courseid);
		}
		
		return $this->_course;
	}
	
	function setCourse(Default_Model_Course $course)
	{
		$this->_course = $course;
		return $this;
	}
	
	function getUser() {
		if(null === $this->_user) {
			$user = new Default_Model_User();
			$this->_user = $user->find($this->_userid);
		}
		return $this->_user;
	}
	
	
}