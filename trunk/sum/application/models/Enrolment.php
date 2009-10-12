<?php
class Default_Model_Enrolment extends Default_Model_Abstract {
	
	protected $_id;
	protected $_userId;
	protected $_courseId;
	protected $_enrolmentDate;
	protected $_finishDate = null;
	
	protected $_course = null;
	protected $_user = null;
	protected $_numberLessons = null;
	
	protected $_mapperClass = 'Default_Model_Mapper_Enrolment';
	
    public function setId($id) {
        $this->_id = (int) $id;
        return $this;
    }
    
    public function getId() {
    	return $this->_id;
    }
	
	public function setUserId($text)
    {
        $this->_userId = (int) $text;
        return $this;
    }

    public function getUserId()
    {
        return $this->_userId;
    }
    
    public function setCourseId($text)
    {
        $this->_courseId = (int) $text;
        return $this;
    }

    public function getCourseId()
    {
        return $this->_courseId;
    }
    
    public function setEnrolmentDate(Zend_Date $date)
    {
        $this->_enrolmentDate = $date;
        return $this;
    }

    public function getEnrolmentDate()
    {
        return $this->_enrolmentDate;
    }
    
    public function setFinishDate(Zend_Date $date)
    {
        $this->_finishDate = $date;
        return $this;
    }

    public function getFinishDate()
    {
        return $this->_finishDate;
    }
    
    
	function getCourse()
	{
		if(null === $this->_course) {
//			$course = new Default_Model_Course();
//			$this->_course = $course->find($this->_courseid);
			$this->_course = $this->getMapper()->getCourse($this);
		}
		
		return $this->_course;
	}
	
	function setCourse(Default_Model_Course $course)
	{
		$this->_course = $course;
		return $this;
	}
	
	function getNumberLessons() {
		if(null === $this->_numberLessons) {
			$this->_numberLessons = $this->getMapper()->getNumberLessons($this);
		}	
		return $this->_numberLessons;
	}
	
	function setNumberLessons($numberLessons) {
		$this->_numberLessons = (int) $numberLessons;
		return $this;
	}
	
	function getUser() {
		if(null === $this->_user) {
			$this->_user = $this->getMapper()->getUser($this);
		}
		return $this->_user;
	}
	
	
}