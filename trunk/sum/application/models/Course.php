<?php

class Default_Model_Course extends Default_Model_Abstract {
	protected $_id;
	protected $_name;
	protected $_numberOfLessons;
	protected $_lessonPrice;
	protected $_lessonLength;
	
	protected $_allEnrolments;
	protected $_activeEnrolments;
	protected $_notActiveEnrolments;
	
	protected $_mapperClass = 'Default_Model_CourseMapper';

    public function setId($id) {
        $this->_id = (int) $id;
        return $this;
    }
    
    public function getId() {
    	return $this->_id;
    }
	
	public function setName($text)
    {
        $this->_name = (string) $text;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }
    
	public function setNumberOfLessons($num)
    {
        $this->_numberOfLessons = (int) $num;
        return $this;
    }

    public function getNumberOfLessons()
    {
        return $this->_numberOfLessons;
    }
    
	public function setLessonPrice($num)
    {
        $this->_lessonPrice = (int) $num;
        return $this;
    }

    public function getLessonPrice()
    {
        return $this->_lessonPrice;
    }
    
	public function setLessonLength($num)
    {
        $this->_lessonLength = (int) $num;
        return $this;
    }

    public function getLessonLength()
    {
        return $this->_lessonLength;
    }
    
    public function getActiveEnrolments() {
    	if(null === $this->_activeEnrolments) {
			$this->_activeEnrolments = $this->getMapper()->getEnrolments($this, true);
		}
		return $this->_activeEnrolments;
    }
    
    public function getNotActiveEnrolments() {
		if(null === $this->_notActiveEnrolments) {
			$this->_notActiveEnrolments = $this->getMapper()->getEnrolments($this, false);
		}
		return $this->_notActiveEnrolments;
    }
    
    public function getAllEnrolments() {
    			if(null === $this->_allEnrolments) {
			$this->_allEnrolments = $this->getMapper()->getEnrolments($this);
		}
		return $this->_allEnrolments;
    }
}